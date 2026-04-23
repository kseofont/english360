<?php
/**
 * Teacher Availability Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Availability {
	
	private $table_name;
	
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tutor_teacher_availability';
	}
	
	/**
	 * Set teacher availability for a day
	 */
	public function set_availability( $teacher_id, $day_of_week, $start_time, $end_time, $is_available = true ) {
		global $wpdb;
		
		// Check if record exists
		$existing = $wpdb->get_row( $wpdb->prepare(
			"SELECT id FROM {$this->table_name} WHERE teacher_id = %d AND day_of_week = %d",
			$teacher_id,
			$day_of_week
		) );
		
		if ( $existing ) {
			// Update existing
			return $wpdb->update(
				$this->table_name,
				array(
					'start_time' => $start_time,
					'end_time' => $end_time,
					'is_available' => $is_available ? 1 : 0,
				),
				array(
					'teacher_id' => $teacher_id,
					'day_of_week' => $day_of_week,
				),
				array( '%s', '%s', '%d' ),
				array( '%d', '%d' )
			);
		} else {
			// Insert new
			return $wpdb->insert(
				$this->table_name,
				array(
					'teacher_id' => $teacher_id,
					'day_of_week' => $day_of_week,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'is_available' => $is_available ? 1 : 0,
				),
				array( '%d', '%d', '%s', '%s', '%d' )
			);
		}
	}
	
	/**
	 * Get teacher availability
	 */
	public function get_availability( $teacher_id ) {
		global $wpdb;
		
		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE teacher_id = %d AND is_available = 1 ORDER BY day_of_week, start_time",
			$teacher_id
		) );
		
		return $results;
	}
	
	/**
	 * Get availability for a specific day
	 */
	public function get_day_availability( $teacher_id, $day_of_week ) {
		global $wpdb;
		
		return $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$this->table_name} WHERE teacher_id = %d AND day_of_week = %d AND is_available = 1",
			$teacher_id,
			$day_of_week
		) );
	}
	
	/**
	 * Check if teacher is available at a specific time
	 */
	public function is_available_at( $teacher_id, $date, $time ) {
		$day_of_week = date( 'w', strtotime( $date ) );
		$availability = $this->get_day_availability( $teacher_id, $day_of_week );
		
		if ( ! $availability ) {
			return false;
		}
		
		$time_str = date( 'H:i:s', strtotime( $time ) );
		
		return ( $time_str >= $availability->start_time && $time_str <= $availability->end_time );
	}
	
	/**
	 * Get available time slots for a teacher on a specific date
	 */
	public function get_available_slots( $teacher_id, $date, $duration = 60 ) {
		$day_of_week = date( 'w', strtotime( $date ) );
		$availability = $this->get_day_availability( $teacher_id, $day_of_week );
		
		if ( ! $availability ) {
			return array();
		}
		
		$slots = array();
		$start = strtotime( $availability->start_time );
		$end = strtotime( $availability->end_time );
		
		// Get existing bookings for this date (only approved/scheduled, not pending)
		global $wpdb;
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		$existing_bookings = $wpdb->get_results( $wpdb->prepare(
			"SELECT booking_time FROM {$bookings_table} 
			WHERE teacher_id = %d AND booking_date = %s AND status IN ('approved', 'scheduled', 'rescheduled')",
			$teacher_id,
			$date
		) );
		$booked_times = array();
		foreach ( $existing_bookings as $existing ) {
			$booked_times[] = $existing->booking_time;
		}
		
		// Generate time slots
		$current = $start;
		while ( $current + ( $duration * 60 ) <= $end ) {
			$time_slot = date( 'H:i:s', $current );
			
			// Check if this slot is already booked
			if ( ! in_array( $time_slot, $booked_times ) ) {
				$slots[] = $time_slot;
			}
			
			$current += ( $duration * 60 );
		}
		
		return $slots;
	}
}

