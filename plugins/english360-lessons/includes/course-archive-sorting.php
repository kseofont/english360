<?php
defined('ABSPATH') || exit;

function e360_course_archive_sort_value(): string {
    $value = '';

    if (isset($_GET['course_order'])) {
        $value = sanitize_key((string) wp_unslash($_GET['course_order']));
    }

    if ($value === '' && isset($_POST['course_order'])) {
        $value = sanitize_key((string) wp_unslash($_POST['course_order']));
    }

    if ($value === '' && isset($_GET['tutor_course_filter'])) {
        $value = sanitize_key((string) wp_unslash($_GET['tutor_course_filter']));
    }

    if ($value === '' && isset($_POST['tutor_course_filter'])) {
        $value = sanitize_key((string) wp_unslash($_POST['tutor_course_filter']));
    }

    return $value !== '' ? $value : 'language_level';
}

function e360_is_course_archive_query($query): bool {
    if (!$query instanceof WP_Query) {
        return false;
    }

    $post_type = $query->get('post_type');
    $is_course_post_type = false;

    if (is_array($post_type)) {
        $is_course_post_type = in_array('courses', $post_type, true);
    } else {
        $is_course_post_type = ($post_type === 'courses');
    }

    return ($query->is_main_query() && !$query->is_admin && ($is_course_post_type || (string) get_query_var('course-category') !== ''));
}

function e360_apply_default_course_archive_sort(WP_Query $query): void {
    if (is_admin() || !$query->is_main_query() || $query->is_feed()) {
        return;
    }

    if (!e360_is_course_archive_query($query)) {
        return;
    }

    if (e360_course_archive_sort_value() !== 'language_level') {
        return;
    }

    $query->set('e360_language_level_sort', 1);
}
add_action('pre_get_posts', 'e360_apply_default_course_archive_sort', 30);

function e360_apply_course_filter_default_sort(array $args): array {
    if (e360_is_courses_listing_request()) {
        $total_courses = e360_get_total_published_courses_count();
        if ($total_courses > 0) {
            $args['posts_per_page'] = $total_courses;
        }
    }

    if (e360_course_archive_sort_value() !== 'language_level') {
        return $args;
    }

    $args['e360_language_level_sort'] = 1;
    return $args;
}
add_filter('tutor_course_filter_args', 'e360_apply_course_filter_default_sort', 20);

function e360_apply_shortcode_course_default_sort(array $args): array {
    if (e360_course_archive_sort_value() !== 'language_level') {
        return $args;
    }

    $args['e360_language_level_sort'] = 1;
    return $args;
}
add_filter('tutor_get_course_list_filter_args', 'e360_apply_shortcode_course_default_sort', 20);

function e360_shortcode_tutor_course_default_atts(array $out, array $pairs, array $atts): array {
    if (!isset($atts['show_pagination']) || $atts['show_pagination'] === '') {
        $out['show_pagination'] = 'on';
    }

    return $out;
}
add_filter('shortcode_atts_tutor_course', 'e360_shortcode_tutor_course_default_atts', 20, 3);

function e360_is_courses_listing_request(): bool {
    if (wp_doing_ajax()) {
        $action = isset($_REQUEST['action']) ? sanitize_key((string) wp_unslash($_REQUEST['action'])) : '';
        if ($action !== 'tutor_course_filter_ajax') {
            return false;
        }

        $referer = '';

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = (string) wp_unslash($_SERVER['HTTP_REFERER']);
        } elseif (!empty($_POST['_wp_http_referer'])) {
            $referer = (string) wp_unslash($_POST['_wp_http_referer']);
        }

        $path = trim((string) wp_parse_url($referer, PHP_URL_PATH), '/');
        return $path === 'courses';
    }

    if (is_admin()) {
        return false;
    }

    if (function_exists('is_post_type_archive') && is_post_type_archive('courses')) {
        return true;
    }

    if (function_exists('is_page') && is_page('courses')) {
        return true;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = trim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/');

    return $path === 'courses';
}

function e360_get_total_published_courses_count(): int {
    $post_type = function_exists('tutor') && isset(tutor()->course_post_type) ? (string) tutor()->course_post_type : 'courses';
    $counts = wp_count_posts($post_type);

    if (!is_object($counts) || !isset($counts->publish)) {
        return 0;
    }

    return max(0, (int) $counts->publish);
}

function e360_wrap_tutor_course_shortcode_for_default_pagination(): void {
    global $shortcode_tags;

    if (!is_array($shortcode_tags) || empty($shortcode_tags['tutor_course'])) {
        return;
    }

    static $wrapped = false;
    static $original_callback = null;

    if ($wrapped) {
        return;
    }

    $original_callback = $shortcode_tags['tutor_course'];

    remove_shortcode('tutor_course');
    add_shortcode('tutor_course', function ($atts = [], $content = null, $tag = '') use (&$original_callback) {
        $atts = is_array($atts) ? $atts : [];

        if (!isset($atts['show_pagination']) || $atts['show_pagination'] === '') {
            $atts['show_pagination'] = 'on';
        }

        if (e360_is_courses_listing_request()) {
            $total_courses = e360_get_total_published_courses_count();
            if ($total_courses > 0) {
                $atts['count'] = $total_courses;
            }
        }

        return is_callable($original_callback) ? (string) call_user_func($original_callback, $atts) : '';
    });

    $wrapped = true;
}
add_action('init', 'e360_wrap_tutor_course_shortcode_for_default_pagination', 999);

function e360_course_archive_posts_clauses(array $clauses, WP_Query $query): array {
    global $wpdb;

    if (!(int) $query->get('e360_language_level_sort')) {
        return $clauses;
    }

    $posts = $wpdb->posts;
    $relationships = $wpdb->term_relationships;
    $taxonomy = $wpdb->term_taxonomy;
    $terms = $wpdb->terms;

    $language_name_sql = "(
        SELECT MIN(LOWER(COALESCE(parent_terms.name, base_terms.name)))
        FROM {$relationships} tr
        INNER JOIN {$taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$terms} base_terms ON tt.term_id = base_terms.term_id
        LEFT JOIN {$terms} parent_terms ON tt.parent = parent_terms.term_id
        WHERE tr.object_id = {$posts}.ID
          AND tt.taxonomy = 'course-category'
    )";

    $english_priority_sql = "(
        SELECT MIN(
            CASE
                WHEN LOWER(COALESCE(parent_terms.name, base_terms.name)) = 'english' THEN 0
                ELSE 1
            END
        )
        FROM {$relationships} tr
        INNER JOIN {$taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$terms} base_terms ON tt.term_id = base_terms.term_id
        LEFT JOIN {$terms} parent_terms ON tt.parent = parent_terms.term_id
        WHERE tr.object_id = {$posts}.ID
          AND tt.taxonomy = 'course-category'
    )";

    $level_priority_sql = "(
        SELECT MIN(
            CASE
                WHEN LOWER(level_terms.name) = 'beginner' THEN 0
                WHEN LOWER(level_terms.name) = 'intermediate' THEN 1
                WHEN LOWER(level_terms.name) = 'advanced' THEN 2
                ELSE 99
            END
        )
        FROM {$relationships} tr
        INNER JOIN {$taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN {$terms} level_terms ON tt.term_id = level_terms.term_id
        WHERE tr.object_id = {$posts}.ID
          AND tt.taxonomy = 'course-category'
          AND tt.parent > 0
    )";

    $clauses['orderby'] = sprintf(
        'COALESCE(%1$s, 999) ASC, COALESCE(%2$s, "zzz") ASC, COALESCE(%3$s, 99) ASC, %4$s.post_title ASC, %4$s.ID ASC',
        $english_priority_sql,
        $language_name_sql,
        $level_priority_sql,
        $posts
    );

    return $clauses;
}
add_filter('posts_clauses', 'e360_course_archive_posts_clauses', 20, 2);
