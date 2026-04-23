<?php
/**
 * Test Setup Class - Creates test data for development
 * 
 * WARNING: This is for testing only. Remove or disable in production.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Test_Setup {
	
	private $teacher_email = 'teacher@test.com';
	private $student_email = 'dmitry.stepanov28@gmail.com';
	private $admin_email = 'dmitry.stepanov28@gmail.com';
	
	/**
	 * Initialize test setup
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_test_menu' ) );
	}
	
	/**
	 * Add test menu
	 */
	public function add_test_menu() {
		// Add directly under Tutor menu for easier access
		add_submenu_page(
			'tutor',
			__( 'Scheduling Test Setup', 'tutor-scheduling' ),
			__( 'Scheduling Test Setup', 'tutor-scheduling' ),
			'manage_options',
			'tutor-scheduling-test',
			array( $this, 'test_setup_page' )
		);
		
		// Also add as submenu of Scheduling page
		add_submenu_page(
			'tutor-scheduling',
			__( 'Test Setup', 'tutor-scheduling' ),
			__( 'Test Setup', 'tutor-scheduling' ),
			'manage_options',
			'tutor-scheduling-test-sub',
			array( $this, 'test_setup_page' )
		);
	}
	
	/**
	 * Test setup page
	 */
	public function test_setup_page() {
		if ( isset( $_POST['create_test_data'] ) && check_admin_referer( 'tutor_test_setup' ) ) {
			$this->create_all_test_data();
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Test data created successfully!', 'tutor-scheduling' ) . '</p></div>';
		}
		
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Test Setup', 'tutor-scheduling' ); ?></h1>
			<p><?php esc_html_e( 'This will create test users, courses, subscriptions, and bookings for testing purposes.', 'tutor-scheduling' ); ?></p>
			
			<form method="post">
				<?php wp_nonce_field( 'tutor_test_setup' ); ?>
				<p>
					<label>
						<input type="checkbox" name="create_users" value="1" checked>
						<?php esc_html_e( 'Create Test Users (Teacher & Student)', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="create_course" value="1" checked>
						<?php esc_html_e( 'Create Test Course', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="create_product" value="1" checked>
						<?php esc_html_e( 'Create WooCommerce Product', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="create_subscription" value="1" checked>
						<?php esc_html_e( 'Create Subscription/Order', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="set_availability" value="1" checked>
						<?php esc_html_e( 'Set Teacher Availability', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="create_bookings" value="1" checked>
						<?php esc_html_e( 'Create Test Bookings', 'tutor-scheduling' ); ?>
					</label>
				</p>
				<p>
					<label>
						<input type="checkbox" name="trigger_notifications" value="1" checked>
						<?php esc_html_e( 'Trigger Test Notifications', 'tutor-scheduling' ); ?>
					</label>
				</p>
				
				<?php submit_button( __( 'Create Test Data', 'tutor-scheduling' ), 'primary', 'create_test_data' ); ?>
			</form>
		</div>
		<?php
	}
	
	/**
	 * Create all test data
	 */
	public function create_all_test_data() {
		$options = array(
			'create_users' => isset( $_POST['create_users'] ),
			'create_course' => isset( $_POST['create_course'] ),
			'create_product' => isset( $_POST['create_product'] ),
			'create_subscription' => isset( $_POST['create_subscription'] ),
			'set_availability' => isset( $_POST['set_availability'] ),
			'create_bookings' => isset( $_POST['create_bookings'] ),
			'trigger_notifications' => isset( $_POST['trigger_notifications'] ),
		);
		
		$teacher_id = null;
		$student_id = null;
		$course_id = null;
		$product_id = null;
		$subscription_id = null;
		
		// Create users
		if ( $options['create_users'] ) {
			$teacher_id = $this->create_teacher();
			$student_id = $this->create_student();
		} else {
			$teacher = get_user_by( 'email', $this->teacher_email );
			$student = get_user_by( 'email', $this->student_email );
			$teacher_id = $teacher ? $teacher->ID : null;
			$student_id = $student ? $student->ID : null;
		}
		
		if ( ! $teacher_id || ! $student_id ) {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Failed to create or find users.', 'tutor-scheduling' ) . '</p></div>';
			return;
		}
		
		// Create course with lessons
		if ( $options['create_course'] ) {
			$course_id = $this->create_course_with_lessons( $teacher_id );
		} else {
			$courses = get_posts( array(
				'post_type' => tutor()->course_post_type,
				'posts_per_page' => 1,
			) );
			$course_id = ! empty( $courses ) ? $courses[0]->ID : null;
		}
		
		if ( ! $course_id ) {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Failed to create or find course.', 'tutor-scheduling' ) . '</p></div>';
			return;
		}
		
		// Create product
		if ( $options['create_product'] && class_exists( 'WooCommerce' ) ) {
			$product_id = $this->create_product( $course_id );
		} else {
			$products = wc_get_products( array( 'limit' => 1 ) );
			$product_id = ! empty( $products ) ? $products[0]->get_id() : null;
		}
		
		// Create subscription/order
		if ( $options['create_subscription'] && class_exists( 'WooCommerce' ) ) {
			// Try subscription first if available
			if ( class_exists( 'WC_Subscriptions' ) && function_exists( 'wcs_create_subscription' ) ) {
				$subscription_id = $this->create_subscription( $student_id, $product_id, $course_id );
				
				if ( $subscription_id ) {
					echo '<div class="notice notice-success"><p>';
					echo sprintf( esc_html__( '✓ Subscription created successfully (ID: %d)', 'tutor-scheduling' ), $subscription_id );
					echo '</p></div>';
				} else {
					echo '<div class="notice notice-info"><p>';
					echo esc_html__( 'ℹ Subscription creation not available or failed. Creating regular order instead (this works fine for testing).', 'tutor-scheduling' );
					echo '</p></div>';
					$subscription_id = $this->create_order( $student_id, $product_id, $course_id );
				}
			} else {
				// No subscriptions plugin, create regular order
				echo '<div class="notice notice-info"><p>';
				echo esc_html__( 'ℹ WooCommerce Subscriptions not available. Creating regular order instead (this works fine for testing).', 'tutor-scheduling' );
				echo '</p></div>';
				$subscription_id = $this->create_order( $student_id, $product_id, $course_id );
			}
			
			if ( ! $subscription_id ) {
				echo '<div class="notice notice-error"><p>';
				echo esc_html__( '❌ Failed to create order/subscription. Please check:', 'tutor-scheduling' );
				echo '<ul style="margin-left: 20px;">';
				echo '<li>' . esc_html__( 'WooCommerce is installed and activated', 'tutor-scheduling' ) . '</li>';
				echo '<li>' . esc_html__( 'WooCommerce is properly configured', 'tutor-scheduling' ) . '</li>';
				echo '<li>' . esc_html__( 'Check WordPress error logs for details', 'tutor-scheduling' ) . '</li>';
				echo '</ul>';
				echo '</p></div>';
			} else {
				echo '<div class="notice notice-success"><p>';
				echo sprintf( esc_html__( '✓ Order/Subscription created successfully (ID: %d)', 'tutor-scheduling' ), $subscription_id );
				echo '</p></div>';
			}
		}
		
		// Set availability
		if ( $options['set_availability'] && $teacher_id ) {
			$this->set_teacher_availability( $teacher_id );
		}
		
		// Create bookings
		$bookings_created = 0;
		if ( $options['create_bookings'] && $teacher_id && $student_id && $course_id ) {
			$bookings_created = $this->create_test_bookings( $teacher_id, $student_id, $course_id, $subscription_id );
		}
		
		// Trigger notifications
		if ( $options['trigger_notifications'] && $subscription_id && $student_id ) {
			$this->trigger_test_notifications( $subscription_id, $student_id );
		}
		
		echo '<div class="notice notice-success"><p>';
		echo sprintf( __( 'Test data created successfully!', 'tutor-scheduling' ) );
		echo '<br>';
		echo sprintf( __( 'Teacher ID: %d, Student ID: %d, Course ID: %d', 'tutor-scheduling' ), 
			$teacher_id, $student_id, $course_id );
		if ( $bookings_created > 0 ) {
			echo '<br>';
			echo sprintf( __( 'Created %d lesson bookings in calendar', 'tutor-scheduling' ), $bookings_created );
		}
		echo '</p></div>';
	}
	
	/**
	 * Create teacher user
	 */
	private function create_teacher() {
		$username = 'test_teacher_' . time();
		$user_id = wp_create_user( $username, 'password123', $this->teacher_email );
		
		if ( ! is_wp_error( $user_id ) ) {
			$user = new WP_User( $user_id );
			$user->set_role( 'tutor_instructor' );
			
			// Update user data
			wp_update_user( array(
				'ID' => $user_id,
				'display_name' => 'Test Teacher',
				'first_name' => 'Test',
				'last_name' => 'Teacher',
			) );
			
			return $user_id;
		}
		
		return null;
	}
	
	/**
	 * Create student user
	 */
	private function create_student() {
		$username = 'test_student_' . time();
		$user_id = wp_create_user( $username, 'password123', $this->student_email );
		
		if ( ! is_wp_error( $user_id ) ) {
			$user = new WP_User( $user_id );
			$user->set_role( 'subscriber' );
			
			// Update user data
			wp_update_user( array(
				'ID' => $user_id,
				'display_name' => 'Dmitry Stepanov',
				'first_name' => 'Dmitry',
				'last_name' => 'Stepanov',
			) );
			
			return $user_id;
		}
		
		return null;
	}
	
	/**
	 * Create test course
	 */
	private function create_course( $teacher_id ) {
		$course_data = array(
			'post_title' => 'Test Course - Scheduling & Booking',
			'post_content' => 'This is a test course for scheduling and booking functionality.',
			'post_status' => 'publish',
			'post_type' => tutor()->course_post_type,
			'post_author' => $teacher_id,
		);
		
		$course_id = wp_insert_post( $course_data );
		
		if ( $course_id ) {
			// Set course meta
			update_post_meta( $course_id, '_tutor_course_price_type', 'paid' );
			update_post_meta( $course_id, '_tutor_is_public_course', 'no' );
			
			return $course_id;
		}
		
		return null;
	}
	
	/**
	 * Create course with lessons (realistic setup)
	 */
	private function create_course_with_lessons( $teacher_id ) {
		// Switch to teacher user context to create course as teacher
		$current_user = get_current_user_id();
		wp_set_current_user( $teacher_id );
		
		$course_data = array(
			'post_title' => 'English Conversation Course',
			'post_content' => 'A comprehensive English conversation course designed to improve your speaking and listening skills through interactive lessons and real-world practice.',
			'post_status' => 'publish',
			'post_type' => tutor()->course_post_type,
			'post_author' => $teacher_id,
		);
		
		$course_id = wp_insert_post( $course_data );
		
		if ( ! $course_id ) {
			wp_set_current_user( $current_user );
			return null;
		}
		
		// Set course meta
		update_post_meta( $course_id, '_tutor_course_price_type', 'paid' );
		update_post_meta( $course_id, '_tutor_is_public_course', 'no' );
		
		// Create topics and lessons
		$topics = array(
			'Introduction to English Conversation' => array(
				'Greetings and Introductions',
				'Small Talk Basics',
				'Asking and Answering Questions',
			),
			'Daily Conversations' => array(
				'Talking About Your Day',
				'Making Plans',
				'Expressing Opinions',
			),
			'Advanced Topics' => array(
				'Business English',
				'Travel Conversations',
				'Cultural Discussions',
			),
		);
		
		$lesson_ids = array();
		$topic_order = 0;
		
		foreach ( $topics as $topic_title => $lessons ) {
			// Create topic
			$topic_data = array(
				'post_title' => $topic_title,
				'post_content' => '',
				'post_type' => tutor()->topics_post_type,
				'post_parent' => $course_id,
				'post_status' => 'publish',
				'menu_order' => $topic_order++,
			);
			
			$topic_id = wp_insert_post( $topic_data );
			
			if ( $topic_id ) {
				$content_order = 0;
				
				// Create lessons in this topic
				foreach ( $lessons as $lesson_title ) {
					$lesson_data = array(
						'post_title' => $lesson_title,
						'post_content' => 'This lesson covers ' . strtolower( $lesson_title ) . '. You will learn practical vocabulary and phrases to use in real conversations.',
						'post_type' => tutor()->lesson_post_type,
						'post_parent' => $topic_id,
						'post_status' => 'publish',
						'post_author' => $teacher_id,
						'menu_order' => $content_order++,
					);
					
					$lesson_id = wp_insert_post( $lesson_data );
					
					if ( $lesson_id ) {
						$lesson_ids[] = $lesson_id;
					}
				}
			}
		}
		
		// Restore original user
		wp_set_current_user( $current_user );
		
		// Store lesson IDs in course meta for later use
		update_post_meta( $course_id, '_tutor_test_lessons', $lesson_ids );
		
		return $course_id;
	}
	
	/**
	 * Create WooCommerce product
	 */
	private function create_product( $course_id ) {
		$product = new WC_Product_Simple();
		$product->set_name( 'Test Course Subscription - 10 Lessons' );
		$product->set_regular_price( '99.00' );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_description( 'Test subscription product with 10 lessons included.' );
		$product->set_short_description( '10 lessons included in this subscription.' );
		
		$product_id = $product->save();
		
		if ( $product_id ) {
			// Link to course
			update_post_meta( $product_id, '_tutor_product', 'yes' );
			update_post_meta( $product_id, '_tutor_course_id', $course_id );
			update_post_meta( $product_id, '_tutor_total_lessons', 10 );
			
			return $product_id;
		}
		
		return null;
	}
	
	/**
	 * Create WooCommerce order
	 */
	private function create_order( $student_id, $product_id, $course_id ) {
		try {
			$order = wc_create_order();
			
			if ( is_wp_error( $order ) ) {
				error_log( 'Order creation error: ' . $order->get_error_message() );
				return null;
			}
			
			if ( ! $order ) {
				error_log( 'Order creation returned null' );
				return null;
			}
			
			$product = wc_get_product( $product_id );
			if ( ! $product ) {
				error_log( 'Product not found for order: ' . $product_id );
				return null;
			}
			
			$order->add_product( $product, 1 );
			$order->set_customer_id( $student_id );
			$order->set_billing_email( $this->student_email );
			$order->set_status( 'completed' );
			$order->calculate_totals();
			$order->save();
			
			$order_id = $order->get_id();
			
			if ( ! $order_id ) {
				error_log( 'Order ID is empty after save' );
				return null;
			}
			
			// Track subscription (using order_id as subscription_id for one-time purchases)
			$tracker = new Tutor_Scheduling_Subscription_Tracker();
			$total_lessons = get_post_meta( $product_id, '_tutor_total_lessons', true ) ?: 10;
			$tracker->track_subscription( $order_id, $student_id, $course_id, $total_lessons );
			
			return $order_id;
			
		} catch ( Exception $e ) {
			error_log( 'Exception creating order: ' . $e->getMessage() );
			return null;
		}
	}
	
	/**
	 * Create WooCommerce subscription
	 */
	private function create_subscription( $student_id, $product_id, $course_id ) {
		// Check if WooCommerce Subscriptions is available
		if ( ! function_exists( 'wcs_create_subscription' ) || ! class_exists( 'WC_Subscriptions' ) ) {
			// Fallback to regular order if subscriptions not available
			return $this->create_order( $student_id, $product_id, $course_id );
		}
		
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			error_log( 'Tutor Scheduling: Product not found: ' . $product_id );
			return $this->create_order( $student_id, $product_id, $course_id );
		}
		
		// For subscriptions, we need to create a subscription product or use existing one
		// For testing, we'll just create a regular order which works fine
		// If you want real subscriptions, convert the product to subscription type first
		
		try {
			// Try to create subscription
			$subscription = wcs_create_subscription( array(
				'order_id' => 0,
				'customer_id' => $student_id,
				'status' => 'active',
			) );
			
			if ( is_wp_error( $subscription ) ) {
				$error_msg = $subscription->get_error_message();
				error_log( 'Tutor Scheduling: Subscription creation error: ' . $error_msg );
				// Fallback to order
				return $this->create_order( $student_id, $product_id, $course_id );
			}
			
			if ( ! $subscription ) {
				error_log( 'Tutor Scheduling: Subscription creation returned null' );
				return $this->create_order( $student_id, $product_id, $course_id );
			}
			
			// Add product to subscription
			$subscription->add_product( $product, 1 );
			$subscription->set_billing_period( 'month' );
			$subscription->set_billing_interval( 1 );
			$subscription->set_next_payment_date( date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ) );
			$subscription->set_billing_email( $this->student_email );
			$subscription->calculate_totals();
			
			$save_result = $subscription->save();
			
			if ( is_wp_error( $save_result ) ) {
				error_log( 'Tutor Scheduling: Subscription save error: ' . $save_result->get_error_message() );
				return $this->create_order( $student_id, $product_id, $course_id );
			}
			
			$subscription_id = $subscription->get_id();
			
			if ( ! $subscription_id || $subscription_id == 0 ) {
				error_log( 'Tutor Scheduling: Subscription ID is empty after save' );
				return $this->create_order( $student_id, $product_id, $course_id );
			}
			
			// Track subscription
			$tracker = new Tutor_Scheduling_Subscription_Tracker();
			$total_lessons = get_post_meta( $product_id, '_tutor_total_lessons', true ) ?: 10;
			$tracker->track_subscription( $subscription_id, $student_id, $course_id, $total_lessons );
			
			return $subscription_id;
			
		} catch ( Exception $e ) {
			error_log( 'Tutor Scheduling: Exception creating subscription: ' . $e->getMessage() );
			// Fallback to regular order
			return $this->create_order( $student_id, $product_id, $course_id );
		}
	}
	
	/**
	 * Set teacher availability
	 */
	private function set_teacher_availability( $teacher_id ) {
		$availability = new Tutor_Scheduling_Availability();
		
		// Set availability for weekdays (Monday-Friday)
		$weekdays = array( 1, 2, 3, 4, 5 ); // Monday to Friday
		
		foreach ( $weekdays as $day ) {
			$availability->set_availability( $teacher_id, $day, '09:00:00', '17:00:00', true );
		}
		
		// Set Saturday (limited hours)
		$availability->set_availability( $teacher_id, 6, '10:00:00', '14:00:00', true );
	}
	
	/**
	 * Create test bookings
	 */
	private function create_test_bookings( $teacher_id, $student_id, $course_id, $subscription_id ) {
		$booking = new Tutor_Scheduling_Lesson_Booking();
		
		// Get lesson IDs from course
		$lesson_ids = get_post_meta( $course_id, '_tutor_test_lessons', true );
		if ( ! $lesson_ids || ! is_array( $lesson_ids ) ) {
			// Fallback: get lessons by parent topic
			$topics = get_posts( array(
				'post_type' => tutor()->topics_post_type,
				'post_parent' => $course_id,
				'posts_per_page' => -1,
			) );
			
			$lesson_ids = array();
			foreach ( $topics as $topic ) {
				$topic_lessons = get_posts( array(
					'post_type' => tutor()->lesson_post_type,
					'post_parent' => $topic->ID,
					'posts_per_page' => -1,
				) );
				foreach ( $topic_lessons as $lesson ) {
					$lesson_ids[] = $lesson->ID;
				}
			}
		}
		
		if ( empty( $lesson_ids ) ) {
			// No lessons found, create bookings without lesson association
			$lesson_ids = array( null );
		}
		
		// Create bookings for next 2 weeks, associating with lessons
		$dates = array();
		$start_date = date( 'Y-m-d', strtotime( '+1 day' ) );
		$lesson_index = 0;
		
		for ( $i = 0; $i < 14; $i++ ) {
			$date = date( 'Y-m-d', strtotime( $start_date . " +{$i} days" ) );
			$day_of_week = date( 'w', strtotime( $date ) );
			
			// Skip weekends (0 = Sunday, 6 = Saturday)
			if ( $day_of_week == 0 || $day_of_week == 6 ) {
				continue;
			}
			
			// Get lesson for this booking
			$lesson_id = isset( $lesson_ids[ $lesson_index % count( $lesson_ids ) ] ) ? $lesson_ids[ $lesson_index % count( $lesson_ids ) ] : null;
			
			// Add morning slot
			$dates[] = array(
				'date' => $date,
				'time' => '10:00',
				'lesson_id' => $lesson_id,
			);
			$lesson_index++;
			
			// Add afternoon slot every other day
			if ( $i % 2 == 0 ) {
				$lesson_id = isset( $lesson_ids[ $lesson_index % count( $lesson_ids ) ] ) ? $lesson_ids[ $lesson_index % count( $lesson_ids ) ] : null;
				$dates[] = array(
					'date' => $date,
					'time' => '14:00',
					'lesson_id' => $lesson_id,
				);
				$lesson_index++;
			}
		}
		
		$created_count = 0;
		foreach ( $dates as $slot ) {
			$booking_data = array(
				'student_id' => $student_id,
				'teacher_id' => $teacher_id,
				'course_id' => $course_id,
				'booking_date' => $slot['date'],
				'booking_time' => $slot['time'],
				'subscription_id' => $subscription_id,
			);
			
			if ( ! empty( $slot['lesson_id'] ) ) {
				$booking_data['lesson_id'] = $slot['lesson_id'];
			}
			
			$result = $booking->create_booking( $booking_data );
			if ( $result && ! is_wp_error( $result ) ) {
				$created_count++;
			}
		}
		
		return $created_count;
	}
	
	/**
	 * Trigger test notifications
	 */
	private function trigger_test_notifications( $subscription_id, $student_id ) {
		$tracker = new Tutor_Scheduling_Subscription_Tracker();
		$subscriptions = $tracker->get_subscription_tracking( $subscription_id, $student_id );
		
		if ( ! empty( $subscriptions ) ) {
			$subscription = $subscriptions[0];
			
			// Manually set remaining lessons to 2 to trigger notification
			global $wpdb;
			$table = $wpdb->prefix . 'tutor_subscription_lessons';
			$wpdb->update(
				$table,
				array(
					'remaining_lessons' => 2,
					'used_lessons' => $subscription->total_lessons - 2,
				),
				array( 'id' => $subscription->id ),
				array( '%d', '%d' ),
				array( '%d' )
			);
			
			// Trigger notification
			$notifications = new Tutor_Scheduling_Notifications();
			$notifications->handle_subscription_ending_soon( $subscription_id, $student_id, 2 );
			
			// Also send payment reminder
			if ( function_exists( 'wcs_get_subscription' ) ) {
				$wc_subscription = wcs_get_subscription( $subscription_id );
				if ( $wc_subscription ) {
					$notifications->check_payment_reminders();
				}
			}
		}
		
		// Also update admin email for notifications
		update_option( 'admin_email', $this->admin_email );
	}
}

// Initialize test setup (only in debug mode)
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
	new Tutor_Scheduling_Test_Setup();
}

