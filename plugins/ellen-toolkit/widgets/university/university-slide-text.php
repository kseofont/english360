<?php
/**
 * fade Text Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_University_Slide_Text extends Widget_Base {

	public function get_name() {
        return 'University_Slide_Text';
    }

	public function get_title() {
        return __( 'University Text Slide', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-t-letter';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_partner_Section',
			[
				'label' => __( 'Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
                    ],
                    'default' => '1',
                ]
            );

            $repeater = new Repeater();
            
            $repeater->add_control(
                'text_title', [
                    'type'    => Controls_Manager::TEXT,
                    'label'   => esc_html__( 'Text Slider Title', 'ellen-toolkit' ),
                    'default' => esc_html__( 'Ellen The University of South Wales', 'ellen-toolkit' ),
                ]
            );
            $repeater->add_control(
                'text_star', [
                    'type'    => Controls_Manager::TEXT,
                    'label'   => esc_html__( 'Text Slider Gap', 'ellen-toolkit' ),
                    'default' => esc_html__( '*', 'ellen-toolkit' ),
                ]
            );
            $this->add_control(
                'text_slider',
                [
                    'label'   => esc_html__( 'Add Text Slide', 'ellen-toolkit' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );
        $this->end_controls_section();

        // Start Style content controls
         $this-> start_controls_section(
            'heading_style',
            [
                'label' => __('Posts Style', 'ellen-toolkit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'sec_bg_color',
                [
                    'label' => __( 'Section Background Color', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .advertise-wrap-area' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'choose_style' => ['2'],
                    ]
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', 'ellen-toolkit' ),
                    'type'  => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .advertise-content h1, {{WRAPPER}} .advertise-wrap-content h1' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'title_typography',
                    'label'    => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .advertise-content h1, {{WRAPPER}} .advertise-wrap-content h1',
                ]
            );
            
        $this-> end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        ?>

        <?php if($settings['choose_style']==1): ?>
            <!-- Start Advertise Area -->
            <div class="university-home advertise-area pb-100">
                <div class="container-fluid">
                    <div class="advertise-content">
                        <h1>
                            <?php 
                                $i=1; foreach( $settings['text_slider'] as $item ): 
                            ?>
                                <?php if($item['text_title']): ?>
                                    <span><?php echo wp_kses_post( $item['text_title'] ); ?></span>
                                <?php endif; ?>
                                <?php if($item['text_star']): ?>
                                    <span class="gap"><?php echo wp_kses_post( $item['text_star'] ); ?></span>
                                <?php endif; ?>
                            <?php 
                                $i++; 
                            endforeach; 
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <!-- End Advertise Area -->
        <?php elseif($settings['choose_style']==2): ?>

            <!-- Start Advertise Wrap Area -->
            <div class="advertise-wrap-area school-college-home">
                <div class="container-fluid">
                    <div class="advertise-wrap-content">
                        <h1>
                            <?php 
                                $i=1; foreach( $settings['text_slider'] as $item ): 
                            ?>
                                <?php if($item['text_title']): ?>
                                    <span><?php echo wp_kses_post( $item['text_title'] ); ?></span>
                                <?php endif; ?>
                                <?php if($item['text_star']): ?>
                                    <span class="gap"><?php echo wp_kses_post( $item['text_star'] ); ?></span>
                                <?php endif; ?>
                            <?php 
                                $i++; 
                            endforeach; 
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <!-- End Advertise Wrap Area -->

        <?php endif; ?>

        <?php
	}

}

Plugin::instance()->widgets_manager->register( new Ellen_University_Slide_Text );