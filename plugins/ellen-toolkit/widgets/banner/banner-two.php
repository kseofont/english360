<?php
/**
 * Banner Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Banner_Two extends Widget_Base {

	public function get_name() {
        return 'Ellen_Banner_Two_One';
    }

	public function get_title() {
        return esc_html__( 'Banner Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Banner_Two_Area',
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

            $repeater = new Repeater();
            $repeater->add_control(
                'number', [
					'type'    => Controls_Manager::NUMBER,
					'label'   => esc_html__( 'Ending Number', 'ellen-toolkit' ),
					'default' => 1926,
                ]
            );
            $repeater->add_control(
                'title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('COURSES', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'number_suffix', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Number Suffix', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
				]
            );
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Counter Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
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
                    '{{WRAPPER}} .banner-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'Banner Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-area' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-area .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .banner-area .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .banner-content p',
                ]
            );

            $this->add_control(
				'search_btn_bg',
				[
					'label' => esc_html__( 'Search Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-content .search-box button' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_bg_hover',
				[
					'label' => esc_html__( 'Search Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-content .search-box button:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'FunFacts Number Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .banner-content .funfacts .single-funfacts-box h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'label' => esc_html__( 'FunFacts Number Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .banner-content .funfacts .single-funfacts-box h3',
                ]
            );

            $this->add_control(
				'funfacts_title_color',
				[
					'label' => __( 'FunFacts Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-content .funfacts .single-funfacts-box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'funfacts_title_typography',
                    'label' => esc_html__( 'FunFacts Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .banner-content .funfacts .single-funfacts-box p',
                ]
            );

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .banner-content .funfacts .single-funfacts-box i' => 'color: {{VALUE}}',
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
        <div class="banner-area">
            <div class="container">
                <div class="banner-content">
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

                    <?php if($settings['items']): ?>
                        <div class="funfacts">
                            <div class="row justify-content-center">
                                <?php foreach( $settings['items'] as $item ): ?>
                                    <div class="col-lg-3 col-md-4 col-6 col-sm-4">
                                        <div class="single-funfacts-box">
                                            <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                                            <h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
                                            <p><?php echo esc_html( $item['title'] ); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if( $settings['image1']['url'] != '' ): ?>
                <div class="banner-image">
                    <img src="<?php echo esc_url( $settings['image1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>

            <?php if( $settings['shape1']['url'] != '' ): ?>
                <div class="shape2">
                    <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape2']['url'] != '' ): ?>
                <div class="shape5">
                    <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape3']['url'] != '' ): ?>
                <div class="shape9">
                    <img src="<?php echo esc_url( $settings['shape3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                </div>
            <?php endif; ?>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Banner_Two );