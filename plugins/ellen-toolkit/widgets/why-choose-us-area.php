<?php
/**
 * Why Choose Us Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_WCU extends Widget_Base {

	public function get_name() {
        return 'WCU';
    }

	public function get_title() {
        return esc_html__( 'Why Choose Us Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-handle';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_WCU',
			[
				'label' => esc_html__( 'Ellen Why Choose Us', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );
            $this->add_control(
                'image',
                [
                    'label' => esc_html__( 'Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );
            $this->add_control(
                'top_title',
                [
                    'label' => esc_html__( 'Top Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('WHY CHOOSE US?', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Learn the Latest Top Skills', 'ellen-toolkit'),
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
					'default' 	=> __('Get Started For Free', 'ellen-toolkit'),
				]
			);

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> __('Get Started For Free', 'ellen-toolkit'),
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
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .why-choose-us-content .sub-title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => __( 'Top Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .why-choose-us-content .sub-title',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .why-choose-us-content h2, .why-choose-us-content h3, .why-choose-us-content h4, .why-choose-us-content h5, .why-choose-us-content h5, .why-choose-us-content h6, .why-choose-us-content h1' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .why-choose-us-content h2, .why-choose-us-content h3, .why-choose-us-content h4, .why-choose-us-content h5, .why-choose-us-content h5, .why-choose-us-content h6',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .why-choose-us-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .why-choose-us-content p',
                ]
            );

            $this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .why-choose-us-content .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .why-choose-us-content .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => __( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .why-choose-us-content .default-btn',
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
        ?>
        <div class="why-choose-us-area pb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <?php if($settings['image']['url']): ?>
                            <div class="why-choose-us-image">
                                <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="why-choose-us-content">
                            <?php if( $settings['top_title'] != '' ): ?>
                                <span class="sub-title"><?php echo esc_html( $settings['top_title'] ); ?></span>
                            <?php endif; ?>
                            <<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <?php echo wp_kses_post( $settings['content'] ); ?>

                            <?php if( $button_text ): ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="default-btn style-two"><?php echo esc_html( $button_text ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_WCU );