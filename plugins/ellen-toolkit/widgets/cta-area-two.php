<?php
/**
 * CTA Area Two Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_CTA_Area_Two extends Widget_Base {

	public function get_name() {
        return 'Ellen_CTA_Area_Two';
    }

	public function get_title() {
        return __( 'CTA Area Two', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-call-to-action';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'cta_section',
			[
				'label' => __( 'Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
                'shape',
                [
                    'label' => esc_html__( 'Shape', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

			$this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Are you ready to take your business to the next level?', 'ellen-toolkit'),
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
                    'default' => 'h2',
                ]
            );


            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> __('Book Your Free Consultation', 'ellen-toolkit'),
				]
			);
            $this->add_control(
				'button_icon',
				[
					'label' 	=> esc_html__( 'Button ICON', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::MEDIA,
				]
			);

            $this->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                ]
            );

            $this->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'link_type' => '1',
                    ]
                ]
            );

            $this->add_control(
                'ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: TEXT,
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'bg_color',
				[
					'label' => __( 'Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .bc-overview-area' => 'background: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cta-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .cta-title',
                ]
            );


            $this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => __( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} ..default-btn',
                ]
            );


        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();// Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        $button_text = $settings['button_text'];

         // Get Button Link
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $link = $settings['ex_link'];
        }else{
            $link = '';
        }
        ?>
        <div class="bc-overview-area ptb-100">
            <div class="container">
                <div class="bc-overview-content">
                    <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cta-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                    
                    <?php if( $button_text ): ?>
                        <div class="overview-btn">
                            <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?>
                            <?php if($settings['button_icon']['url']): ?>
                                <img src="<?php echo esc_url($settings['button_icon']['url']); ?>" alt="<?php echo esc_attr__('Button Icon', 'ellen-toolkit'); ?>">
                            <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($settings['shape']['url']): ?>
                <div class="bc-overview-shape">
                    <img src="<?php echo esc_url($settings['shape']['url']); ?>" alt="Shape Image">
                </div>
            <?php endif; ?>
        </div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_CTA_Area_Two );