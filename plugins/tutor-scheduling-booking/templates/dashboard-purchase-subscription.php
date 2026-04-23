<?php
/**
 * Dashboard Purchase Subscription Template
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

// Ensure helper functions are loaded
// The frontend class should have registered these, but ensure they exist
if ( ! function_exists( 'tutor_scheduling_get_subscription_products' ) ) {
	// Try to load the frontend class if it hasn't been loaded yet
	if ( class_exists( 'Tutor_Scheduling_Frontend' ) ) {
		// Functions should already be registered, but if not, we'll define them here as fallback
		// This shouldn't happen, but it's a safety check
	}
}

// Load the purchase subscription view
$view_file = TUTOR_SCHEDULING_DIR . 'views/dashboard-purchase-subscription.php';
if ( file_exists( $view_file ) ) {
	include $view_file;
} else {
	echo '<div class="tutor-alert tutor-alert-error">' . esc_html__( 'Purchase subscription view file not found.', 'tutor-scheduling' ) . '</div>';
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		echo '<p>File path: ' . esc_html( $view_file ) . '</p>';
	}
}

