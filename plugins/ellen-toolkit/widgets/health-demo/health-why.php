<?php
/**
 * Health Why Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Health_Why extends Widget_Base {

	public function get_name() {
        return 'Why_Health';
    }

	public function get_title() {
        return esc_html__( 'Health Why', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Health_Why_Area',
			[
				'label' => esc_html__( 'Health Why Controls', 'ellen-toolkit' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
        );
           
            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('WHY ELLEN', 'ellen-toolkit'),
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
                    'default'     => __('<strong>Why people love us</strong> from the starting point of our journey', 'ellen-toolkit'),
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
					'default' => esc_html__('Experienced Trainer', 'ellen-toolkit'),
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
                'f_img',
                [
                    'label'		=> esc_html__('Feature Image', 'ellen-toolkit'),
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
                'sec_bg_color',
                [
                    'label' => esc_html__( 'Section Top Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-why-area::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'sec_bg_in_color',
                [
                    'label' => esc_html__( 'Section Inner Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-why-inner' => 'background: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-why-content .sub::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-why-content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-why-content .sub',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hwf-why-content .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-why-content .title-tgas',
                ]
            );

            $this->add_control(
				'counter_nm_color',
				[
					'label' => esc_html__( 'Counter Number Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-why-items .fun .box h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_nm_typography',
                    'label' => esc_html__( 'Counter Number Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-why-items .fun .box h3',
                ]
            );

            $this->add_control(
				'counter_sp_color',
				[
					'label' => esc_html__( 'Counter Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-why-items .fun .box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_sp_typography',
                    'label' => esc_html__( 'Counter Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .hwf-why-items .fun .box p',
                ]
            );

            $this->add_control(
				'con_br_color',
				[
					'label' => esc_html__( 'Counter Border Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hwf-why-items .fun .box' => 'border-color: {{VALUE}}',
					],
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

        <!-- Start HWF Why Area -->
        <div class="hwf-why-area health-wellness-fitness-home">
            <div class="hwf-why-inner">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-md-12">
                            <div class="hwf-why-content">
                                <?php if( $settings['top_title']): ?>
                                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                                <?php endif; ?>
                                <?php if( $settings['title']): ?>
                                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                                <?php endif; ?>
                   
                                <?php if( !empty( $settings['s_img']['url'] ) ){ ?>
                                    <div class="wrap-shape">
                                        <img src="<?php echo esc_url( $settings['s_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-7 col-md-12">
                            <div class="hwf-why-items">
                                <div class="row justify-content-center align-items-center g-5">
                                    <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="image">
                                                <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="fun">

                                            <?php $i=1; foreach( $settings['items'] as $item ):  ?>
                                                <div class="box <?php if($i==2): ?> wrap-box <?php endif; ?>">
                                                    <?php if( $item['number'] && $item['number_suffix']): ?>
                                                        <h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
                                                    <?php endif; ?>
                                                    <?php if( $item['funfact_title']): ?>
                                                        <p><?php echo esc_html( $item['funfact_title'] ); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php $i++; endforeach; ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End HWF Why Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Health_Why );