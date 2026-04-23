<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class Ellen_University_WChoose extends Widget_Base {

	public function get_name() {
        return 'University_WChoose';
    }

	public function get_title() {
        return __( 'University Why Choose', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-animation';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'ellen_whuniversity',
			[
				'label' => __( 'University Why Choose Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'choose_style',
                [
                    'label' => __( 'Choose Style', 'medak-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Style - 1', 'medak-toolkit' ),
                        '2'   => __( 'Choose Style - 2', 'medak-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'heading_tag', [
                    'label'   => __( 'Title Heading Tag', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default'     => 'h2',
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sec_title',
                [
                    'label'   => __( 'Section Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'A university for the future', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'As a university for the future, we combine cutting-edge research, innovative teaching methods, and a commitment to sustainability to prepare students for a rapidly evolving world.', 'ellen-toolkit' ),
                ]
            );

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'f_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_title',
                    [
                        'label'   => __( 'Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( '<strong>Ranked in top 100</strong> of universities worldwide', 'ellen-toolkit' ),
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

            $this->add_control(
                's_img',
                [
                    'label'		=> esc_html__('Shape Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                    'condition' => [
                        'choose_style' => ['2'],
                    ],
                ]
            );

            $this->add_control(
                's_img2',
                [
                    'label'		=> esc_html__('Shape Image Two', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                    'condition' => [
                        'choose_style' => ['2'],
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'university_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'sec_bg_color',
                [
                    'label'     => __( 'Section Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-choose-area, {{WRAPPER}} .sc-choose-area' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .section-wrap-title p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title p',
                ]
            );

            
            $this->add_control(
                'list_icon_bg_color',
                [
                    'label'     => __( 'Icon Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-choose-card .icon::before, {{WRAPPER}} .sc-choose-card .icon::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
           

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Item Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-choose-card h5, {{WRAPPER}} .sc-choose-card h5' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Item Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-choose-card h5, {{WRAPPER}} .sc-choose-card h5',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        $ns_fea_item  = $settings['ns_fea_item'];

    ?>

        

        <?php if($settings['choose_style']==1): ?>
            <!-- Start University Choose Area -->
            <div class="university-choose-area university-home ptb-100">
                <div class="container">
                    <div class="section-wrap-title text-center">
                        <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                        <?php if( $settings['sec_content'] != '' ): ?>
                            <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="row justify-content-center g-5">
                        <?php $i=1; foreach( $ns_fea_item as $item  ):  ?>
                            <div class="col-lg-3 col-sm-6">
                                <div class="university-choose-card">
                                    <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                        <div class="icon">
                                            <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                        </div>
                                    <?php } ?>
                                    <?php if($item['list_title'] != ''): ?>
                                        <h5><?php echo wp_kses_post( $item['list_title'] ); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php 
                            $i++; endforeach; 
                        ?>
                    </div>
                </div>
            </div>
            <!-- End University Choose Area -->
        <?php elseif($settings['choose_style']==2): ?>
            <!-- Start SC Choose Area -->
            <div class="sc-choose-area school-college-home ptb-100">
                <div class="container">
                    <div class="section-wrap-title text-center">
                        <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                        <?php if( $settings['sec_content'] != '' ): ?>
                            <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="row justify-content-center g-5">
                        <?php $i=1; foreach( $ns_fea_item as $item  ):  ?>
                            <div class="col-lg-3 col-sm-6">
                                <div class="sc-choose-card">
                                    <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                        <div class="icon">
                                            <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                        </div>
                                    <?php } ?>
                                    <?php if($item['list_title'] != ''): ?>
                                        <h5><?php echo wp_kses_post( $item['list_title'] ); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php 
                            $i++; endforeach; 
                        ?>
                    </div>
                </div>
                <?php if( !empty( $settings['s_img']['url'] ) ){ ?>
                    <div class="sc-choose-shape1">
                        <img src="<?php echo esc_url( $settings['s_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                    </div>
                <?php } ?>
                <?php if( !empty( $settings['s_img2']['url'] ) ){ ?>
                    <div class="sc-choose-shape2">
                        <img src="<?php echo esc_url( $settings['s_img2']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                    </div>
                <?php } ?>
            </div>
            <!-- End SC Choose Area -->
        <?php endif; ?>


        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_University_WChoose );