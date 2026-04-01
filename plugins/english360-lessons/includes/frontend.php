<?php
defined('ABSPATH') || exit;

add_action('template_redirect', function () {
    if (!is_singular(['courses', 'tutor_course'])) {
        return;
    }

    if (!defined('DONOTCACHEPAGE')) {
        define('DONOTCACHEPAGE', true);
    }
    if (!defined('DONOTCACHEOBJECT')) {
        define('DONOTCACHEOBJECT', true);
    }
    if (!defined('DONOTCACHEDB')) {
        define('DONOTCACHEDB', true);
    }

    nocache_headers();
}, 0);

function e360_course_placeholder_image_url(): string {
    return 'https://lms.english360.ca/wp-content/uploads/2026/02/course-placeholder-english360.png';
}

function e360_is_tutor_course_post($post): bool {
    $post_obj = is_object($post) ? $post : get_post((int) $post);
    if (!$post_obj instanceof WP_Post) {
        return false;
    }

    return in_array($post_obj->post_type, ['courses', 'tutor_course'], true);
}

add_filter('post_thumbnail_url', function ($url, $post, $size) {
    if (is_admin()) {
        return $url;
    }

    if (!empty($url)) {
        return $url;
    }

    if (!e360_is_tutor_course_post($post)) {
        return $url;
    }

    return e360_course_placeholder_image_url();
}, 10, 3);

add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (is_admin()) {
        return $html;
    }

    if (!empty($html) || !empty($post_thumbnail_id)) {
        return $html;
    }

    if (!e360_is_tutor_course_post((int) $post_id)) {
        return $html;
    }

    $size_class = is_string($size) && $size !== '' ? 'attachment-' . sanitize_html_class($size) : 'attachment-post-thumbnail';
    $alt = get_the_title((int) $post_id);

    return sprintf(
        '<img src="%1$s" class="%2$s wp-post-image e360-course-placeholder" alt="%3$s" loading="lazy" />',
        esc_url(e360_course_placeholder_image_url()),
        esc_attr($size_class),
        esc_attr($alt)
    );
}, 10, 5);

function e360_course_booking_url(int $course_id): string {
    $args = [
        'course_id' => $course_id,
    ];
    if (function_exists('e360_booking_prefill_from_course')) {
        $prefill = e360_booking_prefill_from_course($course_id, 'course-category');
        if (!empty($prefill['language_term_id'])) {
            $args['language_term_id'] = (int) $prefill['language_term_id'];
        }
        if (!empty($prefill['level_term_id'])) {
            $args['level_term_id'] = (int) $prefill['level_term_id'];
        }
    }
    return add_query_arg($args, home_url('/booking/'));
}

add_action('wp_enqueue_scripts', function () {
    if (is_admin()) {
        return;
    }
    wp_enqueue_style(
        'e360-tutor-course-frontend',
        E360_LESSONS_URL . 'assets/css/tutor-course.css',
        [],
        '0.1.1'
    );
});

add_action('wp_footer', function () {
    if (is_admin()) {
        return;
    }
    ?>
<script id="e360-tutor-course-btn-text-fix">
(function() {
    function normalizeTutorCourseButtons(root) {
        var scope = root || document;
        var buttons = scope.querySelectorAll(
            '.single-courses-box a[href*="/courses/"], ' +
            '.popover-quickview-courses a[href*="/courses/"]'
        );

        buttons.forEach(function(btn) {
            var isCta = !!btn.closest('.btn-box') ||
                btn.classList.contains('default-btn') ||
                btn.className.indexOf('tutor-btn') !== -1;
            if (!isCta) {
                return;
            }

            btn.querySelectorAll('i').forEach(function(icon) {
                icon.remove();
            });

            btn.classList.remove(
                'tutor-btn',
                'tutor-btn-outline-primary',
                'tutor-btn-md',
                'tutor-btn-block',
                'tutor-btn-ghost',
                'tutor-mr-16'
            );
            btn.classList.add('default-btn');
            btn.textContent = 'View Details';

            var parent = btn.parentElement;
            if (parent && parent.tagName === 'DIV' && parent.classList.contains('default-btn')) {
                parent.parentNode.insertBefore(btn, parent);
                parent.remove();
            }
        });
    }

    normalizeTutorCourseButtons(document);

    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node && node.nodeType === 1) {
                    normalizeTutorCourseButtons(node);
                }
            });
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
})();
</script>
<?php
});

function e360_can_sync_tutor_zoom_api_for_user(): bool {
    if (!is_user_logged_in()) {
        return false;
    }

    if (current_user_can('manage_options') || current_user_can('tutor_instructor') || is_super_admin()) {
        return true;
    }

    $user = wp_get_current_user();
    $roles = is_a($user, 'WP_User') ? (array) $user->roles : [];

    return in_array('super_admin', $roles, true) || in_array('administrator', $roles, true);
}

function e360_is_tutor_zoom_settings_route(): bool {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    return strpos($request_uri, '/dashboard/zoom/set-api/') !== false;
}

function e360_decode_tutor_zoom_api_meta($raw): array {
    if (is_array($raw)) {
        $data = $raw;
    } else {
        $data = json_decode((string) $raw, true);
    }

    if (!is_array($data)) {
        return [];
    }

    $account_id = sanitize_text_field((string) ($data['account_id'] ?? ''));
    $api_key    = sanitize_text_field((string) ($data['api_key'] ?? ''));
    $api_secret = sanitize_text_field((string) ($data['api_secret'] ?? ''));

    if ($account_id === '' || $api_key === '' || $api_secret === '') {
        return [];
    }

    return [
        'account_id' => $account_id,
        'api_key'    => $api_key,
        'api_secret' => $api_secret,
    ];
}

function e360_get_site_tutor_zoom_api_credentials(): array {
    $current_user_id = get_current_user_id();
    if ($current_user_id > 0) {
        $current_creds = e360_decode_tutor_zoom_api_meta(get_user_meta($current_user_id, 'tutor_zoom_api', true));
        if ($current_creds) {
            return $current_creds;
        }
    }

    $candidate_ids = get_users([
        'fields'   => 'ids',
        'number'   => 25,
        'orderby'  => 'ID',
        'order'    => 'ASC',
        'meta_key' => 'tutor_zoom_api',
    ]);

    if (!is_array($candidate_ids)) {
        return [];
    }

    $fallback = [];

    foreach ($candidate_ids as $candidate_id) {
        $candidate_id = (int) $candidate_id;
        if ($candidate_id <= 0) {
            continue;
        }

        $creds = e360_decode_tutor_zoom_api_meta(get_user_meta($candidate_id, 'tutor_zoom_api', true));
        if (!$creds) {
            continue;
        }

        if (user_can($candidate_id, 'manage_options') || is_super_admin($candidate_id)) {
            return $creds;
        }

        if (!$fallback) {
            $fallback = $creds;
        }
    }

    return $fallback;
}

function e360_sync_current_user_tutor_zoom_api(): void {
    if (is_admin() || !e360_can_sync_tutor_zoom_api_for_user() || !e360_is_tutor_zoom_settings_route()) {
        return;
    }

    $user_id = get_current_user_id();
    if ($user_id <= 0) {
        return;
    }

    $existing = e360_decode_tutor_zoom_api_meta(get_user_meta($user_id, 'tutor_zoom_api', true));
    if ($existing) {
        return;
    }

    $creds = e360_get_site_tutor_zoom_api_credentials();
    if (!$creds) {
        return;
    }

    update_user_meta($user_id, 'tutor_zoom_api', wp_json_encode($creds));
}

add_action('template_redirect', function () {
    if (is_admin() || !e360_is_tutor_zoom_settings_route()) {
        return;
    }

    if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
    if (!defined('DONOTCACHEOBJECT')) define('DONOTCACHEOBJECT', true);
    if (!defined('DONOTCACHEDB')) define('DONOTCACHEDB', true);
    nocache_headers();
    e360_sync_current_user_tutor_zoom_api();
}, 0);

function e360_output_tutor_zoom_sync_script(): void {
    static $printed = false;
    if ($printed) {
        return;
    }

    if (is_admin() || !e360_can_sync_tutor_zoom_api_for_user() || !e360_is_tutor_zoom_settings_route()) {
        return;
    }

    $creds = e360_get_site_tutor_zoom_api_credentials();
    if (!$creds) {
        return;
    }

    $printed = true;
    ?>
<script id="e360-sync-tutor-zoom-api">
(function() {
    var creds = {
        account_id: <?php echo wp_json_encode($creds['account_id']); ?>,
        api_key: <?php echo wp_json_encode($creds['api_key']); ?>,
        api_secret: <?php echo wp_json_encode($creds['api_secret']); ?>
    };

    function maskValue(value) {
        value = String(value || '');
        if (value.length <= 8) {
            return value.length ? value.charAt(0) + '*'.repeat(Math.max(value.length - 2, 0)) + value.slice(-1) : '';
        }
        return value.slice(0, 4) + '*'.repeat(value.length - 8) + value.slice(-4);
    }

    function ensureNotice(form) {
        if (!form || form.previousElementSibling && form.previousElementSibling.classList.contains('e360-zoom-sync-notice')) {
            return;
        }

        var notice = document.createElement('div');
        notice.className = 'tutor-alert tutor-alert-success e360-zoom-sync-notice';
        notice.style.marginBottom = '16px';
        notice.innerHTML = 'Zoom credentials are synced from site settings. Values are masked for security.';
        form.parentNode.insertBefore(notice, form);
    }

    function attachSubmitRestore(form, fields) {
        if (!form || form.dataset.e360ZoomRestoreBound === '1') return;
        form.dataset.e360ZoomRestoreBound = '1';

        form.addEventListener('submit', function() {
            fields.forEach(function(field) {
                if (!field) return;
                var realValue = field.getAttribute('data-e360-real-value') || '';
                if (realValue) {
                    field.value = realValue;
                }
            });
        });
    }

    function applyZoomCredentials() {
        var form = document.querySelector('#tutor-zoom-settings');
        if (!form) return;
        ensureNotice(form);

        var accountField = form.querySelector('[name="tutor_zoom_api[account_id]"]');
        var keyField = form.querySelector('[name="tutor_zoom_api[api_key]"]');
        var secretField = form.querySelector('[name="tutor_zoom_api[api_secret]"]');
        var submitButton = form.querySelector('button[type="submit"], input[type="submit"]');

        if (!accountField || !keyField || !secretField) return;

        var wasEmpty = !accountField.value.trim() && !keyField.value.trim() && !secretField.value.trim();

        accountField.setAttribute('data-e360-real-value', creds.account_id);
        keyField.setAttribute('data-e360-real-value', creds.api_key);
        secretField.setAttribute('data-e360-real-value', creds.api_secret);

        accountField.value = maskValue(creds.account_id);
        keyField.value = maskValue(creds.api_key);
        secretField.value = maskValue(creds.api_secret);

        attachSubmitRestore(form, [accountField, keyField, secretField]);

        accountField.dispatchEvent(new Event('input', { bubbles: true }));
        keyField.dispatchEvent(new Event('input', { bubbles: true }));
        secretField.dispatchEvent(new Event('input', { bubbles: true }));
        accountField.dispatchEvent(new Event('change', { bubbles: true }));
        keyField.dispatchEvent(new Event('change', { bubbles: true }));
        secretField.dispatchEvent(new Event('change', { bubbles: true }));

        if (!wasEmpty || !submitButton) return;

        var autosaveKey = 'e360TutorZoomAutosave:' + window.location.pathname;
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
        document.addEventListener('DOMContentLoaded', applyZoomCredentials);
    } else {
        applyZoomCredentials();
    }
})();
</script>
<?php
}

add_action('wp_head', 'e360_output_tutor_zoom_sync_script', 99);
add_action('wp_footer', 'e360_output_tutor_zoom_sync_script', 99);

add_action('wp_footer', function () {
    if (is_admin()) {
        return;
    }

    $course_id = is_singular(['courses', 'tutor_course']) ? (int) get_the_ID() : 0;
    $booking_url = $course_id > 0 ? e360_course_booking_url($course_id) : home_url('/booking/');
    ?>
<script id="e360-course-sidebar-booking-cta">
(function() {
    var defaultBookingUrl = <?php echo wp_json_encode($booking_url); ?>;

    function extractCourseId(scope) {
        if (!scope) return 0;
        var link = scope.querySelector('a[href*="course_id="]');
        if (!link) return 0;
        try {
            var url = new URL(link.href, window.location.origin);
            return parseInt(url.searchParams.get('course_id') || '0', 10) || 0;
        } catch (e) {
            return 0;
        }
    }

    function buildBookingUrl(courseId) {
        try {
            var url = new URL(defaultBookingUrl, window.location.origin);
            if (courseId > 0) {
                url.searchParams.set('course_id', String(courseId));
            }
            return url.toString();
        } catch (e) {
            return defaultBookingUrl;
        }
    }

    function ensureCta(cardBody, courseId) {
        if (!cardBody) return;
        cardBody.classList.add('e360-booking-cta-ready');
        var cta = cardBody.querySelector('.e360-course-booking-cta');
        if (!cta) {
            cta = document.createElement('div');
            cta.className = 'e360-course-booking-cta tutor-mt-20';

            var link = document.createElement('a');
            link.className = 'tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block';
            link.textContent = 'Book Lesson';
            cta.appendChild(link);
            cardBody.appendChild(cta);
        }

        var ctaLink = cta.querySelector('a');
        if (ctaLink) {
            ctaLink.href = buildBookingUrl(courseId);
        }
    }

    function replacePlans() {
        var plansList = document.querySelectorAll('.tutor-subscription-plans');
        if (!plansList.length) return;

        plansList.forEach(function(plans) {
            var cardBody = plans.closest('.tutor-card-body');
            if (!cardBody) return;

            var courseId = extractCourseId(plans) || <?php echo (int) $course_id; ?>;
            ensureCta(cardBody, courseId);

            if (!plans.dataset.e360Processed) {
                plans.dataset.e360Processed = '1';
                plans.classList.add('e360-hidden-by-e360');
                plans.style.display = 'none';
            }
        });
    }

    replacePlans();

    var observer = new MutationObserver(function() {
        replacePlans();
    });
    observer.observe(document.body, { childList: true, subtree: true });
})();
</script>
<?php
});
