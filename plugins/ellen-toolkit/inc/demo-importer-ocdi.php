<?php
/**
 * Demo Import with One Click Demo Importer Plugin
 */


if (! defined('ABSPATH')) {
    exit;
}

class Demo_Importer_OCDI
{

    public function __construct()
    {
        add_filter('pt-ocdi/import_files', array( $this, 'demo_config' ));
        add_filter('pt-ocdi/after_import', array( $this, 'after_import' ));
        add_filter('pt-ocdi/disable_pt_branding', '__return_true');
    }

    public function demo_config() {
        return [
            [
            'import_file_name'           => 'Tutor LMS Demo',
            'import_file_url'            => get_template_directory_uri() . '/lib/sample-data/tutor/contents.xml',
            'import_widget_file_url'     => get_template_directory_uri() . '/lib/sample-data/tutor/widgets.wie',
            'import_customizer_file_url' => get_template_directory_uri() . '/lib/sample-data/tutor/customizer.dat',
            'import_redux'               => [
                [
                'file_url'    => get_template_directory_uri() . '/lib/sample-data/tutor/options.json',
                'option_name' => 'ellen_opt',
                ],
            ],
            'import_preview_image_url'   => esc_url( get_template_directory_uri() ) . '/screenshot.png',
            'preview_url'                => 'https://themes.envytheme.com/ellen/',
            ],
            [
                'import_file_name'           => 'LearnPress Demo',
                'import_file_url'            => get_template_directory_uri() . '/lib/sample-data/learnpress/contents.xml',
                'import_widget_file_url'     => get_template_directory_uri() . '/lib/sample-data/learnpress/widgets.wie',
                'import_customizer_file_url' => get_template_directory_uri() . '/lib/sample-data/learnpress/customizer.dat',
                'import_redux'               => [
                [
                    'file_url'    => get_template_directory_uri() . '/lib/sample-data/learnpress/options.json',
                    'option_name' => 'ellen_opt',
                ],
                ],
                'import_preview_image_url'   => esc_url( get_template_directory_uri() ) . '/screenshot.png',
                'preview_url'                => 'https://themes.envytheme.com/ellen/',
            ],
        ];
    }

    public function after_import($selected_import)
    {
        $this->assign_menu();
        $this->assign_frontpage($selected_import);
        $this->assign_woocommerce_pages();
        $this->update_permalinks();
    }

    private function assign_menu()
    {
        $primary  = get_term_by('name', 'Primary Menu', 'nav_menu');

        set_theme_mod('nav_menu_locations', array(
            'primary'  => $primary->term_id,
        ));
    }

    private function assign_frontpage($selected_import)
    {
        $blog_page  = get_page_by_title('Blog');
        $front_page = get_page_by_title('eLearning School');

        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page->ID);
        update_option('page_for_posts', $blog_page->ID);
    }

    private function assign_woocommerce_pages()
    {
        $shop     = get_page_by_title('Shop');
        $cart     = get_page_by_title('Cart');
        $checkout = get_page_by_title('Checkout');
        $account  = get_page_by_title('My Account');

        update_option('woocommerce_shop_page_id', $shop->ID);
        update_option('woocommerce_cart_page_id', $cart->ID);
        update_option('woocommerce_checkout_page_id', $checkout->ID);
        update_option('woocommerce_myaccount_page_id', $account->ID);
    }

    private function update_permalinks()
    {
        update_option('permalink_structure', '/%postname%/');
    }
}

new Demo_Importer_OCDI;
