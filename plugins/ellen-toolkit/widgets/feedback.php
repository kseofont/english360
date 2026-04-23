<?php
/**
 * Feedback Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Feedback extends Widget_Base {

	public function get_name() {
        return 'Feedback';
    }

	public function get_title() {
        return __( 'Feedback', 'ellen-toolkit' );
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

        $this->add_control( 'style', [
            'label'   => esc_html__( 'Style', 'ellen-toolkit' ),
            'type'    => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => [
                '1'   => 'Style One',
                '2'   => 'Style Two(With Slider)',
                '3'   => 'Style Three(With Slider)',
                '4'   => 'Style Four',
            ],
            'default' => '1',
        ] );

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
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore et mag na aliqua. Minim veniam, quis nostrud ullamco laboris nisi ut aliquip ex ea commodo conse quatt adipiscing dolore.', 'ellen-toolkit'),
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
                    '{{WRAPPER}} .single-feedback-box p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Feedback Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .single-feedback-box p',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Name Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-feedback-box .client-info .info h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => __( 'Name Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .single-feedback-box .client-info .info h3',
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-feedback-box .client-info .info span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => __( 'Designation Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .single-feedback-box .client-info .info span',
            ]
        );


    $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        $items = $settings['ellen_feedback_items'];
        if($settings['icon']['url']): ?>
            <style>.single-feedback-box::before{background-image: url(<?php echo esc_url($settings['icon']['url']); ?>);}</style>
        <?php  endif; ?>

        <?php if($settings['style'] == '1'): ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach ($items as $key => $value): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-feedback-box">
                                <p><?php echo esc_html( $value['feedback'] ); ?></p>
                                <div class="client-info d-flex align-items-center">
                                    <?php if( $value['image']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                    <?php endif; ?>
                                    <div class="info">
                                        <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                        <span><?php echo esc_html( $value['designation'] ); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif($settings['style'] == '2'): ?>
            <div class="container">
                <div class="feedback-slides owl-carousel owl-theme">
                    <?php foreach ($items as $key => $value): ?>
                            <div class="single-feedback-box">
                            <p><?php echo esc_html( $value['feedback'] ); ?></p>
                            <div class="client-info d-flex align-items-center">
                                <?php if( $value['image']['url'] != '' ): ?>
                                    <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                <?php endif; ?>
                                <div class="info">
                                    <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                    <span><?php echo esc_html( $value['designation'] ); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif($settings['style'] == '3'): ?>
            <div class="container">
                <div class="feedback-slides-with-owl-dots owl-carousel owl-them">
                    <?php foreach ($items as $key => $value): ?>
                            <div class="single-feedback-box">
                            <p><?php echo esc_html( $value['feedback'] ); ?></p>
                            <div class="client-info d-flex align-items-center">
                                <?php if( $value['image']['url'] != '' ): ?>
                                    <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                <?php endif; ?>
                                <div class="info">
                                    <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                    <span><?php echo esc_html( $value['designation'] ); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif($settings['style'] == '4'): ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php $count = 1; foreach ($items as $key => $value): ?>
                        <?php if($count == 1 || $count == 2): ?>
                            <div class="col-lg-6 col-md-6">
                        <?php else: ?>
                            <div class="col-lg-4 col-md-6">
                        <?php endif; ?>
                            <div class="single-feedback-box">
                                <p><?php echo esc_html( $value['feedback'] ); ?></p>
                                <div class="client-info d-flex align-items-center">
                                    <?php if( $value['image']['url'] != '' ): ?>
                                        <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                    <?php endif; ?>
                                    <div class="info">
                                        <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                        <span><?php echo esc_html( $value['designation'] ); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $count++; endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Feedback );