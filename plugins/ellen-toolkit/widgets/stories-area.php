<?php
/**
 * Stories Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Stories_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_Stories_Area';
    }

	public function get_title() {
        return esc_html__( 'Stories Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-menu-toggle';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Stories_Area',
			[
				'label' => esc_html__( 'Ellen Stories Area', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control( 'style', [
                'label'   => esc_html__( 'Style', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '1'   => 'Style One',
                    '2'   => 'Style Two',
                ],
                'default' => '1',
            ] );
            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Affordable online courses and learning opportunities​', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label' => esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
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
                'content',
                [
                    'label' => esc_html__( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Explore all of our courses and pick your suitable ones to enroll and start learning with us!', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
				'user_button_text',
				[
					'label' 	=> esc_html__( 'User Logged in Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('View All Stories', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> __('View All Stories', 'ellen-toolkit'),
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
                    'type'		=> Controls_Manager:: TEXT,
                    'condition' => [
                        'link_type' => '2',
                    ]
                ]
            );

            $this->add_control(
                'image',
                [
                    'label'		=> esc_html__('Section Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape1',
                [
                    'label'		=> esc_html__('Shape Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape2',
                [
                    'label'		=> esc_html__('Shape Image Two', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape3',
                [
                    'label'		=> esc_html__('Shape Image Three', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape4',
                [
                    'label'		=> esc_html__('Shape Image Four', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape5',
                [
                    'label'		=> esc_html__('Shape Image Five', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape6',
                [
                    'label'		=> esc_html__('Shape Image Six', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'shape7',
                [
                    'label'		=> esc_html__('Shape Image Seven', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );


        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
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
                        '{{WRAPPER}} .stories-content h2, .stories-content h3, .stories-content h4, .stories-content h5, .stories-content h5, .stories-content h6, .stories-content h1' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .stories-content h2, .stories-content h3, .stories-content h4, .stories-content h5, .stories-content h5, .stories-content h6',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stories-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .stories-content p',
                ]
            );

            $this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stories-content .default-btn' => 'border-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stories-content .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => __( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .stories-content .default-btn',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        if ( is_user_logged_in() ):
            $button_text = $settings['user_button_text'];
        else:
            $button_text = $settings['button_text'];
        endif;

         // Get Button Link
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $link = $settings['ex_link'];
        }else{
            $link = '';
        }

        if($settings['shape6']['url']): ?>
        <style>
            .stories-image::after{background-image: url(<?php echo esc_url($settings['shape6']['url']); ?>);}
            .stories-image::before{background-image: url(<?php echo esc_url($settings['shape7']['url']); ?>);}
        </style>
        <?php endif; ?>

        <?php if($settings['style'] == '1'): ?>
            <div class="stories-area ptb-100">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <?php if( $settings['image']['url'] != '' ): ?>
                                <div class="stories-image">
                                    <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="stories-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <?php if( $button_text ): ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if( $settings['shape1']['url'] != '' ): ?>
                    <div class="shape2">
                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape2']['url'] != '' ): ?>
                    <div class="shape3">
                        <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape3']['url'] != '' ): ?>
                    <div class="shape4">
                        <img src="<?php echo esc_url( $settings['shape3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape4']['url'] != '' ): ?>
                    <div class="shape5">
                        <img src="<?php echo esc_url( $settings['shape4']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape5']['url'] != '' ): ?>
                    <div class="shape6">
                        <img src="<?php echo esc_url( $settings['shape5']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php elseif($settings['style'] == '2'): ?>
            <div class="stories-area ptb-100">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <div class="stories-content">
                            <<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                            <?php if( $button_text ): ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <?php if( $settings['image']['url'] != '' ): ?>
                                <div class="stories-image">
                                    <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if( $settings['shape1']['url'] != '' ): ?>
                    <div class="shape2">
                        <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape2']['url'] != '' ): ?>
                    <div class="shape3">
                        <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape3']['url'] != '' ): ?>
                    <div class="shape4">
                        <img src="<?php echo esc_url( $settings['shape3']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape4']['url'] != '' ): ?>
                    <div class="shape5">
                        <img src="<?php echo esc_url( $settings['shape4']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>

                <?php if( $settings['shape5']['url'] != '' ): ?>
                    <div class="shape6">
                        <img src="<?php echo esc_url( $settings['shape5']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Stories_Area );