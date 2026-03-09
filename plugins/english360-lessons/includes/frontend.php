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
