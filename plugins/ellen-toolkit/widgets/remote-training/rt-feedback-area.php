<?php
/**
 * Feedback Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Feedback_Area extends Widget_Base {

	public function get_name() {
        return 'FeedbackArea';
    }

	public function get_title() {
        return __( 'Feedback Area', 'ellen-toolkit' );
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

        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'ellen-toolkit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('What Our Learners say about Ellen', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1'         => esc_html__( 'h1', 'ellen-toolkit' ),
                    'h2'         => esc_html__( 'h2', 'ellen-toolkit' ),
                    'h3'         => esc_html__( 'h3', 'ellen-toolkit' ),
                    'h4'         => esc_html__( 'h4', 'ellen-toolkit' ),
                    'h5'         => esc_html__( 'h5', 'ellen-toolkit' ),
                    'h6'         => esc_html__( 'h6', 'ellen-toolkit' ),
                ],
                'default' => 'h2',
            ]
        );
        
        $this->add_control(
            'image', [
                'label' => __( 'Section Image', 'ellen-toolkit' ),
                'type' => Controls_Manager::MEDIA,
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
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore et mag na aliqua. Minim veniam, quis nostrud ullamco laboris nisi ut aliquip ex ea commodo conse quatt adipiscing dolore.', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'Ellen_Feedback_Area_items',
            [
                'label' => esc_html__('Feedback Item', 'ellen-toolkit'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [ 'name' => esc_html__(' Item #1', 'ellen-toolkit') ],

                ],
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
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-feedback-content .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .rt-feedback-content .title',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Feedback Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-single-feedback-box p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Feedback Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .rt-single-feedback-box p',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Name Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-single-feedback-box .client-info .info h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => __( 'Name Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .rt-single-feedback-box .client-info .info h3',
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-single-feedback-box .client-info .info span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => __( 'Designation Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .rt-single-feedback-box .client-info .info span',
            ]
        );


    $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        $this-> add_inline_editing_attributes('title','none');

        $items = $settings['Ellen_Feedback_Area_items'];
        ?>
            <div class="rt-feedback-area">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <div class="rt-feedback-content">
                                <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                    <?php echo wp_kses_post( $settings['title'] ); ?>
                                </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                
                                <div class="rt-feedback-slides owl-carousel owl-theme">
                                    <?php foreach ($items as $key => $value): ?>
                                        <div class="rt-single-feedback-box">
                                            <div class="client-info d-flex align-items-center">
                                                <?php if( $value['image']['url'] != '' ): ?>
                                                    <div class="quotes">
                                                        <img src="<?php echo esc_url( $value['image']['url'] ); ?>" alt="<?php echo esc_attr( $value['name'] ) ?>">
                                                    </div>
                                                <?php endif; ?>
                                            <div class="info">
                                                <h3><?php echo esc_html( $value['name'] ); ?></h3>
                                                <span><?php echo esc_html( $value['designation'] ); ?></span>
                                                </div>
                                            </div>
                                            <p><?php echo wp_kses_post( $value['feedback'] ); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="rt-feedback-image">
                                <?php if( $settings['image']['url'] != '' ): ?>
                                    <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Feedback_Area );