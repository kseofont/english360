<?php
/**
 * Test Template Loading
 * Visit: yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-template-load.php
 */

require_once( '../../../wp-load.php' );

if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
	die( 'Access denied. You must be logged in as administrator.' );
}

echo '<h1>Template Loading Test</h1>';

// Check constants
echo '<h2>Constants</h2>';
echo '<p>TUTOR_SCHEDULING_DIR: ' . ( defined( 'TUTOR_SCHEDULING_DIR' ) ? TUTOR_SCHEDULING_DIR : 'NOT DEFINED' ) . '</p>';

// Check template files
echo '<h2>Template Files</h2>';
$templates = array(
	'availability' => TUTOR_SCHEDULING_DIR . 'templates/dashboard-availability.php',
	'bookings' => TUTOR_SCHEDULING_DIR . 'templates/dashboard-bookings.php',
	'subscriptions' => TUTOR_SCHEDULING_DIR . 'templates/dashboard-subscriptions.php',
);

foreach ( $templates as $name => $path ) {
	$exists = file_exists( $path );
	echo '<p>' . $name . ': ' . ( $exists ? '✓ EXISTS' : '✗ NOT FOUND' ) . '</p>';
	if ( $exists ) {
		echo '<pre>' . htmlspecialchars( file_get_contents( $path, false, null, 0, 200 ) ) . '</pre>';
	}
}

// Check view files
echo '<h2>View Files</h2>';
$views = array(
	'availability' => TUTOR_SCHEDULING_DIR . 'views/dashboard-availability.php',
	'bookings' => TUTOR_SCHEDULING_DIR . 'views/dashboard-bookings.php',
	'subscriptions' => TUTOR_SCHEDULING_DIR . 'views/dashboard-subscriptions.php',
);

foreach ( $views as $name => $path ) {
	$exists = file_exists( $path );
	echo '<p>' . $name . ': ' . ( $exists ? '✓ EXISTS' : '✗ NOT FOUND' ) . '</p>';
}

// Test filter
echo '<h2>Filter Test</h2>';
global $wp_query;
$wp_query->query_vars['tutor_dashboard_page'] = 'availability';

$result = apply_filters( 'load_dashboard_template_part_from_other_location', '' );
echo '<p>Filter result: ' . ( $result ? htmlspecialchars( $result ) : 'EMPTY' ) . '</p>';

if ( $result && file_exists( $result ) ) {
	echo '<p style="color:green;">✓ Template file exists and can be loaded!</p>';
} else {
	echo '<p style="color:red;">✗ Template file issue</p>';
}

