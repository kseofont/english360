<?php
/**
 * University Banner Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sc_Our_School extends Widget_Base {

	public function get_name() {
        return 'Sc_School';
    }

	public function get_title() {
        return esc_html__( 'School & College Our School', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-slider-video';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Sc_Banner_Area',
			[
				'label' => esc_html__( 'Our School Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );


            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('WE LOVE OUR SCHOOL', 'ellen-toolkit'),
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
                    'default'     => __('At Ellen, we give ourselves the freedom to be many things at once in life.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'bg_title',
                [
                    'label'       => __( 'Background Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('WE LOVE OUR SCHOOL', 'ellen-toolkit'),
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

        $this->end_controls_section();


        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-mission-content .sub::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-mission-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-mission-content .sub',
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}}  .sc-mission-content .mission-tags',
                ]
            );


            $this->add_control(
				'bg_title_color',
				[
					'label' => esc_html__( 'Background Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .little-big' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'bg_title_typography',
                    'label' => esc_html__( 'Background Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-mission-content .little-big',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Mission Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-btn a span' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Mission Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-mission-content .mission-btn a span',
                ]
            );

            $this->add_control(
				'play_color',
				[
					'label' => __( 'Video Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-btn a i' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_hover_color',
				[
					'label' => __( 'Video Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-btn a:hover i' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_bg_color',
				[
					'label' => __( 'Video Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-btn a i' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_bg_hover_color',
				[
					'label' => __( 'Video Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-mission-content .mission-btn a:hover i' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'play_ic_typography',
                    'label' => esc_html__( 'Video Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-mission-content .mission-btn a i',
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

        <!-- Start SC Mission Area -->
        <div class="sc-mission-area school-college-home ptb-100">
            <div class="container">
                <div class="sc-mission-content">
                    <?php if( $settings['top_title']): ?>
                        <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                    <?php endif; ?>
                   
                    <?php if( $settings['title']): ?>
                        <<?php echo $title_tag;?> class="mission-tags"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                    <?php endif; ?>
                    <?php if( !empty( $settings['video_url'] && $settings['video_icon']) ){ ?>
                        <div class="mission-btn">
                            <a href="<?php echo esc_attr( $settings['video_url'] ); ?>" class="popup-video">
                                <?php if( $settings['play_text']): ?>
                                    <span><?php echo wp_kses_post($settings['play_text']); ?></span>
                                <?php endif; ?>
                                <i class='<?php echo esc_attr($settings['video_icon']); ?>'></i>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if( $settings['bg_title']): ?>
                        <h3 class="little-big"><?php echo wp_kses_post($settings['bg_title']); ?></h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End SC Mission Area -->

        <?php
	}
    
}

Plugin::instance()->widgets_manager->register( new Sc_Our_School );