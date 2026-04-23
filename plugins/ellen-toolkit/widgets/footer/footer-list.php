<?php
/**
 * Footer List Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_FooterList extends Widget_Base {

	public function get_name() {
        return 'Ellen_FooterList';
    }

	public function get_title() {
        return __( 'Footer List', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-bullet-list';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_FooterList',
			[
				'label' => __( 'Ellen Footer Info', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                'title', [
                    'label' => __( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Company' , 'ellen-toolkit' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label' => esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'h1'         => esc_html__( 'h1', 'ellen-toolkit' ),
                        'h2'         => esc_html__( 'h2', 'ellen-toolkit' ),
                        'h3'         => esc_html__( 'h3', 'ellen-toolkit' ),
                        'h4'         => esc_html__( 'h4', 'ellen-toolkit' ),
                        'h5'         => esc_html__( 'h5', 'ellen-toolkit' ),
                        'h6'         => esc_html__( 'h6', 'ellen-toolkit' ),
                    ],
                    'default' => 'h3',
                ]
            );

            $list_item = new Repeater();

                $list_item->add_control(
                    'list_tit', [
                        'label'       => esc_html__( 'List Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'About Us', 'ellen-toolkit' ),
                        'label_block' => true,
                    ]
                );

                $list_item->add_control(
                    'link_type',
                    [
                        'label' 		=> esc_html__( 'List Item Link Type', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' => [
                            '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                            '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                        ],
                    ]
                );
    
                $list_item->add_control(
                    'link_to_page',
                    [
                        'label' 		=> esc_html__( 'List Item Link To Page', 'ellen-toolkit' ),
                        'type' 			=> Controls_Manager::SELECT,
                        'label_block' 	=> true,
                        'options' 		=> ellen_toolkit_get_page_as_list(),
                        'condition' => [
                            'link_type' => '1',
                        ]
                    ]
                );
    
                $list_item->add_control(
                    'ex_link',
                    [
                        'label'		=> esc_html__('List Item External Link', 'ellen-toolkit'),
                        'type'		=> Controls_Manager::TEXT,
                        'condition' => [
                            'link_type' => '2',
                        ]
                    ]
                );

            $this->add_control(
                'list_items',
                [
                    'label'  => esc_html__( 'Add Info Item', 'ellen-toolkit' ),
                    'type'   => Controls_Manager::REPEATER,
                    'fields' => $list_item->get_controls(),
                ]
            );

        $this->end_controls_section();

        // Style Settings
        $this->start_controls_section(
			'Ellen_FooterList_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .footer-wrap-widget h2, {{WRAPPER}} .footer-wrap-widget h3, {{WRAPPER}} .footer-wrap-widget h4,{{WRAPPER}} .footer-wrap-widget h5, {{WRAPPER}} .footer-wrap-widget h6, {{WRAPPER}} .footer-wrap-widget h1' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .footer-wrap-widget h2, {{WRAPPER}} .footer-wrap-widget h3, {{WRAPPER}} .footer-wrap-widget h4,{{WRAPPER}} .footer-wrap-widget h5, {{WRAPPER}} .footer-wrap-widget h6, {{WRAPPER}} .footer-wrap-widget h1',
                ]
            );

            $this->add_control(
				'list_color',
				[
					'label' => esc_html__( 'List Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .custom-links li a' => 'color: {{VALUE}}',
					],
				]
            );

            $this->add_control(
				'list_h_color',
				[
					'label' => esc_html__( 'List Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .footer-wrap-widget .custom-links li a:hover' => 'color: {{VALUE}}',
					],
				]
            );
           
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'label' => __( 'List Typography', 'ellen-toolkit' ),
                    'name' => 'typography_list',
                    'selector' => '{{WRAPPER}} .footer-wrap-widget .custom-links li a',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();


        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <div class="footer-wrap-widget <?php if($settings['choose_style']==1): ?> university-home  <?php elseif($settings['choose_style']==2): ?>  school-college-home <?php elseif($settings['choose_style']==3): ?> health-wellness-fitness-home <?php endif; ?>">
            <<?php echo esc_attr( $settings['title_tag'] ); ?>>
                <?php echo wp_kses_post( $settings['title'] ); ?>
            </<?php echo esc_attr( $settings['title_tag'] ); ?>>
            <ul class="custom-links">
                <?php $i=1; foreach( $settings['list_items'] as $item ): 
                    
                    // Get Button Link
                    if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                        $link = get_page_link( $item['link_to_page'] );
                    }elseif($item['link_type'] == 2) {
                        $link = $item['ex_link'];
                    }else{
                        $link = '';
                    }

                ?>

                    <?php if ( $item['list_tit'] && $link) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $item['list_tit'] ); ?></a>
                        </li>
                    <?php endif; ?>

                <?php $i++; endforeach; ?>
            </ul>
        </div>
    <?php
	}


}

Plugin::instance()->widgets_manager->register_widget_type( new Ellen_FooterList );