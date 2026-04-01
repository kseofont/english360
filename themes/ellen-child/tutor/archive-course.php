<?php
/**
 * Tutor course archive override for Ellen child theme.
 */

tutor_utils()->tutor_custom_header();

get_template_part('template-parts/banner');

$course_filter = (bool) tutor_utils()->get_option('course_archive_filter', false);
$supported_filters = tutor_utils()->get_option('supported_course_filters', array());

if (!function_exists('e360_get_course_archive_page')) {
    function e360_get_course_archive_page() {
        $archive_page_id = 0;
        $queried_object = get_queried_object();

        if ($queried_object instanceof WP_Post && 'page' === $queried_object->post_type) {
            $archive_page_id = (int) $queried_object->ID;
        }

        if (!$archive_page_id) {
            $candidates = array(
                'tutor_course_archive_page_id',
                'tutor_archive_course_page_id',
                'course_archive_page',
                'course_archive_page_id',
            );

            foreach ($candidates as $option_name) {
                $value = (int) get_option($option_name);
                if ($value > 0) {
                    $archive_page_id = $value;
                    break;
                }
            }
        }

        if (!$archive_page_id && !empty($_SERVER['REQUEST_URI'])) {
            $path = trim((string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
            if ($path !== '') {
                $page = get_page_by_path($path);
                if ($page instanceof WP_Post) {
                    $archive_page_id = (int) $page->ID;
                }
            }
        }

        if (!$archive_page_id) {
            return null;
        }

        $page = get_post($archive_page_id);
        if (!$page instanceof WP_Post || 'page' !== $page->post_type || '' === trim((string) $page->post_content)) {
            return null;
        }

        return $page;
    }
}

if (!function_exists('e360_render_course_archive_page_content')) {
    function e360_render_course_archive_page_content($page) {
        if (!$page instanceof WP_Post) {
            return false;
        }

        $content = '';
        $has_tutor_shortcode = false;

        if (function_exists('parse_blocks')) {
            $blocks = parse_blocks($page->post_content);

            foreach ($blocks as $block) {
                $block_name = $block['blockName'] ?? '';
                $block_html = trim((string) ($block['innerHTML'] ?? ''));

                if ('core/shortcode' === $block_name && false !== strpos($block_html, '[tutor_course')) {
                    $has_tutor_shortcode = true;
                }

                if ('core/code' === $block_name && '' === wp_strip_all_tags($block_html)) {
                    continue;
                }

                $content .= render_block($block);
            }
        } else {
            $content = $page->post_content;
            $has_tutor_shortcode = false !== strpos($page->post_content, '[tutor_course');
        }

        if ('' !== trim(wp_strip_all_tags($content))) {
            echo '<div class="page-main-content container"><div class="entry-content e360-course-archive-intro">';
            echo do_shortcode($content);
            echo '</div></div>';
        }

        return $has_tutor_shortcode;
    }
}

$archive_page = e360_get_course_archive_page();
$page_renders_courses = e360_render_course_archive_page_content($archive_page);

if (!$page_renders_courses && $course_filter && count($supported_filters)) {
?>
<div class="tutor-wrap tutor-courses-wrap tutor-container page-main-content container">
    <div class="tutor-row tutor-gx-xl-5">
        <div class="tutor-course-filter tutor-col-3 tutor-course-filter-container">
            <div class="tutor-course-filter-widget">
                <?php tutor_load_template('course-filter.filters'); ?>
            </div>
        </div>
        <div id="tutor-course-filter-loop-container" class="<?php tutor_container_classes(); ?> tutor-col-xl-9"
            data-column_per_row="<?php echo esc_html(tutor_utils()->get_option('courses_col_per_row', 3)); ?>">
            <div style="background-color: #fff;" class="loading-spinner"></div>
            <?php tutor_load_template('archive-course-init'); ?>
        </div>
    </div>
</div>
<?php
} elseif (!$page_renders_courses) {
?>
<div class="tutor-wrap tutor-courses-wrap tutor-container course-archive-page page-main-content container">
    <div class="<?php tutor_container_classes(); ?> tutor-course-filter-loop-container">
        <div style="background-color: #fff;" class="loading-spinner"></div>
        <?php tutor_load_template('archive-course-init'); ?>
    </div>
</div>
<?php
}

tutor_utils()->tutor_custom_footer();
