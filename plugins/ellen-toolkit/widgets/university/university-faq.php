<?php
/**
 * FAQ Widget
 */

namespace Elementor;
class University_Faq extends Widget_Base {

	public function get_name() {
        return 'FAQ_University';
    }

	public function get_title() {
        return __( 'University FAQ', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-help-o';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Faq_Area',
			[
				'label' => __( 'Faq Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                    'default' => __( 'Frequently Asked Questions', 'ellen-toolkit' ),
                ]
            );

            $this->add_control(
                'sec_content',
                [
                    'label'   => __( 'Section Content', 'ellen-toolkit' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( 'Explore answers to some of our most frequently asked questions.', 'ellen-toolkit' ),
                ]
            );

            $list_items = new Repeater();

                $list_items->add_control(
                    'title',
                    [
                        'label' => __( 'Title', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'What programs does the university offer?', 'ellen-toolkit' ),
                    ]
                );
                $list_items->add_control(
                    'content',
                    [
                        'label' => __( 'Description', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __( 'Admission requirements vary by program and level of study. Typically, youll need academic transcripts, proof of English proficiency (if applicable).', 'ellen-toolkit'),
                    ]
                );

            $this->add_control(
                'faq_item',
                [
                    'label' => esc_html__('Faq Item', 'ellen-toolkit'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $list_items->get_controls(),
                ]
            );

            $list_items_two = new Repeater();

                $list_items_two->add_control(
                    'title_two',
                    [
                        'label' => __( 'Title', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'What programs does the university offer?', 'ellen-toolkit' ),
                    ]
                );
                $list_items_two->add_control(
                    'content_two',
                    [
                        'label' => __( 'Description', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __( 'Admission requirements vary by program and level of study. Typically, youll need academic transcripts, proof of English proficiency (if applicable).', 'ellen-toolkit'),
                    ]
                );
                
            $this->add_control(
                'faq_item_two',
                [
                    'label' => esc_html__('Faq Item Two', 'ellen-toolkit'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $list_items_two->get_controls(),
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
                        '{{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_sec_title',
                    'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title h2, {{WRAPPER}} .section-wrap-title h3, {{WRAPPER}} .section-wrap-title h1, {{WRAPPER}} .section-wrap-title h4, {{WRAPPER}} .section-wrap-title h5, {{WRAPPER}} .section-wrap-title h6',
                ]
            );

            $this->add_control(
                'sec_content_color',
                [
                    'label' => esc_html__( 'Section Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .section-wrap-title p' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sec_content_typography',
                    'label' => esc_html__( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .section-wrap-title p',
                ]
            );

            $this->add_control(
                'faq_item_color',
                [
                    'label' => esc_html__( 'Faq Item Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'faq_item_h_color',
                [
                    'label' => esc_html__( 'Faq Item Title Collapsed Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-button:not(.collapsed)' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'faq_item_typography',
                    'label' => __( 'Faq Item Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-button',
                ]
            );

            $this->add_control(
                'faq_item_br_color',
                [
                    'label' => esc_html__( 'Faq Item Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-button' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'faq_item_h_br_color',
                [
                    'label' => esc_html__( 'List Item Collapsed Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-button:not(.collapsed)' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'faq_item_content_color',
                [
                    'label' => esc_html__( 'Faq Item Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-body p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'faq_item_content_typography',
                    'label' => __( 'Faq Item Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .faq-wrap-accordion .accordion .accordion-item .accordion-body p',
                ]
            );
            
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        ?>
       
        <!-- Start FAQ Wrap Area -->
        <div class="faq-wrap-area university-home pb-100">
            <div class="container">
                <div class="section-wrap-title text-center">
                    <<?php echo esc_attr( $settings['heading_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['sec_title'] ); ?></<?php echo esc_attr( $settings['heading_tag'] ); ?>>
                    <?php if( $settings['sec_content'] != '' ): ?>
                        <p><?php echo wp_kses_post( $settings['sec_content'] ); ?></p>
                    <?php endif; ?>
                </div>
                <div class="row justify-content-center g-4">
                    <div class="col-lg-6 col-md-12">
                        <div class="faq-wrap-accordion">
                            <div class="accordion" id="faqAccordion">
                                <?php $i = 1;  foreach( $settings['faq_item'] as $item ): 

                                    $cl='';
                                    if ($i == 1) {
                                        $cl='';
                                    }else {
                                        $cl='collapsed';
                                    }
                                    
                                ?>
                                    <div class="accordion-item">
                                        <button class="accordion-button <?php echo esc_attr($cl); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </button>
                                        <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 1): ?>show<?php endif; ?>" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <p><?php echo wp_kses_post($item['content'] ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="faq-wrap-accordion">
                            <div class="accordion" id="faqAccordion2">
                                <?php $i = 1;  foreach( $settings['faq_item_two'] as $item_two ): 
                                    
                                    $cl='';
                                    if ($i == 1) {
                                        $cl='';
                                    }else {
                                        $cl='collapsed';
                                    }
                                    
                                    
                                ?>
                                    <div class="accordion-item">
                                        <button class="accordion-button <?php echo esc_attr($cl); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse6<?php echo $i; ?>">
                                            <?php echo esc_html( $item_two['title_two'] ); ?>
                                        </button>
                                        <div id="collapse6<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 1): ?>show<?php endif; ?>" data-bs-parent="#faqAccordion2">
                                            <div class="accordion-body">
                                                <p><?php echo wp_kses_post($item_two['content_two'] ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End FAQ Wrap Area -->

        <?php
	}
}

Plugin::instance()->widgets_manager->register( new University_Faq );