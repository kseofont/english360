<?php
/**
 * Event Single Widget
 */

namespace Elementor;

class Ellen_Event_Single extends Widget_Base {

    public function get_name() {
        return 'Ellen_Event_Single';
    }

    public function get_title() {
        return __( 'Event Single', 'ellen-toolkit' );
    }

    public function get_icon() {
        return 'eicon-gallery-group';
    }

    public function get_categories() {
        return [ 'ellen-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'Ellen_Event_Area',
            [
                'label' => __( 'Event Controls', 'ellen-toolkit' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'map_url',
            [
                'label'       => __( 'Map Url', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48064.52655670767!2d28.862469830475504!3d41.15563322027775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x83455128bdb4ef74!2sGokturk%20Picnic%20Area!5e0!3m2!1sen!2sbd!4v1631607806776!5m2!1sen!2sbd', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'event_time_icon',
            [
                'label'       => __( 'Event Time Icon', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('bx bx-time', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'event_time',
            [
                'label'       => __( 'Event Time', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('11:00 AM - 03:00 AM', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'event_location_icon',
            [
                'label'       => __( 'Event Location Icon', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('bx bx-map', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'location_title',
            [
                'label'       => __( 'Location Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Istanbul, Turkey', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'content',
            [
                'label'       => __( 'Content', 'ellen-toolkit' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'info_title',
            [
                'label'       => __( 'Infornation Title', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Event Information', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'selected_product',
            [
                'label' => __('Select Product', 'ellen-toolkit'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_woocommerce_products(),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'cost_text',
            [
                'label'       => __( 'Cost Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Cost:', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'total_text',
            [
                'label'       => __( 'Total Slot Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Total Slot:', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'av_text',
            [
                'label'       => __( 'Available Slot Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Available Slot:', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'book_btn_text',
            [
                'label'       => __( 'Book Button Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Book Now', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'book_bottom_text',
            [
                'label'       => __( 'Book Bottom Text', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('You must  <span>login</span> before register event.', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'social_share',
            [
                'label'       => __( 'Social Share', 'ellen-toolkit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Share This Events', 'ellen-toolkit'),
                'label_block' => true,
            ]
        );
       
        $this->end_controls_section();

        $this->start_controls_section(
            'event_style',
            [
                'label' => __( 'Style', 'ellen-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'title_color',
                [
                    'label'     => __( 'Title Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .events-details-desc h3, {{WRAPPER}} .events-details-desc h1, {{WRAPPER}} .events-details-desc h2, {{WRAPPER}} .events-details-desc h4, {{WRAPPER}} .events-details-desc h5, {{WRAPPER}} .events-details-desc h6' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'title_typography',
                    'label'    => __( 'Title Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}}  .events-details-desc h3, {{WRAPPER}} .events-details-desc h1, {{WRAPPER}} .events-details-desc h2, {{WRAPPER}} .events-details-desc h4, {{WRAPPER}} .events-details-desc h5, {{WRAPPER}} .events-details-desc h6',
                ]
            );
           
            $this->add_control(
                'content_color',
                [
                    'label'     => __( 'Content Color', 'ellen-toolkit' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .events-details-desc p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'content_typography',
                    'label'    => __( 'Content Typography', 'ellen-toolkit' ),
                    'selector' => '{{WRAPPER}} .events-details-desc p',
                ]
            );
        $this->end_controls_section();
    }

    private function get_woocommerce_products() {
        if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            return [];
        }

        $products = wc_get_products(['limit' => -1]);
        $options = [];
        foreach ($products as $product) {
            $options[$product->get_id()] = $product->get_name();
        }
        return $options;
    }

        protected function render() {
            $settings = $this->get_settings_for_display();
          
            $product_id = isset( $settings['selected_product'] ) ? $settings['selected_product'] : 0;
            $price = 0;
    
            if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && $product_id ) {
                $product = wc_get_product($product_id);
                $price = $product ? $product->get_price() : 0;
                
                if ($product) {
                    // Check if stock management is enabled
                    if ($product->get_manage_stock()) {
                        $total_stock = $product->get_stock_quantity();
                    } else {
                        $total_stock = __('Stock management disabled', 'ellen-toolkit');
                    }

                    // Check if the product is a variable product
                    if ($product->is_type('variable')) {
                        $total_stock = 0; 
                        $variations = $product->get_children(); 

                        foreach ($variations as $variation_id) {
                            $variation = wc_get_product($variation_id);
                            if ($variation->get_manage_stock()) {
                                $total_stock += $variation->get_stock_quantity();
                            }
                        }
                    }

                    // Check if stock management is enabled
                    if ($product->get_manage_stock()) {
                        $available_stock = $product->get_stock_quantity();
                    } else {
                        $available_stock = __('Stock management disabled', 'your-text-domain');
                    }

                    if ($product && $product->is_type('variable')) {
                        $available_stock = 0; 
                        $variations = $product->get_children();
                        foreach ($variations as $variation_id) {
                            $variation = wc_get_product($variation_id);
                            if ($variation->get_manage_stock()) {
                                $available_stock += $variation->get_stock_quantity();
                            }
                        }
                    }
                }
            }

            ?>
            
            <div class="events-details-area ptb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="events-details-location">
                                <?php if( $settings['map_url']): ?>
                                    <iframe src="<?php echo wp_kses_post( $settings['map_url'] ); ?>"></iframe>
                                <?php endif; ?>
                                <ul class="info">
                                    <?php if( $settings['event_time_icon'] && $settings['event_time']): ?>
                                        <li><i class="<?php echo esc_attr( $settings['event_time_icon'] ); ?>"></i> <?php echo wp_kses_post( $settings['event_time'] ); ?></li>
                                    <?php endif; ?>
                                    <?php if( $settings['event_location_icon'] && $settings['location_title']): ?>
                                        <li><i class="<?php echo esc_attr( $settings['event_location_icon'] ); ?>"></i> <?php echo wp_kses_post( $settings['location_title'] ); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php if( $settings['content']): ?>
                                <div class="events-details-desc">
                                    <?php echo wp_kses_post( $settings['content'] ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && $product_id ) : ?>
                                <form method="post" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
                                    <div class="events-details-info">
                                        <ul class="info">
                                            <?php if($settings['cost_text']): ?>
                                                <li class="price">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><?php echo wp_kses_post( $settings['cost_text'] ); ?></span>
                                                        <div class="pricing-tags">
                                                        <?php if ($product) {
                                                            echo $product->get_price_html();
                                                        } ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endif; ?>

                                            <?php if($settings['total_text'] && $total_stock): ?>
                                                <li>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><?php echo wp_kses_post( $settings['total_text'] ); ?></span>
                                                        <?php echo wp_kses_post( is_numeric($total_stock) ? $total_stock : 'N/A' ); ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            <?php if($settings['av_text']): ?>
                                                <li>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span><?php echo wp_kses_post( $settings['av_text'] ); ?></span>
                                                    
                                                        <?php echo wp_kses_post(is_numeric($available_stock) ? $available_stock : 'N/A'); ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="btn-box">
                                            <?php if( $settings['book_btn_text']): ?>
                                                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>">
                                                <input type="hidden" id="hidden-total-price" name="total_price" value="<?php echo esc_attr($price); ?>">
                                                <button type="submit" class="default-btn"><?php echo wp_kses_post( $settings['book_btn_text'] ); ?></button>
                                            <?php endif; ?>
                                            <?php if ( !is_user_logged_in() ) : ?>
                                                <p><?php echo wp_kses_post( $settings['book_bottom_text'] ); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <?php 
                                
                                            $share_url      = get_the_permalink();
                                            $share_title    = get_the_title();
                                           
                                        ?>

                                        <div class="events-share">
                                            <div class="share-info">
                                                <?php if($settings['social_share']): ?>
                                                    <span><?php echo wp_kses_post( $settings['social_share'] ); ?>  <i class='bx bx-share-alt'></i></span>
                                                <?php endif; ?>
                                                <ul class="social-link">
                                                   
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>" onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;" class="text-decoration-none facebook" target="_blank"><i class="bx bxl-facebook"></i></a></li>
                                                    <li><a href="https://x.com/share?text=<?php echo urlencode($share_title); ?>&url=<?php echo esc_url($share_url); ?>" class="text-decoration-none twitter" target="_blank"><i class="bx bxl-twitter"></i></a></li>
                                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($share_url); ?>&amp;title=<?php echo urlencode($share_title); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>" onclick="window.open(this.href, 'linkedin','width=580,height=296'); return false;" class="text-decoration-none linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                            
                            <div class="events-details-contact-info">

                                <?php if ( comments_open() ) : ?>
                                    <?php
                                        // If comments are open or we have at least one comment, load up the comment template.
                                        if ( comments_open() || get_comments_number() ) :
                                            comments_template();
                                        endif;
                                    ?>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


       
        <!-- Event Details Area End -->
        <?php
        
    }
}

Plugin::instance()->widgets_manager->register( new Ellen_Event_Single );
