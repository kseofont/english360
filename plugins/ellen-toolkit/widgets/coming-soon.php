<?php
/**
 * Coming Soon Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Coming_Soon extends Widget_Base {

	public function get_name() {
        return 'Ellen_Coming_Soon';
    }

	public function get_title() {
        return __( 'Coming Soon', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-number-field';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Coming_Soon_Area',
			[
				'label' => __( 'Coming Soon Controls', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );


            $this->add_control(
                'due_date',
                [
                    'label' => __( 'Due Date', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::DATE_TIME,
                ]
            );

            $this->add_control(
                'bg_image',
                [
                    'label' => __( 'Background Image', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::MEDIA,
                ]
            );

			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'ellen-toolkit' ),
					'type' => Controls_Manager::TEXT,
					'default' => __('We Are Launching Soon', 'ellen-toolkit'),
				]
			);

            $this->add_control(
                'date', [
                    'label' => __( 'Day Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Days' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'hours', [
                    'label' => __( 'Hours Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Hours' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'minutes', [
                    'label' => __( 'Minutes Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Minutes' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'seconds', [
                    'label' => __( 'Seconds Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Seconds' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'action_url', [
                    'label' => esc_html__( 'Action URL', 'ellen-toolkit' ),
                    'description' => __( 'Enter here your MailChimp action URL. <a href="https://www.docs.envytheme.com/docs/ellen-theme-documentation/tips-guides-troubleshoots/get-mailchimp-newsletter-form-action-url/" target="_blank"> How to </a>', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'placeholder_text', [
                    'label' => __( 'Placeholder Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Enter your email' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'button_text', [
                    'label' => __( 'Button text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Subscribe' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );


        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');

        global $ellen_opt;

        // Main site logo
        if( isset( $ellen_opt['main_logo']['url'] ) ):
            $ellen_logo 	= $ellen_opt['main_logo']['url'];
        else:
            $ellen_logo	= '';
        endif;

        $date = $settings['due_date'];
        $date = str_replace("-","/",$date);
        $due_date = substr($date, 0, -5);
		?>
        <div class="coming-soon-area" style="background-image:url(<?php echo esc_url( $settings['bg_image']['url'] ); ?>);">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="coming-soon-content">
                            <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php if( $ellen_logo != '' ): ?>
                                    <img src="<?php echo esc_url( $ellen_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                <?php else: ?>
                                    <h2><?php bloginfo( 'name' ); ?></h2>
                                <?php endif; ?>
                            </a>
                            <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                            <ul class="coming-soon-countdown flex-wrap d-flex">
                                <li class="align-items-center flex-column d-flex justify-content-center">
                                    <span class="days">00</span>
                                    <?php echo esc_html( $settings['date'] ); ?>
                                </li>
                                <li class="align-items-center flex-column d-flex justify-content-center">
                                    <span class="hours">00</span>
                                    <?php echo esc_html( $settings['hours'] ); ?>
                                </li>
                                <li class="align-items-center flex-column d-flex justify-content-center">
                                    <span class="minutes">00</span>
                                    <?php echo esc_html( $settings['minutes'] ); ?>
                                </li>
                                <li class="align-items-center flex-column d-flex justify-content-center">
                                    <span class="seconds">00</span>
                                    <?php echo esc_html( $settings['seconds'] ); ?>
                                </li>
                            </ul>

                            <form class="mailchimp newsletter-form" method="post">
                                <div class="form-group subcribes">
                                    <input type="email" class="input-newsletter memail" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" name="EMAIL" required>
                                </div>
                                <?php if( $settings['button_text'] != '' ): ?>
                                    <button type="submit" class="default-btn"><?php echo esc_html( $settings['button_text'] ); ?><span></span></button>
                                <?php endif; ?>
                            </form>
                            <p class="mchimp-errmessage" style="display: none;"></p>
                            <p class="mchimp-sucmessage" style="display: none;"></p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            (function($){
            "use strict";
                $( window ).on( 'elementor/frontend/init', function() {
                    elementorFrontend.hooks.addAction( 'frontend/element_ready/Ellen_Coming_Soon.default', function($scope, $){
                        // Count Time
                        $('.coming-soon-countdown').downCount({
                            date: '<?php echo $due_date; ?>',
                            offset: -5
                        }, function () {
                            alert('Done!');
                        });
                    });
                });

                if( typeof elementorFrontend !== 'undefined'  ){
                    elementorFrontend.hooks.addAction( 'frontend/element_ready/Ellen_Coming_Soon.default', function($scope, $){
                        // Count Time
                        $('.coming-soon-countdown').downCount({
                            date: '<?php echo $due_date; ?>',
                            offset: -5
                        }, function () {
                            alert('Done!');
                    });
                    });
                }

            }(jQuery));
        </script>

        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Coming_Soon );