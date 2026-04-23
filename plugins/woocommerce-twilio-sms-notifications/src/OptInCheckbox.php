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

namespace SkyVerge\WooCommerce\Twilio_SMS;

class OptInCheckbox
{
	/** @var string full name of the meta key */
	public const META_KEY = '_wc_other/skyverge/twilio-opt-in';

	/** @var string name of the legacy meta key (data has been migrated out of here) */
	public const LEGACY_META_KEY = '_wc_twilio_sms_optin';

	/**
	 * @since 1.19.0
	 */
	public static function getDefaultValue() : int
	{
		return ( 'checked' === get_option( 'wc_twilio_sms_checkout_optin_checkbox_default', 'unchecked' ) ) ? 1 : 0;
	}

	/**
	 * @since 1.19.0
	 */
	public static function getFrontEndLabel() : string
	{
		/**
		 * Filters the optin label at checkout.
		 *
		 * @since 1.12.0
		 *
		 * @param string $label the checkout label
		 */
		return (string) apply_filters( 'wc_twilio_sms_checkout_optin_label', get_option( 'wc_twilio_sms_checkout_optin_checkbox_label', '' ) );
	}
}
