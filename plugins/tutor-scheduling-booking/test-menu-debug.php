<?php
/**
 * Quick Debug Script for Menu Item
 * 
 * Visit: yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-menu-debug.php
 * (Must be logged in as admin)
 */

require_once( '../../../wp-load.php' );

if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access denied. You must be an administrator.' );
}

echo '<h1>Menu Debug Information</h1>';

// Check if Tutor is loaded
if ( ! function_exists( 'tutor' ) ) {
	die( '<p style="color:red;">Tutor LMS is not loaded!</p>' );
}

echo '<h2>1. Instructor Role Check</h2>';
$instructor_role = tutor()->instructor_role;
echo '<p><strong>Instructor Role:</strong> ' . esc_html( $instructor_role ) . '</p>';

$current_user_id = get_current_user_id();
$current_user = get_userdata( $current_user_id );
echo '<p><strong>Current User:</strong> ' . esc_html( $current_user->user_login ) . ' (ID: ' . $current_user_id . ')</p>';
echo '<p><strong>User Roles:</strong> ' . implode( ', ', $current_user->roles ) . '</p>';
echo '<p><strong>Is Instructor:</strong> ' . ( tutor_utils()->is_instructor() ? 'YES' : 'NO' ) . '</p>';
echo '<p><strong>Can Access Instructor Role:</strong> ' . ( current_user_can( $instructor_role ) ? 'YES' : 'NO' ) . '</p>';

echo '<h2>2. Filter Hook Test</h2>';
$test_nav_items = array();
$test_nav_items = apply_filters( 'tutor_dashboard/instructor_nav_items', $test_nav_items );

echo '<p><strong>Nav Items Count:</strong> ' . count( $test_nav_items ) . '</p>';

if ( isset( $test_nav_items['availability'] ) ) {
	echo '<p style="color:green;">✓ Availability menu item IS being added!</p>';
	echo '<pre>' . print_r( $test_nav_items['availability'], true ) . '</pre>';
} else {
	echo '<p style="color:red;">✗ Availability menu item is NOT being added</p>';
	echo '<p><strong>Available nav items:</strong></p>';
	echo '<pre>' . print_r( array_keys( $test_nav_items ), true ) . '</pre>';
}

echo '<h2>3. Plugin Check</h2>';
if ( class_exists( 'Tutor_Scheduling_Frontend' ) ) {
	echo '<p style="color:green;">✓ Tutor_Scheduling_Frontend class exists</p>';
} else {
	echo '<p style="color:red;">✗ Tutor_Scheduling_Frontend class does NOT exist</p>';
}

echo '<h2>4. All Instructor Nav Items</h2>';
echo '<pre>' . print_r( $test_nav_items, true ) . '</pre>';

echo '<h2>5. Fix Suggestions</h2>';
if ( ! tutor_utils()->is_instructor() ) {
	echo '<p style="color:orange;">⚠ Your current user is not an instructor. Switch to a user with instructor role to see the menu.</p>';
}

if ( ! isset( $test_nav_items['availability'] ) ) {
	echo '<p style="color:orange;">⚠ The filter is not adding the menu item. Check:</p>';
	echo '<ul>';
	echo '<li>Plugin is activated</li>';
	echo '<li>No PHP errors in debug.log</li>';
	echo '<li>Filter hook is correct: tutor_dashboard/instructor_nav_items</li>';
	echo '</ul>';
}

