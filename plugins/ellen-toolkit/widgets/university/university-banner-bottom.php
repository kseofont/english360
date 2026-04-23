<?php
/**
 * Fan Fact Widget
 */

namespace Elementor;
class Ellen_BannerBottom extends Widget_Base {

	public function get_name() {
        return 'BannerBottom';
    }

	public function get_title() {
        return __( 'Banner Bottom', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-thumbnails-down';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $list_items = new Repeater();

                $list_items->add_control(
                    'title',
                    [
                        'type'    => Controls_Manager::TEXT,
                        'label'   => __( 'Title', 'ellen-toolkit' ),
                        'default' => __('Study', 'ellen-toolkit'),
                    ]
                );

                $list_items->add_control(
                    'title_icon',
                    [
                        'type'    => Controls_Manager::TEXT,
                        'label'   => __( 'Title Icon', 'ellen-toolkit' ),
                        'default' => __('bx bx-right-arrow-circle', 'ellen-toolkit'),
                    ]
                );

                $list_items->add_control(
                    'title_url',
                    [
                        'type'    => Controls_Manager::TEXT,
                        'label'   => __( 'Title Url', 'ellen-toolkit' ),
                        'default' => __('#', 'ellen-toolkit'),
                    ]
                );
           
            $this->add_control(
                'items',
                [
                    'label'   => __( 'Add List Item', 'ellen-toolkit' ),
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

            $this->add_control(
                'title_color',
                [
                    'label'     => __( 'Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-boxes h5' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'title_typography',
                    'label'    => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-boxes h5',
                ]
            );

            $this->add_control(
                'title_icon_color',
                [
                    'label'     => __( 'Title Icon Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .university-boxes i' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'title_icon_typography',
                    'label'    => __( 'Title Icon Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .university-boxes i',
                ]
            );

            $this->add_control(
				'tit_bg_color',
				[
					'label'     => __( 'Title Background Color', 'ellen-toolkit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-boxes' => 'background-color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'tit_bg_h_color',
				[
					'label'     => __( 'Title Hover Background Color', 'ellen-toolkit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .university-boxes:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

            $this->add_responsive_control(
                'card_padding',
                [
                    'label' => esc_html__( 'Card Padding', 'ellen-toolkit' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .university-boxes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        $this-> add_inline_editing_attributes('title','none'); 

        ?>

        <!-- Start University Boxes Area -->
        <div class="university-boxes-area university-home">
            <div class="container-fluid">
                <div class="row justify-content-center g-0">
                    <?php $i=1; foreach( $settings['items'] as $item ): 

                        $cls = '';
                        if($i==2){
                            $cls = 'purple';
                        }elseif($i==3){
                            $cls = 'blue';
                        }
                        
                    ?>
                        <?php if( $item['title'] && $item['title_url']): ?>
                            <div class="col-lg-4 col-md-4">
                                <a href="<?php echo esc_attr( $item['title_url'] ); ?>" class="university-boxes <?php echo esc_attr( $cls ); ?>">
                                    <h5><?php echo esc_html( $item['title'] ); ?></h5>
                                   
                                    <?php if( $item['title_icon']): ?>
                                        <i class='<?php echo esc_attr( $item['title_icon'] ); ?>'></i>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php $i++; endforeach; ?>   
                </div>
            </div>
        </div>
        <!-- End University Boxes Area -->

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_BannerBottom );