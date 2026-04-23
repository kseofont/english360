<?php
/**
 * Child-theme override for Tutor course loop card.
 *
 * Keeps Ellen markup but uses Tutor thumbnail helper so placeholder images
 * continue to work on initial load and after AJAX filtering.
 */

$course_id          = get_the_ID();
$tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);

do_action('tutor_course/loop/before_content');

global $post, $authordata;
$profile_url = tutor_utils()->profile_url($post->post_author);
$course_image = function_exists('get_tutor_course_thumbnail_src')
    ? get_tutor_course_thumbnail_src('ellen-course-860X630', $course_id)
    : get_the_post_thumbnail_url($course_id, 'ellen-course-860X630');

if (!$course_image && function_exists('e360_course_placeholder_image_url')) {
    $course_image = e360_course_placeholder_image_url();
}
?>
    <div class="single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
        <div class="image">
            <img src="<?php echo esc_url($course_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
            <a href="<?php the_permalink(); ?>" class="link-btn"></a>
        </div>
        <div class="content">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if (get_the_author_meta() != null) : ?>
                <a href="<?php echo esc_url($profile_url); ?>" class="author"><?php the_author(); ?></a>
            <?php else : ?>
                <a href="<?php echo esc_url($profile_url); ?>" class="author"><?php echo wp_kses(get_the_author_meta('display_name', 1), 'ellenallowedhtml'); ?></a>
            <?php endif; ?>
            <div class="rating">
                <div class="d-flex align-items center">
                    <?php
                    $course_rating = tutor_utils()->get_course_rating();
                    tutor_utils()->star_rating_generator($course_rating->rating_avg);
                    ?>
                    <span class="tutor-rating-count">
                        <?php
                        if ($course_rating->rating_avg > 0) {
                            echo wp_kses(apply_filters('tutor_course_rating_average', $course_rating->rating_avg), 'ellenallowedhtml');
                            echo wp_kses('<span class="total">(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</span>', 'ellenallowedhtml');
                        }
                        ?>
                    </span>
                </div>
            </div>

            <?php
            $is_purchasable = tutor_utils()->is_course_purchasable();
            $price          = apply_filters('get_tutor_course_price', null, get_the_ID());

            if ($is_purchasable && $price) {
                echo '<div class="price">' . $price . '</div>';
            } else {
                ?>
                <div class="price"><span class="new-price">
                    <?php esc_html_e('Free', 'vaximo'); ?>
                </span></div>
                <?php
            }
            ?>
        </div>
    </div>
<?php do_action('tutor_course/loop/after_content'); ?>
