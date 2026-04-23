<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class University_Study_International extends Widget_Base {

	public function get_name() {
        return 'Study_International';
    }

	public function get_title() {
        return __( 'University International Study', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-featured-image';
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
                'video_url',
                [
                    'label'   => __( 'Video Url', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( '#', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                's_img',
                [
                    'label'		=> esc_html__('Mask Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Study as International', 'ellen-toolkit'),
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
                    'default'     => __('Student', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Whether youre starting out, wanting to further your career, or pursuing a passion, lets make it happen.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'f_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_title',
                    [
                        'label'   => __( 'Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'Campus Tour', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_con',
                    [
                        'label'   => __( 'Content', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'Book a campus tour.', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_btn_tit', [
                        'label'       => esc_html__( 'List Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Visit Campus', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $fea_items->add_control(
                    'list_btn_icon', [
                        'label'       => esc_html__( 'List Button Icon', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'bx bx-chevron-right', 'ellen-toolkit' ),
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
                        '{{WRAPPER}} .university-student-area' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
				'top_tit_color',
				[
					'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-student-content h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_tit_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-student-content h3',
                ]
            );

            $this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-student-content .title-tag-in' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-student-content .title-tag-in',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-student-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-student-content p',
                ]
            );

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-student-content .items .item .content h5' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-student-content .items .item .content h5',
                ]
            );

            $this->add_control(
                'list_con_color',
                [
                    'label'     => __( 'Card Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-student-content .items .item .content span' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_con',
                    'label'    => __( 'Card Content Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-student-content .items .item .content span',
                ]
            );
            
            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-student-content .items .item .content .link-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-student-content .items .item .content .link-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-student-content .items .item .content .link-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        $ns_fea_item  = $settings['ns_fea_item'];

    ?>


        <!-- Start University Student Area -->
        <div class="university-student-area university-home pt-100">
            <div class="container">
                <div class="university-student-inner pb-100">
                    <div class="row justify-content-center align-items-center g-5">
                        <?php if( !empty( $settings['video_url']) ){ ?>
                            <div class="col-xl-6 col-md-12">
                                <div class="university-student-video">
                                    <video loop="" muted="" autoplay="" class="student-video">
                                        <source src="<?php echo esc_attr( $settings['video_url'] ); ?>" type="video/mp4">
                                    </video>
                                    <?php if( !empty( $settings['s_img']['url'] ) ){ ?>
                                        <div class="mask">
                                            <img src="<?php echo esc_url( $settings['s_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-xl-6 col-md-12">
                            <div class="university-student-content">
                                <?php if( $settings['top_title'] != '' ): ?>
                                    <h3><?php echo wp_kses_post( $settings['top_title'] ); ?></h3>
                                <?php endif; ?>
                               
                               <<?php echo esc_attr( $settings['title_tag'] ); ?> class="title-tag-in"><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                <?php if( $settings['content'] != '' ): ?>
                                    <p><?php echo wp_kses_post( $settings['content'] ); ?></p>
                                <?php endif; ?>

                                <div class="items">
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
                                    <div class="item">
                                        <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                            <div class="image">
                                                <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            </div>
                                        <?php } ?>
                                        <div class="content">
                                            <?php if($item['list_title'] != ''): ?>
                                                <h5><?php echo wp_kses_post( $item['list_title'] ); ?></h5>
                                            <?php endif; ?>
                                            <?php if($item['list_con'] != ''): ?>
                                                <span><?php echo wp_kses_post( $item['list_con'] ); ?></span>
                                            <?php endif; ?>
                                            <?php if($item['list_btn_tit'] && $link): ?>
                                                <a href="<?php echo esc_url( $link ); ?>" class="link-btn"><?php echo wp_kses_post( $item['list_btn_tit'] ); ?> <?php if($item['list_btn_icon']): ?><i class='<?php echo esc_attr( $item['list_btn_icon'] ); ?>'></i> <?php endif; ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php 
                                        $i++; endforeach; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End University Student Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new University_Study_International );