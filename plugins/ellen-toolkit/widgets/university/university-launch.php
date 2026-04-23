<?php
/**
 * University Launch Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class University_Launch extends Widget_Base {

	public function get_name() {
        return 'Launch_University';
    }

	public function get_title() {
        return esc_html__( 'University Launch', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-before-after';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'University_Launch_Area',
			[
				'label' => esc_html__( 'University Launch Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'f_img',
                [
                    'label'		=> esc_html__('Feature Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
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
                    'default'     => __('Launch your new life <span>in Ellen</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Turn your ambitions into reality as an international student at Ellen University. Study in one of the worlds most liveable cities and join a supportive and welcoming community, dedicated to helping you succeed.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();
            $repeater->add_control(
                'number', [
					'type'    => Controls_Manager::NUMBER,
					'label'   => esc_html__( 'Ending Number', 'ellen-toolkit' ),
					'default' => 1926,
                ]
            );
            $repeater->add_control(
                'number_suffix', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Number Suffix', 'ellen-toolkit' ),
					'default' => esc_html__('+', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'funfact_title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('COURSES', 'ellen-toolkit'),
                ]
            );
           
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Counter Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

            $this->add_control(
                'bottom_content',
                [
                    'label'       => __( 'Bottom Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('We really love to help our students to get into the real world.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Know How We Work For Student', 'ellen-toolkit'),
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

            $this->add_control(
                'sec_bg',
                [
                    'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-overview-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
				'sec_topbg',
				[
					'label' => esc_html__( 'Section Top Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-area::before' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-content h1, {{WRAPPER}} .university-overview-content h2, {{WRAPPER}} .university-overview-content h3, {{WRAPPER}} .university-overview-content h4, {{WRAPPER}} .university-overview-content h5, {{WRAPPER}} .university-overview-content h6' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-overview-content h1, {{WRAPPER}} .university-overview-content h2, {{WRAPPER}} .university-overview-content h3, {{WRAPPER}} .university-overview-content h4, {{WRAPPER}} .university-overview-content h5, {{WRAPPER}} .university-overview-content h6',
                ]
            );

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-overview-content p',
                ]
            );

            $this->add_control(
				'counter_nm_color',
				[
					'label' => esc_html__( 'Counter Number Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-content .fun h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_nm_typography',
                    'label' => esc_html__( 'Counter Number Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-overview-content .fun h3',
                ]
            );

            $this->add_control(
				'counter_sp_color',
				[
					'label' => esc_html__( 'Counter Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-content .fun p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_sp_typography',
                    'label' => esc_html__( 'Counter Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-overview-content .fun h3',
                ]
            );

            $this->add_control(
				'con_bt_color',
				[
					'label' => esc_html__( 'Bottom Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-overview-content .bottom p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'con_bt_typography',
                    'label' => esc_html__( 'Bottom Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-overview-content .bottom p',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_bg_color',
				[
					'label' => __( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover_color',
				[
					'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
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

        <!-- Start University Overview Area -->
        <div class="university-overview-area university-home pb-100">
            <div class="container">
                <div class="row justify-content-center align-items-end g-5">
                    <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                        <div class="col-xl-6 col-md-12">
                            <div class="university-overview-image">
                                <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-xl-6 col-md-12">
                        <div class="university-overview-content">
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="title-animation"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                            <?php if( $settings['content']): ?>
                                <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                            <?php endif; ?>
                            
                            <div class="row justify-content-center g-5">
                                <?php foreach( $settings['items'] as $item ): ?>
                                    <div class="col-lg-4 col-sm-4">
                                        <div class="fun">
                                            <?php if( $item['number'] && $item['number_suffix']): ?>
                                                <h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
                                            <?php endif; ?>
                                            <?php if( $item['funfact_title']): ?>
                                                <p><?php echo esc_html( $item['funfact_title'] ); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="bottom">
                                <?php if( $settings['bottom_content']): ?>
                                    <p><?php echo wp_kses_post($settings['bottom_content'] ); ?></p>
                                <?php endif; ?>
                               
                                <?php if($settings['button_text'] && $link): ?>
                                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn"><?php echo esc_html($settings['button_text']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End University Overview Area -->

        <?php
	}


}

Plugin::instance()->widgets_manager->register( new University_Launch );