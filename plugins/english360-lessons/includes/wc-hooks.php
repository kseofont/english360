<?php
defined('ABSPATH') || exit;

add_action('woocommerce_order_status_processing', 'e360_on_order_paid', 10, 1);
add_action('woocommerce_order_status_completed',  'e360_on_order_paid', 10, 1);

function e360_on_order_paid($order_id) {
    if (!function_exists('wc_get_order')) return;

    $order = wc_get_order($order_id);
    if (!$order) return;

    // защита от повторного создания
    if ($order->get_meta('_e360_entitlements_created')) return;

    $user_id = (int) $order->get_user_id();
    if ($user_id <= 0) {
        return;
    }

    global $wpdb;
    $entitlements = $wpdb->prefix . 'e360_entitlements';

    $now_mysql = current_time('mysql');
    $now_ts    = current_time('timestamp');

    // ✅ Счётчик реально созданных entitlement
    $created = 0;

    foreach ($order->get_items('line_item') as $item) {
        $product_id = (int) ($item->get_variation_id() ?: $item->get_product_id());
        if ($product_id <= 0) continue;

        $plan_type       = get_post_meta($product_id, 'e360_product_type', true);  // trial|package|single
        $lessons_total   = (int) get_post_meta($product_id, 'e360_credits', true); // кол-во уроков
        $session_minutes = (int) get_post_meta($product_id, 'e360_session_minutes', true);
        $valid_days      = (int) get_post_meta($product_id, 'e360_valid_days', true);

        if (!$plan_type || !in_array($plan_type, ['trial','package','single'], true)) continue;

        if ($lessons_total <= 0) $lessons_total = 1;
        if ($session_minutes <= 0) $session_minutes = 60;
        if ($valid_days <= 0) $valid_days = 90;

        $valid_from  = $now_mysql;
        $valid_until = date('Y-m-d H:i:s', $now_ts + ($valid_days * DAY_IN_SECONDS));

        $qty = (int) $item->get_quantity();
        if ($qty < 1) $qty = 1;

        $course_id = (int) $item->get_meta('e360_course_id', true);


        for ($i = 0; $i < $qty; $i++) {
            $ok = $wpdb->insert($entitlements, [
                'user_id'           => $user_id,
                'order_id'          => $order_id,
                'product_id'        => $product_id,
                'plan_type'         => $plan_type,
                'lessons_total'     => $lessons_total,
                'lessons_remaining' => $lessons_total,
                'session_minutes'   => $session_minutes,
                'valid_from'        => $valid_from,
                'valid_until'       => $valid_until,
                'status'            => 'active',
                'created_at'        => $now_mysql,
                'updated_at'        => $now_mysql,
                'course_id' => $course_id ?: null,

            ]);

            if (!$ok || !empty($wpdb->last_error)) {
                error_log('E360 entitlement insert error: ' . $wpdb->last_error);
            } else {
                $created++; // ✅ увеличиваем только при успехе
                error_log("E360 entitlement created: order={$order_id}, product={$product_id}, user={$user_id}");
            }
        }
    }

    // ✅ Флаг ставим только если реально что-то создали
    if ($created > 0) {
        $order->update_meta_data('_e360_entitlements_created', 1);
        $order->save();
    }
}



add_action('wp_loaded', function () {
    if (!function_exists('WC') || !WC()->session) return;

    if (!empty($_GET['e360_course_id'])) {
        $cid = (int) $_GET['e360_course_id'];
        if ($cid > 0) {
            WC()->session->set('e360_course_id', $cid);
        }
    }
});
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id, $variation_id) {
    if (!function_exists('WC') || !WC()->session) return $cart_item_data;

    $cid = 0;
    if (!empty($_GET['e360_course_id'])) $cid = (int) $_GET['e360_course_id'];
    if ($cid <= 0) $cid = (int) WC()->session->get('e360_course_id');

    if ($cid > 0) {
        $cart_item_data['e360_course_id'] = $cid;
    }
    return $cart_item_data;
}, 10, 3);
add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    $cid = 0;

    if (!empty($_POST['e360_course_id'])) {
        $cid = (int) $_POST['e360_course_id'];
    } elseif (!empty($values['e360_course_id'])) {
        $cid = (int) $values['e360_course_id'];
    } elseif (function_exists('WC') && WC()->session) {
        $cid = (int) WC()->session->get('e360_course_id');
    }

    if ($cid > 0) {
        $item->add_meta_data('e360_course_id', $cid, true);
    }
}, 10, 4);




add_action('woocommerce_after_order_notes', function($checkout){
    // только если в корзине есть товары с e360_product_type
    $has_e360 = false;
    foreach (WC()->cart->get_cart() as $ci) {
        $pid = (int) ($ci['variation_id'] ?: $ci['product_id']);
        $ptype = get_post_meta($pid, 'e360_product_type', true);
        if ($ptype && in_array($ptype, ['trial','package','single'], true)) {
            $has_e360 = true;
            break;
        }
    }
    if (!$has_e360) return;

    $default = '';
    if (!empty($_POST['e360_course_id'])) {
        $default = (int) $_POST['e360_course_id'];
    } elseif (WC()->session) {
        $default = (int) WC()->session->get('e360_course_id');
    }

    // вытаскиваем курсы Tutor (post_type может быть courses или tutor_course)
    $courses = get_posts([
        'post_type'   => ['courses', 'tutor_course'],
        'post_status' => 'publish',
        'numberposts' => 200,
        'orderby'     => 'title',
        'order'       => 'ASC',
        'fields'      => 'ids',
    ]);

    $options = ['' => '— Select course —'];
    foreach ($courses as $cid) {
        $options[$cid] = get_the_title($cid);
    }

    echo '<div id="e360-course-select"><h3>Course</h3>';

    woocommerce_form_field('e360_course_id', [
        'type'     => 'select',
        'class'    => ['form-row-wide'],
        'label'    => 'Choose your course',
        'required' => true,
        'options'  => $options,
    ], $default);

    echo '</div>';
});

add_action('woocommerce_checkout_process', function(){
    // проверяем только если в корзине e360 товар
    $has_e360 = false;
    foreach (WC()->cart->get_cart() as $ci) {
        $pid = (int) ($ci['variation_id'] ?: $ci['product_id']);
        $ptype = get_post_meta($pid, 'e360_product_type', true);
        if ($ptype && in_array($ptype, ['trial','package','single'], true)) {
            $has_e360 = true;
            break;
        }
    }
    if (!$has_e360) return;

    if (empty($_POST['e360_course_id']) || (int)$_POST['e360_course_id'] <= 0) {
        wc_add_notice('Please select a course.', 'error');
    }
});