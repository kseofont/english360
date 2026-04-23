<?php
/**
 * University Find Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class University_Find extends Widget_Base {

	public function get_name() {
        return 'Find_University';
    }

	public function get_title() {
        return esc_html__( 'University Find', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-site-search';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Banner_Four_Area',
			[
				'label' => esc_html__( 'Banner Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
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
                    'default' => __( 'Study at Ellen', 'ellen-toolkit' ),
                ]
            );

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Content', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__('With more than 32 study areas to explore, and an even wider selection of degrees, what will you choose?', 'ellen-toolkit'),
                    'label_block' => true,
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Search Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Search Now', 'ellen-toolkit'),
                    'label_block' => true,
				]
            );

            $this->add_control(
				'placeholder_text',
				[
					'label' 	=> esc_html__( 'Course Search Placeholder', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('What do you want to learn today?', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'placeholder_icon',
				[
					'label' 	=> esc_html__( 'Course Search Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('flaticon-search', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'link_title',
				[
					'label' 	=> esc_html__( 'Links Title', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('Popular Search:', 'ellen-toolkit'),
				]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'link_title', [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'TECHNOLOGY', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
                'link_type', [
                    'label' => esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        '1'  => esc_html__( 'Link To Category', 'ellen-toolkit' ),
                        '2' => esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                ]
            );
            $repeater->add_control(
                'tutor_link_to_page', [
                    'label' => esc_html__( 'Button Link Courses Cat', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => ellen_toolkit_get_courses_cat_list(),
                ]
            );
            $repeater->add_control(
                'ex_link', [
                    'label'=>esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'=>Controls_Manager:: TEXT,
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );

            $this->add_control(
                'links',
                [
                    'label' => __( 'Add Link', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .section-wrap-title p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .section-wrap-title p',
                ]
            );

            $this->add_control(
				'search_btn_cl',
				[
					'label' => esc_html__( 'Search Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-box .optional-btn' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_cl_hover',
				[
					'label' => esc_html__( 'Search Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-box .optional-btn:hover' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_bg',
				[
					'label' => esc_html__( 'Search Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-box .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'search_btn_bg_hover',
				[
					'label' => esc_html__( 'Search Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-box .optional-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_btn_typography',
                    'label' => esc_html__( 'Banner Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .university-find-box .optional-btn',
                ]
            );

            $this->add_control(
				'link_title_color',
				[
					'label' => esc_html__( 'Link Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-list li span' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'link_title_typography',
                    'label' => esc_html__( 'Link Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .university-find-list li span',
                ]
            );

            $this->add_control(
				'main_link_title',
				[
					'label' => esc_html__( 'Link Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-list li a' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'main_link_h_title',
				[
					'label' => esc_html__( 'Link Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-list li a:hover' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'main_link_bg_title',
				[
					'label' => esc_html__( 'Link Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-list li a' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'main_link_h_bg_title',
				[
					'label' => esc_html__( 'Link Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-find-list li a:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'main_link_title_typography',
                    'label' => esc_html__( 'Link Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-find-list li a',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

		
        $post_type 	= '';
        if ( function_exists('tutor') ) {
            $post_type = 'courses';
            $category = 'course-category';
        }elseif( class_exists('LearnPress') ){
            $post_type = 'lp_course';
            $category = 'course_category';
        }
        ?>
            
            <!-- Start University Find Area -->
            <div class="university-find-area university-home pt-100">
                <div class="container">
                    <div class="section-wrap-title text-center">
                       
                        <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                        <?php if( $settings['content'] != '' ): ?>
                            <p><?php echo wp_kses_post( $settings['content'] ); ?></p>
                        <?php endif; ?>
                        
                    </div>

                    <?php if($settings['placeholder_text'] != '' || $settings['button_text'] != ''): ?>
                        <form class="university-find-box" method="get" action="<?php echo site_url( '/' ); ?>">
                            <input type="text" name="s" class="input-search" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>">
                            <input type="hidden" value="course" name="ref" />
                            <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>">
                            <?php if($settings['placeholder_icon']): ?>
                                <div class="icon"><i class="<?php echo esc_attr($settings['placeholder_icon']); ?>"></i></div>
                            <?php endif; ?>

                            <?php if($settings['button_text']): ?>
                                <button type="submit" class="optional-btn">
                                    <?php echo esc_html($settings['button_text']); ?>
                                </button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>

                    <ul class="university-find-list">
                        <li><span><?php echo esc_html( $settings['link_title'] ); ?></span></li>
                        <?php foreach( $settings['links'] as $link ): ?>
                            <?php
                            if ($link['link_type'] == 1):
                                $term = get_term_by('name', $link['tutor_link_to_page'], $category);
                                
                                if ($term && !is_wp_error($term)) {
                                    // Cat Link
                                    $title_link = get_category_link($term->term_id);
                                } else {
                                    // Fallback if term doesn't exist
                                    $title_link = '#';
                                }
                            else:
                                $title_link = $link['ex_link'];
                            endif;
                            ?>
                            <li><a href="<?php echo esc_url( $title_link ); ?>"><?php echo esc_html( $link['link_title'] ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!-- End University Find Area -->


        <?php
	}

}

Plugin::instance()->widgets_manager->register( new University_Find );