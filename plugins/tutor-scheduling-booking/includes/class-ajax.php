<?php
/**
 * AJAX Handlers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Ajax {
	
	public function __construct() {
		// Teacher availability
		add_action( 'wp_ajax_tutor_scheduling_save_availability', array( $this, 'save_availability' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_availability', array( $this, 'get_availability' ) );
		
		// Bookings
		add_action( 'wp_ajax_tutor_scheduling_create_booking', array( $this, 'create_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_cancel_booking', array( $this, 'cancel_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_reschedule_booking', array( $this, 'reschedule_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_available_slots', array( $this, 'get_available_slots' ) );
		
		// Subscription tracking
		add_action( 'wp_ajax_tutor_scheduling_get_subscription_details', array( $this, 'get_subscription_details' ) );
		
		// Booking approval (teacher)
		add_action( 'wp_ajax_tutor_scheduling_approve_booking', array( $this, 'approve_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_reject_booking', array( $this, 'reject_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_pending_bookings', array( $this, 'get_pending_bookings' ) );
		
		// Calendar booking
		add_action( 'wp_ajax_tutor_scheduling_get_teachers_for_date', array( $this, 'get_teachers_for_date' ) );
	}
	
	/**
	 * Save teacher availability
	 */
	public function save_availability() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! current_user_can( 'tutor_instructor' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		$teacher_id = get_current_user_id();
		$day_of_week = isset( $_POST['day_of_week'] ) ? intval( $_POST['day_of_week'] ) : -1;
		$start_time = isset( $_POST['start_time'] ) ? sanitize_text_field( $_POST['start_time'] ) : '';
		$end_time = isset( $_POST['end_time'] ) ? sanitize_text_field( $_POST['end_time'] ) : '';
		$is_available = isset( $_POST['is_available'] ) ? (bool) $_POST['is_available'] : true;
		
		if ( $day_of_week < 0 || $day_of_week > 6 ) {
			wp_send_json_error( array( 'message' => __( 'Invalid day of week', 'tutor-scheduling' ) ) );
		}
		
		$availability = new Tutor_Scheduling_Availability();
		$result = $availability->set_availability( $teacher_id, $day_of_week, $start_time, $end_time, $is_available );
		
		if ( $result !== false ) {
			wp_send_json_success( array( 'message' => __( 'Availability saved successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to save availability', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Get teacher availability
	 */
	public function get_availability() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$teacher_id = isset( $_POST['teacher_id'] ) ? intval( $_POST['teacher_id'] ) : get_current_user_id();
		
		// Check permission (teacher can see own, students can see any teacher's)
		if ( $teacher_id != get_current_user_id() && ! current_user_can( 'tutor_instructor' ) && ! current_user_can( 'manage_options' ) ) {
			// Students can view teacher availability
		}
		
		$availability = new Tutor_Scheduling_Availability();
		$result = $availability->get_availability( $teacher_id );
		
		wp_send_json_success( array( 'availability' => $result ) );
	}
	
	/**
	 * Create booking
	 */
	public function create_booking() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => __( 'Please log in to book a lesson', 'tutor-scheduling' ) ) );
		}
		
		$student_id = get_current_user_id();
		$teacher_id = isset( $_POST['teacher_id'] ) ? intval( $_POST['teacher_id'] ) : 0;
		$course_id = isset( $_POST['course_id'] ) ? intval( $_POST['course_id'] ) : 0;
		$booking_date = isset( $_POST['booking_date'] ) ? sanitize_text_field( $_POST['booking_date'] ) : '';
		$booking_time = isset( $_POST['booking_time'] ) ? sanitize_text_field( $_POST['booking_time'] ) : '';
		$subscription_id = isset( $_POST['subscription_id'] ) ? intval( $_POST['subscription_id'] ) : null;
		
		if ( ! $teacher_id || ! $course_id || ! $booking_date || ! $booking_time ) {
			wp_send_json_error( array( 'message' => __( 'Missing required fields', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->create_booking( array(
			'student_id' => $student_id,
			'teacher_id' => $teacher_id,
			'course_id' => $course_id,
			'booking_date' => $booking_date,
			'booking_time' => $booking_time,
			'subscription_id' => $subscription_id,
		) );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 
				'message' => __( 'Booking request submitted! Waiting for teacher approval.', 'tutor-scheduling' ),
				'booking_id' => $result
			) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to create booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Cancel booking
	 */
	public function cancel_booking() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => __( 'Please log in', 'tutor-scheduling' ) ) );
		}
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		$user_id = get_current_user_id();
		
		if ( ! $booking_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid booking ID', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->cancel_booking( $booking_id, $user_id );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Booking cancelled successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to cancel booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Reschedule booking
	 */
	public function reschedule_booking() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => __( 'Please log in', 'tutor-scheduling' ) ) );
		}
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		$new_date = isset( $_POST['new_date'] ) ? sanitize_text_field( $_POST['new_date'] ) : '';
		$new_time = isset( $_POST['new_time'] ) ? sanitize_text_field( $_POST['new_time'] ) : '';
		$user_id = get_current_user_id();
		
		if ( ! $booking_id || ! $new_date || ! $new_time ) {
			wp_send_json_error( array( 'message' => __( 'Missing required fields', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->reschedule_booking( $booking_id, $new_date, $new_time, $user_id );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Booking rescheduled successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to reschedule booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Get available time slots
	 */
	public function get_available_slots() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$teacher_id = isset( $_POST['teacher_id'] ) ? intval( $_POST['teacher_id'] ) : 0;
		$date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		$duration = isset( $_POST['duration'] ) ? intval( $_POST['duration'] ) : 60;
		
		if ( ! $teacher_id || ! $date ) {
			wp_send_json_error( array( 'message' => __( 'Missing required fields', 'tutor-scheduling' ) ) );
		}
		
		$availability = new Tutor_Scheduling_Availability();
		$slots = $availability->get_available_slots( $teacher_id, $date, $duration );
		
		wp_send_json_success( array( 'slots' => $slots ) );
	}
	
	/**
	 * Get subscription details
	 */
	public function get_subscription_details() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => __( 'Please log in', 'tutor-scheduling' ) ) );
		}
		
		$student_id = isset( $_POST['student_id'] ) ? intval( $_POST['student_id'] ) : get_current_user_id();
		$subscription_id = isset( $_POST['subscription_id'] ) ? intval( $_POST['subscription_id'] ) : 0;
		
		// Check permission
		if ( $student_id != get_current_user_id() && ! current_user_can( 'tutor_instructor' ) && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		$tracker = new Tutor_Scheduling_Subscription_Tracker();
		
		if ( $subscription_id ) {
			$details = $tracker->get_subscription_details( $student_id, $subscription_id );
		} else {
			$subscriptions = $tracker->get_student_subscriptions( $student_id );
			$details = array();
			foreach ( $subscriptions as $sub ) {
				$details[] = $tracker->get_subscription_details( $student_id, $sub->subscription_id );
			}
		}
		
		wp_send_json_success( array( 'details' => $details ) );
	}
	
	/**
	 * Approve booking (teacher action)
	 */
	public function approve_booking() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() || ! current_user_can( 'tutor_instructor' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		$teacher_id = get_current_user_id();
		
		if ( ! $booking_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid booking ID', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->approve_booking( $booking_id, $teacher_id );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Booking approved successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to approve booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Reject booking (teacher action)
	 */
	public function reject_booking() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() || ! current_user_can( 'tutor_instructor' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		$teacher_id = get_current_user_id();
		
		if ( ! $booking_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid booking ID', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->reject_booking( $booking_id, $teacher_id );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Booking rejected', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to reject booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Get pending bookings for teacher
	 */
	public function get_pending_bookings() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() || ! current_user_can( 'tutor_instructor' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		$teacher_id = get_current_user_id();
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$bookings = $booking->get_pending_bookings( $teacher_id );
		
		// Format bookings with user and course info
		$formatted = array();
		foreach ( $bookings as $b ) {
			$student = get_userdata( $b->student_id );
			$course = get_post( $b->course_id );
			
			$formatted[] = array(
				'id' => $b->id,
				'date' => $b->booking_date,
				'time' => $b->booking_time,
				'student' => array(
					'id' => $student->ID,
					'name' => $student->display_name,
					'email' => $student->user_email,
				),
				'course' => array(
					'id' => $course->ID,
					'title' => $course->post_title,
				),
			);
		}
		
		wp_send_json_success( array( 'bookings' => $formatted ) );
	}
	
	/**
	 * Get available teachers for a specific date
	 */
	public function get_teachers_for_date() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		$course_id = isset( $_POST['course_id'] ) ? intval( $_POST['course_id'] ) : 0;
		
		if ( ! $date ) {
			wp_send_json_error( array( 'message' => __( 'Date is required', 'tutor-scheduling' ) ) );
		}
		
		// Get all teachers who have availability on this date
		global $wpdb;
		$availability_table = $wpdb->prefix . 'tutor_teacher_availability';
		$day_of_week = date( 'w', strtotime( $date ) );
		
		$teachers = $wpdb->get_results( $wpdb->prepare(
			"SELECT DISTINCT teacher_id FROM {$availability_table} 
			WHERE day_of_week = %d AND is_available = 1",
			$day_of_week
		) );
		
		$teacher_list = array();
		foreach ( $teachers as $teacher_row ) {
			$teacher = get_userdata( $teacher_row->teacher_id );
			if ( $teacher && tutor_utils()->is_instructor( $teacher->ID ) ) {
				// If course_id specified, check if teacher teaches this course
				if ( $course_id ) {
					$course = get_post( $course_id );
					if ( $course && $course->post_author == $teacher->ID ) {
						$availability = new Tutor_Scheduling_Availability();
						$slots = $availability->get_available_slots( $teacher->ID, $date, 60 );
						
						if ( ! empty( $slots ) ) {
							$teacher_list[] = array(
								'id' => $teacher->ID,
								'name' => $teacher->display_name,
								'slots' => $slots,
							);
						}
					}
				} else {
					// Get all courses taught by this teacher
					$teacher_courses = get_posts( array(
						'post_type' => tutor()->course_post_type,
						'author' => $teacher->ID,
						'posts_per_page' => -1,
						'post_status' => 'publish',
					) );
					
					if ( ! empty( $teacher_courses ) ) {
						$availability = new Tutor_Scheduling_Availability();
						$slots = $availability->get_available_slots( $teacher->ID, $date, 60 );
						
						if ( ! empty( $slots ) ) {
							$teacher_list[] = array(
								'id' => $teacher->ID,
								'name' => $teacher->display_name,
								'slots' => $slots,
							);
						}
					}
				}
			}
		}
		
		wp_send_json_success( array( 'teachers' => $teacher_list ) );
	}
}

