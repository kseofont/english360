<?php
/**
 * Blog Post Widget
 */

namespace Elementor;
class Ellen_Blog_Post extends Widget_Base {

	public function get_name() {
        return 'EllenBlogPost';
    }

	public function get_title() {
        return __( 'Blog Post', 'ellen-toolkit' );
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

            $this->add_control(
                'shape2',
                [
                    'label'		=> esc_html__('Shape Image Two', 'ellen-toolkit'),
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
            <div class="container">
                <div class="row justify-content-center">
                    <?php while($post_array->have_posts()): $post_array->the_post(); ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="el-single-blog-post">
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>"class="d-block"><img src="<?php the_post_thumbnail_url( 'ellen_el_post_thumb' ); ?>" alt="<?php the_post_thumbnail_caption(); ?>"></a>
                                </div>

                                <div class="content">
                                    <ul class="meta">
                                        <li><?php echo esc_html(get_the_author()); ?></li>
                                        <li><?php echo esc_html(get_the_date()); ?></li>
                                    </ul>

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>

            <?php if( $settings['shape1']['url'] != '' ): ?>
                <div class="shape2">
                    <img src="<?php echo esc_url( $settings['shape1']['url'] ); ?>" alt="<?php echo esc_attr( the_title() ); ?>">
                </div>
            <?php endif; ?>
            <?php if( $settings['shape2']['url'] != '' ): ?>
                <div class="shape4">
                    <img src="<?php echo esc_url( $settings['shape2']['url'] ); ?>" alt="<?php echo esc_attr( the_title() ); ?>">
                </div>
            <?php endif; ?>
    <?php
    }

}

Plugin::instance()->widgets_manager->register( new Ellen_Blog_Post );