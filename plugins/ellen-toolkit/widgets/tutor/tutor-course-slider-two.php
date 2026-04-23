<?php
/**
 * Courses Slider Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Tutor_Courses_Slider_Two extends Widget_Base {

	public function get_name() {
        return 'TutorCoursesSliderTwo';
    }

	public function get_title() {
        return esc_html__( 'Tutor Courses Slider Two', 'ellen-toolkit' );
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
				'label' => esc_html__( 'Tutor Course Slider', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'top_title',
            [
                'label' => esc_html__( 'Top Title', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('COURSES', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tailored Coaching Services to  <br>  Elevate Your Business',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1'         => esc_html__( 'h1', 'ellen-toolkit' ),
                    'h2'         => esc_html__( 'h2', 'ellen-toolkit' ),
                    'h3'         => esc_html__( 'h3', 'ellen-toolkit' ),
                    'h4'         => esc_html__( 'h4', 'ellen-toolkit' ),
                    'h5'         => esc_html__( 'h5', 'ellen-toolkit' ),
                    'h6'         => esc_html__( 'h6', 'ellen-toolkit' ),
                ],
                'default' => 'h2',
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Unlock the full potential of your business with our comprehensive suite of coaching services designed to meet the unique needs of every entrepreneur.', 'ellen-toolkit'),
            ]
        );


        $this->add_control(
            'limit',
            [
                'label' => esc_attr__( 'Courses Limit', 'ellen-toolkit' ),
                'description' => esc_attr__( 'Choose course limit', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,

                'default' => '5',

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
                'default' 	=> __('Lessons', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
            'students_title',
            [
                'label' 	=> esc_html__( 'Students Title', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> __('Students', 'ellen-toolkit'),
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
                'sec_bg',
                [
                    'label' => esc_html__( 'Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-courses-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control( 'banner_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .bc-courses-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

           
			$this->add_control(
				'top_title_color',
				[
					'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .section-title.center-style .sub-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .section-title.center-style .sub-title',
                ]
            );
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .bc-courses-area .section-title.center-style p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-courses-area .section-title.center-style p',
                ]
            );
        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        
        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

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
                'taxonomy' => 'course-category',
                'field' => 'slug',
                'terms' => $categories_query,
            );
        }

        if( !empty( $tags_query ) ) {
            $tax_query[] = array(
                'taxonomy' => 'course-tag',
                'field' => 'slug',
                'terms' => $tags_query,
            );
        }

        if( count( $specific_posts ) > 0 ) :
            $posts = new \WP_Query( array(
                'post_type' => 'courses',
                'posts_per_page' => $limit,
                'post__in' => $specific_posts,
                'orderby' => 'post__in'
            ));
        else :
            $posts = new \WP_Query( array(
                'post_type' => 'courses',
                'posts_per_page' => $limit,
                'orderby' => $orderby,
                'order' => $order,
                'tax_query' => $tax_query,
            ));
        endif;

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
        ?>
        <div class="bc-courses-area">
            <div class="container">
                <div class="section-title text-start center-style">
                    <span class="sub-title"><?php echo esc_html( $settings['top_title'] ); ?></span>
                    <<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                    <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                </div>
            </div>
            <div class="container-fluid">
                <div class="bc-courses-slides owl-carousel owl-theme">
                    <?php 
                    while ( $posts->have_posts() ) : $posts->the_post();
                        ?>
                        <div class="bc-single-courses-box">
                            <div class="image">
                                <?php the_post_thumbnail( 'ellen-course-860X630' ); ?>
                                <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                            </div>
                            <div class="content">
                                <ul class="list">
                                    <?php if($settings['lessons_title']): ?>
                                        <li>
                                            <?php
                                            $course_id          = get_the_ID();
                                            $tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);
                                            ?>
                                            <i class='flaticon-agenda'></i>
                                            <?php echo $tutor_lesson_count; ?> <?php echo esc_html( $settings['lessons_title'] ); ?>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php if($settings['students_title']): ?> 
                                        <li><?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?> <?php echo esc_html( $settings['students_title'] ); ?></li>
                                    <?php endif; ?>
                                </ul>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="bottom d-flex align-items-center justify-content-between">
                                    <div class="rating">
                                        <div class="d-flex align-items-center">
                                            <span class="overall">
                                                <?php 
                                                $course_rating = tutor_utils()->get_course_rating();

                                                echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg); ?>
                                            </span>
                                            <div class="star">
                                                <i class="bx bxs-star"></i>
                                            </div>
                                            <span class="tutor-rating-count">
                                                <?php
                                                if ($course_rating->rating_avg > 0) {
                                                    echo wp_kses_post('<span class="total">(' . apply_filters('tutor_course_rating_count', $course_rating->rating_count) . ')</span>');
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php
                                       
                                       $is_purchasable = tutor_utils()->is_course_purchasable();
                                       $price          = apply_filters( 'get_tutor_course_price', null, get_the_ID() );

                                       if ( $is_purchasable && $price ) {
                                           echo '<div class="price">' . $price . '</div>';
                                       } else {
                                           ?>
                                           <div class="price">
                                               <?php esc_html_e( 'Free', 'vaximo' ); ?>
                                           </div>
                                           <?php
                                       }
                                   ?>
                                    
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

Plugin::instance()->widgets_manager->register( new Ellen_Tutor_Courses_Slider_Two );