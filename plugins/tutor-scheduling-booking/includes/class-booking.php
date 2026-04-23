<?php
/**
 * Lesson Booking Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Lesson_Booking {
	
	private $table_name;
	
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tutor_lesson_bookings';
	}
	
	/**
	 * Create a booking
	 */
	public function create_booking( $data ) {
		global $wpdb;
		
		// Validate required fields
		$required = array( 'student_id', 'teacher_id', 'course_id', 'booking_date', 'booking_time' );
		foreach ( $required as $field ) {
			if ( empty( $data[ $field ] ) ) {
				return new WP_Error( 'missing_field', sprintf( __( 'Missing required field: %s', 'tutor-scheduling' ), $field ) );
			}
		}
		
		// Check teacher availability
		$availability = new Tutor_Scheduling_Availability();
		$is_available = $availability->is_available_at( $data['teacher_id'], $data['booking_date'], $data['booking_time'] );
		if ( ! $is_available ) {
			error_log( 'Tutor Scheduling: Teacher not available - Teacher: ' . $data['teacher_id'] . ', Date: ' . $data['booking_date'] . ', Time: ' . $data['booking_time'] );
			return new WP_Error( 'not_available', __( 'Teacher is not available at this time. Please select a different time slot.', 'tutor-scheduling' ) );
		}
		
		// Check if slot is already booked (exclude pending bookings from this check, as they can be rejected)
		// Only check approved/scheduled bookings
		if ( $this->is_slot_booked( $data['teacher_id'], $data['booking_date'], $data['booking_time'], null, array( 'approved', 'scheduled', 'rescheduled' ) ) ) {
			return new WP_Error( 'slot_booked', __( 'This time slot is already booked', 'tutor-scheduling' ) );
		}
		
		// Check if student has remaining lessons
		$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
		
		// If subscription_id provided, check it
		if ( ! empty( $data['subscription_id'] ) ) {
			error_log( 'Tutor Scheduling: Checking subscription - ID: ' . $data['subscription_id'] . ', Student: ' . $data['student_id'] );
			
			// Get subscription details first
			$sub_details = $subscription_tracker->get_subscription_details( $data['student_id'], $data['subscription_id'] );
			if ( ! $sub_details ) {
				error_log( 'Tutor Scheduling: Subscription not found - ID: ' . $data['subscription_id'] );
				return new WP_Error( 'invalid_subscription', __( 'Subscription not found. Please select a valid subscription.', 'tutor-scheduling' ) );
			}
			
			// Check subscription status
			$subscription = $sub_details['subscription'];
			if ( ! $subscription || $subscription->status !== 'active' ) {
				error_log( 'Tutor Scheduling: Subscription not active - Status: ' . ( $subscription ? $subscription->status : 'null' ) );
				return new WP_Error( 'inactive_subscription', __( 'Your subscription is not active. Please activate your subscription first.', 'tutor-scheduling' ) );
			}
			
			// Check remaining lessons
			$remaining = $subscription_tracker->get_remaining_lessons( $data['student_id'], $data['subscription_id'] );
			error_log( 'Tutor Scheduling: Remaining lessons: ' . $remaining );
			if ( $remaining <= 0 ) {
				return new WP_Error( 'no_lessons', __( 'No remaining lessons in your subscription. Please purchase a new subscription.', 'tutor-scheduling' ) );
			}
			
			// Verify subscription is for the correct course
			$sub_course_id = isset( $sub_details['course_id'] ) ? $sub_details['course_id'] : ( isset( $subscription->course_id ) ? $subscription->course_id : null );
			if ( $sub_course_id && $sub_course_id != $data['course_id'] ) {
				error_log( 'Tutor Scheduling: Course mismatch - Subscription course: ' . $sub_course_id . ', Selected course: ' . $data['course_id'] );
				return new WP_Error( 'wrong_course', __( 'Selected subscription is not for this course. Please select the correct subscription.', 'tutor-scheduling' ) );
			}
		} else {
			// If no subscription_id provided, try to find active subscription for this course
			error_log( 'Tutor Scheduling: No subscription_id provided, searching for subscriptions - Student: ' . $data['student_id'] . ', Course: ' . $data['course_id'] );
			$subscriptions = $subscription_tracker->get_student_subscriptions( $data['student_id'], $data['course_id'] );
			error_log( 'Tutor Scheduling: Found ' . count( $subscriptions ) . ' subscriptions for course' );
			
			$has_available_lessons = false;
			
			if ( empty( $subscriptions ) ) {
				// Try without course filter
				error_log( 'Tutor Scheduling: No subscriptions for course, trying without course filter' );
				$subscriptions = $subscription_tracker->get_student_subscriptions( $data['student_id'] );
				error_log( 'Tutor Scheduling: Found ' . count( $subscriptions ) . ' total subscriptions' );
			}
			
			foreach ( $subscriptions as $sub ) {
				error_log( 'Tutor Scheduling: Checking subscription - ID: ' . $sub->subscription_id . ', Course: ' . $sub->course_id . ', Status: ' . $sub->status );
				$remaining = $subscription_tracker->get_remaining_lessons( $data['student_id'], $sub->subscription_id );
				error_log( 'Tutor Scheduling: Remaining lessons: ' . $remaining );
				
				if ( $remaining > 0 ) {
					// Check if this subscription is for the selected course (or if course_id is 0/null, allow any)
					if ( ! $data['course_id'] || $sub->course_id == $data['course_id'] || ! $sub->course_id ) {
						$data['subscription_id'] = $sub->subscription_id;
						$has_available_lessons = true;
						error_log( 'Tutor Scheduling: Using subscription ID: ' . $sub->subscription_id );
						break;
					} else {
						error_log( 'Tutor Scheduling: Course mismatch - Subscription course: ' . $sub->course_id . ', Selected course: ' . $data['course_id'] );
					}
				}
			}
			
			if ( ! $has_available_lessons ) {
				if ( empty( $subscriptions ) ) {
					error_log( 'Tutor Scheduling: No subscriptions found for student' );
					return new WP_Error( 'no_subscription', __( 'You need to purchase a subscription to book lessons', 'tutor-scheduling' ) );
				} else {
					error_log( 'Tutor Scheduling: No available lessons in subscriptions' );
					return new WP_Error( 'no_lessons', __( 'No remaining lessons in your subscription for this course', 'tutor-scheduling' ) );
				}
			}
		}
		
		// Insert booking with pending status (needs teacher approval)
		$insert_data = array(
			'student_id' => $data['student_id'],
			'teacher_id' => $data['teacher_id'],
			'course_id' => $data['course_id'],
			'lesson_id' => isset( $data['lesson_id'] ) ? $data['lesson_id'] : null,
			'booking_date' => $data['booking_date'],
			'booking_time' => $data['booking_time'],
			'duration' => isset( $data['duration'] ) ? $data['duration'] : 60,
			'status' => isset( $data['status'] ) ? $data['status'] : 'pending', // Default to pending for approval
			'subscription_id' => isset( $data['subscription_id'] ) ? $data['subscription_id'] : null,
			'order_id' => isset( $data['order_id'] ) ? $data['order_id'] : null,
			'google_meet_link' => isset( $data['google_meet_link'] ) ? $data['google_meet_link'] : null,
			'notes' => isset( $data['notes'] ) ? $data['notes'] : null,
		);
		
		// Format: student_id, teacher_id, course_id, lesson_id, booking_date, booking_time, duration, status, subscription_id, order_id, google_meet_link, notes
		error_log( 'Tutor Scheduling: Inserting booking with data: ' . print_r( $insert_data, true ) );
		$result = $wpdb->insert(
			$this->table_name,
			$insert_data,
			array( '%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%d', '%d', '%s', '%s' )
		);
		
		if ( $result === false ) {
			error_log( 'Tutor Scheduling: Database insert failed - ' . $wpdb->last_error );
			return false;
		}
		
		if ( $result ) {
			$booking_id = $wpdb->insert_id;
			error_log( 'Tutor Scheduling: Booking inserted successfully - ID: ' . $booking_id );
			
			// Decrement remaining lessons if subscription exists (only after booking is created)
			// Note: We don't decrement for pending bookings - only after teacher approval
			// The lesson will be decremented when teacher approves the booking
			
			// Send notification
			do_action( 'tutor_scheduling_booking_created', $booking_id, $insert_data );
			
			return $booking_id;
		}
		
		return false;
	}
	
	/**
	 * Cancel a booking
	 */
	public function cancel_booking( $booking_id, $user_id ) {
		global $wpdb;
		
		$booking = $this->get_booking( $booking_id );
		if ( ! $booking ) {
			return new WP_Error( 'not_found', __( 'Booking not found', 'tutor-scheduling' ) );
		}
		
		// Check if user has permission (student or teacher)
		if ( $booking->student_id != $user_id && $booking->teacher_id != $user_id && ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'permission_denied', __( 'You do not have permission to cancel this booking', 'tutor-scheduling' ) );
		}
		
		// Check cancellation rules (e.g., can't cancel less than 24 hours before)
		$booking_datetime = strtotime( $booking->booking_date . ' ' . $booking->booking_time );
		$hours_before = ( $booking_datetime - time() ) / 3600;
		
		if ( $hours_before < 24 && ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'too_late', __( 'Cannot cancel booking less than 24 hours before the scheduled time', 'tutor-scheduling' ) );
		}
		
		// Update booking status
		$result = $wpdb->update(
			$this->table_name,
			array( 'status' => 'cancelled' ),
			array( 'id' => $booking_id ),
			array( '%s' ),
			array( '%d' )
		);
		
		if ( $result ) {
			// Restore lesson to subscription if applicable
			if ( $booking->subscription_id ) {
				$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
				$subscription_tracker->restore_lesson( $booking->student_id, $booking->subscription_id, $booking_id );
			}
			
			do_action( 'tutor_scheduling_booking_cancelled', $booking_id, $booking );
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Reschedule a booking
	 */
	public function reschedule_booking( $booking_id, $new_date, $new_time, $user_id ) {
		global $wpdb;
		
		$booking = $this->get_booking( $booking_id );
		if ( ! $booking ) {
			return new WP_Error( 'not_found', __( 'Booking not found', 'tutor-scheduling' ) );
		}
		
		// Check permission
		if ( $booking->student_id != $user_id && $booking->teacher_id != $user_id && ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'permission_denied', __( 'You do not have permission to reschedule this booking', 'tutor-scheduling' ) );
		}
		
		// Check if new slot is available
		$availability = new Tutor_Scheduling_Availability();
		if ( ! $availability->is_available_at( $booking->teacher_id, $new_date, $new_time ) ) {
			return new WP_Error( 'not_available', __( 'Teacher is not available at the new time', 'tutor-scheduling' ) );
		}
		
		if ( $this->is_slot_booked( $booking->teacher_id, $new_date, $new_time, $booking_id ) ) {
			return new WP_Error( 'slot_booked', __( 'The new time slot is already booked', 'tutor-scheduling' ) );
		}
		
		// Update booking
		$result = $wpdb->update(
			$this->table_name,
			array(
				'booking_date' => $new_date,
				'booking_time' => $new_time,
				'status' => 'rescheduled',
			),
			array( 'id' => $booking_id ),
			array( '%s', '%s', '%s' ),
			array( '%d' )
		);
		
		if ( $result ) {
			do_action( 'tutor_scheduling_booking_rescheduled', $booking_id, $booking, $new_date, $new_time );
			return true;
		}
		
		return false;
	}
	
	/**
	 * Get booking by ID
	 */
	public function get_booking( $booking_id ) {
		global $wpdb;
		
		return $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE id = %d",
			$booking_id
		) );
	}
	
	/**
	 * Get bookings by date
	 */
	public function get_bookings_by_date( $teacher_id, $date ) {
		global $wpdb;
		
		return $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} 
			WHERE teacher_id = %d AND booking_date = %s AND status IN ('scheduled', 'rescheduled')
			ORDER BY booking_time",
			$teacher_id,
			$date
		) );
	}
	
	/**
	 * Get student bookings
	 */
	public function get_student_bookings( $student_id, $status = null ) {
		global $wpdb;
		
		$where = $wpdb->prepare( "student_id = %d", $student_id );
		if ( $status ) {
			$where .= $wpdb->prepare( " AND status = %s", $status );
		} else {
			// Show all statuses for students (including pending)
			$where .= " AND status IN ('pending', 'approved', 'scheduled', 'rescheduled', 'completed', 'rejected')";
		}
		
		return $wpdb->get_results(
			"SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY booking_date DESC, booking_time DESC"
		);
	}
	
	/**
	 * Get teacher bookings
	 */
	public function get_teacher_bookings( $teacher_id, $status = null ) {
		global $wpdb;
		
		$where = $wpdb->prepare( "teacher_id = %d", $teacher_id );
		if ( $status ) {
			$where .= $wpdb->prepare( " AND status = %s", $status );
		} else {
			// Exclude pending and rejected by default (show only scheduled)
			$where .= " AND status IN ('scheduled', 'rescheduled', 'completed')";
		}
		
		return $wpdb->get_results(
			"SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY booking_date DESC, booking_time DESC"
		);
	}
	
	/**
	 * Check if a time slot is booked
	 */
	private function is_slot_booked( $teacher_id, $date, $time, $exclude_booking_id = null, $statuses = array( 'approved', 'scheduled', 'rescheduled' ) ) {
		global $wpdb;
		
		$status_list = "'" . implode( "','", array_map( 'esc_sql', $statuses ) ) . "'";
		
		$where = $wpdb->prepare(
			"teacher_id = %d AND booking_date = %s AND booking_time = %s AND status IN ({$status_list})",
			$teacher_id,
			$date,
			$time
		);
		
		if ( $exclude_booking_id ) {
			$where .= $wpdb->prepare( " AND id != %d", $exclude_booking_id );
		}
		
		$booking = $wpdb->get_var(
			"SELECT id FROM {$this->table_name} WHERE {$where}"
		);
		
		return ! empty( $booking );
	}
	
	/**
	 * Approve a booking (teacher action)
	 */
	public function approve_booking( $booking_id, $teacher_id ) {
		global $wpdb;
		
		$booking = $this->get_booking( $booking_id );
		if ( ! $booking ) {
			return new WP_Error( 'not_found', __( 'Booking not found', 'tutor-scheduling' ) );
		}
		
		// Check permission - only teacher can approve
		if ( $booking->teacher_id != $teacher_id && ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'permission_denied', __( 'You do not have permission to approve this booking', 'tutor-scheduling' ) );
		}
		
		// Check if booking is in pending status
		if ( $booking->status != 'pending' ) {
			return new WP_Error( 'invalid_status', __( 'Only pending bookings can be approved', 'tutor-scheduling' ) );
		}
		
		// Update booking status to scheduled (approved bookings are shown as scheduled)
		$result = $wpdb->update(
			$this->table_name,
			array( 'status' => 'scheduled' ),
			array( 'id' => $booking_id ),
			array( '%s' ),
			array( '%d' )
		);
		
		if ( $result !== false ) {
			// Now decrement remaining lessons if subscription exists
			if ( ! empty( $booking->subscription_id ) ) {
				$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
				$subscription_tracker->use_lesson( $booking->student_id, $booking->subscription_id, $booking_id );
			}
			
			// Send notification
			do_action( 'tutor_scheduling_booking_approved', $booking_id, $booking );
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Reject a booking (teacher action)
	 */
	public function reject_booking( $booking_id, $teacher_id ) {
		global $wpdb;
		
		$booking = $this->get_booking( $booking_id );
		if ( ! $booking ) {
			return new WP_Error( 'not_found', __( 'Booking not found', 'tutor-scheduling' ) );
		}
		
		// Check permission
		if ( $booking->teacher_id != $teacher_id && ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'permission_denied', __( 'You do not have permission to reject this booking', 'tutor-scheduling' ) );
		}
		
		// Update booking status to rejected
		$result = $wpdb->update(
			$this->table_name,
			array( 'status' => 'rejected' ),
			array( 'id' => $booking_id ),
			array( '%s' ),
			array( '%d' )
		);
		
		if ( $result !== false ) {
			do_action( 'tutor_scheduling_booking_rejected', $booking_id, $booking );
			return true;
		}
		
		return false;
	}
	
	/**
	 * Get pending bookings for a teacher
	 */
	public function get_pending_bookings( $teacher_id ) {
		global $wpdb;
		
		return $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} 
			WHERE teacher_id = %d AND status = 'pending'
			ORDER BY booking_date ASC, booking_time ASC",
			$teacher_id
		) );
	}
}

