<?php
/**
 * Courses Card Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_LP_Courses_Card extends Widget_Base {

	public function get_name() {
        return 'LPCoursesCard';
    }

	public function get_title() {
        return esc_html__( 'LearnPress Courses Card', 'ellen-toolkit' );
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
				'label' => esc_html__( 'LearnPress Course Card', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'grid',
            [
                'label' => esc_html__( 'Select Column', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'col-xxl-12 col-xl-12 col-md-12'    => esc_html__( '1 Column', 'ellen-toolkit' ),
                    'col-xl-6 col-md-6'     => esc_html__( '2 Column', 'ellen-toolkit' ),
                    'col-lg-4 col-md-6'     => esc_html__( '3 Column', 'ellen-toolkit' ),
                    'col-xxl-3 col-xl-4 col-lg-4 col-md-6'     => esc_html__( '4 Column', 'ellen-toolkit' ),
                ],
                'default' => 'col-lg-4 col-md-6',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_attr__( 'Courses Limit', 'ellen-toolkit' ),
                'description' => esc_attr__( 'Choose course limit', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,

                'default' => '6',

            ]
        );

        $this->add_control(
            'posts',
            [
                'label' => esc_attr__( 'Show Only Specific Courses', 'ellen-toolkit' ),
                'description' => esc_attr__( 'Enter post IDs with comma, like: 1,2,3,4,5', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,

            ]
        );

        $this->add_control(
            'course-category',
            [
                'label' => esc_attr__( 'Show Only Specific Categories', 'ellen-toolkit' ),
                'description' => esc_attr__( 'Enter categories slugs to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,

            ]
        );
        $this->add_control(
            'tags',
            [
                'label' => esc_attr__( 'Show Only Specific Tags', 'ellen-toolkit' ),
                'description' => esc_attr__( 'Enter tags slugs to narrow output (Note: only listed tags will be displayed, divide categories with linebreak (Enter)).', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,

            ]
        );
        $this->add_control(
            'order_by',
            [
                'label' => esc_attr__( 'Order By', 'ellen-toolkit' ),
                'description' => esc_attr__( '', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'date' => esc_attr__( 'Date', 'ellen-toolkit' ),
                    'name' => esc_attr__( 'Name', 'ellen-toolkit' ),
                    'author' => esc_attr__( 'Author', 'ellen-toolkit' ),
                    'rand' => esc_attr__( 'Random', 'ellen-toolkit' ),
                    'comment_count' => esc_attr__( 'Comment Count', 'ellen-toolkit' ),
                ],
                'default' => 'date',

            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_attr__( 'Order', 'ellen-toolkit' ),
                'description' => esc_attr__( '', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'desc' => esc_attr__( 'Descending', 'ellen-toolkit' ),
                    'asc' => esc_attr__( 'Ascending', 'ellen-toolkit' ),
                ],
                'default' => 'desc',

            ]
        );
        $this->add_control(
            'lessons_title',
            [
                'label' 	=> esc_html__( 'Lessons Title', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> __('Programs', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
            'price_text',
            [
                'label' 		=> esc_html__( 'Price Text', 'ellen-toolkit' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 	=> __('Enroll Now ', 'ellen-toolkit'),
                'label_block' 	=> true,
            ]
        );
        $this->add_control(
            'free_text',
            [
                'label' 		=> esc_html__( 'Free Course Text', 'ellen-toolkit' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 	=> __('Free', 'ellen-toolkit'),
                'label_block' 	=> true,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-courses-card .content h3 a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-courses-card .content h3',
                ]
            );

			$this->add_control(
				'price_bg_color',
				[
					'label' => esc_html__( 'Price Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-courses-card .content .price' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'price_hover_bg_color',
				[
					'label' => esc_html__( 'Price Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-courses-card:hover .content .price' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'price_typography',
                    'label' => esc_html__( 'Price Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-courses-card .content .price',
                ]
            );
        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        
        $limit = ( isset( $settings['limit'] ) && is_numeric($settings['limit']) ) ? intval( $settings['limit'] ) : 5;
        $tags_query = !is_array( $settings['tags'] ) ? $settings['tags'] : '';
        $categories_query = ( isset($settings['course-category']) && $settings['course-category'] ) ? str_replace("post:","", $settings['course-category'] ) : array();
        $orderby = ( isset($settings['order_by']) && $settings['order_by'] ) ? esc_attr( $settings['order_by'] ) : 'post_date';
        $order = ( isset($settings['order']) && $settings['order'] ) ? esc_attr( $settings['order'] ) : 'desc';

        /* Limit Posts */
        if( isset( $settings['posts'] ) && $settings['posts'] ) :
            $specific_posts = explode(',', $settings['posts']); $i=0;
            foreach( $specific_posts as $specific_post ) {
                $specific_posts[$i] = intval( $specific_post );
                $i++;
            }
        else :
            $specific_posts = array();
        endif;

        $tax_query = array();
        if( !empty( $categories_query ) ) {
            $tax_query[] = array(
                'taxonomy' => 'course_category',
                'field' => 'slug',
                'terms' => $categories_query,
            );
        }

        if( !empty( $tags_query ) ) {
            $tax_query[] = array(
                'taxonomy' => 'course_tag',
                'field' => 'slug',
                'terms' => $tags_query,
            );
        }

        if( count( $specific_posts ) > 0 ) :
            $posts = new \WP_Query( array(
                'post_type' => 'lp_course',
                'posts_per_page' => $limit,
                'post__in' => $specific_posts,
                'orderby' => 'post__in'
            ));
        else :
            $posts = new \WP_Query( array(
                'post_type' => 'lp_course',
                'posts_per_page' => $limit,
                'orderby' => $orderby,
                'order' => $order,
                'tax_query' => $tax_query,
            ));
        endif;

        if ( !ellen_plugin_active( 'learnpress/learnpress.php' ) ) {
            if( is_user_logged_in() ):
                ?>
                <div class="container">
                    <div class="alert alert-danger" role="alert">
                        <?php echo esc_html__( 'Please Install and activated LearnPress  plugin', 'ellen-toolkit' ); ?>
                    </div>
                </div>
                <?php
            endif;
            return;
        }
        ?>
        <div class="la-courses-area">
            <div class="container">
                <div class="row justify-content-center">
                    <?php 
                    while ( $posts->have_posts() ) : $posts->the_post();
                        $flag_image = function_exists( 'get_field' ) ? get_field( 'flag_image' ) : '';
                        $course_id          = get_the_ID();
                        $course = \LP_Global::course();
                        ?>
                        <div class="<?php echo esc_attr($settings['grid']); ?>">
                            <div class="la-courses-card">
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'ellen-course-860X630' ); ?>
                                    </a>
                                    <?php if($flag_image): ?> 
                                        <div class="flag">
                                            <img src="<?php echo esc_url($flag_image); ?>" alt="image">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="content">
                                    <span class="programs">
                                        <?php if($settings['lessons_title']): ?>
                                            <?php echo wp_kses_post( $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0 ); ?> <?php echo esc_html( $settings['lessons_title'] ); ?>
                                        <?php endif; ?>
                                    </span>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="price">
                                            <?php echo esc_html($settings['price_text']); ?> 
                                            <?php echo $course->get_course_price_html(); ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_LP_Courses_Card );