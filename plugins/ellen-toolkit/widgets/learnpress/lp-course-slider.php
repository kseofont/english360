<?php
/**
 * Courses Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_LearnPress_Courses_Slider extends Widget_Base {

	public function get_name() {
        return 'LearnPressCoursesSlider';
    }

	public function get_title() {
        return esc_html__( 'LearnPress Courses Slider', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-slider-push';
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
			'course_count',
			[
				'label' => esc_html__( 'Count Course', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
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

        if ( !ellen_plugin_active( 'learnpress/learnpress.php' ) ) {
            if( is_user_logged_in() ):
                ?>
                <div class="container">
                    <div class="alert alert-danger" role="alert">
                        <?php echo esc_html__( 'Please Install and activated LearnPress LMS plugin', 'ellen-toolkit' ); ?>
                    </div>
                </div>
                <?php
            endif;
            return;
        }

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
            <div class="container-fluid">
                <div class="oa-classes-slides owl-carousel owl-theme">                    
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
                    <div class="oa-classes-card">
                        <div class="row m-0">
                            <div class="col-lg-7 col-md-6 p-0">
                                <div class="oa-classes-image" style="background-image:url(<?php echo esc_url(get_the_post_thumbnail_url()); ?>);"></div>
                            </div>

                            <div class="col-lg-5 col-md-6 p-0">
                                <div class="oa-classes-content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php the_excerpt(); ?>

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
                    </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_LearnPress_Courses_Slider );