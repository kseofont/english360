<?php
/**
 * Dashboard Subscriptions Template
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

// Load the subscriptions view
$view_file = TUTOR_SCHEDULING_DIR . 'views/dashboard-subscriptions.php';
if ( file_exists( $view_file ) ) {
	include $view_file;
} else {
	echo '<div class="tutor-alert tutor-alert-error">' . esc_html__( 'Subscriptions view file not found.', 'tutor-scheduling' ) . '</div>';
}

