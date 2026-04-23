<?php
/**
 * Blog Post Widget
 */

namespace Elementor;
class Sc_Right_Blog extends Widget_Base {

	public function get_name() {
        return 'Blog_Sc';
    }

	public function get_title() {
        return __( 'School & College Right Post', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-grid';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'blog_section',
			[
				'label' => __( 'Blog Post', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'top_title',
                [
                    'label'       => __( 'Top Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('ARTICLES', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'title_tag',
                [
                    'label' 	=> esc_html__( 'Title Tag', 'ellen-toolkit' ),
                    'type' 		=> Controls_Manager::SELECT,
                    'options' 	=> [
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
                'title',
                [
                    'label'       => __( 'Title', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __('Headlines from the campus', 'ellen-toolkit'),
                    'label_block' => true,
                ]
            );

            $this->add_control(
				'button_text',
				[
					'label' 	=> esc_html__( 'Button Text', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('View All Articles', 'ellen-toolkit'),
				]
            );

            $this->add_control(
				'button_icon',
				[
					'label' 	=> esc_html__( 'Button Icon', 'ellen-toolkit' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__('bx bx-chevron-right', 'ellen-toolkit'),
				]
            );

            $this->add_control(
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

            $this->add_control(
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

            $this->add_control(
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
                'cat_name', [
                    'label'       => __( 'Category', 'ellen-toolkit' ),
                    'description' => __( 'Enter the category slugs separated by commas (Eg. cat1, cat2)', 'ellen-toolkit' ),
                    'type'        => Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Post Order By', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'ellen-toolkit' ),
                        'ASC'       => __( 'ASC', 'ellen-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            $this->add_control(
                'count',
                [
                    'label' => __( 'Post Per Page', 'ellen-toolkit' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'banner_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


            $this->add_control(
                'top_title_bg_color',
                [
                    'label' => esc_html__( 'Top Title Left Dot Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .content .sub::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label' => esc_html__( 'Top Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .content .sub' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'Top_title_typography',
                    'label' => esc_html__( 'Top Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-blog-right .content .sub',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-about-content .title-tgas' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-about-content .title-tgas',
                ]
            );

            $this->add_control(
                'cd_br_color',
                [
                    'label' => esc_html__( 'Card Border Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .items .item' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cd_tag_color',
                [
                    'label'     => __( 'Card Tags Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .items .item .top' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_tags',
                    'label'    => __( 'Card Tags Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-right .items .item .top',
                ]
            );

            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .items .item h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_title_h_color',
                [
                    'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .items .item h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}}.sc-blog-right .items .item h3',
                ]
            );

            $this->add_control(
                'cd_date_color',
                [
                    'label'     => __( 'Card Date Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-right .items .item span' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_date',
                    'label'    => __( 'Card Date Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-right .items .item span',
                ]
            );
            
            $this->add_control(
				'btn_color',
				[
					'label' => __( 'Button Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-blog-right .bottom .link-btn' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_control(
				'btn_hover_color',
				[
					'label' => __( 'Button Hover Color', 'ellen-toolkit' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sc-blog-right .bottom .link-btn:hover' => 'color: {{VALUE}} !important',
					],
				]
			);

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => esc_html__( 'Button Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .sc-blog-right .bottom .link-btn',
                ]
            );

            

        $this->end_controls_section();



    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        // Get Banner Button Link
        $target     = '';
        $nofollow   = '';
        if ($settings['link_type'] == 1 && !empty($settings['link_to_page']) && get_post_status($settings['link_to_page'])) {
            $link       = get_page_link( $settings['link_to_page'] );
        }elseif($settings['link_type'] == 2) {
            $target     = $settings['ex_link']['is_external'] ? ' target="_blank"' : '';
		    $nofollow   = $settings['ex_link']['nofollow'] ? ' rel="nofollow"' : '';
            $link       = $settings['ex_link']['url'];
        }else{
            $link = '';
        }

        if ($settings['cat_name'] != '') {
            $args = array(
                'orderby' => 'date',
                'order' => $settings['order'],
                'posts_per_page' => $settings['count'],
                'ignore_sticky_posts' => 1,
                'tax_query' => array(
                    array(
						'taxonomy' => 'category',
						'field'    => 'slug',
                        'terms' => explode( ',', str_replace( ' ', '', $settings['cat_name'])),
                    )
                )
            );
        }else{
            $args = array(
                'orderby' => 'date',
                'order' => $settings['order'],
                'posts_per_page' => $settings['count'],
                'ignore_sticky_posts' => 1,
            );
        }
        $post_array = new \WP_Query( $args );

        // Title tag
		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h2';

        ?>


        <div class="sc-blog-right school-college-home">
            <div class="content">
                <?php if( $settings['top_title']): ?>
                    <span class="sub"><?php echo wp_kses_post($settings['top_title'] ); ?></span>
                <?php endif; ?>
                <?php if( $settings['title']): ?>
                    <<?php echo $title_tag;?> class="title-tgas"><?php echo wp_kses_post($settings['title'] ); ?></<?php echo $title_tag; ?>>
                <?php endif; ?>
            </div>
            <div class="items">
                <?php $i=1; while($post_array->have_posts()): $post_array->the_post(); 

                    // Category 
                    $ellen_blog_category = get_the_terms(get_the_ID(), 'category');
                        
                    if($ellen_blog_category && ! is_wp_error( $ellen_blog_category )) {
                        $blog_cat_list = array();
                        
                        foreach($ellen_blog_category as $category) {
                            $blog_cat_list[] = $category->name; 
                            $category_link = get_category_link($category);
                            $category_ass ='<a href="' . esc_url($category_link) .'" class="top">' . esc_html($category->name) . ' </a>';
                        }
                    } 

                    $clNam = '';
                    if($i==2){
                        $clNam= 'wrap2';
                    }elseif($i==3){
                        $clNam= 'wrap3';
                    }elseif($i==4){
                        $clNam= 'wrap4';
                    }

                ?>
                    <div class="item <?php echo esc_attr( $clNam ); ?>">
                        <?php if($category_ass !=''){?>
                          
                            <?php echo wp_kses_post($category_ass); ?>
                            
                        <?php } ?>
                        <h3>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <span><?php echo esc_html(get_the_date()); ?></span>
                    </div>
                <?php $i++; endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <?php if($settings['button_text'] && $link): ?>
                <div class="bottom">
                    <a href="<?php echo esc_url($link); ?>" <?php echo $target; echo $nofollow; ?> class="link-btn"><?php echo esc_html($settings['button_text']); ?> <?php if($settings['button_icon']): ?><i class='<?php echo esc_attr($settings['button_icon']); ?>'></i><?php endif; ?></a>
                </div>
            <?php endif; ?>
        </div>

    <?php
    }

}

Plugin::instance()->widgets_manager->register( new Sc_Right_Blog );