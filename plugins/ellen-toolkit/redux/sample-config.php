<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = ELLEN_FRAMEWORK_VAR;

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'opt_name/opt_name', $opt_name );

    // Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {
        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();
            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {
                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    // All the possible arguments for Redux.
    $theme = wp_get_theme(); // For use with some settings. Not necessary.
    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'ellen-toolkit' ),
        'page_title'           => esc_html__( 'Theme Options', 'ellen-toolkit' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 3,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'ellen_opt',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p></p>', 'ellen-toolkit' ), $v );
    } else {
        $args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ellen-toolkit' );
    }
    Redux::setArgs( $opt_name, $args );

// General Options
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( 'General Options', 'ellen-toolkit' ),
    'id'                => 'general_options',
    'customizer'        => false,
    'icon'              => ' el el-home',
    'fields'     => array(
        array(
            'id'      => 'ellen_enable_rtl',
            'type'    => 'select',
            'options' => array(
                'enable'        => 'Enable',
                'disable'       => 'Disable',
            ),
            'title'     => esc_html__( 'RTL', 'ellen-toolkit' ),
            'default'   => 'disable',
        ),
        array(
            'id'       => 'main_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Site Logo', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Upload here a image file for your logo', 'ellen-toolkit' ),
        ),
        array(
            'title'     => esc_html__( 'Main Logo dimensions', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload logo. Recommended size 160X35', 'ellen-toolkit' ),
            'id'        => 'logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array( 'em','px','%' ),
            'output'    => '.ellen-nav .navbar .navbar-brand'
        ),
        array(
            'id'       => 'mobile_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Logo For Mobile (optional)', 'ellen-toolkit' ),
            'subtitle' => esc_html__( 'Upload here a image file for your mobile logo.', 'ellen-toolkit' ),
        ),
        array(
            'title'     => esc_html__( 'Mobile Logo dimensions', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload logo. Recommended size 130X35', 'ellen-toolkit' ),
            'id'        => 'mobile_logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array( 'em','px','%' ),
            'output'    => '.ellen-responsive-menu>.logo>a>img'
        ),
        array(
            'id'       => 'footer_main_logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Site Logo for Footer', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload footer logo.Recommended size 160X35', 'ellen-toolkit' ),
        ),
        array(
            'title'     => esc_html__( 'Footer Logo dimensions', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Set a custom height width for your footer logo. Recommended size 160X35', 'ellen-toolkit' ),
            'id'        => 'footer_logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array( 'em','px','%' ),
            'output'    => '.single-footer-widget .logo>img'
        ),
        array(
            'id'        => 'enable_sticky_header',
            'type'      => 'switch',
            'title'     => esc_html__('Enable Sticky Header', 'ellen-toolkit'),
            'desc'      => esc_html__('', 'ellen-toolkit'),
            'default'   => '1'
        ),
        array(
            'id'        => 'enable_back_to_top',
            'type'      => 'switch',
            'title'     => esc_html__('Enable back-to-top Button', 'ellen-toolkit'),
            'default'   => '1'
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Preloader', 'ellen-toolkit' ),
    'id'               => 'preloader_opt',
    'icon'             => 'dashicons dashicons-controls-repeat',
    'customizer'    => false,
    'fields'           => array(

        array(
            'id'      => 'enable_preloader',
            'type'    => 'switch',
            'title'   => esc_html__( 'Pre-loader', 'ellen-toolkit' ),
            'on'      => esc_html__( 'Enable', 'ellen-toolkit' ),
            'off'     => esc_html__( 'Disable', 'ellen-toolkit' ),
            'default' => true,
        ),

        array(
            'required' => array( 'enable_preloader', '=', '1' ),
            'id'       => 'preloader_style',
            'type'     => 'select',
            'title'    => esc_html__( 'Pre-loader Style', 'ellen-toolkit' ),
            'default'   => 'text',
            'options'  => array(
                'circle-spin'   => esc_html__( 'Circle Spin Preloader', 'ellen-toolkit' ),
                'text'          => esc_html__( 'Text Preloader', 'ellen-toolkit' ),
                'image'         => esc_html__( 'Image Preloader', 'ellen-toolkit' )
            ),
            'default'  => array(
                'preloader_style'  => 'circle-spin',
            ),
        ),

        /**
         * Text Preloader
         */
        array(
            'title'     => esc_html__( 'Color', 'ellen-toolkit' ),
            'id'        => 'preloader_color',
            'type'      => 'color',
            'output'    => array( '.preloader .loader .sbl-half-circle-spin, .preloader p' ),
            'required'  => array( 'preloader_style', '!=', 'image' ),
        ),
        array(
            'id'       => 'loading_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Loading Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Loading', 'ellen-toolkit' ),
            'required' => array( 'preloader_style', '=', 'text' ),
        ),

        array(
            'title'         => esc_html__( 'Loading Text Typography', 'ellen-toolkit' ),
            'id'            => 'preloader_small_typo',
            'type'          => 'typography',
            'text-align'    => false,
            'color'         => false,
            'output'        => '.preloader p',
            'required' => array( 'preloader_style', '=', 'text' ),
        ),

        /**
         * Image Preloader
         */
        array(
            'required' => array( 'preloader_style', '=', 'image' ),
            'id'       => 'preloader_image',
            'type'     => 'media',
            'title'    => esc_html__( 'Pre-loader image', 'ellen-toolkit' ),
            'compiler' => true,
            'default'  => array(
                'url'  => get_template_directory_uri() .'/assets/img/status.gif'
            ),
        ),
    )
));

// Popup Option
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'Popup Subscribe', 'ellen-toolkit' ),
    'id'            => 'sub',
    'customizer'    => false,
    'icon'          => 'el el-resize-full',
    'fields'     => array(
        array(
            'id' => 'enable_popup_massage',
            'type' => 'switch',
            'title' => esc_html__('Enable Popup Message!', 'ellen-toolkit'),
            'default' => '1',
        ),
        array(
            'id'       => 'popup_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Popup Image', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
        array(
            'id'    => 'popup_title',
            'type'  => 'text',
            'title' => esc_html__( 'Popup Title', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Subscribe to our newsletter', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
        array(
            'id'    => 'popup_desc',
            'type'  => 'textarea',
            'title' => esc_html__( 'Popup Description', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Sign up to receive updates, promotions, and sneak peeks of upcoming courses. Plus 20% off your next course.', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
        array(
            'id'    => 'action_url',
            'type'  => 'text',
            'title' => esc_html__( 'Action URL', 'ellen-toolkit' ),
            'desc' => __( 'Enter here your MailChimp action URL. <a href="https://www.docs.envytheme.com/docs/ellen-theme-documentation/tips-guides-troubleshoots/get-mailchimp-newsletter-form-action-url/" target="_blank"> How to </a>', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
        array(
            'id'    => 'popup_place',
            'type'  => 'text',
            'title' => esc_html__( 'Popup Placeholder Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Enter your email', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
        array(
            'id'    => 'popup_button_text',
            'type'  => 'text',
            'title' => esc_html__( 'Popup Button Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Subscribe Now', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),

        array(
            'id'    => 'popup_bottom_desc',
            'type'  => 'textarea',
            'title' => esc_html__( 'Newsletter Bottom Description', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Your information will never be shared with any third party', 'ellen-toolkit' ),
            'required' => array( 'enable_popup_massage', '=', '1' ),
        ),
    ),
) );

// Header Option
Redux::setSection( $opt_name, array(
	'title' => esc_html__('Header', 'ellen-toolkit'),
	'icon'  => 'el el-align-justify',
	'customizer' => false,
	'fields' => array(
        array(
            'title'     => esc_html__( 'Header Template', 'ellen-toolkit' ),
            'subtitle'  => __( 'Navigate to Headers > Add New from your WordPress dashboard to add a new Header Template.', 'ellen-toolkit' ),
            'id'        => 'header_style',
            'type'      => 'select',
            'options'   => ellen_get_post_title_array('header'),
        ),
        array(
            'id'        => 'if_header_template_selected',
            'type'      => 'info',
            'style'     => 'warning',
            'title'     => esc_html__( 'Warning', 'ellen-toolkit' ),
            'desc'      => esc_html__( 'You have selected a Custom Header template. Now, all the Header Settings will not apply. Edit your Header template with Header Elementor.', 'ellen-toolkit' ),
            'required'  => array( 'header_style', '!=', '' ),
        ),
        array(
            'id'        => 'enable_search_bar',
            'type'      => 'switch',
            'title'     => esc_html__('Enable Search Bar', 'ellen-toolkit'),
            'default'   => '1',
            'required'  => array( 'header_style', '=', '' ),
        ),
        array(
			'id'        => 'search_placeholder_text',
            'type'      => 'text',
			'title'     => esc_html__('Course Search Placeholder Text', 'ellen-toolkit'),
            'required'  => array( 'enable_search_bar', '=', '1', ),
        ),
        array(
			'id'        => 'login_register_title',
            'type'      => 'text',
			'title'     => esc_html__('Login/Register Title', 'ellen-toolkit'),
            'required'  => array( 'header_style', '=', '' ),
        ),
        array(
            'id'        => 'login_register_link_type',
            'type'       => 'select',
            'options'   => ellen_toolkit_get_page_as_list(),
            'title'     => esc_html__( 'Login/Register Page', 'ellen-toolkit' ),
        ),
        array(
			'id'        => 'profile_text',
            'type'      => 'text',
			'title'     => esc_html__('Profile Title', 'ellen-toolkit'),
            'required'  => array( 'header_style', '=', '' ),
        ),
        array(
            'id'        => 'profile_link',
            'type'      => 'select',
            'options'   => ellen_toolkit_get_page_as_list(),
            'title'     => esc_html__( 'Profile Page', 'ellen-toolkit' ),
            'required'  => array( 'header_style', '=', '' ),
        ),
	)
) );

// Header Category Menu
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( 'Header Category Menu', 'ellen-toolkit' ),
    'id'                => 'header_category_menu',
    'customizer_width'  => '400px',
    'customizer'        => false,
    'subsection'        => true,
    'icon'              => 'el el-list-alt',
    'fields'            => array(
        array(
            'id'        => 'enable_category_menu',
            'type'      => 'switch',
            'title'     => esc_html__('Enable Category Menu', 'ellen-toolkit'),
            'default'   => '1',
        ),
        array(
            'id'        => 'header_category_title',
            'type'      => 'text',
            'title'     => esc_html__('Header Category Menu Title', 'ellen-toolkit'),
            'required'  => array( 'enable_category_menu', '=', '1' ),
        ),
        array(
            'id'        => 'header_category_number',
            'type'      => 'text',
            'validate' => 'numeric',
            'title'     => esc_html__('Count Course Categories', 'ellen-toolkit'),
            'min'       => '0',
            'required'  => array( 'enable_category_menu', '=', '1' ),
        ),
    ),
));

// Header Styling
Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Header Styling', 'ellen-toolkit' ),
    'id'               => 'header_styling_sec',
    'customizer_width' => '400px',
    'icon'             => 'el el-magic',
    'subsection'       => true,
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Navbar box layout', 'ellen-toolkit' ),
            'id'        => 'nav_layout',
            'type'      => 'select',
            'default'   => 'container-fluid',
            'options'   => array(
                'container' => esc_html__( 'Container', 'ellen-toolkit' ),
                'container-fluid' => esc_html__( 'Full Width', 'ellen-toolkit' ),
            )
        ),

        array(
            'title'     => esc_html__( 'Menu Alignment', 'ellen-toolkit' ),
            'id'        => 'menu_alignment',
            'type'      => 'select',
            'default'   => 'menu_right',
            'options'   => array(
                'menu_left'     => esc_html__( 'Left', 'ellen-toolkit' ),
                'menu_center'   => esc_html__( 'Center', 'ellen-toolkit' ),
                'menu_right'    => esc_html__( 'Right', 'ellen-toolkit' ),
            )
        ),
        array(
            'id'            => 'opt-typography-menu-item',
            'type'          => 'typography',
            'title'         => esc_html__( 'Menu Item Typography', 'ellen-toolkit' ),
            'google'        => true,
            'font-backup'   => true,
            'all_styles'    => true,
            'font-style'    => true,
            'font-weight'   => true,
            'font-size'     => true,
            'text-align'    => false,
            'color'         => false,
            'line-height'   => true,
            'output' => array(
                '.ellen-nav .navbar .navbar-nav .nav-item a',
            ),
        ),
        // Mobile Menu
        array(
            'id'            => 'opt-typography-mobile-menu-item',
            'type'          => 'typography',
            'title'         => esc_html__( 'Mobile Menu Item Typography', 'ellen-toolkit' ),
            'google'        => true,
            'font-backup'   => true,
            'all_styles'    => true,
            'font-style'    => true,
            'font-weight'   => true,
            'font-size'     => true,
            'text-align'    => false,
            'color'         => false,
            'line-height'   => true,
            'output' => array(
                '.mean-container .mean-nav ul li a, .mean-container .mean-nav ul li li a',
            ),
        ),

    ),
));

// Banner
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( 'Banner', 'ellen-toolkit' ),
    'id'                => 'banner_options',
    'customizer'        => false,
    'icon'              => 'el el-website',
    'fields'     => array(
        array(
            'id'        => 'page_title_tag',
            'type'      => 'select',
            'title'     => esc_html__( 'Banner Title Tag', 'ellen-toolkit' ),
            'options' => array(
                'h1'         => esc_html__( 'h1', 'ellen-toolkit' ),
                'h2'         => esc_html__( 'h2', 'ellen-toolkit' ),
                'h3'         => esc_html__( 'h3', 'ellen-toolkit' ),
                'h4'         => esc_html__( 'h4', 'ellen-toolkit' ),
                'h5'         => esc_html__( 'h5', 'ellen-toolkit' ),
                'h6'         => esc_html__( 'h6', 'ellen-toolkit' ),
            ),
            'default' => 'h1',
        ),
        array(
            'id'        => 'titlebar_title_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Title Typography', 'ellen-toolkit' ),
            'output'    => '.page-title-content h1, .page-title-content h2, .page-title-content h3, .page-title-content h4, .page-title-content h5, .page-title-content h6'
        ),

        array(
            'id'      => 'is_breadcrumb',
            'type'    => 'switch',
            'title'   => esc_html__( 'Breadcrumb', 'ellen-toolkit' ),
            'on'      => esc_html__( 'Enable', 'ellen-toolkit' ),
            'off'     => esc_html__( 'Disable', 'ellen-toolkit' ),
            'default' => true,
        ),

        array(
            'id'        => 'titlebar_breadcrumb_typo',
            'type'      => 'typography',
            'title'     => esc_html__( 'Breadcrumb Typography', 'ellen-toolkit' ),
            'output'    => '.page-title-content ul li, .learn-press-breadcrumb, .woocommerce-breadcrumb',
            'required'  => array('is_breadcrumb','equals','1'),
        ),

        array(
            'title'     => esc_html__( 'Banner Padding', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Padding around the Banner.', 'ellen-toolkit' ),
            'id'        => 'banner_padding',
            'type'      => 'spacing',
            'output'    => array( '.page-title-area' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),
            'units_extended' => 'true',
        ),
    ),
) );

// Social Profiles
Redux::setSection( $opt_name, array(
	'title' => esc_html__('Social Profiles', 'ellen-toolkit'),
	'desc'  => 'Social profiles are used in different places inside the theme.',
	'icon'  => 'el-icon-user',
	'customizer' => false,
	'fields' => array(
        array(
            'id' => 'ellen_social_target',
            'type' => 'select',
            'options' => array(
                '_blank'    => 'Load in a new window. ( _blank )',
                '_self'     => 'Load in the same frame as it was clicked. ( _self )',
                '_parent'   => 'Load in the parent frameset. ( _parent )',
                '_top'      => 'Load in the full body of the window ( _top )',
            ),
            'title'     => esc_html__( 'Social Link Target', 'ellen-toolkit' ),
            'default'   => '_blank',
        ),

        array(
			'id'    => 'twitter_url',
            'type'  => 'text',
			'title' => esc_html__('Twitter URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'facebook_url',
			'type'  => 'text',
			'title' =>esc_html__('Facebook URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'instagram_url',
			'type'  => 'text',
			'title' => esc_html__('Instagram URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'linkedin_url',
			'type'  => 'text',
			'title' => esc_html__('Linkedin URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'pinterest_url',
			'type'  => 'text',
			'title' =>esc_html__('Pinterest URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'dribbble_url',
			'type'  => 'text',
			'title' =>esc_html__('Dribbble URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'tumblr_url',
			'type'  => 'text',
			'title' =>esc_html__('Tumblr URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'youtube_url',
			'type'  => 'text',
			'title' =>  esc_html__('Youtube URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'flickr_url',
			'type'  => 'text',
			'title' =>  esc_html__('Flickr URL', 'ellen-toolkit')
		),
		array(
			'id'    => 'behance_url',
			'type'  => 'text',
			'title' =>  esc_html__('Behance URL', 'ellen-toolkit'),
		),
		array(
			'id'    => 'github_url',
			'type'  => 'text',
			'title' =>  esc_html__('Github URL', 'ellen-toolkit'),
		),
		array(
			'id'    => 'skype_url',
			'type'  => 'text',
			'title' =>  esc_html__('Skype URL', 'ellen-toolkit'),
		),
		array(
			'id'    => 'rss_url',
			'type'  => 'text',
			'title' =>  esc_html__('RSS URL', 'ellen-toolkit')
		),
	)
) );

// Footer Area
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( 'Footer', 'ellen-toolkit' ),
    'id'                => 'footer',
    'customizer'        => false,
    'icon'              => 'el el-edit',
    'fields' => array(
        array(
            'title'     => esc_html__( 'Footer Style', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Select a Footer template from here. Leave the field empty to use the default footer.', 'ellen-toolkit' ),
            'id'        => 'footer_style',
            'type'      => 'select',
            'options'   => ellen_get_post_title_array('footer'),
        ),
        array(
            'title'     => esc_html__( 'Footer Column', 'ellen-toolkit' ),
            'id'        => 'footer_column',
            'type'      => 'select',
            'default'   => '3',
            'options'   => array(
                '12' => esc_html__( 'One Column', 'ellen-toolkit' ),
                '6' => esc_html__( 'Two Column', 'ellen-toolkit' ),
                '4' => esc_html__( 'Three Column', 'ellen-toolkit' ),
                '3' => esc_html__( 'Four Column', 'ellen-toolkit' ),
            ),
        ),
		array(
			'id'    => 'footer_desc',
			'type'  => 'textarea',
			'title' =>  esc_html__('Footer Description', 'ellen-toolkit'),
        ),
        array(
            'id'        => 'enable_footer_social',
            'type'      => 'switch',
            'title'     => esc_html__('Enable Footer Social Icons', 'ellen-toolkit'),
            'default'   => '1'
        ),
        array(
            'id'       => 'footer_shape_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Footer Shape Image', 'ellen-toolkit' ),        ),
        array(
            'id'        => 'copyright_text',
            'type'      => 'editor',
            'title'     => esc_html__('Footer copyright text (optional)', 'ellen-toolkit'),
            'subtitle'  => esc_html__('HTML and Shortcodes are allowed', 'ellen-toolkit'),
            'desc'      => '',
            'args' => array(
                'teeny'         => true,
                'media_buttons' => false
            ),
        ),
    )
));

// Cursor
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( 'Cursor', 'ellen-toolkit' ),
    'id'                => 'cursor_options',
    'customizer'        => false,
    'icon'              => 'el el-move',
    'fields'     => array(
        array(
            'id'      => 'is_cursor',
            'type'    => 'switch',
            'title'   => esc_html__( 'Cursor Animation', 'ellen-toolkit' ),
            'on'      => esc_html__( 'Enable', 'ellen-toolkit' ),
            'off'     => esc_html__( 'Disable', 'ellen-toolkit' ),
            'default' => true,
        ),
        array(
            'title'     => esc_html__( 'Cursor Dot Color', 'ellen-toolkit' ),
            'id'        => 'cursor_dot_color',
            'type'      => 'color',
            'output'    => array( '.ellen-cursor' ),
            'mode'      => 'background-color',
            'required'  => array( 'is_cursor', '=', '1' ),
        ),
        array(
            'title'     => esc_html__( 'Cursor Border Color', 'ellen-toolkit' ),
            'id'        => 'cursor_border_color',
            'type'      => 'color',
            'output'    => array( '.ellen-cursor2' ),
            'mode'      => 'border-color',
            'required'  => array( 'is_cursor', '=', '1' ),
        ),
    ),
) );

// Custom Post
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'Custom Posts Settings', 'ellen-toolkit' ),
    'id'            => 'ellen_custom_posts',
    'customizer'    => false,
    'icon'          => 'el el-file-edit',
    'desc'          => 'Manage your features and program settings.',
    'fields' => array(
        array(
            'id' => 'ellen_program_banner_style',
            'type' => 'select',
            'options' => array(
                '1'           => esc_html__( 'Choose Single Program Banner Style - 1 ', 'ellen-toolkit' ),
                '2'           => esc_html__( 'Choose Single Program Banner Style - 2', 'ellen-toolkit' ),
            ),
            'title'     => esc_html__( 'Choose Banner Style', 'ellen-toolkit' ),
            'default'   => '1',
        ),
        array(
			'id'    => 'hide_program_banner',
            'type'  => 'switch',
            'title' => esc_html__('Hide Single Program Banner', 'ellen-toolkit'),
            'default'   => '0'
        ),
        array(
			'id'    => 'hide_program_breadcrumb',
            'type'  => 'switch',
			'title' => esc_html__('Hide Single Program Breadcrumb', 'ellen-toolkit'),
            'default'   => '0',
            'required'    => array('hide_program_banner','equals','0'),
        ),
        array(
            'id'       => 'program_img',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Single Program Images', 'ellen-toolkit' ),
            'required' => array('hide_program_banner','equals','0'),
        ),
        array(
            'id'       => 'program_permalink',
            'type'     => 'text',
            'title'    => esc_html__( 'Single Program Permalink', 'ellen-toolkit' ),
            'default'  => esc_html__('program-post', 'ellen-toolkit'),
            'desc'     => '<p>After changing the permalink go to <strong style="color:#28a745;">Settings Permalinks</strong> and hit <strong style="color:#28a745;">Save Changes</strong> button.</p>',
        ), 
        array(
            'id'       => 'event_permalink',
            'type'     => 'text',
            'title'    => esc_html__( 'Single Event Permalink', 'ellen-toolkit' ),
            'default'  => esc_html__('event-post', 'ellen-toolkit'),
            'desc'     => '<p>After changing the permalink go to <strong style="color:#28a745;">Settings Permalinks</strong> and hit <strong style="color:#28a745;">Save Changes</strong> button.</p>',
        ),      
    )
));

// Styling
Redux::setSection( $opt_name, array(
    'title'        => esc_html__( 'Styling Options', 'ellen-toolkit' ),
    'id'           => 'styling_options',
    'customizer'   => false,
    'icon'         => ' el el-magic',
    'fields'     => array(
        array(
            'id'            => 'primary_color',
            'type'          => 'color',
            'title'         => esc_html__('Primary Color', 'ellen-toolkit'),
            'default'       => '#08A9E6',
            'validate'      => 'color',
            'transparent'   => false,
        ),
        array(
            'id'            => 'secondary_color',
            'type'          => 'color',
            'title'         => esc_html__('Secondary Color', 'ellen-toolkit'),
            'default'       => '#EC272E',
            'validate'      => 'color',
            'transparent'   => false,
        ),
        array(
            'id'            => 'gradientRight',
            'type'          => 'color',
            'title'         => esc_html__('Gradient Right Color', 'ellen-toolkit'),
            'default'       => '#6B48FF',
            'validate'      => 'color',
            'output'      => array(
                '--gradientRight' => ':root',
            ),
            'transparent'   => false,
        ),
        array(
            'id'            => 'header_background_color',
            'type'          => 'color',
            'title'         => esc_html__('Header Background Color.', 'ellen-toolkit'),
            'default'       => '#fff',
            'validate'      => 'color',
            'transparent'   => false
        ),
        array(
            'title'     => esc_html__( 'Menu Item Color', 'ellen-toolkit' ),
            'id'        => 'menu_item_color',
            'type'      => 'color',
            'output'    => array( '.ellen-nav .navbar .navbar-nav .nav-item .nav-link, .ellen-nav .navbar .navbar-nav .nav-item .dropdown-menu .nav-item .nav-link' ),
            'important'     => true,
        ),
        array(
            'id'            => 'footer_bg',
            'type'          => 'color',
            'title'         => esc_html__('Footer Background Color.', 'ellen-toolkit'),
            'default'       => '#E6F8FF',
            'validate'      => 'color',
            'transparent'   => false,
        ),
        array(
            'title'     => esc_html__( 'Footer Color', 'ellen-toolkit' ),
            'id'        => 'footer_item_color',
            'type'      => 'color',
            'output'    => array( '.footer-area .single-footer-widget p, .footer-area .single-footer-widget ul li, .single-footer-widget .footer-contact-info li a, .single-footer-widget ul li a' ),
        ),
        array(
            'title'     => esc_html__( 'Footer Title Color', 'ellen-toolkit' ),
            'id'        => 'footer_title_color',
            'type'      => 'color',
            'output'    => array( '.footer-area .single-footer-widget h3' ),
        ),
    ),
) );

// Blog Area
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'Blog Settings', 'ellen-toolkit' ),
    'id'            => 'ellen_blog',
    'customizer'    => false,
    'icon'          => 'el el-file-edit',
    'desc'          => 'Manage your blog settings.',
    'fields' => array(
        array(
            'id' => 'ellen_blog_style',
            'type' => 'select',
            'options' => array(
                '1'         => 'Style One',
                '2'         => 'Style Two',
            ),
            'title'     => esc_html__( 'Blog Style', 'ellen-toolkit' ),
            'default'   => '1',
        ),
        array(
			'id'    => 'ellen_search_page',
            'type'  => 'switch',
            'title' => esc_html__('Enable Pages on Search Result Page', 'ellen-toolkit'),
        ),
        array(
			'id'    => 'hide_breadcrumb',
            'type'  => 'switch',
			'title' => esc_html__('Hide Blog Breadcrumb', 'ellen-toolkit'),
            'default'   => '0',
        ),
        array(
            'id'       => 'blog_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Blog Page Title', 'ellen-toolkit' ),
        ),
        array(
            'id' => 'ellen_blog_layout',
            'type' => 'select',
            'options' => array(
                'container'                 => esc_html__( 'Container', 'ellen-toolkit' ),
                'container-fluid'           => esc_html__( 'Container Fluid', 'ellen-toolkit' ),
            ),
            'title'     => esc_html__( 'Blog Width', 'ellen-toolkit' ),
            'default'   => 'container',
        ),
        array(
            'id' => 'ellen_blog_grid',
            'type' => 'select',
            'options' => array(
                'col-lg-12 col-md-12'       => esc_html__( 'One Column', 'ellen-toolkit' ),
                'col-lg-6 col-md-6'         => esc_html__( 'Two Column', 'ellen-toolkit' ),
                'col-lg-4 col-md-6'         => esc_html__( 'Three Column', 'ellen-toolkit' ),
                'col-lg-3 col-md-6'         => esc_html__( 'Four Column', 'ellen-toolkit' ),
            ),
            'title'     => esc_html__( 'Blog Sidebar', 'ellen-toolkit' ),
            'default'   => 'col-lg-12 col-md-12',
        ),
        array(
            'id' => 'ellen_blog_sidebar',
            'type' => 'select',
            'options' => array(
                'ellen_with_sidebar'              => 'With Sidebar',
                'ellen_without_sidebar'           => 'Without Sidebar ( full width )',
                'ellen_without_sidebar_center'    => 'Without Sidebar( center )',
            ),
            'title'     => esc_html__( 'Blog Sidebar', 'ellen-toolkit' ),
            'default'   => 'ellen_with_sidebar',
        ),

        array(
            'id' => 'ellen_single_blog_sidebar',
            'type' => 'select',
            'options' => array(
                'ellen_with_sidebar'              => 'With Sidebar',
                'ellen_without_sidebar'           => 'Without Sidebar ( full width )',
                'ellen_without_sidebar_center'    => 'Without Sidebar( center )',
            ),
            'title'     => esc_html__( 'Single Blog Sidebar', 'ellen-toolkit' ),
            'default'   => 'ellen_with_sidebar',
        ),
        array(
			'id'    => 'hide_post_meta',
            'type'  => 'switch',
			'title' => esc_html__('Hide Post Meta', 'ellen-toolkit'),
            'default'   => '0',
        ),
    )
));

// Courses Post
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'Course Settings', 'ellen-toolkit' ),
    'id'            => 'ellen_course',
    'customizer'    => false,
    'icon'          => 'el el-file-edit',
    'desc'          => 'Manage your Course settings.',
    'fields' => array(
        array(
            'id'       => 'tutor_course_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Tutor/LearnPress Course Page Title Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Courses', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'course_page_bg_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( 'Course Page Background Image', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'course_last_updated_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Updated Text', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'price_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Price Label Title', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Price', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'course_level',
            'type'     => 'text',
            'title'    => esc_html__( 'Course Level Title', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Course Level', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'lessons_label',
            'type'     => 'text',
            'title'    => esc_html__( 'Lessons Label Text', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'duration_label',
            'type'     => 'text',
            'title'    => esc_html__( ' Duration Label Text', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'enrolled_label',
            'type'     => 'text',
            'title'    => esc_html__( 'Enrolled Label Text', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'last_updated_label',
            'type'     => 'text',
            'title'    => esc_html__( 'Updated Label Text', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'share_course_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Share Course Title', 'ellen-toolkit' ),
        ),
    )
));

// Tutor LMS
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'Tutor LMS Settings', 'ellen-toolkit' ),
    'id'            => 'ellen_course_tutor',
    'customizer'    => false,
    'subsection'    => true,
    'icon'          => 'el el-file-edit',
    'desc'          => 'Manage your Tutor LMS Course settings.',
    'fields' => array(
        array(
            'id'       => 'buy_course_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Buy Course Button Text', 'ellen-toolkit' ),
        ),
    )
));

// LearnPress LMS
Redux::setSection( $opt_name, array(
    'title'         => esc_html__( 'LearnPress Settings', 'ellen-toolkit' ),
    'id'            => 'ellen_course_lp',
    'customizer'    => false,
    'subsection'    => true,
    'icon'          => 'el el-file-edit',
    'desc'          => 'Manage your LearnPress settings.',
    'fields' => array(
        array(
            'id' => 'lp_default_layout',
            'type' => 'select',
            'options' => array(
                'theme_layout'      => 'Theme Design Layout',
                'plugin_layout'     => 'LearnPress Plugin Default Layout',
            ),
            'title'     => esc_html__( 'LearnPress All Pages Layout', 'ellen-toolkit' ),
            'default'   => 'theme_layout',
        ),

        array(
            'id'        => 'if_lp_default_layout_plugin_layout',
            'type'      => 'info',
            'style'     => 'warning',
            'title'     => esc_html__( 'Warning', 'ellen-toolkit' ),
            'desc'      => esc_html__( 'You have selected a LearnPress Plugin Layout. Now, all of LearnPress pages design and layout comes from plugin default and some theme options will not work as pages content comes from LearnPress plugin. Please go to LearnPress->Settings to update your courses settings.', 'ellen-toolkit' ),
            'required'  => array( 'lp_default_layout', '!=', 'theme_layout' ),
        ),
        array(
            'id'       => 'lessons_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Lessons Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Lessons', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'students_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Students Text', 'ellen-toolkit' ),
            'default'  => esc_html__( 'Students', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'rating_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Rating Title', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'student_label',
            'type'     => 'text',
            'title'    => esc_html__( 'Students Label Text', 'ellen-toolkit' ),
        ),
    )
));

// Typography
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Typography', 'ellen-toolkit' ),
    'desc' => esc_html__( 'Manage your fonts and typefaces.', 'ellen-toolkit' ),
    'icon' => 'el-icon-fontsize',
    'customizer'    => false,
    'fields' => array(
        array(
            'id'            => 'opt-typography-body',
            'type'          => 'typography',
            'title'         => esc_html__( 'Body primary font', 'ellen-toolkit' ),
            'google'        => true, // Disable google fonts. Won't work if you haven't defined your google api key
            'font-backup'   => true, // Select a backup non-google font in addition to a google font
            'all_styles'    => false, // Enable all Google Font style/weight variations to be added to the page
            'font-style'    => false,
            'font-weight'   => false,
            'font-size'     => false,
            'text-align'    => false,
            'color'         => false,
            'line-height'   => false,
            'output' => array(
                "body, .tutor-font-family, .tutor-backend #wpbody-content, [class*='tutor-screen-'], .tutor-course-details-page, .tutor-course-single-content-wraper, .tutor-wrap",
            ),
        ),
    ),
) );

// Advanced Settings
Redux::setSection( $opt_name, array(
	'title'         => esc_html__('Advanced Settings', 'ellen-toolkit'),
    'icon'          => 'el-icon-cogs',
    'customizer'    => false,
	'fields' => array(
		array(
			'id' => 'css_code',
			'type' => 'ace_editor',
			'title' => esc_html__('Custom CSS Code', 'ellen-toolkit'),
			'desc' => esc_html__('e.g. .btn-primary{ background: #000; } Don\'t use &lt;style&gt; tags', 'ellen-toolkit'),
			'subtitle' => esc_html__('Paste your CSS code here.', 'ellen-toolkit'),
			'mode' => 'css',
			'theme' => 'monokai'
		),
		array(
			'id'        => 'js_code',
			'type'      => 'ace_editor',
			'title'     => esc_html__('Custom JS Code', 'ellen-toolkit'),
			'desc'      => esc_html__('e.g. alert("Hello World!"); Don\'t use&lt;script&gt;tags.', 'ellen-toolkit'),
			'subtitle'  => esc_html__('Paste your JS code here.', 'ellen-toolkit'),
			'mode'      => 'javascript',
			'theme'     => 'monokai'
		)
	)
) );

// WooCommerce Product
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'WooCommerce', 'ellen-toolkit' ),
    'desc'  => esc_html__( 'Manage product page settings.', 'ellen-toolkit' ),
    'icon'  => 'el-icon-list-alt',
    'customizer'    => false,
    'fields' => array(
        array(
            'title'     => esc_html__( 'Page title', 'ellen-toolkit' ),
            'subtitle'  => esc_html__( 'Give here the shop page title', 'ellen-toolkit' ),
            'desc'      => esc_html__( 'This text will show on the shop page banner', 'ellen-toolkit' ),
            'id'        => 'shop_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Shop', 'ellen-toolkit' ),
        ),

        array(
            'id'    => 'enable_auto_complete',
            'type'  => 'select',
            'options' => array(
                'yes'       => 'Yes',
                'no'        => 'No',
            ),
            'title' => esc_html__('Enable Woocommerce Automatically Complete Orders', 'ellen-toolkit'),
            'default'   => 'yes',
        ),
        array(
            'id'    => 'product_columns',
            'type'  => 'select',
            'options' => array(
                ''         => 'Default',
                '2'        => '2',
                '3'        => '3',
                '4'        => '4',
            ),
            'title' => esc_html__('Select Product Columns', 'ellen-toolkit'),
            'default'   => '',
        ),
        array(
            'id'        => 'products_page_count',
            'desc'      => esc_html__( 'Number of products per page on product pages.', 'ellen-toolkit' ),
            'type'      => 'text',
            'title'     => esc_html__( 'Products per page', 'ellen-toolkit' ),
            'default'   => '6',
        ),
        array(
            'id'    => 'ellen_product_sidebar',
            'type'  => 'select',
            'options' => array(
                'ellen_product_no_sidebar'       => 'None',
                'ellen_product_left_sidebar'     => 'Sidebar on the left',
                'ellen_product_right_sidebar'    => 'Sidebar on the right',
            ),
            'title'     => esc_html__( 'Product Sidebar Position', 'ellen-toolkit' ),
            'default'   => 'ellen_product_no_sidebar',
        ),
        array(
            'id'    => 'ellen_related_product_count',
            'type'  => 'text',
            'title' => esc_html__( 'Product Details Related Product Count', 'ellen-toolkit' ),
            'desc'  => esc_html__( 'e.g. 3', 'ellen-toolkit' ),
            'default' => '3',
        ),
        array(
            'id'        => 'enable_product_share',
            'type'      => 'switch',
            'title'     => esc_html__('Enable Product Social share', 'ellen-toolkit'),
            'default'   => '0'
        ),

        array(
            'id'        => 'enable_social_share_title',
            'type'      => 'text',
            'title'     => esc_html__('Share Title', 'ellen-toolkit'),
            'default'   => 'Share:',
            'required'  => array('enable_product_share','equals','1'),
        ),
        array(
            'id'        => 'enable_product_fb',
            'type'      => 'switch',
            'title'     => esc_html__('Share on Facebook', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),

        array(
            'id'        => 'enable_product_tw',
            'type'      => 'switch',
            'title'     => esc_html__('Share on Twitter', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),
        array(
            'id'        => 'enable_product_ld',
            'type'      => 'switch',
            'title'     => esc_html__('Share on LinkedIn', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),
        array(
            'id'        => 'enable_product_wp',
            'type'      => 'switch',
            'title'     => esc_html__('Share on WhatsApp', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),
        array(
            'id'        => 'enable_product_email',
            'type'      => 'switch',
            'title'     => esc_html__('Share by Email', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),
        array(
            'id'        => 'enable_product_cp',
            'type'      => 'switch',
            'title'     => esc_html__('Copy link', 'ellen-toolkit'),
            'default'   => '0',
            'required'  => array('enable_product_share','equals','1'),
        ),
    ),
));

// 404 Area
Redux::setSection( $opt_name, array(
    'title'             => esc_html__( '404 Settings', 'ellen-toolkit' ),
    'id'                => 'ellen_404',
    'customizer'        => false,
    'icon'              => 'el el-question-sign',
    'fields'            => array(
        array(
            'id'       => 'not_found_image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( '404 Page Image', 'ellen-toolkit' ),
        ),
        array(
            'id'    => 'title_not_found',
            'type'  => 'text',
            'title' => esc_html__('404 Title', 'ellen-toolkit'),
        ),
        array(
            'id'       => 'content_not_found',
            'type'     => 'textarea',
            'title'    => esc_html__( '404 Content', 'ellen-toolkit' ),
        ),
        array(
            'id'       => 'button_not_found',
            'type'     => 'text',
            'title'    => esc_html__( 'Back to Home Button Text', 'ellen-toolkit' ),
        ),
    )
));

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    // Custom function for the callback validation referenced above
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    // Custom function for the callback referenced above
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'ellen-toolkit' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ellen-toolkit' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    // Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    // Filter hook for filtering the default value of any given field. Very useful in development mode.
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    // Removes the demo link and the notice of integrated demo from the redux-framework plugin
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }