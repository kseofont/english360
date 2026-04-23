<?php
/**
 * Notifications Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Notifications {
	
	private $table_name;
	
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tutor_scheduling_notifications';
		
		// Hook into subscription ending
		add_action( 'tutor_scheduling_subscription_ending_soon', array( $this, 'handle_subscription_ending_soon' ), 10, 3 );
	}
	
	/**
	 * Check subscriptions and send notifications
	 */
	public function check_subscription_endings() {
		$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
		
		// Get all active subscriptions with 2 or fewer remaining lessons
		global $wpdb;
		$subscriptions = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}tutor_subscription_lessons 
			WHERE status = 'active' AND remaining_lessons <= 2 AND remaining_lessons > 0"
		);
		
		foreach ( $subscriptions as $subscription ) {
			// Check if notification already sent for this remaining count
			$notification_sent = $this->notification_sent( 
				$subscription->subscription_id, 
				'subscription_ending_admin',
				$subscription->remaining_lessons 
			);
			
			if ( ! $notification_sent ) {
				// Send admin notification
				$this->send_admin_notification( $subscription );
				
				// Send student notification
				$this->send_student_notification( $subscription );
				
				// Log notification
				$this->log_notification( 
					$subscription->subscription_id,
					$subscription->student_id,
					'subscription_ending_admin',
					$subscription->remaining_lessons
				);
			}
		}
		
		// Check for subscriptions ending by date (1 day before expiration)
		$this->check_subscription_date_endings();
		
		// Check for payment reminders
		$this->check_payment_reminders();
	}
	
	/**
	 * Handle subscription ending soon (triggered when lesson is used)
	 */
	public function handle_subscription_ending_soon( $subscription_id, $student_id, $remaining_lessons ) {
		if ( $remaining_lessons == 2 ) {
			$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
			$subscriptions = $subscription_tracker->get_subscription_tracking( $subscription_id, $student_id );
			
			if ( ! empty( $subscriptions ) ) {
				$subscription = $subscriptions[0];
				
				// Check if notification already sent
				if ( ! $this->notification_sent( $subscription_id, 'subscription_ending_admin', 2 ) ) {
					$this->send_admin_notification( $subscription );
					$this->send_student_notification( $subscription );
					
					$this->log_notification( 
						$subscription_id,
						$student_id,
						'subscription_ending_admin',
						2
					);
				}
			}
		}
	}
	
	/**
	 * Send admin notification
	 */
	private function send_admin_notification( $subscription ) {
		$student = get_userdata( $subscription->student_id );
		$course = get_post( $subscription->course_id );
		
		$subject = sprintf( 
			__( 'Subscription Ending Soon - %d Lessons Remaining', 'tutor-scheduling' ),
			$subscription->remaining_lessons
		);
		
		$message = sprintf(
			__( 'Student %s (%s) has only %d lessons remaining in their subscription for course "%s".', 'tutor-scheduling' ),
			$student->display_name,
			$student->user_email,
			$subscription->remaining_lessons,
			$course->post_title
		);
		
		// Send email to admin
		$admin_email = get_option( 'admin_email' );
		wp_mail( $admin_email, $subject, $message );
		
		// Also use Tutor notifications if available
		if ( class_exists( 'TUTOR_NOTIFICATIONS\Utils' ) ) {
			$admin_user = get_user_by( 'email', get_option( 'admin_email' ) );
			if ( $admin_user ) {
				\TUTOR_NOTIFICATIONS\Utils::save_notification_data( array(
					'receiver_id' => $admin_user->ID,
					'title' => $subject,
					'content' => $message,
					'type' => 'info',
					'status' => 'UNREAD',
				) );
			}
		}
	}
	
	/**
	 * Send student notification
	 */
	private function send_student_notification( $subscription ) {
		$student = get_userdata( $subscription->student_id );
		$course = get_post( $subscription->course_id );
		
		// Check if WooCommerce subscription exists
		if ( function_exists( 'wcs_get_subscription' ) ) {
			$wc_subscription = wcs_get_subscription( $subscription->subscription_id );
			
			if ( $wc_subscription ) {
				$next_payment_date = $wc_subscription->get_date( 'next_payment' );
				
				$subject = __( 'Your Subscription is Ending Soon', 'tutor-scheduling' );
				$message = sprintf(
					__( 'Hello %s,', 'tutor-scheduling' ) . "\n\n" .
					__( 'You have %d lessons remaining in your subscription for "%s".', 'tutor-scheduling' ) . "\n\n" .
					__( 'Next payment date: %s', 'tutor-scheduling' ) . "\n\n" .
					__( 'Please renew your subscription to continue taking lessons.', 'tutor-scheduling' ),
					$student->display_name,
					$subscription->remaining_lessons,
					$course->post_title,
					$next_payment_date ? date_i18n( get_option( 'date_format' ), strtotime( $next_payment_date ) ) : __( 'N/A', 'tutor-scheduling' )
				);
				
				wp_mail( $student->user_email, $subject, $message );
				
				// Use Tutor notifications if available
				if ( class_exists( 'TUTOR_NOTIFICATIONS\Utils' ) ) {
					\TUTOR_NOTIFICATIONS\Utils::save_notification_data( array(
						'receiver_id' => $subscription->student_id,
						'title' => $subject,
						'content' => $message,
						'type' => 'warning',
						'status' => 'UNREAD',
					) );
				}
			}
		}
	}
	
	/**
	 * Check for subscriptions ending by date (1 day before expiration)
	 */
	public function check_subscription_date_endings() {
		global $wpdb;
		
		// Get subscriptions ending tomorrow (1 day from now)
		$tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );
		
		$subscriptions = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}tutor_subscription_lessons 
			WHERE status = 'active' AND subscription_end = %s",
			$tomorrow
		) );
		
		foreach ( $subscriptions as $subscription ) {
			// Check if notification already sent for date-based expiration
			$notification_sent = $this->notification_sent( 
				$subscription->subscription_id, 
				'subscription_ending_date',
				null 
			);
			
			if ( ! $notification_sent ) {
				// Send student notification about subscription ending in 1 day
				$this->send_subscription_ending_date_notification( $subscription );
				
				// Log notification
				$this->log_notification( 
					$subscription->subscription_id,
					$subscription->student_id,
					'subscription_ending_date',
					null
				);
			}
		}
	}
	
	/**
	 * Send notification about subscription ending by date
	 */
	private function send_subscription_ending_date_notification( $subscription ) {
		$student = get_userdata( $subscription->student_id );
		if ( ! $student ) {
			return;
		}
		
		$course = get_post( $subscription->course_id );
		$course_name = $course ? $course->post_title : __( 'your course', 'tutor-scheduling' );
		
		$subject = __( 'Your Subscription Ends Tomorrow', 'tutor-scheduling' );
		$message = sprintf(
			__( 'Hello %s,', 'tutor-scheduling' ) . "\n\n" .
			__( 'This is a reminder that your subscription for "%s" will end tomorrow (%s).', 'tutor-scheduling' ) . "\n\n" .
			__( 'You have %d lessons remaining in your subscription.', 'tutor-scheduling' ) . "\n\n" .
			__( 'If you would like to continue taking lessons, please renew your subscription.', 'tutor-scheduling' ) . "\n\n" .
			__( 'Thank you for being a valued student!', 'tutor-scheduling' ),
			$student->display_name,
			$course_name,
			date_i18n( get_option( 'date_format' ), strtotime( $subscription->subscription_end ) ),
			$subscription->remaining_lessons
		);
		
		wp_mail( $student->user_email, $subject, $message );
		
		// Use Tutor notifications if available
		if ( class_exists( 'TUTOR_NOTIFICATIONS\Utils' ) ) {
			\TUTOR_NOTIFICATIONS\Utils::save_notification_data( array(
				'receiver_id' => $subscription->student_id,
				'title' => $subject,
				'content' => $message,
				'type' => 'warning',
				'status' => 'UNREAD',
			) );
		}
	}
	
	/**
	 * Check for payment reminders (public for testing)
	 */
	public function check_payment_reminders() {
		if ( ! function_exists( 'wcs_get_subscriptions' ) ) {
			return;
		}
		
		// Get subscriptions with next payment in 3 days
		$subscriptions = wcs_get_subscriptions( array(
			'subscription_status' => 'active',
			'limit' => -1,
		) );
		
		foreach ( $subscriptions as $subscription ) {
			$next_payment = $subscription->get_date( 'next_payment' );
			
			if ( $next_payment ) {
				$days_until_payment = ( strtotime( $next_payment ) - time() ) / DAY_IN_SECONDS;
				
				if ( $days_until_payment <= 3 && $days_until_payment > 0 ) {
					$student_id = $subscription->get_user_id();
					
					// Check if reminder already sent
					if ( ! $this->notification_sent( $subscription->get_id(), 'payment_reminder', null ) ) {
						$this->send_payment_reminder( $subscription, $student_id );
						
						$this->log_notification( 
							$subscription->get_id(),
							$student_id,
							'payment_reminder',
							null
						);
					}
				}
			}
		}
	}
	
	/**
	 * Send payment reminder
	 */
	private function send_payment_reminder( $subscription, $student_id ) {
		$student = get_userdata( $student_id );
		$next_payment = $subscription->get_date( 'next_payment' );
		$amount = $subscription->get_total();
		
		$subject = __( 'Upcoming Payment Reminder', 'tutor-scheduling' );
		$message = sprintf(
			__( 'Hello %s,', 'tutor-scheduling' ) . "\n\n" .
			__( 'This is a reminder that your next subscription payment of %s is scheduled for %s.', 'tutor-scheduling' ) . "\n\n" .
			__( 'Thank you for your continued subscription.', 'tutor-scheduling' ),
			$student->display_name,
			wc_price( $amount ),
			date_i18n( get_option( 'date_format' ), strtotime( $next_payment ) )
		);
		
		wp_mail( $student->user_email, $subject, $message );
		
		// Use Tutor notifications if available
		if ( class_exists( 'TUTOR_NOTIFICATIONS\Utils' ) ) {
			\TUTOR_NOTIFICATIONS\Utils::save_notification_data( array(
				'receiver_id' => $student_id,
				'title' => $subject,
				'content' => $message,
				'type' => 'info',
				'status' => 'UNREAD',
			) );
		}
	}
	
	/**
	 * Check if notification was already sent
	 */
	private function notification_sent( $subscription_id, $type, $remaining_lessons = null ) {
		global $wpdb;
		
		$where = $wpdb->prepare(
			"subscription_id = %d AND notification_type = %s",
			$subscription_id,
			$type
		);
		
		if ( $remaining_lessons !== null ) {
			$where .= $wpdb->prepare( " AND remaining_lessons = %d", $remaining_lessons );
		}
		
		$sent = $wpdb->get_var(
			"SELECT id FROM {$this->table_name} WHERE {$where} LIMIT 1"
		);
		
		return ! empty( $sent );
	}
	
	/**
	 * Log notification
	 */
	private function log_notification( $subscription_id, $student_id, $type, $remaining_lessons = null ) {
		global $wpdb;
		
		$wpdb->insert(
			$this->table_name,
			array(
				'subscription_id' => $subscription_id,
				'student_id' => $student_id,
				'notification_type' => $type,
				'remaining_lessons' => $remaining_lessons,
			),
			array( '%d', '%d', '%s', '%d' )
		);
	}
}

