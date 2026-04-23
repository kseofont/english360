<?php
/**
 * Feedback Three Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Feedback_Three extends Widget_Base {

	public function get_name() {
        return 'FeedbackThree';
    }

	public function get_title() {
        return __( 'Feedback Three', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'image', [
                'label' => __( 'Image', 'ellen-toolkit' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $repeater->add_control(
            'name', [
                'label' => esc_html__('Name', 'ellen-toolkit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Olivar Lucy', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'designation', [
                'label' => esc_html__('Designation', 'ellen-toolkit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Designer', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'feedback', [
                'label' => esc_html__('Feedback Content', 'ellen-toolkit'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '<strong>Ellen</strong> coaching transformed not just my business, but my mindset as well. Her personalized approach gave me the clarity and direction I needed to scale my operations efficiently. Thanks to her guidance.',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'ellen_feedback_items',
            [
                'label' => esc_html__('Feedback Item', 'ellen-toolkit'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [ 'name' => esc_html__(' Item #1', 'ellen-toolkit') ],

                ],
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Feedback Shape Image', 'ellen-toolkit' ),
                'type' => Controls_Manager::MEDIA,
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
            'content_color',
            [
                'label' => esc_html__( 'Feedback Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .la-testimonials-card p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Feedback Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .la-testimonials-card p',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Name Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .la-testimonials-card .info .title h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => __( 'Name Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .la-testimonials-card .info .title h3',
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .la-testimonials-card .info .title span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => __( 'Designation Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .la-testimonials-card .info .title span',
            ]
        );
    $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        $items = $settings['ellen_feedback_items'];
        ?>
        <div class="container">
            <div class="la-testimonials-slides owl-carousel owl-theme">
                <?php foreach ($items as $key => $value): ?>
                    <div class="la-testimonials-card">
                        <?php if($settings['icon']['url']): ?>
                            <div class="icon">
                                <img src="<?php echo esc_url($settings['icon']['url']); ?>" alt="quote">
                            </div>
                        <?php endif; ?>
                        <p><?php echo wp_kses_post( $value['feedback'] ); ?></p>
                        <div class="info">
                            <?php if( $value['image']['url'] != '' ): ?>
                                <div class="user">
                                    <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                </div>
                            <?php endif; ?>

                            <div class="title">
                                <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                <span><?php echo esc_html( $value['designation'] ); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_Feedback_Three );