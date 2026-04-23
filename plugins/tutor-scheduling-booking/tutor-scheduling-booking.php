<?php
/**
 * Plugin Name: Tutor Scheduling & Booking
 * Plugin URI: https://example.com
 * Description: Advanced scheduling and booking system for Tutor LMS with subscription management and notifications
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: tutor-scheduling
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'TUTOR_SCHEDULING_VERSION', '1.0.0' );
define( 'TUTOR_SCHEDULING_FILE', __FILE__ );
define( 'TUTOR_SCHEDULING_DIR', plugin_dir_path( __FILE__ ) );
define( 'TUTOR_SCHEDULING_URL', plugin_dir_url( __FILE__ ) );
define( 'TUTOR_SCHEDULING_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main plugin class
 */
class Tutor_Scheduling_Booking {
	
	private static $instance = null;
	
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct() {
		$this->includes();
		$this->init_hooks();
	}
	
	private function includes() {
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-database.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-availability.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-booking.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-subscription-tracker.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-notifications.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-woocommerce.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-ajax.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-admin.php';
		require_once TUTOR_SCHEDULING_DIR . 'includes/class-frontend.php';
		
		// Load test setup only in debug mode
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			require_once TUTOR_SCHEDULING_DIR . 'includes/class-test-setup.php';
		}
	}
	
	private function init_hooks() {
		register_activation_hook( TUTOR_SCHEDULING_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( TUTOR_SCHEDULING_FILE, array( $this, 'deactivate' ) );
		
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'init' ) );
	}
	
	public function activate() {
		// Check if Tutor LMS is active
		// During activation, plugins might not be fully loaded yet, so check plugin file directly
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		$tutor_active = false;
		
		// Check if Tutor plugin file exists and is in active plugins
		$active_plugins = get_option( 'active_plugins', array() );
		$tutor_plugin_paths = array( 'tutor/tutor.php', 'tutor-lms/tutor.php' );
		
		foreach ( $tutor_plugin_paths as $tutor_path ) {
			if ( in_array( $tutor_path, $active_plugins ) ) {
				$tutor_active = true;
				break;
			}
		}
		
		// Also check if Tutor function/class is available (if loaded)
		if ( ! $tutor_active ) {
			if ( function_exists( 'tutor' ) || function_exists( 'tutor_lms' ) || class_exists( 'TUTOR\Tutor' ) || defined( 'TUTOR_VERSION' ) ) {
				$tutor_active = true;
			}
		}
		
		// Check if Tutor plugin file physically exists
		if ( ! $tutor_active ) {
			$tutor_file = WP_PLUGIN_DIR . '/tutor/tutor.php';
			if ( file_exists( $tutor_file ) ) {
				// File exists, might just not be activated yet - allow activation but show warning
				$tutor_active = true;
			}
		}
		
		if ( ! $tutor_active ) {
			deactivate_plugins( TUTOR_SCHEDULING_BASENAME );
			wp_die( 
				'<h1>' . esc_html__( 'Plugin Activation Error', 'tutor-scheduling' ) . '</h1>' .
				'<p>' . esc_html__( 'Tutor Scheduling & Booking requires Tutor LMS to be installed and active.', 'tutor-scheduling' ) . '</p>' .
				'<p>' . esc_html__( 'Please install and activate Tutor LMS first, then try activating this plugin again.', 'tutor-scheduling' ) . '</p>' .
				'<p><a href="' . admin_url( 'plugins.php' ) . '">' . esc_html__( 'Return to Plugins', 'tutor-scheduling' ) . '</a></p>'
			);
		}
		
		// Create database tables
		Tutor_Scheduling_Database::create_tables();
		
		// Schedule cron jobs
		$this->schedule_cron_jobs();
		
		// Set default options
		add_option( 'tutor_scheduling_version', TUTOR_SCHEDULING_VERSION );
		
		// Flag to flush rewrite rules on next admin page load
		// This ensures Tutor's rewrite rules include our custom dashboard pages
		// Note: We need to wait for Tutor to register our pages via the filter first
		add_option( 'tutor_scheduling_flush_rewrite_rules', true );
		
		// Also flush immediately if Tutor is already loaded
		if ( function_exists( 'tutor' ) ) {
			// Give Tutor a moment to process our filters, then flush
			add_action( 'shutdown', 'flush_rewrite_rules', 999 );
		}
	}
	
	public function deactivate() {
		// Clear scheduled cron jobs
		wp_clear_scheduled_hook( 'tutor_scheduling_check_subscriptions' );
	}
	
	public function schedule_cron_jobs() {
		if ( ! wp_next_scheduled( 'tutor_scheduling_check_subscriptions' ) ) {
			wp_schedule_event( time(), 'hourly', 'tutor_scheduling_check_subscriptions' );
		}
	}
	
	public function load_textdomain() {
		load_plugin_textdomain( 'tutor-scheduling', false, dirname( TUTOR_SCHEDULING_BASENAME ) . '/languages' );
	}
	
	public function init() {
		// Initialize classes
		if ( is_admin() ) {
			new Tutor_Scheduling_Admin();
		}
		
		// Initialize WooCommerce integration if available
		if ( class_exists( 'WooCommerce' ) ) {
			new Tutor_Scheduling_WooCommerce();
		}
		
		new Tutor_Scheduling_Frontend();
		new Tutor_Scheduling_Ajax();
		new Tutor_Scheduling_Notifications();
		
		// Hook into subscription check
		add_action( 'tutor_scheduling_check_subscriptions', array( $this, 'check_subscriptions' ) );
		
		// Flush rewrite rules if needed (only once after activation)
		add_action( 'admin_init', array( $this, 'maybe_flush_rewrite_rules' ) );
	}
	
	/**
	 * Flush rewrite rules if needed (only once after activation)
	 * This runs on admin_init to ensure Tutor has processed our filters first
	 */
	public function maybe_flush_rewrite_rules() {
		$option_name = 'tutor_scheduling_flush_rewrite_rules';
		if ( get_option( $option_name ) ) {
			// Flush rewrite rules to include our custom dashboard pages
			flush_rewrite_rules( false );
			delete_option( $option_name );
			
			// Show admin notice
			add_action( 'admin_notices', function() {
				echo '<div class="notice notice-success is-dismissible">';
				echo '<p><strong>Tutor Scheduling & Booking:</strong> ' . esc_html__( 'Rewrite rules have been flushed. Dashboard pages should now be accessible.', 'tutor-scheduling' ) . '</p>';
				echo '</div>';
			} );
		}
	}
	
	public function check_subscriptions() {
		$notifications = new Tutor_Scheduling_Notifications();
		$notifications->check_subscription_endings();
	}
}

/**
 * Main instance
 */
function tutor_scheduling_booking() {
	return Tutor_Scheduling_Booking::instance();
}

// Initialize plugin
tutor_scheduling_booking();

