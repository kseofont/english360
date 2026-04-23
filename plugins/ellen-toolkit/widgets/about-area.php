<?php
/**
 * About Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_About_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_About_Area';
    }

	public function get_title() {
        return esc_html__( 'About Area', 'ellen-toolkit' );
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

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'We share knowledge with the world', 'ellen-toolkit' ),
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
					'default' 	=> esc_html__('Whether you want to learn or to share what you know, you’ve come to the right place. As a global destination for online learning, we connect people through knowledge.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);
            $this->add_control(
                'bg',
                [
                    'label'		=> esc_html__('Background Image', 'ellen-toolkit'),
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
                'label'      => esc_html__( 'About Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .about-area.bg-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'banner_bg',
				[
					'label' => esc_html__( 'About Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .about-area.bg-image .about-title' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .about-area.bg-image .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .about-area.bg-image .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .about-area.bg-image .about-title p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .about-area.bg-image .about-title p',
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');
        ?>
        <div class="about-area bg-image" style="background-image:url(<?php echo esc_url( $settings['bg']['url'] ); ?>);">
            <div class="container">
                <div class="about-title">
                    <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                        <?php echo wp_kses_post( $settings['title'] ); ?>
                    </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                    <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_About_Area );