<?php
/**
 * Health Reviews Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Reviews extends Widget_Base {

	public function get_name() {
        return 'Reviews_Health';
    }

	public function get_title() {
        return esc_html__( 'Health Reviews', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Health_Reviews_Area',
			[
				'label' => esc_html__( 'Health Reviews Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('ABOUT ELLEN', 'ellen-toolkit'),
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
                    'default'     => __('Join Ellen for a healthy lifestyle forever', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $feedback_items = new Repeater();

                $feedback_items->add_control(
                    'icon_count',
                    [
                        'label' => esc_html__('Feedback Rating Count', 'vaximo-toolkit'),
                        'type' => Controls_Manager::NUMBER,
                    ]
                );

                $feedback_items->add_control(
                    'feed_icon',
                    [
                        'label'   => __( 'Star Icon', 'vaximo-toolkit' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('bx bxs-star', 'vaximo-toolkit'),
                        'label_block' => true,
                    ]
                );

                $feedback_items->add_control(
                    'feedback',
                    [
                        'label' => esc_html__('Feedback', 'vaximo-toolkit'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Their quick response saved our organization from a ransomware attack. The guidance was clear, timely, and effective.', 'vaximo-toolkit'),
                        'label_block' => true,
                    ]
                );

                $feedback_items->add_control(
                    'u_img',
                    [
                        'label' 	=> esc_html__( 'User Images', 'vaximo-toolkit' ),
                        'type' => Controls_Manager::MEDIA,
                    ]
                );

                $feedback_items->add_control(
                    'name',
                    [
                        'label' => esc_html__('Name', 'vaximo-toolkit'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Brad Traversy', 'vaximo-toolkit'),
                        'label_block' => true,
                    ]
                );

                $feedback_items->add_control(
                    'user_desi',
                    [
                        'label' => esc_html__('Designation', 'vaximo-toolkit'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Car Owner', 'vaximo-toolkit'),
                        'label_block' => true,
                    ]
                );

                $feedback_items->add_control(
                    'quote_icon',
                    [
                        'label' 	=> esc_html__( 'Quote Images', 'vaximo-toolkit' ),
                        'type' => Controls_Manager::MEDIA,
                    ]
                );

            $this->add_control(
                'feedback_items',
                [
                    'label'   => __( 'Add Feedback Item', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $feedback_items->get_controls(),
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
                'sec_bg_color',
                [
                    'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-area' => 'background-color: {{VALUE}}',
                    ],
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
                'fb_bg_color',
                [
                    'label'     => __( 'Feedback Card Background Color', 'vaximo-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'fb_radius',
                [
                    'label' => esc_html__( 'Feedback Card Border Radius', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'fb_padding',
                [
                    'label' => esc_html__( 'Feedback Card Padding', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'star_color',
                [
                    'label' => esc_html__( 'Star Icon Color', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item .rating li i' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'star_typography',
                    'label' => __( 'Quote Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-reviews-item .rating li i',
                ]
            );

            $this->add_control(
                'feedback_color',
                [
                    'label' => esc_html__( 'Feedback Color', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item p' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'feedback_typography',
                    'label' => __( 'Feedback Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-reviews-item p',
                ]
            );

            $this->add_control(
                'name_color',
                [
                    'label' => esc_html__( 'Name Color', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item .info .title .text h3' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => __( 'Name Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-reviews-item .info .title .text h3',
                ]
            );

            
            $this->add_control(
                'des_color',
                [
                    'label' => esc_html__( 'Designation Color', 'vaximo-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-reviews-item .info .title .text span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'des_typography',
                    'label' => __( 'Designation Typography', 'vaximo-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-reviews-item .info .title .text span',
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

        <!-- Start HWF Reviews Area -->
        <div class="hwf-reviews-area health-wellness-fitness-home ptb-100">
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
                        <div class="col-lg-4 col-md-12">
                            <ul class="hwf-reviews-button">
                                <li>
                                    <div class="reviews-button-prev">
                                        <i class='bx bx-left-arrow-alt'></i>
                                    </div>
                                </li>
                                <li>
                                    <div class="reviews-button-next">
                                        <i class='bx bx-right-arrow-alt'></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="swiper hwf-reviews-slider">
                    <div class="swiper-wrapper">
                        <?php $i=1; foreach( $settings['feedback_items'] as $item ): ?>
                            <div class="swiper-slide">
                                <div class="hwf-reviews-item">
                                    <ul class="rating">
                                        <?php for ($x = 0; $x < $item['icon_count']; $x++) { ?>
                                            <?php if($item['feed_icon']):  ?>
                                                <li><i class='<?php echo esc_attr( $item['feed_icon'] ); ?>'></i></li>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </ul>
                                    <?php if( $item['feedback'] != '' ): ?>
                                        <p><?php echo wp_kses_post( $item['feedback'] ); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="info">
                                        <div class="title">
                                            <?php if($item['u_img']['url']): ?>
                                                <div class="image">
                                                    <img src="<?php echo esc_url( $item['u_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'images', 'vaximo-toolkit' ); ?>">
                                                </div>
                                            <?php endif; ?>
                                            <div class="text">
                                                <?php if( $item['name']): ?>
                                                    <h3><?php echo wp_kses_post( $item['name'] ); ?></h3>
                                                <?php endif; ?>
                                                <?php if( $item['user_desi']): ?>
                                                    <span><?php echo wp_kses_post( $item['user_desi'] ); ?></span>
                                                <?php endif; ?> 
                                            </div>
                                        </div>
                                        <?php if($item['quote_icon']['url']): ?>
                                            <div class="quote">
                                                <img src="<?php echo esc_url( $item['quote_icon']['url'] ); ?>" alt="<?php echo esc_attr__( 'images', 'vaximo-toolkit' ); ?>">
                                            </div>
                                        <?php endif; ?> 
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- End HWF Reviews Area -->



        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Health_Reviews );