<?php
/**
 * Single Program Widget
 */

namespace Elementor;
class Single_Program extends Widget_Base {

	public function get_name() {
        return 'SingleProgram';
    }

	public function get_title() {
        return __( 'Single Program', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-header';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Section',
			[
				'label' => __( 'Ellen Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );


            $list_item = new Repeater();

                $list_item->add_control(
                    'list_tit', [
                        'label'       => esc_html__( 'Left List Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Entry Requirements', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $list_item->add_control(
                    'list_url', [
                        'label'       => esc_html__( 'Left List Item Url', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( '#entry', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

            $this->add_control(
                'list_items',
                [
                    'label'  => esc_html__( 'Add Left List Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $list_item->get_controls(),
                ]
            );

            $this->add_control(
                'sec_to_title',
                [
                    'label'   => __( 'Section Top Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Master of Environmental Policy and Management', 'ellen-toolkit' ),
                ]
            );

            $fea_items = new Repeater();

                $fea_items->add_control(
                    'tab_title',
                    [
                        'label'   => __( 'Tab Title', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'Domestic', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'd_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Calendar Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'd_start',
                    [
                        'label'   => __( 'Date Start Text', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'START DATE', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'd_date',
                    [
                        'label'   => __( 'Date Text', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'February and July', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'dur_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Clock Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'dur_start',
                    [
                        'label'   => __( 'Duration Text', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'DURATION', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'dur_time',
                    [
                        'label'   => __( 'Duration Time', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( '2 Years', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'loc_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Location Images', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'loc_start',
                    [
                        'label'   => __( 'Location Text', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'LOCATION', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'loc_place',
                    [
                        'label'   => __( 'Location Place', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXT,
                        'default' => __( 'Venice Campus', 'ellen-toolkit' ),
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
                'entry_id',
                [
                    'label'   => __( 'Entry Id', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( '#entry', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'entry_title',
                [
                    'label'   => __( 'Entry Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Architecture, Design and Planning', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'entry_content',
                [
                    'label'   => __( 'Entry Content', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::WYSIWYG,
                ]
            );

            $this->add_control(
                'f_img',
                [
                    'label'		=> esc_html__('Entry Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'fees_id',
                [
                    'label'   => __( 'Fees Id', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( '#fees', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'fees_title',
                [
                    'label'   => __( 'Fees Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Fees and Scholarships', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'fees_content',
                [
                    'label'   => __( 'Fees Content', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::WYSIWYG,
                ]
            );


            $this->add_control(
                'careers_id',
                [
                    'label'   => __( 'Careers Id', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( '#careers', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'careers_img',
                [
                    'label'		=> esc_html__('Careers Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'careers_title',
                [
                    'label'   => __( 'Careers Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Careers Outcomes', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'careers_content',
                [
                    'label'   => __( 'Careers Content', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::WYSIWYG,
                ]
            );

            $this->add_control(
                'apply_id',
                [
                    'label'   => __( 'Apply Id', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( '#apply', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'apply_title',
                [
                    'label'   => __( 'Apply Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( 'How to Apply', 'ellen-toolkit' ),
                ]
            );

            $apply_item = new Repeater();

                $apply_item->add_control(
                    'ava_list_icon',
                    [
                        'label'		=> esc_html__('Apply Item Image', 'ellen-toolkit'),
                        'type'		=> Controls_Manager:: MEDIA,
                    ]
                );

                $apply_item->add_control(
                    'ava_list_tit', [
                        'label'       => esc_html__( 'Apply Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Apply through <span>online form</span>', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $apply_item->add_control(
                    'ava_list_btn', [
                        'label'       => esc_html__( 'Apply Item Button', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Apply Now', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $apply_item->add_control(
                    'ava_btn_icon', [
                        'label'       => esc_html__( 'Apply Item Button Icon', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'bx bx-right-arrow-alt', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $apply_item->add_control(
                    'ava_link_type',
                    [
                        'label' 		=> esc_html__( 'Apply Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $apply_item->add_control(
                    'ava_link_to_page',
                    [
                        'label' 		=> esc_html__( 'Apply Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'ava_link_type' => '1',
                        ]
                    ]
                );
    
                $apply_item->add_control(
                    'ava_ex_link',
                    [
                        'label'		=> esc_html__('Apply Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'ava_link_type' => '2',
                        ]
                    ]
                );

            $this->add_control(
                'apply_items',
                [
                    'label'  => esc_html__( 'Add Apply Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $apply_item->get_controls(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );
            
            $this->add_control(
                'left_title_color',
                [
                    'label' => esc_html__( 'Left List Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-sidebar li .scroll-link' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'left_title_a_color',
                [
                    'label' => esc_html__( 'Left List Item Active/Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-sidebar li .scroll-link:hover, {{WRAPPER}} .program-details-sidebar li .scroll-link.active' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'left_typography',
                    'label' => __( 'Left List Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-sidebar li .scroll-link',
                ]
            );

            $this->add_control(
                'left_title_br_color',
                [
                    'label' => esc_html__( 'Left List Item Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-sidebar li .scroll-link' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'left_title_h_br_color',
                [
                    'label' => esc_html__( 'Left List Item Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-sidebar li .scroll-link::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content h2' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content h2',
                ]
            );

            $this->add_control(
                'tab_title_color',
                [
                    'label'     => __( 'Tab Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_h_color',
                [
                    'label'     => __( 'Tab Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link:hover, {{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link.active' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_bg_color',
                [
                    'label'     => __( 'Tab Title Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_control(
                'tab_title_h_bg_color',
                [
                    'label'     => __( 'Tab Title Hover Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link:hover, {{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link.active' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_tab_title',
                    'label'    => __( 'Tab Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .time-tabs .nav .nav-item .nav-link',
                ]
            );

            $this->add_control(
                'tab_content_titcolor',
                [
                    'label'     => __( 'Tab Content Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .time-info li .title strong' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tab_content_tit_typography',
                    'label' => esc_html__( 'Tab Content Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .time-tabs .time-info li .title strong',
                ]
            );

            $this->add_control(
                'tab_content_contcolor',
                [
                    'label'     => __( 'Tab Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .time-tabs .time-info li .title span' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tab_content_cont_typography',
                    'label' => esc_html__( 'Tab Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .time-tabs .time-info li .title span',
                ]
            );

            $this->add_control(
				'all_tit_color',
				[
					'label' => esc_html__( 'Section All Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .program-details-content .entry-content h3, {{WRAPPER}} .program-details-content .careers-content h3, {{WRAPPER}} .program-details-content .fees-content h3' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'all_content_typography',
                    'label' => esc_html__( 'Section All Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .entry-content h3, {{WRAPPER}} .program-details-content .careers-content h3, {{WRAPPER}} .program-details-content .fees-content h3',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .program-details-content .entry-content p, {{WRAPPER}} .program-details-content .careers-content p, {{WRAPPER}} .program-details-content .fees-content p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .entry-content p, {{WRAPPER}} .program-details-content .careers-content p, {{WRAPPER}} .program-details-content .fees-content p',
                ]
            );

            $this->add_control(
                'av_item_color',
                [
                    'label' => esc_html__( 'Apply Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .apply-content .apply-box h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'av_item_typography',
                    'label' => __( 'Apply Degrees Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .apply-content .apply-box h3',
                ]
            );

            $this->add_control(
                'av_item_btn_color',
                [
                    'label' => esc_html__( 'Apply Item Button Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .apply-content .apply-box .link-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'av_item_btn_h_color',
                [
                    'label' => esc_html__( 'Apply Item Button Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .program-details-content .apply-content .apply-box .link-btn:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'av_item_btn_typography',
                    'label' => __( 'Apply Item Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .program-details-content .apply-content .apply-box .link-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <!-- Start Program Details Area -->
        <div class="program-details-area university-home ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
                        <ul class="program-details-sidebar">
                            <?php $i=1; foreach( $settings['list_items'] as $item ):  ?>

                                <?php if ( $item['list_tit'] && $item['list_url']) : ?>
                                    <li>
                                        <a href="<?php echo esc_attr( $item['list_url'] ); ?>" class="scroll-link <?php if( $i==1 ) : ?> active <?php endif; ?>"><?php echo wp_kses_post( $item['list_tit'] ); ?></a>
                                    </li>
                                <?php endif; ?>
                                
                            <?php $i++; endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="program-details-content">
                            <?php if( $settings['sec_to_title'] != '' ): ?>
                                <h2><?php echo wp_kses_post( $settings['sec_to_title'] ); ?></h2>
                            <?php endif; ?>
                            <div class="time-tabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <?php $a=1; foreach( $settings['ns_fea_item'] as $fea_item ):  ?>
                                        <?php if ( $fea_item['tab_title']) : ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if( $a==1 ) : ?> active <?php endif; ?>" id="domestic-tab<?php echo $a ?>" data-bs-toggle="tab" href="#domestic<?php echo $a ?>" role="tab" aria-controls="domestic<?php echo $a ?>"><?php echo wp_kses_post( $fea_item['tab_title'] ); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php $a++; endforeach; ?>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <?php $a=1; foreach( $settings['ns_fea_item'] as $fea_item ):  ?>
                                        <div class="tab-pane fade <?php if( $a==1 ) : ?> show active <?php endif; ?>" id="domestic<?php echo $a ?>" role="tabpanel">
                                            <ul class="time-info">
                                                <?php if ( $fea_item['d_img']['url'] && $fea_item['d_start'] && $fea_item['d_date']) : ?>
                                                    <li>
                                                        <div class="image">
                                                            <img src="<?php echo esc_url( $fea_item['d_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                        </div>
                                                        <div class="title">
                                                            <strong><?php echo wp_kses_post( $fea_item['d_start'] ); ?></strong>
                                                            <span><?php echo wp_kses_post( $fea_item['d_date'] ); ?></span>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ( $fea_item['dur_img']['url'] && $fea_item['dur_start'] && $fea_item['dur_time']) : ?>
                                                    <li>
                                                        <div class="image">
                                                            <img src="<?php echo esc_url( $fea_item['dur_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                        </div>
                                                        <div class="title">
                                                            <strong><?php echo wp_kses_post( $fea_item['dur_start'] ); ?></strong>
                                                            <span><?php echo wp_kses_post( $fea_item['dur_time'] ); ?></span>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ( $fea_item['loc_img']['url'] && $fea_item['loc_start'] && $fea_item['loc_place']) : ?>
                                                    <li>
                                                        <div class="image">
                                                            <img src="<?php echo esc_url( $fea_item['loc_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                                        </div>
                                                        <div class="title">
                                                            <strong><?php echo wp_kses_post( $fea_item['loc_start'] ); ?></strong>
                                                            <span><?php echo wp_kses_post( $fea_item['loc_place'] ); ?></span>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php $a++; endforeach; ?>
                                    
                                </div>
                            </div>
                            <div <?php if( $settings['entry_id'] ): ?> id="<?php echo esc_attr( $settings['entry_id'] ); ?>" <?php endif; ?> class="entry-content">
                                <?php if( $settings['entry_title'] != '' ): ?>
                                    <h3><?php echo wp_kses_post( $settings['entry_title'] ); ?></h3>
                                <?php endif; ?>
                                <?php if( $settings['entry_content'] != '' ): ?>
                                   <?php echo wp_kses_post( $settings['entry_content'] ); ?>
                                <?php endif; ?>
                            </div>

                            <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                                <div class="large-image">
                                    <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                </div>
                            <?php } ?>

                            
                            <div <?php if( $settings['fees_id'] ): ?> id="<?php echo esc_attr( $settings['fees_id'] ); ?>" <?php endif; ?> class="fees-content">
                                <?php if( $settings['fees_title'] != '' ): ?>
                                    <h3><?php echo wp_kses_post( $settings['fees_title'] ); ?></h3>
                                <?php endif; ?>
                                <?php if( $settings['fees_content'] != '' ): ?>
                                   <?php echo wp_kses_post( $settings['fees_content'] ); ?>
                                <?php endif; ?>
                            </div>
                            <div <?php if( $settings['careers_id'] ): ?> id="<?php echo esc_attr( $settings['careers_id'] ); ?>" <?php endif; ?> class="careers-content">
                                <?php if( $settings['careers_title'] != '' ): ?>
                                    <h3><?php echo wp_kses_post( $settings['careers_title'] ); ?></h3>
                                <?php endif; ?>
                                <div class="row justify-content-center align-items-center">
                                    <?php if( !empty( $settings['careers_img']['url'] ) ){ ?>
                                        <div class="col-xl-5 col-md-12">
                                            <div class="left">
                                                <img src="<?php echo esc_url( $settings['careers_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-xl-7 col-md-12">
                                        <div class="right">
                                            <?php if( $settings['careers_content'] != '' ): ?>
                                                <?php echo wp_kses_post( $settings['careers_content'] ); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div <?php if( $settings['apply_id'] ): ?> id="<?php echo esc_attr( $settings['apply_id'] ); ?>" <?php endif; ?> class="apply-content">
                              
                                <?php if( $settings['apply_title'] != '' ): ?>
                                    <h3><?php echo wp_kses_post( $settings['apply_title'] ); ?></h3>
                                <?php endif; ?>

                                <div class="row justify-content-center g-4">

                                    <?php $j=1; foreach( $settings['apply_items'] as $av_item ): 
                    
                                        // Get Button Link
                                        if( $av_item['ava_link_type'] == 1 ){
                                            $av_link = get_page_link( $av_item['ava_link_to_page'] );
                                        } else {
                                            $av_link = $av_item['ava_ex_link'];
                                        }

                                    ?>
                                    
                                    <div class="col-xl-4 col-md-6">
                                        <div class="apply-box">
                                            <?php if( !empty( $av_item['ava_list_icon']['url'] ) ){ ?>
                                                <img src="<?php echo esc_url( $av_item['ava_list_icon']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            <?php } ?>
                                            <?php if( $av_item['ava_list_tit'] ): ?>
                                                <h3><?php echo wp_kses_post( $av_item['ava_list_tit'] ); ?></h3>
                                            <?php endif; ?>
                                            <?php if( $av_item['ava_list_btn'] && $av_link ): ?>
                                                <a href="<?php echo esc_url( $av_link ); ?>" class="link-btn"><?php echo wp_kses_post( $av_item['ava_list_btn'] ); ?><i class='<?php echo esc_attr( $av_item['ava_btn_icon'] ); ?>'></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php $j++; endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Program Details Area -->

        <script>

            (function ($) {
                $(document).ready(function () {
                    var sectionLinks = $('a.scroll-link');
                    function updateActiveSection() {
                        var scrollPosition = $(document).scrollTop();

                        sectionLinks.each(function () {
                            var targetSection = $(this).attr('href');
                            
                            if ($(targetSection).length) {
                                var sectionOffset = $(targetSection).offset().top - 150;
                                var sectionHeight = $(targetSection).outerHeight();
                                var sectionBottom = sectionOffset + sectionHeight;

                                if (scrollPosition >= sectionOffset - 20 && scrollPosition < sectionBottom - 20) {
                                    sectionLinks.removeClass('active'); 
                                    $(this).addClass('active'); 
                                }
                            }
                        });
                    }

                   
                    $(document).on('scroll', function () {
                        updateActiveSection();
                    });

                    
                    sectionLinks.on('click', function (e) {
                        e.preventDefault(); 
                        
                        var targetSection = $(this).attr('href');
                        
                        if ($(targetSection).length) {
                            $('html, body').animate({
                                scrollTop: $(targetSection).offset().top - 100
                            }, 800);

                            sectionLinks.removeClass('active'); 
                            $(this).addClass('active'); 
                        }
                    });

                    updateActiveSection();
                });
            })(jQuery);

        </script>

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Single_Program );
