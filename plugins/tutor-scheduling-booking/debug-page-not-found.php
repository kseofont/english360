<?php
/**
 * Debug script for "Page not found" issue
 * 
 * Run this from command line: php debug-page-not-found.php
 * Or access via browser: /wp-content/plugins/tutor-scheduling-booking/debug-page-not-found.php
 */

// Load WordPress
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

echo "=== Tutor Scheduling Dashboard Page Debug ===\n\n";

// Check if Tutor is loaded
if ( ! function_exists( 'tutor' ) ) {
	echo "ERROR: Tutor LMS is not loaded!\n";
	exit;
}

echo "✓ Tutor LMS is loaded\n";

// Check if our plugin classes are loaded
if ( ! class_exists( 'Tutor_Scheduling_Frontend' ) ) {
	echo "ERROR: Tutor_Scheduling_Frontend class not found!\n";
	exit;
}

echo "✓ Tutor_Scheduling_Frontend class is loaded\n";

// Get dashboard page ID
$dashboard_page_id = (int) tutor_utils()->get_option( 'tutor_dashboard_page_id' );
echo "Dashboard Page ID: " . $dashboard_page_id . "\n";

if ( ! $dashboard_page_id ) {
	echo "ERROR: Dashboard page ID is not set in Tutor settings!\n";
	echo "Please go to Tutor LMS > Settings > Advanced and set the Dashboard Page.\n";
	exit;
}

$dashboard_page = get_post( $dashboard_page_id );
if ( ! $dashboard_page ) {
	echo "ERROR: Dashboard page not found!\n";
	exit;
}

echo "Dashboard Page Slug: " . $dashboard_page->post_name . "\n";
echo "Dashboard Page URL: " . get_permalink( $dashboard_page_id ) . "\n\n";

// Check registered dashboard pages
$dashboard_pages = tutor_utils()->tutor_dashboard_permalinks();
echo "Registered Dashboard Pages:\n";
foreach ( $dashboard_pages as $key => $page ) {
	echo "  - {$key}: " . ( isset( $page['title'] ) ? $page['title'] : 'N/A' ) . "\n";
}

echo "\n";

// Check if our pages are registered
$our_pages = array( 'availability', 'bookings', 'subscriptions' );
echo "Our Custom Pages:\n";
foreach ( $our_pages as $page ) {
	if ( isset( $dashboard_pages[ $page ] ) ) {
		echo "  ✓ {$page} is registered\n";
	} else {
		echo "  ✗ {$page} is NOT registered!\n";
	}
}

echo "\n";

// Check rewrite rules
global $wp_rewrite;
$rules = get_option( 'rewrite_rules' );
$dashboard_slug = $dashboard_page->post_name;

echo "Checking Rewrite Rules for '{$dashboard_slug}':\n";
$found_rules = false;
foreach ( $rules as $pattern => $rewrite ) {
	if ( strpos( $pattern, $dashboard_slug ) !== false ) {
		echo "  Found: {$pattern} => {$rewrite}\n";
		$found_rules = true;
	}
}

if ( ! $found_rules ) {
	echo "  ✗ No rewrite rules found for dashboard pages!\n";
	echo "  Solution: Go to WordPress Admin > Settings > Permalinks and click 'Save Changes' to flush rewrite rules.\n";
}

echo "\n";

// Test URLs
echo "Test URLs:\n";
foreach ( $our_pages as $page ) {
	$url = get_permalink( $dashboard_page_id ) . $page . '/';
	echo "  {$page}: {$url}\n";
}

echo "\n";

// Check if templates exist
echo "Template Files:\n";
$template_dir = dirname( __FILE__ ) . '/templates/';
foreach ( $our_pages as $page ) {
	$template_file = $template_dir . 'dashboard-' . $page . '.php';
	if ( file_exists( $template_file ) ) {
		echo "  ✓ dashboard-{$page}.php exists\n";
	} else {
		echo "  ✗ dashboard-{$page}.php NOT found at: {$template_file}\n";
	}
}

echo "\n";

// Check filter hooks
echo "Filter Hooks:\n";
$filters = array(
	'tutor_dashboard/permalinks',
	'tutor_dashboard/instructor_nav_items',
	'tutor_dashboard/nav_items',
	'load_dashboard_template_part_from_other_location',
);

foreach ( $filters as $filter ) {
	$has_filter = has_filter( $filter );
	if ( $has_filter ) {
		echo "  ✓ {$filter} has " . $has_filter . " callback(s)\n";
	} else {
		echo "  ✗ {$filter} has NO callbacks!\n";
	}
}

echo "\n=== Debug Complete ===\n";

