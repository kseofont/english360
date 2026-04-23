<?php
/**
 * WooCommerce Integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Tutor_Scheduling_WooCommerce {
	
	public function __construct() {
		// Add product meta field for total lessons
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_total_lessons_field' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_total_lessons_field' ) );
		
		// Track subscriptions when orders are completed
		add_action( 'woocommerce_order_status_completed', array( $this, 'track_order_lessons' ), 10, 1 );
		add_action( 'woocommerce_payment_complete', array( $this, 'track_order_lessons' ), 10, 1 );
		add_action( 'woocommerce_thankyou', array( $this, 'track_order_lessons_on_thankyou' ), 10, 1 );
		
		if ( class_exists( 'WC_Subscriptions' ) ) {
			add_action( 'woocommerce_subscription_status_active', array( $this, 'track_subscription_lessons' ), 10, 1 );
			add_action( 'woocommerce_subscription_payment_complete', array( $this, 'track_subscription_lessons' ), 10, 1 );
		}
	}
	
	/**
	 * Add total lessons field to product
	 */
	public function add_total_lessons_field() {
		global $woocommerce, $post;
		
		echo '<div class="options_group">';
		
		woocommerce_wp_text_input( array(
			'id' => '_tutor_total_lessons',
			'label' => __( 'Total Lessons in Subscription', 'tutor-scheduling' ),
			'placeholder' => '10',
			'desc_tip' => 'true',
			'description' => __( 'Enter the total number of lessons included in this subscription/product.', 'tutor-scheduling' ),
			'type' => 'number',
			'custom_attributes' => array(
				'step' => '1',
				'min' => '1',
			),
		) );
		
		echo '</div>';
	}
	
	/**
	 * Save total lessons field
	 */
	public function save_total_lessons_field( $post_id ) {
		$total_lessons = isset( $_POST['_tutor_total_lessons'] ) ? intval( $_POST['_tutor_total_lessons'] ) : '';
		
		if ( $total_lessons ) {
			update_post_meta( $post_id, '_tutor_total_lessons', $total_lessons );
		} else {
			delete_post_meta( $post_id, '_tutor_total_lessons' );
		}
	}
	
	/**
	 * Track lessons when order is completed
	 */
	public function track_order_lessons( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}
		
		$student_id = $order->get_user_id();
		if ( ! $student_id ) {
			return;
		}
		
		$tracker = new Tutor_Scheduling_Subscription_Tracker();
		$items = $order->get_items();
		
		foreach ( $items as $item ) {
			$product_id = $item->get_product_id();
			
			// Check if product is linked to a course
			if ( function_exists( 'tutor_utils' ) ) {
				$course_id = tutor_utils()->get_course_id_by_product( $product_id );
				
				if ( $course_id ) {
					$total_lessons = get_post_meta( $product_id, '_tutor_total_lessons', true );
					if ( ! $total_lessons ) {
						$total_lessons = 10; // Default
					}
					
					// Use order_id as subscription_id for one-time purchases
					$tracker->track_subscription( $order_id, $student_id, $course_id, $total_lessons );
				}
			}
		}
	}
	
	/**
	 * Track lessons when subscription is activated
	 */
	public function track_subscription_lessons( $subscription_id ) {
		if ( ! function_exists( 'wcs_get_subscription' ) ) {
			return;
		}
		
		$subscription = wcs_get_subscription( $subscription_id );
		if ( ! $subscription ) {
			return;
		}
		
		$student_id = $subscription->get_user_id();
		if ( ! $student_id ) {
			return;
		}
		
		$tracker = new Tutor_Scheduling_Subscription_Tracker();
		$items = $subscription->get_items();
		
		foreach ( $items as $item ) {
			$product_id = $item->get_product_id();
			
			if ( function_exists( 'tutor_utils' ) ) {
				$course_id = tutor_utils()->get_course_id_by_product( $product_id );
				
				if ( $course_id ) {
					$total_lessons = get_post_meta( $product_id, '_tutor_total_lessons', true );
					if ( ! $total_lessons ) {
						$total_lessons = 10; // Default
					}
					
					$tracker->track_subscription( $subscription_id, $student_id, $course_id, $total_lessons );
				}
			}
		}
	}
	
	/**
	 * Track lessons on thank you page (for cases where payment_complete hook doesn't fire)
	 */
	public function track_order_lessons_on_thankyou( $order_id ) {
		if ( ! $order_id ) {
			return;
		}
		
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}
		
		// Only track if order is paid
		if ( ! $order->is_paid() ) {
			return;
		}
		
		// Check if already tracked
		$already_tracked = $order->get_meta( '_tutor_scheduling_tracked' );
		if ( $already_tracked ) {
			return;
		}
		
		// Track the order
		$this->track_order_lessons( $order_id );
		
		// Mark as tracked
		$order->update_meta_data( '_tutor_scheduling_tracked', 'yes' );
		$order->save();
	}
}

