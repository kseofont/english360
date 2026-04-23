<?php
/**
 * Platform items Widget
 */

namespace Elementor;
class Ellen_University_Feature extends Widget_Base {

	public function get_name() {
        return 'University_Feature';
    }

	public function get_title() {
        return __( 'University Feature', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-table';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'ellen_university',
			[
				'label' => __( 'University Future Tab Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                        'default' => __( 'Pivot to proactive security', 'ellen-toolkit' ),
                    ]
                );

                $fea_items->add_control(
                    'list_btn_tit', [
                        'label'       => esc_html__( 'List Button Text', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'More About Us', 'ellen-toolkit' ),
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
                'sec_bg_color',
                [
                    'label'     => __( 'Section Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-program-area' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'sec_bg_bt_color',
                [
                    'label'     => __( 'Section Bottom Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-program-area::before' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'list_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-program-card .content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_list_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .university-program-card .content h3',
                ]
            );
            
            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-program-card .content .link-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-program-card .content .link-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-program-card .content .link-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings  = $this->get_settings_for_display();

        $ns_fea_item  = $settings['ns_fea_item'];

    ?>

        <!-- Start University Program Area -->
        <div class="university-program-area university-home">
            <div class="container">
                <div class="row justify-content-center g-4">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="university-program-card">
                                <?php if( !empty( $item['f_img']['url'] ) ){ ?>
                                    <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                <?php } ?>
                                <div class="content">
                                    <?php if($item['list_title'] != ''): ?>
                                        <h3><?php echo wp_kses_post( $item['list_title'] ); ?></h3>
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
        <!-- End University Program Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_University_Feature );