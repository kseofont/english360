<?php
/**
 * Manual script to flush rewrite rules
 * 
 * Run this from command line: php flush-rewrite-rules.php
 * Or access via browser: /wp-content/plugins/tutor-scheduling-booking/flush-rewrite-rules.php
 */

// Load WordPress
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

echo "Flushing rewrite rules...\n\n";

// Flush rewrite rules
flush_rewrite_rules( false );

echo "✓ Rewrite rules flushed successfully!\n\n";
echo "Please try accessing the Availability page again:\n";
echo get_permalink( tutor_utils()->get_option( 'tutor_dashboard_page_id' ) ) . "availability/\n";

