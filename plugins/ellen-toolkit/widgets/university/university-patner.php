<?php
/**
 * Partner Logo Slider Widget
 */

namespace Elementor;
class University_Partner_Logo extends Widget_Base {

	public function get_name() {
        return 'Partner_Logo_University';
    }

	public function get_title() {
        return __( 'University Partner Logo', 'ellen-toolkit' );
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
				'label' => __( 'Partner Logo', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
           
            $card_items = new Repeater();

                $card_items->add_control(
                    'logo',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Logo', 'ellen-toolkit' ),
                    ]
                );
        
            $this->add_control(
                'logos',
                [
                    'label'       => __( 'Add Logo', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $card_items->get_controls(),
                ]
            );

        $this->end_controls_section();
      
    }

	protected function render() {
        $settings = $this->get_settings_for_display(); 
        
        ?>

        <!-- Start University Partner Area -->
        <div class="university-partner-area pb-100">
            <div class="container">
                <div class="swiper university-partner-slider">
                    <div class="swiper-wrapper align-items-center">
                        <?php foreach( $settings['logos'] as $item ): ?>
                            <div class="swiper-slide">
                                <div class="university-partner-item">
                                    <img src="<?php echo esc_url( $item['logo']['url'] ); ?>" alt="<?php echo esc_attr__( 'Partner Logo', 'ellen-toolkit' ); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End University Partner Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new University_Partner_Logo );