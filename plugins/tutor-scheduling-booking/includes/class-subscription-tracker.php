<?php
/**
 * Subscription and Lessons Tracking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Subscription_Tracker {
	
	private $table_name;
	
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tutor_subscription_lessons';
	}
	
	/**
	 * Create or update subscription tracking when order is completed
	 */
	public function track_subscription( $subscription_id, $student_id, $course_id, $total_lessons ) {
		global $wpdb;
		
		// Check if tracking already exists
		$existing = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE subscription_id = %d AND student_id = %d AND course_id = %d",
			$subscription_id,
			$student_id,
			$course_id
		) );
		
		// Try to get subscription end date from WooCommerce subscription
		$subscription_end = null;
		if ( function_exists( 'wcs_get_subscription' ) ) {
			$wc_subscription = wcs_get_subscription( $subscription_id );
			if ( $wc_subscription ) {
				$end_date = $wc_subscription->get_date( 'end' );
				if ( $end_date ) {
					// Convert to date only (Y-m-d format)
					$subscription_end = date( 'Y-m-d', strtotime( $end_date ) );
				}
			}
		}
		
		$data = array(
			'student_id' => $student_id,
			'subscription_id' => $subscription_id,
			'course_id' => $course_id,
			'total_lessons' => $total_lessons,
			'used_lessons' => 0,
			'remaining_lessons' => $total_lessons,
			'subscription_start' => current_time( 'Y-m-d' ),
			'subscription_end' => $subscription_end,
			'status' => 'active',
		);
		
		$format = array( '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s' );
		
		if ( $existing ) {
			// Update existing
			$wpdb->update(
				$this->table_name,
				$data,
				array( 'id' => $existing->id ),
				$format,
				array( '%d' )
			);
			return $existing->id;
		} else {
			// Insert new
			$wpdb->insert(
				$this->table_name,
				$data,
				$format
			);
			return $wpdb->insert_id;
		}
	}
	
	/**
	 * Get subscription tracking data
	 */
	public function get_subscription_tracking( $subscription_id, $student_id = null ) {
		global $wpdb;
		
		$where = $wpdb->prepare( "subscription_id = %d", $subscription_id );
		if ( $student_id ) {
			$where .= $wpdb->prepare( " AND student_id = %d", $student_id );
		}
		
		return $wpdb->get_results(
			"SELECT * FROM {$this->table_name} WHERE {$where} AND status = 'active'"
		);
	}
	
	/**
	 * Get student's subscription tracking
	 */
	public function get_student_subscriptions( $student_id, $course_id = null ) {
		global $wpdb;
		
		$where = $wpdb->prepare( "student_id = %d AND status = 'active'", $student_id );
		if ( $course_id ) {
			$where .= $wpdb->prepare( " AND course_id = %d", $course_id );
		}
		
		return $wpdb->get_results(
			"SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY subscription_start DESC"
		);
	}
	
	/**
	 * Get remaining lessons for a subscription
	 */
	public function get_remaining_lessons( $student_id, $subscription_id ) {
		global $wpdb;
		
		// First check without status filter to see if subscription exists
		$subscription = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} 
			WHERE student_id = %d AND subscription_id = %d",
			$student_id,
			$subscription_id
		) );
		
		if ( ! $subscription ) {
			error_log( 'Tutor Scheduling: Subscription not found - Student: ' . $student_id . ', Subscription: ' . $subscription_id );
			return 0;
		}
		
		// Check if subscription is active
		if ( $subscription->status !== 'active' ) {
			error_log( 'Tutor Scheduling: Subscription not active - Status: ' . $subscription->status );
			return 0;
		}
		
		$remaining = (int) $subscription->remaining_lessons;
		error_log( 'Tutor Scheduling: Remaining lessons for subscription ' . $subscription_id . ': ' . $remaining );
		
		return $remaining;
	}
	
	/**
	 * Use a lesson (decrement remaining)
	 */
	public function use_lesson( $student_id, $subscription_id, $booking_id ) {
		global $wpdb;
		
		$result = $wpdb->query( $wpdb->prepare(
			"UPDATE {$this->table_name} 
			SET used_lessons = used_lessons + 1, 
				remaining_lessons = remaining_lessons - 1
			WHERE student_id = %d AND subscription_id = %d AND status = 'active' AND remaining_lessons > 0",
			$student_id,
			$subscription_id
		) );
		
		if ( $result ) {
			// Check if subscription is about to end (2 lessons remaining)
			$remaining = $this->get_remaining_lessons( $student_id, $subscription_id );
			if ( $remaining == 2 ) {
				do_action( 'tutor_scheduling_subscription_ending_soon', $subscription_id, $student_id, $remaining );
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Restore a lesson (increment remaining - for cancellations)
	 */
	public function restore_lesson( $student_id, $subscription_id, $booking_id ) {
		global $wpdb;
		
		return $wpdb->query( $wpdb->prepare(
			"UPDATE {$this->table_name} 
			SET used_lessons = GREATEST(used_lessons - 1, 0), 
				remaining_lessons = remaining_lessons + 1
			WHERE student_id = %d AND subscription_id = %d AND status = 'active'",
			$student_id,
			$subscription_id
		) );
	}
	
	/**
	 * Get subscription details for display
	 */
	public function get_subscription_details( $student_id, $subscription_id ) {
		global $wpdb;
		
		$subscription = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} 
			WHERE student_id = %d AND subscription_id = %d",
			$student_id,
			$subscription_id
		) );
		
		if ( ! $subscription ) {
			return null;
		}
		
		// Get course info
		$course = get_post( $subscription->course_id );
		
		// Get subscription info from WooCommerce (optional, may not exist)
		$wc_subscription = null;
		if ( function_exists( 'wcs_get_subscription' ) ) {
			$wc_subscription = wcs_get_subscription( $subscription_id );
		}
		
		return array(
			'subscription' => $subscription,
			'subscription_id' => $subscription->subscription_id,
			'course' => $course,
			'course_id' => $subscription->course_id,
			'wc_subscription' => $wc_subscription,
			'total_lessons' => $subscription->total_lessons,
			'used_lessons' => $subscription->used_lessons,
			'remaining_lessons' => $subscription->remaining_lessons,
			'status' => $subscription->status,
		);
	}
	
}

