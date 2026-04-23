<?php
/**
 * Footer Newsletter Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Footer_Newsletter extends Widget_Base {

	public function get_name() {
        return 'Ellen_NewsletterFooter';
    }

	public function get_title() {
        return __( 'Footer Newsletter', 'ellen-toolkit' );
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

            $this->add_control(
                'choose_style',
                [
                    'label' => __( 'Choose Style', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Style - 1 (University Demo Fonts Style) ', 'ellen-toolkit' ),
                        '2'   => __( 'Choose Style - 2 (School & College Demo Fonts Style)', 'ellen-toolkit' ),
                        '3'   => __( 'Choose Style - 3 (Health, Wellness & Fitness Demo Fonts Style)', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'footer_logo',
                [
                    'label' => __( 'Footer Logo', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'logomax_width',
                [
                    'label' => __( 'Max Width', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'rem' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .footer-wrap-widget .logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'bg_logo',
                [
                    'label' => __( 'Background Logo', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'content', [
                    'label' => __( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'We are Ellen, Love to take challenge for the bright future.' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sb_content', [
                    'label' => __( 'Subscribe Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'SUBSCRIBE NEWSLETTER' , 'ellen-toolkit' ),
                    'label_block' => true,
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
                'placeholder_text', [
                    'label' => __( 'Email Placeholder Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Enter your email address' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'button_icon', [
                    'label' => __( 'Button Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'bx bx-send' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        // Style Settings
        $this->start_controls_section(
			'Ellen_Newsletter_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .footer-wrap-widget p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .footer-wrap-widget p',
                ]
            );

            $this->add_control(
                'sub_content_color',
                [
                    'label' => esc_html__( 'Subscribe Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .footer-wrap-widget span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sub_content_typography',
                    'label' => __( 'Subscribe Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .footer-wrap-widget span',
                ]
            );

            $this->add_control(
				'fr_bg_color',
				[
					'label' => esc_html__( 'Form Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .newsletter-form .form-control' => 'background-color: {{VALUE}}',
					],
				]
            );

            $this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .newsletter-form button' => 'color: {{VALUE}}',
					],
				]
            );
           
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'label' => __( 'Button Text Typography', 'ellen-toolkit' ),
                    'name' => 'typography_button',
                    'selector' => '{{WRAPPER}} .footer-wrap-widget .newsletter-form button',
                ]
            );
          
            $this->add_control(
				'hover_button_color',
				[
					'label' => esc_html__( 'Hover Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .newsletter-form button:hover' => 'color: {{VALUE}}',
					],
				]
            );

            $this->add_control(
				'button_bg_color',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .newsletter-form button' => 'background-color: {{VALUE}}',
					],
				]
            );

            $this->add_control(
				'button_bg_h_color',
				[
					'label' => esc_html__( 'Button Background Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .newsletter-form button:hover' => 'background-color: {{VALUE}}',
					],
				]
            );


        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();


        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <div class="footer-wrap-widget <?php if($settings['choose_style']==1): ?> university-home  <?php elseif($settings['choose_style']==2): ?>  school-college-home <?php elseif($settings['choose_style']==3): ?> health-wellness-fitness-home <?php endif; ?>">
            <?php if( !empty( $settings['footer_logo']['url'] ) ){ ?>
                <a href="<?php echo esc_url( home_url( '/' ) );?>" class="logo d-inline-block">
                    <img src="<?php echo esc_url( $settings['footer_logo']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                </a>
            <?php } ?>

            <?php if( $settings['content'] != '' ): ?>
                <p><?php echo wp_kses_post( $settings['content'] ); ?></p>
            <?php endif; ?>
                               
            <?php if( $settings['sb_content'] != '' ): ?>
                <span><?php echo wp_kses_post( $settings['sb_content'] ); ?></span>
            <?php endif; ?>
            <form class="newsletter-form mailchimp" data-bs-toggle="validator">
                <input type="email" class="form-control memail" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>">
                <?php if( $settings['button_icon'] != '' ): ?>
                    <button type="submit">
                        <i class='<?php echo esc_attr( $settings['button_icon'] ); ?>'></i>
                    </button>
                <?php endif; ?>
                <div id="validator-newsletter" class="form-result"></div>
            </form>
            <p class="mchimp-errmessage" style="display: none;"></p>
            <p class="mchimp-sucmessage" style="display: none;"></p>
            <?php if( !empty( $settings['bg_logo']['url'] ) ){ ?>
                <div class="award-wrap">
                    <img src="<?php echo esc_url( $settings['bg_logo']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                </div>
            <?php } ?>
        </div>

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

Plugin::instance()->widgets_manager->register_widget_type( new Footer_Newsletter );