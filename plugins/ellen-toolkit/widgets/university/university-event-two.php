<?php
/**
 * Event Widget
*/

namespace Elementor;
class University_Event_Two extends Widget_Base {

	public function get_name() {
        return 'Event_Two';
    }

	public function get_title() {
        return __( 'University Event Two', 'ellen-toolkit' );
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

            $this->add_control(
				'loc_icon',
				[
					'label' 	=> esc_html__( 'Location Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('bx bx-map', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Get Ticket', 'ellen-toolkit'),
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
            'card_date_color',
            [
                'label'     => __( 'Card Date Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .day' => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_date_typography',
                'label'    => __( 'Card Date Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .single-events-box .date .day',
            ]
        );

        $this->add_control(
            'card_month_color',
            [
                'label'     => __( 'Card Month Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .month' => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_month_typography',
                'label'    => __( 'Card Month Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .single-events-box .date .month',
            ]
        );

        $this->add_control(
            'card_loc_color',
            [
                'label'     => __( 'Card Location Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .content .location' => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_loc_typography',
                'label'    => __( 'Card Location Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .single-events-box .content .location',
            ]
        );

        $this->add_control(
            'card_title_color',
            [
                'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .content h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'card_title_typography',
                'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .single-events-box .content h3',
            ]
        );
        
        $this->add_control(
            'btn_color',
            [
                'label' => __( 'Button Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .default-btn' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .default-btn:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => __( 'Button Background Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .default-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_hover_color',
            [
                'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-events-box .date .default-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typography',
                'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .single-events-box .date .default-btn',
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

       
        <!-- Start Events Area -->
        <div class="events-area pt-100 pb-75">
            <div class="container">
                <div class="row">
                    <?php
                        while($event_array->have_posts()):
                        $event_array->the_post();
                        $id              =  get_the_ID();

		                $event_date = function_exists( 'get_field' ) ? get_field( 'event_date' ) : '';
		                $event_location = function_exists( 'get_field' ) ? get_field( 'event_location' ) : '';
		                $event_time = function_exists( 'get_field' ) ? get_field( 'event_time' ) : '';
                    ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="single-events-box with-boxshadow">
                                <a href="<?php echo esc_url(get_the_permalink($id)); ?>" class="link-btn"></a>
                                <div class="d-flex align-items-center">
                                    <div class="date">
                                        <?php if($event_date): ?>
                                            <?php echo wp_kses_post ($event_date); ?>
                                        <?php endif; ?>
                                        <?php if($settings['button_text']): ?>
                                            <a href="<?php echo esc_url(get_the_permalink($id)); ?>" class="default-btn style-two"><?php echo esc_html($settings['button_text']); ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                  
                                        <?php if($event_location && $settings['loc_icon']): ?>
                                            <span class="location"><i class='<?php echo esc_attr($settings['loc_icon']); ?>'></i><?php echo wp_kses_post ($event_location); ?></span>
                                        <?php endif; ?>

                                        <h3> <?php the_title(); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata();?>
                </div>
            </div>
        </div>
        <!-- End Events Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new University_Event_Two );