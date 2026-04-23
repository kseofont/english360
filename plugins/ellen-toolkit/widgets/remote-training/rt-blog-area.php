<?php
/**
 * Blog Slider Widget
 */

namespace Elementor;
class Ellen_Blog_Slider extends Widget_Base {

	public function get_name() {
        return 'EllenBlogSlider';
    }

	public function get_title() {
        return __( 'Blog Slider', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-carousel';
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

            $this->add_control( 'class', [
                'label'       => esc_html__( 'Section Class', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'ptb-100',
                'label_block' => true,
            ] );

            $this->add_control( 'title', [
                'label'       => esc_html__( 'Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Ellen latest publications​', 'ellen-toolkit' ),
                'placeholder' => esc_html__( 'Enter your title', 'ellen-toolkit' ),
                'label_block' => true,
            ] );

            $this->add_control( 'title_tag', [
                'label'   => esc_html__( 'Title HTML Tag', 'ellen-toolkit' ),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ] );

            $this->add_control(
                'cat_name',
                [
                    'label' => __( 'Select Category', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ellen_toolkit_get_post_cat_list(),
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

            $this->add_control(
                'shape1',
                [
                    'label'		=> esc_html__('Shape Image One', 'ellen-toolkit'),
                    'type'		=> Controls_Manager:: MEDIA,
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
                        'terms' => $settings['cat_name'],
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
        <div class="rt-blog-area <?php echo esc_attr($settings['class']); ?> ">
            <div class="container">
                <div class="section-title with-just-heading">
                    <<?php echo esc_attr( $settings['title_tag'] ); ?>  class="title">
                        <?php echo wp_kses_post( $settings['title'] ); ?>
                    </<?php echo esc_attr( $settings['title_tag'] ); ?>>                
                </div>
                
                <div class="rt-blog-slides owl-carousel owl-theme">
                    <?php while($post_array->have_posts()): $post_array->the_post(); ?>
                        <div class="rt-blog-card">
                            <div class="blog-image">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url( 'ellen_el_post_thumb' ); ?>" alt="<?php the_post_thumbnail_caption(); ?>">
                                </a>
                            </div>
                            <div class="blog-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <ul class="meta">
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>                                            <?php echo esc_html(get_the_author()); ?>
                                        </a>
                                    </li>

                                    <li><?php echo esc_html(get_the_date()); ?></li>
                                </ul>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>

            <div class="rt-blog-shape">
                <?php if( $settings['shape1']['url'] != '' ): ?>
                    <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>">
                <?php endif; ?>
            </div>
        </div>            
    <?php
    }

}

Plugin::instance()->widgets_manager->register( new Ellen_Blog_Slider );