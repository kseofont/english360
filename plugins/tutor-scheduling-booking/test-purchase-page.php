<?php
/**
 * Test script for purchase-subscription page
 */

require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

echo "=== Testing Purchase Subscription Page ===\n\n";

// Check if page is registered
$dashboard_pages = tutor_utils()->tutor_dashboard_permalinks();
if ( isset( $dashboard_pages['purchase-subscription'] ) ) {
	echo "✓ Page is registered in permalinks\n";
	echo "  Title: " . $dashboard_pages['purchase-subscription']['title'] . "\n";
} else {
	echo "✗ Page is NOT registered!\n";
}

// Check if template file exists
$template_file = dirname( __FILE__ ) . '/templates/dashboard-purchase-subscription.php';
if ( file_exists( $template_file ) ) {
	echo "✓ Template file exists: " . $template_file . "\n";
} else {
	echo "✗ Template file NOT found: " . $template_file . "\n";
}

// Check if view file exists
$view_file = dirname( __FILE__ ) . '/views/dashboard-purchase-subscription.php';
if ( file_exists( $view_file ) ) {
	echo "✓ View file exists: " . $view_file . "\n";
} else {
	echo "✗ View file NOT found: " . $view_file . "\n";
}

// Check rewrite rules
$rules = get_option( 'rewrite_rules' );
$dashboard_slug = get_post_field( 'post_name', tutor_utils()->get_option( 'tutor_dashboard_page_id' ) );
$rule_pattern = "({$dashboard_slug})/purchase-subscription/?$";

if ( isset( $rules[ $rule_pattern ] ) ) {
	echo "✓ Rewrite rule exists\n";
	echo "  Pattern: " . $rule_pattern . "\n";
	echo "  Rewrite: " . $rules[ $rule_pattern ] . "\n";
} else {
	echo "✗ Rewrite rule NOT found!\n";
	echo "  Looking for: " . $rule_pattern . "\n";
	echo "  Available rules containing 'purchase-subscription':\n";
	foreach ( $rules as $pattern => $rewrite ) {
		if ( strpos( $pattern, 'purchase-subscription' ) !== false ) {
			echo "    - " . $pattern . " => " . $rewrite . "\n";
		}
	}
}

// Test URL
$dashboard_page_id = tutor_utils()->get_option( 'tutor_dashboard_page_id' );
$test_url = get_permalink( $dashboard_page_id ) . 'purchase-subscription/';
echo "\nTest URL: " . $test_url . "\n";

echo "\n=== Test Complete ===\n";

