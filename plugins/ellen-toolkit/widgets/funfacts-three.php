<?php
/**
 * Funfacts Three Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Funfacts_Three extends Widget_Base {

	public function get_name() {
        return 'Ellen_Funfacts_Three';
    }

	public function get_title() {
        return __( 'Funfacts Three', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-counter';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'funfacts_section',
			[
				'label' => __( 'Funfacts Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


			$this->add_control(
				'content',
				[
					'label' => esc_html__( 'Left Content', 'ellen-toolkit' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => 'Transform your vision into reality with tailored business coaching',
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
					'default' => esc_html__('Student Enrolled', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'number_suffix', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Number Suffix', 'ellen-toolkit' ),
					'default' => esc_html__('+', 'ellen-toolkit'),
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
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'background',
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .bc-fun-facts-inner',
				]
			);

            $this->add_control(
                'content_color',
                [
                    'label' => __( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-fun-facts-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-fun-facts-content p',
                ]
            );
            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'Number Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-funfacts-box h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'label' => esc_html__( 'Number Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-funfacts-box h3',
                ]
            );

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .bc-funfacts-box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-funfacts-box p',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
		?>
		<div class="bc-fun-facts-area">
            <div class="container-fluid">
                <div class="bc-fun-facts-inner">
                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <div class="bc-fun-facts-content">
                                    <p><?php echo wp_kses_post($settings['content']); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <div class="d-lg-flex d-md-flex justify-content-between">
									<?php foreach( $settings['items'] as $item ): ?>
										<div class="custom-grid">
											<div class="bc-funfacts-box">
												<h3>
													<span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="plus"><?php echo esc_html( $item['number_suffix'] ); ?></span>
												</h3>
												<p><?php echo esc_html( $item['title'] ); ?></p>
											</div>
										</div>
									<?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}
}
Plugin::instance()->widgets_manager->register( new Ellen_Funfacts_Three );