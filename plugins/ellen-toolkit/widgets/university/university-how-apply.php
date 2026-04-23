<?php
/**
 * How Apply Widget
 */

namespace Elementor;
class University_How_Apply extends Widget_Base {

	public function get_name() {
        return 'UniversityHowApply';
    }

	public function get_title() {
        return __( 'University How Apply', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-slider-device';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Section',
			[
				'label' => __( 'Ellen Section', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'heading_tag', [
                    'label'   => __( 'Title Heading Tag', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default'     => 'h2',
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'sec_title',
                [
                    'label'   => __( 'Section Title', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Ready to Apply?', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Start your journey with us today! Explore our diverse programs, meet admission requirements, and prepare your documents.', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content2',
                [
                    'label'   => __( 'Section Content Two', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Our application process is simple and designed to guide you every step of the way. Dont wait—take the first step toward your future now!', 'ellen-toolkit' ),
                ]
            );

            $list_item = new Repeater();

                $list_item->add_control(
                    'list_tit', [
                        'label'       => esc_html__( 'List Item Title', 'ellen-toolkit' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Entry requirements', 'ellen-toolkit' ),
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

            $this->add_control(
                'f_img',
                [
                    'label'		=> esc_html__('Feature Image', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
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
                'sec_title_color',
                [
                    'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content h2, {{WRAPPER}} .ready-to-apply-content h3, {{WRAPPER}} .ready-to-apply-content h1, {{WRAPPER}} .ready-to-apply-content h4, {{WRAPPER}} .ready-to-apply-content h5, {{WRAPPER}} .ready-to-apply-content h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .ready-to-apply-content h2, {{WRAPPER}} .ready-to-apply-content h3, {{WRAPPER}} .ready-to-apply-content h1, {{WRAPPER}} .ready-to-apply-content h4, {{WRAPPER}} .ready-to-apply-content h5, {{WRAPPER}} .ready-to-apply-content h6',
                ]
            );

            $this->add_control(
                'sec_content_color',
                [
                    'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content p' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .ready-to-apply-content p',
                ]
            );

            $this->add_control(
                'list_item_color',
                [
                    'label' => esc_html__( 'List Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content .lists li a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_h_color',
                [
                    'label' => esc_html__( 'List Item Hover Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content .lists li a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_bg_color',
                [
                    'label' => esc_html__( 'List Item Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content .lists li a' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'list_item_h_bg_color',
                [
                    'label' => esc_html__( 'List Item Hover Background Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .ready-to-apply-content .lists li a:hover' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'list_item_typography',
                    'label' => __( 'List Item Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .ready-to-apply-content .lists li a',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        ?>

        <!-- Start Ready to Apply Area -->
        <div class="ready-to-apply-area university-home ptb-100">
            <div class="container">
                <div class="row justify-content-center align-items-end">
                    <div class="col-lg-6 col-md-12">
                        <div class="ready-to-apply-content">
                            <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                            <?php if( $settings['sec_content'] != '' ): ?>
                                <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                            <?php endif; ?>
                            <?php if( $settings['sec_content2'] != '' ): ?>
                                <p><?php echo wp_kses_post( $settings['sec_content2'] ); ?></p>
                            <?php endif; ?>
                           
                            <ul class="lists">
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
                    </div>

                    <?php if( !empty( $settings['f_img']['url'] ) ){ ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="ready-to-apply-image">
                                <img src="<?php echo esc_url( $settings['f_img']['url'] ); ?>" alt="<?php echo esc_attr__( 'Image', 'ellen-toolkit' ); ?>">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Ready to Apply Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new University_How_Apply );