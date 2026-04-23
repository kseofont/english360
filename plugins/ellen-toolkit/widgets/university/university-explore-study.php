<?php
/**
 * Mega Menu Content Widget
 */

namespace Elementor;
class Explore_Study extends Widget_Base {

	public function get_name() {
        return 'university_explore_study';
    }

	public function get_title() {
        return __( 'University Explore Study', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-mega-menu';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Bharat_Section',
			[
				'label' => __( 'Explore Study Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
                    'default' => __( 'Explore Study Areas', 'ellen-toolkit' ),
                ]
            );

            $menu_item = new Repeater();

                $menu_item->add_control(
                    'icon1',
                    [
                        'label' => esc_html__( 'List Icon', 'ellen-toolkit' ),
                        'type'		=> Controls_Manager:: MEDIA,
                    ]
                );

                $menu_item->add_control(
                    'menu_tit', [
                        'label'       => esc_html__( 'List Item', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Architecture, Design and Planning', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $menu_item->add_control(
                    'link_type',
                    [
                        'label'         => esc_html__('List Link Type', 'ellen-toolkit'),
                        'type'          => Controls_Manager::SELECT,
                        'label_block'   => true,
                        'options' => [
                            '1'   => esc_html__('Link To Page', 'ellen-toolkit'),
                            '2'   => esc_html__('Link To Programs', 'ellen-toolkit'), 
                            '3'   => esc_html__('External Link', 'ellen-toolkit'),
                        ],
                    ]
                );
                
                $menu_item->add_control(
                    'link_to_page',
                    [
                        'label'         => esc_html__('List Link Page', 'ellen-toolkit'),
                        'type'          => Controls_Manager::SELECT,
                        'label_block'   => true,
                        'options'       => ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );

                $menu_item->add_control(
                    'link_to_program',
                    [
                        'label'         => esc_html__('List Link Program', 'ellen-toolkit'),
                        'type'          => Controls_Manager::SELECT,
                        'label_block'   => true,
                        'options'       => ellen_toolkit_get_program_as_list(), 
                        'condition' => [
                            'link_type' => '2',
                        ]
                    ]
                ); 
                
                $menu_item->add_control(
                    'ex_link',
                    [
                        'label'         => esc_html__('List External Link', 'ellen-toolkit'),
                        'type'          => Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '3',
                        ]
                    ]
                );
                
            $this->add_control(
                'menu_items',
                [
                    'label'  => esc_html__( 'Add List Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $menu_item->get_controls(),
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
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-find-items .find-tags' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-find-items .find-tags',
                ]
            );

            $this->add_control(
                'list_item_color',
                [
                    'label' => esc_html__( 'List Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-find-items .items li span a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_h_color',
                [
                    'label' => esc_html__( 'List Item Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-find-items .items li span a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'list_item_typography',
                    'label' => __( 'List Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-find-items .items li span a',
                ]
            );

            $this->add_control(
                'list_item_br_color',
                [
                    'label' => esc_html__( 'List Item Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-find-items .items li' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_h_br_color',
                [
                    'label' => esc_html__( 'List Item Hover Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-find-items .items li::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <!-- Start University Find Area -->
        <div class="university-find-area university-home pb-100">
            <div class="container">
                <div class="university-find-items">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="find-tags"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <div class="row justify-content-center g-5">
                        <div class="col-lg-6 col-md-12">
                            <ul class="items">
                                <?php if ( $settings['menu_items'] !='' ) :
                                    $i=1; foreach ( $settings['menu_items'] as $item_menu ) : 
                                    
                                    // Get Button Link
                                    if ($item_menu['link_type'] == 1) {
                                        $page = get_post($item_menu['link_to_page']);
                                        $link = ($page && $page->post_status != 'trash') ? get_page_link($page->ID) : '#';
                                    } elseif ($item_menu['link_type'] == 2) {
                                        $page = get_post($item_menu['link_to_program']);
                                        $link = ($page && $page->post_status != 'trash') ? get_page_link($page->ID) : '#';
                                    } else {
                                        $link = !empty($item_menu['ex_link']) ? $item_menu['ex_link'] : '#';
                                    }

                                    if($i<=5):

                                ?>
                                <li>
                                    <?php if( !empty( $item_menu['icon1']['url'] ) ){ ?>
                                        <img src="<?php echo esc_url( $item_menu['icon1']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                    <?php } ?>
                                    
                                    <span>
                                        <a href="<?php echo esc_url( $link ); ?>">
                                            <?php echo esc_html( $item_menu['menu_tit'] ); ?>
                                        </a>
                                    </span>
                                </li>
                                <?php 
                                    endif;
                                    $i++;
                                    endforeach;
                                endif; ?>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <ul class="items">
                                <?php if ( $settings['menu_items'] !='' ) :
                                    $i=1; foreach ( $settings['menu_items'] as $item_menu ) : 
                                    
                                    // Get Button Link
                                    $link = '#'; 
                                    if ($item_menu['link_type'] == 1) {
                                        $page = get_post($item_menu['link_to_page']);
                                        if ($page && $page->post_status != 'trash') {
                                            $link = get_page_link($page->ID);
                                        }
                                    } elseif ($item_menu['link_type'] == 2) {
                                        $page = get_post($item_menu['link_to_program']);
                                        if ($page && $page->post_status != 'trash') {
                                            $link = get_page_link($page->ID);
                                        }
                                    } else {
                                        $link = $item_menu['ex_link'];
                                    }

                                    if($i>=6):

                                ?>
                                <li>
                                    <?php if( !empty( $item_menu['icon1']['url'] ) ){ ?>
                                        <img src="<?php echo esc_url( $item_menu['icon1']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                    <?php } ?>
                                    
                                    <span>
                                        <a href="<?php echo esc_url( $link ); ?>">
                                            <?php echo esc_html( $item_menu['menu_tit'] ); ?>
                                        </a>
                                    </span>
                                </li>
                                <?php 
                                    endif;
                                    $i++;
                                    endforeach;
                                endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End University Find Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Explore_Study );