<?php
/**
 * Courses Filter Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Tutor_Courses_Filter_Two extends Widget_Base {

	public function get_name() {
        return 'TutorCoursesFilterTwo';
    }

	public function get_title() {
        return esc_html__( 'Tutor Courses Filter Two', 'ellen-toolkit' );
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
				'label' => esc_html__( 'Tutor Courses Filter Two', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'all_title',
            [
                'label' => esc_html__( 'All Button Text', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('All', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
			'course_count',
			[
				'label' => esc_html__( 'Course Per Tab', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 8,
			]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'cat_name', [
                'label' => esc_html__( 'Course Category Slug', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
			'count',
			[
				'label' => __( 'Course Per Tab', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
			]
        );

        $this->add_control(
            'course_cat',
            [
                'label' => esc_html__('Add filter nav item', 'ellen-toolkit'),
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

        $this->add_control(
            'button_text',
            [
                'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> esc_html__('View All Courses', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'link_type',
            [
                'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                'type' 			=> Controls_Manager::SELECT,
                'label_block' 	=> true,
                'options' => [
                    '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                    '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                ],
                'default' 	=> '1',
            ]
        );

        $this->add_control(
            'link_to_page',
            [
                'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                'type' 			=> Controls_Manager::SELECT,
                'label_block' 	=> true,
                'options' 		=> ellen_toolkit_get_page_as_list(),
                'condition' => [
                    'link_type' => '1',
                ]
            ]
        );

        $this->add_control(
            'ex_link',
            [
                'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'separator'   => 'before',
                'condition' => [
                    'link_type' => '2',
                ]
            ]
        );

        $this->add_control(
            'shape1',
            [
                'label'		=> esc_html__('Shape Image 1', 'ellen-toolkit'),
                'type'        => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'shape2',
            [
                'label'		=> esc_html__('Shape Image 2', 'ellen-toolkit'),
                'type'        => Controls_Manager::MEDIA,
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

        if( $settings != '' ) {
            $all = $settings['all_title'];
        }else {
            $all = 'All';
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
            <div class="container">
                <div class="courses-shorting-menu">
                    <button type="button" class="control all" data-filter=".all"><?php echo esc_attr($all); ?></button>

                    <?php
                    foreach ($cat_item as $key => $cat):
                        if( !$cat['cat_name'] == '' ) {
                            $term = get_term_by('slug', $cat['cat_name'], 'course-category');
                            ?>
                            <button type="button" class="control" data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
                            <?php
                        }
                    endforeach;
                    ?>
                </div>

                <div class="shorting row">
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
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mix all">
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
                        </div>

                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>

                    <?php foreach ($cat_item as $key => $cat):
                        if( !$cat['cat_name'] == '' ) {
                            $args_options = get_term_by('slug', $cat['cat_name'], 'course-category')->term_id;
                        }

                        $course_array = new \WP_Query( array('posts_per_page' => $cat['count'], 'post_type' => 'courses', 'order' => $settings['order'], 'tax_query' => array( array( 'taxonomy' => 'course-category', 'terms' => $args_options, ) ),'meta_key' => '_thumbnail_id' ) );
                        ?>

                        <?php
                        while($course_array->have_posts()): $course_array->the_post();
                            $idd = get_the_ID();
                            $terms = wp_get_post_terms(get_the_ID(), 'course-category');

                            $term = get_term(  $args_options, 'course-category' );
                            $slug = $term->slug;

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
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mix <?php echo $slug; ?>">
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
                                            <a href="<?php echo esc_url($profile_url); ?><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?>" class="author"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a>
                                        <?php endif; ?>                                        <?php $course_rating = tutor_utils()->get_course_rating(); ?>  
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
                                        $course_id = get_the_ID();
                                        $price_html = '<div class="price"><span class="new-price"> '.esc_html__('Free', 'ellen').'</span></div>';
                                        if (tutor_utils()->is_course_purchasable()) {
                                            $product_id = tutor_utils()->get_course_product_id($course_id);
                                            $product    = wc_get_product( $product_id );
                                            if ( $product ) {
                                                $price_html = '<div class="price"> '.$product->get_price_html().' </div>';
                                            }
                                        }
                                        echo wp_kses_post($price_html);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_query(); ?>
                    <?php endforeach; ?>
                </div>
                <?php
                // Get Button Link
                if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
                    $link = get_page_link( $settings['link_to_page'] );
                }elseif($settings['link_type'] == 2) {
                    $link = $settings['ex_link'];
                }else{
                    $link = '';
                }
                
                $button_text = $settings['button_text'];
                ?>
                <?php if( $button_text ): ?>
                    <div class="view-all-courses-btn">
                        <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?><div class="btn-icon"><?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></div></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="rt-courses-shape1">
                <?php echo wp_get_attachment_image( $settings['shape1']['id'], 'full' ); ?>
            </div>

            <div class="rt-courses-shape2">
                <?php echo wp_get_attachment_image( $settings['shape2']['id'], 'full' ); ?>
            </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Tutor_Courses_Filter_Two );