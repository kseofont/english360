<?php
/**
 * Kitchen Coach Overview Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_KC_Overview_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_KC_Overview_Area';
    }

	public function get_title() {
        return esc_html__( 'Overview Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-alert';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_KC_Overview_Area_Area',
			[
				'label' => esc_html__( 'Overview Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Stress-Free recipes to cook for and with your family', 'ellen-toolkit' ),
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
					'type' 		=> Controls_Manager::WYSIWYG,
					'default' 	=> esc_html__('Explore all of our courses and pick your suitable ones to enroll and start learning with us!', 'ellen-toolkit'),
                    'label_block' => true,
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
                'shape1',
                [
                    'label'		=> esc_html__('Section Shape Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> esc_html__('Download Free Now', 'ellen-toolkit'),
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
			'about_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
            $this->add_responsive_control( 'about_padding', [
                'label'      => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .kc-overview-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'section_bg',
				[
					'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kc-overview-inner-box' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kc-overview-content .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .kc-overview-content .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kc-overview-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .kc-overview-content p',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .kc-overview-content .overview-btn .default-btn',
                ]
            );
            
            $this->add_control(
                'btn_color',
                [
                    'label' => __( 'Button Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-overview-content .overview-btn .default-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_color',
                [
                    'label' => __( 'Button Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-overview-content .overview-btn .default-btn' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_bg_hover_color',
                [
                    'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-overview-content .overview-btn .default-btn:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'btn_hover_color',
                [
                    'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .kc-overview-content .overview-btn .default-btn:hover' => 'color: {{VALUE}}',
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
        <div class="kc-overview-area">
            <div class="container">
                <div class="kc-overview-inner-box">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <div class="kc-overview-image">
                                <?php if( $settings['image']['url'] != '' ): ?>
                                    <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                                <?php endif; ?>                            
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="kc-overview-content">
                                <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                    <?php echo wp_kses_post( $settings['title'] ); ?>
                                </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                
                                <?php echo wp_kses_post( $settings['content'] ); ?>
                                
                                <div class="overview-btn">
                                    <?php if($settings['button_text']): ?>
                                        <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($settings['button_text']); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kc-overview-shape">
                        <?php if( $settings['shape1']['url'] != '' ): ?>
                            <?php echo wp_get_attachment_image( $settings['shape1']['id'], 'full' ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_KC_Overview_Area );