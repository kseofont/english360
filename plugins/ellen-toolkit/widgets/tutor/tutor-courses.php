<?php
/**
 * Courses Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Tutor_Courses extends Widget_Base {

	public function get_name() {
        return 'TutorCourses';
    }

	public function get_title() {
        return esc_html__( 'Tutor Courses', 'ellen-toolkit' );
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
				'label' => esc_html__( 'Tutor Course', 'ellen-toolkit' ),
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
        <?php if($settings['style'] == 'slider'): ?>
            <div class="container-fluid">
                <div class="rt-courses-slides owl-carousel owl-theme">
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
                        <div class="rt-single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
                            <div class="image">
                                <?php the_post_thumbnail( 'ellen-course-950X635' ); ?>
                                <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                            </div>
                            <div class="content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php if(get_the_author_meta() != null): ?>
                                    <a href="<?php echo esc_url($profile_url); ?>" class="author"><?php the_author(); ?></a>
                                <?php else: ?>
                                    <div class="author d-flex align-items-center">
                                        <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                        <span><a href="<?php echo esc_url($profile_url); ?>"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a></span>
                                    </div>
                                <?php endif; ?>

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
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6">
                            <div class="oa-single-courses-box">
                                <div class="image">
                                    <?php the_post_thumbnail( 'ellen-course-950X635' ); ?>
                                    <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                </div>
                                <div class="content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="author d-flex align-items-center">
                                        <?php if(get_the_author_meta() != null): ?>
                                            <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                            <span><a href="<?php echo esc_url($profile_url); ?>" class="author"><?php the_author(); ?></a></span>
                                        <?php else: ?>
                                            <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                            <span><a href="<?php echo esc_url($profile_url); ?><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?>" class="author"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a></span>
                                    </div>
                                    <?php endif; ?>                                    
                                    
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
                                        <?php if(get_the_author_meta() != null): ?>
                                            <a href="<?php echo esc_url($profile_url); ?>" class="author"><?php the_author(); ?></a>
                                        <?php else: ?>
                                            <a href="<?php echo esc_url($profile_url); ?><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?>" class="author"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a>
                                        <?php endif; ?>

                                        <div class="rating">
                                            <?php
                                            $course_rating = tutor_utils()->get_course_rating();
                                            tutor_utils()->star_rating_generator($course_rating->rating_avg);
                                            ?>
                                            <span class="tutor-rating-count">
                                                <?php
                                                if ($course_rating->rating_avg > 0) {
                                                    echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
                                                    echo wp_kses_post('<span class="total">(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</span>');
                                                }
                                                ?>
                                            </span>
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
                                <div class="back">
                                    <div class="d-table">
                                        <div class="d-table-cell">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <span class="update-info"><?php esc_html_e('Updated:', 'ellen-toolkit') ?> <?php echo esc_html(get_the_modified_date()); ?></span>
                                        <div class="stats d-flex align-items-center">
                                            <span class="level"><?php echo wp_kses_post(get_tutor_course_level()); ?></span>
                                            <span><?php echo wp_kses_post(get_tutor_course_duration_context()); ?></span>
                                        </div>
                                        <?php the_excerpt(); ?>

                                        <?php $course_benefits = tutor_course_benefits(); ?>
                                        <?php if ( !empty($course_benefits)){ ?>
                                            <ul>
                                                <?php
                                                $count_benefit = 1;
                                                foreach ($course_benefits as $benefit){
                                                    if($count_benefit < 2):
                                                        echo wp_kses_post("<li><i class='flaticon-check-mark'></i>{$benefit}</li>");
                                                    endif;
                                                    $count_benefit++;
                                                }
                                                ?>
                                            </ul>
                                        <?php } ?>

                                        <div class="btn-box d-flex align-items-center">
                                        <?php
                                            $course_id = get_the_ID();
                                            $enroll_btn = '<div  class="tutor-public-course-start-learning">' . apply_filters( 'tutor_course_restrict_new_entry', '<a class="default-btn" href="'. get_the_permalink(). '">'.__('Get Enrolled', 'ellen'). '<i class="flaticon-hand"></i></a>' ) . '</div>';
                                            $price_html = '<div class="price"> '.$enroll_btn. '</div>';
                                            if (tutor_utils()->is_course_purchasable()) {
                                                $enroll_btn = tutor_course_loop_add_to_cart(false);
                                                $product_id = tutor_utils()->get_course_product_id($course_id);
                                                $price_html = '<div class="course-btn"> ' . apply_filters( 'tutor_course_restrict_new_entry', $enroll_btn ) . ' </div>';
                                            }
                                            echo wp_kses_post($price_html);
                                            ?><?php
                                            $is_wishlisted = tutor_utils()->is_wishlisted($course_id);
                                            $has_wish_list = '';
                                            if ($is_wishlisted){
                                                $has_wish_list = 'has-wish-listed';
                                            }

                                            $action_class = '';
                                            if ( is_user_logged_in()){
                                                $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
                                            }else{
                                                $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
                                            }

                                            echo wp_kses_post('<span class="tutor-course-wishlist"><a href="javascript:;" class="wishlist-btn tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"></a> </span>');
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

Plugin::instance()->widgets_manager->register( new Ellen_Tutor_Courses );