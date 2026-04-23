<?php
/**
 * WooCommerce Twilio SMS Notifications
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Twilio SMS Notifications to newer
 * versions in the future. If you wish to customize WooCommerce Twilio SMS Notifications for your
 * needs please refer to http://docs.woocommerce.com/document/twilio-sms-notifications/ for more information.
 *
 * @author      SkyVerge
 * @copyright   Copyright (c) 2013-2025, SkyVerge, Inc. (info@skyverge.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace SkyVerge\WooCommerce\Twilio_SMS\Blocks;

use Automattic\WooCommerce\Blocks\Domain\Services\CheckoutFields;
use Exception;
use SkyVerge\WooCommerce\Twilio_SMS\OptInCheckbox;
use WC_Data;

class CheckoutBlockIntegration {

	/** @var string opt-in checkbox field ID */
	public string $field_id = 'skyverge/twilio-opt-in';

	 /**
	  * Registers hooks.
	  *
	  * Note: We don't have a hook for saving data, because WooCommerce does that for us automatically.
	  *
	  * @since 1.19.0
	  */
	public function addHooks() : void
	{
		add_action( 'wp_loaded', [ $this, 'registerAdditionalCheckoutField' ] );
		add_action( "woocommerce_get_default_value_for_{$this->field_id}", [ $this, 'maybeSetCheckedState' ], 10, 3 );
	}

	/**
	 * Register opt-in checkbox via the Additional Fields API
	 *
	 * @since 1.19.0
	 * @see https://github.com/woocommerce/woocommerce/blob/trunk/docs/cart-and-checkout-blocks/additional-checkout-fields.md
	 */
	public function registerAdditionalCheckoutField() : void
	{
		$optin_label = OptInCheckbox::getFrontEndLabel();

		if( ! empty( $optin_label ) && is_callable('woocommerce_register_additional_checkout_field') ) {
			try {
				woocommerce_register_additional_checkout_field(
					[
						'id'       => $this->field_id,
						'label'    => $optin_label,
						'location' => 'order',
						'type'     => 'checkbox',
					]
				);
			} catch(Exception $e) {
				wc_twilio_sms()->log(sprintf('Failed to register block checkout field: %s', $e->getMessage()));
			}
		}
	}

	 /**
	  * Customizes the default value to be checked on or off.
	  *
	  * {@see CheckoutFields::get_field_from_object()}
	  *
	  * @internal
	  *
	  * @since 1.19.0
	  *
	  * @param null|mixed $value
	  * @param string|mixed $group
	  * @param WC_Data|mixed $wc_object
	  * @return int
	  */
	public function maybeSetCheckedState($value, $group, $wc_object) : int
	{
		return OptInCheckbox::getDefaultValue();
	}
}
