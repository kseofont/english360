<?php
/**
 * University Why Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sc_kindergarten extends Widget_Base {

	public function get_name() {
        return 'kindergarten_Sc';
    }

	public function get_title() {
        return esc_html__( 'School & College Ckindergarten', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-before-after';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'University_Why_Area',
			[
				'label' => esc_html__( 'Ckindergarten Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'choose_style',
                [
                    'label' => __( 'Choose Style', 'medak-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Choose Style - 1', 'medak-toolkit' ),
                        '2'   => __( 'Choose Style - 2', 'medak-toolkit' ),
                        '3'   => __( 'Choose Style - 3', 'medak-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('KINDERGARTEN - GRADE 6', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'top_title_top',
                [
                    'label'       => __( 'Title Top', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Ellen', 'ellen-toolkit'),
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
                    'default'     => __('Kindergarten', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Your journey starts here. Choose from more than 159 program options, check the admission requirements and apply online.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('Learn More', 'ellen-toolkit'),
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
                        '{{WRAPPER}} .sc-kindergarten-content .sub::before, {{WRAPPER}} .sc-middle-school-content .sub::before, {{WRAPPER}} .sc-senior-school-content .sub::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-kindergarten-content .sub, {{WRAPPER}} .sc-middle-school-content .sub, {{WRAPPER}} .sc-senior-school-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Title Top Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-kindergarten-content .sub, {{WRAPPER}} .sc-middle-school-content .sub, {{WRAPPER}} .sc-senior-school-content .sub',
                ]
            );

            $this->add_control(
                'top_title_top_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-kindergarten-content h3, {{WRAPPER}} .sc-middle-school-content h3, {{WRAPPER}} .sc-senior-school-content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_top_typography',
                    'label' => esc_html__( 'Title Top Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-kindergarten-content h3, {{WRAPPER}} .sc-middle-school-content h3, {{WRAPPER}} .sc-senior-school-content h3',
                ]
            );

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-kindergarten-content .title-tags, {{WRAPPER}} .sc-middle-school-content .title-tags, {{WRAPPER}} .sc-senior-school-content .title-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-kindergarten-content .title-tags, {{WRAPPER}} .sc-middle-school-content .title-tags, {{WRAPPER}} .sc-senior-school-content .title-tags',
                ]
            );

            $this->add_control(
				'bg_bf_title_color',
				[
					'label' => esc_html__( 'Title Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-kindergarten-content .title-tags::before, {{WRAPPER}} .sc-middle-school-content .title-tags::before, {{WRAPPER}} .sc-senior-school-content .title-tags::before' => 'background-color: {{VALUE}} !important',
					],
				]
			);

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-kindergarten-content p, {{WRAPPER}} .sc-middle-school-content p, {{WRAPPER}} .sc-senior-school-content p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-kindergarten-content p, {{WRAPPER}} .sc-middle-school-content p, {{WRAPPER}} .sc-senior-school-content p',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_bg_color',
				[
					'label' => __( 'Button Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'btn_bg_hover_color',
				[
					'label' => __( 'Button Hover Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .optional-btn:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .optional-btn',
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
     
        ?>

        <?php if($settings['choose_style']==1): ?>

            <div class="sc-kindergarten-content school-college-home">
                <?php if( $settings['top_title']): ?>
                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                <?php endif; ?>
                <?php if( $settings['top_title_top']): ?>
                    <h3><?php echo wp_kses_post($settings['top_title_top']); ?></h3>
                <?php endif; ?>
                <?php if( $settings['title']): ?>
                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                <?php endif; ?>
                <?php if( $settings['content']): ?>
                    <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                <?php endif; ?>
                <?php if($settings['button_text'] && $link): ?>
                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn"><?php echo esc_html($settings['button_text']); ?></a>
                <?php endif; ?>
            </div>

        <?php elseif($settings['choose_style']==2): ?>

            <div class="sc-middle-school-content school-college-home">
                <?php if( $settings['top_title']): ?>
                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                <?php endif; ?>
                <?php if( $settings['top_title_top']): ?>
                    <h3><?php echo wp_kses_post($settings['top_title_top']); ?></h3>
                <?php endif; ?>
                <?php if( $settings['title']): ?>
                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                <?php endif; ?>
                <?php if( $settings['content']): ?>
                    <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                <?php endif; ?>
                <?php if($settings['button_text'] && $link): ?>
                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn"><?php echo esc_html($settings['button_text']); ?></a>
                <?php endif; ?>
            </div>

        <?php elseif($settings['choose_style']==3): ?>

            <div class="sc-senior-school-content school-college-home">
                <?php if( $settings['top_title']): ?>
                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                <?php endif; ?>
                <?php if( $settings['top_title_top']): ?>
                    <h3><?php echo wp_kses_post($settings['top_title_top']); ?></h3>
                <?php endif; ?>
                <?php if( $settings['title']): ?>
                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                <?php endif; ?>
                <?php if( $settings['content']): ?>
                    <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                <?php endif; ?>
                <?php if($settings['button_text'] && $link): ?>
                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="optional-btn"><?php echo esc_html($settings['button_text']); ?></a>
                <?php endif; ?>
            </div>



        <?php endif; ?>

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Sc_kindergarten );