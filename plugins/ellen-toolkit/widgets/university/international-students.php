<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class International_Students extends Widget_Base {

	public function get_name() {
        return 'InternationalStudents';
    }

	public function get_title() {
        return __( 'International Students', 'ellen-toolkit' );
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
				'label' => __( 'International Students Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                    'default' => __( 'International Students', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'You might design a new living estate to meet the demands of a growing regional area. You could work with community groups to ensure sacred sites are protected while championing future growth. Perhaps you might lead the creation of the next smart city, providing invaluable data insights, planning knowledge and meaningful solutions that balance sustainability with urban development.', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Choose Columns', 'medak-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( '1', 'medak-toolkit' ),
                        '2'   => __( '2', 'medak-toolkit' ),
                        '3'   => __( '3', 'medak-toolkit' ),
                        '4'   => __( '4', 'medak-toolkit' ),
                    ],
                    'default' => '4',
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
                        'default' => __( 'Find Your degree', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_content',
                    [
                        'label'   => __( 'Content', 'ellen-toolkit' ),
                        'type'    => Controls_Manager::TEXTAREA,
                        'default' => __( 'Your journey starts here. Choose from more than 159 program options, check the admission requirements and apply online.', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_btn_tit', [
                        'label'       => esc_html__( 'List Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Search Program', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $fea_items->add_control(
                    'list_btn_icon', [
                        'label'       => esc_html__( 'List Button Icon', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'bx bx-chevron-right', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $fea_items->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'List Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $fea_items->add_control(
                    'link_to_page',
                    [
                        'label' 		=> esc_html__( 'List Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );
    
                $fea_items->add_control(
                    'ex_link',
                    [
                        'label'		=> esc_html__('List Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '2',
                        ]
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
			'university_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .international-students-content h2, {{WRAPPER}} .international-students-content h3, {{WRAPPER}} .international-students-content h1, {{WRAPPER}} .international-students-content h4, {{WRAPPER}} .international-students-content h5, {{WRAPPER}} .international-students-content h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .international-students-content h2, {{WRAPPER}} .international-students-content h3, {{WRAPPER}} .international-students-content h1, {{WRAPPER}} .international-students-content h4, {{WRAPPER}} .international-students-content h5, {{WRAPPER}} .international-students-content h6',
                ]
            );

            $this->add_control(
				'sec_content_color',
				[
					'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .international-students-content p' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .international-students-content p',
                ]
            );

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .international-students-card .content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .international-students-card .content h3',
                ]
            );

            $this->add_control(
                'cd_content_color',
                [
                    'label'     => __( 'Card Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .international-students-card .content p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_content',
                    'label'    => __( 'Card Content Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .international-students-card .content p',
                ]
            );

            $this->add_control(
                'cd_btn_color',
                [
                    'label'     => __( 'Card Button Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .international-students-card .content .link-btn' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_btn_h_color',
                [
                    'label'     => __( 'Card Button Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .international-students-card .content .link-btn:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_btn',
                    'label'    => __( 'Card Button Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .international-students-card .content .link-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        
        // Card Columns
        $columns = $settings['columns'];
        if ($columns == '1') {
            $column = 'col-lg-12 col-md-6';
        }elseif ($columns == '2') {
            $column = 'col-lg-6 col-md-6';
        }elseif ($columns == '3') {
            $column = 'col-lg-4 col-md-6';
        }elseif ($columns == '4') {
            $column = 'col-xl-3 col-lg-6 col-md-6';
        }

        $ns_fea_item  = $settings['ns_fea_item'];

    ?>

        <!-- Start International Students Area -->
        <div class="international-students-area university-home ptb-100">
            <div class="container">
                <div class="international-students-content">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <?php if( $settings['sec_content'] != '' ): ?>
                        <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="row justify-content-center g-5">
                    <?php $i=1; foreach( $ns_fea_item as $item  ):  
                        
                        // Get Button Link
                        if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                            $link = get_page_link( $item['link_to_page'] );
                        }elseif($item['link_type'] == 2) {
                            $link = $item['ex_link'];
                        }else{
                            $link = '';
                        }
                        
                    ?>
                        <div class="<?php echo esc_attr( $column );?>">
                            <div class="international-students-card">
                                
                                <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                    <div class="image">
                                        <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                    </div>
                                <?php } ?>
                                <div class="content">
                                    <?php if($item['list_title'] != ''): ?>
                                        <h3><?php echo wp_kses_post( $item['list_title'] ); ?></h3>
                                    <?php endif; ?>
                                    <?php if($item['list_content'] != ''): ?>
                                        <p><?php echo wp_kses_post( $item['list_content'] ); ?></p>
                                    <?php endif; ?>
                                    <?php if($item['list_btn_tit'] && $link): ?>
                                        <a href="<?php echo esc_url( $link ); ?>" class="link-btn"><?php echo wp_kses_post( $item['list_btn_tit'] ); ?> <?php if($item['list_btn_icon']): ?><i class='<?php echo esc_attr( $item['list_btn_icon'] ); ?>'></i> <?php endif; ?></a>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php 
                        $i++; endforeach; 
                    ?>
                   
                </div>
            </div>
        </div>
        <!-- End International Students Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new International_Students );