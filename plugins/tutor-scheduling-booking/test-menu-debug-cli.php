<?php
/**
 * CLI Debug Script for Menu Item
 * 
 * Run: php test-menu-debug-cli.php
 */

// Load WordPress
require_once( __DIR__ . '/../../../wp-load.php' );

echo "=== Tutor Scheduling Menu Debug ===\n\n";

// Check if Tutor is loaded
if ( ! function_exists( 'tutor' ) ) {
	die( "ERROR: Tutor LMS is not loaded!\n" );
}
echo "✓ Tutor LMS is loaded\n";

// Check instructor role
$instructor_role = tutor()->instructor_role;
echo "Instructor Role: {$instructor_role}\n\n";

// Check if class exists
if ( class_exists( 'Tutor_Scheduling_Frontend' ) ) {
	echo "✓ Tutor_Scheduling_Frontend class exists\n";
} else {
	echo "✗ Tutor_Scheduling_Frontend class does NOT exist\n";
	echo "  This means the plugin files are not being loaded!\n";
	echo "\n  Trying to manually include the file...\n";
	
	$frontend_file = __DIR__ . '/includes/class-frontend.php';
	if ( file_exists( $frontend_file ) ) {
		echo "  File exists: {$frontend_file}\n";
		require_once( $frontend_file );
		if ( class_exists( 'Tutor_Scheduling_Frontend' ) ) {
			echo "  ✓ Class loaded after manual include\n";
		} else {
			echo "  ✗ Class still doesn't exist after include - check for PHP errors\n";
		}
	} else {
		echo "  ✗ File not found: {$frontend_file}\n";
	}
}

// Check if plugin is active
$active_plugins = get_option( 'active_plugins', array() );
$plugin_file = 'tutor-scheduling-booking/tutor-scheduling-booking.php';
$is_active = in_array( $plugin_file, $active_plugins );

if ( $is_active ) {
	echo "✓ Plugin is activated\n";
} else {
	echo "✗ Plugin is NOT activated\n";
	echo "  Plugin file: {$plugin_file}\n";
	echo "  Active plugins:\n";
	foreach ( $active_plugins as $plugin ) {
		if ( strpos( $plugin, 'tutor-scheduling' ) !== false ) {
			echo "    - {$plugin}\n";
		}
	}
}

echo "\n=== Testing Filter Hook ===\n";

// Test the filter directly
$test_nav_items = array();
$test_nav_items = apply_filters( 'tutor_dashboard/instructor_nav_items', $test_nav_items );

echo "Nav items count: " . count( $test_nav_items ) . "\n";

if ( isset( $test_nav_items['availability'] ) ) {
	echo "✓ Availability menu item IS being added!\n";
	echo "  Title: " . $test_nav_items['availability']['title'] . "\n";
	echo "  Icon: " . $test_nav_items['availability']['icon'] . "\n";
	echo "  Auth Cap: " . $test_nav_items['availability']['auth_cap'] . "\n";
} else {
	echo "✗ Availability menu item is NOT being added\n";
	echo "  Available nav items:\n";
	foreach ( array_keys( $test_nav_items ) as $key ) {
		echo "    - {$key}\n";
	}
}

echo "\n=== All Instructor Nav Items ===\n";
foreach ( $test_nav_items as $key => $item ) {
	if ( is_array( $item ) ) {
		$title = isset( $item['title'] ) ? $item['title'] : 'N/A';
		$icon = isset( $item['icon'] ) ? $item['icon'] : 'N/A';
		echo "  {$key}: {$title} (icon: {$icon})\n";
	} else {
		echo "  {$key}: {$item}\n";
	}
}

echo "\n=== Checking Users ===\n";
$users = get_users( array( 'role' => $instructor_role ) );
echo "Users with instructor role: " . count( $users ) . "\n";
if ( count( $users ) > 0 ) {
	echo "Instructor users:\n";
	foreach ( $users as $user ) {
		$is_instructor = tutor_utils()->is_instructor( $user->ID );
		echo "  - {$user->user_login} (ID: {$user->ID}) - Is Instructor: " . ( $is_instructor ? 'YES' : 'NO' ) . "\n";
	}
}

echo "\n=== Recommendations ===\n";
if ( ! isset( $test_nav_items['availability'] ) ) {
	echo "1. Check if filter hook is being called\n";
	echo "2. Check WordPress error logs (wp-content/debug.log)\n";
	echo "3. Try deactivating and reactivating the plugin\n";
	echo "4. Clear all caches\n";
} else {
	echo "✓ Menu item is being added correctly!\n";
	echo "  If it's not showing in dashboard:\n";
	echo "  1. Make sure you're logged in as an instructor\n";
	echo "  2. Clear browser cache (Ctrl+F5)\n";
	echo "  3. Check if user has '{$instructor_role}' role\n";
}

echo "\n=== Done ===\n";

