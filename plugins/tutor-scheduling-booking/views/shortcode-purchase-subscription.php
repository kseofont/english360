<?php
/**
 * Purchase Subscription Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	echo '<p>' . esc_html__( 'Please log in to purchase subscriptions.', 'tutor-scheduling' ) . '</p>';
	return;
}

// Check if WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
	echo '<div class="tutor-alert tutor-alert-error">';
	echo esc_html__( 'WooCommerce is required to purchase subscriptions.', 'tutor-scheduling' );
	echo '</div>';
	return;
}

// Get subscription products
$subscription_products = tutor_scheduling_get_subscription_products();
?>

<div class="tutor-scheduling-purchase-subscription">
	<h2><?php esc_html_e( 'Purchase Subscription', 'tutor-scheduling' ); ?></h2>
	
	<?php if ( empty( $subscription_products ) ) : ?>
		<div class="no-products">
			<p><?php esc_html_e( 'No subscription products available at the moment.', 'tutor-scheduling' ); ?></p>
			<p><?php esc_html_e( 'Please contact the administrator to set up subscription products.', 'tutor-scheduling' ); ?></p>
		</div>
	<?php else : ?>
		<div class="subscription-options">
			<?php 
			// Group products by type
			$monthly_products = array();
			$yearly_products = array();
			$lesson_packages = array();
			
			foreach ( $subscription_products as $product ) {
				$product_type = tutor_scheduling_get_product_subscription_type( $product );
				
				if ( $product_type === 'monthly' ) {
					$monthly_products[] = $product;
				} elseif ( $product_type === 'yearly' ) {
					$yearly_products[] = $product;
				} else {
					$lesson_packages[] = $product;
				}
			}
			?>
			
			<?php if ( ! empty( $monthly_products ) ) : ?>
				<div class="subscription-category">
					<h3><?php esc_html_e( 'Monthly Subscriptions', 'tutor-scheduling' ); ?></h3>
					<div class="products-grid">
						<?php foreach ( $monthly_products as $product ) : 
							tutor_scheduling_render_subscription_product_card( $product );
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ( ! empty( $yearly_products ) ) : ?>
				<div class="subscription-category">
					<h3><?php esc_html_e( 'Yearly Subscriptions', 'tutor-scheduling' ); ?></h3>
					<div class="products-grid">
						<?php foreach ( $yearly_products as $product ) : 
							tutor_scheduling_render_subscription_product_card( $product );
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ( ! empty( $lesson_packages ) ) : ?>
				<div class="subscription-category">
					<h3><?php esc_html_e( 'Lesson Packages', 'tutor-scheduling' ); ?></h3>
					<div class="products-grid">
						<?php foreach ( $lesson_packages as $product ) : 
							tutor_scheduling_render_subscription_product_card( $product );
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>

