<?php

// Disable Elementor's Default Colors and Default Fonts
update_option( 'elementor_disable_color_schemes', 'yes' );
update_option( 'elementor_disable_typography_schemes', 'yes' );
update_option( 'elementor_global_image_lightbox', '' );

/**
 * Main Elementor ellen Extension Class
 */
final class Elementor_Ellen_Extension {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	// Instance
    private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	// Constructor
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	// init
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );

        add_action('elementor/elements/categories_registered',[ $this, 'register_new_category'] );

    }

    public function register_new_category($manager){
        $manager->add_category('ellen-elements',[
            'title'=>esc_html__('Ellen','ellen-toolkit'),
        ]);
    }

	//Admin notice
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ellen-toolkit' ),
			'<strong>' . esc_html__( 'Ellen Toolkit', 'ellen-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ellen-toolkit' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ellen-toolkit' ),
			'<strong>' . esc_html__( 'Ellen Toolkit', 'ellen-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ellen-toolkit' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ellen-toolkit' ),
			'<strong>' . esc_html__( 'Ellen Toolkit', 'ellen-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'ellen-toolkit' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	// Toolkit Widgets
	public function init_widgets() {

		// Include Widget files
		$pcs = trim( get_option( 'ellen_purchase_code_status' ) );
		if ( $pcs == 'valid' ) {
			require_once( __DIR__ . '/widgets/banner/banner-one.php' );
			require_once( __DIR__ . '/widgets/banner/banner-two.php' );
			require_once( __DIR__ . '/widgets/banner/banner-three.php' );
			require_once( __DIR__ . '/widgets/banner/banner-four.php' );
			require_once( __DIR__ . '/widgets/banner/banner-five.php' );
			require_once( __DIR__ . '/widgets/banner/banner-six.php' );
			require_once( __DIR__ . '/widgets/banner/banner-seven.php' );
			require_once( __DIR__ . '/widgets/banner/banner-eight.php' );
			require_once( __DIR__ . '/widgets/banner/banner-nine.php' );
			require_once( __DIR__ . '/widgets/banner/banner-slider.php' );
			require_once( __DIR__ . '/widgets/banner/banner-ten.php' );

			require_once( __DIR__ . '/widgets/funfacts.php' );
			require_once( __DIR__ . '/widgets/funfacts-three.php' );
			require_once( __DIR__ . '/widgets/section.php' );
			require_once( __DIR__ . '/widgets/features-inner.php' );
			require_once( __DIR__ . '/widgets/partner.php' );
			require_once( __DIR__ . '/widgets/become-an-instructor.php' );
			require_once( __DIR__ . '/widgets/feedback.php' );
			require_once( __DIR__ . '/widgets/stories-area.php' );
			require_once( __DIR__ . '/widgets/cta-area.php' );
			require_once( __DIR__ . '/widgets/about-area.php' );
			require_once( __DIR__ . '/widgets/about-area-two.php' );
			require_once( __DIR__ . '/widgets/about-slides.php' );
			require_once( __DIR__ . '/widgets/instructors.php' );
			require_once( __DIR__ . '/widgets/success-stories.php' );
			require_once( __DIR__ . '/widgets/single-success-stories.php' );
			require_once( __DIR__ . '/widgets/contact-area.php' );
			require_once( __DIR__ . '/widgets/faq.php' );
			require_once( __DIR__ . '/widgets/coming-soon.php' );
			require_once( __DIR__ . '/widgets/become-an-instructor-two.php' );
			require_once( __DIR__ . '/widgets/blog.php' );
			require_once( __DIR__ . '/widgets/features-area.php' );
			require_once( __DIR__ . '/widgets/why-choose-us-area.php' );
			require_once( __DIR__ . '/widgets/icon-card.php' );
			require_once( __DIR__ . '/widgets/feedback-two.php' );
			require_once( __DIR__ . '/widgets/feedback-three.php' );
			require_once( __DIR__ . '/widgets/funfacts-four.php' );
			require_once( __DIR__ . '/widgets/video-area.php' );
			require_once( __DIR__ . '/widgets/cta-area-two.php' );

			if ( function_exists('tutor') ) {
				require_once( __DIR__ . '/widgets/tutor/tutor-courses-filter.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-courses-filter-two.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-courses.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-categories.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-course-slider.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-course-slider-two.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-course-card.php' );
				require_once( __DIR__ . '/widgets/tutor/health-course.php' );
				require_once( __DIR__ . '/widgets/tutor/tutor-instructors.php' );
			}

			require_once( __DIR__ . '/widgets/course-categories-two.php' );

			if( class_exists('LearnPress') ){
				require_once( __DIR__ . '/widgets/learnpress/lp-courses-filter.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-categories.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-courses.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-courses-filter-two.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-course-slider.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-course-slider-two.php' );
				require_once( __DIR__ . '/widgets/learnpress/lp-course-card.php' );
			}

			require_once( __DIR__ . '/widgets/kitchen-coach/features-wrap-area.php' );
			require_once( __DIR__ . '/widgets/kitchen-coach/kc-about-area.php' );
			require_once( __DIR__ . '/widgets/kitchen-coach/kc-overview-area.php' );
			require_once( __DIR__ . '/widgets/kitchen-coach/partner.php' );
			require_once( __DIR__ . '/widgets/kitchen-coach/kc-stories-area.php' );
			require_once( __DIR__ . '/widgets/kitchen-coach/kc-subscribe-area.php' );

			require_once( __DIR__ . '/widgets/vendor-certification/about-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/rt-features-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/video-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/rt-feedback-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/rt-instructor-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/rt-opportunities-area.php' );
			require_once( __DIR__ . '/widgets/remote-training/rt-blog-area.php' );

			require_once( __DIR__ . '/widgets/button.php' );
			require_once( __DIR__ . '/widgets/button-two.php' );
			require_once( __DIR__ . '/widgets/text-slider.php' );

			// New
			require_once( __DIR__ . '/widgets/university/university-banner.php' );
			require_once( __DIR__ . '/widgets/university/university-banner-bottom.php' );
			require_once( __DIR__ . '/widgets/university/university-slide-text.php' );
			require_once( __DIR__ . '/widgets/university/university-future-tab.php' );
			require_once( __DIR__ . '/widgets/university/ellen-university.php' );
			require_once( __DIR__ . '/widgets/university/university-why-choose.php' );
			require_once( __DIR__ . '/widgets/university/university-launch.php' );
			require_once( __DIR__ . '/widgets/university/university-patner.php' );
			require_once( __DIR__ . '/widgets/university/university-feature.php' );
			require_once( __DIR__ . '/widgets/university/university-study-international.php' );
			require_once( __DIR__ . '/widgets/university/university-research.php' );
			require_once( __DIR__ . '/widgets/university/university-trusted.php' );
			require_once( __DIR__ . '/widgets/university/university-blog.php' );
			require_once( __DIR__ . '/widgets/university/university-top-header.php' );
			require_once( __DIR__ . '/widgets/university/university-navbar.php' );
			require_once( __DIR__ . '/widgets/university/university-find.php' );
			require_once( __DIR__ . '/widgets/university/university-explore-study.php' );
			require_once( __DIR__ . '/widgets/university/university-how-apply.php' );
			require_once( __DIR__ . '/widgets/university/university-faq.php' );
			require_once( __DIR__ . '/widgets/university/university-bachelors.php' );
			require_once( __DIR__ . '/widgets/university/single-program.php' );
			require_once( __DIR__ . '/widgets/university/international-students.php' );
			require_once( __DIR__ . '/widgets/university/university-event.php' );
			require_once( __DIR__ . '/widgets/university/university-event-two.php' );
			require_once( __DIR__ . '/widgets/university/single-event.php' );
			require_once( __DIR__ . '/widgets/university/speakers.php' );

			require_once( __DIR__ . '/widgets/school-college/sc-navbar.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-banner.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-our-school.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-about.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-why.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-kindergarten.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-gallery.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-left-blog.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-right-blog.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-journey.php' );
			require_once( __DIR__ . '/widgets/school-college/sc-admissions.php' );

			require_once( __DIR__ . '/widgets/health-demo/health-navbar.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-banner.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-mission.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-about.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-join.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-newsletter.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-reviews.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-why.php' );
			require_once( __DIR__ . '/widgets/health-demo/health-blog.php' );

			require_once( __DIR__ . '/widgets/page-banner.php' );

			require_once( __DIR__ . '/widgets/footer/footer-newsletter.php' );
			require_once( __DIR__ . '/widgets/footer/footer-list.php' );
			require_once( __DIR__ . '/widgets/footer/copyright.php' );
		}
	}

}
Elementor_ellen_Extension::instance();