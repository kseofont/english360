<?php
/**
 * Purchase Subscription Dashboard Page
 * 
 * Note: This is included within Tutor's dashboard template wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

<style>
.tutor-scheduling-purchase-subscription {
	padding: 20px 0;
}

.subscription-options {
	margin-top: 30px;
}

.subscription-category {
	margin-bottom: 40px;
}

.subscription-category h3 {
	margin-bottom: 20px;
	font-size: 24px;
	color: #333;
	border-bottom: 2px solid #e0e0e0;
	padding-bottom: 10px;
}

.products-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
	gap: 20px;
	margin-top: 20px;
}

.product-card {
	border: 2px solid #e0e0e0;
	border-radius: 8px;
	padding: 25px;
	background: #fff;
	transition: all 0.3s ease;
	text-align: center;
}

.product-card:hover {
	border-color: #2271b1;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	transform: translateY(-2px);
}

.product-card.featured {
	border-color: #2271b1;
	background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
}

.product-title {
	font-size: 20px;
	font-weight: bold;
	margin-bottom: 10px;
	color: #333;
}

.product-price {
	font-size: 32px;
	font-weight: bold;
	color: #2271b1;
	margin: 15px 0;
}

.product-price .period {
	font-size: 14px;
	color: #666;
	font-weight: normal;
}

.product-lessons {
	font-size: 16px;
	color: #666;
	margin: 15px 0;
}

.product-lessons strong {
	color: #333;
}

.product-description {
	font-size: 14px;
	color: #666;
	margin: 15px 0;
	line-height: 1.6;
}

.product-button {
	margin-top: 20px;
}

.product-button .tutor-btn {
	width: 100%;
	padding: 12px 24px;
	font-size: 16px;
	font-weight: 600;
}

.no-products {
	text-align: center;
	padding: 40px 20px;
	background: #f9f9f9;
	border-radius: 8px;
	margin-top: 20px;
}

.no-products p {
	margin-bottom: 10px;
	font-size: 16px;
	color: #666;
}
</style>


