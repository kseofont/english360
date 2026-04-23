<?php
/**
 * University Banner Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sc_Photo_Gallery extends Widget_Base {

	public function get_name() {
        return 'Photo_Gallery';
    }

	public function get_title() {
        return esc_html__( 'School & College Photo Gallery', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-photo-library';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Sc_Banner_Area',
			[
				'label' => esc_html__( 'School & College Photo Gallery Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('PHOTO GALLERY', 'ellen-toolkit'),
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
                    'default'     => __('Our best moment in the <span>school</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'bg_title',
                [
                    'label'       => __( 'Background Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('PHOTO GALLERY', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();

                $repeater->add_control(
                    'f_img',
                    [
                        'type'    => Controls_Manager::MEDIA,
                        'label'   => __( 'Images', 'ellen-toolkit' ),
                    ]
                );
        
            $this->add_control(
                'items',
                [
                    'label'   => esc_html__( 'Add Counter Item', 'ellen-toolkit' ),
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
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title .sub::before' => 'background-color: {{VALUE}}',
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
						'{{WRAPPER}} .school-gallery-area .section-wrap-title .title-tags' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .school-gallery-area .section-wrap-title .title-tags',
                ]
            );

            $this->add_control(
				'title_br_color',
				[
					'label' => esc_html__( 'Title Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .school-gallery-area .section-wrap-title .title-tags span::before, {{WRAPPER}} .school-gallery-area .section-wrap-title h2 span::before' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'bg_title_color',
				[
					'label' => esc_html__( 'Background Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .school-gallery-inner .little-big' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'bg_title_typography',
                    'label' => esc_html__( 'Background Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .school-gallery-inner .little-big',
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


        <!-- Start School Gallery Area -->
        <div class="school-gallery-area school-college-home ptb-100">
            <div class="container">
                <div class="school-gallery-inner">
                    <div class="section-wrap-title text-start">
                        <?php if( $settings['top_title']): ?>
                            <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                        <?php endif; ?>
                    
                        <?php if( $settings['title']): ?>
                            <<?php echo $title_tag;?> class="title-tags"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                        <?php endif; ?>
                    </div>
                    <div class="swiper school-gallery-slider">
                        <div class="swiper-wrapper align-items-center">
                            <?php $i=1; foreach( $settings['items'] as $item  ):  ?>
                                <div class="swiper-slide">
                                    <div class="school-gallery-item">
                                        <a href="<?php echo esc_url( $item['f_img']['url'] ); ?>">
                                            <img src="<?php echo esc_url( $item['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <ul class="school-gallery-button">
                        <li>
                            <div class="school-gallery-button-prev">
                                <i class='bx bx-left-arrow-alt'></i>
                            </div>
                        </li>
                        <li>
                            <div class="school-gallery-button-next">
                                <i class='bx bx-right-arrow-alt'></i>
                            </div>
                        </li>
                    </ul>
                    <?php if( $settings['bg_title']): ?>
                        <h3 class="little-big"><?php echo wp_kses_post($settings['bg_title']); ?></h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End School Gallery Area -->

        <?php
	}
    
}

Plugin::instance()->widgets_manager->register( new Sc_Photo_Gallery );