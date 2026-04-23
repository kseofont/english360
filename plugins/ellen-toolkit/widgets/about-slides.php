<?php
/**
 * About Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_About_Slider extends Widget_Base {

	public function get_name() {
        return 'About_Slider';
    }

	public function get_title() {
        return __( 'Ellen About Slider', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-slides';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_About_Slider',
			[
				'label' => __( 'About Slider Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $repeater = new Repeater();
            $repeater->add_control(
                'title', [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'About Our Story', 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'content', [
                    'label' => __( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'Whether you want to learn or to share what you know, you’ve come to the right place. As a global destination for online learning, we connect people through knowledge.', 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'image', [
                    'label' => __( 'Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'youtube_link', [
                    'label' => __( 'YouTube Video Link', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'https://www.youtube.com/watch?v=l-epKcOA7RQ', 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );
            $this->add_control(
                'items',
                [
                    'label' => esc_html__('Slider Items', 'ellen-toolkit'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'about_sliders_style',
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
                        '{{WRAPPER}} .single-about-box .content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-about-box .content h3',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-about-box .content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-about-box .content p',
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
        <div class="container">
            <div class="about-slides owl-carousel owl-theme">
                <?php foreach( $settings['items'] as $item ): ?>
                    <div class="single-about-box">
                        <div class="row m-0 align-items-center">
                            <div class="col-lg-7 col-md-6 p-0">
                                <div class="image">
                                    <?php if($item['image']['url']): ?>
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>">

                                        <?php if($item['youtube_link']): ?>
                                            <a href="<?php echo esc_url($item['youtube_link']); ?>" class="popup-video"></a>
                                            <i class='bx bx-play'></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 p-0">
                                <div class="content">
                                    <h3><?php echo wp_kses_post( $item['title'] ); ?></h3>
                                    <p><?php echo wp_kses_post( $item['content'] ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_About_Slider );