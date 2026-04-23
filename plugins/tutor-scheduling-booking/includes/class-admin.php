<?php
/**
 * Admin Interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_Admin {
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Add admin menu
	 */
	public function add_admin_menu() {
		add_submenu_page(
			'tutor',
			__( 'Scheduling & Booking', 'tutor-scheduling' ),
			__( 'Scheduling', 'tutor-scheduling' ),
			'manage_options',
			'tutor-scheduling',
			array( $this, 'admin_page' )
		);
	}
	
	/**
	 * Enqueue admin scripts
	 */
	public function enqueue_scripts( $hook ) {
		if ( strpos( $hook, 'tutor-scheduling' ) === false ) {
			return;
		}
		
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'jquery-ui-datepicker' );
		
		wp_enqueue_script( 
			'tutor-scheduling-admin',
			TUTOR_SCHEDULING_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			TUTOR_SCHEDULING_VERSION,
			true
		);
		
		wp_enqueue_style(
			'tutor-scheduling-admin',
			TUTOR_SCHEDULING_URL . 'assets/css/admin.css',
			array(),
			TUTOR_SCHEDULING_VERSION
		);
		
		wp_localize_script( 'tutor-scheduling-admin', 'tutorScheduling', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'tutor_scheduling_nonce' ),
		) );
	}
	
	/**
	 * Admin page
	 */
	public function admin_page() {
		// Add link to test setup if available
		if ( class_exists( 'Tutor_Scheduling_Test_Setup' ) ) {
			$test_setup_url = admin_url( 'admin.php?page=tutor-scheduling-test' );
			echo '<div class="notice notice-info"><p>';
			echo '<strong>' . esc_html__( 'Quick Test Setup:', 'tutor-scheduling' ) . '</strong> ';
			echo '<a href="' . esc_url( $test_setup_url ) . '" class="button button-primary">' . esc_html__( 'Go to Test Setup', 'tutor-scheduling' ) . '</a>';
			echo ' | <a href="' . esc_url( TUTOR_SCHEDULING_URL . 'test-quick-setup.php' ) . '" target="_blank">' . esc_html__( 'Quick Setup Script', 'tutor-scheduling' ) . '</a>';
			echo '</p></div>';
		}
		
		include TUTOR_SCHEDULING_DIR . 'views/admin-page.php';
	}
}

