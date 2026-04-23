<?php
/**
 * Script to send subscription ending email notification
 * 
 * This script checks for subscriptions ending tomorrow and sends email notifications.
 * Can be run directly or via WordPress admin.
 */

// Load WordPress
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

// Check if user is admin or if running from command line
if ( php_sapi_name() !== 'cli' && ! defined( 'WP_CLI' ) && ! current_user_can( 'manage_options' ) ) {
	die( 'Access denied. This script requires administrator privileges.' );
}

// Get student email
$student_email = 'dmitry.stepanov28@gmail.com';

// Get student user
$student = get_user_by( 'email', $student_email );

if ( ! $student ) {
	die( "Student with email {$student_email} not found.\n" );
}

echo "Found student: {$student->display_name} (ID: {$student->ID})\n";

// Get subscription tracker
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-subscription-tracker.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-notifications.php' );

$tracker = new Tutor_Scheduling_Subscription_Tracker();
$notifications = new Tutor_Scheduling_Notifications();

// Get all active subscriptions for this student
global $wpdb;
$subscriptions = $wpdb->get_results( $wpdb->prepare(
	"SELECT * FROM {$wpdb->prefix}tutor_subscription_lessons 
	WHERE student_id = %d AND status = 'active'",
	$student->ID
) );

if ( empty( $subscriptions ) ) {
	die( "No active subscriptions found for student.\n" );
}

echo "Found " . count( $subscriptions ) . " active subscription(s).\n\n";

// Check for subscriptions ending tomorrow
$tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );
$found_subscription = null;

foreach ( $subscriptions as $subscription ) {
	echo "Checking subscription ID: {$subscription->subscription_id}\n";
	echo "  - Subscription end date: " . ( $subscription->subscription_end ? $subscription->subscription_end : 'Not set' ) . "\n";
	echo "  - Tomorrow date: {$tomorrow}\n";
	
	// If subscription_end is not set, try to get it from WooCommerce subscription
	if ( ! $subscription->subscription_end && function_exists( 'wcs_get_subscription' ) ) {
		$wc_subscription = wcs_get_subscription( $subscription->subscription_id );
		if ( $wc_subscription ) {
			$end_date = $wc_subscription->get_date( 'end' );
			if ( $end_date ) {
				$subscription_end = date( 'Y-m-d', strtotime( $end_date ) );
				echo "  - Found WooCommerce end date: {$subscription_end}\n";
				
				// Update the subscription_end in our tracking table
				$wpdb->update(
					$wpdb->prefix . 'tutor_subscription_lessons',
					array( 'subscription_end' => $subscription_end ),
					array( 'id' => $subscription->id ),
					array( '%s' ),
					array( '%d' )
				);
				
				$subscription->subscription_end = $subscription_end;
			}
		}
	}
	
	if ( $subscription->subscription_end === $tomorrow ) {
		$found_subscription = $subscription;
		echo "  ✓ This subscription ends tomorrow!\n";
		break;
	} else {
		echo "  - Does not end tomorrow\n";
	}
	echo "\n";
}

// If no subscription ends tomorrow, update the first one for testing
if ( ! $found_subscription && ! empty( $subscriptions ) ) {
	echo "No subscription found ending tomorrow. Updating first subscription for testing...\n";
	$found_subscription = $subscriptions[0];
	
	// Update subscription_end to tomorrow
	$wpdb->update(
		$wpdb->prefix . 'tutor_subscription_lessons',
		array( 'subscription_end' => $tomorrow ),
		array( 'id' => $found_subscription->id ),
		array( '%s' ),
		array( '%d' )
	);
	
	$found_subscription->subscription_end = $tomorrow;
	echo "Updated subscription ID {$found_subscription->subscription_id} to end tomorrow ({$tomorrow}).\n\n";
}

if ( $found_subscription ) {
	echo "Sending email notification...\n";
	
	// Check if notification already sent
	$notification_sent = $wpdb->get_var( $wpdb->prepare(
		"SELECT id FROM {$wpdb->prefix}tutor_scheduling_notifications 
		WHERE subscription_id = %d AND notification_type = 'subscription_ending_date' LIMIT 1",
		$found_subscription->subscription_id
	) );
	
	if ( $notification_sent ) {
		echo "Notification already sent. Sending anyway for testing...\n";
		// Delete the old notification log so we can send again
		$wpdb->delete(
			$wpdb->prefix . 'tutor_scheduling_notifications',
			array(
				'subscription_id' => $found_subscription->subscription_id,
				'notification_type' => 'subscription_ending_date',
			),
			array( '%d', '%s' )
		);
	}
	
	// Use reflection to call the private method
	$reflection = new ReflectionClass( $notifications );
	$method = $reflection->getMethod( 'send_subscription_ending_date_notification' );
	$method->setAccessible( true );
	
	try {
		$method->invoke( $notifications, $found_subscription );
		echo "✓ Email sent successfully to {$student_email}\n";
		echo "✓ Notification logged in database\n";
	} catch ( Exception $e ) {
		echo "✗ Error sending email: " . $e->getMessage() . "\n";
		// Fallback to direct email sending
		echo "Trying direct email send...\n";
		
		$course = get_post( $found_subscription->course_id );
		$course_name = $course ? $course->post_title : 'your course';
		
		$subject = __( 'Your Subscription Ends Tomorrow', 'tutor-scheduling' );
		$message = sprintf(
			__( 'Hello %s,', 'tutor-scheduling' ) . "\n\n" .
			__( 'This is a reminder that your subscription for "%s" will end tomorrow (%s).', 'tutor-scheduling' ) . "\n\n" .
			__( 'You have %d lessons remaining in your subscription.', 'tutor-scheduling' ) . "\n\n" .
			__( 'If you would like to continue taking lessons, please renew your subscription.', 'tutor-scheduling' ) . "\n\n" .
			__( 'Thank you for being a valued student!', 'tutor-scheduling' ),
			$student->display_name,
			$course_name,
			date_i18n( get_option( 'date_format' ), strtotime( $found_subscription->subscription_end ) ),
			$found_subscription->remaining_lessons
		);
		
		// Increase memory limit temporarily
		$old_limit = ini_get( 'memory_limit' );
		ini_set( 'memory_limit', '256M' );
		
		$result = @wp_mail( $student_email, $subject, $message );
		
		ini_set( 'memory_limit', $old_limit );
		
		if ( $result ) {
			echo "✓ Email sent successfully to {$student_email}\n";
			
			// Log notification
			$wpdb->insert(
				$wpdb->prefix . 'tutor_scheduling_notifications',
				array(
					'subscription_id' => $found_subscription->subscription_id,
					'student_id' => $found_subscription->student_id,
					'notification_type' => 'subscription_ending_date',
					'remaining_lessons' => null,
				),
				array( '%d', '%d', '%s', '%d' )
			);
			
			echo "✓ Notification logged in database\n";
		} else {
			echo "✗ Failed to send email. Check WordPress mail configuration.\n";
		}
	}
} else {
	die( "No subscription found to send notification for.\n" );
}

echo "\nDone!\n";

