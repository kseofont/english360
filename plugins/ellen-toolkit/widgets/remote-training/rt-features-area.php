<?php
/**
 * Remote Training Features Widget
 */

namespace Elementor;
class Ellen_RT_Features extends Widget_Base {

	public function get_name() {
        return 'RemoteTrainingFeatures';
    }

	public function get_title() {
        return __( 'Ellen Remote Training Features', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-info-box';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_RT_Features',
			[
				'label' => __( 'Features Control', 'ellen-toolkit' ),
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
                    '2'       => esc_html__( 'Style Two', 'ellen-toolkit' ),
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __( 'Choose Columns', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1   => __( '1', 'ellen-toolkit' ),
                    2   => __( '2', 'ellen-toolkit' ),
                    3   => __( '3', 'ellen-toolkit' ),
                    4   => __( '4', 'ellen-toolkit' ),
                ],
                'default' => 4,
            ]
        );

        $list_items = new Repeater();

            $list_items->add_control(
                'image',
                [
                    'label'		=> esc_html__('Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
                ]
            );
            $list_items->add_control(
                'title',
                [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Do you want to teach here?', 'ellen-toolkit' ),
                ]
            );
            $list_items->add_control(
                'content',
                [
                    'label' => __( 'Description', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'Explore all of our courses and pick your suitable ones to enroll and start learning with us!' ),
                ]
            );
        $this->add_control(
            'features_item',
            [
                'label' => esc_html__('Features Item', 'ellen-toolkit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $list_items->get_controls(),
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

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'banner_bg',
                    'label' => __( 'Section Background', 'ellen-toolkit' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .rt-features-area, {{WRAPPER}} .rt-choose-card',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Features Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .rt-features-card .content h3, {{WRAPPER}} .rt-choose-card .content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Features Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .rt-features-card .content h3, {{WRAPPER}} .rt-choose-card .content h3',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Features Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .rt-features-card .content p, {{WRAPPER}} .rt-choose-card .content p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Features Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .rt-features-card .content p, {{WRAPPER}} .rt-choose-card .content p',
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Card Columns
        $columns = $settings['columns'];
        if ($columns == 1) {
            $column = 'col-lg-12 col-sm-12 col-md-12';
        }elseif ($columns == 2) {
            $column = 'col-lg-6 col-md-6';
        }elseif ($columns == 3) {
            $column = 'col-lg-4 col-md-6';
        }elseif ($columns == 4) {
            $column = 'col-xl-3 col-lg-4 col-md-6 col-sm-6';
        }
        ?>
        <?php if($settings['style'] == '2'): ?>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <?php foreach( $settings['features_item'] as $item ): ?>
                        <div class="<?php echo esc_attr($column); ?>">
                            <div class="rt-choose-card">
                                <div class="content">
                                    <?php if( $item['image']['url'] != '' ): ?>
                                        <div class="icon-image">
                                            <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <h3><?php echo esc_html($item['title']); ?></h3>
                                    <?php if($item['content']): ?>
                                        <p><?php echo wp_kses_post($item['content']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="rt-features-area pt-100 pb-75">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <?php foreach( $settings['features_item'] as $item ): ?>
                            <div class="<?php echo esc_attr($column); ?>">
                                <div class="rt-features-card">
                                    <div class="content">
                                        <?php if( $item['image']['url'] != '' ): ?>
                                            <div class="icon-image">
                                                <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                                            </div>
                                        <?php endif; ?>

                                        <h3><?php echo esc_html($item['title']); ?></h3>
                                        <p><?php echo wp_kses_post($item['content']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
        endif;
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_RT_Features );