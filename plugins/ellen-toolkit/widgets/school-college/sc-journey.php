<?php
/**
 * University Why Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sc_Journey extends Widget_Base {

	public function get_name() {
        return 'Journey_Sc';
    }

	public function get_title() {
        return esc_html__( 'School & College Journey', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-before-after';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Journey_Area',
			[
				'label' => esc_html__( 'School & College Journey Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
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
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('START ELLEN JOURNEY', 'ellen-toolkit'),
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
                    'default'     => __('Start your journey at Ellen', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'bg_title',
                [
                    'label'       => __( 'Background Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('START YOUR JOURNEY', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Explore all that Ellen has to offer. Learn about our school, join one of our events or take a virtual tour.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Register Now', 'ellen-toolkit'),
                    'condition' => [
                        'choose_style' => ['2'],
                    ]
				]
            );

            $this->add_control(
                'button_link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                    'condition' => [
                        'choose_style' => ['2'],
                    ]
                ]
            );

            $this->add_control(
                'button_link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'button_link_type' => '1',
                        'choose_style' => ['2'],
                    ]
                ]
            );

            $this->add_control(
                'button_ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'        => Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'separator'   => 'before',
                    'condition' => [
                        'button_link_type' => '2',
                        'choose_style' => ['2'],
                    ]
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
                    'list_btn_icon', [
                        'label'       => esc_html__( 'Card Button Icon', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'bx bx-chevron-right', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $fea_items->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'Card Item Link Type', 'ellen-toolkit' ),
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
                        'label' 		=> esc_html__( 'Card Item Link To Page', 'ellen-toolkit' ),
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
                        'label'		=> esc_html__('Card Item External Link', 'ellen-toolkit'),
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
                        '{{WRAPPER}} .sc-journey-content .sub::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-journey-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-journey-content .sub',
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-journey-content .title-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-journey-content .title-tags',
                ]
            );

            $this->add_control(
				'bg_title_color',
				[
					'label' => esc_html__( 'Background Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-journey-inner .little-big' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'bg_title_typography',
                    'label' => esc_html__( 'Background Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-journey-inner .little-big',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-journey-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-journey-content p',
                ]
            );

            $this->add_control(
                'cd_bg_color',
                [
                    'label'     => __( 'Card Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-journey-card' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-journey-card h3' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-journey-card h3',
                ]
            );

            $this->add_control(
                'cd_btn_color',
                [
                    'label'     => __( 'Card Button Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-journey-card .link-btn a i' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_btn_h_color',
                [
                    'label'     => __( 'Card Button Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-journey-card .link-btn a:hover i' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_btn',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-journey-card .link-btn a i',
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
                    'condition' => [
                        'choose_style' => ['2'],
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
                    'condition' => [
                        'choose_style' => ['2'],
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
                    'condition' => [
                        'choose_style' => ['2'],
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
                    'condition' => [
                        'choose_style' => ['2'],
                    ],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
                    'condition' => [
                        'choose_style' => ['2'],
                    ],
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';
        
        $ns_fea_item  = $settings['ns_fea_item'];
     
        ?>


        <?php if($settings['choose_style']==1): ?>
            <!-- Start SC Journey Area -->
            <div class="sc-journey-area school-college-home">
                <div class="container">
                    <div class="sc-journey-inner">
                        <div class="sc-journey-content">
                            <?php if( $settings['top_title']): ?>
                                <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                            <?php endif; ?>
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                            <?php if( $settings['content']): ?>
                                <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="row justify-content-center g-0">
                            <?php $i=1; foreach( $ns_fea_item as $item  ):  

                                // Get Button Link
                                if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                                    $link = get_page_link( $item['link_to_page'] );
                                }elseif($item['link_type'] == 2) {
                                    $link = $item['ex_link'];
                                }else{
                                    $link = '';
                                }

                                $clNam = '';
                                if($i==2){
                                    $clNam= 'wrap2';
                                }elseif($i==3){
                                    $clNam= 'wrap3';
                                }
                            ?>
                                <div class="col-lg-4 col-md-12">
                                    <div class="sc-journey-card <?php echo esc_attr( $clNam ); ?>">
                                        <div class="content">
                                        
                                            <?php if($item['list_title'] != ''): ?>
                                                <h3><?php echo wp_kses_post( $item['list_title'] ); ?></h3>
                                            <?php endif; ?>
                                            <?php if($item['list_btn_icon'] && $link): ?>
                                                <div class="link-btn">
                                                    <a href="<?php echo esc_url( $link ); ?>"><i class='<?php echo esc_attr( $item['list_btn_icon'] ); ?>'></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                            <div class="image">
                                                <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                            <?php 
                                $i++; endforeach; 
                            ?>
                        </div>

                        <?php if( $settings['bg_title']): ?>
                            <h3 class="little-big"><?php echo wp_kses_post($settings['bg_title']); ?></h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- End SC Journey Area -->
        <?php elseif($settings['choose_style']==2): 

            // Get Banner Button Link
            if($settings['button_link_type'] == 1){
                $button_link       = get_page_link( $settings['button_link_to_page'] );
                $target     = '';
                $nofollow   = '';
            } else {
                $target     = $settings['button_ex_link']['is_external'] ? ' target="_blank"' : '';
                $nofollow   = $settings['button_ex_link']['nofollow'] ? ' rel="nofollow"' : '';
                $button_link       = $settings['button_ex_link']['url'];
            }
        
        ?>

            <!-- Start SC Journey Area -->
            <div class="sc-journey-area health-wellness-fitness-home">
                <div class="container">
                    <div class="sc-journey-inner">
                        <div class="sc-journey-content">
                            <?php if( $settings['top_title']): ?>
                                <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                            <?php endif; ?>
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                            <?php if( $settings['content']): ?>
                                <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                            <?php endif; ?>

                            <?php if($settings['button_text'] && $button_link): ?>
                                <div class="journey-btn">
                                    <a href="<?php echo esc_url($button_link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn extra-radius"><?php echo esc_html($settings['button_text']); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row justify-content-center g-0">
                            <?php $i=1; foreach( $ns_fea_item as $item  ):  

                                // Get Button Link
                                if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                                    $link = get_page_link( $item['link_to_page'] );
                                }elseif($item['link_type'] == 2) {
                                    $link = $item['ex_link'];
                                }else{
                                    $link = '';
                                }

                                $clNam = '';
                                if($i==2){
                                    $clNam= 'wrap2';
                                }elseif($i==3){
                                    $clNam= 'wrap3';
                                }
                            ?>
                                <div class="col-lg-4 col-md-12">
                                    <div class="sc-journey-card <?php echo esc_attr( $clNam ); ?>">
                                        <div class="content">
                                        
                                            <?php if($item['list_title'] != ''): ?>
                                                <h3><?php echo wp_kses_post( $item['list_title'] ); ?></h3>
                                            <?php endif; ?>
                                            <?php if($item['list_btn_icon'] && $link): ?>
                                                <div class="link-btn">
                                                    <a href="<?php echo esc_url( $link ); ?>"><i class='<?php echo esc_attr( $item['list_btn_icon'] ); ?>'></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                            <div class="image">
                                                <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            </div>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                            <?php 
                                $i++; endforeach; 
                            ?>
                        </div>

                        <?php if( $settings['bg_title']): ?>
                            <h3 class="little-big"><?php echo wp_kses_post($settings['bg_title']); ?></h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- End SC Journey Area -->

        <?php endif; ?>

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Sc_Journey );