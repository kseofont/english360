<?php
/**
 * LearnPress Content Drip Functions
 *
 * Define common functions for both front-end and back-end
 *
 * @author   ThimPress
 * @package  LearnPress/Content-Drip/Functions
 * @version  3.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'lp_content_drip_admin_view' ) ) {
	function lp_content_drip_admin_view( $name, $args = '' ) {
		if ( ! preg_match( '~.php$~', $name ) ) {
			$name .= '.php';
		}

		if ( is_array( $args ) ) {
			extract( $args );
		}

		include LP_ADDON_CONTENT_DRIP_INC_PATH . "admin/views/{$name}";
	}
}

if ( ! function_exists( 'lp_content_drip_types' ) ) {
	function lp_content_drip_types() {
		$types = array(
			'specific_date' => esc_html__( '1. Specific time after enrolled course', 'learnpress-content-drip' ),
			'sequentially'  => esc_html__( '2. Open the course items sequentially', 'learnpress-content-drip' ),
			'prerequisite'  => esc_html__( '3. Open item bases on prerequisite items', 'learnpress-content-drip' ),
		);

		return apply_filters( ' learn-press/content-drip/drip-types', $types );
	}
}
