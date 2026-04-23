<?php
/**
 * Partner Logo Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Partner_Logo extends Widget_Base {

	public function get_name() {
        return 'Partner_Logo';
    }

	public function get_title() {
        return __( 'Partner Logos', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-logo';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'partner_section',
			[
				'label' => __( 'Partner Logo Control', 'ellen-toolkit' ),
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
					'default' => esc_html__('Online Coaching Lessons For Remote Learning', 'ellen-toolkit'),
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
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ellen-toolkit'),
				]
			);

			$this->add_control(
				'user_button_text',
				[
					'label' 	=> esc_html__( 'User Logged in Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('Apply to Become a Teacher', 'ellen-toolkit'),
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> __('Start For Free', 'ellen-toolkit'),
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
                'logos',
                [
                    'label'   => esc_html__( 'Add Partner Logos', 'ellen-toolkit' ),
                    'type' => Controls_Manager::GALLERY,
                ]
            );

			$this->add_control(
                'shape_image',
                [
                    'label' => esc_html__( 'Shape Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'partner_styling',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .partner-inner-area h2, .partner-inner-area h3, .partner-inner-area h4, .partner-inner-area h5, .partner-inner-area h5, .partner-inner-area h6, .partner-inner-area h1' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => __( 'Title Typography', 'ellen-toolkit' ),
					
					'selector' => '{{WRAPPER}} .partner-inner-area h2, .partner-inner-area h3, .partner-inner-area h4, .partner-inner-area h5, .partner-inner-area h5, .partner-inner-area h6',
				]
			);

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .partner-inner-area p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'label' => __( 'Content Typography', 'ellen-toolkit' ),
					
					'selector' => '{{WRAPPER}} .partner-inner-area p',
				]
			);

			$this->add_control(
				'btn_bg',
				[
					'label' => esc_html__( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .partner-inner-area .default-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'btn_bg_hover',
				[
					'label' => esc_html__( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .partner-inner-area .default-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'btn_typography',
					'label' => __( 'Button Typography', 'ellen-toolkit' ),
					
					'selector' => '{{WRAPPER}} .partner-inner-area .default-btn',
				]
			);

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings_for_display();

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
		<div class="partner-area">
			<div class="container">
				<div class="partner-inner-area">
					<div class="row align-items-center">
						<div class="col-lg-5 col-md-12">
							<<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
							<p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
							<?php if( $button_text ): ?>
								<a href="<?php echo esc_url( $link ); ?>" class="default-btn"><?php echo esc_html( $button_text ); ?><span></span></a>
							<?php endif; ?>
						</div>
						<div class="col-lg-7 col-md-12">
							<div class="partner-lists">
								<div class="row align-items-center">
									<?php foreach( $settings['logos'] as $item ): ?>
										<?php if($settings['style'] == '2'): ?>
											<div class="col-lg-4 col-md-4 col-sm-4 col-6">
										<?php else: ?>
											<div class="col-lg-3 col-md-3 col-sm-4 col-6">
										<?php endif; ?>
												<div class="item">
													<img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr__( 'Partner Logo', 'ellen-toolkit' ); ?>">
												</div>
											</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if($settings['shape_image']['url']): ?>
                <div class="shape2"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>"></div>
            <?php endif; ?>
		</div>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Partner_Logo );