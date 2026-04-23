<?php
/**
 * Frontend Interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Frontend {
	
	public function __construct() {
		// Make sure Tutor is loaded first
		if ( ! function_exists( 'tutor' ) ) {
			return;
		}
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		// Use correct Tutor LMS filter hooks
		// Add to instructor nav items (for Availability) - use priority 20 like tutor-report
		add_filter( 'tutor_dashboard/instructor_nav_items', array( $this, 'add_instructor_nav_items' ), 20 );
		// Add to general nav items (for Bookings and Subscriptions)
		add_filter( 'tutor_dashboard/nav_items', array( $this, 'add_dashboard_nav_items' ), 20 );
		add_filter( 'tutor_dashboard/permalinks', array( $this, 'add_dashboard_pages' ), 20 );
		
		// Hook into Tutor's dashboard template loading system
		// This filter returns the template file path if we want to override the default template
		add_filter( 'load_dashboard_template_part_from_other_location', array( $this, 'load_dashboard_template' ), 10, 1 );
		
		// Shortcodes
		add_shortcode( 'tutor_teacher_availability', array( $this, 'shortcode_availability' ) );
		add_shortcode( 'tutor_book_lesson', array( $this, 'shortcode_book_lesson' ) );
		add_shortcode( 'tutor_my_subscriptions', array( $this, 'shortcode_my_subscriptions' ) );
		add_shortcode( 'tutor_purchase_subscription', array( $this, 'shortcode_purchase_subscription' ) );
		
		// Register helper functions for subscription products
		$this->register_subscription_helper_functions();
		
		// Handle add to cart redirect to checkout for subscription products
		add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'redirect_subscription_to_checkout' ), 10, 1 );
		add_action( 'template_redirect', array( $this, 'handle_add_to_cart_redirect' ) );
		
		// Use custom cart page (cart-2)
		add_filter( 'woocommerce_get_cart_url', array( $this, 'get_custom_cart_url' ), 10, 1 );
		
		// Integrate with Tutor Calendar - hook into the response before it's sent
		// Use output buffering to intercept and modify the JSON response
		add_action( 'wp_ajax_get_calendar_materials', array( $this, 'intercept_calendar_ajax' ), 1 );
		add_action( 'wp_ajax_nopriv_get_calendar_materials', array( $this, 'intercept_calendar_ajax' ), 1 );
		add_action( 'wp_ajax_tutor_scheduling_get_calendar_bookings', array( $this, 'ajax_get_calendar_bookings' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_booking_details', array( $this, 'ajax_get_booking_details' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_available_teachers', array( $this, 'ajax_get_available_teachers' ) );
		add_action( 'wp_ajax_tutor_scheduling_get_available_slots', array( $this, 'ajax_get_available_slots' ) );
		add_action( 'wp_ajax_tutor_scheduling_save_google_meet', array( $this, 'ajax_save_google_meet' ) );
		add_action( 'wp_ajax_tutor_scheduling_approve_booking', array( $this, 'ajax_approve_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_reject_booking', array( $this, 'ajax_reject_booking' ) );
		add_action( 'wp_ajax_tutor_scheduling_book_from_calendar', array( $this, 'ajax_book_from_calendar' ) );
	}
	
	/**
	 * Modify calendar JSON response to include bookings
	 * This filters wp_send_json_success to add our bookings to Tutor Calendar's response
	 */
	public function modify_calendar_json_response( $data, $status_code = null ) {
		// Check if this is calendar materials response
		if ( ! isset( $_POST['action'] ) || $_POST['action'] !== 'get_calendar_materials' ) {
			return $data;
		}
		
		if ( ! isset( $data['data'] ) || ! isset( $data['data']['response'] ) ) {
			return $data;
		}
		
		// Get month and year from request
		$month = isset( $_POST['month'] ) ? intval( $_POST['month'] ) + 1 : date( 'n' );
		$year = isset( $_POST['year'] ) ? intval( $_POST['year'] ) : date( 'Y' );
		
		// Get bookings for current user
		global $wpdb;
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return $data;
		}
		
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		$bookings = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$bookings_table} 
			WHERE (student_id = %d OR teacher_id = %d) 
			AND status IN ('scheduled', 'rescheduled')
			AND YEAR(booking_date) = %d
			AND MONTH(booking_date) = %d
			ORDER BY booking_date, booking_time",
			$user_id,
			$user_id,
			$year,
			$month
		) );
		
		if ( ! empty( $bookings ) ) {
			foreach ( $bookings as $booking ) {
				// Format exactly like Tutor Calendar expects (matching the format from Tutor_Calendar.php)
				// Tutor Calendar expects objects with specific properties matching post objects
				$event = new stdClass();
				$event->ID = 'booking_' . $booking->id;
				$event->post_date = $booking->booking_date;
				$event->post_title = $this->get_booking_title( $booking, $user_id );
				$event->post_content = '';
				$event->post_type = 'tutor_scheduling_booking';
				$event->post_parent = $booking->course_id;
				$event->guid = '#'; // Will be used for click handler
				$event->month = date( 'm', strtotime( $booking->booking_date ) );
				$event->created_at = $booking->booking_date;
				
				// Meta info in Tutor Calendar format (similar to Google Meet format)
				// Tutor Calendar uses expire_date and is_expired for display logic
				// Store booking_id in meta_info for JavaScript access
				$booking_datetime = $booking->booking_date . ' ' . $booking->booking_time;
				$is_expired = strtotime( $booking_datetime ) < time();
				
				$event->meta_info = array(
					'booking_id' => $booking->id,
					'booking_date' => $booking->booking_date,
					'booking_time' => $booking->booking_time,
					'expire_date' => $booking_datetime,
					'is_expired' => $is_expired,
				);
				
				// Add to response if month matches (Tutor Calendar filters by month)
				if ( $event->month == sprintf( '%02d', $month ) ) {
					$data['data']['response'][] = $event;
					
					// Update overdue/upcoming counts
					if ( $is_expired ) {
						$data['data']['overdue'] = isset( $data['data']['overdue'] ) ? intval( $data['data']['overdue'] ) + 1 : 1;
					} else {
						$data['data']['upcoming'] = isset( $data['data']['upcoming'] ) ? intval( $data['data']['upcoming'] ) + 1 : 1;
					}
				}
			}
		}
		
		return $data;
	}
	
	/**
	 * AJAX: Get calendar bookings for a month/year
	 */
	public function ajax_get_calendar_bookings() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$month = isset( $_POST['month'] ) ? intval( $_POST['month'] ) : date( 'n' );
		$year = isset( $_POST['year'] ) ? intval( $_POST['year'] ) : date( 'Y' );
		
		global $wpdb;
		$user_id = get_current_user_id();
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		
		// Get bookings for the user (as student or teacher)
		$bookings = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$bookings_table} 
			WHERE (student_id = %d OR teacher_id = %d) 
			AND status IN ('scheduled', 'rescheduled')
			AND YEAR(booking_date) = %d
			AND MONTH(booking_date) = %d
			ORDER BY booking_date, booking_time",
			$user_id,
			$user_id,
			$year,
			$month
		) );
		
		// Format events exactly like Tutor Calendar expects
		$events = array();
		foreach ( $bookings as $booking ) {
			$event = new stdClass();
			$event->ID = 'booking_' . $booking->id;
			$event->post_date = $booking->booking_date;
			$event->post_title = $this->get_booking_title( $booking, $user_id );
			$event->post_content = '';
			$event->post_type = 'tutor_scheduling_booking';
			$event->post_parent = $booking->course_id;
			$event->guid = '#';
			$event->month = date( 'm', strtotime( $booking->booking_date ) );
			$event->created_at = $booking->booking_date;
			
			// Meta info in Tutor Calendar format (matching the format used by Google Meet)
			$booking_datetime = $booking->booking_date . ' ' . $booking->booking_time;
			$event->meta_info = array(
				'booking_id' => $booking->id,
				'booking_date' => $booking->booking_date,
				'booking_time' => $booking->booking_time,
				'expire_date' => $booking_datetime,
				'is_expired' => strtotime( $booking_datetime ) < time(),
			);
			
			// Add fields that Tutor Calendar React component expects
			// Based on how it processes events (see Calendar.js line 727)
			// For tutor_scheduling_booking post_type, we need to provide expire_date or unlock_date
			if ( ! isset( $event->meta_info['expire_date'] ) || empty( $event->meta_info['expire_date'] ) ) {
				$event->meta_info['expire_date'] = $booking_datetime;
			}
			
			$events[] = $event;
		}
		
		wp_send_json_success( array( 'events' => $events ) );
	}
	
	/**
	 * Get custom cart URL (cart-2)
	 */
	public function get_custom_cart_url( $cart_url ) {
		// Try to find page with slug 'cart-2'
		$cart_page = get_page_by_path( 'cart-2' );
		if ( $cart_page ) {
			return get_permalink( $cart_page->ID );
		}
		
		// Fallback to default
		return $cart_url;
	}
	
	/**
	 * Add bookings to Tutor Calendar (legacy filter method - not used, kept for compatibility)
	 */
	public function add_bookings_to_calendar( $data, $month = 0, $year = 0 ) {
		global $wpdb;
		
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return $data;
		}
		
		// Get month and year from request if not provided
		if ( ! $month || ! $year ) {
			$month = isset( $_POST['month'] ) ? intval( $_POST['month'] ) : date( 'n' );
			$year = isset( $_POST['year'] ) ? intval( $_POST['year'] ) : date( 'Y' );
		}
		
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		
		// Get bookings for the user (as student or teacher)
		$bookings = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$bookings_table} 
			WHERE (student_id = %d OR teacher_id = %d) 
			AND status IN ('scheduled', 'rescheduled')
			AND YEAR(booking_date) = %d
			AND MONTH(booking_date) = %d
			ORDER BY booking_date, booking_time",
			$user_id,
			$user_id,
			$year,
			$month
		) );
		
		if ( ! empty( $bookings ) && isset( $data['response'] ) ) {
			foreach ( $bookings as $booking_item ) {
				// Format as calendar event
				$event = new stdClass();
				$event->ID = 'booking_' . $booking_item->id;
				$event->post_date = $booking_item->booking_date . ' ' . $booking_item->booking_time;
				$event->post_title = $this->get_booking_title( $booking_item, $user_id );
				$event->post_content = '';
				$event->post_type = 'tutor_scheduling_booking';
				$event->post_parent = $booking_item->course_id;
				$event->guid = '#';
				$event->month = date( 'm', strtotime( $booking_item->booking_date ) );
				$event->created_at = $booking_item->booking_date;
				
				// Meta info for calendar display
				$event->meta_info = array(
					'booking_id' => $booking_item->id,
					'booking_date' => $booking_item->booking_date,
					'booking_time' => $booking_item->booking_time,
					'is_expired' => strtotime( $booking_item->booking_date . ' ' . $booking_item->booking_time ) < time(),
				);
				
				$data['response'][] = $event;
			}
		}
		
		return $data;
	}
	
	/**
	 * Get booking title for calendar
	 */
	private function get_booking_title( $booking, $user_id ) {
		if ( $booking->student_id == $user_id ) {
			// Student view
			$teacher = get_userdata( $booking->teacher_id );
			$course = get_post( $booking->course_id );
			return sprintf( __( 'Lesson with %s - %s', 'tutor-scheduling' ), 
				$teacher->display_name,
				$course->post_title
			);
		} else {
			// Teacher view
			$student = get_userdata( $booking->student_id );
			$course = get_post( $booking->course_id );
			return sprintf( __( 'Lesson with %s - %s', 'tutor-scheduling' ), 
				$student->display_name,
				$course->post_title
			);
		}
	}
	
	/**
	 * AJAX: Get booking details for modal
	 */
	public function ajax_get_booking_details() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		if ( ! $booking_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid booking ID', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$booking_data = $booking->get_booking( $booking_id );
		
		if ( ! $booking_data ) {
			wp_send_json_error( array( 'message' => __( 'Booking not found', 'tutor-scheduling' ) ) );
		}
		
		// Check permission
		$user_id = get_current_user_id();
		if ( $booking_data->student_id != $user_id && $booking_data->teacher_id != $user_id && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		// Get related data
		$student = get_userdata( $booking_data->student_id );
		$teacher = get_userdata( $booking_data->teacher_id );
		$course = get_post( $booking_data->course_id );
		$lesson = $booking_data->lesson_id ? get_post( $booking_data->lesson_id ) : null;
		
		wp_send_json_success( array(
			'booking' => array(
				'id' => $booking_data->id,
				'date' => $booking_data->booking_date,
				'time' => $booking_data->booking_time,
				'duration' => $booking_data->duration,
				'status' => $booking_data->status,
				'google_meet_link' => $booking_data->google_meet_link,
				'notes' => $booking_data->notes,
			),
			'student' => array(
				'id' => $student->ID,
				'name' => $student->display_name,
				'email' => $student->user_email,
			),
			'teacher' => array(
				'id' => $teacher->ID,
				'name' => $teacher->display_name,
				'email' => $teacher->user_email,
			),
			'course' => array(
				'id' => $course->ID,
				'title' => $course->post_title,
			),
			'lesson' => $lesson ? array(
				'id' => $lesson->ID,
				'title' => $lesson->post_title,
			) : null,
		) );
	}
	
	/**
	 * AJAX: Get available teachers for a date (for calendar booking)
	 */
	public function ajax_get_available_teachers() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		$course_id = isset( $_POST['course_id'] ) ? intval( $_POST['course_id'] ) : 0;
		
		if ( ! $date ) {
			wp_send_json_error( array( 'message' => __( 'Date is required', 'tutor-scheduling' ) ) );
		}
		
		// Get day of week
		$day_of_week = date( 'w', strtotime( $date ) );
		
		// Get teachers who have availability on this day
		global $wpdb;
		$availability_table = $wpdb->prefix . 'tutor_teacher_availability';
		
		$teachers = $wpdb->get_results( $wpdb->prepare(
			"SELECT DISTINCT teacher_id FROM {$availability_table} 
			WHERE day_of_week = %d AND is_available = 1",
			$day_of_week
		) );
		
		$teacher_list = array();
		$availability = new Tutor_Scheduling_Availability();
		
		foreach ( $teachers as $teacher_row ) {
			$teacher = get_userdata( $teacher_row->teacher_id );
			if ( $teacher && tutor_utils()->is_instructor( $teacher->ID ) ) {
				// Get available slots for this teacher on this date
				$slots = $availability->get_available_slots( $teacher->ID, $date, 60 );
				
				if ( ! empty( $slots ) ) {
					// If course_id specified, check if teacher teaches this course
					if ( $course_id ) {
						$course = get_post( $course_id );
						if ( $course && $course->post_author == $teacher->ID ) {
							$teacher_list[] = array(
								'id' => $teacher->ID,
								'name' => $teacher->display_name,
								'slots' => $slots,
							);
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
							$teacher_list[] = array(
								'id' => $teacher->ID,
								'name' => $teacher->display_name,
								'slots' => $slots,
								'courses' => array_map( function( $c ) {
									return array( 'id' => $c->ID, 'title' => $c->post_title );
								}, $teacher_courses ),
							);
						}
					}
				}
			}
		}
		
		wp_send_json_success( array( 'teachers' => $teacher_list ) );
	}
	
	/**
	 * AJAX: Get available time slots for a teacher on a date
	 */
	public function ajax_get_available_slots() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$teacher_id = isset( $_POST['teacher_id'] ) ? intval( $_POST['teacher_id'] ) : 0;
		$date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		
		if ( ! $teacher_id || ! $date ) {
			wp_send_json_error( array( 'message' => __( 'Invalid parameters', 'tutor-scheduling' ) ) );
		}
		
		$availability = new Tutor_Scheduling_Availability();
		$slots = $availability->get_available_slots( $teacher_id, $date, 60 );
		
		wp_send_json_success( array( 'slots' => $slots ) );
	}
	
	/**
	 * AJAX: Book lesson from calendar (student clicks on date)
	 */
	public function ajax_book_from_calendar() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => __( 'Please log in to book a lesson', 'tutor-scheduling' ) ) );
		}
		
		$student_id = get_current_user_id();
		$teacher_id = isset( $_POST['teacher_id'] ) ? intval( $_POST['teacher_id'] ) : 0;
		$course_id = isset( $_POST['course_id'] ) ? intval( $_POST['course_id'] ) : 0;
		$booking_date = isset( $_POST['booking_date'] ) ? sanitize_text_field( $_POST['booking_date'] ) : '';
		$booking_time = isset( $_POST['booking_time'] ) ? sanitize_text_field( $_POST['booking_time'] ) : '';
		$subscription_id = isset( $_POST['subscription_id'] ) && $_POST['subscription_id'] !== '' && $_POST['subscription_id'] !== '0' ? intval( $_POST['subscription_id'] ) : null;
		
		if ( ! $teacher_id || ! $course_id || ! $booking_date || ! $booking_time ) {
			wp_send_json_error( array( 'message' => __( 'Missing required fields', 'tutor-scheduling' ) ) );
		}
		
		// Log for debugging
		error_log( 'Tutor Scheduling: Creating booking - Student: ' . $student_id . ', Teacher: ' . $teacher_id . ', Course: ' . $course_id . ', Date: ' . $booking_date . ', Time: ' . $booking_time . ', Subscription: ' . $subscription_id );
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$result = $booking->create_booking( array(
			'student_id' => $student_id,
			'teacher_id' => $teacher_id,
			'course_id' => $course_id,
			'booking_date' => $booking_date,
			'booking_time' => $booking_time,
			'subscription_id' => $subscription_id,
			'status' => 'pending', // Needs teacher approval
		) );
		
		if ( is_wp_error( $result ) ) {
			error_log( 'Tutor Scheduling: Booking error - ' . $result->get_error_message() );
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			error_log( 'Tutor Scheduling: Booking created successfully - ID: ' . $result );
			wp_send_json_success( array( 
				'message' => __( 'Booking request sent! Waiting for teacher approval.', 'tutor-scheduling' ),
				'booking_id' => $result
			) );
		} else {
			error_log( 'Tutor Scheduling: Booking creation returned false' );
			wp_send_json_error( array( 'message' => __( 'Failed to create booking. Please check if you have available lessons in your subscription.', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * AJAX: Approve booking (teacher)
	 */
	public function ajax_approve_booking() {
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
		$result = $booking->approve_booking( $booking_id, $user_id );
		
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		} elseif ( $result ) {
			wp_send_json_success( array( 'message' => __( 'Booking approved successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to approve booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * AJAX: Reject booking (teacher)
	 */
	public function ajax_reject_booking() {
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
		$booking_data = $booking->get_booking( $booking_id );
		
		if ( ! $booking_data ) {
			wp_send_json_error( array( 'message' => __( 'Booking not found', 'tutor-scheduling' ) ) );
		}
		
		// Check permission
		if ( $booking_data->teacher_id != $user_id && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		// Update booking status to rejected
		global $wpdb;
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		$result = $wpdb->update(
			$bookings_table,
			array( 'status' => 'rejected' ),
			array( 'id' => $booking_id ),
			array( '%s' ),
			array( '%d' )
		);
		
		if ( $result !== false ) {
			// Restore lesson to subscription if applicable
			if ( $booking_data->subscription_id ) {
				$subscription_tracker = new Tutor_Scheduling_Subscription_Tracker();
				$subscription_tracker->restore_lesson( $booking_data->student_id, $booking_data->subscription_id, $booking_id );
			}
			
			wp_send_json_success( array( 'message' => __( 'Booking rejected', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to reject booking', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * AJAX: Save Google Meet link for a booking
	 */
	public function ajax_save_google_meet() {
		check_ajax_referer( 'tutor_scheduling_nonce', 'nonce' );
		
		$booking_id = isset( $_POST['booking_id'] ) ? intval( $_POST['booking_id'] ) : 0;
		$google_meet_link = isset( $_POST['google_meet_link'] ) ? esc_url_raw( $_POST['google_meet_link'] ) : '';
		
		if ( ! $booking_id ) {
			wp_send_json_error( array( 'message' => __( 'Invalid booking ID', 'tutor-scheduling' ) ) );
		}
		
		$booking = new Tutor_Scheduling_Lesson_Booking();
		$booking_data = $booking->get_booking( $booking_id );
		
		if ( ! $booking_data ) {
			wp_send_json_error( array( 'message' => __( 'Booking not found', 'tutor-scheduling' ) ) );
		}
		
		// Check permission - only teacher or admin can add Google Meet link
		$user_id = get_current_user_id();
		if ( $booking_data->teacher_id != $user_id && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied', 'tutor-scheduling' ) ) );
		}
		
		// Update booking with Google Meet link
		global $wpdb;
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		$result = $wpdb->update(
			$bookings_table,
			array( 'google_meet_link' => $google_meet_link ),
			array( 'id' => $booking_id ),
			array( '%s' ),
			array( '%d' )
		);
		
		if ( $result !== false ) {
			wp_send_json_success( array( 'message' => __( 'Google Meet link saved successfully', 'tutor-scheduling' ) ) );
		} else {
			wp_send_json_error( array( 'message' => __( 'Failed to save Google Meet link', 'tutor-scheduling' ) ) );
		}
	}
	
	/**
	 * Redirect subscription products to cart after adding to cart
	 */
	public function redirect_subscription_to_checkout( $url ) {
		// Check if we're adding a subscription product from purchase subscription page
		if ( isset( $_REQUEST['add-to-cart'] ) && is_numeric( $_REQUEST['add-to-cart'] ) ) {
			// Check if coming from purchase subscription page
			$from_purchase_page = isset( $_REQUEST['from_purchase_page'] ) || 
			                      ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], 'purchase-subscription' ) !== false );
			
			if ( $from_purchase_page ) {
				$product_id = absint( $_REQUEST['add-to-cart'] );
				$product = wc_get_product( $product_id );
				
				if ( $product ) {
					// Check if it's a subscription product (has _tutor_total_lessons or is a subscription type)
					$total_lessons = $product->get_meta( '_tutor_total_lessons' );
					$is_subscription = false;
					
					if ( $total_lessons ) {
						$is_subscription = true;
					} elseif ( class_exists( 'WC_Subscriptions' ) && $product->is_type( 'subscription' ) ) {
						$is_subscription = true;
					}
					
					if ( $is_subscription ) {
						// Redirect to custom cart page (cart-2)
						$cart_page = get_page_by_path( 'cart-2' );
						if ( $cart_page ) {
							return get_permalink( $cart_page->ID );
						}
						// Fallback to default cart
						return wc_get_cart_url();
					}
				}
			}
		}
		
		return $url;
	}
	
	/**
	 * Handle add to cart redirect when coming from purchase subscription page
	 * This ensures subscription products go to cart page
	 */
	public function handle_add_to_cart_redirect() {
		// Only handle if we're processing add-to-cart from our purchase page
		if ( ! isset( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) ) {
			return;
		}
		
		// Check if coming from purchase subscription page
		$from_purchase_page = isset( $_REQUEST['from_purchase_page'] ) || 
		                      ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], 'purchase-subscription' ) !== false );
		
		if ( $from_purchase_page && class_exists( 'WooCommerce' ) && WC()->cart ) {
			$product_id = absint( $_REQUEST['add-to-cart'] );
			$product = wc_get_product( $product_id );
			
			if ( $product ) {
				// Check if it's a subscription product
				$total_lessons = $product->get_meta( '_tutor_total_lessons' );
				$is_subscription = false;
				
				if ( $total_lessons ) {
					$is_subscription = true;
				} elseif ( class_exists( 'WC_Subscriptions' ) && $product->is_type( 'subscription' ) ) {
					$is_subscription = true;
				}
				
				if ( $is_subscription ) {
					// WooCommerce should have already added it to cart via the form handler
					// Redirect to custom cart page (cart-2)
					$cart_page = get_page_by_path( 'cart-2' );
					if ( $cart_page ) {
						wp_safe_redirect( get_permalink( $cart_page->ID ) );
					} else {
						wp_safe_redirect( wc_get_cart_url() );
					}
					exit;
				}
			}
		}
	}
	
	/**
	 * Register helper functions for subscription products
	 */
	private function register_subscription_helper_functions() {
		if ( ! function_exists( 'tutor_scheduling_get_subscription_products' ) ) {
			function tutor_scheduling_get_subscription_products() {
				if ( ! class_exists( 'WooCommerce' ) ) {
					return array();
				}
				
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => '_tutor_total_lessons',
							'value' => '',
							'compare' => '!=',
						),
						array(
							'key' => '_subscription_period',
							'value' => '',
							'compare' => '!=',
						),
					),
				);
				
				$products = get_posts( $args );
				$product_objects = array();
				
				foreach ( $products as $product_post ) {
					$product = wc_get_product( $product_post->ID );
					if ( $product && $product->is_purchasable() ) {
						$product_objects[] = $product;
					}
				}
				
				return $product_objects;
			}
		}
		
		if ( ! function_exists( 'tutor_scheduling_get_product_subscription_type' ) ) {
			function tutor_scheduling_get_product_subscription_type( $product ) {
				// Check if it's a WooCommerce Subscription product
				if ( class_exists( 'WC_Subscriptions' ) && $product->is_type( 'subscription' ) ) {
					$period = $product->get_meta( '_subscription_period' );
					if ( $period === 'month' ) {
						return 'monthly';
					} elseif ( $period === 'year' ) {
						return 'yearly';
					}
				}
				
				// Check if it's a lesson package (has _tutor_total_lessons)
				$total_lessons = $product->get_meta( '_tutor_total_lessons' );
				if ( $total_lessons ) {
					return 'lesson_package';
				}
				
				return 'other';
			}
		}
		
		if ( ! function_exists( 'tutor_scheduling_render_subscription_product_card' ) ) {
			function tutor_scheduling_render_subscription_product_card( $product ) {
				$product_id = $product->get_id();
				$product_name = $product->get_name();
				$product_price = $product->get_price_html();
				$product_url = $product->get_permalink();
				$total_lessons = $product->get_meta( '_tutor_total_lessons' );
				$product_type = tutor_scheduling_get_product_subscription_type( $product );
				
				// Determine if featured (most popular)
				$is_featured = false;
				if ( $product_type === 'lesson_package' && $total_lessons == 10 ) {
					$is_featured = true;
				} elseif ( $product_type === 'monthly' ) {
					$is_featured = true;
				}
				?>
				<div class="product-card <?php echo $is_featured ? 'featured' : ''; ?>">
					<div class="product-title"><?php echo esc_html( $product_name ); ?></div>
					
					<div class="product-price">
						<?php echo $product_price; ?>
						<?php if ( $product_type === 'monthly' ) : ?>
							<span class="period">/ <?php esc_html_e( 'month', 'tutor-scheduling' ); ?></span>
						<?php elseif ( $product_type === 'yearly' ) : ?>
							<span class="period">/ <?php esc_html_e( 'year', 'tutor-scheduling' ); ?></span>
						<?php endif; ?>
					</div>
					
					<?php if ( $total_lessons ) : ?>
						<div class="product-lessons">
							<strong><?php echo esc_html( $total_lessons ); ?></strong> <?php esc_html_e( 'lessons included', 'tutor-scheduling' ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $product->get_short_description() ) : ?>
						<div class="product-description">
							<?php echo wp_kses_post( $product->get_short_description() ); ?>
						</div>
					<?php endif; ?>
					
					<div class="product-button">
						<?php
						// Create add to cart URL - WooCommerce will handle adding to cart
						// We use a filter to redirect to checkout after adding
						$add_to_cart_url = add_query_arg( array(
							'add-to-cart' => $product_id,
							'quantity' => 1,
						), wc_get_page_permalink( 'shop' ) ?: home_url() );
						
						// Add a marker so we know it's from purchase subscription page
						$add_to_cart_url = add_query_arg( 'from_purchase_page', '1', $add_to_cart_url );
						?>
						<a href="<?php echo esc_url( $add_to_cart_url ); ?>" class="tutor-btn tutor-btn-primary add-to-cart-button" data-product-id="<?php echo esc_attr( $product_id ); ?>">
							<?php esc_html_e( 'Purchase', 'tutor-scheduling' ); ?>
						</a>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/**
	 * Enqueue frontend scripts
	 */
	public function enqueue_scripts() {
		// Always enqueue on dashboard pages (Tutor dashboard)
		// Also enqueue on pages with our shortcodes
		$is_dashboard = $this->is_tutor_dashboard();
		$has_shortcode = $this->has_scheduling_shortcode();
		
		if ( ! is_admin() && ( $is_dashboard || $has_shortcode ) ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-ui-datepicker' );
			
			wp_enqueue_script(
				'tutor-scheduling-frontend',
				TUTOR_SCHEDULING_URL . 'assets/js/frontend.js',
				array( 'jquery' ),
				TUTOR_SCHEDULING_VERSION,
				true
			);
			
			// Enqueue calendar integration script if on calendar page or any dashboard page (for modal functionality)
			// Always load on dashboard pages so modal works everywhere
			if ( $is_dashboard ) {
				wp_enqueue_script(
					'tutor-scheduling-calendar',
					TUTOR_SCHEDULING_URL . 'assets/js/calendar-integration.js',
					array( 'jquery' ),
					TUTOR_SCHEDULING_VERSION,
					true
				);
			}
			
			// Enqueue styles with lower priority to not override Tutor's styles
			wp_enqueue_style(
				'tutor-scheduling-frontend',
				TUTOR_SCHEDULING_URL . 'assets/css/frontend.css',
				array(),
				TUTOR_SCHEDULING_VERSION
			);
			
			// Add inline style to ensure our styles don't conflict
			wp_add_inline_style( 'tutor-scheduling-frontend', '
				.tutor-dashboard-content-wrap .tutor-scheduling-availability,
				.tutor-dashboard-content-wrap .tutor-scheduling-bookings,
				.tutor-dashboard-content-wrap .tutor-scheduling-subscriptions {
					background: transparent;
				}
			' );
			
			// Enqueue calendar booking script
			wp_enqueue_script(
				'tutor-scheduling-calendar-booking',
				TUTOR_SCHEDULING_URL . 'assets/js/calendar-booking.js',
				array( 'jquery' ),
				TUTOR_SCHEDULING_VERSION,
				true
			);
			
			// Enqueue Tutor Calendar integration script
			wp_enqueue_script(
				'tutor-scheduling-calendar-integration',
				TUTOR_SCHEDULING_URL . 'assets/js/calendar-integration-tutor.js',
				array( 'jquery' ),
				TUTOR_SCHEDULING_VERSION,
				true
			);
			
			// Localize script for AJAX
			wp_localize_script( 'tutor-scheduling-frontend', 'tutorScheduling', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'tutor_scheduling_nonce' ),
				'currentUserId' => get_current_user_id(),
				'userRole' => current_user_can( 'tutor_instructor' ) ? 'tutor_instructor' : 'student',
				'strings' => array(
					'booking_success' => __( 'Booking created successfully!', 'tutor-scheduling' ),
					'booking_error' => __( 'Failed to create booking', 'tutor-scheduling' ),
					'cancel_success' => __( 'Booking cancelled successfully', 'tutor-scheduling' ),
					'reschedule_success' => __( 'Booking rescheduled successfully', 'tutor-scheduling' ),
				),
			) );
			
			// Also localize for calendar booking script
			wp_localize_script( 'tutor-scheduling-calendar-booking', 'tutorScheduling', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'tutor_scheduling_nonce' ),
				'currentUserId' => get_current_user_id(),
				'userRole' => current_user_can( 'tutor_instructor' ) ? 'tutor_instructor' : 'student',
			) );
		}
	}
	
	/**
	 * Add instructor nav items (for Availability)
	 */
	public function add_instructor_nav_items( $nav_items ) {
		// Add availability menu in instructor section
		// Note: auth_cap is required for Tutor to show this menu item to instructors
		// Using same pattern as Tutor Pro addons (Google Meet, Zoom, etc.)
		$nav_items['availability'] = array(
			'title'    => __( 'Availability', 'tutor-scheduling' ),
			'icon'     => 'tutor-icon-gear', // Using gear icon (definitely exists) - can change to calendar later
			'auth_cap' => tutor()->instructor_role,
		);
		
		// Debug: Log if WP_DEBUG is enabled
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'Tutor Scheduling: Adding availability menu item. Instructor role: ' . tutor()->instructor_role );
			error_log( 'Tutor Scheduling: Current user can instructor role: ' . ( current_user_can( tutor()->instructor_role ) ? 'yes' : 'no' ) );
		}
		
		return $nav_items;
	}
	
	/**
	 * Add dashboard nav items (for all users)
	 */
	public function add_dashboard_nav_items( $nav_items ) {
		// Add bookings menu for all users
		$nav_items['bookings'] = array(
			'title' => __( 'My Bookings', 'tutor-scheduling' ),
			'icon'  => 'tutor-icon-calendar-line',
		);
		
		// Add pending bookings menu for instructors
		if ( current_user_can( 'tutor_instructor' ) ) {
			$nav_items['pending-bookings'] = array(
				'title' => __( 'Pending Bookings', 'tutor-scheduling' ),
				'icon'  => 'tutor-icon-clock',
				'auth_cap' => tutor()->instructor_role,
			);
		}
		
		// Add subscriptions menu for all users
		$nav_items['subscriptions'] = array(
			'title' => __( 'Subscriptions', 'tutor-scheduling' ),
			'icon'  => 'tutor-icon-cart-bold',
		);
		
		return $nav_items;
	}
	
	/**
	 * Add dashboard pages
	 */
	public function add_dashboard_pages( $pages ) {
		$pages['availability'] = array(
			'title'         => __( 'Set Availability', 'tutor-scheduling' ),
			'login_require' => true,
		);
		
		$pages['bookings'] = array(
			'title'         => __( 'My Bookings', 'tutor-scheduling' ),
			'login_require' => true,
		);
		
		$pages['subscriptions'] = array(
			'title'         => __( 'My Subscriptions', 'tutor-scheduling' ),
			'login_require' => true,
		);
		
		$pages['purchase-subscription'] = array(
			'title'         => __( 'Purchase Subscription', 'tutor-scheduling' ),
			'login_require' => true,
		);
		
		$pages['pending-bookings'] = array(
			'title'         => __( 'Pending Bookings', 'tutor-scheduling' ),
			'login_require' => true,
		);
		
		return $pages;
	}
	
	/**
	 * Load dashboard template for our custom pages (Filter version)
	 */
	public function load_dashboard_template( $template_path ) {
		global $wp_query;
		
		// Try multiple ways to get the dashboard page name
		$dashboard_page = '';
		
		// Method 1: From query_vars (standard way)
		if ( isset( $wp_query->query_vars['tutor_dashboard_page'] ) ) {
			$dashboard_page = $wp_query->query_vars['tutor_dashboard_page'];
		}
		
		// Method 2: From get_query_var (fallback)
		if ( empty( $dashboard_page ) ) {
			$dashboard_page = get_query_var( 'tutor_dashboard_page' );
		}
		
		// Method 3: From URL path (last resort)
		if ( empty( $dashboard_page ) ) {
			global $wp;
			$request = trim( $wp->request, '/' );
			$parts = explode( '/', $request );
			// Get dashboard page slug from Tutor settings
			$dashboard_page_id = (int) tutor_utils()->get_option( 'tutor_dashboard_page_id' );
			if ( $dashboard_page_id ) {
				$dashboard_page_slug = get_post_field( 'post_name', $dashboard_page_id );
				// Find the dashboard page slug in URL and get the next part
				$slug_index = array_search( $dashboard_page_slug, $parts );
				if ( $slug_index !== false && isset( $parts[ $slug_index + 1 ] ) ) {
					$dashboard_page = $parts[ $slug_index + 1 ];
				}
			}
		}
		
		// Debug logging
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'Tutor Scheduling: load_dashboard_template called. Page: ' . $dashboard_page . ', Current path: ' . $template_path );
			error_log( 'Tutor Scheduling: Query vars: ' . print_r( $wp_query->query_vars, true ) );
		}
		
		// Check if it's one of our pages
		if ( in_array( $dashboard_page, array( 'availability', 'bookings', 'subscriptions', 'purchase-subscription', 'pending-bookings' ) ) ) {
			$template_file = TUTOR_SCHEDULING_DIR . 'templates/dashboard-' . $dashboard_page . '.php';
			
			// Verify file exists
			if ( file_exists( $template_file ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( 'Tutor Scheduling: Returning template: ' . $template_file );
				}
				// Return our template path - Tutor will include it
				return $template_file;
			} else {
				// File doesn't exist, log error
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( 'Tutor Scheduling: Template file not found: ' . $template_file );
				}
			}
		}
		
		return $template_path;
	}
	
	
	/**
	 * Dashboard availability page
	 */
	public function dashboard_availability_page() {
		include TUTOR_SCHEDULING_DIR . 'views/dashboard-availability.php';
	}
	
	/**
	 * Dashboard bookings page
	 */
	public function dashboard_bookings_page() {
		include TUTOR_SCHEDULING_DIR . 'views/dashboard-bookings.php';
	}
	
	/**
	 * Dashboard subscriptions page
	 */
	public function dashboard_subscriptions_page() {
		include TUTOR_SCHEDULING_DIR . 'views/dashboard-subscriptions.php';
	}
	
	/**
	 * Shortcode: Teacher availability
	 */
	public function shortcode_availability( $atts ) {
		$atts = shortcode_atts( array(
			'teacher_id' => get_current_user_id(),
		), $atts );
		
		ob_start();
		include TUTOR_SCHEDULING_DIR . 'views/shortcode-availability.php';
		return ob_get_clean();
	}
	
	/**
	 * Shortcode: Book lesson
	 */
	public function shortcode_book_lesson( $atts ) {
		$atts = shortcode_atts( array(
			'teacher_id' => 0,
			'course_id' => 0,
		), $atts );
		
		ob_start();
		include TUTOR_SCHEDULING_DIR . 'views/shortcode-book-lesson.php';
		return ob_get_clean();
	}
	
	/**
	 * Shortcode: My subscriptions
	 */
	public function shortcode_my_subscriptions( $atts ) {
		ob_start();
		include TUTOR_SCHEDULING_DIR . 'views/shortcode-subscriptions.php';
		return ob_get_clean();
	}
	
	/**
	 * Shortcode: Purchase subscription
	 */
	public function shortcode_purchase_subscription( $atts ) {
		ob_start();
		include TUTOR_SCHEDULING_DIR . 'views/shortcode-purchase-subscription.php';
		return ob_get_clean();
	}
	
	/**
	 * Check if current page is Tutor dashboard
	 */
	private function is_tutor_dashboard() {
		global $wp_query;
		return isset( $wp_query->query_vars['tutor_dashboard_page'] );
	}
	
	/**
	 * Check if current page has our shortcodes
	 */
	private function has_scheduling_shortcode() {
		global $post;
		if ( ! $post ) {
			return false;
		}
		
		$shortcodes = array(
			'tutor_teacher_availability',
			'tutor_book_lesson',
			'tutor_my_subscriptions',
		);
		
		foreach ( $shortcodes as $shortcode ) {
			if ( has_shortcode( $post->post_content, $shortcode ) ) {
				return true;
			}
		}
		
		return false;
	}
}

