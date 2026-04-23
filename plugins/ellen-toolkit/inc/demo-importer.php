<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function ellen_data_loss_warning($links) {
    $html  = '<div style="margin-top:20px;color:#856404;font-size:18px;line-height:1.3;font-weight:600;margin-bottom:40px;background-color: #ffeeba;padding:10px 10px;border-radius: 10px;">';
    $html .= __('All of your existing data will be erased if you install/import One Click demo data from here, so we recommend importing demo data only for a new website.', 'ellen-toolkit');
    $html .= '</div>';
    return $html;
}        
add_filter('rt_demo_installer_warning', 'ellen_data_loss_warning');

// Initializing online demo contents
function _filter_ellen_fw_ext_backups_demos( $demos ) {
	$demos_array			 = array(
		'tutor-demo'	=> array(
			'title'			 => esc_html__( 'Tutor Demo', 'ellen' ),
			'screenshot'	 => esc_url( get_template_directory_uri() ) . '/screenshot.png',
			'preview_link'	 => esc_url( 'https://themes.envytheme.com/ellen/' ),
		),
		'learnpress-demo'	=> array(
			'title'			 => esc_html__( 'LearnPress Demo', 'ellen' ),
			'screenshot'	 => esc_url( get_template_directory_uri() ) . '/screenshot.png',
			'preview_link'	 => esc_url( 'https://themes.envytheme.com/ellen-lp/' ),
		),
	);

	$download_url	 = 'https://themes.envytheme.com/tools/ellen/';
	
	foreach ( $demos_array as $id => $data ) {
		$demo			 = new FW_Ext_Backups_Demo( $id, 'piecemeal', array(
			'url'		 => $download_url,
			'file_id'	 => $id,
		) );
		$demo->set_title( $data[ 'title' ] );
		$demo->set_screenshot( $data[ 'screenshot' ] );
		$demo->set_preview_link( $data[ 'preview_link' ] );
		$demos[ $demo->get_id() ]	 = $demo;
		unset( $demo );
	}
	return $demos;
}
add_filter( 'fw:ext:backups-demo:demos', '_filter_ellen_fw_ext_backups_demos' );