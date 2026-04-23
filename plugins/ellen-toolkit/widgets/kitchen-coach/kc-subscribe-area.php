<?php
/**
 * Newsletter Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Newsletter extends Widget_Base {

	public function get_name() {
        return 'Ellen_Newsletter';
    }

	public function get_title() {
        return __( 'Newsletter', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-email-field';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

    public function get_keywords() {
        return [ 'mailchimp', 'form', 'newsletter' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Newsletter',
			[
				'label' => __( 'Ellen Newsletter', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'style', [
                'label'   => esc_html__( 'Section Style', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '1'   => 'Style One',
                    '2'   => 'Style Two',
                ],
                'default' => '1',
            ] );

            $this->add_group_control(
               Group_Control_Background::get_type(),
                [
                    'name' => 'background',
                    'label' => __( 'Background', 'ellen-toolkit' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .kc-subscribe-inner-box, {{WRAPPER}} .vc-subscribe-inner-box',
                ]
            );

            $this->add_control(
                'action_url', [
                    'label' => esc_html__( 'Action URL', 'ellen-toolkit' ),
                    'description' => __( 'Enter here your MailChimp action URL. <a href="https://docs.envytheme.com/docs/ellen-theme-documentation/tips-guides-troubleshoots/get-mailchimp-newsletter-form-action-url/" target="_blank"> How to </a>', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title', [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'There a better way to get healthy subscribe to my newsletter' , 'ellen-toolkit' ),
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
                    'default' => 'h3',
                ]
            );

            $this->add_control(
                'content', [
                    'label' => __( 'Description', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Explore all of our courses and pick your suitable ones to enroll and start learning with us!' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'placeholder_text', [
                    'label' => __( 'Email Placeholder Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Enter your email address' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'button_text', [
                    'label' => __( 'Button text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Subscribe Now' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'shape1',
                [
                    'label'		=> esc_html__('Section Shape Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape2',
                [
                    'label'		=> esc_html__('Section Shape Image Two(Style 1)', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
			'newsletter_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_responsive_control( 'newsletter_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .kc-subscribe-inner-box, {{WRAPPER}} .vc-subscribe-inner-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-subscribe-content .title, {{WRAPPER}} .vc-subscribe-content .title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .kc-subscribe-content .title, {{WRAPPER}} .vc-subscribe-content .title',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-subscribe-content p, {{WRAPPER}} .vc-subscribe-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .kc-subscribe-content p, {{WRAPPER}} .vc-subscribe-content p',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .default-btn',
                ]
            );
            
            $this->add_control(
                'btn_color',
                [
                    'label' => __( 'Button Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_border_color',
                [
                    'label' => __( 'Button Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_color',
                [
                    'label' => __( 'Button Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            
            $this->add_control(
                'btn_hover_border_color',
                [
                    'label' => __( 'Button Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_hover_color',
                [
                    'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_hover_color',
                [
                    'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'color: {{VALUE}}',
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

        if($settings['style'] == '2'): ?>
            <div class="vc-subscribe-area">
                <div class="container">
                    <div class="vc-subscribe-inner-box ptb-100">
                        <div class="vc-subscribe-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            
                            <p><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <form class="mailchimp newsletter-form" method="post">
                                <input type="email" class="input-newsletter memail" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" name="EMAIL" required>
                                <?php if( $settings['button_text'] != '' ): ?>
                                    <button type="submit" class="default-btn"><?php echo esc_html( $settings['button_text'] ); ?></button>
                                <?php endif; ?>
                                <p class="mchimp-errmessage" style="display: none;"></p>
                                <p class="mchimp-sucmessage" style="display: none;"></p>
                            </form>
                        </div>

                        <div class="vc-subscribe-shape">
                            <?php if( $settings['shape1']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>                        
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="kc-subscribe-area">
                <div class="container">
                    <div class="kc-subscribe-inner-box ptb-100">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-7 col-md-12">
                                <div class="kc-subscribe-content">
                                    <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                        <?php echo wp_kses_post( $settings['title'] ); ?>
                                    </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                    
                                    <p><?php echo wp_kses_post( $settings['content'] ); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <form class="mailchimp newsletter-form" method="post">
                                    <input type="email" class="input-newsletter memail" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" name="EMAIL" required>
                                    <?php if( $settings['button_text'] != '' ): ?>
                                        <button type="submit" class="default-btn"><?php echo esc_html( $settings['button_text'] ); ?></button>
                                    <?php endif; ?>
                                <p class="mchimp-errmessage" style="display: none;"></p>
                                <p class="mchimp-sucmessage" style="display: none;"></p>
                                </form>
                            </div>
                        </div>

                        <div class="kc-subscribe-shape-1">
                            <?php if( $settings['shape1']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="kc-subscribe-shape-2">
                            <?php if( $settings['shape2']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <script>
            ;(function($){
                "use strict";
                $(document).ready(function () {
                    // MAILCHIMP
                    if ($(".mailchimp").length > 0) {
                        $(".mailchimp").ajaxChimp({
                            callback: mailchimpCallback,
                            url: "<?php echo esc_js($settings['action_url']) ?>"
                        });
                    }
                    if ($(".mailchimp_two").length > 0) {
                        $(".mailchimp_two").ajaxChimp({
                            callback: mailchimpCallback,
                            url: "<?php echo esc_js($settings['action_url']) ?>" //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
                        });
                    }
                    $(".memail").on("focus", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("keydown", function () {
                        $(".mchimp-errmessage").fadeOut();
                        $(".mchimp-sucmessage").fadeOut();
                    });
                    $(".memail").on("click", function () {
                        $(".memail").val("");
                    });

                    function mailchimpCallback(resp) {
                        if (resp.result === "success") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                            $(".mchimp-sucmessage").fadeOut(500);
                        } else if (resp.result === "error") {
                            $(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
                        }
                    }
                });
            })(jQuery)
        </script>
    <?php
	}


}

Plugin::instance()->widgets_manager->register_widget_type( new Ellen_Newsletter );