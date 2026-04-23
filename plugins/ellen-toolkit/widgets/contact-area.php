<?php
/**
 * Contact Area Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Contact_Area extends Widget_Base {

	public function get_name() {
        return 'Contact_Area';
    }

	public function get_title() {
        return esc_html__( 'Contact Area', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-form-horizontal';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Contact_Area',
			[
				'label' => esc_html__( 'Ellen Contact Area', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label' => esc_html__( 'Top Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('CONTACT DETAILS', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Get in Touch', 'ellen-toolkit'),
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
                    'default' => 'h2',
                ]
            );

            $this->add_control(
                'content',
                [
                    'label' => esc_html__( 'Content', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__('Have a inquiry or some feedback for us? Fill out the form below to contact our team. For partnership and business development inquiries, please contact us at hello@ellen.com.', 'ellen-toolkit'),
                ]
            );

            $repeater = new Repeater();
            $repeater->add_control(
                'title', [
                    'label'     => __( 'Title', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__('10,000 Online Courses', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'default_icon', [
                    'label' => esc_html__( 'Select Icon', 'ellen-toolkit' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'options' => ellen_flaticons(),
                ]
            );
            $repeater->add_control(
                'content', [
                    'label'     => __( 'Content', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::TEXTAREA,
                    'default'   => esc_html__('2750 Quadra Street Victoria Road, New York, Canada', 'ellen-toolkit'),
                ]
            );

            $this->add_control(
                'list_items',
                [
                    'label' => esc_html__('Card Item', 'ellen-toolkit'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
            );

            $this->add_control(
                'image',
                [
                    'label' => esc_html__( 'Contact Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .contact-info-content-content .sub-title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'top_title_typography',
                    'label' => __( 'Top Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .contact-info-content-content .sub-title',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .contact-info-content h2, .contact-info-content h3, .contact-info-content h4, .contact-info-content h5, .contact-info-content h5, .contact-info-content h6, .contact-info-content h1' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .contact-info-content h2, .contact-info-content h3, .contact-info-content h4, .contact-info-content h5, .contact-info-content h5, .contact-info-content h6, .contact-info-content h1',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .contact-info-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .contact-info-content p',
                ]

            );
            $this->add_control(
                'list_title_color',
                [
                    'label' => esc_html__( 'List Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .contact-info-content ul li h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'lis_title_content_typography',
                    'label' => __( 'List Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .contact-info-content ul li h3',
                ]
            );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Inline Editing
        $this-> add_inline_editing_attributes('title','none');
        $this-> add_inline_editing_attributes('content','none');
        ?>
        <div class="contact-info-area pt-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="contact-info-content">
                            <span class="sub-title"><?php echo esc_html( $settings['top_title'] ); ?></span>
                            <<?php echo esc_attr( $settings['title_tag'] ); ?> <?php echo $this-> get_render_attribute_string('title'); ?>><?php echo esc_html( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                            <p <?php echo $this-> get_render_attribute_string('content'); ?>><?php echo wp_kses_post( $settings['content'] ); ?></p>
                            <ul>
                                <?php foreach( $settings['list_items'] as $item ):
                                    // Icon
                                    $icon =$item['default_icon'];
                                    ?>
                                    <li>
                                        <div class="icon">
                                            <i class="<?php echo esc_attr( $icon ); ?>"></i>
                                        </div>
                                        <h3><?php echo esc_html( $item['title'] ); ?></h3>
                                        <?php echo wp_kses_post( $item['content'] ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <?php if($settings['image']['url']): ?>
                            <div class="contact-info-image">
                                <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Contact_Area );