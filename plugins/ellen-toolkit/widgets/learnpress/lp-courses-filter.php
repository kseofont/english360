<?php
/**
 * Courses Filter Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_LP_Courses_Filter extends Widget_Base {

	public function get_name() {
        return 'LPCoursesFilter';
    }

	public function get_title() {
        return esc_html__( 'LearnPress Courses Filter', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-posts-grid';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
			'course_section',
			[
				'label' => esc_html__( 'LearnPress Courses Filter', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Select Style', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid'         => esc_html__( 'Grid', 'ellen-toolkit' ),
                    'slider'       => esc_html__( 'Slider', 'ellen-toolkit' ),
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'all_title',
            [
                'label' => esc_html__( 'All Button Text', 'ellen-toolkit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('All', 'ellen-toolkit'),
            ]
        );

        $this->add_control(
			'course_count',
			[
				'label' => esc_html__( 'Course Per Tab', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 8,
			]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'cat_name', [
                'label' => esc_html__( 'Select Category', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => ellen_toolkit_get_courses_cat_list(),
            ]
        );

        $repeater->add_control(
			'count',
			[
				'label' => __( 'Course Per Tab', 'ellen-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
			]
        );

        $this->add_control(
            'course_cat',
            [
                'label' => esc_html__('Add filter nav item', 'ellen-toolkit'),
                'type' => Controls_Manager::REPEATER,
                'separator' => 'before',
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Courses Filter Order By', 'ellen-toolkit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
					'DESC'      => esc_html__( 'DESC', 'ellen-toolkit' ),
					'ASC'       => esc_html__( 'ASC', 'ellen-toolkit' ),
				],
				'default' => 'DESC',
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
                'nav_item_color',
                [
                    'label' => esc_html__( 'Nav Item Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shorting-menu .control' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'nav_typography',
                    'label' => __( 'Nav Item Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .shorting-menu .control',
                ]
            );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        $all = $settings != '' ? $settings['all_title'] : 'All';
        $cat_item = $settings['course_cat'];
    
        $ellen_courses_categories = get_terms('course_category');
        $args_options = [];
    
        foreach ($cat_item as $key => $cat):
            if (!empty($cat['cat_name'])) {
                $term = get_term_by('slug', $cat['cat_name'], 'course_category');
                if ($term && !is_wp_error($term)) {
                    $args_options[] = $term->term_id;
                }
            }
        endforeach;
    
        $course_array = new \WP_Query([
            'posts_per_page' => $settings['course_count'],
            'post_type' => 'lp_course',
            'order' => $settings['order'],
            'tax_query' => [[
                'taxonomy' => 'course_category',
                'terms' => $args_options,
            ]]
        ]);
    
        if ($settings['style'] == 'grid'): ?>
            <div class="container">
                <div class="shorting-menu">
                    <button type="button" class="control all" data-filter=".all"><?php echo esc_attr($all); ?></button>
                    <?php foreach ($cat_item as $key => $cat):
                        if (!empty($cat['cat_name'])) {
                            $term = get_term_by('slug', $cat['cat_name'], 'course_category');
                            if ($term && !is_wp_error($term)): ?>
                                <button type="button" class="control" data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($cat['cat_name']); ?></button>
                            <?php endif;
                        }
                    endforeach; ?>
                </div>
    
                <div class="shorting row">
                    <?php while ($course_array->have_posts()): $course_array->the_post();
                        $terms = wp_get_post_terms(get_the_ID(), 'course_category');
                        $output = $id = [];
    
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $output[] = $term->slug;
                                $id[] = $term->term_id;
                            }
                        }
    
                        $course = \LP_Global::course();
                        $course_rate_res = learn_press_get_course_rate(get_the_ID(), false);
                        $course_rate = $course_rate_res['rated'];
                        ?>
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mix all">
                            <div class="single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
                                <div class="image">
                                    <?php the_post_thumbnail('ellen-course-860X630'); ?>
                                    <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                </div>
                                <div class="content">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php echo wp_kses_post($course->get_instructor_html()); ?>
                                    <div class="rating lp-course-rating">
                                        <div class="d-flex align-items center">
                                            <span class="overall"><?php echo number_format($course_rate, 1); ?></span>
                                            <div class="star"><?php ellen_lp_course_ratings(); ?></div>
                                            <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                        </div>
                                    </div>
                                    <div class="price"><?php echo $course->get_course_price_html(); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
    
                    <?php foreach ($cat_item as $key => $cat):
                        if (!empty($cat['cat_name'])) {
                            $term = get_term_by('slug', $cat['cat_name'], 'course_category');
                            if ($term && !is_wp_error($term)) {
                                $args_options = $term->term_id;
                                $slug = $term->slug;
    
                                $course_array = new \WP_Query([
                                    'posts_per_page' => $cat['count'],
                                    'post_type' => 'lp_course',
                                    'order' => $settings['order'],
                                    'tax_query' => [[
                                        'taxonomy' => 'course_category',
                                        'terms' => $args_options,
                                    ]],
                                    'meta_key' => '_thumbnail_id'
                                ]);
    
                                while ($course_array->have_posts()): $course_array->the_post();
                                    $terms = wp_get_post_terms(get_the_ID(), 'course_category');
                                    $output = $id = [];
    
                                    if ($terms && !is_wp_error($terms)) {
                                        foreach ($terms as $term) {
                                            $output[] = $term->slug;
                                            $id[] = $term->term_id;
                                        }
                                    }
    
                                    $course = \LP_Global::course();
                                    $course_rate_res = learn_press_get_course_rate(get_the_ID(), false);
                                    $course_rate = $course_rate_res['rated'];
                                    ?>
                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mix <?php echo esc_attr($slug); ?>">
                                        <div class="single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
                                            <div class="image">
                                                <?php the_post_thumbnail('ellen-course-860X630'); ?>
                                                <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                            </div>
                                            <div class="content">
                                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <?php echo wp_kses_post($course->get_instructor_html()); ?>
                                                <div class="rating lp-course-rating">
                                                    <div class="d-flex align-items center">
                                                        <span class="overall"><?php echo number_format($course_rate, 1); ?></span>
                                                        <div class="star"><?php ellen_lp_course_ratings(); ?></div>
                                                        <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                                    </div>
                                                </div>
                                                <div class="price"><?php echo $course->get_course_price_html(); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; wp_reset_query();
                            }
                        }
                    endforeach; ?>
                </div>
            </div>
        <?php elseif ($settings['style'] == 'slider'): ?>
            <div class="container">
                <ul class="nav nav-tabs courses-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-courses-tab" data-bs-toggle="tab" data-bs-target="#all-courses" type="button" role="tab" aria-controls="all-courses" aria-selected="true"><?php echo esc_attr($all); ?></button>
                    </li>
                    <?php foreach ($cat_item as $key => $cat):
                        if (!empty($cat['cat_name'])) {
                            $term = get_term_by('slug', $cat['cat_name'], 'course_category');
                            if ($term && !is_wp_error($term)): ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="<?php echo esc_attr($term->slug); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr($term->slug); ?>" type="button" role="tab" aria-controls="<?php echo esc_attr($term->slug); ?>" aria-selected="false"><?php echo esc_html($cat['cat_name']); ?></button>
                                </li>
                            <?php endif;
                        }
                    endforeach; ?>
                </ul>
    
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="all-courses" role="tabpanel">
                        <div class="courses-slides owl-carousel owl-theme">
                            <?php while ($course_array->have_posts()): $course_array->the_post();
                                $terms = wp_get_post_terms(get_the_ID(), 'course_category');
                                $output = $id = [];
    
                                if ($terms && !is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        $output[] = $term->slug;
                                        $id[] = $term->term_id;
                                    }
                                }
    
                                $course = \LP_Global::course();
                                $course_rate_res = learn_press_get_course_rate(get_the_ID(), false);
                                $course_rate = $course_rate_res['rated'];
                                ?>
                                <div class="single-courses-box">
                                    <div class="image">
                                        <?php the_post_thumbnail('ellen-course-860X630'); ?>
                                        <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                    </div>
                                    <div class="content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php echo wp_kses_post($course->get_instructor_html()); ?>
                                        <div class="rating lp-course-rating">
                                            <div class="d-flex align-items center">
                                                <span class="overall"><?php echo number_format($course_rate, 1); ?></span>
                                                <div class="star"><?php ellen_lp_course_ratings(); ?></div>
                                                <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                            </div>
                                        </div>
                                        <div class="price"><?php echo $course->get_course_price_html(); ?></div>
                                    </div>
                                </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                    </div>
    
                    <?php foreach ($cat_item as $key => $cat):
                        if (!empty($cat['cat_name'])) {
                            $term = get_term_by('slug', $cat['cat_name'], 'course_category');
                            if ($term && !is_wp_error($term)) {
                                $args_options = $term->term_id;
                                $slug = $term->slug;
    
                                $course_array = new \WP_Query([
                                    'posts_per_page' => $cat['count'],
                                    'post_type' => 'lp_course',
                                    'order' => $settings['order'],
                                    'tax_query' => [[
                                        'taxonomy' => 'course_category',
                                        'terms' => $args_options,
                                    ]],
                                    'meta_key' => '_thumbnail_id'
                                ]);
                                ?>
                                <div class="tab-pane fade" id="<?php echo esc_attr($slug); ?>" role="tabpanel">
                                    <div class="row">
                                        <?php while ($course_array->have_posts()): $course_array->the_post();
                                            $terms = wp_get_post_terms(get_the_ID(), 'course_category');
                                            $output = $id = [];
    
                                            if ($terms && !is_wp_error($terms)) {
                                                foreach ($terms as $term) {
                                                    $output[] = $term->slug;
                                                    $id[] = $term->term_id;
                                                }
                                            }
    
                                            $course = \LP_Global::course();
                                            $course_rate_res = learn_press_get_course_rate(get_the_ID(), false);
                                            $course_rate = $course_rate_res['rated'];
                                            ?>
                                            <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 mix <?php echo esc_attr($slug); ?>">
                                                <div class="single-courses-box inline" data-tipped-options="inline: 'tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>'">
                                                    <div class="image">
                                                        <?php the_post_thumbnail('ellen-course-860X630'); ?>
                                                        <a href="<?php the_permalink(); ?>" class="link-btn"></a>
                                                    </div>
                                                    <div class="content">
                                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                        <?php echo wp_kses_post($course->get_instructor_html()); ?>
                                                        <div class="rating lp-course-rating">
                                                            <div class="d-flex align-items center">
                                                                <span class="overall"><?php echo number_format($course_rate, 1); ?></span>
                                                                <div class="star"><?php ellen_lp_course_ratings(); ?></div>
                                                                <span class="total">(<?php ellen_lp_course_ratings_count(); ?>)</span>
                                                            </div>
                                                        </div>
                                                        <div class="price"><?php echo $course->get_course_price_html(); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; wp_reset_query(); ?>
                                    </div>
                                </div>
                            <?php }
                        }
                    endforeach; ?>
                </div>
            </div>
        <?php endif;
    }
    


}

Plugin::instance()->widgets_manager->register( new Ellen_LP_Courses_Filter );