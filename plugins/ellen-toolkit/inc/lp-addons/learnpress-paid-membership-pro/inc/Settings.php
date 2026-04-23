<?php

namespace LP_PMS;

use LP_Abstract_Settings_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_PMS_Setting
 */
class Settings extends LP_Abstract_Settings_Page {

	public function __construct() {
		$this->id   = 'membership';
		$this->text = esc_html__( 'Memberships', 'learnpress-paid-membership-pro' );

		parent::__construct();
	}

	public function output_section_general() {
		include LP_ADDON_PMPRO_PATH . '/inc/views/membership.php';
	}

	/**
	 * Get setting lp pms
	 *
	 * @param string $section
	 * @param string $tab
	 *
	 * @return array|array[]|bool|mixed
	 */
	public function get_settings( $section = '', $tab = '' ) {
		$link_levels_pms = '<a href="' . home_url( 'wp-admin/admin.php?page=pmpro-membershiplevels' ) . '">level</a>';

		$desc_auto_update_list_courses_on_level  = sprintf( '%s %s', __( 'LP Orders\'s users bought level PMS will update list courses when save', 'learnpress-paid-membership-pro' ), $link_levels_pms );
		$desc_auto_update_list_courses_on_level .= '<br><span style="color: red">' . __( 'Note: when remove courses on list, all progress of those courses of users will lose', 'learnpress-paid-membership-pro' ) . '</span>';

		return apply_filters(
			'lp-pms-fields-setting',
			array(
				array(
					'title' => __( 'Settings', 'learnpress-paid-membership-pro' ),
					'type'  => 'title',
				),
				array(
					'title'   => __( 'Always buy the course through membership', 'learnpress-paid-membership-pro' ),
					'id'      => 'buy_through_membership',
					'default' => 'no',
					'desc'    => __( 'Enable/Disable', 'learnpress-paid-membership-pro' ),
					'type'    => 'yes-no',
				),
				/*array(
					'title'      => __( 'Button Buy Course', 'learnpress-paid-membership-pro' ),
					'id'         => 'button_buy_course',
					'default'    => 'Buy Now',
					'type'       => 'text',
					'visibility' => array(
						'state'       => 'show',
						'conditional' => array(
							array(
								'field'   => 'buy_through_membership',
								'compare' => '!=',
								'value'   => 'yes',
							),
						),
					),
				),*/
				/*array(
					'title'   => __( 'Button Buy Membership', 'learnpress-paid-membership-pro' ),
					'id'      => 'button_buy_membership',
					'default' => 'Buy Membership',
					'type'    => 'text',
				),*/
				array(
					'type' => 'sectionend',
				),
				array(
					'title' => __( 'When membership level change', 'learnpress-paid-membership-pro' ),
					'type'  => 'title',
				),
				array(
					'title'   => __( 'Update access courses when level change list courses', 'learnpress-paid-membership-pro' ),
					'id'      => 'pmpro_update_access_course',
					'desc'    => $desc_auto_update_list_courses_on_level,
					'default' => 'no',
					'type'    => 'yes-no',
				),
				/*array(
					'title'           => __( 'Remove users old from courses if they are no longer at the required level.', 'learnpress-paid-membership-pro' ),
					'id'              => 'pms_cancel_enroll_course_removed',
					'desc'            => 'If enabled, the user will not be able to continue with the course if it\'s removed from their level. else, the user will still be able to continue with the course.',
					'default'         => 'no',
					'type'            => 'yes-no',
					'show_if_checked' => 'pmpro_update_access_course',
				),*/
				array(
					'type' => 'sectionend',
				),
			)
		);
	}
}
