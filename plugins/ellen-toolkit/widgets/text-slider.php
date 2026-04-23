<?php
/**
 * Text Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Text_Slider extends Widget_Base {

	public function get_name() {
        return 'Ellen_Text_Slider';
    }

	public function get_title() {
        return __( 'TextSlider', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-slider-push';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'text_slider_section',
			[
				'label' => __( 'Text Slider Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
			$repeater = new Repeater();
            $repeater->add_control(
                'title', [
					'type'    => Controls_Manager::TEXTAREA,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => 'Best <span>Online</span> Art <span>Learning</span> Platform',
                ]
            );
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Slider Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'Text Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .oa-animation-content h1' => 'color: {{VALUE}}',
                    ],
                ]
            );

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => esc_html__( 'Text Typography 1', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .oa-animation-content h1',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text2_typography',
                    'label' => esc_html__( 'Text Typography 2', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .oa-animation-content h1 span',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
         <div class="container-fluid">
            <div class="oa-feedback-animation-slides owl-carousel owl-theme">
				<?php foreach( $settings['items'] as $item ): ?>
                    <div class="oa-animation-content">
                        <h1><?php echo wp_kses_post( $item['title'] ); ?></h1>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
        <svg style="display:none;">
            <defs>
                <filter id="stroke-text">
                    <feMorphology radius="1" operator="dilate"></feMorphology>
                    <feComposite operator="xor" in="SourceGraphic"/>
                </filter>
            </defs>
        </svg>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Text_Slider );