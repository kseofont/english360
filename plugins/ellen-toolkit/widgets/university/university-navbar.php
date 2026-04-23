<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Ellen_Bootstrap_Navwalker;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class University_Navbar extends Widget_Base {

    public function get_name() {
        return 'ellen-navbar-university';
    }

    public function get_title() {
        return __( 'Navbar_University', 'ellen-toolkit' );
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_keywords() {
        return [ 'University Menu', 'Navigation' ];
    }

    public function get_categories() {
        return [ 'ellen-elements' ];
    }

    protected function register_controls() {

        // Menu
        $this->start_controls_section(
            'menu_settings',
            [
                'label' => __( 'Menu', 'ellen-toolkit' ),
            ]
        );

            $this->add_control(
                'menu', [
                    'label' => __( 'Menu', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ellen_get_menu_array()
                ]
            );
            $this->add_control(
				'navbar_bg',
				[
					'label' => esc_html__( 'Navbar Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-navbar' => 'background-color: {{VALUE}} !important',
					],
				]
            );

            $this->add_control(
				'sticky_navbar_bg',
				[
					'label' => esc_html__( 'Sticky Navbar Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-navbar.is-sticky' => 'background-color: {{VALUE}} !important',
					],
				]
            );

            $this->add_control(
                'sticky_navbar_box_shadow',
                [
                    'label' => esc_html__( 'Sticky Navbar Box Shadow', 'ellen-toolkit' ),
                    'type' => Controls_Manager::BOX_SHADOW,
                    'selectors' => [
                        '{{SELECTOR}} .university-navbar.is-sticky' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
                    ],
                ]
            );

            $this->add_control(
                'sec_padding', [
                    'label' => __( 'Navbar Padding', 'ellen-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .university-navbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',

                    ],
                ]
            );

        $this->end_controls_section();

        // Logo settings
        $this->start_controls_section(
            'section_logo',
            [
                'label' => __( 'Logo', 'ellen-toolkit' ),
            ]
        );

            $this->add_control(
                'main_logo',
                [
                    'label' => __( 'Main Logo', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'logomax_width',
                [
                    'label' => __( 'Max Width', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'rem' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ellen-nav .navbar .navbar-brand img' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Mobile Logo
        $this->start_controls_section(
            'section_mobile_logo',
            [
                'label' => __( 'Mobile Logo', 'ellen-toolkit' ),
            ]
        );

            $this->add_control(
                'mobile_logo',
                [
                    'label' => __( 'Main Logo', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'mobile_logomax_width',
                [
                    'label' => __( 'Max Width', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'rem' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ellen-responsive-menu>.logo>a>img' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
				'mobile_menu_bg',
				[
					'label' => esc_html__( 'Mobile Menu Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-navbar .ellen-responsive-nav .mean-container a.meanmenu-reveal' => 'background-color: {{VALUE}} !important',
					],
				]
            );

        $this->end_controls_section();

        // Layout Settings
        $this->start_controls_section(
            'layout_settings',
            [
                'label' => __( 'Layout Settings', 'ellen-toolkit' ),
            ]
        );

            $this->add_control(
                'nav_box_layout', [
                    'label' => __( 'Navbar box layout', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'container-fluid',
                    'options' => [
                        'container' => esc_html__( 'Wide', 'ellen-toolkit' ),
                        'container-fluid' => esc_html__( 'Full Width', 'ellen-toolkit' ),
                    ]
                ]
            );

            $this->add_control(
                'menu_alignment', [
                    'label' => __( 'Menu Alignment', 'ellen-toolkit' ),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => 'right',
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ellen-toolkit' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ellen-toolkit' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ellen-toolkit' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ]
                ]
            );

        $this->end_controls_section();

        // Navbar Settings
        $this->start_controls_section(
            'navbar_settings',
            [
                'label' => __( 'Navbar Settings', 'ellen-toolkit' ),
            ]
        );
            $this->add_control(
                'hide_is_sticky',
                [
                    'label' => __( 'Hide Sticky Header', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', 'ellen-toolkit' ),
                    'label_off' => __( 'No', 'ellen-toolkit' ),
                    'return_value' => 'yes',
                    'default' => 'no'
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'label' => __( 'Menu Item Typography', 'ellen-toolkit' ),
                    'name' => 'typography_menu_item',
                    'selector' => '{{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link',
                ]
            );
            $this->add_control(
				'menu_item_color',
				[
					'label' => esc_html__( 'Menu Item Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link, {{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .dropdown-menu li a, {{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a, {{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link.dropdown-icon::after' => 'color: {{VALUE}} !important',
					],
				]
            );
            $this->add_control(
				'menu_item_hover_color',
				[
					'label' => esc_html__( 'Menu Item Active/Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link:hover, {{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link.active, {{WRAPPER}} .university-navbar .ellen-nav .navbar .navbar-nav .nav-item .nav-link:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item a.active, {{WRAPPER}} .navbar .navbar-nav .nav-item:hover a, {{WRAPPER}}  .navbar .navbar-nav .nav-item.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li.active a, {{WRAPPER}}  .navbar .navbar-nav .nav-item .dropdown-menu li.active a, {{WRAPPER}} .navbar .navbar-nav .nav-item.active .nav-link.dropdown-icon::after, {{WRAPPER}} .navbar .navbar-nav .nav-item:hover .nav-link.dropdown-icon::after' => 'color: {{VALUE}} !important',
					],
				]
            );

           
            $this->add_control(
				'dropdown_menu_bg_color',
				[
					'label' => esc_html__( 'Dropdown Menu Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ellen-nav .navbar .navbar-nav .nav-item .dropdown-menu' => 'background-color: {{VALUE}} !important',
					],
				]
            );
           
            $this->add_control(
				'mobile_menu_item_color',
				[
					'label' => esc_html__( 'Mobile Menu Item Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mean-container .mean-nav ul li a, {{WRAPPER}} .mean-container .mean-nav ul li li a' => 'color: {{VALUE}} !important',
					],
				]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'label' => __( 'Mobile Menu Item Typography', 'ellen-toolkit' ),
                    'name' => 'typography_mobile_menu_item',
                    
                    'selector' => '{{WRAPPER}} .mean-container .mean-nav ul li a, {{WRAPPER}} .mean-container .mean-nav ul li li a',
                ]
            );
            $this->add_control(
				'mobile_menu_item_hover_color',
				[
					'label' => esc_html__( 'Mobile Menu Item Active/Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mean-container .mean-nav ul li a:hover, {{WRAPPER}} .mean-container .mean-nav ul li li a:hover, {{WRAPPER}} .ellen-responsive-nav .mean-container a.meanmenu-reveal' => 'color: {{VALUE}} !important',
						'{{WRAPPER}} .ellen-responsive-nav .mean-container a.meanmenu-reveal span' => 'background: {{VALUE}} !important',
						'{{WRAPPER}} .others-option-for-responsive .dot-menu .inner .circle' => 'background-color: {{VALUE}} !important',
					],
				]
            );

        $this->end_controls_section();

        // Addisonian Settings
        $this->start_controls_section(
            'navbar_optional_settings',
            [
                'label' => __( 'Search Option Settings', 'ellen-toolkit' ),
            ]
        );


            $this->add_control(
                'is_search',
                [
                    'label' => __( 'Enable Search Option', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'             => __( 'Yes', 'ellen-toolkit' ),
                        '2'            => __( 'NO', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );


            $this->add_control(
                'search_icon', [
                    'label'   => __( 'Search Icon', 'ellen-toolkit' ),
                   'type'  => Controls_Manager::TEXT,
                    'default' => __('bx bx-search', 'ellen-toolkit'),
                    'condition' => [
                        'is_search' => '1',
                    ]
                ]
            );

            $this->add_control(
                'pr_text',
                [
                    'label'   => __( 'placeholder Text', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::TEXT,
                    'default' => __('Search', 'ellen-toolkit'),
                    'condition' => [
                        'is_search' => '1',
                    ]
                ]
            );
           
           

            $this->add_control(
                'search_color',
                [
                    'label' => esc_html__( 'Search Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-navbar .ellen-nav .navbar .others-option .option-item .search-box-popup i' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_h_color',
                [
                    'label' => esc_html__( 'Search Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-navbar .ellen-nav .navbar .others-option .option-item .search-box-popup i:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_bg_color',
                [
                    'label' => esc_html__( 'Search Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-navbar .ellen-nav .navbar .others-option .option-item .search-box-popup i' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_h_bg_color',
                [
                    'label' => esc_html__( 'Search Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-navbar .ellen-nav .navbar .others-option .option-item .search-box-popup i:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'search_typography',
                    'label' => __( 'Search Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-navbar .ellen-nav .navbar .others-option .option-item .search-box-popup i',
                ]
            );

            $this->add_control(
                'search_pop_bg_color',
                [
                    'label' => esc_html__( 'Search Popup Form Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-overlay-popup .search-overlay-form form .input-search' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_btn_bg_color',
                [
                    'label' => esc_html__( ' Popup Search Button Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-overlay-popup .search-overlay-form form button' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_btn_h_bg_color',
                [
                    'label' => esc_html__( ' Popup Search Button Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-overlay-popup .search-overlay-form form button:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_btn_color',
                [
                    'label' => esc_html__( ' Popup Search Button Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-overlay-popup .search-overlay-form form button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'search_btn_h_color',
                [
                    'label' => esc_html__( ' Popup Search Button Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .search-overlay-popup .search-overlay-form form button:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'search_btn_typography',
                    'label' => __( 'Popup Search Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .search-overlay-popup .search-overlay-form form button',
                ]
            );
           
        $this->end_controls_section();

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings();

        $logo           = !empty($settings['main_logo']['url']) ? $settings['main_logo']['url'] : '';
        $mobile_logo    = !empty($settings['mobile_logo']['url']) ? $settings['mobile_logo']['url'] : '';

        switch ( $settings['menu_alignment'] ) {
            case 'right':
                $ul_class = 'navbar-nav ml-auto';
                break;
            case 'left':
                $ul_class = 'navbar-nav mr-auto left'; 
                break;
            case 'center':
                $ul_class = 'navbar-nav mx-auto';
                break;
        }

        $hide_adminbar 				= 'ellen-hide-adminbar';

        ?>

        <div class="optional-header-with-position-absolute university-home">

            <!-- Start Navbar Area -->
            <div class="navbar-area university-navbar <?php if ( is_user_logged_in() ) { echo esc_attr( $hide_adminbar ); } ?>  <?php if( $settings['hide_is_sticky'] == 'yes' ): ?> no-sticky <?php endif; ?>">
                <div class="ellen-responsive-nav">
                    <div class="container">
                        <div class="ellen-responsive-menu">
                            <div class="logo">
                                <a href="<?php echo esc_url( home_url( '/' ) );?>"  class="logo d-inline-block">
                                    <?php if( $mobile_logo != '' ): ?>
                                        <img src="<?php echo esc_url( $mobile_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                    <?php elseif( $logo != '' ): ?>
                                        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                    <?php else: ?>
                                        <h2><?php bloginfo( 'name' ); ?></h2>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ellen-nav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php if( $logo != '' ): ?>
                                    <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                <?php else: ?>
                                    <h2><?php bloginfo( 'name' ); ?></h2>
                                <?php endif; ?>
                            </a>
                            <div class="collapse navbar-collapse mean-menu">
                               
                                <?php
                                    $menu = !empty($settings['menu']) ? $settings['menu'] : '';
                                    $primary_nav_arg = [
                                        'menu'            => $menu,
                                        'theme_location'  => 'primary',
                                        'container'       => null,
                                        'menu_class'      => $ul_class,
                                        'depth'           => 3,
                                        'walker'          => new Ellen_Bootstrap_Navwalker(),
                                        'fallback_cb'     => 'Ellen_Bootstrap_Navwalker::fallback',
                                    ];
                                    if(has_nav_menu('primary')){ wp_nav_menu( $primary_nav_arg );  }
                                ?>

                                
                                <?php if( $settings['is_search'] == '1' ) { ?>
                                    <?php if($settings['search_icon']): ?> 
                                        <div class="others-option d-flex align-items-center">
                                            <div class="option-item">
                                                <div class="search-box-popup">
                                                    <i class='<?php echo esc_attr( $settings['search_icon'] ); ?>'></i>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?> 
                                <?php } ?>
                            </div>
                        </nav>
                    </div>
                </div>
                <?php if( $settings['is_search'] == '1' ) { ?>
                    <?php if($settings['search_icon']): ?> 
                        <div class="others-option-for-responsive">
                            <div class="container">
                                <div class="dot-menu">
                                    <div class="inner">
                                        <div class="circle circle-one"></div>
                                        <div class="circle circle-two"></div>
                                        <div class="circle circle-three"></div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="option-inner">
                                        <div class="option-item">
                                
                                            <form class="search-box" role="search" method="get" id="search2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                                <input type="search" class="input-search" value="<?php echo get_search_query(); ?>" name="s" id="s2"  placeholder="<?php echo esc_html($settings['pr_text']); ?>">
                                                <?php if($settings['search_icon']): ?> 
                                                    <button type="submit"><i class="<?php echo esc_attr( $settings['search_icon'] ); ?>"></i></button>
                                                <?php endif; ?> 
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?> 
                <?php } ?>
            </div>
            <!-- End Navbar Area -->

        </div>


        <!-- Search Overlay -->
        <?php if( $settings['is_search'] == '1' ) { ?>
            <?php if($settings['pr_text']): ?>
                <div class="search-overlay-popup">
                    <div class="d-table">
                        <div class="d-table-cell">
                            <div class="search-overlay-layer"></div>
                            <div class="search-overlay-layer"></div>
                            <div class="search-overlay-layer"></div>
                            
                            <div class="search-overlay-close">
                                <span class="search-overlay-close-line"></span>
                                <span class="search-overlay-close-line"></span>
                            </div>

                            <div class="search-overlay-form">
                                <form role="search" method="get" id="search1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <input type="search" class="input-search" value="<?php echo get_search_query(); ?>" name="s" id="s1"  placeholder="<?php echo esc_html($settings['pr_text']); ?>">
                                    <?php if($settings['search_icon']): ?> 
                                        <button type="submit"><i class='<?php echo esc_attr( $settings['search_icon'] ); ?>'></i></button>
                                    <?php endif; ?>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?> 
            <!-- End Search Overlay -->
        <?php } ?>

        <?php
    }

}
Plugin::instance()->widgets_manager->register( new University_Navbar );