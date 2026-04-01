<?php

add_action('wp_enqueue_scripts', function () {
    // Parent theme enqueues 'ellen-style' with get_stylesheet_uri(), which points to child style
    // when a child theme is active. Re-register it with filemtime version for deterministic caching.
    wp_dequeue_style('ellen-style');
    wp_deregister_style('ellen-style');

    $child_style_path = get_stylesheet_directory() . '/style.css';
    $child_style_ver = file_exists($child_style_path) ? (string) filemtime($child_style_path) : null;
    wp_register_style('ellen-style', get_stylesheet_uri(), [], $child_style_ver);
    wp_enqueue_style('ellen-style');
}, 100);

add_action('wp_enqueue_scripts', function () {
    if (is_admin() || !is_user_logged_in()) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    if (strpos($request_uri, '/dashboard/zoom/set-api/') === false) {
        return;
    }

    if (!current_user_can('manage_options') && !current_user_can('tutor_instructor') && !is_super_admin()) {
        $user = wp_get_current_user();
        $roles = $user instanceof WP_User ? (array) $user->roles : [];
        if (!in_array('administrator', $roles, true) && !in_array('super_admin', $roles, true)) {
            return;
        }
    }

    $zoom_api = get_option('tutor_zoom_api', []);
    if (!is_array($zoom_api)) {
        return;
    }

    $account_id = sanitize_text_field((string) ($zoom_api['account_id'] ?? ''));
    $api_key = sanitize_text_field((string) ($zoom_api['api_key'] ?? ''));
    $api_secret = sanitize_text_field((string) ($zoom_api['api_secret'] ?? ''));
    if ($account_id === '' || $api_key === '' || $api_secret === '') {
        return;
    }

    $js = <<<JS
(function() {
    var creds = {
        account_id: %s,
        api_key: %s,
        api_secret: %s
    };

    function maskValue(value) {
        value = String(value || '');
        if (value.length <= 8) {
            return value.length ? value.charAt(0) + '*'.repeat(Math.max(value.length - 2, 0)) + value.slice(-1) : '';
        }
        return value.slice(0, 4) + '*'.repeat(value.length - 8) + value.slice(-4);
    }

    function applySync() {
        var form = document.querySelector('#tutor-zoom-settings');
        if (!form) return;

        var accountField = form.querySelector('[name="tutor_zoom_api[account_id]"]');
        var keyField = form.querySelector('[name="tutor_zoom_api[api_key]"]');
        var secretField = form.querySelector('[name="tutor_zoom_api[api_secret]"]');
        var submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        if (!accountField || !keyField || !secretField) return;

        var notice = document.querySelector('.e360-zoom-sync-notice');
        if (!notice) {
            notice = document.createElement('div');
            notice.className = 'tutor-alert tutor-alert-success e360-zoom-sync-notice';
            notice.style.marginBottom = '16px';
            notice.textContent = 'Zoom credentials are synced from site settings. Values are masked for security.';
            form.parentNode.insertBefore(notice, form);
        }

        var wasEmpty = !accountField.value.trim() && !keyField.value.trim() && !secretField.value.trim();

        accountField.setAttribute('data-e360-real-value', creds.account_id);
        keyField.setAttribute('data-e360-real-value', creds.api_key);
        secretField.setAttribute('data-e360-real-value', creds.api_secret);

        accountField.value = maskValue(creds.account_id);
        keyField.value = maskValue(creds.api_key);
        secretField.value = maskValue(creds.api_secret);

        if (form.dataset.e360ZoomRestoreBound !== '1') {
            form.dataset.e360ZoomRestoreBound = '1';
            form.addEventListener('submit', function() {
                accountField.value = accountField.getAttribute('data-e360-real-value') || '';
                keyField.value = keyField.getAttribute('data-e360-real-value') || '';
                secretField.value = secretField.getAttribute('data-e360-real-value') || '';
            });
        }

        if (!wasEmpty || !submitButton) return;

        var autosaveKey = 'e360ThemeZoomAutosave:' + window.location.pathname;
        if (window.sessionStorage && sessionStorage.getItem(autosaveKey) === '1') {
            return;
        }
        if (window.sessionStorage) {
            sessionStorage.setItem(autosaveKey, '1');
        }

        window.setTimeout(function() {
            submitButton.click();
        }, 250);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applySync);
    } else {
        applySync();
    }
})();
JS;

    $js = sprintf(
        $js,
        wp_json_encode($account_id),
        wp_json_encode($api_key),
        wp_json_encode($api_secret)
    );

    wp_add_inline_script('tutor_zoom_frontend_js-js', $js, 'after');
}, 200);



add_action('show_user_profile', 'technical_admin_type_field');
add_action('edit_user_profile', 'technical_admin_type_field');
function technical_admin_type_field($user) {
    if (!current_user_can('administrator')) return;
    $type = get_user_meta($user->ID, 'restricted_admin_type', true);
    ?>
<h3>Налаштування обмеженого доступу</h3>
<table class="form-table">
    <tr>
        <th><label for="restricted_admin_type">Тип доступу</label></th>
        <td>
            <select name="restricted_admin_type" id="restricted_admin_type">
                <option value="" <?php selected($type, ''); ?>>Повний Адміністратор</option>
                <option value="super_admin" <?php selected($type, 'super_admin'); ?>>Super Admin (Обмежене меню)
                </option>
                <option value="simple_admin" <?php selected($type, 'simple_admin'); ?>>Simple Admin (Тільки курси)
                </option>
            </select>
            <p class="description">Користувач залишиться Адміністратором для системи, але бачитиме обмежене меню.</p>
        </td>
    </tr>
</table>
<?php
}

add_action('personal_options_update', 'technical_save_admin_type');
add_action('edit_user_profile_update', 'technical_save_admin_type');
function technical_save_admin_type($user_id) {
    if (current_user_can('administrator')) {
        update_user_meta($user_id, 'restricted_admin_type', $_POST['restricted_admin_type']);
    }
}
add_action('admin_head', function() {
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if ($type === 'simple_admin' || $type === 'super_admin') {
        echo '<style>
            #adminmenu > li:not(#toplevel_page_tutor):not(#menu-users):not(#menu-dashboard) { 
                display: none !important; 
            }
            
            ' . ($type === 'simple_admin' ? '
                #toplevel_page_tutor .wp-submenu li a[href*="settings"],
                #toplevel_page_tutor .wp-submenu li a[href*="addons"],
                #toplevel_page_tutor .wp-submenu li a[href*="tools"] { display: none !important; }
            ' : '') . '

            .update-nag, .notice:not(.tutor-notice), #footer-thankyou { display: none !important; }
        </style>';
    }
});


add_action('admin_menu', function() {
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if ($type === 'simple_admin' || $type === 'super_admin') {
        $hide = ['edit.php', 'edit.php?post_type=page', 'themes.php', 'plugins.php', 'tools.php', 'options-general.php', 'woocommerce', 'elementor', 'theme-options'];
        foreach ($hide as $p) { remove_menu_page($p); }
    }
}, 9999);

add_action('pre_get_users', function($query) {
    if (!is_admin()) return;
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if ($type === 'simple_admin') {
        $query->set('role__in', ['tutor_instructor', 'subscriber']);
    }
});

add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if (($type === 'simple_admin' || $type === 'super_admin') && in_array($cap, ['edit_user', 'delete_user'])) {
        if (isset($args[0])) {
            $target_type = get_user_meta($args[0], 'restricted_admin_type', true);
            if (!$target_type && $args[0] != get_current_user_id()) {
                $caps[] = 'do_not_allow';
            }
        }
    }
    return $caps;
}, 10, 4);
add_filter('woocommerce_prevent_admin_access', '__return_false');
add_filter('query', function($query) {
    if (strpos($query, 'wp_f150ff0ea0_tutor_subscriptions') !== false) {
        
        $query = str_replace('WHERE user_id =', 'WHERE s.user_id =', $query);
        $current_user = wp_get_current_user();
        if (in_array('simple_admin', (array) $current_user->roles) || in_array('super_admin', (array) $current_user->roles)) {
            $query = preg_replace('/WHERE s\.user_id = \d+/', 'WHERE 1=1', $query);
        }
    }
    return $query;
});

add_action('admin_init', function() {
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if ($type === 'simple_admin' || $type === 'super_admin') {
        remove_meta_box('dashboard_primary', 'dashboard', 'side'); 
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); 
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); 
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');  
        remove_meta_box('tutor_admin_stat_reporting_widget', 'dashboard', 'normal'); 
    }
});

add_action('admin_head', function() {
    $type = get_user_meta(get_current_user_id(), 'restricted_admin_type', true);
    if ($type === 'simple_admin' || $type === 'super_admin') {
        echo '<style>#welcome-panel, .postbox-container .empty-container { display: none !important; }</style>';
    }
});

add_action('wp', function () {
    if (is_user_logged_in()) {
        global $ellen_opt;

        if (is_array($ellen_opt)) {
            // Скрыть блок с кнопкой (условие в теме больше не пройдёт)
            $ellen_opt['profile_text'] = '';
            $ellen_opt['login_register_title'] = '';
        }
    }
}, 1);

function e360_theme_can_sync_tutor_zoom_api(): bool {
    if (!is_user_logged_in()) {
        return false;
    }

    if (current_user_can('manage_options') || current_user_can('tutor_instructor') || is_super_admin()) {
        return true;
    }

    $user = wp_get_current_user();
    $roles = $user instanceof WP_User ? (array) $user->roles : [];

    return in_array('super_admin', $roles, true) || in_array('administrator', $roles, true);
}

function e360_theme_is_zoom_api_route(): bool {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    return strpos($request_uri, '/dashboard/zoom/set-api/') !== false;
}

add_action('template_redirect', function () {
    if (is_admin() || !e360_theme_is_zoom_api_route()) {
        return;
    }

    if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
    if (!defined('DONOTCACHEOBJECT')) define('DONOTCACHEOBJECT', true);
    if (!defined('DONOTCACHEDB')) define('DONOTCACHEDB', true);
    nocache_headers();
}, 0);

function e360_theme_output_zoom_api_sync(): void {
    static $printed = false;
    if ($printed || is_admin() || !e360_theme_can_sync_tutor_zoom_api() || !e360_theme_is_zoom_api_route()) {
        return;
    }

    $zoom_api = get_option('tutor_zoom_api', []);
    if (!is_array($zoom_api)) {
        return;
    }

    $account_id = sanitize_text_field((string) ($zoom_api['account_id'] ?? ''));
    $api_key = sanitize_text_field((string) ($zoom_api['api_key'] ?? ''));
    $api_secret = sanitize_text_field((string) ($zoom_api['api_secret'] ?? ''));

    if ($account_id === '' || $api_key === '' || $api_secret === '') {
        return;
    }

    $printed = true;
    ?>
<script id="e360-theme-zoom-api-sync">
(function() {
    var creds = {
        account_id: <?php echo wp_json_encode($account_id); ?>,
        api_key: <?php echo wp_json_encode($api_key); ?>,
        api_secret: <?php echo wp_json_encode($api_secret); ?>
    };

    function maskValue(value) {
        value = String(value || '');
        if (value.length <= 8) {
            return value.length ? value.charAt(0) + '*'.repeat(Math.max(value.length - 2, 0)) + value.slice(-1) : '';
        }
        return value.slice(0, 4) + '*'.repeat(value.length - 8) + value.slice(-4);
    }

    function applySync() {
        var form = document.querySelector('#tutor-zoom-settings');
        if (!form) return;

        var accountField = form.querySelector('[name="tutor_zoom_api[account_id]"]');
        var keyField = form.querySelector('[name="tutor_zoom_api[api_key]"]');
        var secretField = form.querySelector('[name="tutor_zoom_api[api_secret]"]');
        var submitButton = form.querySelector('button[type="submit"], input[type="submit"]');

        if (!accountField || !keyField || !secretField) return;

        var notice = document.querySelector('.e360-zoom-sync-notice');
        if (!notice) {
            notice = document.createElement('div');
            notice.className = 'tutor-alert tutor-alert-success e360-zoom-sync-notice';
            notice.style.marginBottom = '16px';
            notice.textContent = 'Zoom credentials are synced from site settings. Values are masked for security.';
            form.parentNode.insertBefore(notice, form);
        }

        var wasEmpty = !accountField.value.trim() && !keyField.value.trim() && !secretField.value.trim();

        accountField.setAttribute('data-e360-real-value', creds.account_id);
        keyField.setAttribute('data-e360-real-value', creds.api_key);
        secretField.setAttribute('data-e360-real-value', creds.api_secret);

        accountField.value = maskValue(creds.account_id);
        keyField.value = maskValue(creds.api_key);
        secretField.value = maskValue(creds.api_secret);

        if (form.dataset.e360ZoomRestoreBound !== '1') {
            form.dataset.e360ZoomRestoreBound = '1';
            form.addEventListener('submit', function() {
                accountField.value = accountField.getAttribute('data-e360-real-value') || '';
                keyField.value = keyField.getAttribute('data-e360-real-value') || '';
                secretField.value = secretField.getAttribute('data-e360-real-value') || '';
            });
        }

        if (!wasEmpty || !submitButton) return;

        var autosaveKey = 'e360ThemeZoomAutosave:' + window.location.pathname;
        if (window.sessionStorage && sessionStorage.getItem(autosaveKey) === '1') {
            return;
        }

        if (window.sessionStorage) {
            sessionStorage.setItem(autosaveKey, '1');
        }

        window.setTimeout(function() {
            submitButton.click();
        }, 250);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applySync);
    } else {
        applySync();
    }
})();
</script>
<?php
}

add_action('wp_head', 'e360_theme_output_zoom_api_sync', 99);
add_action('wp_footer', 'e360_theme_output_zoom_api_sync', 99);
