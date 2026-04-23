<?php
/**
 * CTA Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_CTA_Area extends Widget_Base {

	public function get_name() {
        return 'Ellen_CTA_Area';
    }

	public function get_title() {
        return __( 'CTA Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-call-to-action';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'cta_section',
			[
				'label' => __( 'Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
            $this->add_control(
                'style',
                [
                    'label' => esc_html__( 'Select Style', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'         => esc_html__( 'Style One', 'ellen-toolkit' ),
                        '2'         => esc_html__( 'Style Two', 'ellen-toolkit' ),
                        '3'         => esc_html__( 'Style Three', 'ellen-toolkit' ),
                        '4'         => esc_html__( 'Style Four', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );
			$this->add_control(
                'bg',
                [
                    'label' => esc_html__( 'Background Shape Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );
			$this->add_control(
                'shape',
                [
                    'label' => esc_html__( 'Shape', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
				]
            );

			$this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Transform access to education', 'ellen-toolkit'),
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
					'default' 	=> __('Profile', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> __('Register For Free', 'ellen-toolkit'),
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

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'bg_color',
				[
					'label' => __( 'Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .free-trial-area.bg-color::before, .free-trial-area.bg-image::before' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cta-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .cta-title',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .free-trial-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .free-trial-content p',
                ]
            );

            $this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .free-trial-content .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .free-trial-content .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => __( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} ..free-trial-content .default-btn',
                ]
            );

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .free-trial-content i' => 'color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();// Inline Editing
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
        if($settings['style'] == '2'):
            if($settings['bg']['url']): ?>
                <style>
                    .free-trial-area.bg-image::before{background-image: url(<?php echo esc_url($settings['bg']['url']); ?>);}
                </style>
            <?php endif; ?>

            <div class="free-trial-area ptb-100 bg-image">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <div class="free-trial-content">
                                <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cta-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="free-trial-btn">
                                <?php if( $button_text ): ?>
                                    <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if( $settings['shape']['url'] != '' ): ?>
                    <div class="shape5">
                        <img src="<?php echo esc_url( $settings['shape']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
                <div class="lines">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
        <?php elseif($settings['style'] == '3'): ?>
            <?php if($settings['bg']['url']): ?>
                <style>
                    .free-trial-area.bg-image::before {
                        background-image: url(<?php echo esc_url($settings['bg']['url']); ?>);
                    }
                </style>
            <?php endif; ?>

            <div class="free-trial-area ptb-100 bg-image">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <div class="free-trial-content">
                                <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cta-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="free-trial-btn">
                                <?php if( $button_text ): ?>
                                    <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if( $settings['shape']['url'] != '' ): ?>
                    <div class="shape5">
                        <img src="<?php echo esc_url( $settings['shape']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php elseif($settings['style'] == '4'): ?>
            <?php if($settings['bg']['url']): ?>
                <style>
                    .free-trial-area.bg-image::before {
                        background-image: url(<?php echo esc_url($settings['bg']['url']); ?>);
                    }
                </style>
            <?php endif; ?>

            <div class="free-trial-area ptb-100 style-two bg-image">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <div class="free-trial-content">
                                <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cta-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="free-trial-btn">
                                <?php if( $button_text ): ?>
                                    <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if( $settings['shape']['url'] != '' ): ?>
                    <div class="shape5">
                        <img src="<?php echo esc_url( $settings['shape']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="free-trial-area bg-color">
                <div class="free-trial-inner" style="background-image:url(<?php echo esc_url($settings['bg']['url']); ?>);">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 offset-lg-3">
                                <div class="free-trial-content">
                                    <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                                    <<?php echo esc_attr( $settings['title_tag'] ); ?> class="cta-title"><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                                    <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>

                                    <?php if( $button_text ): ?>
                                        <a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_CTA_Area );