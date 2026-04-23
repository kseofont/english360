<?php
/**
 * Blog Post Widget
 */

namespace Elementor;
class Health_Blog extends Widget_Base {

	public function get_name() {
        return 'Blog_Health';
    }

	public function get_title() {
        return __( 'Health Post', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-grid';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'blog_section',
			[
				'label' => __( 'Blog Post', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('ARTICLES', 'ellen-toolkit'),
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
                    'default'     => __('Read our latest lifestyle <span>articles</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Visit Blog Page', 'ellen-toolkit'),
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
                'cat_name', [
                    'label'       => __( 'Category', 'ellen-toolkit' ),
                    'description' => __( 'Enter the category slugs separated by commas (Eg. cat1, cat2)', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Post Order By', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'ellen-toolkit' ),
                        'ASC'       => __( 'ASC', 'ellen-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            $this->add_control(
                'count',
                [
                    'label' => __( 'Post Per Page', 'ellen-toolkit' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3,
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
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub::before' => 'background-color: {{VALUE}}',
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
                'title_br_color',
                [
                    'label' => esc_html__( 'Title Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .title-tgas span::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_bg_color',
				[
					'label' => __( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover_color',
				[
					'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
                ]
            );

            $this->add_control(
                'cd_tag_color',
                [
                    'label'     => __( 'Card Tags Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-blog-item .content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_tags',
                    'label'    => __( 'Card Tags Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .hwf-blog-item .content .sub',
                ]
            );

            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-blog-item .content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_title_h_color',
                [
                    'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-blog-item .content h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .hwf-blog-item .content h3',
                ]
            );

            $this->add_control(
                'cd_date_color',
                [
                    'label'     => __( 'Card Date Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-blog-item .content span' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_date',
                    'label'    => __( 'Card Date Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .hwf-blog-item .content span',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        // Get Banner Button Link
        $target     = '';
        $nofollow   = '';
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link       = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $target     = $settings['ex_link']['is_external'] ? ' target="_blank"' : '';
		    $nofollow   = $settings['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
            $link       = $settings['ex_link']['url'];
        }else{
            $link = '';
        }

        if ($settings['cat_name'] != '') {
            $args = array(
                'orderby' => 'date',
                'order' => $settings['order'],
                'posts_per_page' => $settings['count'],
                'ignore_sticky_posts' => 1,
                'tax_query' => array(
                    array(
						'taxonomy' => 'category',
						'field'    => 'slug',
                        'terms' => explode( ',', str_replace( ' ', '', $settings['cat_name'])),
                    )
                )
            );
        }else{
            $args = array(
                'orderby' => 'date',
                'order' => $settings['order'],
                'posts_per_page' => $settings['count'],
                'ignore_sticky_posts' => 1,
            );
        }
        $post_array = new \WP_Query( $args );

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        ?>

        <!-- Start HWF Blog Area -->
        <div class="hwf-blog-area health-wellness-fitness-home ptb-100">
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
                        <?php if($settings['button_text'] && $link): ?>
                            <div class="col-lg-4 col-md-12">
                                <div class="section-btn">
                                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn extra-radius"><?php echo esc_html($settings['button_text']); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div> 
                </div>

                <div class="swiper hwf-blog-slider">
                    <div class="swiper-wrapper align-items-center">
                        <?php $i=1; while($post_array->have_posts()): $post_array->the_post(); 

                            // Category 
                            $ellen_blog_category = get_the_terms(get_the_ID(), 'category');
                                
                            if($ellen_blog_category && ! is_wp_error( $ellen_blog_category )) {
                                $blog_cat_list = array();
                                
                                foreach($ellen_blog_category as $category) {
                                    $blog_cat_list[] = $category->name; 
                                    $category_link = get_category_link($category);
                                    $category_ass ='<a href="' . esc_url($category_link) .'" class="sub">' . esc_html($category->name) . ' </a>';
                                }
                            } 
                        ?>
                            <div class="swiper-slide">
                                <div class="hwf-blog-item">
                                    <div class="image">
                                        <a href="blog-details.html">
                                            <img src="<?php echo get_the_post_thumbnail_url( get_the_ID() ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <?php if($category_ass !=''){?>
                                            <?php echo wp_kses_post($category_ass); ?>
                                        <?php } ?>
                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <span><?php echo esc_html(get_the_date()); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
                <ul class="hwf-blog-button">
                    <li>
                        <div class="blog-button-prev">
                            <i class='bx bx-left-arrow-alt'></i>
                        </div>
                    </li>
                    <li>
                        <div class="blog-button-next">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End HWF Blog Area -->

    <?php
    }

}

Plugin::instance()->widgets_manager->register( new Health_Blog );