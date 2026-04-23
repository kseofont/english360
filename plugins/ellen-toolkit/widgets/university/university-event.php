<?php
/**
 * Event Widget
*/

namespace Elementor;
class University_Event extends Widget_Base {

	public function get_name() {
        return 'Event';
    }

	public function get_title() {
        return __( 'University Event', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-person';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'event_section',
			[
				'label' => __( 'University Event', 'ellen-toolkit' ),
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
                    'default' => __( 'Upcoming Events', 'ellen-toolkit' ),
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

            $this->add_control(
                'cat_name',
                [
                    'label' => __( 'Choose Category', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ellen_toolkit_get_page_event_cat_el(),
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Event Order By', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'ellen-toolkit' ),
                        'ASC'       => __( 'ASC', 'ellen-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            $this->add_control(
                'count',
                [
                    'label' => __( 'Post Per Page', 'ellen-toolkit' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'description' => __('If you want to see all post, type -1','ellen-toolkit')
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'event_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
            'card_date_color',
            [
                'label'     => __( 'Card Date Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .date .inner' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'card_date_bg_color',
            [
                'label'     => __( 'Card Date Background Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .date .inner' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_date_typography',
                'label'    => __( 'Card Date Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .university-events-card .content .date .inner',
            ]
        );

        $this->add_control(
            'card_time_color',
            [
                'label'     => __( 'Card Time Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .date span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'card_time_bg_color',
            [
                'label'     => __( 'Card Time Background Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .date span' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_time_typography',
                'label'    => __( 'Card Time Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .university-events-card .content .date span',
            ]
        );

        $this->add_control(
            'card_title_color',
            [
                'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .title h3 a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_title_hcolor',
            [
                'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card .content .title h3 a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_title_typography',
                'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .university-events-card .content .title h3',
            ]
        );
        
        $this->add_control(
            'card_bg_color',
            [
                'label'     => __( 'Card Background Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .university-events-card' => 'background: {{VALUE}}',
                ],
            ]
        );
       
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Event Query
        if( $settings['cat_name'] != '' ) {
            $args = array(
                'post_type'     => 'event',
                'posts_per_page'=> $settings['count'],
                'order'         => $settings['order'],
                'tax_query'     => array(
                    array(
                        'taxonomy'      => 'event_cat',
                        'field'         => 'slug',
                        'terms'         => $settings['cat_name'],
                        'hide_empty'    => false
                    )
                )
            );
        } else {
            $args = array(
                'post_type'         => 'event',
                'posts_per_page'    => $settings['count'],
                'order'             => $settings['order']
            );
        }

        $event_array = new \WP_Query( $args );

        ?>

        <!-- Start University Events Area -->
        <div class="university-events-area university-home pb-100">
            <div class="container">
                <div class="section-wrap-title text-center">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <?php if( $settings['sec_content'] != '' ): ?>
                        <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="row justify-content-center g-5">
                    <?php
                        while($event_array->have_posts()):
                        $event_array->the_post();
                        $id              =  get_the_ID();
                        $event_date      =  function_exists('get_field') ? \get_field( 'event_date' ) : '';
                        $event_location  =  function_exists('get_field') ? \get_field( 'event_location' ) : '';
                        $event_time      =  function_exists('get_field') ? \get_field( 'event_time' ) : '';
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="university-events-card">
                                <div class="content">
                                    <div class="date">
                                        <?php if($event_date): ?>
                                            <div class="inner">
                                                <?php echo wp_kses_post ($event_date); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($event_time): ?>
                                            <span><?php echo wp_kses_post ($event_time); ?></span>
                                        <?php endif; ?>
                                       
                                    </div>
                                    <div class="title">
                                        <h3>
                                            <a href="<?php echo esc_url(get_the_permalink($id)); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                                <div class="image">
                                    <a href="<?php echo esc_url(get_the_permalink($id)); ?>">
                                        <img src="<?php echo get_the_post_thumbnail_url( get_the_ID() ); ?>"  alt="Image">
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata();?>
                   
                </div>
            </div>
        </div>
        <!-- End University Events Area -->


        <?php
	}

}

Plugin::instance()->widgets_manager->register( new University_Event );