<?php
$theme = wp_get_theme(); // gets the current theme
if ( 'Ellen' == $theme->name || 'Ellen' == $theme->parent_theme ) {

	require_once(ELLEN_ACC_PATH . 'inc/admin/core.php');
	require_once(ELLEN_ACC_PATH . 'inc/functions.php');

    /**
     * Redirect after theme activation
     */
    add_action( 'after_switch_theme', function() {
        if ( isset( $_GET['activated'] ) ) {
            wp_safe_redirect( admin_url('admin.php?page=ellen-activation&lk-refresh=true') );
            update_option( 'ellen_purchase_code_status', '', 'yes' );
            update_option( 'ellen_purchase_code', '', 'yes' );
            exit;
        }
        update_option('notice_dismissed', '0');
    });

    if (version_compare($theme->get('Version'), ELLEN_TOOLKIT_VERSION, '>')) {
        function ellen_toolkit_update_notice() {
            $update_message = sprintf(
                /* translators: %1$s: Plugins page URL, %2$s: Ellen Theme Plugins page URL */
                esc_html__(
                    'A new version of Ellen Toolkit is available! Please navigate to %1$s, delete the old Ellen Toolkit plugin, and then install the updated version from %2$s.',
                    'ellen'
                ),
                '<a href="' . esc_url(admin_url('plugins.php')) . '"><strong>' . esc_html__('Dashboard → Plugins', 'ellen') . '</strong></a>',
                '<a href="' . esc_url(admin_url('admin.php?page=ellen-admin-plugins')) . '"><strong>' . esc_html__('Dashboard → Ellen Theme → Plugins', 'ellen') . '</strong></a>'
            );
        
            echo '<div class="notice notice-error is-dismissible">';
            echo '<p><strong>' . esc_html__('Important Update:', 'ellen') . '</strong> ' . $update_message . '</p>';
            echo '</div>';
        }
        add_action('admin_notices', 'ellen_toolkit_update_notice');
    }
}