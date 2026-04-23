<?php
/**
 * Banner Eight Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Banner_Eight extends Widget_Base {

	public function get_name() {
        return 'Ellen_Banner_Eight';
    }

	public function get_title() {
        return esc_html__( 'Banner Eight', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Banner_Eight_Area',
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
                'default'     => esc_html__( 'Find Simple & Effective Training Courses Now', 'ellen-toolkit' ),
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
					'default' 	=> esc_html__('<b>Ellen</b> is a Global training provider based across the UK that specialises in accredited and bespoke training courses. Flexible easy to access learning opportunities can bring a significant change.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Search Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Search Now', 'ellen-toolkit'),
                    'label_block' => true,
				]
            );

            $this->add_control(
				'button_icon',
				[
					'label' => esc_html__( 'Search Button Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
				]
            );

            $this->add_control(
				'placeholder_text',
				[
					'label' 	=> esc_html__( 'Course Search Placeholder', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('What do you want to learn today?', 'ellen-toolkit'),
				]
			);

            $this->add_control(
                'user_images',
                [
                    'label' => esc_html__( 'Support User Images', 'ellen-toolkit' ),
                    'type' => Controls_Manager::GALLERY,
                ]
            );

            $this->add_control(
				'support_description',
				[
					'label' 	=> esc_html__( 'Support Description', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::WYSIWYG,
					'default' 	=> esc_html__('500K+ People already trusted us.', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'banner_button_text',
				[
					'label' 	=> esc_html__( 'Banner Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('View Reviews', 'ellen-toolkit'),
				]
            );

            $this->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Banner Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                ]
            );

            $this->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Banner Button Link Page', 'ellen-toolkit' ),
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

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'banner_bg',
                    'label' => __( 'Banner Background Image', 'ellen-toolkit' ),
                    'types' => [ 'classic' ],
                    'selector' => '{{WRAPPER}} .remote-training-banner-area',
                ]
            );

            $this->add_control(
                'image1',
                [
                    'label'		=> esc_html__('Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'image2',
                [
                    'label'		=> esc_html__('Image Two', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'image3',
                [
                    'label'		=> esc_html__('Image Three', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'youtube_video',
                [
                    'label'		=> esc_html__('YouTube Popup Video Link', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
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
                'shape_url',
                [
                    'label'		=> esc_html__('Shape Image Link', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'shape2',
                    'label' => __( 'Shape Image Two', 'ellen-toolkit' ),
                    'types' => [ 'classic' ],
                    'selector' => '{{WRAPPER}} .remote-training-banner-content h1 b::before',
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
                    '{{WRAPPER}} .remote-training-banner-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'Banner Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-area' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .remote-training-banner-content .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .remote-training-banner-content p',
                ]
            );

            $this->add_control(
				'search_btn_bg',
				[
					'label' => esc_html__( 'Search Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content .search-box button' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_bg_hover',
				[
					'label' => esc_html__( 'Search Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content .search-box button:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'support_content_color',
				[
					'label' => esc_html__( 'Support Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content .support-box .text p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'support_content_typography',
                    'label' => esc_html__( 'Support Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .remote-training-banner-content .support-box .text p',
                ]
            );

            $this->add_control(
				'banner_btn_color',
				[
					'label' => esc_html__( 'Banner Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .remote-training-banner-content .support-box .text p a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_btn_typography',
                    'label' => esc_html__( 'Banner Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .remote-training-banner-content .support-box .text p a',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

		// Search Button Icon
        $search_btn_icon = $settings['button_icon'];

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

        $post_type 	= '';
        if ( function_exists('tutor') ) {
            $post_type = 'courses';
        }elseif( class_exists('LearnPress') ){
            $post_type = 'lp_course';
        }

        ?>

        <div class="remote-training-banner-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="remote-training-banner-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <?php if($settings['placeholder_text'] != '' || $settings['button_text'] != ''): ?>
                                <form class="search-box" method="get" action="<?php echo site_url( '/' ); ?>">
                                    <input type="text" name="s" class="input-search" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>">
                                    <input type="hidden" value="course" name="ref" />
                                    <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>">

                                    <?php if($settings['button_text']): ?>
                                        <button type="submit">
                                            <?php if($settings['button_icon']): ?>
                                                <i class="<?php echo esc_attr($settings['button_icon']); ?>"></i>
                                            <?php endif; ?>
                                            <?php echo esc_html($settings['button_text']); ?>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>

                            <div class="support-box">
                                <div class="d-flex align-items-center">
                                    <div class="images d-flex align-items-center">
                                        <?php foreach ( $settings['user_images'] as $image ) { ?>
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                        <?php } ?>
                                    </div>
                                    <div class="text">
                                        <p>
                                            <?php echo wp_kses_post($settings['support_description']); ?>
                                            <?php if($settings['banner_button_text']): ?>
                                                <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>> <?php echo esc_html($settings['banner_button_text']); ?></a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="remote-training-banner-image">
                            <?php if( $settings['image1']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>

                            <div class="banner-video-1">
                                <div class="video">
                                    <?php if( $settings['image2']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $settings['image2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="banner-video-2">
                                <div class="video">
                                    <?php if( $settings['image3']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $settings['image3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                    <?php endif; ?>                                
                                </div>
                                <?php if($settings['youtube_video']): ?>
                                    <a href="<?php echo esc_url($settings['youtube_video']); ?>" class="popup-video">
                                        <i class='bx bx-play'></i>
                                    </a>
                                <?php endif; ?>   
                            </div>
                            <div class="banner-wrap-shape">
                                <?php if($settings['shape_url']): ?>
                                    <a href="<?php echo esc_url($settings['shape_url']); ?>">
                                <?php endif; ?>   
                                    <?php if( $settings['shape1']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                    <?php endif; ?> 
                                <?php if($settings['shape_url']): ?>
                                    </a>
                                <?php endif; ?>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Banner_Eight );