<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class Ellen_Research_University extends Widget_Base {

	public function get_name() {
        return 'University_Research';
    }

	public function get_title() {
        return __( 'Ellen University Research', 'ellen-toolkit' );
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
				'label' => __( 'University Research Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                    'default' => __( 'Our Research', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Our researchers are tackling the worlds greatest problems, from creating a more sustainable world to developing new treatments.', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'recent_title',
                [
                    'label'   => __( 'Recent Research Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'RECENT RESEARCH PUBLICATIONS', 'ellen-toolkit' ),
                ]
            );
            

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'list_date',
                    [
                        'label'   => __( 'Research Release Date', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( '12 DEC, 2022', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_desc',
                    [
                        'label'   => __( 'Research Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( '“The Influence of Socioeconomic Status on Dietary Choices and Health Outcomes in Urban and Rural America”', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_author',
                    [
                        'label'   => __( 'Research Author', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( '- Andrew Miller', 'ellen-toolkit' ),
                    ]
                );

            $this->add_control(
                'ns_fea_item',
                [
                    'label'       => __( 'Add Research Item', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $fea_items->get_controls(),
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

        $this->end_controls_section();

        $this->start_controls_section(
			'university_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'sec_bg_color',
                [
                    'label'     => __( 'Section Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_bg_bt_color',
                [
                    'label'     => __( 'Section Bottom Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-area::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-area .section-wrap-title h2, {{WRAPPER}} .university-research-area .section-wrap-title h3, {{WRAPPER}} .university-research-area .section-wrap-title h1, {{WRAPPER}} .university-research-area .section-wrap-title h4, {{WRAPPER}} .university-research-area .section-wrap-title h5, {{WRAPPER}} .university-research-area .section-wrap-title h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-area .section-wrap-title h2, {{WRAPPER}} .university-research-area .section-wrap-title h3, {{WRAPPER}} .university-research-area .section-wrap-title h1, {{WRAPPER}} .university-research-area .section-wrap-title h4, {{WRAPPER}} .university-research-area .section-wrap-title h5, {{WRAPPER}} .university-research-area .section-wrap-title h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-research-area .section-wrap-title p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} ..university-research-area .section-wrap-title p',
                ]
            );

            $this->add_control(
                'lt_cd_bg_color',
                [
                    'label'     => __( 'Research Card Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-box' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'lt_cd_title_color',
                [
                    'label'     => __( 'Research Card Top Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-box h5' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_lt_cd_title',
                    'label'    => __( 'Research Card Top Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-box h5',
                ]
            );

            $this->add_control(
                'lt_cd_date_color',
                [
                    'label'     => __( 'Research Card Date Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-box .items .item strong' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_lt_date_title',
                    'label'    => __( 'Research Card Date Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-box .items .item strong',
                ]
            );

            $this->add_control(
                'left_cd_title_color',
                [
                    'label'     => __( 'Research Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-box .items .item p' => 'color: {{VALUE}}',
                    ],
                ]
            );
        
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_left_cd_title',
                    'label'    => __( 'Research Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-box .items .item p',
                ]
            );

            $this->add_control(
                'left_cd_ath_color',
                [
                    'label'     => __( 'Research Card Author Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-box .items .item span' => 'color: {{VALUE}}',
                    ],
                ]
            );
        
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_left_ath_title',
                    'label'    => __( 'Research Card Author Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-box .items .item span',
                ]
            );
           
            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-card .content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cd_title_h_color',
                [
                    'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-card .content h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cd_title_br_color',
                [
                    'label'     => __( 'Card Title Border Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-research-card .content h3::before' => 'color: {{VALUE}}',
                    ],
                ]
            );
        
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-research-card .content h3',
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
            
        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        $ns_fea_item  = $settings['ns_fea_item'];

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

        <!-- Start University Research Area -->
        <div class="university-research-area university-home ptb-100">
            <div class="container">
                <div class="section-wrap-title text-center">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?>><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <?php if( $settings['sec_content'] != '' ): ?>
                        <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="row justify-content-center align-items-center g-5">
                    <div class="col-xl-4 col-md-12">
                        <div class="university-research-box">
                            <?php if( $settings['recent_title'] != '' ): ?>
                                <h5><?php echo wp_kses_post( $settings['recent_title'] ); ?></h5>
                            <?php endif; ?>
                            <div class="items">
                                <?php $i=1; foreach( $ns_fea_item as $item  ): ?>
                                    <div class="item">
                                        <?php if($item['list_date'] != ''): ?>
                                            <strong><?php echo wp_kses_post( $item['list_date'] ); ?></strong>
                                        <?php endif; ?>
                                        <?php if($item['list_desc'] != ''): ?>
                                            <p><?php echo wp_kses_post( $item['list_desc'] ); ?></p>
                                        <?php endif; ?>
                                        <?php if($item['list_author'] != ''): ?>
                                            <span><?php echo wp_kses_post( $item['list_author'] ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php 
                                    $i++; endforeach; 
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php
                        $i=1;
                        while($program_array->have_posts()):
                        $program_array->the_post();

                        $id    = get_the_ID();
                        
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="university-research-card">
                                <?php if(has_post_thumbnail()): ?>
                                    <div class="image">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php the_post_thumbnail_url('ellen-programm-800X1064'); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>
                               
                                <div class="content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php $i++; endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
        <!-- End University Research Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_Research_University );