<?php
/**
 * FAQ Widget
 */

namespace Elementor;
class Ellen_Faq extends Widget_Base {

	public function get_name() {
        return 'FAQ';
    }

	public function get_title() {
        return __( 'Ellen FAQ', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-help-o';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Faq',
			[
				'label' => __( 'Faq Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Ciao! How Can We Help You?', 'ellen-toolkit' ),
            ]
        );

        $this->add_control(
            'placeholder_text', [
                'label' => __( 'Placeholder Text', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search a question...' , 'ellen-toolkit' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_text', [
                'label' => __( 'Button text', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search' , 'ellen-toolkit' ),
                'label_block' => true,
            ]
        );

        $list_items = new Repeater();

        $list_items->add_control(
            'title',
            [
                'label' => __( 'Title', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Where should I incorporate my business?', 'ellen-toolkit' ),
            ]
        );
        $list_items->add_control(
            'content',
            [
                'label' => __( 'Description', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Ellen is always looking for talented information security and IT risk management professionals who are dedicated, hard working and looking for a challenge. If you are interested in employment with Ellen, a company who values you and your family, visit our careers page.

                ' ),
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

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-content h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .single-feedback-item .client-info .title h3, single-feedback-box .client-info .title h3',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'FAQ Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-accordion .accordion .accordion-item .accordion-button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'FAQ Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .faq-accordion .accordion .accordion-item .accordion-button',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Feedback Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .faq-accordion .accordion .accordion-item .accordion-body p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Feedback Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .faq-accordion .accordion .accordion-item .accordion-body p',
                ]
            );
        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        $faq_item = $settings['faq_item'];
        if(isset($_GET['faq'])):
            $default_value = $_GET['faq'];
        else:
            $default_value = '';
        endif;
        ?>
        <div class="faq-area ptb-100">
            <div class="container">
                <div class="faq-content">
                    <h2><?php echo esc_html($settings['title']); ?></h2>
                    <?php if($settings['placeholder_text'] != '' || $settings['button_text'] != '' ): ?>
                        <form method="get">
                            <label><i class='bx bx-search-alt'></i></label>
                            <input type="text" name="faq" class="input-search" value="<?php echo esc_attr($default_value); ?>" placeholder="<?php echo esc_attr($settings['placeholder_text']); ?>">
                            <?php if($settings['button_text'] ): ?>
                                <button type="submit" class="default-btn"><?php echo esc_html($settings['button_text']); ?></button>
                        <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="faq-accordion">
                    <div class="accordion" id="faqAccordion">
                        <?php $i = 1;  foreach( $faq_item as $item ): ?>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                    <?php echo esc_html( $item['title'] ); ?>
                                </button>
                                <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 1): ?>show<?php endif; ?>" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <?php echo wp_kses_post($item['content'] ); ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery(function ($) {
                'use strict';
                jQuery(document).on('ready', function () {
                    $(".input-search").keyup(function(){
                        var value = $(this).val().toLowerCase();
                        $("#faqAccordion .accordion-item").each(function(){
                            var search = $(this).text().toLowerCase();
                            if(search.indexOf(value)>-1){
                                $(this).fadeIn();
                            }
                            else{
                                $(this).fadeOut();
                            }
                        });
                    });
                });
            }(jQuery));
        </script>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Faq );