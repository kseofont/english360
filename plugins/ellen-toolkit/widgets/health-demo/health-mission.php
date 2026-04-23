<?php
/**
 * University Why Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Mission extends Widget_Base {

	public function get_name() {
        return 'Mission_Health';
    }

	public function get_title() {
        return esc_html__( 'Health Mission', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-before-after';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Health_Mission_Area',
			[
				'label' => esc_html__( 'Health Mission Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
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
                    'default'     => __('At Ellen, we give ourselves the freedom to be many things at once in life.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'play_text',
				[
					'label' 	=> esc_html__( 'Play Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Our Mission', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'video_icon',
				[
					'label' 	=> esc_html__( 'Play Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('bx bx-play', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'video_url',
				[
					'label' 	=> esc_html__( 'Video Url', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
				]
            );

            $this->add_control(
                'f_img1',
                [
                    'label'		=> esc_html__('Feature Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'f_img2',
                [
                    'label'		=> esc_html__('Feature Image Two', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'f_img3',
                [
                    'label'		=> esc_html__('Feature Image Three', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                's_img',
                [
                    'label'		=> esc_html__('Shape Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
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
						'{{WRAPPER}} .hwf-mission-content  .title-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-mission-content .title-tags',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Mission Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-mission-content .popup-video span' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Mission Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-mission-content .popup-video span',
                ]
            );

            $this->add_control(
				'play_color',
				[
					'label' => __( 'Video Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-mission-content .popup-video i' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_hover_color',
				[
					'label' => __( 'Video Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-mission-content .popup-video i:hover' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_bg_color',
				[
					'label' => __( 'Video Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-mission-content .popup-video i' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_bg_hover_color',
				[
					'label' => __( 'Video Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-mission-content .popup-video i:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'play_ic_typography',
                    'label' => esc_html__( 'Video Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-mission-content .popup-video i',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

		$settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';
     
        ?>

        <!-- Start HWF Mission Area -->
        <div class="hwf-mission-area health-wellness-fitness-home">
            <div class="container">
                <div class="hwf-mission-inner">
                    <div class="hwf-mission-content">
                        <?php if( !empty( $settings['s_img']['url'] ) ){ ?>
                            <div class="leaf">
                                <img src="<?php echo esc_url( $settings['s_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        <?php } ?>
                        
                        <?php if( $settings['title']): ?>
                            <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                        <?php endif; ?>
                        <?php if( !empty( $settings['video_url'] && $settings['video_icon']) ){ ?>
                            <a href="<?php echo esc_attr( $settings['video_url'] ); ?>" class="popup-video">
                                <i class='<?php echo esc_attr($settings['video_icon']); ?>'></i>
                                <?php if( $settings['play_text']): ?>
                                    <span><?php echo wp_kses_post($settings['play_text']); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php } ?>

                        <?php if( !empty( $settings['f_img1']['url'] ) ){ ?>
                            <div class="image1">
                                <img src="<?php echo esc_url( $settings['f_img1']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        <?php } ?>

                        <?php if( !empty( $settings['f_img2']['url'] ) ){ ?>
                            <div class="image2">
                                <img src="<?php echo esc_url( $settings['f_img2']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        <?php } ?>

                        <?php if( !empty( $settings['f_img3']['url'] ) ){ ?>
                            <div class="image3">
                                <img src="<?php echo esc_url( $settings['f_img3']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End HWF Mission Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Health_Mission );