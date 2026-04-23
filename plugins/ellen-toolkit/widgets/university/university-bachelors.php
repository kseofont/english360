<?php
/**
 * Top Header Widget
 */

namespace Elementor;
class University_Bachelors extends Widget_Base {

	public function get_name() {
        return 'UniversityBachelors';
    }

	public function get_title() {
        return __( 'University Bachelors', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-header';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Section',
			[
				'label' => __( 'Ellen Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );


            $list_item = new Repeater();

                $list_item->add_control(
                    'list_tit', [
                        'label'       => esc_html__( 'Left List Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Bachelors', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $list_item->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'Left List Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $list_item->add_control(
                    'link_to_page',
                    [
                        'label' 		=> esc_html__( 'Left List Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );
    
                $list_item->add_control(
                    'ex_link',
                    [
                        'label'		=> esc_html__('Left List Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '2',
                        ]
                    ]
                );

            $this->add_control(
                'list_items',
                [
                    'label'  => esc_html__( 'Add Left List Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $list_item->get_controls(),
                ]
            );

            $this->add_control(
                'f_img',
                [
                    'label'		=> esc_html__('Feature Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'sec_title',
                [
                    'label'   => __( 'Bachelors Section Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Architecture, Design and Planning', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Bachelors Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'As a university for the future, we combine cutting-edge research, innovative teaching methods, and a commitment to sustainability to prepare students for a rapidly evolving world.', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content2',
                [
                    'label'   => __( 'Bachelors Section Content tWO', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'As a university for the future, we combine cutting-edge research, innovative teaching methods, and a commitment to sustainability to prepare students for a rapidly evolving world.', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_title2',
                [
                    'label'   => __( 'Available Degrees Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Available Bachelor Degrees', 'ellen-toolkit' ),
                ]
            );

            $available_item = new Repeater();

                $available_item->add_control(
                    'ava_list_tit', [
                        'label'       => esc_html__( 'Available Degrees Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Bachelors', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );
                
                $available_item->add_control(
                    'ava_list_icon', [
                        'label'       => esc_html__( 'Available Degrees Item Icon', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'bx bx-chevron-right', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $available_item->add_control(
                    'ava_link_type',
                    [
                        'label' 		=> esc_html__( 'Available Degrees Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $available_item->add_control(
                    'ava_link_to_page',
                    [
                        'label' 		=> esc_html__( 'Available Degrees Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'ava_link_type' => '1',
                        ]
                    ]
                );
    
                $available_item->add_control(
                    'ava_ex_link',
                    [
                        'label'		=> esc_html__('Available Degrees Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'ava_link_type' => '2',
                        ]
                    ]
                );

            $this->add_control(
                'available_items',
                [
                    'label'  => esc_html__( 'Add Available Degrees Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $available_item->get_controls(),
                ]
            );

           
        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );
            
            $this->add_control(
                'left_title_color',
                [
                    'label' => esc_html__( 'Left List Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-sidebar li a' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'left_typography',
                    'label' => __( 'Left List Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .study-sidebar li a',
                ]
            );

            $this->add_control(
                'left_title_br_color',
                [
                    'label' => esc_html__( 'Left List Item Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-sidebar li a' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'left_title_h_br_color',
                [
                    'label' => esc_html__( 'Left List Item Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-sidebar li a::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content h2, {{WRAPPER}} .study-content h3, {{WRAPPER}} .study-content h1, {{WRAPPER}} .study-content h4, {{WRAPPER}} .study-content h5, {{WRAPPER}} .study-content h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .study-content h2, {{WRAPPER}} .study-content h3, {{WRAPPER}} .study-content h1, {{WRAPPER}} .study-content h4, {{WRAPPER}} .study-content h5, {{WRAPPER}} .study-content h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .study-content p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .study-content p',
                ]
            );

            $this->add_control(
                'av_item_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li a span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'av_item_h_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li a:hover span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'av_item_typography',
                    'label' => __( 'Available Degrees Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .study-content .list li a span',
                ]
            );

            $this->add_control(
                'av_item_ic_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Icon Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li a i' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'av_item_h_ic_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Hover Icon Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li a:hover i' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'av_item_ic_typography',
                    'label' => __( 'Available Degrees Item Icon Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .study-content .list li a i',
                ]
            );

            $this->add_control(
                'av_item_bg_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'av_item_h_br_color',
                [
                    'label' => esc_html__( 'Available Degrees Item Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .study-content .list li::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

       
        <!-- Start Study Area -->
        <div class="study-area university-home ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                        <ul class="study-sidebar">
                           
                            <?php $i=1; foreach( $settings['list_items'] as $item ): 
                    
                                // Get Button Link
                                if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                                    $link = get_page_link( $item['link_to_page'] );
                                }elseif($item['link_type'] == 2) {
                                    $link = $item['ex_link'];
                                }else{
                                    $link = '';
                                }

                                $current_page_title = get_the_title();

                            ?>

                                <?php if ( $item['list_tit'] && $link) : ?>
                                    <li <?php if( $current_page_title == wp_kses_post( $item['list_tit'] ) ): ?> class="active" <?php endif; ?>>
                                        <a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $item['list_tit'] ); ?></a>
                                    </li>
                                <?php endif; ?>

                            <?php $i++; endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="study-content">
                            <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                                <div class="image">
                                    <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                </div>
                            <?php } ?>
                            <?php if( $settings['sec_title'] != '' ): ?>
                                <h2><?php echo wp_kses_post( $settings['sec_title'] ); ?></h2>
                            <?php endif; ?>
                            <?php if( $settings['sec_content'] != '' ): ?>
                                <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                            <?php endif; ?>
                            <?php if( $settings['sec_content2'] != '' ): ?>
                                <p><?php echo wp_kses_post( $settings['sec_content2'] ); ?></p>
                            <?php endif; ?>
                            <?php if( $settings['sec_title2'] != '' ): ?>
                                <h2><?php echo wp_kses_post( $settings['sec_title2'] ); ?></h2>
                            <?php endif; ?>
                            <ul class="list">
                                <?php $i=1; foreach( $settings['available_items'] as $av_item ): 
                    
                                    // Get Button Link
                                    if( $av_item['ava_link_type'] == 1 ){
                                        $av_link = get_page_link( $av_item['ava_link_to_page'] );
                                    } else {
                                        $av_link = $av_item['ava_ex_link'];
                                    }

                                ?>

                                    <?php if ( $av_item['ava_list_tit'] && $av_link) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( $av_link ); ?>">
                                                <span><?php echo wp_kses_post( $av_item['ava_list_tit'] ); ?></span>
                                                <?php if( $av_item['ava_list_icon'] != '' ): ?>
                                                    <i class='<?php echo esc_attr( $av_item['ava_list_icon'] ); ?>'></i>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                <?php $i++; endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Study Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new University_Bachelors );
