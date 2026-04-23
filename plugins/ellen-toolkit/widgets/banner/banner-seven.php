<?php
/**
 * Banner Seven Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Banner_Seven extends Widget_Base {

	public function get_name() {
        return 'Ellen_Banner_Seven';
    }

	public function get_title() {
        return esc_html__( 'Banner Seven', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Banner_Seven_Area',
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
                'default' => 'h1',
            ] );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Flexible easy to access learning opportunities can bring a significant change in how individuals prefer to learn! The Ellen can offer you to enjoy the beauty of eLearning!', 'ellen-toolkit'),
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
                    'label'		=> esc_html__('Image One', 'ellen-toolkit'),
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
                    '{{WRAPPER}} .dark-home-banner-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'Banner Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .dark-home-banner-area' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .dark-home-banner-area .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .dark-home-banner-area .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .dark-home-banner-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .dark-home-banner-content p',
                ]
            );

            $this->add_control(
				'search_btn_bg',
				[
					'label' => esc_html__( 'Search Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .dark-home-banner-content .search-box button' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_bg_hover',
				[
					'label' => esc_html__( 'Search Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .dark-home-banner-content .search-box button:hover' => 'background-color: {{VALUE}}',
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

		// Search Button Icon
        $search_btn_icon = $settings['button_icon'];

        $post_type 	= '';
        if ( function_exists('tutor') ) {
            $post_type = 'courses';
        }elseif( class_exists('LearnPress') ){
            $post_type = 'lp_course';
        }
        ?>
         <div class="dark-home-banner-area dark-home-with-seven">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-md-12">
                            <div class="dark-home-banner-content">
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
                                                <?php echo esc_html($settings['button_text']); ?>
                                            </button>
                                        <?php endif; ?>
                                        <div class="icon">
                                            <?php if($settings['button_icon']): ?>
                                                <i class="<?php echo esc_attr($settings['button_icon']); ?>"></i>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="dark-home-banner-image">
                                <?php if( $settings['image1']['url'] != '' ): ?>
                                    <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if( $settings['shape1']['url'] != '' ): ?>
                    <div class="dark-home-banner-shape-1">
                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape2']['url'] != '' ): ?>
                    <div class="dark-home-banner-shape-2">
                        <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape3']['url'] != '' ): ?>
                    <div class="dark-home-banner-shape-3">
                        <img src="<?php echo esc_url( $settings['shape3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Banner_Seven );