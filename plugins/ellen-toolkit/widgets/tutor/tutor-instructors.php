<?php
/**
 * Instructors Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Instructors extends Widget_Base {

	public function get_name() {
        return 'Instructors_Health';
    }

	public function get_title() {
        return __( 'Health Instructors', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-person';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
	}
	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Instructors',
			[
				'label' => __( 'Ellen Instructors', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('INSTRUCTOR', 'ellen-toolkit'),
                    'label_block' => true,
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
                ]
            );

            $this->add_control(
                'title',
                [
                    'label'       => __( 'Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Meet our Instructors', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'count',
                [
                    'label' => __( 'Count Instructors', 'ellen-toolkit' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 8,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Order By', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'ellen-toolkit' ),
                        'ASC'       => __( 'ASC', 'ellen-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            $this->add_control(
				'view_text',
				[
					'label' 	=> esc_html__( 'View Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('View Details', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('View All Articles', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'button_icon',
				[
					'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('bx bx-chevron-right', 'ellen-toolkit'),
				]
            );

            $this->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                ]
            );

            $this->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'link_type' => '1',
                    ]
                ]
            );

            $this->add_control(
                'ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'        => Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'separator'   => 'before',
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'team_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title .sub',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title .title-tgas',
                ]
            );

            $this->add_control(
                'name_color',
                [
                    'label' => __( 'Name Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-instructors-items .item .instructors-content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'name_hcolor',
                [
                    'label' => __( 'Name Hover/Active Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-instructors-items .item:hover .instructors-content h3 a, {{WRAPPER}} .hwf-instructors-items .item.active .instructors-content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => __( 'Name Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-instructors-items .item .instructors-content h3 a',
                ]
            );

            $this->add_control(
                'designation_color',
                [
                    'label' => __( 'Designation Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-instructors-items .item .instructors-content h3 span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'designation_typography',
                    'label' => __( 'Designation Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-instructors-items .item .instructors-content h3 span',
                ]
            );

            $this->add_control(
                'br_color',
                [
                    'label' => __( 'Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-instructors-items .item' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
				'view_btn_color',
				[
					'label' => __( 'View Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item .instructors-btn .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'view_btn_hover_color',
				[
					'label' => __( 'View Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item:hover .instructors-btn .optional-btn, {{WRAPPER}} .hwf-instructors-items .item.active .instructors-btn .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'view_btn_bg_color',
				[
					'label' => __( 'View Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item .instructors-btn .optional-btn' => 'background-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'view_btn_hover_bg_color',
				[
					'label' => __( 'View Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item:hover .instructors-btn .optional-btn, {{WRAPPER}} .hwf-instructors-items .item.active .instructors-btn .optional-btn' => 'background-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'view_btn_br_color',
				[
					'label' => __( 'View Button Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item .instructors-btn .optional-btn' => 'border-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'view_btn_hover_br_color',
				[
					'label' => __( 'View Button Hover Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-instructors-items .item:hover .instructors-btn .optional-btn, {{WRAPPER}} .hwf-instructors-items .item.active .instructors-btn .optional-btn' => 'border-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'view_btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .instructors-link-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .instructors-link-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .instructors-link-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        // Get Banner Button Link
        $target     = '';
        $nofollow   = '';
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link       = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $target     = $settings['ex_link']['is_external'] ? ' target="_blank"' : '';
		    $nofollow   = $settings['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
            $link       = $settings['ex_link']['url'];
        }else{
            $link = '';
        }

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ( function_exists('tutor') ) {
            $args = array(
                'role'          => 'tutor_instructor',
                'order'         => $settings['order'],
                'number'         => $settings['count'],
                'paged'         => $paged, 
            );
            $user_query     = new \WP_User_Query( $args );
            $instructors    = $user_query->get_results();

            // Display pagination links
            $total_users = $user_query->get_total();
            $total_pages = ceil($total_users / $settings['count']);

        ?>
           

            <!-- Start HWF Instructors Area -->
            <div class="hwf-instructors-area health-wellness-fitness-home pb-100">
                <div class="container">
                    <div class="section-wrap-title text-center">
                        <?php if( $settings['top_title']): ?>
                            <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                        <?php endif; ?>
                        <?php if( $settings['title']): ?>
                            <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                        <?php endif; ?>
                    </div>
                    <div class="hwf-instructors-items">
                        <?php if ( ! empty( $instructors ) ) {
                            $i=1; foreach ( $instructors as $instructor ) {
                            $profile_url        = tutor_utils()->profile_url( $instructor->ID );
                            $profile_url		= str_replace("?view=student","", $profile_url);
                            $user               = tutor_utils()->get_tutor_user( $instructor->ID );
                            $image              = wp_get_attachment_image($user->tutor_profile_photo, array('1272', '1305'));
                            $job_title          = get_user_meta( $instructor->ID, '_tutor_profile_job_title', true );
                            $total_courses      = ellen_get_total_courses_by_instructor( $instructor->ID );
                            $total_students     = tutor_utils()->get_total_students_by_instructor($instructor->ID);
                            $instructor_rating  = tutor_utils()->get_instructor_ratings( $instructor->ID );

                            $user_id = $instructor->ID;
                        ?>
                        <div class="item border-wrap" id="instructors-element<?php echo esc_attr($i); ?>">
                            <div class="instructors-content">
                                <h3>
                                    <a href="<?php echo esc_url($profile_url); ?>"><?php echo esc_html( $instructor->display_name ); ?></a>
                                    <?php if($job_title): ?>
                                        <span><?php echo esc_html( $job_title ); ?></span>
                                    <?php endif; ?>
                                </h3>
                            </div>

                            <?php if( $settings['view_text']): ?>
                                <div class="instructors-btn">
                                    <a href="<?php echo esc_url($profile_url); ?>" class="optional-btn extra-radius"><?php echo wp_kses_post($settings['view_text']); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="image">
                                <?php if($image): ?>
                                    <?php echo wp_kses_post($image); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        $i++;
                            }
                        } ?>
                        
                    </div>

                    <?php if($settings['button_text'] && $link): ?>
                        <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="instructors-link-btn"><?php echo esc_html($settings['button_text']); ?> <?php if($settings['button_icon']): ?><i class='<?php echo esc_attr($settings['button_icon']); ?>'></i><?php endif; ?></a>
                    <?php endif; ?>
                    
                </div>
            </div>
            <!-- End HWF Instructors Area -->

            <?php
        }
	}

}

Plugin::instance()->widgets_manager->register( new Health_Instructors );