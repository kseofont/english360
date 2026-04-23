<?php
/**
 * Health Banner Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Banner extends Widget_Base {

	public function get_name() {
        return 'Banner_Health';
    }

	public function get_title() {
        return esc_html__( 'Health Banner', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Health_Banner_Area',
			[
				'label' => esc_html__( 'Banner Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        ); 

            $this->add_control(
                'title_tag',
                [
                    'label'     => esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => [
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

            $slider_items = new Repeater();

                $slider_items->add_control(
                    'bg_img',
                    [
                        'label'		=> esc_html__('Background Image', 'ellen-toolkit'),
                        'type'		=> Controls_Manager:: MEDIA,
                    ]
                );

                $slider_items->add_control(
                    'top_title',
                    [
                        'label'       => __( 'Top Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => __('HEALTH, WELLNESS AND FITNESS ONLINE COURSES', 'ellen-toolkit'),
                        'label_block' => true,
                    ]
                );

                $slider_items->add_control(
                    'title',
                    [
                        'label'       => __( 'Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => __('<strong>Heal yourself</strong> with our health & wellness online <strong>Courses</strong>', 'ellen-toolkit'),
                        'label_block' => true,
                    ]
                );

                $slider_items->add_control(
                    'content',
                    [
                        'label'       => __( 'Content', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => __('Welcome to Ellen, where innovation and excellence pave the way for a brighter future. Our vibrant campus fosters a community of learners, leaders, and visionaries, empowering students to excel in academics.', 'ellen-toolkit'),
                        'label_block' => true,
                    ]
                );
               
                $slider_items->add_control(
                    'button_text', [
                        'label'       => esc_html__( 'Left Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Find Courses', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $slider_items->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'Left Button Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );

                $slider_items->add_control(
                    'link_to_page',
                    [
                        'label' 		=> esc_html__( 'Left Button Link Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );

                $slider_items->add_control(
                    'ex_link',
                    [
                        'label'		=> esc_html__('Left Button External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '2',
                        ]
                    ]
                );

                $slider_items->add_control(
                    'button_text2', [
                        'label'       => esc_html__( 'Right Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'See Reviews', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $slider_items->add_control(
                    'link_type2',
                    [
                        'label' 		=> esc_html__( 'Right Button Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );

                $slider_items->add_control(
                    'link_to_page2',
                    [
                        'label' 		=> esc_html__( 'Right Button Link Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type2' => '1',
                        ]
                    ]
                );

                $slider_items->add_control(
                    'ex_link2',
                    [
                        'label'		=> esc_html__('Right Button External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type2' => '2',
                        ]
                    ]
                );
                
            $this->add_control(
                'banner_item',
                [
                    'label'       => __( 'Add Banner Item', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $slider_items->get_controls(),
                ]
            );

            $this->add_control(
                's_img',
                [
                    'label'		=> esc_html__('Sub Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
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
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-slider-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .hwf-slider-content .sub',
                ]
            );
            
            $this->add_control(
				'top_title_bg',
				[
					'label' => esc_html__( 'Top Title Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content .sub' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content .title-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-slider-content .title-tags',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-slider-content p',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Left Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Left Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_bg_color',
				[
					'label' => __( 'Left Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover_color',
				[
					'label' => __( 'Left Button Hover Background Color', 'ellen-toolkit' ),
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
                    'label' => esc_html__( 'Left Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
                ]
            );

            $this->add_control(
				'r_btn_bg_color',
				[
					'label' => __( 'Right Button Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content .banner-btn li:last-child .optional-btn' => 'border-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'right_btn_color',
				[
					'label' => __( 'Right Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content .banner-btn li:last-child .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'right_btn_hover_color',
				[
					'label' => __( 'Right Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-slider-content .banner-btn li:last-child .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'right_btn_typography',
                    'label' => esc_html__( 'Right Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-slider-content .banner-btn li:last-child .optional-btn',
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

        ?>
      
        <!-- Start Health, Wellness & Fitness Slider Area -->
        <div class="hwf-slider-area health-wellness-fitness-home">
            <div class="swiper hwf-slider">
                <div class="swiper-wrapper">

                    <?php foreach( $settings['banner_item'] as $item ): 

                        // Get Button Link
                        if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                            $link = get_page_link( $item['link_to_page'] );
                        }elseif($item['link_type'] == 2) {
                            $link = $item['ex_link'];
                        }else{
                            $link = '';
                        }

                        if ($item['link_type2'] == 1 && !empty($item['link_to_page2']) && get_post_status($item['link_to_page2'])) {
                            $link2 = get_page_link( $item['link_to_page2'] );
                        }elseif($item['link_type2'] == 2) {
                            $link2 = $item['ex_link2'];
                        }else{
                            $link2 = '';
                        }
                        
                    ?>
                        <div class="swiper-slide">
                            <div class="hwf-slider-item" <?php if($item['bg_img']['url']): ?> style="background-image: url(<?php echo esc_url($item['bg_img']['url']); ?>);"  <?php endif; ?>>
                                <div class="container-fluid">
                                    <div class="hwf-slider-content">
                                        <?php if( $item['top_title']): ?>
                                            <span class="sub"><?php echo wp_kses_post($item['top_title']); ?></span>
                                        <?php endif; ?>

                                        <?php if( $item['title']): ?>
                                            <<?php echo $title_tag;?> class="title-tags"><?php echo wp_kses_post($item['title'] ); ?></<?php echo $title_tag; ?>>
                                        <?php endif; ?>
                                        <?php if( $item['content']): ?>
                                            <p><?php echo wp_kses_post($item['content'] ); ?></p>
                                        <?php endif; ?>
                                        <ul class="banner-btn">
                                            <?php if($item['button_text'] && $link): ?>
                                                <li>
                                                    <a href="<?php echo esc_url($link); ?>" class="optional-btn extra-radius"> <?php echo esc_html($item['button_text']); ?></a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if($item['button_text2'] && $link2): ?>
                                                <li>
                                                    <a href="<?php echo esc_url($link2); ?>" class="optional-btn extra-radius"> <?php echo esc_html($item['button_text2']); ?></a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <?php if( !empty( $settings['s_img']['url'] ) ){ ?>
                                    <div class="white-wrap">
                                        <img src="<?php echo esc_url( $settings['s_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>
            <div class="hwf-slider-pagination"></div>
        </div>
        <!-- End Health, Wellness & Fitness Slider Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Health_Banner );