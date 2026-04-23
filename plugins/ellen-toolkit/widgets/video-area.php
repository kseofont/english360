<?php
/**
 * Video Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Video extends Widget_Base {

	public function get_name() {
        return 'VideoAreaTwo';
    }

	public function get_title() {
        return esc_html__( 'Video Area Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-handle';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Video',
			[
				'label' => esc_html__( 'Ellen Video', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control(
                'img1',
                [
                    'label'   => __( 'Image', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::MEDIA,
                ]
            );
            $this->add_control(
                'shape1',
                [
                    'label'   => __( 'Shape 1', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::MEDIA,
                ]
            );
            $this->add_control(
                'shape2',
                [
                    'label'   => __( 'Shape 2', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::MEDIA,
                ]
            );
            $this->add_control(
                'video_url',
                [
                    'label'    => esc_html__( 'Video URL', 'ellen-toolkit' ),
                    'type'     => Controls_Manager::TEXT,
                    'default'  => 'https://www.youtube.com/watch?v=PWvPbGWVRrU',
                ]
            );
            $this->add_control(
                'play_icon',
                [
                    'label'   => __( 'Play Icon', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::MEDIA,
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="la-video-area">
            <div class="container">
                <div class="la-video-image">
                    <?php if( $settings['img1']['url'] != '' ): ?>
                        <img src="<?php echo esc_url( $settings['img1']['url'] ); ?>" alt="<?php echo esc_attr__('image', 'ellen-toolkit'); ?>">
                    <?php endif; ?>

                    <?php if( $settings['video_url'] != '' ): ?>
                        <a href="<?php echo esc_url( $settings['video_url'] ); ?>" class="video-btn popup-video">
                            <?php if( $settings['play_icon']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $settings['play_icon']['url'] ); ?>" alt="play">
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>

                    <?php if( $settings['shape1']['url'] != '' ): ?>
                        <div class="wrap-shape1" data-speed="0.10" data-revert="true">
                            <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr__('shape1', 'ellen-toolkit'); ?>">
                        </div>
                    <?php endif; ?>
                    <?php if( $settings['shape2']['url'] != '' ): ?>
                        <div class="wrap-shape2" data-speed="0.10" data-revert="true">
                            <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr__('shape2', 'ellen-toolkit'); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Video );