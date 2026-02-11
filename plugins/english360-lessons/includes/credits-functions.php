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

    // курс берём из привязки студента (ты уже сохраняешь)
    $course_id = (int) get_user_meta($user_id, 'e360_primary_course_id', true);
    if (!$course_id) return;

    // защита от повторного начисления по одному заказу/курсу
    $flag = 'e360_credits_applied_' . $order_id . '_' . $course_id;
    if (get_user_meta($user_id, $flag, true)) return;

    $total_added = 0;

    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;

        $qty = (int) $item->get_quantity();
        $credits_per = (int) get_post_meta($product->get_id(), 'e360_credits_qty', true);

        if ($credits_per <= 0) continue;

        $add = $credits_per * max(1, $qty);
        $total_added += $add;
    }

    if ($total_added > 0) {
        e360_add_credits($user_id, $course_id, $total_added, 'Woo order #' . $order_id);
        update_user_meta($user_id, $flag, 1);
    }
}