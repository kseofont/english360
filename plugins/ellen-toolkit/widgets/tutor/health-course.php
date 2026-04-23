<?php
/**
 * Cta Courses Widget
 */

namespace Elementor;
class Hwf_Courses extends Widget_Base {

	public function get_name() {
        return 'Courses_Hwf';
    }

	public function get_title() {
        return __( 'Health Courses', 'vaximo-toolkit' );
    }

	public function get_icon() {
        return 'eicon-post-list';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'courses_section',
			[
				'label' => __( 'Courses', 'vaximo-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );
           
            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('OUR COURSES', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label' 	=> esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
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
                'title',
                [
                    'label'       => __( 'Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Our life changing affordable <span>online Courses</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label'   => __( 'Courses Order By', 'vaximo-toolkit' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'vaximo-toolkit' ),
                        'ASC'       => __( 'ASC', 'vaximo-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            $this->add_control(
                'count',
                [
                    'label'   => __( 'Post Per Page', 'vaximo-toolkit' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 6,
                ]
            );

            $this->add_control(
                'cat_name',
                [
                    'label' => __( 'Category', 'vaximo-toolkit' ),
                    'description' => __( 'Enter the category slugs separated by commas (Eg. cat1, cat2)', 'vaximo-toolkit' ),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'header_size',
                [
                    'label' => __( 'Title Heading Tag', 'vaximo-toolkit' ),
                    'type'  => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default' => 'h3',
                ]
            );

        $this->end_controls_section();
        
       
        $this->start_controls_section(
			'courses_style',
			[
				'label' => __( 'Style', 'vaximo-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'sec_bg_color',
                [
                    'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_bg_top_color',
                [
                    'label' => esc_html__( 'Section Top Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-area::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title .sub',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title .title-tgas',
                ]
            );

            $this->add_control(
                'pr_text_color',
                [
                    'label'     => __( 'Pricing Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-item .image .price' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'pr_bg_color',
                [
                    'label'     => __( 'Pricing Background Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-item .image .price' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'pr_text_typography',
                    'label'    => __( 'Pricing Text Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-courses-item .image .price',
                ]
            );

            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Title Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-item .content h3 a, {{WRAPPER}} .hwf-courses-item .content h2 a, {{WRAPPER}} .hwf-courses-item .content h4 a, {{WRAPPER}} .hwf-courses-item .content h1 a, {{WRAPPER}} .hwf-courses-item .content h5 a, {{WRAPPER}} .hwf-courses-item .content h6 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_title_hcolor',
                [
                    'label'     => __( 'Title Hover Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-item .content:hover h3 a, {{WRAPPER}} .hwf-courses-item .content:hover h2 a, {{WRAPPER}} .hwf-courses-item .content:hover h4 a, {{WRAPPER}} .hwf-courses-item .content:hover h1 a, {{WRAPPER}} .hwf-courses-item .content:hover h5 a, {{WRAPPER}} .hwf-courses-item .content:hover h6 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cd_title_typography',
                    'label'    => __( 'Title Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-courses-item .content h3,  {{WRAPPER}} .hwf-courses-item .content h1,  {{WRAPPER}} .hwf-courses-item .content h2,  {{WRAPPER}} .hwf-courses-item .content h4,  {{WRAPPER}} .hwf-courses-item .content h5,  {{WRAPPER}} .hwf-courses-item .content h6',
                ]
            );

            $this->add_control(
                'au_text_color',
                [
                    'label'     => __( 'Author Text Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-courses-item .content .list li span a, {{WRAPPER}} .hwf-courses-item .content .list li span' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'au_text_typography',
                    'label'    => __( 'Author Text Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-courses-item .content .list li span a, {{WRAPPER}} .hwf-courses-item .content .list li span',
                ]
            );
        
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

       
       // Coursess Query
       $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
       if( $settings['cat_name'] != '' ) {
           $args = array(
               'post_type'     => 'courses',
               'posts_per_page'=> $settings['count'],
               'order'         => $settings['order'],
               'tax_query'     => array(
                   array(
                       'taxonomy'      => 'course-category',
                       'field'         => 'slug',
                       'terms'         => explode( ',', str_replace( ' ', '', $settings['cat_name'])),
                       'hide_empty'    => false
                   )
               ),
               'paged' => get_query_var('paged') ? get_query_var('paged') : 1
           );
       } else {
           $args = array(
               'post_type'         => 'courses',
               'posts_per_page'    => $settings['count'],
               'order'             => $settings['order'],
               'paged' => get_query_var('paged') ? get_query_var('paged') : 1
           );
       }
       $courses_array = new \WP_Query( $args );
       
       ?>

        <!-- Start HWF Courses Area -->
        <div class="hwf-courses-area health-wellness-fitness-home pb-100">
            <div class="container">
                <div class="section-wrap-title text-start">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <?php if( $settings['top_title']): ?>
                                <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                            <?php endif; ?>
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <ul class="hwf-courses-button">
                                <li>
                                    <div class="courses-button-prev">
                                        <i class='bx bx-left-arrow-alt'></i>
                                    </div>
                                </li>
                                <li>
                                    <div class="courses-button-next">
                                        <i class='bx bx-right-arrow-alt'></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="swiper hwf-courses-slider">
                    <div class="swiper-wrapper">
                        <?php while( $courses_array->have_posts() ): 
                            $courses_array->the_post();

                            $idd = get_the_ID();
        
                            $course_id          = get_the_ID();
                            $tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);
                            global $post, $authordata;
                            $profile_url    = tutor_utils()->profile_url($post->post_author);
                        ?>
                            <div class="swiper-slide">
                                <div class="hwf-courses-item">

                                    <div class="image">
                                        <a href="<?php echo esc_url(get_the_permalink($course_id)); ?>">
                                            <img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" alt="image">
                                        </a>
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

                                    <div class="content">
                                        <<?php echo esc_attr( $settings['header_size'] ); ?>><a href="<?php echo esc_url(get_the_permalink($course_id)); ?>"><?php the_title(); ?></a></<?php echo esc_attr( $settings['header_size'] ); ?>>
                                    
                                        <ul class="list">
                                            <li>
                                                <div class="author">
                                                
                                                    <?php if(get_the_author_meta() != null): ?>
                                                        <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                                        <?php echo esc_html__('By', 'ellen'); ?><a href="<?php echo esc_url($profile_url); ?>" class="author"><?php the_author(); ?></a>
                                                    <?php else: ?>
                                                        <?php echo tutor_utils()->get_tutor_avatar(get_the_author_meta('ID'), 'md'); ?>
                                                        <?php echo esc_html__('By', 'ellen'); ?> <a href="<?php echo esc_url($profile_url); ?><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?>" class="author"><?php echo wp_kses_post(get_the_author_meta('display_name', 1)); ?></a>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </li>
                                            <li>
                                                <i class='bx bx-time'></i>
                                                <span><?php echo wp_kses_post(get_tutor_course_duration_context()); ?></span>
                                            </li>
                                        </ul>
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
        </div>
        <!-- End HWF Courses Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Hwf_Courses );