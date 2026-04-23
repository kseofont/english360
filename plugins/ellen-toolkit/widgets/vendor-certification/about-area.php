<?php
/**
 * Vendor Certification About Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_VC_About_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_VC_About_Area';
    }

	public function get_title() {
        return esc_html__( 'About Area Three', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-alert';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_VC_About_Area_Area',
			[
				'label' => esc_html__( 'About Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Always take the harmless path, never take shortcuts', 'ellen-toolkit' ),
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
					'default' 	=> esc_html__('Here are some of the advantages that we have to describe related to the industrial business. Industries help in making the employment prospects for the people and in a common of the nations after agriculture. Its business has also a lot of opportunities for a job. It’s due to the presence of various industries that we get to use a selection of products like television, clothes, automobiles, furniture, etc', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);
            $this->add_control(
				'quotes',
				[
					'label' 	=> esc_html__( 'Quotes', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('Our project management training equips learners with the knowledge and discipline required to effectively plan, manage, execute, and control projects regardless of industry. You will learn all about the most popular project management methodologies that help organizations deliver successful projects.', 'ellen-toolkit'),
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
                'quotation',
                [
                    'label'		=> esc_html__('Quotation Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> esc_html__('Find All Courses', 'ellen-toolkit'),
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
                    '{{WRAPPER}} .row.align-items-center' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control(
				'section_bg',
				[
					'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .row.align-items-center' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vc-about-content .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .vc-about-content .title',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vc-about-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .vc-about-content p',
                ]
            );

            $this->add_control(
				'quotes_bg_color',
				[
					'label' => esc_html__( 'Quotes Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vc-about-content .box' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'quotes_color',
				[
					'label' => esc_html__( 'Quotes Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vc-about-content .box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'quotes_typography',
                    'label' => esc_html__( 'Quotes Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .vc-about-content .box p',
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
         <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="vc-about-image">
                        <?php if( $settings['image']['url'] != '' ): ?>
                            <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <div class="vc-about-content">
                        <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                            <?php echo wp_kses_post( $settings['title'] ); ?>
                        </<?php echo esc_attr( $settings['title_tag'] ); ?>>
                        
                        <?php echo wp_kses_post( $settings['content'] ); ?>

                        <?php if($settings['quotes']): ?>
                            <div class="box">
                                <p><?php echo wp_kses_post($settings['quotes']); ?></p>
                                <div class="quotation">
                                    <?php echo wp_get_attachment_image( $settings['quotation']['id'], 'full' ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="about-btn">
                            <?php if($settings['button_text']): ?>
                                <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?>class="default-btn"> <?php echo esc_html($settings['button_text']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_VC_About_Area );