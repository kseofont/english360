<?php
defined('ABSPATH') || exit;

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

function e360_page_has_shortcode(string $tag): bool {
    if (!is_singular()) {
        return false;
    }

    $post = get_post();
    if (!$post instanceof WP_Post) {
        return false;
    }

    return has_shortcode((string) $post->post_content, $tag);
}

add_action('wp_enqueue_scripts', function () {
    if (is_admin()) {
        return;
    }
    wp_enqueue_style(
        'e360-tutor-course-frontend',
        E360_LESSONS_URL . 'assets/css/tutor-course.css',
        [],
        '0.1.0'
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
