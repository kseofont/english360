<?php
/**
 * Dashboard Availability Template
 * 
 * This template is loaded directly by Tutor's dashboard system
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Make sure constants are defined
if ( ! defined( 'TUTOR_SCHEDULING_DIR' ) ) {
	define( 'TUTOR_SCHEDULING_DIR', plugin_dir_path( dirname( __FILE__ ) ) );
}

// Check instructor permission
if ( ! tutor_utils()->is_instructor() ) {
	echo '<div class="tutor-alert tutor-alert-error tutor-mt-20">' . esc_html__( 'Access denied. Instructor access required.', 'tutor-scheduling' ) . '</div>';
	return;
}

// Load the availability view
$view_file = TUTOR_SCHEDULING_DIR . 'views/dashboard-availability.php';
if ( file_exists( $view_file ) ) {
	include $view_file;
} else {
	echo '<div class="tutor-alert tutor-alert-error">' . esc_html__( 'Availability view file not found.', 'tutor-scheduling' ) . '</div>';
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		echo '<p>File path: ' . esc_html( $view_file ) . '</p>';
	}
}

