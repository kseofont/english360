<?php
/**
 * Partner Logo Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Partner extends Widget_Base {

	public function get_name() {
        return 'Partner_Logo2';
    }

	public function get_title() {
        return __( 'Partner Logos Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-logo';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'partner_section',
			[
				'label' => __( 'Partner Logo Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'logo', [
                    'type'    => Controls_Manager::MEDIA,
                    'label'   => esc_html__( 'Logo', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
                'logo_link', [
                    'type'    => Controls_Manager::TEXT,
                    'label'   => esc_html__( 'Logo Link', 'ellen-toolkit' ),
                ]
            );
            $this->add_control(
                'logos',
                [
                    'label'   => esc_html__( 'Add Partner Logo', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'partner_styling',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control( 'section_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .partner-wrap-inner-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .partner-wrap-inner-box' => 'background-color: {{VALUE}}',
					],
				]
			);


        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="partner-wrap-area">
            <div class="container">
                <div class="partner-wrap-inner-box pt-100 pb-75">
                    <div class="row align-items-center justify-content-center">
						<?php foreach( $settings['logos'] as $item ): ?>
                            <div class="col-lg-2 col-6 col-sm-4 col-md-4">
                                <div class="partner-wrap-card">
                                    <a href="<?php echo esc_url($item['logo_link']); ?>" class="d-inline-block" target="_blank">
                                        <?php if( $item['logo']['url'] != '' ): ?>
                                            <?php echo wp_get_attachment_image( $item['logo']['id'], 'full' ); ?>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Partner );