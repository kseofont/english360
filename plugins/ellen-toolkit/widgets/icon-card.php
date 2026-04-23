<?php
/**
 * Icon Card Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Icon_Card extends Widget_Base {

	public function get_name() {
        return 'Icon_Card';
    }

	public function get_title() {
        return esc_html__( 'Icon Card', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-handle';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Section',
			[
				'label' => esc_html__( 'Icon Card', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control(
                'icon',
                [
                    'label' => esc_html__( 'Icon Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control( 'align', [
                'label'   => esc_html__( 'Card Align', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'left'      => 'Left',
                    'center'    => 'Center',
                ],
                'default'       => 'left',
            ] );

            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Strategic Planning', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'content',
                [
                    'label' => esc_html__( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Develop a clear roadmap for business growth with personalized strategic planning sessions.', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'link',
                [
                    'label'		=> esc_html__('Card Link', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'icon_bg_color',
                [
                    'label' => esc_html__( 'Icon Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-services-card .icon' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'card_border_color',
                [
                    'label' => esc_html__( 'Card Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-services-card' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'card_hover_border_color',
                [
                    'label' => esc_html__( 'Card Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-services-card:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-services-card h3 a, {{WRAPPER}} .bc-services-card h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-services-card h3',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bc-services-card p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .bc-services-card p',
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
        <div class="bc-services-card card-<?php echo esc_attr($settings['align']); ?>">
            <?php if($settings['icon']['url']): ?>
                <div class="icon">
                    <img src="<?php echo esc_url($settings['icon']['url']); ?>" alt="<?php echo esc_attr__('Button Icon', 'ellen-toolkit'); ?>">
                </div>
            <?php endif; ?>

            <?php if($settings['link']): ?>
                <h3>
                    <a href="<?php echo esc_url($settings['link']); ?>"><?php echo esc_html($settings['title']); ?></a>
                </h3>
            <?php else: ?>
                <h3>
                    <?php echo esc_html($settings['title']); ?>
                </h3>
            <?php endif; ?>
            <p><?php echo wp_kses_post($settings['content']); ?></p>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Icon_Card );