<?php
/**
 * Single Success Stories Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Single_Success_Stories extends Widget_Base {

	public function get_name() {
        return 'Ellen_Single_Success_Stories';
    }

	public function get_title() {
        return esc_html__( 'Single Success Stories', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-blockquote';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Single_Success_Stories_Area',
			[
				'label' => esc_html__( 'Success Stories Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Alina Smith Story
                ', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::WYSIWYG,
                    'label_block' => true,
				]
			);

            $this->add_control(
				'quote',
				[
					'label' 	=> esc_html__( 'Quote', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
                    'label_block' => true,
				]
			);

            $this->add_control( 'video_title', [
                'label'       => esc_html__( 'Video Button Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ] );
            $this->add_control( 'video_link', [
                'label'       => esc_html__( 'YouTube Video Link', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ] );
        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .success-story-desc h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .success-story-desc h3',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .success-story-desc p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .success-story-desc p',
                ]
            );

            $this->add_control(
				'quote_color',
				[
					'label' => esc_html__( 'Quote Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .success-story-sidebar .quote' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'quote_typography',
                    'label' => esc_html__( 'Quote Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .success-story-sidebar .quote',
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');
        ?>
        <div class="success-story-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-12">
                        <div class="success-story-sidebar">
                            <div class="story">
                                <?php the_post_thumbnail(); ?>
                                <?php if($settings['video_title']): ?>
                                    <a href="<?php echo esc_url($settings['video_link']); ?>" class="popup-video"><?php echo esc_html($settings['video_title']); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="quote">
                                <?php echo wp_kses_post($settings['quote']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <div class="success-story-desc">
                            <h3><?php echo wp_kses_post($settings['title']); ?></h3>
                            <?php echo wp_kses_post($settings['content']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Single_Success_Stories );