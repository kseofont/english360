<?php
/**
 * Courses Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_LearnPress_Courses extends Widget_Base {

	public function get_name() {
        return 'LearnPressCourses';
    }

	public function get_title() {
        return esc_html__( 'LearnPress Courses', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-grid';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'course_section',
			[
				'label' => esc_html__( 'LearnPress Course', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Select Style', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid'         => esc_html__( 'Grid', 'ellen-toolkit' ),
                    'slider'       => esc_html__( 'Slider', 'ellen-toolkit' ),
                    'grid2'       => esc_html__( 'Grid Two', 'ellen-toolkit' ),
                ],
                'default' => 'grid',
            ]
        );

        $this->add_control(
			'course_count',
			[
				'label' => esc_html__( 'Count Course', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 8,
			]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'cat_name', [
                'label' => esc_html__( 'Select Category', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => ellen_toolkit_get_courses_cat_list(),
            ]
        );

        $this->add_control(
            'course_cat',
            [
                'label' => esc_html__('Add Category to Filter Courses', 'ellen-toolkit'),
                'type' => Controls_Manager::REPEATER,
                'separator' => 'before',
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Courses Filter Order By', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
					'DESC'      => esc_html__( 'DESC', 'ellen-toolkit' ),
					'ASC'       => esc_html__( 'ASC', 'ellen-toolkit' ),
				],
				'default' => 'DESC',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        $cat_item = $settings['course_cat'];

        $ellen_courses_categories = get_terms('course_category');

        $args_options = [];
        foreach ($cat_item as $key => $cat):
            if( !$cat['cat_name'] == '' ) {
                $args_options[] = get_term_by('slug', $cat['cat_name'], 'course_category')->term_id;
            }
        endforeach;

        $course_array = new \WP_Query( array('posts_per_page' => $settings['course_count'], 'post_type' => 'lp_course', 'order' => $settings['order'], 'tax_query' => array( array( 'taxonomy' => 'course_category', 'terms' => $args_options, ) ) ) );
        ?>

        <?php if($settings['style'] == 'slider'): ?>
            <div class="container-fluid">
                <div class="rt-courses-slides owl-carousel owl-theme">
                    <?php
                    while($course_array->have_posts()): $course_array->the_post();
                    $idd = get_the_ID();
                    $terms = wp_get_post_terms(get_the_ID(), 'course_category');

                    $output = array();
                    if ($terms) {
                        foreach ($terms as $term) {
                            $output[] = $term->slug ;
                            $id[] = $term->term_id ;
                        }
                    }

                    $course_id          = get_the_ID();
                    $course = \LP_Global::course();
                    $course_rate_res = learn_press_get_course_rate( get_the_ID(), false );
                    $level = learn_press_get_post_level( get_the_ID() );
                    $course_rate     = $course_rate_res['rated'];
                    ?>
                        <div class="rt-single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
                            <div class="image">
                                <?php the_post_thumbnail( 'ellen-course-950X635' ); ?>
                                <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                            </div>
                            <div class="content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                <div class="lp-course-instructor">
                                    <?php echo wp_kses_post( $course->get_instructor_html() ); ?>
                                </div>

                                <div class="rating lp-course-rating">
                                    <div class="d-flex align-items-center">
                                        <span class="overall"><?php echo number_format( $course_rate, 1 ); ?></span>
                                        <div class="star">
                                            <i class="bx bxs-star"></i>
                                        </div>
                                        <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                    </div>
                                </div>

                                <div class="price">
                                    <?php echo $course->get_course_price_html(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        <?php elseif($settings['style'] == 'grid2'): ?>
            <div class="container">
                <div class="row">
                    <?php
                    while($course_array->have_posts()): $course_array->the_post();
                    $idd = get_the_ID();
                    $terms = wp_get_post_terms(get_the_ID(), 'course_category');

                    $output = array();
                    if ($terms) {
                        foreach ($terms as $term) {
                            $output[] = $term->slug ;
                            $id[] = $term->term_id ;
                        }
                    }

                    $course_id          = get_the_ID();
                    $course = \LP_Global::course();
                    $course_rate_res = learn_press_get_course_rate( get_the_ID(), false );
                    $level = learn_press_get_post_level( get_the_ID() );
                    $course_rate     = $course_rate_res['rated'];
                    $instructor = $course->get_instructor();
                    ?>
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6">
                            <div class="oa-single-courses-box">
                                <div class="image">
                                    <?php the_post_thumbnail( 'ellen-course-950X635' ); ?>
                                    <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                </div>
                                <div class="content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                    <div class="author d-flex align-items-center">
                                        <?php echo $instructor->get_profile_picture(); ?>
                                        <?php echo wp_kses_post( $course->get_instructor_html() ); ?>
                                    </div>

                                    <div class="rating lp-course-rating">
                                        <div class="d-flex align-items-center">
                                            <span class="overall"><?php echo number_format( $course_rate, 1 ); ?></span>
                                            <div class="star">
                                                <i class="bx bxs-star"></i>
                                            </div>
                                            <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                        </div>
                                    </div>

                                    <div class="price">
                                        <?php echo $course->get_course_price_html(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="container">
                <div class="row">
                    <?php
                    while($course_array->have_posts()): $course_array->the_post();
                    $idd = get_the_ID();
                    $terms = wp_get_post_terms(get_the_ID(), 'course_category');

                    $output = array();
                    if ($terms) {
                        foreach ($terms as $term) {
                            $output[] = $term->slug ;
                            $id[] = $term->term_id ;
                        }
                    }

                    $course_id          = get_the_ID();
                    $course = \LP_Global::course();
                    $course_rate_res = learn_press_get_course_rate( get_the_ID(), false );
                    $level = learn_press_get_post_level( get_the_ID() );
                    $course_rate     = $course_rate_res['rated'];
                    ?>
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6">
                            <div class="single-courses-item">
                                <div class="front">
                                    <div class="image">
                                        <a href="<?php the_permalink(); ?>" class="d-block">
                                            <?php the_post_thumbnail( 'ellen-course-220X180' ); ?>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                        <?php echo wp_kses_post( $course->get_instructor_html() ); ?>

                                        <div class="rating lp-course-rating">
                                            <div class="d-flex align-items-center">
                                                <span class="overall"><?php echo number_format( $course_rate, 1 ); ?></span>
                                                <div class="star">
                                                    <i class="bx bxs-star"></i>
                                                </div>
                                                <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                            </div>
                                        </div>

                                        <div class="price">
                                            <?php echo $course->get_course_price_html(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="back">
                                    <div class="d-table">
                                        <div class="d-table-cell">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <span class="update-info"><?php esc_html_e('Updated:', 'ellen-toolkit') ?> <?php echo esc_html(get_the_modified_date()); ?></span>
                                            <div class="stats d-flex align-items-center">
                                                <span class="level"><?php echo wp_kses_post($level); ?></span>
                                                <span><?php echo learn_press_get_post_translated_duration( get_the_ID(), esc_html__( 'Lifetime access', 'ellen-toolkit' ) ); ?></span>
                                            </div>

                                            <?php the_excerpt(); ?>

                                            <ul>
                                                <?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
                                                <li><i class='bx bx-user-circle' ></i> <?php echo esc_html_e('Total Students: ', 'ellen-toolkit'); ?> <?php echo esc_html( $user_count ); ?></li>
                                                <li><i class='bx bx-book' ></i><?php echo esc_html_e('Total Lesson: ', 'ellen-toolkit'); ?> <?php echo wp_kses_post( $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0 ); ?></li>
                                            </ul>

                                            <div class="btn-box d-flex align-items-center">
                                                <?php
                                                do_action( 'learn-press/before-course-buttons' );

                                                /**
                                                 * @see LP_Template_Course::course_purchase_button - 10
                                                 * @see LP_Template_Course::course_enroll_button - 10
                                                 * @see learn_press_course_retake_button - 10
                                                 */
                                                do_action( 'learn-press/course-buttons' );

                                                do_action( 'learn-press/after-course-buttons' );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
            <?php
        endif;
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_LearnPress_Courses );