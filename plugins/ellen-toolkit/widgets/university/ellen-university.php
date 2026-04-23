<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class Ellen_Study_University extends Widget_Base {

	public function get_name() {
        return 'University_Study';
    }

	public function get_title() {
        return __( 'Ellen University', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-table';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'ellen_university',
			[
				'label' => __( 'Ellen University Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'choose_style',
                [
                    'label' => __( 'Choose Style', 'medak-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Style - 1', 'medak-toolkit' ),
                        '2'   => __( 'Choose Style - 2', 'medak-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'sec_img',
                [
                    'type'    => Controls_Manager::MEDIA,
                    'label'   => __( 'Section Images', 'ellen-toolkit' ),
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
                'heading_tag', [
                    'label'   => __( 'Section Title Heading Tag', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default'     => 'h2',
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sec_title',
                [
                    'label'   => __( 'Section Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Study <span>at Ellen University</span>', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'As a university for the future, we combine cutting-edge research, innovative teaching methods, and a commitment to sustainability to prepare students for a rapidly evolving world.', 'ellen-toolkit' ),
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
				'sec_button_text',
				[
					'label' 	=> esc_html__( 'Section Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Explore our digital view book »', 'ellen-toolkit'),
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
				]
            );

            $this->add_control(
                'sec_link_type',
                [
                    'label' 		=> esc_html__( 'Section Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
                'sec_link_to_page',
                [
                    'label' 		=> esc_html__( 'Section Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'sec_link_type' => '1',
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
                'sec_ex_link',
                [
                    'label'		=> esc_html__('Section Button External Link', 'ellen-toolkit'),
                    'type'        => Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'separator'   => 'before',
                    'condition' => [
                        'sec_link_type' => '2',
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Choose Columns', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( '1', 'ellen-toolkit' ),
                        '2'   => __( '2', 'ellen-toolkit' ),
                        '3'   => __( '3', 'ellen-toolkit' ),
                        '4'   => __( '4', 'ellen-toolkit' ),
                    ],
                    'default' => '3',
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
                    'label' => __( 'Programs Order By', 'ellen-toolkit' ),
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
                    'default' => 4,
                ]
            );

            $this->add_control(
				'cd_button',
				[
					'label'   => __( 'Card Button', 'ellen-toolkit' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __('Search Program', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);

            $this->add_control(
				'cd_button_icon',
				[
					'label'   => __( 'Card Button Icon', 'ellen-toolkit' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __('bx bx-chevron-right', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);


        $this->end_controls_section();

        $this->start_controls_section(
			'university_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-top-content .content h2, {{WRAPPER}} .university-explore-top-content .content h3, {{WRAPPER}} .university-explore-top-content .content h1, {{WRAPPER}} .university-explore-top-content .content h4, {{WRAPPER}} .university-explore-top-content .content h5, {{WRAPPER}} .university-explore-top-content .content h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-explore-top-content .content h2, {{WRAPPER}} .university-explore-top-content .content h3, {{WRAPPER}} .university-explore-top-content .content h1, {{WRAPPER}} .university-explore-top-content .content h4, {{WRAPPER}} .university-explore-top-content .content h5, {{WRAPPER}} .university-explore-top-content .content h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-explore-top-content .content p' => 'color: {{VALUE}} !important',
					],
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-explore-top-content .content p',
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
				'sec_btn_color',
				[
					'label' => esc_html__( 'Section Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-explore-top-content .content p a' => 'color: {{VALUE}} !important',
					],
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
				]
			);

            $this->add_control(
				'sec_btn_hcolor',
				[
					'label' => esc_html__( 'Section Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-explore-top-content .content p a:hover' => 'color: {{VALUE}} !important',
					],
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_btn_typography',
                    'label' => esc_html__( 'Section Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-explore-top-content .content p a',
                    'condition' => [
                        'choose_style' => ['1'],
                    ]
                ]
            );

            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-card .image h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_title_hcolor',
                [
                    'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-card .image h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-explore-card .image h3',
                ]
            );
            
            $this->add_control(
                'cd_content_color',
                [
                    'label'     => __( 'Card Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-card .content p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_content',
                    'label'    => __( 'Card Content Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-explore-card .content p',
                ]
            );

            $this->add_control(
                'cd_btn_color',
                [
                    'label'     => __( 'Card Button Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-card .content .link-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_btn_h_color',
                [
                    'label'     => __( 'Card Button Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-explore-card .content .link-btn:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_btn_content',
                    'label'    => __( 'Card Button Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-explore-card .content .link-btn',
                ]
            );
            
        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        // Card Columns
        $columns = $settings['columns'];
        if ($columns == '1') {
            $column = 'col-lg-12 col-md-6';
        }elseif ($columns == '2') {
            $column = 'col-lg-6 col-md-6';
        }elseif ($columns == '3') {
            $column = 'col-xl-4 col-md-6';
        }elseif ($columns == '4') {
            $column = 'col-xl-3 col-lg-6 col-md-6';
        }

        // Programs Query
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if( $settings['cat_name'] != '' ) {
            $args = array(
                'post_type'     => 'program',
                'posts_per_page'=> $settings['count'],
                'order'         => $settings['order'],
                'tax_query'     => array(
                    array(
                        'taxonomy'      => 'program_cat',
                        'field'         => 'slug',
                        'terms'         => explode( ',', str_replace( ' ', '', $settings['cat_name'])),
                        'hide_empty'    => false
                    )
                ),
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            );
        } else {
            $args = array(
                'post_type'         => 'program',
                'posts_per_page'    => $settings['count'],
                'order'             => $settings['order'],
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            );
        }
        $program_array = new \WP_Query( $args );

    ?>


        <?php if($settings['choose_style']==1): 

            // Get Banner Button Link
            if($settings['sec_link_type'] == 1){
                $sec_link       = get_page_link( $settings['sec_link_to_page'] );
                $target     = '';
                $nofollow   = '';
            } else {
                $target     = $settings['sec_ex_link']['is_external'] ? ' target="_blank"' : '';
                $nofollow   = $settings['sec_ex_link']['nofollow'] ? ' rel="nofollow"' : '';
                $sec_link       = $settings['sec_ex_link']['url'];
            }
            
        ?>
            <!-- Start University Explore Area -->
            <div class="university-explore-area university-home pb-100">
                <div class="container">
                    <div class="university-explore-top-content">
                        <?php if( !empty( $settings['sec_img']['url'] ) ){ ?>
                            <div class="image">
                                <img src="<?php echo esc_url( $settings['sec_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        <?php } ?>

                        <div class="content">

                            <<?php echo esc_attr( $settings['heading_tag'] ); ?>><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                            <?php if( $settings['sec_content'] != '' ): ?>
                                <p><?php echo wp_kses_post( $settings['sec_content'] ); ?> <?php if($settings['sec_button_text'] && $sec_link): ?> <a href="<?php echo esc_url($sec_link); ?>" <?php echo $target; echo $nofollow; ?>><?php echo wp_kses_post( $settings['sec_button_text'] ); ?></a> <?php endif; ?></p>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="row justify-content-center g-5">
                        <?php
                            $i=1;
                            while($program_array->have_posts()):
                            $program_array->the_post();

                            $id    = get_the_ID();
                            
                            if ( class_exists( 'ACF') ) {
                                if ( get_field('choose_link_type') == 1 ) {
                                    $programs_link = get_post_permalink();
                                } else {
                                    $programs_link = get_field('external_link');
                                }
                            }
                        ?>
                            <div class="<?php echo esc_attr($column); ?>">
                                <div class="university-explore-card">
                                    <?php if(has_post_thumbnail()): ?>
                                        <div class="image">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url('ellen_el_program_380x475'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                            </a>
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        </div>
                                    <?php endif; ?>
                                    <div class="content">
                                        <p><?php the_excerpt(); ?></p>
                                        <?php if($settings['cd_button'] && $settings['cd_button_icon']): ?>
                                            <a href="<?php the_permalink(); ?>" class="link-btn"><?php echo wp_kses_post( $settings['cd_button'] ); ?> <i class='<?php echo esc_attr( $settings['cd_button_icon'] ); ?>'></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endwhile; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
            <!-- End University Explore Area -->
        <?php elseif($settings['choose_style']==2): ?>

             <!-- Start University Explore Area -->
             <div class="university-explore-area university-home pb-100">
                <div class="container">
                    <div class="section-wrap-title text-center">
                        <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    </div>
                    <div class="row justify-content-center g-5">
                        <?php
                            $i=1;
                            while($program_array->have_posts()):
                            $program_array->the_post();

                            $id    = get_the_ID();
                            
                            if ( class_exists( 'ACF') ) {
                                if ( get_field('choose_link_type') == 1 ) {
                                    $programs_link = get_post_permalink();
                                } else {
                                    $programs_link = get_field('external_link');
                                }
                            }
                        ?>
                            <div class="<?php echo esc_attr($column); ?>">
                                <div class="university-explore-card">
                                    <?php if(has_post_thumbnail()): ?>
                                        <div class="image">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url('ellen_el_program_380x475'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                            </a>
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        </div>
                                    <?php endif; ?>
                                    <div class="content">
                                        <p><?php the_excerpt(); ?></p>
                                        <?php if($settings['cd_button'] && $settings['cd_button_icon']): ?>
                                            <a href="<?php the_permalink(); ?>" class="link-btn"><?php echo wp_kses_post( $settings['cd_button'] ); ?> <i class='<?php echo esc_attr( $settings['cd_button_icon'] ); ?>'></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endwhile; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
            <!-- End University Explore Area -->

        <?php endif; ?>
        

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_Study_University );