<?php
function e360_resolve_booking_format(array $ctx): string {
    $format = sanitize_key((string) ($ctx['booking_format'] ?? ''));
    if (in_array($format, ['trial', 'package', 'single'], true)) return $format;

    $plan_product_id = (int) ($ctx['plan_product_id'] ?? 0);
    if ($plan_product_id > 0) {
        $ptype = sanitize_key((string) get_post_meta($plan_product_id, 'e360_product_type', true));
        if (in_array($ptype, ['trial', 'package', 'single'], true)) {
            return $ptype === 'single' ? 'single' : ($ptype === 'trial' ? 'trial' : 'package');
        }
    }

    return '';
}

function e360_booking_format_label(string $format): string {
    if ($format === 'trial') return 'Trial lesson';
    if ($format === 'single') return 'Single lesson';
    if ($format === 'package') return 'Package';
    return '';
}

function e360_product_credits_for_display(int $product_id): int {
    if ($product_id <= 0) return 0;

    if (function_exists('e360_get_product_credits_qty')) {
        $v = (int) e360_get_product_credits_qty($product_id);
        if ($v > 0) return $v;
    }

    $v = (int) get_post_meta($product_id, 'e360_credits', true);
    if ($v > 0) return $v;

    if (function_exists('get_field')) {
        $v = (int) get_field('e360_credits', $product_id);
        if ($v > 0) return $v;
    }

    return 0;
}

function e360_ctx_slot_labels(array $ctx): array {
    $repeat = (($ctx['repeat'] ?? '') === 'once') ? 'once' : 'weekly';
    $duration = (int)($ctx['duration'] ?? 60);
    if ($duration <= 0) $duration = 60;

    $slots = e360_sanitize_ctx_slots(($ctx['slots'] ?? []), $repeat, $duration);
    if (!$slots && !empty($ctx['date']) && !empty($ctx['time'])) {
        $slots = [[
            'date' => sanitize_text_field((string)$ctx['date']),
            'time' => substr(sanitize_text_field((string)$ctx['time']), 0, 5),
            'repeat' => $repeat,
            'duration' => $duration,
        ]];
    }

    $labels = [];
    foreach ((array)$slots as $slot) {
        $date = sanitize_text_field((string)($slot['date'] ?? ''));
        $time = substr(sanitize_text_field((string)($slot['time'] ?? '')), 0, 5);
        if ($date === '' || $time === '') continue;
        $labels[] = $date . ' ' . $time;
    }

    return array_values(array_unique($labels));
}

function e360_ctx_slot_html(array $ctx): string {
    $labels = e360_ctx_slot_labels($ctx);
    if (!$labels) return '';
    return implode('<br>', array_map('esc_html', $labels));
}

// Save booking context from hidden input to order item meta
add_action('woocommerce_checkout_create_order_line_item', function($item, $cart_item_key, $values, $order) {
if (!empty($_POST['e360_booking_ctx_checkout'])) {
$ctx = json_decode(wp_unslash($_POST['e360_booking_ctx_checkout']), true);
if (is_array($ctx)) {
$course_id = $ctx['course_id'] ?? '';
$course_title = !empty($course_id) ? get_the_title((int)$course_id) : '';
$teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
$plan_title = !empty($ctx['plan_product_id']) && function_exists('wc_get_product') ?
(wc_get_product($ctx['plan_product_id'])->get_name() ?? '') : '';
$plan_credits = !empty($ctx['plan_product_id']) ? e360_product_credits_for_display((int)$ctx['plan_product_id']) : 0;
$format_label = e360_booking_format_label(e360_resolve_booking_format($ctx));
$slot_labels = e360_ctx_slot_labels($ctx);
$item->add_meta_data('e360_course_id', $course_id, true);
$item->add_meta_data('Course', $course_title . ($course_id ? ' (ID ' . $course_id . ')' : ''));
$item->add_meta_data('Teacher', $teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? '')));
if ($slot_labels) {
    $item->add_meta_data('Date/time', $slot_labels[0]);
    if (count($slot_labels) > 1) {
        $item->add_meta_data('Schedule', implode(' | ', $slot_labels));
    }
} else {
    $item->add_meta_data('Date/time', ($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5));
}
if ($plan_title) $item->add_meta_data('Package', $plan_title);
if ($plan_credits > 0) $item->add_meta_data('Credits (lessons)', $plan_credits);
$item->add_meta_data('Format', $format_label ?: 'Not set');
$item->add_meta_data('Type', ($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly');
}
}
}, 10, 4);


// Show booking summary above order review on checkout
add_action('woocommerce_checkout_before_order_review', function() {
if (!function_exists('WC') || !WC()->cart) return;
$ctx = null;
foreach (WC()->cart->get_cart() as $cart_item) {
if (!empty($cart_item['e360_booking_context'])) {
$ctx = $cart_item['e360_booking_context'];
break;
}
}
if (!is_array($ctx) || empty($ctx)) return;
$course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
$teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
$plan_title = !empty($ctx['plan_product_id']) && function_exists('wc_get_product') ?
(wc_get_product($ctx['plan_product_id'])->get_name() ?? '') : '';
$plan_credits = !empty($ctx['plan_product_id']) ? e360_product_credits_for_display((int)$ctx['plan_product_id']) : 0;
$format_label = e360_booking_format_label(e360_resolve_booking_format($ctx));
$slot_labels = e360_ctx_slot_labels($ctx);
$slots_html = e360_ctx_slot_html($ctx);
echo '<div id="e360-checkout-summary" style="padding:12px;border:1px solid #ddd;border-radius:10px;margin:12px 0;">';
    echo '<div style="font-weight:600;margin-bottom:6px;">Your lesson request</div>';
    echo '<div><strong>Course:</strong> ' . esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))) . '</div>';
    echo '<div><strong>Teacher:</strong> ' . esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ??
        ''))) . '</div>';
    if (count($slot_labels) > 1) {
        echo '<div><strong>Schedule:</strong><br>' . wp_kses_post($slots_html) . '</div>';
    } else {
        echo '<div><strong>Date/time:</strong> ' . esc_html($slot_labels ? $slot_labels[0] : (($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5))) . '</div>';
    }
    if ($plan_title) echo '<div><strong>Package:</strong> ' . esc_html($plan_title) . '</div>';
    if ($plan_credits > 0) echo '<div><strong>Credits (lessons):</strong> ' . esc_html((string)$plan_credits) . '</div>';
    if ($format_label) echo '<div><strong>Format:</strong> ' . esc_html($format_label) . '</div>';
    echo '<div><strong>Type:</strong> ' . esc_html(($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly') . '</div>
    ';
    // Add hidden input with booking context JSON
    echo '<input type="hidden" name="e360_booking_ctx_checkout" value="' . esc_attr(json_encode($ctx)) . '" />';
    echo '</div>';

// JS to auto-select course in course dropdown if present
if (!empty($ctx['course_id'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sel = document.getElementById('e360_course_id');
    if (sel) {
        sel.value = '<?php echo esc_js($ctx['course_id']); ?>';
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            jQuery(sel).trigger('change.select2');
        }
    }
});
</script>
<?php
    }
});

// Show booking summary on Thank You / Order details page
add_action('woocommerce_order_details_after_order_table', function($order) {
if (!is_a($order, 'WC_Order')) return;

$ctx = $order->get_meta('_e360_booking_context');
if (!is_array($ctx) || empty($ctx)) return;

$course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
$teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
$plan_title = !empty($ctx['plan_product_id']) && function_exists('wc_get_product') ?
(wc_get_product((int)$ctx['plan_product_id'])->get_name() ?? '') : '';
$plan_credits = !empty($ctx['plan_product_id']) ? e360_product_credits_for_display((int)$ctx['plan_product_id']) : 0;
$format_label = e360_booking_format_label(e360_resolve_booking_format($ctx));
$slot_labels = e360_ctx_slot_labels($ctx);
$slots_html = e360_ctx_slot_html($ctx);

echo '<section id="e360-order-summary" style="margin-top:14px;padding:12px;border:1px solid #ddd;border-radius:10px;">';
echo '<h2 style="margin:0 0 8px;font-size:18px;">Lesson request</h2>';
echo '<p><strong>Course:</strong> ' . esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))) . '</p>';
echo '<p><strong>Teacher:</strong> ' . esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? ''))) . '</p>';
if (count($slot_labels) > 1) {
    echo '<p><strong>Schedule:</strong><br>' . wp_kses_post($slots_html) . '</p>';
} else {
    echo '<p><strong>Date/time:</strong> ' . esc_html($slot_labels ? $slot_labels[0] : (($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5))) . '</p>';
}
if ($plan_title) echo '<p><strong>Package:</strong> ' . esc_html($plan_title) . '</p>';
if ($plan_credits > 0) echo '<p><strong>Credits (lessons):</strong> ' . esc_html((string)$plan_credits) . '</p>';
if ($format_label) echo '<p><strong>Format:</strong> ' . esc_html($format_label) . '</p>';
echo '<p><strong>Type:</strong> ' . esc_html(($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly') . '</p>';
echo '</section>';
}, 20);

// Restore booking context for cart item on checkout page load
add_action('woocommerce_before_checkout_form', function() {
    if (!is_user_logged_in()) return;
    $user_id = get_current_user_id();
    $ctx = get_user_meta($user_id, 'e360_booking_context', true);
    if (!is_array($ctx) || empty($ctx)) return;
    $cart = WC()->cart;
    if (!$cart) return;
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (empty($cart_item['e360_booking_context'])) {
            WC()->cart->cart_contents[$cart_item_key]['e360_booking_context'] = $ctx;
        }
    }
});

// Add booking context to cart item meta
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id) {
// Try to get booking context from POST
$ctx = null;
if (!empty($_POST['e360_booking_ctx'])) {
$raw = wp_unslash($_POST['e360_booking_ctx']);
$ctx = json_decode($raw, true);
}
if (!is_array($ctx) || !$ctx) {
$course_id = isset($_POST['e360_course_id']) ? (int) $_POST['e360_course_id'] : (isset($_POST['course_id']) ? (int)
$_POST['course_id'] : 0);
$teacher_id = isset($_POST['e360_teacher_id']) ? (int) $_POST['e360_teacher_id'] : (isset($_POST['teacher_id']) ? (int)
$_POST['teacher_id'] : 0);
$date = isset($_POST['e360_booking_date']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_date'])) :
(isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '');
$time = isset($_POST['e360_booking_time']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_time'])) :
(isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '');
$language_term_id = isset($_POST['e360_term_id']) ? (int) $_POST['e360_term_id'] : (isset($_POST['language_term_id']) ?
(int) $_POST['language_term_id'] : 0);
$level_term_id = isset($_POST['level_term_id']) ? (int) $_POST['level_term_id'] : (isset($_POST['e360_level_id']) ?
(int) $_POST['e360_level_id'] : 0);
$plan_product_id = isset($_POST['plan_product_id']) ? (int) $_POST['plan_product_id'] : (isset($_POST['plan']) ? (int)
$_POST['plan'] : 0);
$duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
$repeat = isset($_POST['repeat']) ? sanitize_text_field($_POST['repeat']) : 'weekly';
$booking_format = isset($_POST['booking_format']) ? sanitize_key(wp_unslash($_POST['booking_format'])) : '';
if ($course_id && $teacher_id && $date && $time) {
$ctx = [
'language_term_id' => $language_term_id,
'level_term_id' => $level_term_id,
'course_id' => $course_id,
'teacher_id' => $teacher_id,
'date' => $date,
'time' => $time,
'plan_product_id' => $plan_product_id,
'duration' => $duration,
'repeat' => $repeat,
'booking_format' => $booking_format,
];
}
}
if (is_array($ctx) && $ctx) {
$ctx['booking_format'] = e360_resolve_booking_format($ctx);
$cart_item_data['e360_booking_context'] = $ctx;
}
return $cart_item_data;
}, 10, 3);

// Display booking context in cart and checkout
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
if (isset($cart_item['e360_booking_context']) && is_array($cart_item['e360_booking_context'])) {
$ctx = $cart_item['e360_booking_context'];
$course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
$teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
$item_data[] = [
'name' => 'Course',
'value' => esc_html($course_title ?: ('#'.($ctx['course_id'] ?? '')))
];
$item_data[] = [
'name' => 'Teacher',
'value' => esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? '')))
];
$slot_labels = e360_ctx_slot_labels($ctx);
if (count($slot_labels) > 1) {
    $item_data[] = [
        'name' => 'Schedule',
        'value' => esc_html(implode(' | ', $slot_labels))
    ];
} else {
    $item_data[] = [
        'name' => 'Date/time',
        'value' => esc_html($slot_labels ? $slot_labels[0] : (($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5)))
    ];
}
if (!empty($ctx['plan_product_id'])) {
$plan_title = function_exists('wc_get_product') ? (wc_get_product($ctx['plan_product_id'])->get_name() ?? '') : '';
$item_data[] = [
'name' => 'Package',
'value' => esc_html($plan_title)
];
}
$format_label = e360_booking_format_label(e360_resolve_booking_format($ctx));
if ($format_label) {
$item_data[] = [
'name' => 'Format',
'value' => esc_html($format_label)
];
}
$item_data[] = [
'name' => 'Type',
'value' => esc_html(($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly')
];
}
return $item_data;
}, 10, 2);

add_action('wp_ajax_e360_get_courses_by_term', 'e360_get_courses_by_term');
add_action('wp_ajax_nopriv_e360_get_courses_by_term', 'e360_get_courses_by_term');

function e360_teacher_public_name($user): string {
    if (!$user) return '';

    $first = trim((string) get_user_meta($user->ID, 'first_name', true));
    $last  = trim((string) get_user_meta($user->ID, 'last_name', true));

    if ($first === '' && $last === '') {
        $parts = preg_split('/\s+/', trim((string) $user->display_name));
        $first = $parts[0] ?? '';
        $last  = $parts[1] ?? '';
    }

    if ($first === '') $first = (string) $user->display_name;

    $initial = '';
    if ($last !== '') {
        $initial = mb_substr($last, 0, 1) . '.';
    }

    return trim($first . ' ' . $initial);
}


function e360_get_course_instructor_ids(int $course_id): array {
    $ids = [];

    $author_id = (int) get_post_field('post_author', $course_id);
    if ($author_id) $ids[] = $author_id;

    // Tutor LMS (включая co-instructors)
    if (function_exists('tutor_utils') && is_object(tutor_utils()) && method_exists(tutor_utils(), 'get_instructors_by_course')) {
        $list = tutor_utils()->get_instructors_by_course($course_id);
        foreach ((array)$list as $it) {
            if (is_numeric($it)) {
                $ids[] = (int)$it;
            } elseif (is_object($it) && isset($it->ID)) {
                $ids[] = (int)$it->ID;
            } elseif (is_array($it) && isset($it['ID'])) {
                $ids[] = (int)$it['ID'];
            }
        }
    }

    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    return $ids;
}

/**
 * Полный HTML bio из Tutor профиля.
 * Разрешаем базовый HTML + iframe ТОЛЬКО с youtube доменов.
 */
function e360_teacher_bio_html(int $user_id): string {
    $bio = (string) get_user_meta($user_id, '_tutor_profile_bio', true); // Tutor LMS bio meta :contentReference[oaicite:1]{index=1}
    if ($bio === '') {
        $u = get_user_by('id', $user_id);
        $bio = $u ? (string)$u->description : '';
    }
    $bio = trim($bio);
    if ($bio === '') return '';

    // Вырезаем iframe, если src НЕ youtube
    $bio = preg_replace_callback('~<iframe\b[^>]*\bsrc=(["\'])(.*?)\1[^>]*>(.*?)</iframe>~is', function($m){
        $src  = $m[2] ?? '';
        $host = strtolower((string) parse_url($src, PHP_URL_HOST));
        $host = preg_replace('~^www\.~', '', $host);

        $ok_hosts = ['youtube.com', 'youtube-nocookie.com', 'youtu.be'];
        if (!in_array($host, $ok_hosts, true)) {
            return '';
        }
        return $m[0];
    }, $bio);

    $allowed = [
        'p' => [], 'br' => [],
        'strong' => [], 'b' => [],
        'em' => [], 'i' => [],
        'ul' => [], 'ol' => [], 'li' => [],
        'a' => ['href'=>true,'title'=>true,'target'=>true,'rel'=>true],
        'iframe' => [
            'src'=>true,'width'=>true,'height'=>true,'frameborder'=>true,
            'allow'=>true,'allowfullscreen'=>true,'referrerpolicy'=>true,'title'=>true
        ],
        'div' => [], 'span' => [],
    ];

    return wp_kses($bio, $allowed);
}

/**
 * Короткий текстовый сниппет (для компактного превью в карточке)
 */
function e360_teacher_bio_snippet(int $user_id, int $limit = 140): string {
    $html = e360_teacher_bio_html($user_id);
    $bio  = trim(wp_strip_all_tags($html));

    if ($bio === '') return '';
    if (mb_strlen($bio) > $limit) $bio = mb_substr($bio, 0, $limit - 1) . '…';
    return $bio;
}


function e360_course_base_title(string $title): string {
    $t = trim($title);

    // отрежем " — Teacher", " - Teacher", " – Teacher"
    $t = preg_split('/\s[—–-]\s/u', $t)[0] ?? $t;

    return trim($t);
}

function e360_get_courses_by_term() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $term_id = isset($_POST['term_id']) ? (int) $_POST['term_id'] : 0;
    if ($term_id <= 0) {
        wp_send_json_error(['message' => 'term_id required']);
    }

    $taxonomy = isset($_POST['taxonomy']) ? sanitize_key($_POST['taxonomy']) : 'course-category';

    $q = new WP_Query([
        'post_type'      => 'courses',
        'post_status'    => 'publish',
        'posts_per_page' => 500,
        'tax_query'      => [[
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => [$term_id],
        ]],
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    // Группируем по base_title => список вариантов (учителей)
    $groups = [];

    foreach ($q->posts as $p) {
        $course_post_id = (int) $p->ID;
        $base_title = e360_course_base_title(get_the_title($course_post_id));
        $key = sanitize_title($base_title);

        if (!isset($groups[$key])) {
            $groups[$key] = [
                'course_key'   => $key,
                'course_title' => $base_title,
                'variants'     => [],
                '_seen'        => [],
            ];
        }

        $author_id = (int) $p->post_author;
        $instructor_ids = e360_get_course_instructor_ids($course_post_id);

        foreach ($instructor_ids as $tid) {
            $variant_key = $course_post_id . ':' . $tid;
            if (isset($groups[$key]['_seen'][$variant_key])) continue;
            $groups[$key]['_seen'][$variant_key] = 1;

            $u = get_user_by('id', $tid);
            if (!$u) continue;

            $bio_html = e360_teacher_bio_html($tid);
            $bio_snip = e360_teacher_bio_snippet($tid, 140);

            $groups[$key]['variants'][] = [
                'course_id'        => $course_post_id,          // один и тот же course post
                'course_title'     => get_the_title($course_post_id),
                'teacher_id'       => $tid,                     // может быть author или attached instructor
                'teacher_name'     => e360_teacher_public_name($u),
                'teacher_avatar'   => get_avatar_url($tid, ['size' => 96]),
                'teacher_bio'      => $bio_snip,                // текстовое превью
                'teacher_bio_html' => $bio_html,                // полный HTML (safe)
                'teacher_role'     => ($tid === $author_id) ? 'Author' : 'Instructor',
            ];
        }
    }

    // перед отдачей JSON убираем служебное поле
    foreach ($groups as &$g) {
        unset($g['_seen']);
    }


    // В массив для JSON
    $items = array_values($groups);

    wp_send_json_success(['items' => $items]);
}

add_action('wp_ajax_e360_get_schedule_preview_bulk', 'e360_get_schedule_preview_bulk');
add_action('wp_ajax_nopriv_e360_get_schedule_preview_bulk', 'e360_get_schedule_preview_bulk');

function e360_slot_hhmm($s): string {
    if (is_string($s)) {
        if (preg_match('/^\d{2}:\d{2}/', $s, $m)) return substr($s, 0, 5);
        // если вдруг вернёт ISO
        if (($ts = strtotime($s)) !== false) return date('H:i', $ts);
        return $s;
    }
    return '';
}

function e360_get_schedule_preview_bulk() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
    $include_past_today = !empty($_POST['include_past_today']);

    $raw = isset($_POST['teacher_ids']) ? wp_unslash($_POST['teacher_ids']) : '[]';
    $teacher_ids = json_decode($raw, true);
    if (!is_array($teacher_ids)) $teacher_ids = [];

    $teacher_ids = array_values(array_unique(array_filter(array_map('intval', $teacher_ids))));
    if (!$teacher_ids) wp_send_json_success(['items' => []]);

    $days = 7;
    $start = current_time('timestamp'); // WP timezone
    $items = [];

    // viewer (student) timezone: prefer current user or explicit student_id POST
    $viewer_id = get_current_user_id();
    if (!$viewer_id && isset($_POST['student_id'])) {
        $viewer_id = (int) $_POST['student_id'];
    }

    // helper: resolve timezone for a user (try personal setting, then fallback to site tz)
    $resolve_user_tz = function($uid) {
        if (!$uid) return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        $tz = get_user_option('timezone_string', $uid);
        if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
        return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
    };

    $student_tz = $resolve_user_tz($viewer_id);

    foreach ($teacher_ids as $tid) {
        $out_days = [];

        $teacher_tz = e360_get_teacher_timezone_string((int)$tid);
        // compute start date in teacher's timezone so slots align with teacher local days
        try {
            $teacher_now = new DateTimeImmutable('now', new DateTimeZone($teacher_tz));
        } catch (Exception $e) {
            $teacher_now = new DateTimeImmutable('now', new DateTimeZone((function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC')));
        }

        for ($i = 0; $i < $days; $i++) {
            $date = $teacher_now->modify("+$i day")->format('Y-m-d');

            $slots = function_exists('e360_generate_slots_for_teacher_date')
                ? e360_generate_slots_for_teacher_date((int)$tid, $date, $duration, $include_past_today)
                : [];

            $count = is_array($slots) ? count($slots) : 0;
            $times = [];
            foreach ((array)$slots as $s) {
                $t = e360_slot_hhmm($s);
                if ($t === '') continue;

                // convert teacher local slot (date + time) into student's timezone for display
                try {
                    $dtTeacher = new DateTimeImmutable($date . ' ' . $t, new DateTimeZone($teacher_tz));
                    $dtStudent = $dtTeacher->setTimezone(new DateTimeZone($student_tz));
                    $times[] = $dtStudent->format('H:i');
                } catch (Exception $e) {
                    // fallback to raw hh:mm
                    $times[] = $t;
                }
            }

            $out_days[] = [
                'date'  => $date,
                'count' => $count,
                'times' => $times,
            ];
        }

        $items[$tid] = ['days' => $out_days];
    }

    wp_send_json_success(['items' => $items]);
}


add_action('wp_ajax_e360_get_slots', 'e360_get_slots');
add_action('wp_ajax_nopriv_e360_get_slots', 'e360_get_slots');

function e360_get_slots() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $teacher_id = isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0;
    $date       = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $duration   = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
    $include_past_today = !empty($_POST['include_past_today']);

    if (!$teacher_id || !$date) {
        wp_send_json_error(['message' => 'teacher_id and date required']);
    }

    $slots = function_exists('e360_generate_slots_for_teacher_date')
        ? e360_generate_slots_for_teacher_date($teacher_id, $date, $duration, $include_past_today)
        : [];

    // Determine student timezone (viewer)
    $viewer_id = get_current_user_id();
    $resolve_user_tz = function($uid) {
        if (!$uid) return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        $tz = get_user_option('timezone_string', $uid);
        if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
        return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
    };
    $student_tz = $resolve_user_tz($viewer_id);

    // Get teacher timezone
    if (!function_exists('e360_get_teacher_timezone_string')) {
        function e360_get_teacher_timezone_string($uid) {
            $tz = get_user_option('timezone_string', $uid);
            if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
            return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        }
    }
    $teacher_tz = e360_get_teacher_timezone_string($teacher_id);

    $times = [];
    foreach ((array)$slots as $s) {
        $t = e360_slot_hhmm($s);
        if ($t === '') continue;
        try {
            $dtTeacher = new DateTimeImmutable($date . ' ' . $t, new DateTimeZone($teacher_tz));
            $dtStudent = $dtTeacher->setTimezone(new DateTimeZone($student_tz));
            $times[] = $dtStudent->format('H:i');
        } catch (Exception $e) {
            $times[] = $t;
        }
    }

    wp_send_json_success(['slots' => $times]);
}

function e360_sanitize_ctx_slots($raw_slots, string $default_repeat = 'weekly', int $default_duration = 60): array {
    $out = [];
    if (!is_array($raw_slots)) return $out;
    $default_repeat = ($default_repeat === 'once') ? 'once' : 'weekly';
    if ($default_duration <= 0) $default_duration = 60;
    foreach ($raw_slots as $row) {
        if (!is_array($row)) continue;
        $date = sanitize_text_field((string)($row['date'] ?? ''));
        $time = sanitize_text_field((string)($row['time'] ?? ''));
        $repeat = (($row['repeat'] ?? $default_repeat) === 'once') ? 'once' : 'weekly';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) continue;
        if (!preg_match('/^\d{2}:\d{2}/', $time)) continue;
        $out[] = [
            'date' => $date,
            'time' => substr($time, 0, 5),
            'repeat' => $repeat,
            'duration' => $default_duration,
        ];
    }
    $unique = [];
    $clean = [];
    foreach ($out as $r) {
        $k = $r['date'] . '|' . $r['time'] . '|' . $r['repeat'];
        if (isset($unique[$k])) continue;
        $unique[$k] = 1;
        $clean[] = $r;
    }
    return $clean;
}

add_action('wp_ajax_e360_prepare_checkout', function() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Please log in first.'], 401);
    }
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $uid = get_current_user_id();
    $ctx_raw = isset($_POST['ctx']) ? wp_unslash($_POST['ctx']) : '';
    $ctx = json_decode((string)$ctx_raw, true);
    if (!is_array($ctx) || empty($ctx)) {
        wp_send_json_error(['message' => 'Invalid booking context.'], 400);
    }

    $clean = [
        'language_term_id' => (int)($ctx['language_term_id'] ?? 0),
        'level_term_id'    => (int)($ctx['level_term_id'] ?? 0),
        'course_id'        => (int)($ctx['course_id'] ?? 0),
        'teacher_id'       => (int)($ctx['teacher_id'] ?? 0),
        'date'             => sanitize_text_field((string)($ctx['date'] ?? '')),
        'time'             => sanitize_text_field((string)($ctx['time'] ?? '')),
        'plan_product_id'  => (int)($ctx['plan_product_id'] ?? 0),
        'duration'         => (int)($ctx['duration'] ?? 60),
        'repeat'           => (($ctx['repeat'] ?? '') === 'once') ? 'once' : 'weekly',
        'booking_format'   => e360_resolve_booking_format($ctx),
        'created_at'       => current_time('mysql'),
    ];
    $clean['slots'] = e360_sanitize_ctx_slots(($ctx['slots'] ?? []), $clean['repeat'], (int)$clean['duration']);
    if (!$clean['slots'] && $clean['date'] !== '' && $clean['time'] !== '') {
        $clean['slots'] = [[
            'date' => $clean['date'],
            'time' => substr((string)$clean['time'], 0, 5),
            'repeat' => $clean['repeat'],
            'duration' => (int)$clean['duration'],
        ]];
    }
    if ($clean['slots']) {
        $clean['date'] = (string)$clean['slots'][0]['date'];
        $clean['time'] = (string)$clean['slots'][0]['time'];
        $clean['repeat'] = (string)$clean['slots'][0]['repeat'];
    }

    if ($clean['course_id'] <= 0 || $clean['teacher_id'] <= 0 || !$clean['slots'] || $clean['plan_product_id'] <= 0) {
        wp_send_json_error(['message' => 'Missing required fields.'], 400);
    }

    update_user_meta($uid, 'e360_booking_context', $clean);
    update_user_meta($uid, 'e360_primary_teacher_id', $clean['teacher_id']);
    update_user_meta($uid, 'e360_primary_course_id', $clean['course_id']);

    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(['message' => 'WooCommerce cart is unavailable.'], 500);
    }

    WC()->session->set('e360_course_id', (int)$clean['course_id']);
    WC()->cart->empty_cart();
    WC()->cart->add_to_cart((int)$clean['plan_product_id'], 1, 0, [], [
        'e360_course_id' => (int)$clean['course_id'],
        'e360_booking_context' => $clean,
    ]);

    $checkout_url = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
    wp_send_json_success(['checkout_url' => $checkout_url]);
});

add_shortcode('e360_booking_wizard', function($atts){
    $atts = shortcode_atts([
        'taxonomy'        => 'course-category',
        'duration'        => 60,
        'registration_url'=> 'https://lms.english360.ca/student-registration/',
        'only_parent_terms' => 1,
    ], $atts);

    $taxonomy = sanitize_key($atts['taxonomy']);
    $duration = (int) $atts['duration'];
    $registration_url = esc_url_raw($atts['registration_url']);
    $only_parent = (int) $atts['only_parent_terms'];

    $term_args = [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ];
    if ($only_parent) $term_args['parent'] = 0;

    $languages = get_terms($term_args);
    if (is_wp_error($languages)) return '<p>Cannot load languages.</p>';

    wp_enqueue_script('jquery');
    $nonce = wp_create_nonce('e360_booking_nonce');

    ob_start();
    ?>
<div id="e360-wizard" data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
    data-duration="<?php echo esc_attr($duration); ?>"
    data-registration-url="<?php echo esc_attr($registration_url); ?>"
    data-is-logged-in="<?php echo is_user_logged_in() ? '1' : '0'; ?>">
    <p>
        <label>What language would you like to learn?</label><br>
    <div id="e360-language" class="e360-language-cards"
        style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;">
        <?php foreach ($languages as $t): ?>
        <?php
                $term_id = (int) $t->term_id;
                $thumb_id = get_term_meta($term_id, 'thumbnail_id', true);
                $img = '';
                if ($thumb_id) $img = wp_get_attachment_image_url($thumb_id, 'medium');
            ?>
        <div class="e360-language-card" data-term-id="<?php echo $term_id; ?>"
            style="border:1px solid #ddd;border-radius:10px;padding:14px;cursor:pointer;display:flex;align-items:center;gap:12px;min-height:92px;">
            <?php if ($img): ?>
            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($t->name); ?>"
                style="width:64px;height:64px;border-radius:8px;object-fit:cover;">
            <?php else: ?>
            <div
                style="width:64px;height:64px;border-radius:8px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-weight:600;color:#555;font-size:20px;">
                <?php echo esc_html(mb_substr($t->name,0,1)); ?>
            </div>
            <?php endif; ?>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:18px;line-height:1.2;"><?php echo esc_html($t->name); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </p>

    <div id="e360-step-level" style="display:none;">
        <p>
            <label>Level</label><br>
        <div id="e360-level" class="e360-level-cards"
            style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;">
            <div style="opacity:.7">Select language first…</div>
        </div>
        </p>
    </div>

    <div id="e360-step-course" style="display:none;">
        <p>
            <label>Course</label><br>
        <div id="e360-course" class="e360-course-cards"
            style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:10px;">
            <div style="opacity:.7">Select level first…</div>
        </div>
        </p>

        <div id="e360-teacher-list" style="margin:10px 0;"></div>
    </div>

    <div id="e360-step-offer" style="display:none;">
        <p>
            <label>Choose format</label><br>
        <div id="e360-purchase-options"
            style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;">
            <button type="button" class="e360-purchase-card tutor-btn tutor-btn-outline-primary"
                data-plan-kind="trial">Trial lesson</button>
            <button type="button" class="e360-purchase-card tutor-btn tutor-btn-outline-primary"
                data-plan-kind="package">Buy a package</button>
        </div>
        </p>

        <p id="e360-plan-wrap" style="display:none;">
            <label>Choose package</label><br>
            <select id="e360-plan">
                <option value="">Select…</option>
            </select>
        </p>

        <div id="e360-offer-msg" style="margin-top:10px;opacity:.85;"></div>
        <div id="e360-offer-schedule" style="margin-top:12px;font-size:13px;display:none;"></div>
    </div>

    <div id="e360-step-time" style="display:none;">
        <p style="margin:0 0 8px;font-weight:600;">Choose a convenient time</p>
        <p id="e360-date-wrap" style="display:none;">
            <label>Select Date</label><br>
            <input type="date" id="e360-date" min="<?php echo esc_attr(date('Y-m-d')); ?>">
        </p>
        <p id="e360-time-wrap" style="display:none;">
            <label>Available times</label><br>
            <select id="e360-time">
                <option value="">Select date first…</option>
            </select>
        </p>
        <p id="e360-repeat-wrap">
            <label>Lesson type</label><br>
            <select id="e360-repeat">
                <option value="weekly" selected>Weekly</option>
                <option value="once">One-time</option>
            </select>
        </p>



        <p>
            <button type="button" id="e360-continue" class="tutor-btn tutor-btn-primary">Continue</button>
        </p>

        <div id="e360-msg" style="margin-top:10px;"></div>
    </div>
</div>

<script>
jQuery(function($) {
    const nonce = <?php echo json_encode($nonce); ?>;
    const ajaxurl = <?php echo json_encode(admin_url('admin-ajax.php')); ?>;

    const $wiz = $('#e360-wizard');

    let coursesIndex = {}; // course_key => {course_title, variants:[]}
    let plansIndex = []; // products from e360_get_plans


    let selected = {
        taxonomy: $wiz.data('taxonomy'),
        duration: parseInt($wiz.data('duration'), 10) || 60,
        language_term_id: null,
        level_term_id: null,
        course_id: null,
        teacher_id: null,
        teacher_name: null,
        course_title: null,
        date: null,
        time: null,
        plan_product_id: null,
        plan_kind: null,
        course_key: null,
        repeat: 'weekly',
        slots: [],
    };

    function resetAfterLanguage() {
        // visually unselect any language cards
        $('.e360-language-card').css('border-color', '#ddd');
        $('#e360-level').html('<div style="opacity:.7">Select language first…</div>');
        $('#e360-course').html('<div style="opacity:.7">Select level first…</div>');
        $('#e360-teacher-list').empty();
        $('#e360-step-offer').hide();
        $('#e360-offer-msg').text('');
        $('#e360-offer-schedule').hide().html('');
        $('#e360-plan-wrap').hide();
        $('#e360-plan').html('<option value="">Select…</option>');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-level, #e360-step-course, #e360-step-offer, #e360-step-time').hide();
        selected.level_term_id = selected.course_id = selected.teacher_id = null;
        selected.teacher_name = selected.course_title = null;
        selected.date = selected.time = null;
        selected.plan_product_id = null;
        selected.plan_kind = null;
        selected.repeat = 'weekly';
        selected.slots = [];
    }

    function resetAfterLevel() {
        // visually unselect any level cards
        $('.e360-level-card').css('border-color', '#ddd');
        $('#e360-course').html('<div style="opacity:.7">Loading…</div>');
        $('#e360-teacher-list').empty();
        $('#e360-step-offer').hide();
        $('#e360-offer-msg').text('');
        $('#e360-offer-schedule').hide().html('');
        $('#e360-plan-wrap').hide();
        $('#e360-plan').html('<option value="">Select…</option>');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-course').show();
        $('#e360-step-offer').hide();
        $('#e360-step-time').hide();
        selected.course_id = selected.teacher_id = null;
        selected.teacher_name = selected.course_title = null;
        selected.date = selected.time = null;
        selected.plan_product_id = null;
        selected.plan_kind = null;
        selected.repeat = 'weekly';
        selected.slots = [];
    }

    function canShowTimeStep() {
        return !!(selected.teacher_id && selected.plan_product_id);
    }

    function updateTimeStepVisibility() {
        if (canShowTimeStep()) {
            $('#e360-step-time').show();
            return;
        }
        $('#e360-step-time').hide();
    }

    function renderPlansByKind(planKind) {
        const $plan = $('#e360-plan');
        const trialItems = plansIndex.filter(function(it) {
            return (it.plan_kind || '') === 'trial';
        });
        const otherItems = plansIndex.filter(function(it) {
            return (it.plan_kind || '') !== 'trial';
        });

        if (planKind === 'package') {
            $('#e360-plan-wrap').show();
            $plan.html('<option value="">Select…</option>');
            otherItems.forEach(function(it) {
                $plan.append($('<option>', {
                    value: it.product_id,
                    text: it.title + (it.price_text ? ' — ' + it.price_text : '')
                }));
            });
            selected.plan_product_id = null;
            if (!otherItems.length) {
                $('#e360-offer-msg').text('No package products configured.');
            } else {
                $('#e360-offer-msg').text('');
            }
            return;
        }

        // trial: только "1 lesson subscription"
        $('#e360-plan-wrap').show();
        $plan.html('<option value="">Select…</option>');

        const trialOne = trialItems.find(function(it) {
            return /1\s*lesson\s*subscription/i.test((it.title || '').toString());
        }) || trialItems[0] || null;

        if (!trialOne) {
            selected.plan_product_id = null;
            $('#e360-offer-msg').text('Trial lesson product was not found.');
            return;
        }

        $plan.append($('<option>', {
            value: trialOne.product_id,
            text: trialOne.title + (trialOne.price_text ? ' — ' + trialOne.price_text : '')
        }));
        $plan.val(String(trialOne.product_id));
        selected.plan_product_id = parseInt(trialOne.product_id, 10) || null;
        $('#e360-offer-msg').text(trialOne.title ? ('Selected: ' + trialOne.title) : '');
    }

    function loadTeacherSchedulePreview(teacherId) {
        const $box = $('#e360-offer-schedule');
        if (!teacherId) {
            $box.hide().html('');
            return;
        }

        $box.show().html('<em>Loading schedule…</em>');

        $.post(ajaxurl, {
            action: 'e360_get_schedule_preview_bulk',
            nonce,
            duration: selected.duration,
            include_past_today: 1,
            teacher_ids: JSON.stringify([teacherId])
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $box.html('<em>Schedule unavailable</em>');
                return;
            }

            const map = resp.data.items || {};
            const data = map[teacherId];
            if (!data || !data.days) {
                $box.html('<em>No schedule</em>');
                return;
            }

            function escHtml(v) {
                return $('<div>').text(v || '').html();
            }

            let s = '<div style="font-weight:600;margin-bottom:4px;">Next 7 days</div>';
            s += '<div style="display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px;">';

            data.days.forEach(function(d) {
                const dateObj = new Date(d.date);
                const weekday = dateObj.toLocaleDateString('en-US', {
                    weekday: 'short'
                });
                const day = d.date.slice(5);
                const daySelected = (selected.slots || []).some(function(s) {
                    return s && s.date === d.date;
                });
                const dayBorder = daySelected ? '#3e64de' : '#eee';
                s += `<div class="e360-day-card" data-date="${escHtml(d.date)}" style="border:1px solid ${dayBorder};border-radius:10px;padding:6px;">
                        <div style="font-size:12px;opacity:.8;">${escHtml(weekday)}, ${escHtml(day)}</div>`;
                if (d.times && d.times.length) {
                    s += '<div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:6px;">';
                    d.times.forEach(function(t) {
                        const isActive = (selected.slots || []).some(function(s) {
                            return s && s.date === d.date && s.time === t;
                        });
                        const btnStyle = isActive ?
                            'border:1px solid #3e64de;background:#eef3ff;color:#1f3fb4;' :
                            'border:1px solid #ddd;background:#fff;color:#222;';
                        const btnClass = isActive ? 'e360-slot-btn e360-slot-active' :
                            'e360-slot-btn';
                        s +=
                            `<button type="button" class="${btnClass}" data-date="${escHtml(d.date)}" data-time="${escHtml(t)}" style="font-size:12px;padding:2px 6px;border-radius:999px;cursor:pointer;${btnStyle}">${escHtml(t)}</button>`;
                    });
                    s += '</div>';
                } else {
                    s += '<div style="font-size:12px;opacity:.6;margin-top:6px;">—</div>';
                }
                s += '</div>';
            });

            s += '</div>';
            s +=
                '<div style="margin-top:8px;font-size:12px;opacity:.8;">Click a time slot to select lesson day and time.</div>';
            $box.html(s);
        });
    }

    function selectPreviewSlot(date, time) {
        if (!date || !time) return;
        if (!Array.isArray(selected.slots)) selected.slots = [];
        const key = date + '|' + time;
        const idx = selected.slots.findIndex(function(s) {
            return (s && (s.date + '|' + s.time) === key);
        });

        if (selected.repeat === 'once') {
            selected.slots = [{
                date: date,
                time: time,
                repeat: 'once'
            }];
        } else {
            if (idx >= 0) {
                selected.slots.splice(idx, 1);
            } else {
                selected.slots.push({
                    date: date,
                    time: time,
                    repeat: 'weekly'
                });
            }
        }

        if (selected.slots.length) {
            selected.date = selected.slots[0].date;
            selected.time = selected.slots[0].time;
        } else {
            selected.date = null;
            selected.time = null;
        }

        $('#e360-date').val(selected.date || '');
        $('#e360-time').html('<option value="">Select…</option>');
        if (selected.time) {
            $('#e360-time').append($('<option>', {
                value: selected.time,
                text: selected.time
            }));
            $('#e360-time').val(selected.time);
        }
        if (selected.teacher_id) {
            loadTeacherSchedulePreview(selected.teacher_id);
        }
        $('#e360-msg').text('');
    }

    function applyPlanKind(planKind) {
        selected.plan_kind = planKind || null;
        selected.plan_product_id = null;
        selected.date = null;
        selected.time = null;
        selected.slots = [];
        $('#e360-date').val('');
        $('#e360-time').html('<option value="">Select date first…</option>');

        if (planKind === 'package') {
            selected.repeat = 'weekly';
            $('#e360-repeat').val('weekly');
            $('#e360-repeat-wrap').show();
        } else {
            selected.repeat = 'once';
            $('#e360-repeat').val('once');
            $('#e360-repeat-wrap').hide();
        }

        renderPlansByKind(planKind);
        updateTimeStepVisibility();
    }

    function loadLevels(languageTermId) {
        resetAfterLevel();
        $('#e360-step-level').show();
        $('#e360-level').html('<div style="opacity:.7">Loading…</div>');
        // Не показываем блок Course/Loading… до выбора уровня
        $('#e360-step-course').hide();
        $('#e360-course').html('<div style="opacity:.7">Select level first…</div>');

        $.post(ajaxurl, {
            action: 'e360_get_child_terms',
            nonce,
            taxonomy: selected.taxonomy,
            parent_term_id: languageTermId
        }).done(function(resp) {
            if (!resp.success) {
                $('#e360-level').html('<div>Error</div>');
                return;
            }
            const items = resp.data.items || [];
            if (!items.length) {
                $('#e360-level').html('<div>No levels</div>');
                return;
            }

            // render level cards
            let html = '';
            items.forEach(function(it) {
                html +=
                    `<div class=\"e360-level-card\" data-term-id=\"${it.term_id}\" style=\"border:1px solid rgb(221, 221, 221);border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;\">` +
                    `<div style=\"flex:1;font-weight:600;\">${$('<div>').text(it.name).html()}</div>` +
                    `</div>`;
            });

            $('#e360-level').html(html);
            // Сбросить бордер у всех карточек уровня после ajax
            $('.e360-level-card').css('border', '1px solid rgb(221, 221, 221)');
        });
    }

    function loadCourses(levelTermId) {
        resetAfterLevel();

        $.post(ajaxurl, {
            action: 'e360_get_courses_by_term',
            nonce,
            taxonomy: selected.taxonomy,
            term_id: levelTermId
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-course').html('<option value="">Error</option>');
                return;
            }

            const items = resp.data.items || [];
            coursesIndex = {};

            if (!items.length) {
                $('#e360-course').html('<option value="">No courses</option>');
                return;
            }

            // render course cards (was a <select> before)
            let courseHtml = '';
            items.forEach(function(group) {
                coursesIndex[group.course_key] = group;
                courseHtml +=
                    `<div class="e360-course-card" data-course-key="${group.course_key}" data-course-title="${$('<div>').text(group.course_title).html()}" style="border:1px solid #ddd;border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;">` +
                    `<div style="flex:1;font-weight:600;">${$('<div>').text(group.course_title).html()}</div>` +
                    `</div>`;
            });
            $('#e360-course').html(courseHtml);

            // Спрячем учителей/время пока курс не выбран
            $('#e360-teacher-list').empty();
            $('#e360-step-offer').hide();
            $('#e360-step-time').hide();
            selected.course_key = null;
            selected.course_id = null;
            selected.teacher_id = null;
            selected.teacher_name = null;
            selected.course_title = null;
            selected.plan_product_id = null;
            selected.plan_kind = null;
        });
    }


    function loadSlots(teacherId, date) {
        $('#e360-time').html('<option value="">Loading…</option>');

        $.post(ajaxurl, {
            action: 'e360_get_slots',
            nonce,
            teacher_id: teacherId,
            date: date,
            duration: selected.duration,
            include_past_today: 1
        }).done(function(resp) {
            if (!resp.success) {
                $('#e360-time').html('<option value="">Error</option>');
                return;
            }
            const slots = resp.data.slots || [];
            if (!slots.length) {
                $('#e360-time').html('<option value="">No available slots</option>');
                return;
            }
            $('#e360-time').html('<option value="">Select…</option>');
            slots.forEach(function(s) {
                $('#e360-time').append($('<option>', {
                    value: s,
                    text: s.substring(0, 5)
                }));
            });
        });
    }

    // Step 1: language (cards)
    $(document).on('click', '.e360-language-card', function() {
        resetAfterLanguage();
        $('.e360-language-card').css('border-color', '#ddd').removeClass('e360-language-selected');
        $(this).css('border-color', '#3e64de').addClass('e360-language-selected');
        console.log('LANGUAGE CLICKED', $(this).data('term-id'));

        // Скрыть блок Course до выбора уровня
        $('#e360-step-course').hide();
        // Сбросить контент и показать заглушку
        $('#e360-course').html('<div style="opacity:.7">Select level first…</div>');

        const langId = parseInt($(this).data('term-id'), 10) || 0;
        if (!langId) return;
        selected.language_term_id = langId;
        loadLevels(langId);
    });

    // Step 2: level (cards)
    $(document).on('click', '.e360-level-card', function() {
        // Сбросить стиль и класс у всех карточек уровня
        $('.e360-level-card').each(function() {
            $(this).attr('style',
                'border:1px solid rgb(221, 221, 221);border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;'
            ).removeClass('e360-level-selected');
        });
        // Выделить выбранную
        $(this).attr('style',
            'border:1px solid rgb(62, 100, 222);border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;'
        ).addClass('e360-level-selected');
        console.log('LEVEL CLICKED', $(this).data('term-id'), 'style:', $(this).attr('style'));
        // Повторно применить стиль через 100мс (если DOM обновляется)
        var $el = $(this);
        setTimeout(function() {
            $el.attr('style',
                'border:1px solid rgb(62, 100, 222);border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;'
            );
            console.log('LEVEL STYLE REAPPLIED', $el.data('term-id'), $el.attr('style'));
        }, 100);
        // Показать блок Course после выбора уровня и показать лоадер
        $('#e360-step-course').show();
        $('#e360-course').html('<div style="opacity:.7">Loading…</div>');

        const levelId = parseInt($(this).data('term-id'), 10) || 0;
        selected.level_term_id = levelId || null;
        if (!levelId) return;
        loadCourses(levelId);
    });

    // Step 3: course (+ teacher auto) — course cards are clickable
    $(document).on('click', '.e360-course-card', function() {
        const courseKey = $(this).data('course-key') || '';
        selected.course_key = courseKey || null;

        $('.e360-course-card').css('border-color', '#ddd');
        $(this).css('border-color', '#3e64de');
        // reset selection
        selected.course_id = null;
        selected.teacher_id = null;
        selected.teacher_name = null;
        selected.course_title = null;
        selected.date = null;
        selected.time = null;

        $('#e360-date').val('');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-step-time').hide();

        const group = coursesIndex[courseKey];
        if (!group || !group.variants || !group.variants.length) {
            $('#e360-teacher-list').html('<div>No teachers found for this course.</div>');
            return;
        }

        // Рисуем карточки учителей
        const teachers = group.variants;

        let html =
            '<div class="e360-teachers" style="display:grid;grid-template-columns:1fr;gap:10px;">';
        teachers.forEach(function(v) {
            const avatar = v.teacher_avatar ?
                `<img src="${v.teacher_avatar}" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">` :
                '';

            // short snippet removed — keep only full bio behind the Bio button

            // full html уже sanitized на сервере, но защитим template literal от ` (редко, но бывает)
            const fullBioSafe = (v.teacher_bio_html || '').replace(/`/g, '&#96;');
            const bioFull = fullBioSafe ?
                `<div class="e360-bio-full" style="display:none;margin-top:8px;">${fullBioSafe}</div>` :
                '';

            const role = v.teacher_role ?
                `` :
                '';

            const bioBtn = fullBioSafe ?
                `<button type="button" class="e360-toggle-bio tutor-btn tutor-btn-outline-primary tutor-btn-sm" style="margin-top:8px;">Bio</button>` :
                '';

            const chooseBtn =
                `<button type="button" class="e360-choose-teacher tutor-btn tutor-btn-primary tutor-btn-sm tutor-ws-nowrap" style="margin-top:8px;">
            Choose this teacher
         </button>`;

            html += `
        <div class="e360-teacher-card"
             data-teacher-id="${v.teacher_id}"
             data-course-id="${v.course_id}"
             data-teacher-name="${$('<div>').text(v.teacher_name||'').html()}"
             style="border:1px solid #ddd;border-radius:12px;padding:10px;">
            <div style="display:flex;gap:10px;align-items:flex-start;">
                <div>${avatar}</div>
                <div style="flex:1;">
                    <div style="font-weight:600;">${$('<div>').text(v.teacher_name || '').html()}</div>
                    ${role}
                    ${bioBtn}
                    ${bioFull}

                    <div style="margin-top:10px;">
                        ${chooseBtn}
                    </div>
                </div>
            </div>
        </div>`;
        });

        html += '</div>';

        $('#e360-teacher-list').html(html);

        // toggle bio
        $(document).off('click.e360bio').on('click.e360bio', '.e360-toggle-bio', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.e360-teacher-card').find('.e360-bio-full').toggle();
        });

        // choose teacher (кнопка)
        $(document).off('click.e360choosebtn').on('click.e360choosebtn', '.e360-choose-teacher',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).closest('.e360-teacher-card').trigger('click');

                // мягко докрутим к выбору формата
                const $step = $('#e360-step-offer');
                if ($step.length) {
                    $('html, body').animate({
                        scrollTop: $step.offset().top - 80
                    }, 250);
                }
            });

        // card click = select teacher
        $(document).off('click.e360card').on('click.e360card', '.e360-teacher-card', function() {
            $('.e360-teacher-card').css('border-color', '#ddd');
            $(this).css('border-color', '#3e64de');

            const teacherId = parseInt($(this).data('teacher-id'), 10) || 0;
            const courseId = parseInt($(this).data('course-id'), 10) || 0;
            const teacherName = $(this).data('teacher-name') || null;

            selected.teacher_id = teacherId || null;
            selected.course_id = courseId || null;
            selected.teacher_name = teacherName || null;
            selected.plan_kind = null;
            selected.plan_product_id = null;
            selected.date = null;
            selected.time = null;
            selected.slots = [];

            $('#e360-date').val('');
            $('#e360-time').html('<option value="">Select date first…</option>');
            $('#e360-offer-msg').text('');
            $('#e360-offer-schedule').show().html('<em>Loading schedule…</em>');
            $('.e360-purchase-card').removeClass('tutor-btn-primary').addClass(
                'tutor-btn-outline-primary');
            $('#e360-step-offer').show();
            $('#e360-plan-wrap').hide();
            updateTimeStepVisibility();

            loadPlans();
            loadTeacherSchedulePreview(teacherId);
        });

    });


    // Step 4: date -> slots
    $('#e360-date').on('change', function() {
        const date = $(this).val();
        selected.date = date || null;
        if (!date || !selected.teacher_id || !canShowTimeStep()) return;
        loadSlots(selected.teacher_id, date);
    });

    $('#e360-time').on('change', function() {
        selected.time = $(this).val() || null;
    });

    $(document).on('click', '.e360-slot-btn', function(e) {
        e.preventDefault();
        const date = ($(this).data('date') || '').toString();
        const time = ($(this).data('time') || '').toString();
        if (!date || !time) return;
        selectPreviewSlot(date, time);
    });

    $('#e360-plan').on('change', function() {
        selected.plan_product_id = parseInt($(this).val(), 10) || null;
        updateTimeStepVisibility();

        if (selected.plan_product_id && selected.date && selected.teacher_id) {
            loadSlots(selected.teacher_id, selected.date);
        }
    });

    $(document).on('click', '.e360-purchase-card', function() {
        if (!selected.teacher_id) return;
        const planKind = ($(this).data('plan-kind') || '').toString();
        if (!planKind) return;

        $('.e360-purchase-card').removeClass('tutor-btn-primary').addClass('tutor-btn-outline-primary');
        $(this).removeClass('tutor-btn-outline-primary').addClass('tutor-btn-primary');

        applyPlanKind(planKind);
    });

    $('#e360-repeat').on('change', function() {
        selected.repeat = $(this).val() || 'weekly';
        if (selected.repeat === 'once' && Array.isArray(selected.slots) && selected.slots.length > 1) {
            selected.slots = [selected.slots[0]];
            selected.date = selected.slots[0].date;
            selected.time = selected.slots[0].time;
        }
        if (Array.isArray(selected.slots)) {
            selected.slots = selected.slots.map(function(s) {
                if (!s) return s;
                s.repeat = (selected.repeat === 'once') ? 'once' : 'weekly';
                return s;
            });
        }
        if (selected.teacher_id) loadTeacherSchedulePreview(selected.teacher_id);
    });


    // Continue -> student registration
    $('#e360-continue').on('click', function() {
        if (!Array.isArray(selected.slots) || !selected.slots.length) {
            if (selected.date && selected.time) {
                selected.slots = [{
                    date: selected.date,
                    time: selected.time,
                    repeat: (selected.repeat === 'once') ? 'once' : 'weekly'
                }];
            }
        }
        if (Array.isArray(selected.slots) && selected.slots.length) {
            selected.date = selected.slots[0].date;
            selected.time = selected.slots[0].time;
        }

        if (!selected.language_term_id || !selected.level_term_id || !selected.course_id || !selected
            .teacher_id || !selected.slots || !selected.slots.length) {
            $('#e360-msg').text('Select language, level, course, date and time first.');
            return;
        }
        if (!selected.plan_product_id) {
            $('#e360-msg').text('Select a lesson option first.');
            return;
        }

        const payload = {
            language_term_id: selected.language_term_id,
            level_term_id: selected.level_term_id,
            course_id: selected.course_id,
            teacher_id: selected.teacher_id,
            date: selected.date,
            time: selected.time,
            slots: selected.slots,
            plan_product_id: selected.plan_product_id,
            duration: selected.duration,
            repeat: selected.repeat,
            booking_format: selected.plan_kind || ''
        };

        const isLoggedIn = String($wiz.data('is-logged-in')) === '1';
        if (isLoggedIn) {
            $('#e360-msg').text('Preparing checkout…');
            $.post(ajaxurl, {
                action: 'e360_prepare_checkout',
                nonce,
                ctx: JSON.stringify(payload)
            }).done(function(resp) {
                if (!resp || !resp.success) {
                    const m = (resp && resp.data && resp.data.message) ? resp.data.message :
                        'Could not prepare checkout.';
                    $('#e360-msg').text(m);
                    return;
                }
                const checkoutUrl = (resp.data && resp.data.checkout_url) ? resp.data
                    .checkout_url : '';
                if (!checkoutUrl) {
                    $('#e360-msg').text('Checkout URL is missing.');
                    return;
                }
                window.location.href = checkoutUrl;
            }).fail(function() {
                $('#e360-msg').text('Request failed. Please try again.');
            });
            return;
        }

        const regUrl = $wiz.data('registration-url');
        const url = new URL(regUrl);

        url.searchParams.set('language_term_id', selected.language_term_id);
        url.searchParams.set('level_term_id', selected.level_term_id);
        url.searchParams.set('course_id', selected.course_id);
        url.searchParams.set('teacher_id', selected.teacher_id);
        url.searchParams.set('date', selected.date);
        url.searchParams.set('time', selected.time);
        url.searchParams.set('plan_product_id', selected.plan_product_id);
        url.searchParams.set('duration', selected.duration);
        url.searchParams.set('repeat', selected.repeat);
        if (selected.slots && selected.slots.length) {
            url.searchParams.set('slots', encodeURIComponent(JSON.stringify(selected.slots)));
        }
        if (selected.plan_kind) {
            url.searchParams.set('booking_format', selected.plan_kind);
        }



        window.location.href = url.toString();
    });


    function loadPlans() {
        if (plansIndex.length) return;
        $('#e360-plan').html('<option value="">Loading…</option>');

        $.post(ajaxurl, {
            action: 'e360_get_plans',
            nonce
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-offer-msg').text('Could not load payment options.');
                $('#e360-plan').html('<option value="">Error</option>');
                return;
            }

            const items = resp.data.items || [];
            if (!items.length) {
                $('#e360-offer-msg').text('No payment options are available.');
                $('#e360-plan').html('<option value="">No packages found</option>');
                return;
            }

            plansIndex = items;
            if (selected.plan_kind) applyPlanKind(selected.plan_kind);
        });
    }


});
</script>
<?php
    return ob_get_clean();
});


add_shortcode('e360_registration_booking_context', function () {
    $term_id    = isset($_GET['term_id']) ? (int) $_GET['term_id'] : 0;
    $course_id  = isset($_GET['course_id']) ? (int) $_GET['course_id'] : 0;
    $teacher_id = isset($_GET['teacher_id']) ? (int) $_GET['teacher_id'] : 0;
    $date       = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $time       = isset($_GET['time']) ? sanitize_text_field($_GET['time']) : '';
    $slots_param = isset($_GET['slots']) ? wp_unslash((string)$_GET['slots']) : '';
    $booking_format = isset($_GET['booking_format']) ? sanitize_key($_GET['booking_format']) : '';
    $format_label = e360_booking_format_label($booking_format);

    if (!$course_id || !$teacher_id || !$date || !$time) {
        return ''; // если пришли без параметров — ничего не показываем
    }

    $course  = get_post($course_id);
    $teacher = get_user_by('id', $teacher_id);

    $course_title  = $course ? $course->post_title : ('Course #' . $course_id);
    $teacher_name  = $teacher ? $teacher->display_name : ('Teacher #' . $teacher_id);

    // имя категории (языка)
    $term_name = '';
    if ($term_id) {
        $t = get_term($term_id);
        if ($t && !is_wp_error($t)) $term_name = $t->name;
    }

    ob_start(); ?>
<div class="e360-selected-booking" style="padding:12px;border:1px solid #ddd;margin:12px 0;">
    <strong>Your selection:</strong><br>
    <?php if ($term_name) : ?>
    Language: <?php echo esc_html($term_name); ?><br>
    <?php endif; ?>
    Teacher: <?php echo esc_html($teacher_name); ?><br>
    Course: <?php echo esc_html($course_title); ?><br>
    Date/Time: <?php echo esc_html($date . ' ' . substr($time, 0, 5)); ?><br>
    <?php if ($format_label) : ?>
    Format: <?php echo esc_html($format_label); ?>
    <?php endif; ?>
</div>

<div id="e360-hidden-context" style="display:none;">
    <input type="hidden" name="e360_term_id" value="<?php echo esc_attr($term_id); ?>">
    <input type="hidden" name="e360_course_id" value="<?php echo esc_attr($course_id); ?>">
    <input type="hidden" name="e360_teacher_id" value="<?php echo esc_attr($teacher_id); ?>">
    <input type="hidden" name="e360_booking_date" value="<?php echo esc_attr($date); ?>">
    <input type="hidden" name="e360_booking_time" value="<?php echo esc_attr($time); ?>">
    <input type="hidden" name="booking_format" value="<?php echo esc_attr($booking_format); ?>">
</div>

<script>
jQuery(function($) {
    // Пытаемся найти форму регистрации и добавить hidden-поля внутрь
    const $form =
        $('.tutor-register-wrap form').first().length ? $('.tutor-register-wrap form').first() :
        $('form').first();

    if ($form.length) {
        $('#e360-hidden-context input').each(function() {
            const $i = $(this);
            // не дублировать если уже вставлено
            if (!$form.find('input[name="' + $i.attr('name') + '"]').length) {
                $form.append($i.clone());
            }
        });
    }
});
</script>
<?php
    return ob_get_clean();
});


add_action('user_register', function($user_id){

    $ctx = null;

    // preferred: full JSON context (injected by some registration shortcode)
    if (!empty($_POST['e360_booking_ctx'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx']);
        $ctx = json_decode($raw, true);
    }
    if ((!is_array($ctx) || !$ctx) && !empty($_POST['e360_booking_ctx_checkout'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx_checkout']);
        $ctx = json_decode($raw, true);
    }

    // fallback: individual hidden inputs (older shortcode / simple hidden fields)
    if (!is_array($ctx) || !$ctx) {
        // collect from various possible input names
        $course_id = isset($_POST['e360_course_id']) ? (int) $_POST['e360_course_id'] : (isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0);
        $teacher_id = isset($_POST['e360_teacher_id']) ? (int) $_POST['e360_teacher_id'] : (isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0);
        $date = isset($_POST['e360_booking_date']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_date'])) : (isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '');
        $time = isset($_POST['e360_booking_time']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_time'])) : (isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '');
        $language_term_id = isset($_POST['e360_term_id']) ? (int) $_POST['e360_term_id'] : (isset($_POST['language_term_id']) ? (int) $_POST['language_term_id'] : 0);
        $level_term_id = isset($_POST['level_term_id']) ? (int) $_POST['level_term_id'] : (isset($_POST['e360_level_id']) ? (int) $_POST['e360_level_id'] : 0);
        $plan_product_id = isset($_POST['plan_product_id']) ? (int) $_POST['plan_product_id'] : (isset($_POST['plan']) ? (int) $_POST['plan'] : 0);
        $booking_format = isset($_POST['booking_format']) ? sanitize_key(wp_unslash($_POST['booking_format'])) : '';

        if ($course_id && $teacher_id && $date && $time) {
            $ctx = [
                'language_term_id' => $language_term_id,
                'level_term_id'    => $level_term_id,
                'course_id'        => $course_id,
                'teacher_id'       => $teacher_id,
                'date'             => $date,
                'time'             => $time,
                'plan_product_id'  => $plan_product_id,
                'booking_format'   => $booking_format,
            ];
        }
    }

    if (!is_array($ctx)) return;

    $plan_id = (int)($ctx['plan_product_id'] ?? 0);

    $clean = [
        'language_term_id' => (int)($ctx['language_term_id'] ?? 0),
        'level_term_id'    => (int)($ctx['level_term_id'] ?? 0),
        'course_id'        => (int)($ctx['course_id'] ?? 0),
        'teacher_id'       => (int)($ctx['teacher_id'] ?? 0),
        'date'             => sanitize_text_field($ctx['date'] ?? ''),
        'time'             => sanitize_text_field($ctx['time'] ?? ''),
        'plan_product_id'  => $plan_id,
        'booking_format'   => e360_resolve_booking_format($ctx),
        'created_at'       => current_time('mysql'),
    ];
    $clean['repeat'] = (($ctx['repeat'] ?? '') === 'once') ? 'once' : 'weekly';
    $clean['duration'] = (int)($ctx['duration'] ?? 60);
    if ($clean['duration'] <= 0) $clean['duration'] = 60;
    $clean['slots'] = e360_sanitize_ctx_slots(($ctx['slots'] ?? []), $clean['repeat'], (int)$clean['duration']);
    if (!$clean['slots'] && $clean['date'] !== '' && $clean['time'] !== '') {
        $clean['slots'] = [[
            'date' => $clean['date'],
            'time' => substr((string)$clean['time'], 0, 5),
            'repeat' => $clean['repeat'],
            'duration' => (int)$clean['duration'],
        ]];
    }
    if ($clean['slots']) {
        $clean['date'] = (string)$clean['slots'][0]['date'];
        $clean['time'] = (string)$clean['slots'][0]['time'];
    }

    update_user_meta($user_id, 'e360_booking_context', $clean);
    update_user_meta($user_id, 'e360_primary_teacher_id', (int)($ctx['teacher_id'] ?? 0));
    update_user_meta($user_id, 'e360_primary_course_id', (int)($ctx['course_id'] ?? 0));
    if (function_exists('e360_create_bookings_from_context')) {
        e360_create_bookings_from_context((int)$user_id, $clean);
    } elseif (function_exists('e360_create_booking_from_context')) {
        e360_create_booking_from_context((int)$user_id, $clean);
    }



    if ($plan_id) {
        update_user_meta($user_id, 'e360_plan_to_checkout_once', $plan_id);

        // cookie на 10 минут, чтобы пережить любые редиректы после регистрации
        setcookie('e360_go_checkout', '1', time() + 600, COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), true);
    }

}, 10, 1);


add_action('template_redirect', function(){
    if (is_admin() || wp_doing_ajax()) return;

    // запускаем только если cookie есть
    if (empty($_COOKIE['e360_go_checkout'])) return;

    // если не залогинен — на логин, потом вернёмся сюда же
    if (!is_user_logged_in()) {
        $here = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        wp_safe_redirect( wp_login_url($here) );
        exit;
    }

    // залогинен — убираем cookie, чтобы не зациклить
    setcookie('e360_go_checkout', '', time() - 3600, COOKIEPATH ?: '/', COOKIE_DOMAIN);

    $user_id = get_current_user_id();
    $plan_id = (int) get_user_meta($user_id, 'e360_plan_to_checkout_once', true);
    if (!$plan_id) return;

    delete_user_meta($user_id, 'e360_plan_to_checkout_once');

    if (function_exists('WC') && WC()->cart) {
        // обычно лучше чистить, чтобы в оплате был 1 пакет
        WC()->cart->empty_cart();
        WC()->cart->add_to_cart($plan_id);
    }

    wp_safe_redirect( wc_get_checkout_url() );
    exit;
});



add_action('wp_ajax_e360_get_child_terms', 'e360_get_child_terms');
add_action('wp_ajax_nopriv_e360_get_child_terms', 'e360_get_child_terms');

function e360_get_child_terms() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $parent_id = isset($_POST['parent_term_id']) ? (int) $_POST['parent_term_id'] : 0;
    $taxonomy  = isset($_POST['taxonomy']) ? sanitize_key($_POST['taxonomy']) : 'course-category';

    if ($parent_id <= 0) {
        wp_send_json_error(['message' => 'parent_term_id required']);
    }

    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => $parent_id,
    ]);

    if (is_wp_error($terms)) {
        wp_send_json_error(['message' => 'Cannot load terms']);
    }

    $items = [];
    foreach ($terms as $t) {
        $items[] = [
            'term_id' => (int) $t->term_id,
            'name'    => $t->name,
            'slug'    => $t->slug,
        ];
    }

    wp_send_json_success(['items' => $items]);
}

// 1) Рендерим блок на странице student-registration
add_action('wp_footer', function () {
    if (!is_page('student-registration')) return;

    $course_id  = isset($_GET['course_id']) ? (int) $_GET['course_id'] : 0;
    $teacher_id = isset($_GET['teacher_id']) ? (int) $_GET['teacher_id'] : 0;
    $date       = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $time       = isset($_GET['time']) ? sanitize_text_field($_GET['time']) : '';
    $slots_param = isset($_GET['slots']) ? wp_unslash((string)$_GET['slots']) : '';

    $language_term_id = isset($_GET['language_term_id']) ? (int) $_GET['language_term_id'] : 0;
    $level_term_id    = isset($_GET['level_term_id']) ? (int) $_GET['level_term_id'] : 0;

    $plan_product_id = isset($_GET['plan_product_id']) ? (int) $_GET['plan_product_id'] : 0;
    $booking_format = isset($_GET['booking_format']) ? sanitize_key($_GET['booking_format']) : '';


    // Если параметров нет — ничего не показываем.
    $slots = [];
    if ($slots_param !== '') {
        $decoded = json_decode(rawurldecode($slots_param), true);
        if (is_array($decoded)) $slots = e360_sanitize_ctx_slots($decoded, 'weekly', 60);
    }
    if ((!$date || !$time) && $slots) {
        $date = (string)$slots[0]['date'];
        $time = (string)$slots[0]['time'];
    }
    if (!$course_id || !$teacher_id || !$date || !$time) return;

    $course_title = $course_id ? get_the_title($course_id) : '';
    $teacher = get_user_by('id', $teacher_id);
    $teacher_name = $teacher ? $teacher->display_name : ('Teacher #'.$teacher_id);
    $duration = isset($_GET['duration']) ? (int) $_GET['duration'] : 60;
    $repeat   = isset($_GET['repeat']) ? sanitize_text_field($_GET['repeat']) : 'weekly';
    $format_key = e360_resolve_booking_format([
        'booking_format' => $booking_format,
        'plan_product_id' => $plan_product_id,
    ]);
    $format_label = e360_booking_format_label($format_key);


    $ctx = [
        'language_term_id' => $language_term_id,
        'level_term_id'    => $level_term_id,
        'course_id'        => $course_id,
        'teacher_id'       => $teacher_id,
        'date'             => $date,
        'time'             => $time,
        'plan_product_id' => $plan_product_id,
        'duration' => $duration,
        'repeat'   => $repeat,
        'booking_format' => $format_key,
        'slots'            => $slots,


    ];
    $ctx_json = wp_json_encode($ctx);

    $plan_title = '';
$plan_price = '';
if ($plan_product_id && function_exists('wc_get_product')) {
    $p = wc_get_product($plan_product_id);
    if ($p) {
        $plan_title = $p->get_name();
        $plan_price = trim(wp_strip_all_tags($p->get_price_html()));
    }
}


    ?>
<div id="e360-reg-context" style="padding:12px;border:1px solid #ddd;border-radius:10px;margin:12px 0;">
    <div style="font-weight:600;margin-bottom:6px;">Your lesson request</div>
    <div><strong>Course:</strong> <?php echo esc_html($course_title ?: ('#'.$course_id)); ?></div>
    <div><strong>Teacher:</strong> <?php echo esc_html($teacher_name); ?></div>
    <?php $ctx_slot_labels = e360_ctx_slot_labels($ctx); ?>
    <?php if (count($ctx_slot_labels) > 1): ?>
    <div><strong>Schedule:</strong><br><?php echo wp_kses_post(e360_ctx_slot_html($ctx)); ?></div>
    <?php else: ?>
    <div><strong>Date/time:</strong>
        <?php echo esc_html($ctx_slot_labels ? $ctx_slot_labels[0] : ($date . ' ' . substr($time,0,5))); ?></div>
    <?php endif; ?>
    <?php if ($plan_title): ?>
    <div><strong>Package:</strong> <?php echo esc_html($plan_title . ($plan_price ? ' — ' . $plan_price : '')); ?></div>
    <?php endif; ?>
    <?php if ($format_label): ?>
    <div><strong>Format:</strong> <?php echo esc_html($format_label); ?></div>
    <?php endif; ?>
    <?php if ($plan_title): ?>
    <div><strong>Type:</strong> <?php echo esc_html($repeat === 'once' ? 'One-time' : 'Weekly'); ?></div>
    <?php endif; ?>

</div>

<script>
(function() {
    // 1) Вставляем блок перед регистрационной формой
    var box = document.getElementById('e360-reg-context');
    if (!box) return;

    var form = document.querySelector('form'); // fallback
    // попробуем найти “правильную” форму Tutor
    var tutorForm = document.querySelector('form input[name="tutor_register_nonce"]');
    if (tutorForm) form = tutorForm.closest('form');

    if (form && form.parentNode) {
        form.parentNode.insertBefore(box, form);
    }

    // 2) Добавляем скрытое поле с контекстом, чтобы на user_register это поймать
    if (form) {
        var hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'e360_booking_ctx';
        hidden.value = <?php echo json_encode($ctx_json); ?>;
        form.appendChild(hidden);
    }
})();
</script>
<?php
});

function e360_render_booking_context_in_profile($user){
    $ctx = get_user_meta($user->ID, 'e360_booking_context', true);
    if (empty($ctx) || !is_array($ctx)) return;

    $course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
    $teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
    $slot_labels = e360_ctx_slot_labels($ctx);

    ?>
<h2>English360 Booking Context</h2>
<table class="form-table" role="presentation">
    <tr>
        <th>Course</th>
        <td><?php echo esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))); ?></td>
    </tr>
    <tr>
        <th>Teacher</th>
        <td><?php echo esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? ''))); ?></td>
    </tr>
    <tr>
        <th>Date / time</th>
        <td>
            <?php if (count($slot_labels) > 1): ?>
            <?php echo wp_kses_post(e360_ctx_slot_html($ctx)); ?>
            <?php else: ?>
            <?php echo esc_html($slot_labels ? $slot_labels[0] : (($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5))); ?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Saved</th>
        <td><?php echo esc_html($ctx['created_at'] ?? ''); ?></td>
    </tr>
</table>
<?php
}
add_action('show_user_profile', 'e360_render_booking_context_in_profile');
add_action('edit_user_profile', 'e360_render_booking_context_in_profile');

add_action('wp_ajax_e360_get_plans', 'e360_get_plans');
add_action('wp_ajax_nopriv_e360_get_plans', 'e360_get_plans');

function e360_get_plans() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    if ( ! function_exists('wc_get_product') ) {
        wp_send_json_error(['message' => 'WooCommerce not active']);
    }

    // Можно оставить whitelist (как у тебя)
    $plan_ids = [196, 158, 156, 57];

    $items = [];
    foreach ($plan_ids as $pid) {
        $product = wc_get_product($pid);
        if (!$product) continue;

        // НЕ отбрасываем purchasable — иногда плагины/подписки дают false в неожиданных местах
        $price_html = $product->get_price_html();
        $price_text = html_entity_decode(trim(wp_strip_all_tags($price_html)));

        $items[] = [
            'product_id' => (int) $pid,
            'title'      => $product->get_name(),
            'price_html' => $price_html,
            'price_text' => $price_text,
            'type'       => $product->get_type(),
            'plan_kind'  => sanitize_key((string) get_post_meta($pid, 'e360_product_type', true)),
        ];
    }

    wp_send_json_success(['items' => $items]);
}

/**
 * Берём значение из $_POST по списку возможных ключей.
 */
function e360_post_first_nonempty(array $keys): string {
    foreach ($keys as $k) {
        if (!empty($_POST[$k])) {
            return sanitize_text_field(wp_unslash($_POST[$k]));
        }
    }
    return '';
}

/**
 * При регистрации: переносим данные в Woo billing_* meta,
 * чтобы checkout был предзаполнен.
 */
add_action('user_register', function($user_id){

    // если WooCommerce не активен — просто выходим
    if (!function_exists('wc_get_checkout_url')) return;

    $user = get_userdata($user_id);

    // Tutor/WordPress формы могут использовать разные name=""
    $first = e360_post_first_nonempty(['first_name', 'fname', 'tutor_first_name', 'student_first_name']);
    $last  = e360_post_first_nonempty(['last_name', 'lname', 'tutor_last_name', 'student_last_name']);
    $phone = e360_post_first_nonempty(['phone', 'billing_phone', 'tutor_phone', 'student_phone', 'phone_number']);

    // На всякий: email обычно уже в $user->user_email
    $email = ($user && !empty($user->user_email)) ? sanitize_email($user->user_email) : '';
    if (!$email) {
        $email = sanitize_email(e360_post_first_nonempty(['email', 'user_email']));
    }

    // Не перетираем, если у пользователя уже заполнено
    $set_if_empty = function(string $meta_key, string $value) use ($user_id) {
        if ($value === '') return;
        $existing = get_user_meta($user_id, $meta_key, true);
        if ($existing === '' || $existing === null) {
            update_user_meta($user_id, $meta_key, $value);
        }
    };

    // WP core (иногда полезно для профиля)
    $set_if_empty('first_name', $first);
    $set_if_empty('last_name',  $last);

    // Woo billing (это подтянется на checkout автоматически)
    $set_if_empty('billing_first_name', $first);
    $set_if_empty('billing_last_name',  $last);
    $set_if_empty('billing_phone',      $phone);
    $set_if_empty('billing_email',      $email);

}, 20, 1);

add_filter('woocommerce_checkout_get_value', function($value, $input){
    if (!empty($value)) return $value;
    if (!is_user_logged_in()) return $value;

    $uid = get_current_user_id();

    switch ($input) {
        case 'billing_first_name':
            return get_user_meta($uid, 'billing_first_name', true) ?: get_user_meta($uid, 'first_name', true);
        case 'billing_last_name':
            return get_user_meta($uid, 'billing_last_name', true) ?: get_user_meta($uid, 'last_name', true);
        case 'billing_phone':
            return get_user_meta($uid, 'billing_phone', true);
        case 'billing_email':
            $u = wp_get_current_user();
            return get_user_meta($uid, 'billing_email', true) ?: ($u->user_email ?? '');
    }
    return $value;
}, 10, 2);

// 1) Секция в Checkout settings
add_filter('woocommerce_get_sections_checkout', function($sections){
    $sections['english360'] = 'English360';
    return $sections;
});

// 2) Поля настроек секции
add_filter('woocommerce_get_settings_checkout', function($settings, $current_section){

    if ($current_section !== 'english360') return $settings;

    $settings = [];

    $settings[] = [
        'title' => 'English360 checkout fields',
        'type'  => 'title',
        'id'    => 'e360_checkout_fields_title',
    ];

    $settings[] = [
        'title'   => 'Referral sources (one per line)',
        'desc'    => 'These values will be used in "How did you hear about us?" dropdown.',
        'id'      => 'e360_referral_sources',
        'type'    => 'textarea',
        'css'     => 'min-width:400px;min-height:120px;',
        'default' => "Google\nInstagram\nFriend recommendation\nOther",
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id'   => 'e360_checkout_fields_title',
    ];

    return $settings;

}, 10, 2);

/**
 * Достаём варианты из опции (по 1 в строке)
 */
function e360_get_referral_sources(): array {
    $raw = (string) get_option('e360_referral_sources', '');
    $lines = preg_split("/\r\n|\n|\r/", $raw);
    $out = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line !== '') $out[] = $line;
    }
    return $out;
}

add_filter('woocommerce_checkout_fields', function($fields){

    // Убедимся что телефон есть и обязателен
    if (!empty($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required'] = true;
        $fields['billing']['billing_phone']['priority'] = 25;
    }

    // How did you hear about us? (select)
    $options = ['' => 'Select…'];
    foreach (e360_get_referral_sources() as $src) {
        $options[$src] = $src;
    }

    $fields['billing']['e360_referral_source'] = [
        'type'     => 'select',
        'label'    => 'How did you hear about us?',
        'required' => true, // если хочешь optional — поставь false
        'options'  => $options,
        'priority' => 60,
        'class'    => ['form-row-wide'],
    ];

    // Birthday (optional)
    $fields['billing']['e360_birthdate'] = [
        'type'        => 'date',
        'label'       => 'Birthday (optional)',
        'required'    => false,
        'priority'    => 70,
        'class'       => ['form-row-first'],
        'placeholder' => '',
    ];

    // Has WhatsApp checkbox
    $fields['billing']['e360_has_whatsapp'] = [
        'type'     => 'checkbox',
        'label'    => 'My phone has WhatsApp',
        'required' => false,
        'priority' => 80,
        'class'    => ['form-row-last'],
        'default'  => 1, // по умолчанию включено
    ];

    // WhatsApp number (покажем/спрячем через JS)
    $fields['billing']['e360_whatsapp_number'] = [
        'type'        => 'text',
        'label'       => 'WhatsApp number',
        'required'    => false, // требование сделаем валидатором
        'priority'    => 90,
        'class'       => ['form-row-wide', 'e360-whatsapp-number-row'],
        'placeholder' => '+1 555 123 4567',
    ];

    return $fields;
});


add_action('wp_footer', function(){
    if (!function_exists('is_checkout') || !is_checkout()) return;
    ?>
<script>
(function($) {
    function toggleWhatsappField() {
        var checked = $('#e360_has_whatsapp').is(':checked');
        var $row = $('.e360-whatsapp-number-row');
        if (checked) {
            $row.hide();
            $('#e360_whatsapp_number').val('');
        } else {
            $row.show();
        }
    }

    $(document).on('change', '#e360_has_whatsapp', toggleWhatsappField);
    $(document).ready(function() {
        toggleWhatsappField();
    });
})(jQuery);
</script>
<?php
});


// Валидация
add_action('woocommerce_checkout_process', function(){

    $ref = isset($_POST['e360_referral_source']) ? trim(wp_unslash($_POST['e360_referral_source'])) : '';
    if ($ref === '') {
        wc_add_notice('Please select how you heard about us.', 'error');
    }

    $has_whatsapp = !empty($_POST['e360_has_whatsapp']);
    $wa_number = isset($_POST['e360_whatsapp_number']) ? trim(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    // Если НЕ отмечено "есть WhatsApp" — требуем номер WhatsApp
    if (!$has_whatsapp && $wa_number === '') {
        wc_add_notice('Please enter a WhatsApp number (or check "My phone has WhatsApp").', 'error');
    }

    // Birthdate (если заполнено — проверим формат YYYY-MM-DD)
    $birth = isset($_POST['e360_birthdate']) ? trim(wp_unslash($_POST['e360_birthdate'])) : '';
    if ($birth !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth)) {
        wc_add_notice('Birthday format is invalid.', 'error');
    }
});

// Сохранение в заказ
add_action('woocommerce_checkout_create_order', function($order){

    $ref = isset($_POST['e360_referral_source']) ? sanitize_text_field(wp_unslash($_POST['e360_referral_source'])) : '';
    $birth = isset($_POST['e360_birthdate']) ? sanitize_text_field(wp_unslash($_POST['e360_birthdate'])) : '';
    $has_whatsapp = !empty($_POST['e360_has_whatsapp']) ? 'yes' : 'no';
    $wa_number = isset($_POST['e360_whatsapp_number']) ? sanitize_text_field(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    if ($ref !== '') $order->update_meta_data('_e360_referral_source', $ref);
    if ($birth !== '') $order->update_meta_data('_e360_birthdate', $birth);
    $order->update_meta_data('_e360_has_whatsapp', $has_whatsapp);
    if ($wa_number !== '') $order->update_meta_data('_e360_whatsapp_number', $wa_number);
    
    // Save booking context to order meta
    $ctx = null;
    if (!empty($_POST['e360_booking_ctx'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx']);
        $ctx = json_decode($raw, true);
    }
    if ((!is_array($ctx) || !$ctx) && !empty($_POST['e360_booking_ctx_checkout'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx_checkout']);
        $ctx = json_decode($raw, true);
    }
    if (!is_array($ctx) || !$ctx) {
        $course_id = isset($_POST['e360_course_id']) ? (int) $_POST['e360_course_id'] : (isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0);
        $teacher_id = isset($_POST['e360_teacher_id']) ? (int) $_POST['e360_teacher_id'] : (isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0);
        $date = isset($_POST['e360_booking_date']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_date'])) : (isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '');
        $time = isset($_POST['e360_booking_time']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_time'])) : (isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '');
        $language_term_id = isset($_POST['e360_term_id']) ? (int) $_POST['e360_term_id'] : (isset($_POST['language_term_id']) ? (int) $_POST['language_term_id'] : 0);
        $level_term_id = isset($_POST['level_term_id']) ? (int) $_POST['level_term_id'] : (isset($_POST['e360_level_id']) ? (int) $_POST['e360_level_id'] : 0);
        $plan_product_id = isset($_POST['plan_product_id']) ? (int) $_POST['plan_product_id'] : (isset($_POST['plan']) ? (int) $_POST['plan'] : 0);
        $duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
        $repeat = isset($_POST['repeat']) ? sanitize_text_field($_POST['repeat']) : 'weekly';
        $booking_format = isset($_POST['booking_format']) ? sanitize_key(wp_unslash($_POST['booking_format'])) : '';
        $slots_raw = isset($_POST['e360_slots']) ? wp_unslash($_POST['e360_slots']) : '';
        $slots = [];
        if ($slots_raw !== '') {
            $tmp = json_decode((string)$slots_raw, true);
            if (is_array($tmp)) $slots = $tmp;
        }
        if ($course_id && $teacher_id && $date && $time) {
            $ctx = [
                'language_term_id' => $language_term_id,
                'level_term_id'    => $level_term_id,
                'course_id'        => $course_id,
                'teacher_id'       => $teacher_id,
                'date'             => $date,
                'time'             => $time,
                'plan_product_id'  => $plan_product_id,
                'duration'         => $duration,
                'repeat'           => $repeat,
                'booking_format'   => $booking_format,
                'slots'            => $slots,
            ];
        }
    }
    if (is_array($ctx) && $ctx) {
        $repeat = (($ctx['repeat'] ?? '') === 'once') ? 'once' : 'weekly';
        $duration = (int)($ctx['duration'] ?? 60);
        if ($duration <= 0) $duration = 60;
        $slots = e360_sanitize_ctx_slots(($ctx['slots'] ?? []), $repeat, $duration);
        if (!$slots && !empty($ctx['date']) && !empty($ctx['time'])) {
            $slots = [[
                'date' => sanitize_text_field((string)$ctx['date']),
                'time' => substr(sanitize_text_field((string)$ctx['time']), 0, 5),
                'repeat' => $repeat,
                'duration' => $duration,
            ]];
        }
        if ($slots) {
            $ctx['date'] = (string)$slots[0]['date'];
            $ctx['time'] = (string)$slots[0]['time'];
            $ctx['repeat'] = (string)$slots[0]['repeat'];
            $ctx['slots'] = $slots;
        }
        $ctx['booking_format'] = e360_resolve_booking_format($ctx);
        $order->update_meta_data('_e360_booking_context', $ctx);
    }

}, 20, 1);

// Сохранение в user meta (если юзер залогинен)
add_action('woocommerce_checkout_update_user_meta', function($customer_id){

    if (!$customer_id) return;

    $ref = isset($_POST['e360_referral_source']) ? sanitize_text_field(wp_unslash($_POST['e360_referral_source'])) : '';
    $birth = isset($_POST['e360_birthdate']) ? sanitize_text_field(wp_unslash($_POST['e360_birthdate'])) : '';
    $has_whatsapp = !empty($_POST['e360_has_whatsapp']) ? 'yes' : 'no';
    $wa_number = isset($_POST['e360_whatsapp_number']) ? sanitize_text_field(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    if ($ref !== '') update_user_meta($customer_id, 'e360_referral_source', $ref);
    if ($birth !== '') update_user_meta($customer_id, 'e360_birthdate', $birth);
    update_user_meta($customer_id, 'e360_has_whatsapp', $has_whatsapp);
    if ($wa_number !== '') update_user_meta($customer_id, 'e360_whatsapp_number', $wa_number);

}, 20, 1);


add_action('woocommerce_admin_order_data_after_billing_address', function($order){

    $ref  = $order->get_meta('_e360_referral_source');
    $birth = $order->get_meta('_e360_birthdate');
    $has = $order->get_meta('_e360_has_whatsapp');
    $wa  = $order->get_meta('_e360_whatsapp_number');

    echo '<div style="margin-top:10px;padding-top:10px;border-top:1px solid #eee;">';
    echo '<h4 style="margin:0 0 6px;">English360</h4>';
    if ($ref)   echo '<p><strong>Referral:</strong> ' . esc_html($ref) . '</p>';
    if ($birth) echo '<p><strong>Birthday:</strong> ' . esc_html($birth) . '</p>';
    echo '<p><strong>Has WhatsApp:</strong> ' . esc_html($has === 'yes' ? 'Yes' : 'No') . '</p>';
    if ($wa)    echo '<p><strong>WhatsApp number:</strong> ' . esc_html($wa) . '</p>';
    
    $ctx = $order->get_meta('_e360_booking_context');
    $order_credits_total = 0;
    foreach ($order->get_items('line_item') as $item) {
        $pid = (int) ($item->get_variation_id() ?: $item->get_product_id());
        if ($pid <= 0) continue;
        $qty = (int) $item->get_quantity();
        if ($qty <= 0) $qty = 1;
        $order_credits_total += (e360_product_credits_for_display($pid) * $qty);
    }

    // Show booking context
    if (is_array($ctx) && !empty($ctx)) {
        echo '<div style="margin-top:10px;">';
        echo '<strong>Booking details:</strong><br>';
        $course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
        $teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
        $plan_credits = !empty($ctx['plan_product_id']) ? e360_product_credits_for_display((int)$ctx['plan_product_id']) : 0;
        $slot_labels = e360_ctx_slot_labels($ctx);
        echo '<p><strong>Course:</strong> ' . esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))) . '</p>';
        echo '<p><strong>Teacher:</strong> ' . esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? ''))) . '</p>';
        if (count($slot_labels) > 1) {
            echo '<p><strong>Schedule:</strong><br>' . wp_kses_post(e360_ctx_slot_html($ctx)) . '</p>';
        } else {
            echo '<p><strong>Date/time:</strong> ' . esc_html($slot_labels ? $slot_labels[0] : (($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5))) . '</p>';
        }
        if (!empty($ctx['plan_product_id'])) {
            $plan_title = function_exists('wc_get_product') ? (wc_get_product($ctx['plan_product_id'])->get_name() ?? '') : '';
            echo '<p><strong>Package:</strong> ' . esc_html($plan_title) . '</p>';
        }
        if ($plan_credits > 0) {
            echo '<p><strong>Credits (lessons):</strong> ' . esc_html((string)$plan_credits) . '</p>';
        } elseif ($order_credits_total > 0) {
            echo '<p><strong>Credits (lessons):</strong> ' . esc_html((string)$order_credits_total) . '</p>';
        }
        $format_label = e360_booking_format_label(e360_resolve_booking_format($ctx));
        if ($format_label) {
            echo '<p><strong>Format:</strong> ' . esc_html($format_label) . '</p>';
        }
        echo '<p><strong>Type:</strong> ' . esc_html(($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly') . '</p>';
        echo '</div>';
    } elseif ($order_credits_total > 0) {
        echo '<p><strong>Credits (lessons):</strong> ' . esc_html((string)$order_credits_total) . '</p>';
    }
    echo '</div>';

});

/**
 * WooCommerce -> Settings -> English360 tab
 */
add_filter('woocommerce_settings_tabs_array', function($tabs) {
    $tabs['e360'] = 'English360';
    return $tabs;
}, 50);

add_action('woocommerce_settings_tabs_e360', function() {
    woocommerce_admin_fields(e360_wc_settings_fields());
});

add_action('woocommerce_update_options_e360', function() {
    // Небольшая доп.санитизация textarea (на всякий)
    if (isset($_POST['e360_referral_sources'])) {
        $_POST['e360_referral_sources'] = wp_unslash($_POST['e360_referral_sources']);
    }
    woocommerce_update_options(e360_wc_settings_fields());
});

function e360_wc_settings_fields() {
    return [
        [
            'title' => 'English360 settings',
            'type'  => 'title',
            'id'    => 'e360_settings_section',
            'desc'  => 'Admin-controlled fields used on checkout.',
        ],

        [
            'title' => 'How did you hear about us? (options)',
            'id'    => 'e360_referral_sources',
            'type'  => 'textarea',
            'css'   => 'min-width:420px;height:160px;',
            'desc'  => "One option per line.\nExample:\nGoogle\nInstagram\nFriend referral",
            'default' => '',
        ],

        [
            'type' => 'sectionend',
            'id'   => 'e360_settings_section',
        ],
    ];
}

add_action('wp_footer', function () {
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    // студент = НЕ instructor и НЕ admin
    if (current_user_can('tutor_instructor') || current_user_can('manage_options')) return;

    ?>
<style>
/* названия классов могут отличаться по теме/версии — это safe вариант: скрываем любые кнопки “complete” */
.tutor-lesson-complete,
.tutor-course-complete,
button[name*="complete"],
a[href*="complete"],
[data-action*="complete"] {
    display: none !important;
}
</style>
<?php
});


add_action('tutor_dashboard/before/container', function($page){
    if ($page !== 'dashboard') return;
    if (!is_user_logged_in()) return;

    $uid = get_current_user_id();
    $course_id = (int) get_user_meta($uid, 'e360_primary_course_id', true);
    if (!$course_id) return;

    $bal  = e360_get_credits_balance($uid, $course_id);
    $used = e360_get_credits_used($uid, $course_id);

    // студент
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        echo '<div style="margin:0 0 12px;padding:12px;border:1px solid #e5e5e5;border-radius:10px;">';
        echo '<strong>Lessons remaining:</strong> ' . esc_html($bal) . ' ';
        echo '<span style="opacity:.7;">(completed: ' . esc_html($used) . ')</span>';
        echo '</div>';
    }
}, 10, 1);


add_action('wp_footer', function(){
    if (!is_user_logged_in()) return;

    // иногда Tutor кладёт slug страницы в body class: tutor-dashboard-page-availability
    if (!is_admin() && strpos((string)implode(' ', get_body_class()), 'tutor-dashboard-page-availability') !== false) {
        echo '<style>
            /* подстрой селекторы под реальную разметку на странице */
            .tutor-dashboard-content .tutor-scheduling-wrap,
            .tutor-dashboard-content .tutor-availability-wrap {
                display:none !important;
            }
        </style>';
    }
});



add_action('tutor_dashboard/before/container', function($page){
    if ($page !== 'dashboard') return;
    if (!is_user_logged_in()) return;

    $teacher_id = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    $students = get_users([
        'number' => 50,
        'fields' => ['ID','display_name','user_email'],
        'meta_key' => 'e360_primary_teacher_id',
        'meta_value' => $teacher_id,
    ]);

    if (!$students) return;

    echo '<div style="margin:0 0 12px;padding:12px;border:1px solid #e5e5e5;border-radius:10px;">';
    echo '<strong>Your students (lessons remaining)</strong>';
    echo '<div style="margin-top:8px;">';

    foreach ($students as $s) {
        $bal  = e360_get_credits_balance($s->ID);
        $used = e360_get_credits_used($s->ID);

        // имя без фамилии: берём first_name и первую букву last_name, иначе display_name
        $first = get_user_meta($s->ID, 'first_name', true);
        $last  = get_user_meta($s->ID, 'last_name', true);
        $label = $first ? ($first . ($last ? ' ' . mb_substr($last,0,1) . '.' : '')) : $s->display_name;

        echo '<div style="display:flex;gap:10px;justify-content:space-between;border-top:1px solid #f0f0f0;padding:8px 0;">';
        echo '<div>' . esc_html($label) . '</div>';
        echo '<div><strong>' . esc_html($bal) . '</strong> remaining <span style="opacity:.7;">(completed: ' . esc_html($used) . ')</span></div>';
        echo '</div>';
    }

    echo '</div></div>';
}, 20, 1);

/**
 * Detect Tutor dashboard availability page
 */
function e360_is_tutor_availability_page($dashboard_page_name = ''): bool {
    $dashboard_page_name = (string) $dashboard_page_name;

    // If Tutor passes page name
    if ($dashboard_page_name !== '' && stripos($dashboard_page_name, 'availability') !== false) {
        return true;
    }

    // Fallback by URL
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return (strpos($uri, '/dashboard/availability') !== false);
}

/**
 * Render our availability UI and hide Tutor original block
 */
function e360_render_availability_override(): void {
    if (!is_user_logged_in()) return;

    // только учитель/админ
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    // маркер для проверки в исходнике страницы
    echo "\n<!-- e360 availability override -->\n";

    // скрываем оригинальный Tutor LMS блок
    echo '<style>
        .tutor-dashboard-content .tutor-scheduling-availability { display:none !important; }
    </style>';

    // показываем наш UI
    echo '<div style="margin:0 0 14px;">' . do_shortcode('[e360_teacher_calendar_settings]') . '</div>';
}

/**
 * Main hook (recommended) — Tutor passes dashboard page name here
 */
add_action('tutor_load_dashboard_template_before', function($dashboard_page_name){
    if (!e360_is_tutor_availability_page($dashboard_page_name)) return;
    e360_render_availability_override();
}, 5, 1);

/**
 * Fallback hook — if the one above doesn’t exist in your Tutor version
 */
add_action('tutor_dashboard/before/wrap', function(){
    if (!e360_is_tutor_availability_page('')) return;
    e360_render_availability_override();
}, 5);