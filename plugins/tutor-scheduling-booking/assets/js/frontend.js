/**
 * Frontend JavaScript
 */

(function($) {
	'use strict';
	
	$(document).ready(function() {
		// Cancel booking
		$(document).on('click', '.cancel-booking', function(e) {
			e.preventDefault();
			
			if (!confirm('Are you sure you want to cancel this booking?')) {
				return;
			}
			
			var bookingId = $(this).data('booking-id');
			var $button = $(this);
			
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_cancel_booking',
					nonce: tutorScheduling.nonce,
					booking_id: bookingId
				},
				success: function(response) {
					if (response.success) {
						$button.closest('tr').fadeOut(function() {
							$(this).remove();
						});
					} else {
						alert(response.data.message || 'Failed to cancel booking');
					}
				}
			});
		});
		
		// Reschedule booking
		$(document).on('click', '.reschedule-booking', function(e) {
			e.preventDefault();
			
			var bookingId = $(this).data('booking-id');
			$('#reschedule-booking-id').val(bookingId);
			$('#reschedule-modal').show();
		});
		
		$('#reschedule-form').on('submit', function(e) {
			e.preventDefault();
			
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_reschedule_booking',
					nonce: tutorScheduling.nonce,
					booking_id: $('#reschedule-booking-id').val(),
					new_date: $('#reschedule-date').val(),
					new_time: $('#reschedule-time').val()
				},
				success: function(response) {
					if (response.success) {
						$('#reschedule-modal').hide();
						location.reload();
					} else {
						alert(response.data.message || 'Failed to reschedule booking');
					}
				}
			});
		});
		
		// Handle add to cart for subscription products
		// Use WooCommerce's built-in add to cart if available, otherwise use our custom handler
		if (typeof wc_add_to_cart_params !== 'undefined') {
			$(document).on('click', '.add-to-cart-button', function(e) {
				var $button = $(this);
				var productId = $button.data('product-id') || $button.attr('href').match(/add-to-cart=(\d+)/);
				
				if (productId && productId[1]) {
					productId = productId[1];
					
					// Check if WooCommerce AJAX add to cart is available
					if (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.ajax_url) {
						e.preventDefault();
						
						$button.addClass('loading').prop('disabled', true);
						
						$.ajax({
							url: wc_add_to_cart_params.ajax_url,
							type: 'POST',
							data: {
								action: 'woocommerce_add_to_cart',
								product_id: productId,
								quantity: 1
							},
							success: function(response) {
								if (response.error && response.product_url) {
									// Redirect to product page if there's an error
									window.location = response.product_url;
								} else {
									// Redirect to custom cart page (cart-2)
									var cartPage = '/cart-2/';
									// Try to get from WooCommerce params first
									if (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.cart_url) {
										// Check if it's the default cart, replace with cart-2
										if (wc_add_to_cart_params.cart_url.indexOf('/cart/') !== -1) {
											cartPage = wc_add_to_cart_params.cart_url.replace('/cart/', '/cart-2/');
										} else {
											cartPage = wc_add_to_cart_params.cart_url;
										}
									}
									window.location = cartPage;
								}
							},
							error: function() {
								// Fallback to direct URL
								window.location = $button.attr('href');
							}
						});
					}
					// Otherwise, let the default link behavior work
				}
			});
		}
	});
	
})(jQuery);

