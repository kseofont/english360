<?php
/**
 * Newsletter Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Newsletter extends Widget_Base {

	public function get_name() {
        return 'Newsletter_Health';
    }

	public function get_title() {
        return __( 'Health Newsletter', 'ellen-toolkit' );
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
                        '1'   => __( 'Choose with Mailchimp', 'ellen-toolkit' ),
                        '2'   => __( 'Choose with Contact Form 7', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'bg_img',
                [
                    'label'		=> esc_html__('Background Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shortcode',
                [
                    'label'   => __( 'Form Shortcode', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'choose_style' => ['2'],
                    ]
                   
                ]
            );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('NEWSLETTER', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title', [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Subscribe Newsletter' , 'ellen-toolkit' ),
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
                'action_url', [
                    'label' => esc_html__( 'Action URL', 'ellen-toolkit' ),
                    'description' => __( 'Enter here your MailChimp action URL. <a href="https://docs.envytheme.com/docs/ellen-theme-documentation/tips-guides-troubleshoots/get-mailchimp-newsletter-form-action-url/" target="_blank"> How to </a>', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'choose_style' => ['1'],
                    ],
                ]
            );

            $this->add_control(
                'placeholder_text', [
                    'label' => __( 'Email Placeholder Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Enter your email' , 'ellen-toolkit' ),
                    'label_block' => true,
                    'condition' => [
                        'choose_style' => ['1'],
                    ],
                ]
            );

            $this->add_control(
                'button_text', [
                    'label' => __( 'Button text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Subscribe Now' , 'ellen-toolkit' ),
                    'label_block' => true,
                    'condition' => [
                        'choose_style' => ['1'],
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Settings
        $this->start_controls_section(
			'newsletter_health_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-overview-item .content .sub.wrap2' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-overview-item .content .sub.wrap2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-overview-item .content .sub.wrap2',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-overview-item .content .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-overview-item .content .title-tgas',
                ]
            );

            $this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-overview-item .content .newsletter-form .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
            );
            $this->add_control(
				'button_bg',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-overview-item .content .newsletter-form .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'label' => __( 'Button Text Typography', 'ellen-toolkit' ),
                    'name' => 'typography_button',
                    'selector' => '{{WRAPPER}} .hwf-overview-item .content .newsletter-form .optional-btn',
                ]
            );
           
            $this->add_control(
				'hover_button_bg',
				[
					'label' => esc_html__( 'Hover Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-overview-item .content .newsletter-form .optional-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
            );
            $this->add_control(
				'hover_button_color',
				[
					'label' => esc_html__( 'Hover Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-overview-item .content .newsletter-form .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
            );
        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';


        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

            

        <?php if($settings['choose_style']==1): ?>

            <div class="hwf-overview-item health-wellness-fitness-home">
                <?php if( !empty( $settings['bg_img']['url'] ) ){ ?>
                    <img src="<?php echo esc_url( $settings['bg_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                <?php } ?>
                <div class="content">
                    <?php if( $settings['top_title']): ?>
                        <span class="sub wrap2"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                    <?php endif; ?>
                    <?php if( $settings['title']): ?>
                        <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                    <?php endif; ?>
                    <?php if( $settings['button_text'] && $settings['placeholder_text'] != '' ): ?>
                        <form class="newsletter-form mailchimp">
                            <input type="email" class="form-control memail" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>">
                            <?php if( $settings['button_text'] != '' ): ?>
                                <button type="submit" class="optional-btn extra-radius"><?php echo esc_html( $settings['button_text'] ); ?></button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                    <p class="mchimp-errmessage" style="display: none;"></p>
                    <p class="mchimp-sucmessage" style="display: none;"></p>
                </div>
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
           
            

        <?php elseif($settings['choose_style']==2): ?>

            <div class="hwf-overview-item health-wellness-fitness-home">
                <?php if( !empty( $settings['bg_img']['url'] ) ){ ?>
                    <img src="<?php echo esc_url( $settings['bg_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                <?php } ?>
                <div class="content">
                    <?php if( $settings['top_title']): ?>
                        <span class="sub wrap2"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                    <?php endif; ?>
                    <?php if( $settings['title']): ?>
                        <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                    <?php endif; ?>
                    <?php if( $settings['shortcode'] ): ?>
                        <div class="newsletter-form">
                            <?php echo do_shortcode( $settings['shortcode'] ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>
    <?php
	}


}

Plugin::instance()->widgets_manager->register_widget_type( new Health_Newsletter );