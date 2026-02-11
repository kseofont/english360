<?php
defined('ABSPATH') || exit;

add_action('woocommerce_after_order_itemmeta', function ($item_id, $item, $product) {
    if (!is_admin()) return;
    if (!($item instanceof WC_Order_Item_Product)) return;

    $course_id = (int) $item->get_meta('e360_course_id', true);
    if ($course_id <= 0) return;

    $title = get_the_title($course_id);
    if (!$title) $title = 'Course #' . $course_id;

    $edit_url = admin_url('post.php?post=' . $course_id . '&action=edit');

    echo '<div class="e360-order-item-course" style="margin-top:6px;">';
    echo '<strong>Course:</strong> ' . esc_html($title) . ' (ID ' . esc_html($course_id) . ') ';
    echo '<a href="' . esc_url($edit_url) . '" target="_blank" rel="noopener">Edit</a>';
    echo '</div>';
}, 10, 3);