<?php
/**
 * Credits per student per course
 * Stored in user_meta:
 *  - e360_credits_total_{course_id}
 *  - e360_credits_used_{course_id}
 */

function e360_credits_key_total(int $course_id): string { return 'e360_credits_total_' . $course_id; }
function e360_credits_key_used(int $course_id): string  { return 'e360_credits_used_' . $course_id; }

function e360_get_credits_total(int $student_id, int $course_id): int {
    return max(0, (int) get_user_meta($student_id, e360_credits_key_total($course_id), true));
}

function e360_get_credits_used(int $student_id, int $course_id): int {
    return max(0, (int) get_user_meta($student_id, e360_credits_key_used($course_id), true));
}

function e360_get_credits_balance(int $student_id, int $course_id): int {
    return max(0, e360_get_credits_total($student_id, $course_id) - e360_get_credits_used($student_id, $course_id));
}

function e360_get_product_credits_qty(int $product_id): int {
    if ($product_id <= 0) return 0;

    $keys = [
        'e360_credits',
        'e360_credits_qty',
        'credits_lessons_granted',
        'credits_lessons',
        'lessons_granted',
    ];

    foreach ($keys as $k) {
        $v = (int) get_post_meta($product_id, $k, true);
        if ($v > 0) return $v;
    }

    if (function_exists('get_field')) {
        $acf_keys = [
            'e360_credits',
            'credits_lessons_granted',
            'credits_lessons',
            'e360_credits_qty',
        ];
        foreach ($acf_keys as $k) {
            $v = (int) get_field($k, $product_id);
            if ($v > 0) return $v;
        }
    }

    return 0;
}

/**
 * Add credits (admin / order). Does NOT touch used.
 */
function e360_add_credits(int $student_id, int $course_id, int $qty, string $reason = ''): bool {
    if ($qty <= 0) return false;

    $total_key = e360_credits_key_total($course_id);

    // atomic-ish: update based on current
    $current = e360_get_credits_total($student_id, $course_id);
    update_user_meta($student_id, $total_key, $current + $qty);

    // optional ledger
    $ledger_key = 'e360_credits_ledger_' . $course_id;
    $ledger = get_user_meta($student_id, $ledger_key, true);
    if (!is_array($ledger)) $ledger = [];
    $ledger[] = [
        'ts'     => current_time('mysql'),
        'type'   => 'add',
        'qty'    => $qty,
        'reason' => $reason,
        'by'     => get_current_user_id(),
    ];
    update_user_meta($student_id, $ledger_key, $ledger);

    return true;
}

/**
 * Spend credits. Returns false if not enough.
 * $unique_lock = e.g. "lesson:123" to prevent double spending.
 */
function e360_spend_credits(int $student_id, int $course_id, int $qty, string $unique_lock = ''): bool {
    if ($qty <= 0) return false;

    // prevent double spend for same lesson/student
    if ($unique_lock !== '') {
        $lock_key = 'e360_credit_lock_' . md5($course_id . '|' . $unique_lock);
        if (!add_user_meta($student_id, $lock_key, current_time('mysql'), true)) {
            // already spent earlier
            return true;
        }
    }

    $balance = e360_get_credits_balance($student_id, $course_id);
    if ($balance < $qty) {
        // rollback lock
        if ($unique_lock !== '') {
            $lock_key = 'e360_credit_lock_' . md5($course_id . '|' . $unique_lock);
            delete_user_meta($student_id, $lock_key);
        }
        return false;
    }

    $used_key = e360_credits_key_used($course_id);
    $used = e360_get_credits_used($student_id, $course_id);
    update_user_meta($student_id, $used_key, $used + $qty);

    // ledger
    $ledger_key = 'e360_credits_ledger_' . $course_id;
    $ledger = get_user_meta($student_id, $ledger_key, true);
    if (!is_array($ledger)) $ledger = [];
    $ledger[] = [
        'ts'     => current_time('mysql'),
        'type'   => 'spend',
        'qty'    => $qty,
        'reason' => $unique_lock ?: 'manual',
        'by'     => get_current_user_id(),
    ];
    update_user_meta($student_id, $ledger_key, $ledger);

    return true;
}


add_action('woocommerce_order_status_completed', 'e360_apply_order_credits', 20);
add_action('woocommerce_order_status_processing', 'e360_apply_order_credits', 20);

function e360_apply_order_credits($order_id) {
    if (!function_exists('wc_get_order')) return;

    $order = wc_get_order($order_id);
    if (!$order) return;

    $user_id = (int) $order->get_user_id();
    if (!$user_id) return;

    $order_ctx = $order->get_meta('_e360_booking_context');
    if (!is_array($order_ctx)) $order_ctx = [];
    $ctx_course_id = (int)($order_ctx['course_id'] ?? 0);

    // aggregate credits per course from line items
    $per_course = [];

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;

        $product_id = (int) $product->get_id();
        $qty = (int) $item->get_quantity();
        if ($qty <= 0) $qty = 1;
        $credits_per = e360_get_product_credits_qty($product_id);

        if ($credits_per <= 0) continue;

        $course_id = (int) $item->get_meta('e360_course_id', true);
        if ($course_id <= 0) $course_id = $ctx_course_id;
        if ($course_id <= 0) $course_id = (int) get_user_meta($user_id, 'e360_primary_course_id', true);
        if ($course_id <= 0) continue;

        if (!isset($per_course[$course_id])) $per_course[$course_id] = 0;
        $per_course[$course_id] += ($credits_per * $qty);
    }

    foreach ($per_course as $course_id => $total_added) {
        $course_id = (int) $course_id;
        $total_added = (int) $total_added;
        if ($course_id <= 0 || $total_added <= 0) continue;

        // idempotency per order/course
        $flag = 'e360_credits_applied_' . $order_id . '_' . $course_id;
        if (get_user_meta($user_id, $flag, true)) continue;

        e360_add_credits($user_id, $course_id, $total_added, 'Woo order #' . $order_id);
        update_user_meta($user_id, $flag, 1);
    }
}

function e360_reconcile_paid_orders_credits_for_user(int $user_id, int $limit = 200): void {
    if ($user_id <= 0 || !function_exists('wc_get_orders')) return;

    $orders = wc_get_orders([
        'customer_id' => $user_id,
        'status' => ['processing', 'completed'],
        'limit' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'ids',
    ]);
    if (!$orders) return;

    foreach ($orders as $oid) {
        e360_apply_order_credits((int)$oid);
    }
}

add_action('tutor/course/enrol_status_change', function($enrol_id, $new_status){
    $status = strtolower((string)$new_status);
    if (!in_array($status, ['approved', 'completed', 'publish'], true)) return;

    $enrol = get_post((int)$enrol_id);
    if (!$enrol || $enrol->post_type !== 'tutor_enrolled') return;

    $student_id = (int)$enrol->post_author;
    if ($student_id <= 0) return;

    e360_reconcile_paid_orders_credits_for_user($student_id);
}, 30, 2);