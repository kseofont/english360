<?php
/**
 * Banner Widget
 */

namespace Elementor;
class Page_Banner extends Widget_Base {

	public function get_name() {
        return 'Page_Banner';
    }

	public function get_title() {
        return __( 'Page Banner', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-banner';
    }

	public function get_categories() {
        return ['ellen-elements'];
    }

	protected function register_controls() {

        // Banner Content 
        $this->start_controls_section(
			'Page_Banner_Area',
			[
				'label' => __( 'Banner Controls', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

            $this->add_control(
                'show_title',
                [
                    'label' => esc_html__( 'Hide/Show Title', 'textdomain' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Show', 'textdomain' ),
                    'label_off' => esc_html__( 'Hide', 'textdomain' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
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
                    'condition' => [
                        'show_title' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'choose_title',
                [
                    'label' 	=> esc_html__( 'Choose Pgae Title Type', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
                        '1'         => esc_html__( 'Get Page Title', 'ellen-toolkit' ),
                        '2'         => esc_html__( 'Write Title', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                    'condition' => [
                        'show_title' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'title',
                [
                    'label'       => __( 'Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Projects', 'ellen-toolkit'),
                    'label_block' => true,
                    'condition' => [
                        'show_title' => 'yes',
                        'choose_title' => '2',
                    ]
                ]
            );

            $this->add_control(
                'show_breadcrumb',
                [
                    'label' => esc_html__( 'Hide/Show Breadcrumb', 'textdomain' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Show', 'textdomain' ),
                    'label_off' => esc_html__( 'Hide', 'textdomain' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
				'page_home_title',
				[
					'label'   => __( 'Page Banner Home Title', 'ellen-toolkit' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __('Home', 'ellen-toolkit'),
                    'label_block' => true,
                    'condition' => [
                        'show_breadcrumb' => 'yes',
                    ]
				]
			);

            $this->add_control(
				'bg_img',
				[
					'label' => __( 'Background Image', 'ellen-toolkit' ),
					'type'  => Controls_Manager::MEDIA,
				]
			);

        $this->end_controls_section();

        // Style Settings
        $this->start_controls_section(
			'page_banner_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_responsive_control(
                'sec_border_padding',
                [
                    'label' => esc_html__( 'Section Padding', 'ellen-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .page-banner-wrap-area ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
				'pg_breadcrumb_color',
				[
					'label'     => __( 'Breadcrumb Color', 'ellen-toolkit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .page-banner-wrap-content .list li a, {{WRAPPER}} .page-banner-wrap-content .list li, {{WRAPPER}} .page-banner-wrap-content .list li::before' => 'color: {{VALUE}}',
					],
                    'condition' => [
                        'show_breadcrumb' => 'yes',
                    ]
				]
			);

            $this->add_control(
				'pg_breadcrumb_h_color',
				[
					'label'     => __( 'Breadcrumb Hover Color', 'ellen-toolkit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .page-banner-wrap-content .list li a:hover' => 'color: {{VALUE}}',
					],
                    'condition' => [
                        'show_breadcrumb' => 'yes',
                    ]
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'pg_breadcrumb_typography',
                    'label'    => __( 'Breadcrumb Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .page-banner-wrap-content .list li a, {{WRAPPER}} .page-banner-wrap-content .list li, {{WRAPPER}} .page-banner-wrap-content .list li::before',
                    'condition' => [
                        'show_breadcrumb' => 'yes',
                    ]
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label'     => __( 'Title Color', 'ellen-toolkit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .page-banner-wrap-content h2, {{WRAPPER}} .page-banner-wrap-content h3, {{WRAPPER}} .page-banner-wrap-content h4, {{WRAPPER}} .page-banner-wrap-content h5, {{WRAPPER}} .page-banner-wrap-content h6' => 'color: {{VALUE}}',
					],
                    'condition' => [
                        'show_title' => 'yes',
                    ]
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'title_typography',
                    'label'    => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .page-banner-wrap-content h2, {{WRAPPER}} .page-banner-wrap-content h3, {{WRAPPER}} .page-banner-wrap-content h4, {{WRAPPER}} .page-banner-wrap-content h5, {{WRAPPER}} .page-banner-wrap-content h6',
                    'condition' => [
                        'show_title' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');

        $title = get_the_title();

		?>
       
        <!-- Start Page Banner Wrap Area -->
        <div class="page-banner-wrap-area jarallax university-home" <?php if($settings['bg_img']['url']): ?> style="background-image: url(<?php echo esc_url($settings['bg_img']['url']); ?>);"  <?php endif; ?>>
            <div class="container-fluid">
                <div class="page-banner-wrap-content">
                    <?php if( $settings['show_breadcrumb'] =='yes'): ?>
                        <?php
                            if ( function_exists('yoast_breadcrumb') ) {
                                yoast_breadcrumb( '<p class="ellen-seo-breadcrumbs" id="breadcrumbs">','</p>' );
                            } else { ?>
                                <ul class="list">
                                    <?php if( $settings['page_home_title']): ?>
                                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo wp_kses_post($settings['page_home_title']); ?></a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html_e( 'Home', 'ellen-toolkit' ); ?></a></li>
                                    <?php endif; ?>
                                        <?php if($settings['choose_title']==2): ?>
                                            <?php if( $settings['title']): ?>
                                                <li class="active"><span><?php echo wp_kses_post($settings['title'] ); ?></span></li>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if( $title != '' ): ?>
                                                <li class="active"><span><?php echo esc_html( $title ); ?></span></li>
                                                <?php else: ?>
                                                    <li class="active"><span><?php echo esc_html_e( 'No Title', 'ellen-toolkit' ); ?></span></li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php ?>                             
                                </ul>
                            <?php
                            }
                        ?>
                    <?php endif; ?>
                    <?php if( $settings['show_title'] =='yes'): ?>
                        <?php if($settings['choose_title']==2): ?>
                            <?php if( $settings['title']): ?>
                                <<?php echo $title_tag;?> class="banner-title-tags"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if( $title != '' ): ?>
                                <<?php echo $title_tag;?> class="banner-title-tags"><?php echo esc_html_e( $title ); ?></<?php echo $title_tag; ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Page Banner Wrap Area -->
        
        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Page_Banner );