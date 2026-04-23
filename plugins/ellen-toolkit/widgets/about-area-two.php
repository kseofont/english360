<?php
/**
 * About Area Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_About_Area_Two extends Widget_Base {

	public function get_name() {
        return 'Ellen_About_Area_Two';
    }

	public function get_title() {
        return esc_html__( 'About Area Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-alert';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_About_Area_Area',
			[
				'label' => esc_html__( 'About Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'top_title', [
                'label'       => esc_html__( 'Top Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'ABOUT ELLEN', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your top title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Why Choose Ellen Language Academy?', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );

			$this->add_control( 'title_tag', [
                'label'   => esc_html__( 'Title HTML Tag', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ] );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Unlock the full potential of your business with our comprehensive suite of coaching services designed to meet the unique needs of every entrepreneur.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);
            $this->add_control(
                'img',
                [
                    'label'		=> esc_html__('Section Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $list_items = new Repeater();

            $list_items->add_control(
                'title',
                [
                    'label' => __( 'Tab Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Our Story', 'ellen-toolkit' ),
                ]
            );
            $list_items->add_control(
                'content',
                [
                    'label' => __( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'Founded by passionate linguists and experienced educators, Ellen Language Academy has grown from a small local school into a renowned global institution. Over the years, we’ve helped thousands of students achieve fluency in their chosen languages, empowering them to travel, work, and live in different parts of the world with confidence.' ),
                ]
            );
            $this->add_control(
                'items',
                [
                    'label' => esc_html__('Tab Items', 'ellen-toolkit'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $list_items->get_controls(),
                ]
            );

            $this->add_control( 'number', [
                'label'       => esc_html__( 'Number', 'ellen-toolkit' ),
                'type'        => Controls_Manager::NUMBER,
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => 100,
            ] );

            $this->add_control( 'number_text', [
                'label'       => esc_html__( 'Number Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => '%',
            ] );
            $this->add_control( 'number_title', [
                'label'       => esc_html__( 'Number Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
                'default' => 'Learners Satisfaction Rate',
            ] );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('More About Us', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'button_icon',
				[
					'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::MEDIA,
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
				'shape',
				[
					'label' 	=> esc_html__( 'Shape Image', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::MEDIA,
				]
            );


        $this->end_controls_section();

        $this->start_controls_section(
			'sec_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
            $this->add_responsive_control( 'banner_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .la-about-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-area' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'top_title_color',
				[
					'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .sub' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content .sub',
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
						'{{WRAPPER}} .la-about-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content p',
                ]
            );

            $this->add_control(
				'tab_color',
				[
					'label' => esc_html__( 'Tab Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .la-about-tabs .nav-item .nav-link' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tab_typography',
                    'label' => esc_html__( 'Tab Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content .la-about-tabs .nav-item .nav-link',
                ]
            );
            $this->add_control(
				'number_color',
				[
					'label' => esc_html__( 'Number Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .inner-bottom .count-box h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'label' => esc_html__( 'Number Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content .inner-bottom .count-box h3',
                ]
            );
            $this->add_control(
				'number_title_color',
				[
					'label' => esc_html__( 'Number Title', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .inner-bottom .count-box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_title_typography',
                    'label' => esc_html__( 'Number Title', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content .inner-bottom .count-box p',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .inner-bottom .about-btn .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .la-about-content .inner-bottom .about-btn .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .la-about-content .inner-bottom .about-btn .default-btn',
                ]
            );
        $this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

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
        ?>
        <div class="la-about-area ptb-100">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-xl-6 col-md-12">
                        <?php if($settings['img']['url']): ?>
                            <div class="la-about-image">
                                <img src="<?php echo esc_url($settings['img']['url']); ?>" alt="<?php echo esc_attr__('Image', 'ellen-toolkit'); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="la-about-content">
                            <span class="sub"><?php echo wp_kses_post( $settings['top_title'] ); ?></span>
                            
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>

                            <p <?php echo $this-> get_render_attribute_string('content'); ?> class="extra"><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <ul class="nav nav-tabs la-about-tabs" id="myTab" role="tablist">
                                <?php $i = 1; foreach($settings['items'] as $item): ?> 
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if($i == 1): ?> active<?php endif; ?>" id="tab-atab-<?php echo $i; ?>" data-bs-toggle="tab" data-bs-target="#atab-<?php echo $i; ?>" type="button" role="tab" aria-controls="atab-<?php echo $i; ?>" aria-selected="true"><?php echo esc_html($item['title']); ?></button>
                                    </li>
                                <?php $i++; endforeach; ?>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <?php $i = 1; foreach($settings['items'] as $item): ?> 
                                    <div class="tab-pane fade <?php if($i == 1): ?> show active<?php endif; ?>" id="atab-<?php echo $i; ?>" role="tabpanel" aria-labelledby="#atab-<?php echo $i; ?>">
                                        <p><?php echo wp_kses_post($item['content']); ?></p>
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                            <div class="inner-bottom">
                                <div class="count-box">
                                    <h3>
                                        <span class="odometer" data-count="<?php echo esc_attr($settings['number']); ?>">00</span><span class="plus"><?php echo esc_attr($settings['number_text']); ?></span>
                                    </h3>
                                    <p><?php echo esc_html($settings['number_title']); ?></p>
                                </div>
                                <div class="about-btn">
                                    <?php if($settings['button_text']): ?>
                                        <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> 
                                            <?php echo esc_html($settings['button_text']); ?>
                                            <?php if($settings['button_icon']['url']): ?>
                                                <img src="<?php echo esc_url($settings['button_icon']['url']); ?>" alt="<?php echo esc_attr__('Button Icon', 'ellen-toolkit'); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($settings['shape']['url']): ?>
                <div class="la-about-shape1">
                    <img src="<?php echo esc_url($settings['shape']['url']); ?>" alt="<?php echo esc_attr__('Image', 'ellen-toolkit'); ?>">
                </div>
            <?php endif; ?>
        </div>
        <?php
	}
}
Plugin::instance()->widgets_manager->register( new Ellen_About_Area_Two );