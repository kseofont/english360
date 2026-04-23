<?php
/**
 * Banner Slider Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Banner_Slider extends Widget_Base {

	public function get_name() {
        return 'Ellen_Banner_Slider';
    }

	public function get_title() {
        return __( 'Banner Slider', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-post-slider';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'slider_section',
			[
				'label' => __( 'Slider Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
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
                'default' => 'h1',
            ] );

			$repeater = new Repeater();

            $repeater->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Find Simple & Effective Training Courses Now', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );
            $repeater->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Ellen is a Global training provider based across the UK that specialists in accredited and bespoke training courses. Flexible easy to access learning opportunities can bring a significant change.', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);
            $repeater->add_control(
				'image',
				[
					'label' 	=> esc_html__( 'Image', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::MEDIA,
				]
			);

            $repeater->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('View Reviews', 'ellen-toolkit'),
				]
            );

            $repeater->add_control(
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

            $repeater->add_control(
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

            $repeater->add_control(
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

            $repeater->add_control(
				'user_image',
				[
					'label' 	=> esc_html__( 'User Image', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::MEDIA,
				]
			);
            $repeater->add_control(
				'photo_by',
				[
					'label' 	=> esc_html__( 'By Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Art Done By ', 'ellen-toolkit'),
				]
			);
            $repeater->add_control(
				'photo_by_name',
				[
					'label' 	=> esc_html__( 'By Name', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Andrew Watson', 'ellen-toolkit'),
				]
			);
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Slider Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

            $this->add_control(
				'button_icon',
				[
					'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::ICONS,
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

        $this->add_responsive_control( 'banner_padding', [
            'label'      => esc_html__( 'Slider Padding', 'ellen-toolkit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .online-art-banner-slides' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .online-art-banner-content .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .online-art-banner-content .title',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .online-art-banner-content p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                
                'selector' => '{{WRAPPER}} .online-art-banner-content p',
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

        $this->add_control(
            'shape_color',
            [
                'label' => __( 'Slider Shape Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .online-art-banner-item::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
             [
                 'name' => 'background',
                 'label' => __( 'Slider Arrow Background', 'ellen-toolkit' ),
                 'types' => [ 'gradient' ],
                 'selector' => '{{WRAPPER}} .online-art-banner-slides.owl-theme .owl-nav [class*=owl-]',
             ]
         );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
		?>

        <div class="online-art-banner-slides owl-carousel owl-theme">
            <?php foreach( $settings['items'] as $item ): 
                // Get Banner Button Link
                
                $target     = '';
                $nofollow   = '';
                if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                    $link       = get_page_link( $item['link_to_page'] );
                }elseif($item['link_type'] == 2) {
                    $target     = $item['ex_link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow   = $item['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
                    $link       = $item['ex_link']['url'];
                }else{
                    $link = '';
                } ?>
                <div class="online-art-banner-item jarallax" data-jarallax='{"speed": 0.3}' style="background-image:url(<?php echo esc_url($item['image']['url']); ?>);">
                    <div class="container-fluid">
                        <div class="online-art-banner-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                                <?php echo wp_kses_post( $item['title'] ); ?>
                            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p><?php echo wp_kses_post( $item['content'] ); ?></p>

                            <div class="banner-btn">
                                <?php if($item['button_text']): ?>
                                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($item['button_text']); ?><div class="btn-icon"><?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?></div></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="art-banner-info">
                        <div class="d-flex align-items-center">
                            <div class="images d-flex align-items-center">
                                <?php if( $item['user_image']['url'] != '' ): ?>
                                    <?php echo wp_get_attachment_image( $item['user_image']['id'], 'full' ); ?>
                                <?php endif; ?>                            
                            </div>
                            <div class="text">
                                <p><?php echo esc_html($item['photo_by']); ?> <span><?php echo esc_html($item['photo_by_name']); ?></a></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Banner_Slider );