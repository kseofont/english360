<?php
/**
 * Video Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Video_Area extends Widget_Base {

	public function get_name() {
        return 'VideoArea';
    }

	public function get_title() {
        return esc_html__( 'Video Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-play';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Video_Area',
			[
				'label' => esc_html__( 'Ellen Video ARea', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
    
            $this->add_control(
                'image',
                [
                    'label' => esc_html__( 'Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'video_link',
                [
                    'label' => esc_html__( 'Popup YouTube Video Link', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'https://www.youtube.com/watch?v=PWvPbGWVRrU',
                ]
            );

            $this->add_control(
                'title', [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );
            
            $this->add_control(
                'icon', [
                    'label' => esc_html__( 'Play Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

          
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
        <div class="rt-video-area pb-100">
            <div class="container">
                <div class="rt-video-view">
                    <?php if( $settings['image']['url'] != '' ): ?>
                        <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                    <?php endif; ?>

                    <?php if($settings['video_link']): ?>
                        <a href="<?php echo esc_url($settings['video_link']); ?>" class="video-btn popup-video">
                            <?php if( $settings['icon']['url'] != '' ): ?>
                                <div class="polygon-icon">
                                    <?php echo wp_get_attachment_image( $settings['icon']['id'], 'full' ); ?>
                                </div>
                            <?php endif; ?>
                            <span><?php echo esc_html($settings['title']); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div
        <?php        
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Video_Area );