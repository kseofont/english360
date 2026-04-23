<?php
/**
 * Blog Post Widget
 */

namespace Elementor;
class Sc_left_Post extends Widget_Base {

	public function get_name() {
        return 'Sc_left_Blog';
    }

	public function get_title() {
        return __( 'School & College Left Post', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-grid';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'sc_left_section',
			[
				'label' => __( 'Blog Post', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'sc_left_style',
			[
				'label' => esc_html__( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            $this->add_control(
                'top_cd_tag_color',
                [
                    'label'     => __( 'Top Card Tags Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .top-item .content .meta li a' => 'color: {{VALUE}}',
                    ],
                ]
            );
           
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_rh_cd_tags',
                    'label'    => __( 'Top Card Tags Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .top-item .content .meta li a',
                ]
            );

            $this->add_control(
                'rh_cd_date_color',
                [
                    'label'     => __( 'Top Card Date Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .top-item .content .meta li:last-child' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_rh_date',
                    'label'    => __( 'Top Card Date Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .top-item .content .meta li:last-child',
                ]
            );

            $this->add_control(
                'top_cd_title_color',
                [
                    'label'     => __( 'Top Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .top-item .content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'top_cd_title_h_color',
                [
                    'label'     => __( 'Top Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .top-item .content h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_top_cd_title',
                    'label'    => __( 'Top Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .top-item .content h3',
                ]
            );

            $this->add_control(
                'cd_tag_color',
                [
                    'label'     => __( 'Card Tags Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .item .image .tags' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_tag_bg_color',
                [
                    'label'     => __( 'Card Tags Background Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .item .image .tags' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_tags',
                    'label'    => __( 'Card Tags Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .item .image .tags',
                ]
            );

            $this->add_control(
                'cd_date_color',
                [
                    'label'     => __( 'Card Date Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .item .content span' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_date',
                    'label'    => __( 'Card Date Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .item .content span',
                ]
            );

            $this->add_control(
                'cd_title_color',
                [
                    'label'     => __( 'Card Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .item .content h3 a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cd_title_h_color',
                [
                    'label'     => __( 'Card Title Hover Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .sc-blog-left .item .content h3 a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(), [
                    'name'     => 'typography_cd_title',
                    'label'    => __( 'Card Title Typography', 'ellen-toolkit' ),
                    'selector' => ' {{WRAPPER}} .sc-blog-left .item .content h3',
                ]
            );

        $this->end_controls_section();



    }

	protected function render() {
        $settings = $this->get_settings_for_display();

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

        ?>

        <div class="sc-blog-left school-college-home">
            <?php $i=1; while($post_array->have_posts()): $post_array->the_post(); 

                // Category 
                $ellen_blog_category = get_the_terms(get_the_ID(), 'category');
                    
                if($ellen_blog_category && ! is_wp_error( $ellen_blog_category )) {
                    $blog_cat_list = array();
                    
                    foreach($ellen_blog_category as $category) {
                        $blog_cat_list[] = $category->name; 
                        $category_link = get_category_link($category);
                        $category_ass ='<a href="' . esc_url($category_link) .'">' . esc_html($category->name) . ' </a>';
                    }
                } 

                if($i==1):
            ?>
                <div class="top-item">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_post_thumbnail_url( 'ellen-senior-1296X760' ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                    </a>
                    <div class="content">
                        <ul class="meta">
                            <?php if($category_ass !=''){?>
                                <li>
                                    <?php echo wp_kses_post($category_ass); ?>
                                </li>
                            <?php } ?>
                            <?php if(get_the_date() != '' ): ?>
                                <li> <?php echo esc_html(get_the_date()); ?></li>
                            <?php endif; ?>
                            
                        </ul>
                        <h3>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </div>
                </div>
            <?php endif; $i++; endwhile; ?>
            <?php wp_reset_postdata(); ?>

            <div class="row justify-content-center g-4">
                <?php $i=1; while($post_array->have_posts()): $post_array->the_post(); 

                    // Category 
                    $ellen_blog_category = get_the_terms(get_the_ID(), 'category');
                        
                    if($ellen_blog_category && ! is_wp_error( $ellen_blog_category )) {
                        $blog_cat_list = array();
                        
                        foreach($ellen_blog_category as $category) {
                            $blog_cat_list[] = $category->name; 
                            $category_link = get_category_link($category);
                            $category_ass ='<a href="' . esc_url($category_link) .'">' . esc_html($category->name) . ' </a>';
                        }
                    } 

                    if($i==2 || $i==3):
                ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="item">
                            <div class="image">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url( 'ellen-senior-624X492' ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                </a>
                                <?php if($category_ass !=''){?>
                                    <span>
                                        <?php echo wp_kses_post($category_ass); ?>
                                    </span>
                                <?php } ?>
                               
                            </div>
                            <div class="content">
                                <h3>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php if(get_the_date() != '' ): ?>
                                    <span><?php echo esc_html(get_the_date()); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; $i++; endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>

    <?php
    }

}

Plugin::instance()->widgets_manager->register( new Sc_left_Post );