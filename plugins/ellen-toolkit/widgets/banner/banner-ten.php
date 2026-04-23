<?php
/**
 * Banner Ten Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Banner_Ten extends Widget_Base {

	public function get_name() {
        return 'Ellen_Banner_Ten';
    }

	public function get_title() {
        return esc_html__( 'Banner Ten', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Banner_Ten_Area',
			[
				'label' => esc_html__( 'Banner Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Master A New Language With Confidence!', 'ellen-toolkit' ),
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
                'default' => 'h1',
            ] );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Join our academy and start your journey to fluency in the worlds most spoken languages.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Get a Free Trial Lesson', 'ellen-toolkit'),
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

        $this->end_controls_section();

        $this->start_controls_section(
			'banner_images',
			[
				'label' => esc_html__( 'Images', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

            $this->add_control(
                'image1',
                [
                    'label'		=> esc_html__('Section Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape1',
                [
                    'label'		=> esc_html__('Shape Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape2',
                [
                    'label'		=> esc_html__('Shape Image Ten', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

        $this->end_controls_section();
       
        $this->start_controls_section(
			'card_sec',
			[
				'label' => esc_html__( 'Image Card Info', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'left_card_icon',
            [
                'label' 	=> esc_html__( 'Left Card Icon', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'left_card_title',
            [
                'label' 	=> esc_html__( 'Left Card Title', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> esc_html__('Students Enrolled', 'ellen-toolkit'),
            ]
        );
        $this->add_control(
            'left_card_number',
            [
                'label' 	=> esc_html__( 'Left Card Number', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::NUMBER,
                'default' 	=> 25,
            ]
        );
        $this->add_control(
            'left_card_number_text',
            [
                'label' 	=> esc_html__( 'Left Card Number Text', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> 'K+',
            ]
        );

        // Right Card
        $this->add_control(
            'right_card_icon',
            [
                'label' 	=> esc_html__( 'Right Card Icon', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'right_card_title',
            [
                'label' 	=> esc_html__( 'Right Card Title', 'ellen-toolkit' ),
                'type' 		=> Controls_Manager::TEXT,
                'default' 	=> esc_html__('Students Feedback', 'ellen-toolkit'),
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
            $this->add_responsive_control( 'banner_padding', [
                'label'      => esc_html__( 'Banner Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .language-academy-banner-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'Banner Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .language-academy-banner-area' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .language-academy-banner-content .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .language-academy-banner-content .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .language-academy-banner-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .language-academy-banner-content p',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .language-academy-banner-content .banner-btn .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .language-academy-banner-content .banner-btn .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_btn_typography',
                    'label' => esc_html__( 'Banner Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .language-academy-banner-content .banner-btn .default-btn',
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
        <div class="language-academy-banner-area">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-xxl-6 col-md-12">
                        <div class="language-academy-banner-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>

                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <div class="banner-btn">
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
                    <div class="col-xxl-6 col-md-12">
                        <div class="language-academy-banner-image">
                            <?php if( $settings['image1']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>

                            <?php if($settings['left_card_title']): ?> 
                                <div class="count-box">
                                    <div class="icon">
                                        <?php if($settings['left_card_icon']['url']): ?>
                                            <img src="<?php echo esc_url($settings['left_card_icon']['url']); ?>" alt="<?php echo esc_attr__('Image', 'ellen-toolkit'); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="title">
                                        <h3>
                                            <span class="odometer" data-count="<?php echo esc_attr($settings['left_card_number']); ?>">00</span><span class="plus"><?php echo esc_html($settings['left_card_number_text']); ?></span>
                                        </h3>
                                        <p><?php echo esc_html($settings['left_card_title']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            
                            <?php if($settings['right_card_title']): ?> 
                                <div class="rating-box">
                                    <h5><?php echo esc_html($settings['right_card_title']); ?></h5>
                                    <?php if($settings['right_card_icon']['url']): ?>
                                        <img src="<?php echo esc_url($settings['right_card_icon']['url']); ?>" alt="<?php echo esc_attr__('Image', 'ellen-toolkit'); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if( $settings['shape1']['url'] != '' ): ?>
                <div class="language-academy-banner-shape1" data-speed="0.10" data-revert="true">
                    <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>

            <?php if( $settings['shape2']['url'] != '' ): ?>
                <div class="language-academy-banner-shape2" data-speed="0.10" data-revert="true">
                    <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Banner_Ten );