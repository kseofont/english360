<?php
/**
 * Features Widget
 */

namespace Elementor;
class Ellen_Features extends Widget_Base {

	public function get_name() {
        return 'Features';
    }

	public function get_title() {
        return __( 'Ellen Features', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-info-box';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Features',
			[
				'label' => __( 'Features Control', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
                'default' => 2,
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
            $list_items->add_control(
                'button_text',
                [
                    'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> esc_html__('Register Now', 'ellen-toolkit'),
                ]
            );

            $list_items->add_control(
                'login_button_text',
                [
                    'label' 	=> esc_html__( 'Logged In Button Text', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::TEXT,
                    'default' 	=> esc_html__('Profile', 'ellen-toolkit'),
                ]
            );

            $list_items->add_control(
                'link_type',
                [
                    'label' 		=> esc_html__( 'Button Link Type', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' => [
                        '1'  	=> esc_html__( 'Link To Page', 'ellen-toolkit' ),
                        '2' 	=> esc_html__( 'External Link', 'ellen-toolkit' ),
                    ],
                    'default' 	=> '1',
                ]
            );

            $list_items->add_control(
                'link_to_page',
                [
                    'label' 		=> esc_html__( 'Button Link Page', 'ellen-toolkit' ),
                    'type' 			=> Controls_Manager::SELECT,
                    'label_block' 	=> true,
                    'options' 		=> ellen_toolkit_get_page_as_list(),
                    'condition' => [
                        'link_type' => '1',
                    ]
                ]
            );

            $list_items->add_control(
                'ex_link',
                [
                    'label'		=> esc_html__('Button External Link', 'ellen-toolkit'),
                    'type'        => Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'separator'   => 'before',
                    'condition' => [
                        'link_type' => '2',
                    ]
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

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Features Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-features-item h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Features Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .single-features-item h3',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Features Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-features-item p' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Features Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .single-features-item p',
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
            $column = 'col-lg-3 col-md-6';
        }
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <?php foreach( $settings['features_item'] as $item ):
                    // Get Banner Button Link
                    $target     = '';
                    $nofollow   = '';
                    if ($item['link_type'] == 1 && !empty($item['link_to_page']) && get_post_status($item['link_to_page'])) {
                        $link       = get_page_link( $item['link_to_page'] );
                    }elseif($item['link_type'] == 2) {
                        $target     = $item['ex_link']['is_external'] ? ' target="_blank"' : '';
                        $nofollow   = $item['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
                        $link       = $item['ex_link']['url'];
                    }else{
                        $link = '';
                    }
                    ?>
                    <div class="<?php echo esc_attr($column); ?>">
                        <div class="single-features-item">
                            <?php if( $item['image']['url'] != '' ): ?>
                                <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                            <?php endif; ?>

                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo wp_kses_post($item['content']); ?></p>

                            <?php if($item['button_text']):
                                if ( is_user_logged_in() ) {
                                    $title = $item['login_button_text'];
                                 } else {
                                    $title = $item['button_text'];
                                 }
                                ?>

                                <a href="<?php echo esc_url($link); ?>" class="default-btn style-two"><?php echo esc_html($title); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Features );