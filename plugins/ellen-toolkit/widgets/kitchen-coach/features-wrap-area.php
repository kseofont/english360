<?php
/**
 * Feature Wrap Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Features_Wrap extends Widget_Base {

	public function get_name() {
        return 'Ellen_Features_Wrap';
    }

	public function get_title() {
        return __( 'Feature Wrap', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-star-o';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'features_inner_section',
			[
				'label' => __( 'Features Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Choose Columns', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'col-lg-12 col-sm-12'   => esc_html__( '1', 'ellen-toolkit' ),
                        'col-lg-6 col-sm-6'   	=> esc_html__( '2', 'ellen-toolkit' ),
                        'col-lg-3 col-sm-6'   	=> esc_html__( '3', 'ellen-toolkit' ),
                        'col-lg-4 col-sm-6'   	=> esc_html__( '4', 'ellen-toolkit' ),
                    ],
                    'default' => 'col-lg-3 col-sm-6',
                ]
            );

			$repeater = new Repeater();

            $repeater->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICONS,
                    'label_block' => true,
				]
            );

            $repeater->add_control(
                'title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('Meal Planning', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'content', [
					'type'    => Controls_Manager::TEXTAREA,
					'label'   => esc_html__( 'Content', 'ellen-toolkit' ),
					'default' => esc_html__('This project will guide you through how to set up your kitchen and pantry to ensure you are set up for success', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'features_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'bg_color',
				[
					'label' => __( 'Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .features-wrap-area' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .features-wrap-card h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .features-wrap-card h3',
                ]
            );

            $this->add_control(
				'content_color',
				[
					'label' => __( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .features-wrap-card p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .features-wrap-card p',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <?php foreach( $settings['items'] as $item ): ?>
                    <div class="<?php echo esc_attr($settings['columns']); ?>">
                        <div class="features-wrap-card">
                            <div class="f-icon">
                                <?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
                            <h3><?php echo esc_html( $item['title'] ); ?></h3>
                            <p><?php echo wp_kses_post( $item['content'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Features_Wrap );