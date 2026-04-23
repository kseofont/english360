<?php
/**
 * University Banner Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sc_About extends Widget_Base {

	public function get_name() {
        return 'Sc_About';
    }

	public function get_title() {
        return esc_html__( 'School & College About', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-info-box';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Sc_About_Sc',
			[
				'label' => esc_html__( 'About Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );


            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('ABOUT ELLEN', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label' 	=> esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
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
                'title',
                [
                    'label'       => __( 'Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('A School for the <span>Intellectually Adventurous</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('We believe academically curious, socially engaged girls are our best hope for the future. We celebrate and cultivate that power, enabling our students to grow into their authentic selves and lead lives of purpose.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'tab_title',
                    [
                        'label'   => __( 'Tab Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'ABOUT ELLEN', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'tab_icon',
                    [
                        'label'   => __( 'Tab Icon', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'bx bx-chevron-right', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'f_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'sub_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Sub Images', 'ellen-toolkit' ),
                    ]
                );

            $this->add_control(
                'ns_fea_item',
                [
                    'label'       => __( 'Add Item', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $fea_items->get_controls(),
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

            $this->add_control(
                'sec_bg_color',
                [
                    'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_top_bg_color',
                [
                    'label' => esc_html__( 'Section Top Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-area::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-content .sub::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-about-content .sub',
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .title-tgas' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-about-content .title-tgas',
                ]
            );

            $this->add_control(
				'bg_title_color',
				[
					'label' => esc_html__( 'Title Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .title-tgas span::before' => 'background-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-about-content p',
                ]
            );

           
            $this->add_control(
				'tab_tit_color',
				[
					'label' => __( 'Tab Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'tab_tit_hover_color',
				[
					'label' => __( 'Tab Title Hover & Active Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link:hover, {{WRAPPER}} .sc-about-content .nav .nav-item .nav-link.active' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'tab_tit_br_color',
				[
					'label' => __( 'Tab Title Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link' => 'border-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'tab_tit_br_a_color',
				[
					'label' => __( 'Tab Title Hover Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link:hover, {{WRAPPER}} .sc-about-content .nav .nav-item .nav-link.active' => 'border-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'tab_tit_bg_color',
				[
					'label' => __( 'Video Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'tab_tit_bg_hover_color',
				[
					'label' => __( 'Video Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link:hover, {{WRAPPER}} .sc-about-content .nav .nav-item .nav-link.active' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tab_tit_typography',
                    'label' => esc_html__( 'Video Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-about-content .nav .nav-item .nav-link',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        $ns_fea_item  = $settings['ns_fea_item'];

        ?>

        <!-- Start SC About Area -->
        <div class="sc-about-area school-college-home ptb-100">
            <div class="container">
                <div class="row justify-content-center g-5">
                    <div class="col-xl-6 col-md-12">
                        <div class="sc-about-content">
                            <?php if( $settings['top_title']): ?>
                                <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                            <?php endif; ?>
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                            <?php if( $settings['content']): ?>
                                <p><?php echo wp_kses_post($settings['content']); ?></p>
                            <?php endif; ?>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <?php $i=1; foreach( $ns_fea_item as $item  ):  ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($i==1): ?> active <?php endif; ?>" id="one-tab<?php echo $i; ?>" data-bs-toggle="tab" href="#one<?php echo $i; ?>" role="tab" aria-controls="one<?php echo $i; ?>">
                                            <span><?php echo wp_kses_post($item['tab_title']); ?></span>
                                            <?php if ( $item['tab_icon']) : ?>
                                                <i class='<?php echo esc_attr($item['tab_icon']); ?>'></i>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php 
                                    $i++; endforeach; 
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="tab-content" id="myTabContent">
                            <?php $i=1; foreach( $ns_fea_item as $item  ): ?>
                                <div class="tab-pane fade <?php if($i==1): ?> show active <?php endif; ?>" id="one<?php echo $i; ?>" role="tabpanel">
                                    <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                        <div class="sc-about-image">
                                            <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            <?php if( !empty( $item['sub_img']['url'] ) ){ ?>
                                                <div class="wrap-shape">
                                                    <img src="<?php echo esc_url( $item['sub_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php 
                                $i++; endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End SC About Area -->

        <?php
	}
    
}

Plugin::instance()->widgets_manager->register( new Sc_About );