<?php
/*
 * Plugin Name: Ellen Toolkit
 * Author: EnvyTheme
 * Author URI: envytheme.com
 * Description: A Light weight and easy toolkit for Ellen Theme.
 * Version: 2.6
 * Domain Path: /languages
 * Text Domain: ellen-toolkit
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
define('ELLEN_TOOLKIT_VERSION', '2.6');
define('ELLEN_ACC_PATH', plugin_dir_path(__FILE__));
if( !defined('ELLEN_FRAMEWORK_VAR') ) define('ELLEN_FRAMEWORK_VAR', 'ellen_opt');

require_once(ELLEN_ACC_PATH . 'theme-rt.php');

function ellen_init() {
    load_plugin_textdomain( 'ellen-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ellen_init' );

/**
 * Load toolkit files
 */
$pcs = trim( get_option( 'ellen_purchase_code_status' ) );
if ( $pcs == 'valid' ) {
	require_once( ELLEN_ACC_PATH . 'inc/acf.php' );
	require_once( ELLEN_ACC_PATH . 'elementor.php' );

	add_action('after_setup_theme', function() {
		require_once(ELLEN_ACC_PATH . 'redux/framework.php');
		require_once( ELLEN_ACC_PATH . 'redux/sample-config.php' );
	});
	require_once( ELLEN_ACC_PATH . 'inc/widgets.php' );
	require_once( ELLEN_ACC_PATH . 'post-type/footer.php' );
	require_once( ELLEN_ACC_PATH . 'post-type/header.php' );
	require_once( ELLEN_ACC_PATH . 'post-type/success-stories.php' );
	require_once( ELLEN_ACC_PATH . 'inc/courses-functions.php' );
    require_once( ELLEN_ACC_PATH . '/inc/demo-importer.php');
    require_once( ELLEN_ACC_PATH . '/inc/demo-importer-ocdi.php');
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'learnpress/learnpress.php' ) ) {
	require_once( ELLEN_ACC_PATH . 'inc/lp-addons/learnpress-certificates/learnpress-certificates.php' );
	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		require_once( ELLEN_ACC_PATH . 'inc/lp-addons/learnpress-woo-payment/learnpress-woo-payment.php' );
	}
	require_once( ELLEN_ACC_PATH . 'inc/lp-addons/learnpress-content-drip/learnpress-content-drip.php' );
	require_once( ELLEN_ACC_PATH . 'inc/lp-addons/learnpress-gradebook/learnpress-gradebook.php' );
	if ( is_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) ) {
		require_once( ELLEN_ACC_PATH . 'inc/lp-addons/learnpress-paid-membership-pro/learnpress-paid-membership-pro.php' );
	}
}

require_once( ELLEN_ACC_PATH . 'inc/icons.php' ); // Elementor custom field icons

/**
 * Registering crazy toolkit files
 */
function ellen_toolkit_files() {
    wp_enqueue_style('font-awesome-4.7', plugin_dir_url(__FILE__) . 'assets/css/font-awesome.min.css');
}
add_action('wp_enqueue_scripts', 'ellen_toolkit_files');


//Custom Post
function ellen_toolkit_custom_post()
{
	// Programs Custom Post
	// Programs permalink
	global $ellen_opt;
	if( isset( $ellen_opt['program_permalink'] ) ):
		$program_permalink = $ellen_opt['program_permalink'];
	else:
		$program_permalink = 'program-post';
	endif;
	register_post_type('program',
		array(
			'labels' => array(
				'name' => esc_html__('Programs', 'ellen-toolkit'),
				'singular_name' => esc_html__('Program', 'ellen-toolkit'),
			),
			'menu_icon' => 'dashicons-feedback',
			'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => $program_permalink ),
		)
	);

	// Event Custom Post
	// Event permalink
	global $ellen_opt;
	if( isset( $ellen_opt['event_permalink'] ) ):
		$event_permalink = $ellen_opt['event_permalink'];
	else:
		$event_permalink = 'event-post';
	endif;
	register_post_type('event',
		array(
			'labels' => array(
				'name' => esc_html__('Event', 'ellen-toolkit'),
				'singular_name' => esc_html__('Event', 'ellen-toolkit'),
			),
			'menu_icon' => 'dashicons-groups',
			'supports' => array('title', 'thumbnail', 'editor', 'excerpt', 'comments'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => $event_permalink ),
		)
	);
}
add_action('init', 'ellen_toolkit_custom_post');

/**
 * Post category list
 */
function ellen_toolkit_get_post_cat_list() {
	$post_category_id = get_queried_object_id();
	$args = array(
		'parent' => $post_category_id
	);

	$terms = get_terms( 'category', get_the_ID());
	$cat_options = array('' => '');

	if ($terms) {
		foreach ($terms as $term) {
			$cat_options[$term->name] = $term->name;
		}
	}
	return $cat_options;
}

//Taxonomy Custom Post
function ellen_custom_post_taxonomy(){
    register_taxonomy(
      'success-stories-cat',
      'success-stories',
        array(
          'hierarchical'      => true,
          'label'             => esc_html__('Success Stories Category', 'ellen-toolkit' ),
          'query_var'         => true,
          'show_admin_column' => true,
              'rewrite'         => array(
              'slug'          => 'success-stories-category',
              'with_front'    => true
            )
        )
    );

	register_taxonomy(
		'program_cat',
		'program',
		  array(
			'hierarchical'      => true,
			'label'             => esc_html__('Program Category', 'ellen-toolkit' ),
			'query_var'         => true,
			'show_admin_column' => true,
				'rewrite'         => array(
				'slug'          => 'program-category',
				'with_front'    => true
			  )
		  )
	  );

	register_taxonomy(
		'event_cat',
		'event',
		  array(
			'hierarchical'      => true,
			'label'             => esc_html__('Event Category', 'ellen-toolkit' ),
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'         => array(
				'slug'          => 'event-category',
				'with_front'    => true
			)
		)
	);

  }
add_action('init', 'ellen_custom_post_taxonomy');


function ellen_toolkit_get_success_stories_cat_el() {
    $arg = array(
        'taxonomy' => 'success-stories-cat',
        'orderby' => 'name',
        'order'   => 'ASC'
    );
    $args = get_categories($arg);
    $args_options = array(esc_html__('', 'ellen-toolkit') => '');
    if ($args) {
        foreach ($args as $args) {
            $args_options[$args->name] = $args->slug;
        }
    }
    return $args_options;
}

// Select program category for link
function ellen_toolkit_get_page_program_cat_el(){
    $arg = array(
        'taxonomy' => 'program_cat',
        'orderby' => 'name',
        'order'   => 'ASC'
    );
    $args = get_categories($arg);
    $args_options = array(esc_html__('', 'ellen-toolkit') => '');
    if ($args) {
        foreach ($args as $args) {
            $args_options[$args->name] = $args->slug;
        }
    }
    return $args_options;
}

// Select Event Cat
function ellen_toolkit_get_page_event_cat_el(){
    $arg = array(
        'taxonomy' => 'event_cat',
        'orderby' => 'name',
        'order'   => 'ASC'
    );
    $args = get_categories($arg);
    $args_options = array(esc_html__('', 'ellen-toolkit') => '');
    if ($args) {
        foreach ($args as $args) {
            $args_options[$args->name] = $args->slug;
        }
    }
    return $args_options;
}

/**
 * Get Program Custom Post Type as a List
 */
function ellen_toolkit_get_program_as_list() {
    $args = array(
        'post_type'      => 'program', 
        'posts_per_page' => -1, 
        'post_status'    => 'publish',
    );
    
    $program_posts = get_posts($args);
	$program_options = array(esc_html__('', 'ellen-toolkit') => '');

    if (!empty($program_posts)) {
        foreach ($program_posts as $post) {
            $program_options[$post->ID] = get_the_title($post->ID); 
        }
    }

    return $program_options;
}

/**
 *  Select page for link
 */
function ellen_toolkit_get_page_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'page',
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
 * Check a plugin activate
 */
function ellen_plugin_active( $plugin ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( $plugin ) ) {
		return true;
	}
	return false;
}

function ellen_toolkit_options($initArray)  {
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
}
 add_filter('tiny_mce_before_init', 'ellen_toolkit_options');

/**
 * Post title array
 */
function ellen_get_post_title_array( $postType = 'post' ) {
	$args = wp_parse_args(array(
        'post_type' => $postType,
        'numberposts' => -1,
    ));

    $posts = get_posts( $args );
    $post_options = array( '' => '' );

    if ($posts) {
        foreach ( $posts as $post ) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip( $post_options);
	return $flipped;
}

/**
 * Get the existing menus in array format
 * @return array
 */
function ellen_get_menu_array() {
    $menus = wp_get_nav_menus();
    $menu_array = [];
    foreach ( $menus as $menu ) {
        $menu_array[$menu->slug] = $menu->name;
    }
    return $menu_array;
}

/**
 * Ellen Popup Newsletter
 */
function ellen_popup_newsletter() {
	global $ellen_opt;
	$is_popup_massage 	= !empty($ellen_opt['enable_popup_massage']) ? $ellen_opt['enable_popup_massage'] : '';
	$newsletter_type 	= !empty($ellen_opt['ellen_newsletter_type']) ? $ellen_opt['ellen_newsletter_type'] : '';
	if(isset($ellen_opt['popup_image']['url'])):
	?>
		<?php if( $is_popup_massage == '1' ): ?>
			<!-- Start Newsletter Modal -->
			<div id="newsletter-modal" class="newsletter-modal modal">
				<div class="newsletter-modal-content">
					<div class="row m-0">
                    	<div class="col-lg-5 col-md-5 p-0">
							<?php if( $ellen_opt['popup_image']['url'] != '' ): ?>
								<div class="modal-image" style="background-image:url(<?php echo esc_url( $ellen_opt['popup_image']['url'] ); ?>);">
									<img src="<?php echo esc_url( $ellen_opt['popup_image']['url'] ); ?>" alt="<?php echo esc_attr($ellen_opt['popup_title']); ?>">
								</div>
							<?php endif; ?>
						</div>

						<div class="col-lg-7 col-md-7 p-0">
							<div class="modal-inner-content">
								<h2><?php echo esc_html( $ellen_opt['popup_title'] ); ?></h2>
								<span class="sub-text"><?php echo esc_html( $ellen_opt['popup_desc'] ); ?></span>
									<form class="newsletter-form mailchimp" method="post">
										<div class="input-group subcribes">
											<input type="email" name="EMAIL" class="input-newsletter" placeholder="<?php echo esc_attr( $ellen_opt['popup_place'] ); ?>" required autocomplete="off">

											<?php if( $ellen_opt['popup_button_text'] != '' ): ?>
												<button type="submit"><?php echo esc_html( $ellen_opt['popup_button_text'] ); ?><span></span></button>
											<?php endif; ?>
										</div>
										<p class="mchimp-errmessage" style="display: none;"></p>
										<p class="mchimp-sucmessage" style="display: none;"></p>
									</form>
									<?php if( isset( $ellen_opt['action_url'] ) ): ?>
										<script>
											;(function($){
												"use strict";
												$(document).ready(function () {
													// MAILCHIMP
													if ($(".mailchimp").length > 0) {
														$(".mailchimp").ajaxChimp({
															callback: mailchimpCallback,
															url: "<?php echo esc_js($ellen_opt['action_url']) ?>"
														});
													}
													if ($(".mailchimp_two").length > 0) {
														$(".mailchimp_two").ajaxChimp({
															callback: mailchimpCallback,
															url: "<?php echo esc_js($ellen_opt['action_url']) ?>" //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
														});
													}
													$(".memail").on("focus", function () {
														$(".mchimp-errmessage").fadeOut();
														$(".mchimp-sucmessage").fadeOut();
													});
													$(".memail").on("keydown", function () {
														$(".mchimp-errmessage").fadeOut();
														$(".mchimp-sucmessage").fadeOut();
													});
													$(".memail").on("click", function () {
														$(".memail").val("");
													});

													function mailchimpCallback(resp) {
														if (resp.result === "success") {
															$(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
															$(".mchimp-sucmessage").fadeOut(500);
														} else if (resp.result === "error") {
															$(".mchimp-errmessage").html(resp.msg).fadeIn(1000);
														}
													}
												});
											})(jQuery)
										</script>
									<?php endif; ?>

								<p><i class="bx bx-lock"></i> <?php echo esc_html( $ellen_opt['popup_bottom_desc'] ); ?></p>
							</div>
						</div>
					</div>

					<div class="close-btn btn-yes"><i class="flaticon-cancel"></i></div>
				</div>
			</div>
			<!-- End Newsletter Modal -->
	<?php endif;
	endif;
}

function ellen_number_format_nice_float( $number ) {
	// Not type.
	if ( 0 == $number ) {
		return $number;
	}

	$number = number_format( (float) $number, 2 );

	if ( 4 === strlen( $number ) && '0' === substr( $number, -1 ) ) {
		$number = substr_replace( $number, '', -1 );
	}

	return $number;
}

function ellen_woocommerce_order( $order_id ) {
    if( ! $order_id ) return;

    // Get order
    $order = wc_get_order( $order_id );

    // get order items = each product in the order
    $items = $order->get_items();

    // Set variable
    $found = false;

    foreach ( $items as $item ) {
        // Get product id
        $product = wc_get_product( $item['product_id'] );

        // Is virtual
        $is_virtual = $product->is_virtual();

        if( $is_virtual ) {
            $found = true;
            break;
        }
    }

    if( $found ) {
        $order->update_status( 'completed' );
    }
}
add_action('woocommerce_thankyou', 'ellen_woocommerce_order', 10, 1 );

/**
 * Remove pages from search result
 */
if ( ! function_exists( 'ellen_remove_pages_from_search' ) ) :
    function ellen_remove_pages_from_search() {
		global $ellen_opt;
		global $wp_post_types;

		if( isset( $ellen_opt['ellen_search_page'] ) ):
			if( $ellen_opt['ellen_search_page'] != true ):
				$wp_post_types['page']->exclude_from_search = true;
			else:
				$wp_post_types['page']->exclude_from_search = false;
			endif;
		else:
			$wp_post_types['page']->exclude_from_search = false;
		endif;
	}
endif;
add_action('init', 'ellen_remove_pages_from_search');

function ellen_admin_css() {
	echo '<style>.#fw-ext-brizy,#fw-extensions-list-wrapper .toggle-not-compat-ext-btn-wrapper,.fw-brz-dismiss{display:none}.fw-brz-dismiss{display:none}.fw-extensions-list-item{display:none!important}#fw-ext-backups{display:block!important}#update-nag,.update-nag{display:block!important} .fw-sole-modal-content.fw-text-center .fw-text-danger.dashicons.dashicons-warning:before { content: "Almost finished! Please check with a reload." !important;}.fw-sole-modal-content.fw-text-center .fw-text-danger.dashicons.dashicons-warning {color: green !important; width:100%} .fw-modal.fw-modal-open > .media-modal-backdrop {width: 100% !important;}</style>';
  }
add_action('admin_head', 'ellen_admin_css');

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );

function ellen_toolkit_enable_svg_upload( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'ellen_toolkit_enable_svg_upload', 10, 1 );

// Add this to your theme's functions.php
function ellen_add_script_to_footer(){
    if( ! is_admin() ) { ?>
    <script>
    jQuery(document).ready(function($){
    $(document).on('click', '.plus', function(e) { // replace '.quantity' with document (without single quote)
        $input = $(this).prev('input.qty');
        var val = parseInt($input.val());
        var step = $input.attr('step');
        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
        $input.val( val + step ).change();
    });
    $(document).on('click', '.minus',  // replace '.quantity' with document (without single quote)
        function(e) {
        $input = $(this).next('input.qty');
        var val = parseInt($input.val());
        var step = $input.attr('step');
        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
        if (val > 0) {
            $input.val( val - step ).change();
        }
    });
    });
    </script>
<?php
    }
}
add_action( 'wp_footer', 'ellen_add_script_to_footer' );

function ellen_lp_the_loop_lessons() {
	$course      = LP_Global::course();
	$count_items = $course->count_items();

	if ( empty( $count_items ) ) {
		return;
	}

	$count_items = intval( $count_items );

	return $count_items;
}

function ellen_lp_the_loop_students() {
	$course = LP_Global::course();
	if ( ! $course || ! $course->is_required_enroll() ) {
		return;
	}

	$count = intval( $course->count_students() );

	return $count;
}

function ellen_lp_the_loop_instructor() {
	/**
	 * @var LP_Course        $course
	 * @var LP_Abstract_User $instructor
	 */
	$course     = LP_Global::course();
	$instructor = $course->get_instructor();
	?>
		<?php echo $course->get_instructor()->get_profile_picture(); ?>
		<span><?php echo ent2ncr( $instructor->get_display_name() ); ?></span>
	<?php
}

function lp_get_total_lessons_by_course_id($course_id) {
	// Check if LearnPress is active
	if (function_exists('learn_press_get_course_sections')) {
		$sections = learn_press_get_course_sections($course_id);
		$lesson_count = 0;

		if (!empty($sections) && is_array($sections)) {
			foreach ($sections as $section) {
				if (is_object($section) && isset($section->items) && is_array($section->items)) {
					$lesson_count += count($section->items);
				}
			}
		}

		return $lesson_count;
	} else {
		return 0;
	}
}


$opt_name = ELLEN_FRAMEWORK_VAR;