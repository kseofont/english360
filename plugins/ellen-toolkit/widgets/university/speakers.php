<?php
/**
 * Team Widget
 */
namespace Elementor;
class Ellen_Speakers extends Widget_Base{
    public function get_name(){
        return "Ellen_Team";
    }
    public function get_title(){
        return "Team";
    }
    public function get_icon(){
        return "eicon-gallery-group";
    }
    public function get_categories(){
        return ['ellen-elements'];
    }
    protected function register_controls(){

    $this->start_controls_section(
        'Ellen_Team',
        [
            'label' => __( 'Ellen Team', 'ellen-toolkit' ),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]
    );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Our Speakers', 'ellen-toolkit'),
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
            'columns',
            [
                'label' => __( 'Choose Columns', 'saldana-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1'   => __( '1', 'saldana-toolkit' ),
                    '2'   => __( '2', 'saldana-toolkit' ),
                    '3'   => __( '3', 'saldana-toolkit' ),
                    '4'   => __( '4', 'saldana-toolkit' ),
                    '6'   => __( '6', 'saldana-toolkit' ),
                ],
                'default' => '4',
            ]
        );

        $repeater = new Repeater();

            $repeater->add_control(
                'member_img',
                [
                    'label' => esc_html__( 'Image', 'ellen-toolkit' ),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'name',
                [
                    'label' => esc_html__( 'Member Name', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $repeater->add_control(
                'icon1',
                [
                    'label' => esc_html__( 'Social Icon One', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('bx bxl-facebook', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'url1',
                [
                    'label' => esc_html__( 'Social Link One', 'ellen-toolkit' ),
                    'type' => Controls_Manager::URL,
                    'description' => esc_html__( 'This social link work only style one', 'ellen-toolkit'  ),
                ]
            );

            $repeater->add_control(
                'icon2',
                [
                    'label' => esc_html__( 'Social Icon Two', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('bx bxl-twitter', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'url2',
                [
                    'label' => esc_html__( 'Social Link Two', 'ellen-toolkit' ),
                    'type' => Controls_Manager::URL,
                    'description' => esc_html__( 'This social link work only style one', 'ellen-toolkit'  ),
                ]
            );

            $repeater->add_control(
                'icon3',
                [
                    'label' => esc_html__( 'Social Icon Three', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('bx bxl-instagram', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'url3',
                [
                    'label' => esc_html__( 'Social Link Three', 'ellen-toolkit' ),
                    'type' => Controls_Manager::URL,
                    'description' => esc_html__( 'This social link work only style one', 'ellen-toolkit'  ),
                ]
            );

            $repeater->add_control(
                'icon4',
                [
                    'label' => esc_html__( 'Social Icon Four', 'ellen-toolkit' ),
                   'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('bx bxl-linkedin', 'ellen-toolkit'),
                ]
            );
            $repeater->add_control(
                'url4',
                [
                    'label' => esc_html__( 'Social Link Four', 'ellen-toolkit' ),
                    'type' => Controls_Manager::URL,
                    'description' => esc_html__( 'This social link work only style one', 'ellen-toolkit'  ),
                ]
            );

            $repeater->add_control(
                'icon5',
                [
                    'label' => esc_html__( 'Social Icon Five', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );
            $repeater->add_control(
                'url5',
                [
                    'label' => esc_html__( 'Social Link Five', 'ellen-toolkit' ),
                    'type' => Controls_Manager::URL,
                    'description' => esc_html__( 'This social link work only style one', 'ellen-toolkit'  ),
                ]
            );

        $this->add_control(
            'teams',
            [
                'label' => esc_html__( 'Add Member', 'ellen-toolkit' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

    $this-> end_controls_section();

    // Start Style content controls
    $this-> start_controls_section(
        'section_style',
        [
            'label'=>esc_html__('Style', 'ellen-toolkit'),
            'tab'=> Controls_Manager::TAB_STYLE,
        ]
    );


        $this->add_control(
            'sec_title_color',
            [
                'label'     => __( 'Section Title Color', 'ellen-toolkit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .section-title h2, {{WRAPPER}} .section-title h3, {{WRAPPER}} .section-title h1, {{WRAPPER}} .section-title h4, {{WRAPPER}} .section-title h5, {{WRAPPER}} .section-title h6, {{WRAPPER}} .text-white' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'typography_sec_title',
                'label'    => __( 'Section Title Typography', 'ellen-toolkit' ),
                'selector' => '{{WRAPPER}} .section-title h2, {{WRAPPER}} .section-title h3, {{WRAPPER}} .section-title h1, {{WRAPPER}} .section-title h4, {{WRAPPER}} .section-title h5, {{WRAPPER}} .section-title h6',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Member Name Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-speaker-box h3' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_size',
				'label' => __( 'Name Typography', 'ellen-toolkit' ),
				'selector' => '{{WRAPPER}} .single-speaker-box h3',
			]
		);

        $this->add_control(
            'soc_color',
            [
                'label' => esc_html__( 'Social Link Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-speaker-box .social li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'soc_h_color',
            [
                'label' => esc_html__( 'Social Link Hover Color', 'ellen-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-speaker-box .social li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'soc_size',
				'label' => __( 'Social Link Typography', 'ellen-toolkit' ),
				
				'selector' => '{{WRAPPER}} .team-card span',
			]
		);
    $this-> end_controls_section();
}
    protected function render()
    {
        $settings = $this->get_settings_for_display();

            
            // Card Columns
            $columns = $settings['columns'];
            if ($columns == '1') {
                $column = 'col-lg-12 col-md-6';
            }elseif ($columns == '2') {
                $column = 'col-lg-6 col-md-6';
            }elseif ($columns == '3') {
                $column = 'col-lg-4 col-md-6 col-sm-6';
            }elseif ($columns == '4') {
                $column = 'col-lg-3 col-md-6 col-sm-6';
            }elseif ($columns == '6') {
                $column = 'col-xxl-2 col-xl-3 col-md-4 col-sm-6';
            }

        ?>

    
        <!-- Start Speakers Area -->
        <div class="speakers-area with-border pt-100 pb-75">
            <div class="container">
                <div class="section-title style-two">
                    <<?php echo esc_attr( $settings['title_tag'] ); ?> class="title-tgas"><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_tag'] ); ?>>
                </div>
                <div class="row justify-content-center">
                    <?php $i=1; foreach( $settings['teams'] as $item ): 
                    ?>
                        <div class="<?php echo esc_attr( $column );?>">
                            <div class="single-speaker-box bg1" <?php if($item['member_img']['url']): ?> style="background-image: url(<?php echo esc_url( $item['member_img']['url'] ); ?>);"  <?php endif; ?>>
                                <img src="<?php echo esc_url( $item['member_img']['url'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>">
                                <?php if( $item['name'] != '' ): ?>
                                    <h3><?php echo esc_html( $item['name'] ); ?></h3>
                                <?php endif; ?>
                                <ul class="social">
                                    <?php if( $item['icon1']!= '' && $item['url1']['url'] != '' ): ?>
                                        <li><a href="<?php echo esc_url( $item['url1']['url'] ); ?>" target="_blank"><i class='<?php echo esc_attr( $item['icon1'] ); ?>'></i></a></li>
                                    <?php endif; ?>
                                    <?php if( $item['icon2']!= '' && $item['url2']['url'] != '' ): ?>
                                        <li><a href="<?php echo esc_url( $item['url2']['url'] ); ?>" target="_blank"><i class='<?php echo esc_attr( $item['icon2'] ); ?>'></i></a></li>
                                    <?php endif; ?>
                                    <?php if( $item['icon3']!= '' && $item['url3']['url'] != '' ): ?>
                                        <li><a href="<?php echo esc_url( $item['url3']['url'] ); ?>" target="_blank"><i class='<?php echo esc_attr( $item['icon3'] ); ?>'></i></a></li>
                                    <?php endif; ?>
                                    <?php if( $item['icon4']!= '' && $item['url4']['url'] != '' ): ?>
                                        <li><a href="<?php echo esc_url( $item['url4']['url'] ); ?>" target="_blank"><i class='<?php echo esc_attr( $item['icon4'] ); ?>'></i></a></li>
                                    <?php endif; ?>
                                    <?php if( $item['icon5']!= '' && $item['url5']['url'] != '' ): ?>
                                        <li><a href="<?php echo esc_url( $item['url5']['url'] ); ?>" target="_blank"><i class='<?php echo esc_attr( $item['icon5'] ); ?>'></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
        <!-- End Speakers Area -->

    <?php
    }
}
Plugin::instance()->widgets_manager->register( new Ellen_Speakers );