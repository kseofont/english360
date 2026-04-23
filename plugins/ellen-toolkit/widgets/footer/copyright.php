<?php
/**
 * Copyright Widget
 */

namespace Elementor;
class Ellen_Copyright extends Widget_Base {

	public function get_name() {
        return 'Copyright';
    }

	public function get_title() {
        return __( 'Copyright', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-copy';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Section',
			[
				'label' => __( 'Ellen Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'choose_style',
                [
                    'label' => __( 'Choose Style', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Style - 1 (University Demo Fonts Style) ', 'ellen-toolkit' ),
                        '2'   => __( 'Choose Style - 2 (School & College Demo Fonts Style)', 'ellen-toolkit' ),
                        '3'   => __( 'Choose Style - 3 (Health, Wellness & Fitness Demo Fonts Style)', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'author_tit',
                [
                    'label'   => __( 'Author Name', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::TEXTAREA,
                    'default' => __('EnvyTheme', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'author_url',
                [
                    'label'   => __( 'Author url', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::TEXTAREA,
                    'default' => __('https://envytheme.com/', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'copy_text',
                [
                    'label'   => __( 'Copyright Text', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::TEXTAREA,
                    'default' => __('Copyright <span>Ellen</span>. All Rights Reserved by ', 'ellen-toolkit'),
                ]
            );


        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'choose_card_align',
                [
                    'label' => __( 'Choose Alignment', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Text Align Center', 'ellen-toolkit' ),
                        '2'   => __( 'Choose Text Align Left', 'ellen-toolkit' ),
                        '3'   => __( 'Choose Text Align Right', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'copyright_bg_color',
                [
                    'label' => esc_html__( 'Copyright Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .copyright-wrap-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'author_tit_color',
                [
                    'label' => esc_html__( 'Author Name Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .copyright-wrap-area p a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'author_tit_h_color',
                [
                    'label' => esc_html__( 'Author Name Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .copyright-wrap-area p a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'author_tit_typography',
                    'label' => __( 'Author Name Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .copyright-wrap-area p a',
                ]
            );

            $this->add_control(
                'copyright_color',
                [
                    'label' => esc_html__( 'Copyright Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .copyright-wrap-area p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'copyright_typography',
                    'label' => __( 'Copyright Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .copyright-wrap-area p',
                ]
            );

            $this->add_control(
                'copyright_th_color',
                [
                    'label' => esc_html__( 'Copyright Theme Name Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .copyright-wrap-area p span' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');

        // Card Text Alignment
        $card_align_cls = '';
        if ( $settings['choose_card_align'] == '1') {
            $card_align_cls = 'text-center';
        }elseif ( $settings['choose_card_align'] == '2') {
            $card_align_cls = 'text-start';
        }elseif ( $settings['choose_card_align'] == '3') {
            $card_align_cls = 'text-end';
        }

        ?>

        <!-- Start Copyright Wrap Area -->
        <div class="<?php if($settings['choose_style']==1): ?> university-home copyright-wrap-area  <?php elseif($settings['choose_style']==2): ?>  school-college-home copyright-wrap-area wrap-style2 <?php elseif($settings['choose_style']==3): ?> health-wellness-fitness-home copyright-wrap-area <?php endif; ?> <?php echo esc_attr( $card_align_cls ); ?>">
            <div class="container">
                <p><?php if ( $settings['copy_text']) : ?>  <?php echo wp_kses_post( $settings['copy_text'] ); ?><?php endif; ?> <?php if ( $settings['author_tit'] && $settings['author_url']) : ?> <a href="<?php echo esc_url( $settings['author_url'] ); ?>" target="_blank"><?php echo esc_html( $settings['author_tit'] ); ?></a><?php endif; ?></p>
            </div>
        </div>
        <!-- End Copyright Wrap Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Copyright );