<?php
/**
 * Courses Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Tutor_Courses_Slider extends Widget_Base {

	public function get_name() {
        return 'TutorCoursesSlider';
    }

	public function get_title() {
        return esc_html__( 'Tutor Courses Slider', 'ellen-toolkit' );
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
				'label' => esc_html__( 'Tutor Course', 'ellen-toolkit' ),
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

        if ( !ellen_plugin_active( 'tutor/tutor.php' ) ) {
            if( is_user_logged_in() ):
                ?>
                <div class="container">
                    <div class="alert alert-danger" role="alert">
                        <?php echo esc_html__( 'Please Install and activated Tutor LMS plugin', 'ellen-toolkit' ); ?>
                    </div>
                </div>
                <?php
            endif;
            return;
        }

        $cat_item = $settings['course_cat'];

        $ellen_courses_categories = get_terms('course-category');

        $args_options = [];
        foreach ($cat_item as $key => $cat):
            if( !$cat['cat_name'] == '' ) {
                $args_options[] = get_term_by('slug', $cat['cat_name'], 'course-category')->term_id;
            }
        endforeach;

        $course_array = new \WP_Query( array('posts_per_page' => $settings['course_count'], 'post_type' => 'courses', 'order' => $settings['order'], 'tax_query' => array( array( 'taxonomy' => 'course-category', 'terms' => $args_options, ) ) ) );
        ?>
            <div class="container-fluid">
                <div class="oa-classes-slides owl-carousel owl-theme">                    
                    <?php
                    while($course_array->have_posts()): $course_array->the_post();
                    $idd = get_the_ID();
                    $terms = wp_get_post_terms(get_the_ID(), 'course-category');

                    $output = array();
                    if ($terms) {
                        foreach ($terms as $term) {
                            $output[] = $term->slug ;
                            $id[] = $term->term_id ;
                        }
                    }

                    $course_id          = get_the_ID();
                    $tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);
                    global $post, $authordata;
                    $profile_url    = tutor_utils()->profile_url($post->post_author);
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
                                        <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                        <span><a href="<?php echo esc_url($profile_url); ?>"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a></span>
                                    </div>
                                    
                                    <?php $course_rating = tutor_utils()->get_course_rating(); ?>
                                    <div class="rating">
                                        <div class="d-flex align-items-center">
                                            <span class="overall">
                                                <?php 
                                                if ($course_rating->rating_avg > 0) {
                                                    echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
                                                }else{
                                                    echo "0.0";
                                                }
                                                ?>
                                            </span>
                                            <div class="star">
                                                <i class="bx bxs-star"></i>
                                            </div>
                                            <?php echo wp_kses_post('<span class="total">(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</span>'); ?>
                                        </div>
                                    </div>

                                    <?php
                                       
                                       $is_purchasable = tutor_utils()->is_course_purchasable();
                                       $price          = apply_filters( 'get_tutor_course_price', null, get_the_ID() );

                                       if ( $is_purchasable && $price ) {
                                           echo '<div class="price">' . $price . '</div>';
                                       } else {
                                           ?>
                                           <div class="new-price">
                                               <?php esc_html_e( 'Free', 'vaximo' ); ?>
                                           </div>
                                           <?php
                                       }
                                   ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
                <div class="slider-counter"></div>
            </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Tutor_Courses_Slider );