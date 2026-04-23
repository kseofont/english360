<?php
/**
 * Funfacts Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Funfacts extends Widget_Base {

	public function get_name() {
        return 'Ellen_Funfacts';
    }

	public function get_title() {
        return __( 'Funfacts', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-counter';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'funfacts_section',
			[
				'label' => __( 'Funfacts Control', 'ellen-toolkit' ),
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
					],
					'default' => '1',
				]
			);
			$this->add_control(
                'number_bg',
                [
                    'label' => esc_html__( 'Number Background Shape Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                    'condition' => [
                        'style' => '1',
                    ]
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
                'title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('COURSES', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'number_suffix', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Number Suffix', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
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
						'{{WRAPPER}} .funfacts-area.bg-color::before, .single-funfacts-box ' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'Number Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-funfacts-box.white-color h3, .single-funfacts-box h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'label' => esc_html__( 'Number Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-funfacts-box.white-color h3, .single-funfacts-box h3',
                ]
            );

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-funfacts-box.white-color p, .single-funfacts-box p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-funfacts-box.white-color p, .single-funfacts-box p',
                ]
            );

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-funfacts-box.white-color i, .single-funfacts-box i' => 'color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();

		if($settings['style'] == '2'): ?>
		<div class="container">
			<div class="row">
				<?php foreach( $settings['items'] as $item ): ?>
					<div class="col-lg-3 col-md-3 col-6 col-sm-6">
						<div class="single-funfacts-box style-two">
							<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
							<h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
							<p><?php echo esc_html( $item['title'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php else: ?>
			<div class="funfacts-area bg-color">
				<div class="funfacts-inner" style="background-image:url(<?php echo esc_url($settings['number_bg']['url']); ?>);">
					<div class="container">
						<div class="row">
							<?php foreach( $settings['items'] as $item ): ?>
								<div class="col-lg-3 col-md-4 col-6 col-sm-4">
									<div class="single-funfacts-box white-color">
										<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
										<h3><span class="odometer" data-count="<?php echo esc_attr( $item['number'] ); ?>">00</span><span class="sign"><?php echo esc_html( $item['number_suffix'] ); ?></span></h3>
										<p><?php echo esc_html( $item['title'] ); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Funfacts );