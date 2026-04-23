<?php
/**
 * Check for Plugin Errors
 * Run: php check-errors.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Checking Plugin Files ===\n\n";

// Check if files exist
$files = array(
	'includes/class-database.php',
	'includes/class-availability.php',
	'includes/class-booking.php',
	'includes/class-subscription-tracker.php',
	'includes/class-notifications.php',
	'includes/class-woocommerce.php',
	'includes/class-ajax.php',
	'includes/class-admin.php',
	'includes/class-frontend.php',
);

$base_dir = __DIR__;
foreach ( $files as $file ) {
	$path = $base_dir . '/' . $file;
	if ( file_exists( $path ) ) {
		echo "✓ {$file}\n";
		
		// Check for syntax errors
		$output = array();
		$return = 0;
		exec( "php -l \"{$path}\" 2>&1", $output, $return );
		if ( $return !== 0 ) {
			echo "  ✗ Syntax error:\n";
			foreach ( $output as $line ) {
				echo "    {$line}\n";
			}
		}
	} else {
		echo "✗ {$file} - NOT FOUND\n";
	}
}

echo "\n=== Checking for Common Issues ===\n";

// Check if Tutor is available
if ( file_exists( $base_dir . '/../../../wp-load.php' ) ) {
	require_once( $base_dir . '/../../../wp-load.php' );
	
	if ( function_exists( 'tutor' ) ) {
		echo "✓ Tutor LMS is available\n";
	} else {
		echo "✗ Tutor LMS is NOT available\n";
	}
	
	// Try to include main plugin file
	echo "\n=== Testing Plugin Load ===\n";
	try {
		// Define ABSPATH if not defined
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/' );
		}
		
		// Try to load plugin
		$plugin_file = $base_dir . '/tutor-scheduling-booking.php';
		if ( file_exists( $plugin_file ) ) {
			ob_start();
			include $plugin_file;
			$output = ob_get_clean();
			
			if ( class_exists( 'Tutor_Scheduling_Booking' ) ) {
				echo "✓ Plugin class loaded successfully\n";
			} else {
				echo "✗ Plugin class NOT loaded\n";
			}
		}
	} catch ( Exception $e ) {
		echo "✗ Error loading plugin: " . $e->getMessage() . "\n";
	} catch ( Error $e ) {
		echo "✗ Fatal error: " . $e->getMessage() . "\n";
		echo "  File: " . $e->getFile() . "\n";
		echo "  Line: " . $e->getLine() . "\n";
	}
} else {
	echo "✗ Cannot find wp-load.php\n";
}

echo "\n=== Done ===\n";

