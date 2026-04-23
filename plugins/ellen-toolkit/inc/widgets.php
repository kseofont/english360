<?php

class ellen_posts_thumbs extends WP_Widget{

    function __construct(){
        $widget_ops = array('description' => esc_html__('Display Random or Recent posts with a small image.', 'ellen-toolkit'));
        parent::__construct( false, esc_html__('Ellen Recent Posts With Image', 'ellen-toolkit'), $widget_ops);
    }

    function widget($args, $instance){
        global $ellen_theme;
        extract($args); //it receives an associative array

        $title = apply_filters('widget_title', $instance['title']);
        $args = array(
            'posts_per_page' => $instance['number'],
            'post_type' => 'post',
            'order' => 'DESC',
            'orderby' => $instance['orderby']
        );
        $query = new WP_Query($args);

        if( !$query->have_posts() ) return;
        echo $before_widget;
        if($title) echo $before_title.$title.$after_title;
        if(!$instance['number']) $instance['number'] = 4;

        if($query->have_posts()):
            $c = 0;

            while($query->have_posts()): $query->the_post(); ?>
                <?php
                $class = 'item';
                $post_id = get_the_ID();
                $thumb_size = 'ellen_widget_thumb';
                ?>
                <?php if( !has_post_thumbnail() ) $class .= ' no-thumb'; ?>
                <article <?php post_class($class); ?>>

                    <?php if( has_post_thumbnail() ): ?>
                        <?php
                        $thumb_id   = get_post_thumbnail_id($post_id);
                        $thumb_type = get_post_mime_type($thumb_id);
                        $image_alt  = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true);
                        if( !$image_alt ){
                            $image_alt = get_the_title($post_id);
                        }
                        if($thumb_type == 'image/gif'){
                            $thumb_size = '';
                        }
                        ?>
                        <a href="<?php the_permalink(); ?>" class="thumb hover-effect" aria-label="<?php the_title(); ?>">
                            <span class="fullimage cover" role="img" aria-label="<?php echo esc_attr($image_alt); ?>" style="background: url('<?php the_post_thumbnail_url($thumb_size); ?>');"></span>
                        </a>
                    <?php endif; ?>

                    <div class="info gradient-effect">
                        <h4 class="title usmall"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>                        <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time( get_option('date_format') ); ?></time>
                    </div>

                    <div class="clear"></div>
                </article>
            <?php
            endwhile;
            wp_reset_postdata();
        endif;
        echo $after_widget;
    }

    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['orderby'] = $new_instance['orderby'];
        return $instance;
    }

    function form($instance){
        $defaults = array(
            'title' => 'Recent posts',
            'number' => 4,
            'orderby' => 'date'
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php esc_html_e('Title:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts to show:', 'ellen-toolkit'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Mode:', 'ellen-toolkit') ?> </label>
            <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php if ($instance['orderby'] == 'date') echo 'selected="selected"'; ?> value="date"><?php esc_html_e('Recent Posts', 'ellen-toolkit'); ?></option>
                <option <?php if ($instance['orderby'] == 'rand') echo 'selected="selected"'; ?> value="rand"><?php esc_html_e('Random Posts', 'ellen-toolkit'); ?></option>
                <?php if( function_exists('get_field') ): // By views ?>
                    <option <?php if ($instance['orderby'] == 'views') echo 'selected="selected"'; ?> value="views"><?php esc_html_e('Post views', 'ellen-toolkit'); ?></option>
                <?php endif; ?>
            </select>
        </p>
        <?php
    }

}

function ellen_register_posts_thumbs() {
    register_widget('ellen_posts_thumbs');
}

add_action('widgets_init', 'ellen_register_posts_thumbs');

/**
 * Contact Info Widget
 */
class ellen_contact_info extends WP_Widget{

    function __construct(){
        $widget_ops = array('description' => esc_html__('Display Contact Info', 'ellen-toolkit'));
        parent::__construct( false, esc_html__('Ellen Contact Info', 'ellen-toolkit'), $widget_ops);
    }

    function widget($args, $instance){
        extract($args);
        global $ellen_theme;

        $title  = apply_filters('widget_title', $instance['title']);
        $social = ! empty( $instance['social'] ) ? '1' : '0';

        echo $before_widget;
        if($title) echo $before_title.$title.$after_title;
        ?>
        <ul class="footer-contact-info">
            <?php if( $instance['location'] != '' ): ?>
                <li>
                    <i class="bx bx-map"></i>
                    <a href="<?php echo esc_url( $instance['location_link'] ); ?>" target="_blank"><?php echo $instance['location']; ?></a>
                </li>
            <?php endif; ?>

            <?php if( $instance['phone'] != '' ): ?>
                <li>
                    <i class="bx bx-phone-call"></i>
                    <a href="<?php echo esc_url( $instance['phone_link'] ); ?>"><?php echo $instance['phone']; ?></a>
                </li>
            <?php endif; ?>

            <?php if( $instance['email'] != '' ): ?>
                <li>
                    <i class="bx bx-envelope"></i>
                    <a href="<?php echo esc_url( $instance['email_link'] ); ?>"><?php echo $instance['email']; ?></a>
                </li>
            <?php endif; ?>

            <?php if( $instance['fax'] != '' ): ?>
                <li>
                    <i class="bx bxs-inbox"></i>
                    <a href="<?php echo esc_url( $instance['fax_link'] ); ?>"><?php echo $instance['fax']; ?></a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if ( $social ) { ?>
            <?php ellen_social_link(); ?>
        <?php } ?>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance){
        $instance                    = $old_instance;
        $instance['title']           = strip_tags($new_instance['title']);
        $instance['location']        = $new_instance['location'];
        $instance['location_link']   = $new_instance['location_link'];
        $instance['phone']           = $new_instance['phone'];
        $instance['phone_link']      = $new_instance['phone_link'];
        $instance['email']           = $new_instance['email'];
        $instance['email_link']      = $new_instance['email_link'];
        $instance['phone_link']      = $new_instance['phone_link'];
        $instance['fax']             = $new_instance['fax'];
        $instance['fax_link']        = $new_instance['fax_link'];
		$instance['social']          = $new_instance['social'] ? 1 : 0;
        return $instance;
    }

    function form($instance){
        $defaults = array(
            'title'             => 'Address',
            'location'          => '2750 Quadra Street Victoria Road, New York, Canada',
            'location_link'     => '#',
            'phone'             => '+1 (123) 456 7890',
            'phone_link'        => 'tel:+11234567890',
            'email'             => 'hello@ellen.com',
            'email_link'        => 'mailto:hello@ellen.com',
            'phone_link'        => 'tel:+11234567890',
            'fax'               => '+55 785 4578964',
            'fax_link'          => 'tel:+55 785 4578964',
            'social'            => '',
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php esc_html_e('Title:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('location'); ?>">
                <?php esc_html_e('Location:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="text" value="<?php echo $instance['location']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('location_link'); ?>">
                <?php esc_html_e('Location Link:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('location_link'); ?>" name="<?php echo $this->get_field_name('location_link'); ?>" type="text" value="<?php echo $instance['location_link']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('phone'); ?>">
                <?php esc_html_e('Phone Number:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $instance['phone']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('phone_link'); ?>">
                <?php esc_html_e('Number Link:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('phone_link'); ?>" name="<?php echo $this->get_field_name('phone_link'); ?>" type="text" value="<?php echo $instance['phone_link']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>">
                <?php esc_html_e('Email:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $instance['email']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('email_link'); ?>">
                <?php esc_html_e('Email Link:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('email_link'); ?>" name="<?php echo $this->get_field_name('email_link'); ?>" type="text" value="<?php echo $instance['email_link']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('fax'); ?>">
                <?php esc_html_e('Fax:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo $instance['fax']; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('fax_link'); ?>">
                <?php esc_html_e('Fax Link:', 'ellen-toolkit'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('fax_link'); ?>" name="<?php echo $this->get_field_name('fax_link'); ?>" type="text" value="<?php echo $instance['fax_link']; ?>" />
            </label>
        </p>

        <p>
			<input class="checkbox" type="checkbox"<?php checked( $instance['social'] ); ?> id="<?php echo $this->get_field_id( 'social' ); ?>" name="<?php echo $this->get_field_name( 'social' ); ?>" /> <label for="<?php echo $this->get_field_id( 'social' ); ?>"><?php _e( 'Display social icons' ); ?></label>
		</p>
        <?php
    }

}

function ellen_register_contact_info() {
    register_widget('ellen_contact_info');
}

add_action('widgets_init', 'ellen_register_contact_info');