<?php
/**
 * Opportunities Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Opportunities_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_Opportunities_Area';
    }

	public function get_title() {
        return esc_html__( 'Opportunities Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-site-identity';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Opportunities_Area',
			[
				'label' => esc_html__( 'Opportunities Area Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Affordable Remote Training and learning opportunities​', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );

			$this->add_control( 'title_tag', [
                'label'   => esc_html__( 'Title HTML Tag', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h3',
            ] );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Explore all of our courses and pick your suitable ones to enroll and start learning with us! Flexible easy to access learning opportunities can bring a significant change.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);
            $this->add_control(
                'bg',
                [
                    'label'		=> esc_html__('Background Shape Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );
            $this->add_control(
                'image',
                [
                    'label'		=> esc_html__('Section Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );
           
            $this->add_control(
                'button_text',
                [
                    'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> esc_html__('View All Stories', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'button_icon',
                [
                    'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::ICONS,
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
                    'type'        => Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'separator'   => 'before',
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
            $this->add_responsive_control( 'section_padding', [
                'label'      => esc_html__( 'About Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .rt-opportunities-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

          
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .rt-opportunities-content .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .rt-opportunities-content .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .rt-opportunities-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .rt-opportunities-content p',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .default-btn',
                ]
            );
            
            $this->add_control(
                'btn_color',
                [
                    'label' => __( 'Button Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_border_color',
                [
                    'label' => __( 'Button Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_color',
                [
                    'label' => __( 'Button Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            
            $this->add_control(
                'btn_hover_border_color',
                [
                    'label' => __( 'Button Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_hover_color',
                [
                    'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_hover_color',
                [
                    'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .default-btn:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        // Get Banner Button Link
        $target     = '';
        $nofollow   = '';
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link       = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $target     = $settings['ex_link']['is_external'] ? ' target="_blank"' : '';
		    $nofollow   = $settings['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
            $link       = $settings['ex_link']['url'];
        }else{
            $link = '';
        }
        ?>

        <div class="rt-opportunities-area ptb-100" style="background-image:url(<?php echo esc_url($settings['bg']['url']); ?>);">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="rt-opportunities-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $settings['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <div class="opportunities-btn">
                                <?php if($settings['button_text']): ?>
                                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($settings['button_text']); ?><div class="btn-icon"><?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></div></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="rt-opportunities-image">
                            <?php if( $settings['image']['url'] != '' ): ?>
                                <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Opportunities_Area );