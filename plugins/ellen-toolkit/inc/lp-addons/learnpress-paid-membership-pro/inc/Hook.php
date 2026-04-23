<?php

namespace LP_PMS;

use LearnPress\Helpers\Template;
use LearnPress\Models\CourseModel;
use LearnPress\Models\UserItems\UserCourseModel;
use LearnPress\Models\UserModel;
use LP_Addon_Paid_Memberships_Pro_Preload;

/**
 * Class Hook
 *
 * Handle hook of plugin.
 */
class Hook {

	public function __construct() {
		// Hook display button buy via pms
		add_filter( 'learn-press/course/html-button-enroll', array( $this, 'html_btn_buy_member' ), 11, 3 );
		add_filter( 'learn-press/course/html-button-purchase', array( $this, 'html_btn_buy_member' ), 11, 3 );

		add_filter( 'learn_press/order_item_name', array( $this, 'name_course_order' ), 10, 3 );
		add_filter( 'learn_pres_pmpro_course_header_level', array( $this, 'name_course_membership_checkout' ), 10, 3 );
	}

	/**
	 * Get html button buy membership.
	 *
	 * @param array $section
	 * @param CourseModel $course
	 * @param UserModel|false $user
	 *
	 * @return array
	 * @since 4.0.7
	 */
	public function html_btn_buy_member( $section, $course, $user ) {
		$lp_addon = LP_Addon_Paid_Memberships_Pro_Preload::$addon;
		$user_id  = 0;
		if ( $user instanceof UserModel ) {
			$user_id = $user->get_id();
		}

		// Check course has membership level
		$levels = $lp_addon->get_levels_of_course( $course );
		if ( empty( $levels ) || empty( $levels[0] ) ) {
			return $section;
		}

		$levels_page_id = $lp_addon->get_pms_levels_page_id();
		$link_pms       = add_query_arg(
			'course_id',
			$course->get_id(),
			get_the_permalink( $levels_page_id )
		);

		if ( $lp_addon->is_only_buy_via_pms() ) {
			$section['btn'] = '';
		}

		$html_btn_pms = sprintf(
			'<a class="btn-buy-via-member-ship" href="%s">%s</a>',
			$link_pms,
			sprintf(
				'<button type="button" class="lp-button">%s</button>',
				__( 'Buy Membership', 'learnpress-paid-membership-pro' )
			)
		);

		return Template::insert_value_to_position_array( $section, 'after', 'btn', 'btn_pms', $html_btn_pms );
	}

	/**
	 * Display label course full students.
	 *
	 * @param $name
	 * @param $item
	 * @param $order
	 *
	 * @return mixed|string
	 * @since 4.0.6
	 * @version 1.0.0
	 */
	public function name_course_order( $name, $item, $order ) {
		$course_id                   = $item['course_id'] ?? '';
		$order_id                    = $order->get_id();
		$course_ids_out_of_stock     = [];
		$key                         = '_lp_course_out_stock';
		$course_ids_out_of_stock_str = get_post_meta( $order_id, $key, true );
		if ( ! empty( $course_ids_out_of_stock_str ) ) {
			$course_ids_out_of_stock = explode( ',', $course_ids_out_of_stock_str );
		}

		if ( empty( $course_ids_out_of_stock ) ) {
			return $name;
		}

		if ( in_array( $course_id, $course_ids_out_of_stock ) ) {
			$name = sprintf( '%s - %s', $name, esc_html__( 'The course is full of students.', 'learnpress' ) );
		}

		return $name;
	}

	/**
	 * Show out of stock course in PMS checkout page.
	 *
	 * @param $link
	 * @param $course_item
	 * @param $key
	 *
	 * @return mixed|string
	 * @since 4.0.6
	 * @version 1.0.1
	 */
	public function name_course_membership_checkout( $link, $course_item, $key ) {
		$course_id = $key['id'];
		$course    = CourseModel::find( $course_id, true );
		$user_id   = get_current_user_id();

		$userCourse = UserCourseModel::find( $user_id, $course_id, true );
		if ( ! $userCourse && ! $course->is_in_stock() && ! $course->has_no_enroll_requirement() ) {
			$link = sprintf(
				'<td class="list-main item-td">%s - %s</td>',
				wp_kses_post( $course_item ),
				esc_html__( 'The course is full of students.', 'learnpress' )
			);
		}

		return $link;
	}
}
