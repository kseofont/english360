<?php

function ellen_category_post_count( $atts ) {

	if ( function_exists('tutor') ) {
		$terms = 'course-category';
	}elseif( class_exists('LearnPress') ){
		$terms = 'course_category';
	}

    // get the category by slug.
    $term = get_term_by( 'slug', $atts, $terms);
    return ( isset( $term->count ) ) ? $term->count : 0;
}

function ellen_toolkit_get_courses_cat_list() {
	$courses_category_id = get_queried_object_id();
	$args = array(
		'parent' => $courses_category_id
	);

	if ( function_exists('tutor') ) {
		$terms = get_terms( array(
			'taxonomy' => 'course-category',
			'hide_empty' => false,
		) );
	}elseif( class_exists('LearnPress') ){
		$terms = get_terms( array(
			'taxonomy' => 'course_category',
			'hide_empty' => false,
		) );
	}

	$cat_options = array('' => '');

	if ($terms) {
		foreach ($terms as $term) {
			$cat_options[$term->name] = $term->name;
		}
	}
	return $cat_options;
}

function ellen_toolkit_get_tutor_course_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'courses',
        'numberposts' => -1,
    ));

    $posts = get_posts($args);
    $post_options = array('' => '');

    if ($posts) {
        foreach ($posts as $post) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip($post_options);
    return $flipped;
}

/**
 * Count number of courses of given instructor.
 *
 * @param $instructor_id
 *
 * @return int
 */
function ellen_get_total_courses_by_instructor( $instructor_id ) {
	global $wpdb;

	$sql = "SELECT COUNT( {$wpdb->users}.ID ) FROM {$wpdb->users}";
	$sql .= " INNER JOIN {$wpdb->usermeta} ON {$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND {$wpdb->usermeta}.meta_key = '_tutor_instructor_course_id'";
	$sql .= " INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->usermeta}.meta_value";
	$sql .= " WHERE {$wpdb->users}.ID = {$instructor_id}";
	$sql .= " AND {$wpdb->posts}.post_type = 'courses' AND {$wpdb->posts}.post_status = 'publish'";

	return absint( $wpdb->get_var( $sql ) ); // WPCS: unprepared SQL ok.
}

/**
 * @param int|float $rating Rating average.
 * @param array     $args
 *
 * @return string HTML template
 */
function ellen_render_rating( $rating = 5, $args = array() ) {
	$default = [
		'echo'          => true,
	];

	$args = wp_parse_args( $args, $default );

	$full_stars = intval( $rating );
	$template   = '';

	$template .= str_repeat( '<i class="bx bxs-star" ></i>', $full_stars );

	$half_star = floatval( $rating ) - $full_stars;

	if ( $half_star != 0 ) {
		$template .= '<i class="bx bxs-star-half" ></i>';
	}

	$empty_stars = intval( 5 - $rating );
	$template    .= str_repeat( '<i class="bx bx-star"></i>', $empty_stars );

	if ( true === $args['echo'] ) {
		echo '' . $template;
	} else {
		return $template;
	}
}

function ellen_footer_all_courses_popup(){

	if(is_single()):
		return;
	endif;

	if ( function_exists('tutor') ) {
		$course_array2 = new \WP_Query( array('post_type' => 'courses', 'posts_per_page' => -1 ) ); ?>
		<?php  while($course_array2->have_posts()): $course_array2->the_post();

				global $ellen_opt;
				$updated = !empty($ellen_opt['course_last_updated_text']) ? $ellen_opt['course_last_updated_text'] : 'Updated:';
				?>
				<!-- Popover Quickview Courses -->
				<div id="tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>" class="popover-quickview-courses">
					<div class="popover-quickview">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<span class="update-info"><?php echo esc_html($updated); ?> <?php echo esc_html(get_the_modified_date()); ?></span>
						<div class="stats d-flex align-items-center">
							<span class="level"><?php echo wp_kses_post(get_tutor_course_level()); ?></span>
							<span><?php echo wp_kses_post(get_tutor_course_duration_context()); ?></span>
						</div>
						<?php the_excerpt(); ?>

						<?php $course_benefits = tutor_course_benefits(); ?>
						<?php if ( !empty($course_benefits)){ ?>
							<ul>
								<?php
								$count_benefit = 1;
								foreach ($course_benefits as $benefit){
									if($count_benefit < 3):
										echo wp_kses_post("<li><i class='flaticon-check-mark'></i>{$benefit}</li>");
									endif;
									$count_benefit++;
								}
								?>
							</ul>
						<?php } ?>

						<div class="btn-box d-flex align-items-center">
						<?php
							$course_id = get_the_ID();
							$enroll_btn = '<div  class="tutor-public-course-start-learning">' . apply_filters( 'tutor_course_restrict_new_entry', '<a class="default-btn" href="'. get_the_permalink(). '">'.__('Get Enrolled', 'ellen'). '<i class="flaticon-hand"></i></a>' ) . '</div>';
							$price_html = '<div class="price"> '.$enroll_btn. '</div>';
							if (tutor_utils()->is_course_purchasable()) {
								$enroll_btn = tutor_course_loop_add_to_cart(false);
								$product_id = tutor_utils()->get_course_product_id($course_id);
								$price_html = '<div class="default-btn"> ' . apply_filters( 'tutor_course_restrict_new_entry', $enroll_btn ) . '</div>';
							}
							echo wp_kses_post($price_html);
							
							$is_wish_listed     = tutor_utils()->is_wishlisted( $course_id, get_current_user_id() );
							?>

							<a href="#" class="tutor-btn tutor-btn-ghost tutor-course-wishlist-btn tutor-mr-16" data-course-id="<?php echo get_the_ID(); ?>">
								<i class="<?php echo $is_wish_listed ? 'tutor-icon-bookmark-bold' : 'tutor-icon-bookmark-line' ?> tutor-mr-8"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- End Popover Quickview Courses -->
		<?php endwhile;
		wp_reset_query();
	}elseif(class_exists('LearnPress')){
		$course_array2 = new \WP_Query( array('post_type' => 'lp_course', 'posts_per_page' => -1 ) ); ?>
		<?php  while($course_array2->have_posts()): $course_array2->the_post();
				$level = learn_press_get_post_level( get_the_ID() );
				$course = LP_Global::course();
				global $ellen_opt;
				$updated = !empty($ellen_opt['course_last_updated_text']) ? $ellen_opt['course_last_updated_text'] : 'Updated:';
				$lessons_title  = !empty($ellen_opt['lessons_title']) ? $ellen_opt['lessons_title'] : 'Total Lessons';
				$students_title = !empty($ellen_opt['students_title']) ? $ellen_opt['students_title'] : 'Total Students';
				?>
				<!-- Popover Quickview Courses -->
				<div id="tooltip-courses-<?php echo esc_attr(get_the_ID()); ?>" class="popover-quickview-courses">
					<div class="popover-quickview">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<span class="update-info"><?php echo esc_html($updated); ?> <?php echo esc_html(get_the_modified_date()); ?></span>
						<div class="stats d-flex align-items-center">
							<span class="level"><?php echo wp_kses_post($level); ?></span>
							<span><?php echo learn_press_get_post_translated_duration( get_the_ID(), esc_html__( 'Lifetime access', 'ellen-toolkit' ) ); ?></span>
						</div>
						<?php the_excerpt(); ?>

						<ul>
							<?php $user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0; ?>
							<li><i class='bx bx-user-circle' ></i> <?php echo esc_html($students_title); ?> <?php echo esc_html( $user_count ); ?></li>
							<li><i class='bx bx-book' ></i><?php echo esc_html($lessons_title); ?> <?php echo wp_kses_post( $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0 ); ?></li>
						</ul>

						<div class="btn-box d-flex align-items-center">
							<a href="<?php the_permalink(); ?>" class="lp-button button button-purchase-course">
								<?php echo esc_html__('See Details', 'ellen'); ?>
							</a>
						</div>
					</div>
				</div>
				<!-- End Popover Quickview Courses -->
		<?php endwhile;
		wp_reset_query();
	}
}

add_action('wp_footer', 'ellen_footer_all_courses_popup');


/**
 * Print rating
 */
if ( !function_exists( 'ellen_lp_print_rating' ) ) {
	function ellen_lp_print_rating( $rate ) {
		if ( !ellen_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}

		?>
		<div class="review-stars-rated">
			<ul class="review-stars">
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
			</ul>
			<ul class="review-stars filled"
			    style="<?php echo esc_attr( 'width: calc(' . ( $rate * 20 ) . '% - 2px)' ) ?>">
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
			</ul>
		</div>
		<?php

	}
}

/**
 * Display course ratings
 */
if ( !function_exists( 'ellen_lp_course_ratings' ) ) {
	function ellen_lp_course_ratings() {

		if ( !ellen_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}

		$course_id   = get_the_ID();
		$course_rate = learn_press_get_course_rate( $course_id );
		$ratings     = learn_press_get_course_rate_total( $course_id );
		?>
		<div class="course-review">
			<?php ellen_lp_print_rating( $course_rate ); ?>
		</div>
		<?php
	}
}

/**
 * Display ratings count
 */
if ( !function_exists( 'ellen_lp_course_ratings_count' ) ) {
	function ellen_lp_course_ratings_count( $course_id = null ) {
		if ( !ellen_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}
		if ( !$course_id ) {
			$course_id = get_the_ID();
		}
		$ratings = learn_press_get_course_rate_total( $course_id ) ? learn_press_get_course_rate_total( $course_id ) : 0;
		echo esc_html( $ratings );
	}
}