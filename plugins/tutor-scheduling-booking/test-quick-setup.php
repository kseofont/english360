<?php
/**
 * Quick Test Setup Script
 * 
 * Run this file directly to quickly create test data
 * Usage: Visit: yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-quick-setup.php
 * 
 * WARNING: Remove this file in production!
 */

// Load WordPress
$wp_load_paths = array(
	'../../../wp-load.php',
	'../../../../wp-load.php',
	'../../../../../wp-load.php',
);

$wp_loaded = false;
foreach ( $wp_load_paths as $path ) {
	if ( file_exists( __DIR__ . '/' . $path ) ) {
		require_once( __DIR__ . '/' . $path );
		$wp_loaded = true;
		break;
	}
}

if ( ! $wp_loaded ) {
	die( 'Could not load WordPress. Please check the path.' );
}

if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
	die( 'Access denied. You must be logged in as an administrator.' );
}

// Include necessary classes
require_once( __DIR__ . '/includes/class-database.php' );
require_once( __DIR__ . '/includes/class-availability.php' );
require_once( __DIR__ . '/includes/class-booking.php' );
require_once( __DIR__ . '/includes/class-subscription-tracker.php' );
require_once( __DIR__ . '/includes/class-notifications.php' );

$teacher_email = 'teacher@test.com';
$student_email = 'dmitry.stepanov28@gmail.com';
$admin_email = 'dmitry.stepanov28@gmail.com';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Test Setup - Tutor Scheduling</title>
	<style>
		body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
		h1 { color: #2271b1; }
		h2 { color: #00a32a; margin-top: 30px; }
		p { margin: 10px 0; }
		ul { margin: 10px 0; padding-left: 20px; }
		.success { color: #00a32a; font-weight: bold; }
		.error { color: #d63638; font-weight: bold; }
	</style>
</head>
<body>
	<h1>Creating Test Data...</h1>
<?php

// Create teacher
echo '<p>Creating teacher...</p>';
$teacher = get_user_by( 'email', $teacher_email );
if ( ! $teacher ) {
	$teacher_id = wp_create_user( 'test_teacher_' . time(), 'password123', $teacher_email );
	if ( ! is_wp_error( $teacher_id ) ) {
		$user = new WP_User( $teacher_id );
		$user->set_role( 'tutor_instructor' );
		wp_update_user( array(
			'ID' => $teacher_id,
			'display_name' => 'Test Teacher',
		) );
		echo '<p>✓ Teacher created (ID: ' . $teacher_id . ')</p>';
	} else {
		die( 'Failed to create teacher: ' . $teacher_id->get_error_message() );
	}
} else {
	$teacher_id = $teacher->ID;
	echo '<p>✓ Teacher exists (ID: ' . $teacher_id . ')</p>';
}

// Create student
echo '<p>Creating student...</p>';
$student = get_user_by( 'email', $student_email );
if ( ! $student ) {
	$student_id = wp_create_user( 'test_student_' . time(), 'password123', $student_email );
	if ( ! is_wp_error( $student_id ) ) {
		$user = new WP_User( $student_id );
		$user->set_role( 'subscriber' );
		wp_update_user( array(
			'ID' => $student_id,
			'display_name' => 'Dmitry Stepanov',
		) );
		echo '<p>✓ Student created (ID: ' . $student_id . ')</p>';
	} else {
		die( 'Failed to create student: ' . $student_id->get_error_message() );
	}
} else {
	$student_id = $student->ID;
	echo '<p>✓ Student exists (ID: ' . $student_id . ')</p>';
}

// Create course
echo '<p>Creating course...</p>';
$courses = get_posts( array(
	'post_type' => tutor()->course_post_type,
	'posts_per_page' => 1,
	'title' => 'Test Course - Scheduling & Booking',
) );

if ( empty( $courses ) ) {
	$course_id = wp_insert_post( array(
		'post_title' => 'Test Course - Scheduling & Booking',
		'post_content' => 'This is a test course for scheduling and booking functionality.',
		'post_status' => 'publish',
		'post_type' => tutor()->course_post_type,
		'post_author' => $teacher_id,
	) );
	
	if ( $course_id ) {
		update_post_meta( $course_id, '_tutor_course_price_type', 'paid' );
		echo '<p>✓ Course created (ID: ' . $course_id . ')</p>';
	} else {
		die( 'Failed to create course' );
	}
} else {
	$course_id = $courses[0]->ID;
	echo '<p>✓ Course exists (ID: ' . $course_id . ')</p>';
}

// Create product
echo '<p>Creating WooCommerce product...</p>';
if ( class_exists( 'WooCommerce' ) ) {
	$products = wc_get_products( array(
		'limit' => 1,
		'meta_key' => '_tutor_course_id',
		'meta_value' => $course_id,
	) );
	
	if ( empty( $products ) ) {
		$product = new WC_Product_Simple();
		$product->set_name( 'Test Course Subscription - 10 Lessons' );
		$product->set_regular_price( '99.00' );
		$product->set_status( 'publish' );
		$product_id = $product->save();
		
		if ( $product_id ) {
			update_post_meta( $product_id, '_tutor_product', 'yes' );
			update_post_meta( $product_id, '_tutor_course_id', $course_id );
			update_post_meta( $product_id, '_tutor_total_lessons', 10 );
			echo '<p>✓ Product created (ID: ' . $product_id . ')</p>';
		} else {
			die( 'Failed to create product' );
		}
	} else {
		$product_id = $products[0]->get_id();
		echo '<p>✓ Product exists (ID: ' . $product_id . ')</p>';
	}
} else {
	die( 'WooCommerce is not installed' );
}

// Create order/subscription
echo '<p>Creating order/subscription...</p>';
$subscription_id = null;
$subscription_attempted = false;

// Try to create subscription if WooCommerce Subscriptions is available
if ( function_exists( 'wcs_create_subscription' ) && class_exists( 'WC_Subscriptions' ) ) {
	$subscription_attempted = true;
	try {
		$subscription = wcs_create_subscription( array(
			'order_id' => 0,
			'customer_id' => $student_id,
			'status' => 'active',
		) );
		
		if ( is_wp_error( $subscription ) ) {
			echo '<p class="error">⚠ Subscription creation error: ' . esc_html( $subscription->get_error_message() ) . '</p>';
			echo '<p>Falling back to regular order (this works fine for testing)...</p>';
		} elseif ( ! $subscription ) {
			echo '<p class="error">⚠ Subscription creation returned null</p>';
			echo '<p>Falling back to regular order (this works fine for testing)...</p>';
		} else {
			$product = wc_get_product( $product_id );
			if ( $product ) {
				$subscription->add_product( $product, 1 );
				$subscription->set_billing_period( 'month' );
				$subscription->set_billing_interval( 1 );
				$subscription->set_next_payment_date( date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ) );
				$subscription->set_billing_email( $student_email );
				$subscription->calculate_totals();
				$save_result = $subscription->save();
				
				if ( is_wp_error( $save_result ) ) {
					echo '<p class="error">⚠ Subscription save error: ' . esc_html( $save_result->get_error_message() ) . '</p>';
					echo '<p>Falling back to regular order (this works fine for testing)...</p>';
				} else {
					$subscription_id = $subscription->get_id();
					if ( $subscription_id ) {
						echo '<p class="success">✓ Subscription created (ID: ' . esc_html( $subscription_id ) . ')</p>';
					} else {
						echo '<p class="error">⚠ Subscription ID is empty after save</p>';
						echo '<p>Falling back to regular order (this works fine for testing)...</p>';
					}
				}
			} else {
				echo '<p class="error">⚠ Product not found</p>';
				echo '<p>Falling back to regular order (this works fine for testing)...</p>';
			}
		}
	} catch ( Exception $e ) {
		echo '<p class="error">⚠ Exception creating subscription: ' . esc_html( $e->getMessage() ) . '</p>';
		echo '<p>Falling back to regular order (this works fine for testing)...</p>';
	}
} else {
	echo '<p>ℹ WooCommerce Subscriptions not available. Creating regular order instead (this works fine for testing).</p>';
}

// Fallback to regular order if subscription failed or not available
if ( ! $subscription_id ) {
	try {
		$order = wc_create_order();
		
		if ( is_wp_error( $order ) ) {
			die( '<p class="error">Failed to create order: ' . esc_html( $order->get_error_message() ) . '</p>' );
		}
		
		if ( ! $order ) {
			die( '<p class="error">Failed to create order: wc_create_order() returned null</p>' );
		}
		
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			die( '<p class="error">Product not found (ID: ' . esc_html( $product_id ) . ')</p>' );
		}
		
		$order->add_product( $product, 1 );
		$order->set_customer_id( $student_id );
		$order->set_billing_email( $student_email );
		$order->set_status( 'completed' );
		$order->calculate_totals();
		$order->save();
		$subscription_id = $order->get_id();
		
		if ( $subscription_id ) {
			echo '<p class="success">✓ Order created (ID: ' . esc_html( $subscription_id ) . ')</p>';
			echo '<p><em>Note: Using regular order instead of subscription (this works fine for testing)</em></p>';
		} else {
			die( '<p class="error">Order ID is empty after save</p>' );
		}
	} catch ( Exception $e ) {
		die( '<p class="error">Exception creating order: ' . esc_html( $e->getMessage() ) . '</p>' );
	}
}

// Track subscription
$tracker = new Tutor_Scheduling_Subscription_Tracker();
$total_lessons = get_post_meta( $product_id, '_tutor_total_lessons', true ) ?: 10;
$tracker->track_subscription( $subscription_id, $student_id, $course_id, $total_lessons );
echo '<p>✓ Subscription tracked</p>';

// Set availability
echo '<p>Setting teacher availability...</p>';
$availability = new Tutor_Scheduling_Availability();
for ( $day = 1; $day <= 5; $day++ ) {
	$availability->set_availability( $teacher_id, $day, '09:00:00', '17:00:00', true );
}
$availability->set_availability( $teacher_id, 6, '10:00:00', '14:00:00', true );
echo '<p>✓ Availability set</p>';

// Create bookings
echo '<p>Creating test bookings...</p>';
$booking = new Tutor_Scheduling_Lesson_Booking();
$dates_created = 0;
for ( $i = 1; $i <= 3; $i++ ) {
	$date = date( 'Y-m-d', strtotime( "+{$i} days" ) );
	$day_of_week = date( 'w', strtotime( $date ) );
	
	if ( $day_of_week >= 1 && $day_of_week <= 5 ) {
		$result = $booking->create_booking( array(
			'student_id' => $student_id,
			'teacher_id' => $teacher_id,
			'course_id' => $course_id,
			'booking_date' => $date,
			'booking_time' => '10:00:00',
			'subscription_id' => $subscription_id,
		) );
		
		if ( ! is_wp_error( $result ) && $result ) {
			$dates_created++;
		}
	}
}
echo '<p>✓ Created ' . $dates_created . ' bookings</p>';

// Trigger notifications
echo '<p>Triggering notifications...</p>';
update_option( 'admin_email', $admin_email );

// Set remaining lessons to 2 to trigger notification
global $wpdb;
$table = $wpdb->prefix . 'tutor_subscription_lessons';
$sub = $wpdb->get_row( $wpdb->prepare(
	"SELECT * FROM {$table} WHERE subscription_id = %d AND student_id = %d",
	$subscription_id,
	$student_id
) );

if ( $sub ) {
	$wpdb->update(
		$table,
		array(
			'remaining_lessons' => 2,
			'used_lessons' => $sub->total_lessons - 2,
		),
		array( 'id' => $sub->id ),
		array( '%d', '%d' ),
		array( '%d' )
	);
	
	$notifications = new Tutor_Scheduling_Notifications();
	$notifications->handle_subscription_ending_soon( $subscription_id, $student_id, 2 );
	echo '<p>✓ Notifications sent to: ' . $admin_email . ' and ' . $student_email . '</p>';
}

echo '<h2 class="success">✓ Test Setup Complete!</h2>';
echo '<div style="background: #f0f6fc; padding: 20px; border-radius: 5px; margin: 20px 0;">';
echo '<h3>Login Credentials:</h3>';
echo '<ul>';
echo '<li><strong>Teacher:</strong> ' . esc_html( $teacher_email ) . ' / password123</li>';
echo '<li><strong>Student:</strong> ' . esc_html( $student_email ) . ' / password123</li>';
echo '</ul>';
echo '<h3>Test Data Created:</h3>';
echo '<ul>';
echo '<li>Teacher ID: ' . esc_html( $teacher_id ) . '</li>';
echo '<li>Student ID: ' . esc_html( $student_id ) . '</li>';
echo '<li>Course ID: ' . esc_html( $course_id ) . '</li>';
echo '<li>Product ID: ' . esc_html( $product_id ) . '</li>';
echo '<li>Subscription/Order ID: ' . esc_html( $subscription_id ) . '</li>';
echo '</ul>';
echo '<h3>Next Steps:</h3>';
echo '<ul>';
echo '<li>Check your email: ' . esc_html( $student_email ) . ' for notifications</li>';
echo '<li>Login as student to test bookings</li>';
echo '<li>Login as teacher to test availability</li>';
echo '<li>Go to Tutor Dashboard to see all features</li>';
echo '</ul>';
echo '</div>';
echo '<p><a href="' . admin_url() . '" class="button">Go to WordPress Admin</a></p>';
?>
</body>
</html>

