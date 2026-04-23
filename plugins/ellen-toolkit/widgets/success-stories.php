<?php
/**
 * Success_Stories Widget
*/

namespace Elementor;
class Ellen_Success_Stories extends Widget_Base {

	public function get_name() {
        return 'Success_Stories';
    }

	public function get_title() {
        return __( 'Success Stories', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-image-rollover';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'success_stories_section',
			[
				'label' => __( 'Success_Stories', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'style',
                [
                    'label' => __( 'Services Style', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '1'   => __( 'Style 1', 'ellen-toolkit' ),
                        '2'   => __( 'Style 2', 'ellen-toolkit' ),
                    ],
                    'default' => '1',
                ]
            );

            $this->add_control(
                'read_more',
                [
                    'label' => __( 'Read More Text', 'ellen-toolkit' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Read Story', 'ellen-toolkit'),
                    'condition' => [
                        'style' => '1',
                    ]
                ]
            );

            $this->add_control(
                'cat_name',
                [
                    'label' => __( 'Choose Category', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ellen_toolkit_get_success_stories_cat_el(),
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Services Order By', 'ellen-toolkit' ),
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
                    'default' => 4,
                ]
            );
        $this->end_controls_section();

        $this->start_controls_section(
			'service_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-success-story-box .content h3, .single-success-story-item .content h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Title Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-success-story-box .content h3, .single-success-story-item .content h3',
                ]
            );

            $this->add_control(
                'content_color',
                [
                    'label' => __( 'Content Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-success-story-box .content p, .single-success-story-item .content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Content Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-success-story-box .content p, .single-success-story-item .content p',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_typography',
                    'label' => __( 'Button Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-success-story-box .content .default-btn',
                    'condition' => [
                        'style' => '1',
                    ]
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();

        // Services Query
        if( $settings['cat_name'] != '' ) {
            $args = array(
                'post_type'     => 'success-stories',
                'posts_per_page'=> $settings['count'],
                'order'         => $settings['order'],
                'tax_query'     => array(
                    array(
                        'taxonomy'      => 'success-stories-cat',
                        'field'         => 'slug',
                        'terms'         => $settings['cat_name'],
                        'hide_empty'    => false
                    )
                )
            );
        } else {
            $args = array(
                'post_type'         => 'success-stories',
                'posts_per_page'    => $settings['count'],
                'order'             => $settings['order']
            );
        }
        $success_stories_array = new \WP_Query( $args );
        ?>

        <?php if($settings['style'] == '1'): ?>
            <div class="success-story-area">
                <div class="container">
                    <?php
                    $i = 1;
                    while($success_stories_array->have_posts()): $success_stories_array->the_post();
                    if($i % 2 != 0 ): ?>
                        <div class="single-success-story-box">
                            <div class="row m-0 align-items-center">
                                <div class="col-lg-7 col-md-7 content">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php the_excerpt(); ?></p>

                                    <?php if($settings['read_more']): ?>
                                        <a href="<?php the_permalink(); ?>" class="default-btn"><?php echo esc_html($settings['read_more']); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-5 col-md-5 image">
                                    <?php if(has_post_thumbnail()) { ?>
                                        <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'ellen_success_stories_thumb' ); ?>" alt="<?php the_post_thumbnail_caption();  ?>">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="single-success-story-box">
                            <div class="row m-0 align-items-center">
                                <div class="col-lg-5 col-md-5 image">
                                    <?php if(has_post_thumbnail()) { ?>
                                        <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'ellen-success-stories-860x860' ); ?>" alt="<?php the_post_thumbnail_caption();  ?>">
                                    <?php } ?>
                                </div>
                                <div class="col-lg-7 col-md-7 content">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php the_excerpt(); ?></p>

                                    <?php if($settings['read_more']): ?>
                                        <a href="<?php the_permalink(); ?>" class="default-btn"><?php echo esc_html($settings['read_more']); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                    $i++; endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    while($success_stories_array->have_posts()): $success_stories_array->the_post();
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-success-story-item">
                                <?php if(has_post_thumbnail()) { ?>
                                    <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'ellen-success-stories-860x860' ); ?>" alt="<?php the_post_thumbnail_caption();  ?>">
                                <?php } ?>
                                <div class="content">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
	}
}

Plugin::instance()->widgets_manager->register( new Ellen_Success_Stories );