<?php
/**
 * Health About Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_About extends Widget_Base {

	public function get_name() {
        return 'About_Health';
    }

	public function get_title() {
        return esc_html__( 'Health About', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-box';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Health_About_Area',
			[
				'label' => esc_html__( 'Health About Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'f_img',
                [
                    'label'		=> esc_html__('Feature Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('ABOUT ELLEN', 'ellen-toolkit'),
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
                    'default'     => __('An Online Platform to <span>make you Healthy</span>', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'content',
                [
                    'label'       => __( 'Content', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('We believe academically curious, socially engaged girls are our best hope for the future. We celebrate and cultivate that power, enabling our students to grow into their authentic selves and lead lives of purpose.', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();
            $repeater->add_control(
                'number', [
					'type'    => Controls_Manager::NUMBER,
					'label'   => esc_html__( 'Ending Number', 'ellen-toolkit' ),
					'default' => 1926,
                ]
            );
            $repeater->add_control(
                'number_suffix', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Number Suffix', 'ellen-toolkit' ),
					'default' => esc_html__('+', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'funfact_title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('COURSES', 'ellen-toolkit'),
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

            $this->add_control(
                'user_images',
                [
                    'label' => esc_html__( 'Support User Images', 'medak-toolkit' ),
                    'type' => Controls_Manager::GALLERY,
                ]
            );

            $this->add_control(
				'people_text',
				[
					'label'   => __( 'People loved Text', 'medak-toolkit' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __('More than <b>60K+</b> members Joined us for a healthy life', 'medak-toolkit'),
                    'label_block' => true,
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
                'video_img',
                [
                    'label'		=> esc_html__('Video Background Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );

            $this->add_control(
				'video_text',
				[
					'label' 	=> esc_html__( 'Video Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('See the video to see how we help', 'ellen-toolkit'),
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
                'sec_bg_color',
                [
                    'label' => esc_html__( 'Section Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-about-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-about-content .content .sub::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-about-content .content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .content .sub',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-about-content .content .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .content .title-tgas',
                ]
            );

            $this->add_control(
                'bg_title_color',
                [
                    'label' => esc_html__( 'Title Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-about-content .content .title-tgas span::before' => 'background-color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_control(
				'left_br_color',
				[
					'label' => esc_html__( 'Left Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .inner' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .inner p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .inner p',
                ]
            );

            $this->add_control(
				'counter_nm_color',
				[
					'label' => esc_html__( 'Counter Number Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .inner .box h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_nm_typography',
                    'label' => esc_html__( 'Counter Number Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .inner .box h3',
                ]
            );

            $this->add_control(
				'counter_sp_color',
				[
					'label' => esc_html__( 'Counter Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .inner .box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_sp_typography',
                    'label' => esc_html__( 'Counter Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .inner .box p',
                ]
            );

            $this->add_control(
				'con_bg_color',
				[
					'label' => esc_html__( 'Bottom Content Background Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .bottom' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'people_color',
				[
					'label' => esc_html__( 'People loved Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .health-overview-content .bottom p' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_color',
				[
					'label' => __( 'Video Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .bottom .right .image .popup-video i' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'play_hover_color',
				[
					'label' => __( 'Video Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .bottom .right .image .popup-video i:hover' => 'color: {{VALUE}}',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'play_ic_typography',
                    'label' => esc_html__( 'Video Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .bottom .right .image .popup-video i',
                ]
            );

            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Video Text Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-about-content .bottom .right .title p' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Video Text Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-about-content .bottom .right .title p',
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

        <!-- Start HWF About Area -->
        <div class="hwf-about-area health-wellness-fitness-home ptb-100">
            <div class="container">
                <div class="row justify-content-center align-items-center g-5">
                    
                    <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                        <div class="col-xl-5 col-md-12">
                            <div class="hwf-about-image">
                                <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-xl-7 col-md-12">
                        <div class="hwf-about-content">
                            <div class="content">
                                
                                <?php if( $settings['top_title']): ?>
                                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                                <?php endif; ?>
                                <?php if( $settings['title']): ?>
                                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                                <?php endif; ?>

                                <?php if( $settings['content']): ?>
                                    <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                                <?php endif; ?>
                                
                            </div>
                            <div class="inner">

                                <?php if( $settings['content']): ?>
                                    <p><?php echo wp_kses_post($settings['content'] ); ?></p>
                                <?php endif; ?>
                                
                                <div class="row justify-content-center g-4">

                                    <?php $i=1; foreach( $settings['items'] as $item ): 

                                        $clNam = '';
                                        if($i==2){
                                            $clNam= 'wrap2';
                                        }elseif($i==3){
                                            $clNam= 'wrap3';
                                        }
                                        
                                    ?>
                                        <div class="col-lg-4 col-sm-4">
                                            <div class="box <?php echo esc_attr( $clNam ); ?>">
                                                <?php if( $item['number'] && $item['number_suffix']): ?>
                                                    <h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
                                                <?php endif; ?>
                                                <?php if( $item['funfact_title']): ?>
                                                    <p><?php echo esc_html( $item['funfact_title'] ); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php $i++; endforeach; ?>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="users">
                                        <?php foreach ( $settings['user_images'] as $image ) { ?>

                                            <img class="user-image-1" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">

                                        <?php } ?>
                                    </div>
                                    <?php if($settings['people_text'] ): ?>
                                        <div class="title">
                                            <p><?php echo wp_kses_post($settings['people_text'] ); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if( !empty( $settings['video_img']['url'] ) ){ ?>
                                    <div class="right">
                                        <div class="image">
                                            <img src="<?php echo esc_url( $settings['video_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">

                                            <?php if( !empty( $settings['video_url'] && $settings['video_icon']) ){ ?>
                                                <a href="<?php echo esc_attr( $settings['video_url'] ); ?>" class="popup-video">
                                                    <i class='<?php echo esc_attr($settings['video_icon']); ?>'></i>
                                                </a>
                                            <?php } ?>
                                        </div>

                                        <?php if( $settings['video_text']): ?>
                                            <div class="title">
                                                <p><?php echo wp_kses_post($settings['video_text']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End HWF About Area -->

        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Health_About );