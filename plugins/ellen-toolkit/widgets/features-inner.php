<?php
/**
 * Features Inner Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Features_Inner extends Widget_Base {

	public function get_name() {
        return 'Ellen_FeaturesInner';
    }

	public function get_title() {
        return __( 'Features Inner', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-star-o';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'features_inner_section',
			[
				'label' => __( 'Features Control', 'ellen-toolkit' ),
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
                    '3'   => 'Style Three',
                ],
                'default' => '1',
            ] );

			$this->add_control(
                'number_bg',
                [
                    'label' => esc_html__( 'Background Shape Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

			$repeater = new Repeater();

            $repeater->add_control(
                'title', [
					'type'    => Controls_Manager::TEXT,
					'label'   => esc_html__( 'Title', 'ellen-toolkit' ),
					'default' => esc_html__('COURSES', 'ellen-toolkit'),
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
                    'label'   => esc_html__( 'Add Item', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
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
						'{{WRAPPER}} .features-area.bg-color::before' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-features-box.white-color h3' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-features-box.white-color h3',
                ]
            );

			$this->add_control(
				'icon_color',
				[
					'label' => __( 'Icon Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-features-box.white-color i' => 'color: {{VALUE}}',
					],
				]
			);

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <?php if($settings['style'] == '1'): ?>
            <div class="features-area bg-color">
                <div class="features-inner" style="background-image:url(<?php echo esc_url($settings['number_bg']['url']); ?>);">
                    <div class="container">
                        <div class="row">
                            <?php $i = 0; foreach( $settings['items'] as $item ): ?>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 col-sm-4 <?php if($i == 0): ?>offset-xl-3<?php endif; ?>">
                                    <div class="single-features-box white-color">
                                        <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                                        <h3><?php echo esc_html( $item['title'] ); ?></h3>
                                    </div>
                                </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php if($settings['shape_image']['url']): ?>
                    <div class="shape5"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>"></div>
                <?php endif; ?>
            </div>
        <?php elseif($settings['style'] == '2'): ?>
            <?php if($settings['number_bg']['url']): ?>
                <style>
                    .features-area.pt-100.pb-75.bg-image::before {
                        background-image: url(<?php echo esc_url($settings['number_bg']['url']); ?>);
                    }
                </style>
            <?php endif; ?>
            <div class="features-area pt-100 pb-75 bg-image">
                <div class="container">
                    <div class="features-inner-box">
                        <div class="row">
                            <?php $i = 0; foreach( $settings['items'] as $item ): ?>
                                <div class="col-lg-4 col-md-4 col-6 col-sm-4">
                                    <div class="single-features-box white-color">
                                        <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                                        <h3><?php echo esc_html( $item['title'] ); ?></h3>
                                    </div>
                                </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php if($settings['shape_image']['url']): ?>
                    <div class="shape5"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>"></div>
                <?php endif; ?>
            </div>
        <?php elseif($settings['style'] == '3'): ?>
            <?php if($settings['number_bg']['url']): ?>
                <style>
                    .features-area.bg-image::before {
                        background-image: url(<?php echo esc_url($settings['number_bg']['url']); ?>);
                    }
                </style>
            <?php endif; ?>
            <div class="features-area pt-100 pb-75 style-two bg-image">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php $i = 0; foreach( $settings['items'] as $item ): ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-6 col-sm-4">
                                <div class="single-features-box white-color">
                                    <i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
                                    <h3><?php echo esc_html( $item['title'] ); ?></h3>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>
                </div>
                <?php if($settings['shape_image']['url']): ?>
                    <div class="shape5"><img src="<?php echo esc_url($settings['shape_image']['url']); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>"></div>
                <?php endif; ?>
                <div class="lines">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
        <?php endif; ?>
        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_Features_Inner );