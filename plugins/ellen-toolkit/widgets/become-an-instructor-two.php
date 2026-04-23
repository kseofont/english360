<?php
/**
 * Become Instructor Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Become_Instructor_Two extends Widget_Base {

	public function get_name() {
        return 'Become_Instructor_Two_One';
    }

	public function get_title() {
        return esc_html__( 'Become Instructor Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-plus';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Become_Instructor_Two_Area',
			[
				'label' => esc_html__( 'Become Instructor Two Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control( 'style', [
                'label'   => esc_html__( 'Style', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '1'   => 'Style One',
                    '2'   => 'Style Two',
                ],
                'default' => '1',
            ] );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'This is the heading', 'ellen-toolkit' ),
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
					'default' 	=> esc_html__('Explore all of our courses and pick your suitable ones to enroll and start learning with us!', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Start Teaching Today', 'ellen-toolkit'),
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
				'social_title',
				[
					'label' 	=> esc_html__( 'Social Title', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Follow Us:', 'ellen-toolkit'),
                    'label_block' => true,
                    'description'   => "Please go to Theme Options->Social Profiles to manage social icons",
				]
			);
        $this->end_controls_section();

        $this->start_controls_section(
			'bit_images',
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
                    'label'		=> esc_html__('Shape Image Two', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape3',
                [
                    'label'		=> esc_html__('Shape Image Three', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );
            $this->add_control(
                'shape4',
                [
                    'label'		=> esc_html__('Shape Image Four', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'bit_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
            $this->add_responsive_control( 'bit_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .become-instructor-inner-area, .become-instructor-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'section_bg',
				[
					'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-inner-area, .become-insinstructor-img::before' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-content .title, .become-instructor-content.black-color .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .become-instructor-inner-area .title, .become-instructor-content.black-color .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-content p, .become-instructor-content.black-color p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .become-instructor-content p, .become-instructor-content.black-color p',
                ]
            );

            $this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-content .default-btn, .become-instructor-content.black-color .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-content .default-btn:hover, .become-instructor-content.black-color .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'social_color',
				[
					'label' => esc_html__( 'Social Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .become-instructor-content .social span, .become-instructor-content.black-color .social span' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'social_typography',
                    'label' => esc_html__( 'Social Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .become-instructor-content .social span, .become-instructor-content.black-color .social span',
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

        <?php if($settings['style'] == '1'): ?>
            <style>
                .become-insinstructor-image::before {
                    background-image: url(<?php echo esc_url($settings['shape3']['url']); ?>);
                }
                .become-insinstructor-image::after {
                    background-image: url(<?php echo esc_url($settings['shape4']['url']); ?>);
                }
            </style>
            <div class="become-instructor-area">
                <div class="container">
                    <div class="become-instructor-inner-area">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="become-insinstructor-image">
                                    <?php if( $settings['image1']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="become-instructor-content">
                                    <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                        <?php echo wp_kses_post( $settings['title'] ); ?>
                                    </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                    <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                                    <?php if($settings['button_text']): ?>
                                        <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($settings['button_text']); ?></a>
                                    <?php endif; ?>

                                    <?php if($settings['social_title']): ?>
                                        <div class="social">
                                            <div class="d-flex align-items-center">
                                                <span><?php echo esc_html($settings['social_title']); ?></span>
                                                <ul>
                                                    <?php ellen_social_link(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if( $settings['shape1']['url'] != '' ): ?>
                    <div class="shape4">
                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
                <?php if( $settings['shape2']['url'] != '' ): ?>
                    <div class="shape6">
                        <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php elseif($settings['style'] == '2'): ?>
            <div class="become-instructor-area pt-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="become-insinstructor-img">
                            <?php if( $settings['image1']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="become-instructor-content black-color">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <?php if($settings['button_text']): ?>
                                <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($settings['button_text']); ?></a>
                            <?php endif; ?>

                            <?php if($settings['social_title']): ?>
                                <div class="social">
                                    <div class="d-flex align-items-center">
                                        <span><?php echo esc_html($settings['social_title']); ?></span>
                                        <ul>
                                            <?php ellen_social_link(); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if( $settings['shape1']['url'] != '' ): ?>
                <div class="shape1">
                    <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape2']['url'] != '' ): ?>
                <div class="shape8">
                    <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape3']['url'] != '' ): ?>
                <div class="shape5">
                    <img src="<?php echo esc_url( $settings['shape3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape4']['url'] != '' ): ?>
                <div class="shape10">
                    <img src="<?php echo esc_url( $settings['shape4']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Become_Instructor_Two );