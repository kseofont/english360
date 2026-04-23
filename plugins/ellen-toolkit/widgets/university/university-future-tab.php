<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class Ellen_University_Tab extends Widget_Base {

	public function get_name() {
        return 'University_Tab';
    }

	public function get_title() {
        return __( 'University Future Tab', 'ellen-toolkit' );
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
				'label' => __( 'University Future Tab Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'heading_tag', [
                    'label'   => __( 'Title Heading Tag', 'ellen-toolkit' ),
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
                    'default' => __( 'A university for the future', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'As a university for the future, we combine cutting-edge research, innovative teaching methods, and a commitment to sustainability to prepare students for a rapidly evolving world.', 'ellen-toolkit' ),
                ]
            );

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'tab_title',
                    [
                        'label'   => __( 'Tab Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'A UNIVERSITY FOR ALL', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'f_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'sub_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Sub Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_totitle',
                    [
                        'label'   => __( 'Top Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'OPENING IN 2025', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_title',
                    [
                        'label'   => __( 'Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'Pivot to proactive security', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_content',
                    [
                        'label'   => __( 'Content', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => __( 'At Ellen, our mission is to ignite potential and launch bright futures for every student. Through personalized support, world-class education, and opportunities for hands-on learning, we empower you to turn your dreams into reality.', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_list1',
                    [
                        'label'   => __( 'Content List One', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => __( '<ul class="list"><li><i class="bx bx-check"></i><span>Personalized student guidance</span></li><li><i class="bx bx-check"></i><span>World-class education programs</span></li></ul>', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_list2',
                    [
                        'label'   => __( 'Content List Two', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => __( '<ul class="list"><li><i class="bx bx-check"></i><span>Hands-on learning experiences</span></li><li><i class="bx bx-check"></i><span>Supportive, inspiring community</span></li></ul>', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_bottom_content',
                    [
                        'label'   => __( 'Bottom Content', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => __( 'Still want to know more about us? We are always open to our future student. You can know more about us through the link below.', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_btn_tit', [
                        'label'       => esc_html__( 'List Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'More About Us', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $fea_items->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'List Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $fea_items->add_control(
                    'link_to_page',
                    [
                        'label' 		=> esc_html__( 'List Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );
    
                $fea_items->add_control(
                    'ex_link',
                    [
                        'label'		=> esc_html__('List Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '2',
                        ]
                    ]
                );
                
            $this->add_control(
                'ns_fea_item',
                [
                    'label'       => __( 'Add Item', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $fea_items->get_controls(),
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
                        '{{WRAPPER}} .university-about-area::before' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} {{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .section-wrap-title p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title p',
                ]
            );

            $this->add_control(
                'tab_title_color',
                [
                    'label'     => __( 'Tab Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_h_color',
                [
                    'label'     => __( 'Tab Hover / Active Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link:hover, {{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link.active' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_bgcolor',
                [
                    'label'     => __( 'Tab Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_h_bgcolor',
                [
                    'label'     => __( 'Tab Hover / Active Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link:hover, {{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link.active' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'tab_title_br_color',
                [
                    'label'     => __( 'Tab Border Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'tab_title_br_h_color',
                [
                    'label'     => __( 'Tab Hover / Active Border Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link::before' => 'background: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_tab_title',
                    'label'    => __( 'Tab Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-tabs .nav .nav-item .nav-link',
                ]
            );

            $this->add_control(
                'list_toptitle_color',
                [
                    'label'     => __( 'Tab Content Top Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'list_toptitle_bg_color',
                [
                    'label'     => __( 'Tab Content Top Title Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content .sub' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_toptitle',
                    'label'    => __( 'Tab Content Top Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content .sub',
                ]
            );

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Tab Content Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content h2' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Tab Content Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content h2',
                ]
            );
            
            $this->add_control(
                'list_content_color',
                [
                    'label'     => __( 'Tab Content Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_content',
                    'label'    => __( 'Tab Content Content Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content p',
                ]
            );

            $this->add_control(
                'list_ul_color',
                [
                    'label'     => __( 'Tab Content List Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content .list li' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_ul',
                    'label'    => __( 'Tab Content List Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content .list li',
                ]
            );

            $this->add_control(
                'list_ul_ic_color',
                [
                    'label'     => __( 'Tab Content List Icon Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content .list li i' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_ic_ul',
                    'label'    => __( 'Tab Content List Icon Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content .list li i',
                ]
            );

            $this->add_control(
                'list_content_b_color',
                [
                    'label'     => __( 'Tab Content Bottom Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-about-content .bottom p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_b_content',
                    'label'    => __( 'Tab Content Bottom Content Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-about-content .bottom p',
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

        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        $ns_fea_item  = $settings['ns_fea_item'];

    ?>

        <!-- Start University About Area -->
        <div class="university-about-area ptb-100">
            <div class="container">
                <div class="section-wrap-title text-center">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <?php if( $settings['sec_content'] != '' ): ?>
                        <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="university-about-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php $i=1; foreach( $ns_fea_item as $item  ):  ?>
                            <?php if ( $item['tab_title']) : ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($i==1): ?> active <?php endif; ?>" id="one-tab<?php echo $i; ?>" data-bs-toggle="tab" href="#one<?php echo $i; ?>" role="tab" aria-controls="one<?php echo $i; ?>">
                                        <?php echo wp_kses_post($item['tab_title']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php 
                            $i++; endforeach; 
                        ?>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <?php $i=1; foreach( $ns_fea_item as $item  ):  
                            // Get Button Link
                            if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                                $link = get_page_link( $item['link_to_page'] );
                            }elseif($item['link_type'] == 2) {
                                $link = $item['ex_link'];
                            }else{
                                $link = '';
                            }
                        ?>
                            <div class="tab-pane fade <?php if($i==1): ?> show active <?php endif; ?>" id="one<?php echo $i; ?>" role="tabpanel">
                                <div class="row justify-content-center align-items-center g-5">
                                    <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="university-about-image">
                                                <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                <?php if( !empty( $item['sub_img']['url'] ) ){ ?>
                                                    <div class="wrap-shape">
                                                        <img src="<?php echo esc_url( $item['sub_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                    <div class="col-xl-6 col-md-12">
                                        <div class="university-about-content">
                                            <?php if($item['list_totitle'] != ''): ?>
                                                <span class="sub"><?php echo wp_kses_post( $item['list_totitle'] ); ?></span>
                                            <?php endif; ?>
                                            <?php if($item['list_title'] != ''): ?>
                                                <h2><?php echo wp_kses_post( $item['list_title'] ); ?></h2>
                                            <?php endif; ?>
                                            <?php if($item['list_content'] != ''): ?>
                                                <p><?php echo wp_kses_post( $item['list_content'] ); ?></p>
                                            <?php endif; ?>
                                            
                                            <div class="row justify-content-center">
                                                <div class="col-lg-6 col-md-6">
                                                    <?php if($item['list_list1'] != ''): ?>
                                                        <?php echo wp_kses_post( $item['list_list1'] ); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <?php if($item['list_list2'] != ''): ?>
                                                        <?php echo wp_kses_post( $item['list_list2'] ); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="bottom">
                                                <?php if($item['list_bottom_content'] != ''): ?>
                                                    <p><?php echo wp_kses_post( $item['list_bottom_content'] ); ?></p>
                                                <?php endif; ?>
                                                <?php if($item['list_btn_tit'] && $link): ?>
                                                    <a href="<?php echo esc_url( $link ); ?>" class="optional-btn"><?php echo wp_kses_post( $item['list_btn_tit'] ); ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            $i++; endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End University About Area -->



        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_University_Tab );