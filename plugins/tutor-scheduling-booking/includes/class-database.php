<?php
/**
 * Database operations for Tutor Scheduling & Booking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Database {
	
	/**
	 * Create database tables
	 */
	public static function create_tables() {
		global $wpdb;
		
		$charset_collate = $wpdb->get_charset_collate();
		
		// Teacher availability table
		$table_availability = $wpdb->prefix . 'tutor_teacher_availability';
		$sql_availability = "CREATE TABLE IF NOT EXISTS $table_availability (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			teacher_id bigint(20) UNSIGNED NOT NULL,
			day_of_week tinyint(1) NOT NULL COMMENT '0=Sunday, 1=Monday, etc.',
			start_time time NOT NULL,
			end_time time NOT NULL,
			is_available tinyint(1) DEFAULT 1,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY teacher_id (teacher_id),
			KEY day_of_week (day_of_week)
		) $charset_collate;";
		
		// Bookings table
		$table_bookings = $wpdb->prefix . 'tutor_lesson_bookings';
		$sql_bookings = "CREATE TABLE IF NOT EXISTS $table_bookings (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			student_id bigint(20) UNSIGNED NOT NULL,
			teacher_id bigint(20) UNSIGNED NOT NULL,
			course_id bigint(20) UNSIGNED NOT NULL,
			lesson_id bigint(20) UNSIGNED DEFAULT NULL,
			booking_date date NOT NULL,
			booking_time time NOT NULL,
			duration int(11) DEFAULT 60 COMMENT 'Duration in minutes',
			status varchar(20) DEFAULT 'pending' COMMENT 'pending, approved, scheduled, completed, cancelled, rescheduled, rejected',
			subscription_id bigint(20) UNSIGNED DEFAULT NULL COMMENT 'WooCommerce subscription ID',
			order_id bigint(20) UNSIGNED DEFAULT NULL COMMENT 'WooCommerce order ID',
			google_meet_link varchar(500) DEFAULT NULL COMMENT 'Google Meet link for the lesson',
			notes text,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY student_id (student_id),
			KEY teacher_id (teacher_id),
			KEY course_id (course_id),
			KEY booking_date (booking_date),
			KEY status (status),
			KEY subscription_id (subscription_id)
		) $charset_collate;";
		
		// Add google_meet_link column if it doesn't exist (for existing installations)
		$column_exists = $wpdb->get_results( $wpdb->prepare(
			"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
			WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = 'google_meet_link'",
			DB_NAME,
			$table_bookings
		) );
		
		if ( empty( $column_exists ) ) {
			$wpdb->query( "ALTER TABLE {$table_bookings} ADD COLUMN google_meet_link varchar(500) DEFAULT NULL COMMENT 'Google Meet link for the lesson' AFTER order_id" );
		}
		
		// Subscription lessons tracking table
		$table_subscriptions = $wpdb->prefix . 'tutor_subscription_lessons';
		$sql_subscriptions = "CREATE TABLE IF NOT EXISTS $table_subscriptions (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			student_id bigint(20) UNSIGNED NOT NULL,
			subscription_id bigint(20) UNSIGNED NOT NULL COMMENT 'WooCommerce subscription ID',
			course_id bigint(20) UNSIGNED NOT NULL,
			total_lessons int(11) NOT NULL DEFAULT 0 COMMENT 'Total lessons in subscription',
			used_lessons int(11) NOT NULL DEFAULT 0 COMMENT 'Lessons already used',
			remaining_lessons int(11) NOT NULL DEFAULT 0 COMMENT 'Lessons remaining',
			subscription_start date NOT NULL,
			subscription_end date DEFAULT NULL,
			status varchar(20) DEFAULT 'active' COMMENT 'active, expired, cancelled',
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY student_id (student_id),
			KEY subscription_id (subscription_id),
			KEY course_id (course_id),
			KEY status (status)
		) $charset_collate;";
		
		// Notifications log table
		$table_notifications = $wpdb->prefix . 'tutor_scheduling_notifications';
		$sql_notifications = "CREATE TABLE IF NOT EXISTS $table_notifications (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			subscription_id bigint(20) UNSIGNED NOT NULL,
			student_id bigint(20) UNSIGNED NOT NULL,
			notification_type varchar(50) NOT NULL COMMENT 'subscription_ending_admin, subscription_ending_student, payment_reminder',
			sent_at datetime DEFAULT CURRENT_TIMESTAMP,
			remaining_lessons int(11) DEFAULT NULL,
			PRIMARY KEY (id),
			KEY subscription_id (subscription_id),
			KEY student_id (student_id),
			KEY notification_type (notification_type)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql_availability );
		dbDelta( $sql_bookings );
		dbDelta( $sql_subscriptions );
		dbDelta( $sql_notifications );
	}
	
	/**
	 * Get table name
	 */
	public static function get_table( $table_name ) {
		global $wpdb;
		return $wpdb->prefix . 'tutor_' . $table_name;
	}
}

