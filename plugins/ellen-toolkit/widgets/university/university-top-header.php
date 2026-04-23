<?php
/**
 * Top Header Widget
 */

namespace Elementor;
class University_TopHeader extends Widget_Base {

	public function get_name() {
        return 'UniversityTopHeader';
    }

	public function get_title() {
        return __( 'University Top Header', 'ellen-toolkit' );
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

            $this->add_control(
                'left_tit',
                [
                    'label'   => __( 'Left Content', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::TEXTAREA,
                    'default' => __('<strong>Celebrating 50 Years</strong> of Excellence at Ellen in 2025!', 'ellen-toolkit'),
                ]
            );

            $list_item = new Repeater();

                $list_item->add_control(
                    'list_tit', [
                        'label'       => esc_html__( 'List Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'About Us', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $list_item->add_control(
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
    
                $list_item->add_control(
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
    
                $list_item->add_control(
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
                'list_items',
                [
                    'label'  => esc_html__( 'Add Info Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $list_item->get_controls(),
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
                'tophead_bg',
                [
                    'label' => esc_html__( 'Top Header Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .top-header-area' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
                'tophead_padding', [
                    'label' => __( 'Top Header Padding', 'ellen-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .top-header-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',

                    ],
                ]
            );

            $this->add_control(
                'left_title_color',
                [
                    'label' => esc_html__( 'Top Header Left Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .top-header-left span' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'left_typography',
                    'label' => __( 'Top Header Left Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .top-header-left span',
                ]
            );

            $this->add_control(
                'list_item_color',
                [
                    'label' => esc_html__( 'List Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .top-header-right li a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_h_color',
                [
                    'label' => esc_html__( 'List Item Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .top-header-right li a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'list_item_typography',
                    'label' => __( 'List Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .top-header-right li a',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <!-- Start Top Header Area -->
        <div class="top-header-area university-home">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <?php if ( $settings['left_tit']) : ?>
                        <div class="col-xl-6 col-md-12">
                            <div class="top-header-left">
                                <span><?php echo wp_kses_post( $settings['left_tit'] ); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-xl-6 col-md-12">
                        <ul class="top-header-right">
                            <?php $i=1; foreach( $settings['list_items'] as $item ): 
                    
                                // Get Button Link
                                if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                                    $link = get_page_link( $item['link_to_page'] );
                                }elseif($item['link_type'] == 2) {
                                    $link = $item['ex_link'];
                                }else{
                                    $link = '';
                                }
                            ?>

                                <?php if ( $item['list_tit'] && $link) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $item['list_tit'] ); ?></a>
                                    </li>
                                <?php endif; ?>

                            <?php $i++; endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Top Header Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new University_TopHeader );