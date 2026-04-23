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

namespace SkyVerge\WooCommerce\Twilio_SMS\BackwardsCompatibility;

use Automattic\WooCommerce\Internal\DataStores\Orders\OrdersTableDataStore;
use SkyVerge\WooCommerce\Twilio_SMS\OptInCheckbox;
use WC_Order;

/**
 * Version 1.19.0 changed the order opt-in meta key from {@see OptInCheckbox::LEGACY_META_KEY} to {@see OptInCheckbox::META_KEY}.
 * This class handles all backwards compatibility with the old meta key name, including re-routing "get meta" calls
 * to use the new key.
 *
 * @since 1.19.0
 */
class OrderMetaKeyMigrationHandler
{
	public function addHooks() : void
	{
		// reroute reads
		add_filter('get_post_metadata', [$this, 'maybeRerouteGetLegacyPostMeta'], 10, 4);
		/** {@see \WC_Data::get_meta()} */
		add_filter('woocommerce_order_get_'.OptInCheckbox::LEGACY_META_KEY, [$this, 'rerouteLegacyOrderMeta'], 10, 2);

		// reroute writes
		add_filter('update_post_metadata', [$this, 'maybeRerouteUpdatingLegacyPostMeta'], 10, 5);
	}

	/**
	 * Migrates the Twilio opt-in meta to a new meta key name.
	 */
	public static function migrate() : void
	{
		global $wpdb;

		$tablesToUpdate = [
			$wpdb->postmeta, // legacy order storage
			OrdersTableDataStore::get_meta_table_name(), // HPOS storage
		];

		foreach($tablesToUpdate as $tableName) {
			wc_twilio_sms()->log(sprintf('Starting migration on table %s', $tableName));

			$numberRecords = (int) $wpdb->get_var($wpdb->prepare(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT COUNT(*) from {$tableName} WHERE meta_key = %s",
				[OptInCheckbox::LEGACY_META_KEY]
			));

			wc_twilio_sms()->log(sprintf('Found %d record(s).', $numberRecords));

			if (! $numberRecords) {
				continue;
			}

			$numberRowsUpdated = $wpdb->update(
				$tableName,
				['meta_key' => OptInCheckbox::META_KEY],
				['meta_key' => OptInCheckbox::LEGACY_META_KEY],
				['%s'],
				['%s']
			);

			if ($numberRowsUpdated === false) {
				wc_twilio_sms()->log(sprintf('Error while migrating. Last SQL message: %s', $wpdb->last_error));
			} else {
				wc_twilio_sms()->log(sprintf('%d record(s) updated.', $numberRowsUpdated));
			}
		}
	}

	protected function triggerDeprecationNotice() : void
	{
		wc_doing_it_wrong(
			OptInCheckbox::LEGACY_META_KEY,
			sprintf('The %1%s meta key is deprecated. Use %2$s instead.', OptInCheckbox::LEGACY_META_KEY, OptInCheckbox::META_KEY),
			'1.19.0'
		);
	}

	/**
	 * Reroutes reading legacy metadata when using post meta.
	 *
	 * @param null|mixed $shortCircuitValue The short-circuit meta value. Default null affects nothing.
	 * @param int $objectId Object ID.
	 * @param string $metaKey Meta key.
	 * @param bool $single Whether to return only the first value.
	 * @return mixed
	 */
	public function maybeRerouteGetLegacyPostMeta($shortCircuitValue, $objectId, $metaKey, $single)
	{
		if ($metaKey !== OptInCheckbox::LEGACY_META_KEY) {
			return $shortCircuitValue;
		}

		$this->triggerDeprecationNotice();

		return get_post_meta($objectId, OptInCheckbox::META_KEY, $single);
	}

	/**
	 * Reroutes writing legacy metadata when using post meta.
	 *
	 * @param null|bool $shortCircuitValue Whether to allow updating metadata for the given type.
	 * @param int $objectId ID of the object metadata is for.
	 * @param string $metaKey Metadata key.
	 * @param mixed $metaValue Metadata value. Must be serializable if non-scalar.
	 * @param mixed $prevValue Optional. Previous value to check before updating.
	 *                               If specified, only update existing metadata entries with
	 *                               this value. Otherwise, update all entries.
	 *
	 * @return null|bool
	 */
	public function maybeRerouteUpdatingLegacyPostMeta($shortCircuitValue, $objectId, $metaKey, $metaValue, $prevValue)
	{
		if ($metaKey !== OptInCheckbox::LEGACY_META_KEY) {
			return $shortCircuitValue;
		}

		$this->triggerDeprecationNotice();

		return update_post_meta($objectId, OptInCheckbox::META_KEY, $metaValue, $prevValue);
	}

	/**
	 * Reroutes reading order metadata when using HPOS.
	 *
	 * @param mixed $value
	 * @param WC_Order|mixed $order
	 * @return void
	 */
	public function rerouteLegacyOrderMeta($value, $order)
	{
		if (! $order instanceof WC_Order) {
			return $value;
		}

		$this->triggerDeprecationNotice();

		return $order->get_meta(OptInCheckbox::META_KEY);
	}
}
