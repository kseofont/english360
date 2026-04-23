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

function e360_booking_nonce_valid(): bool {
    $nonce = isset($_REQUEST['nonce']) ? sanitize_text_field(wp_unslash((string) $_REQUEST['nonce'])) : '';
    if ($nonce === '') {
        return false;
    }

    return (bool) wp_verify_nonce($nonce, 'e360_booking_nonce');
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

function e360_teacher_is_bookable_for_wizard(int $user_id): bool {
    if ($user_id <= 0) {
        return false;
    }

    if (user_can($user_id, 'manage_options')) {
        return true;
    }

    $status = sanitize_key((string) get_user_meta($user_id, '_tutor_instructor_status', true));
    if ($status !== '') {
        return $status === 'approved';
    }

    $is_instructor = user_can($user_id, 'tutor_instructor') || (bool) get_user_meta($user_id, '_is_tutor_instructor', true);
    if ($is_instructor) {
        // Some instructors do not have explicit status meta saved yet.
        // In that case treat them as available instead of silently hiding them.
        return true;
    }

    return true;
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

function e360_get_teacher_profile_fields(int $user_id): array {
    $headline = trim((string) get_user_meta($user_id, 'e360_teacher_headline', true));
    $intro = trim((string) get_user_meta($user_id, 'e360_teacher_intro', true));
    $country = trim((string) get_user_meta($user_id, 'e360_teacher_country', true));
    $languages = trim((string) get_user_meta($user_id, 'e360_teacher_languages', true));
    $price = trim((string) get_user_meta($user_id, 'e360_teacher_price', true));
    $price_label = trim((string) get_user_meta($user_id, 'e360_teacher_price_label', true));
    $badges = trim((string) get_user_meta($user_id, 'e360_teacher_badges', true));
    $rating = trim((string) get_user_meta($user_id, 'e360_teacher_rating', true));
    $intro_video = trim((string) get_user_meta($user_id, 'e360_teacher_intro_video', true));
    $native_language = trim((string) get_user_meta($user_id, 'e360_teacher_native_language', true));
    $featured = !empty(get_user_meta($user_id, 'e360_teacher_featured', true));

    if ($intro === '') {
        $intro = e360_teacher_bio_snippet($user_id, 180);
    }

    if ($price_label === '') {
        $price_label = 'lesson';
    }

    return [
        'headline'        => $headline,
        'intro'           => $intro,
        'country'         => $country,
        'languages'       => $languages,
        'price'           => $price,
        'price_label'     => $price_label,
        'badges'          => $badges,
        'rating'          => $rating,
        'intro_video'     => $intro_video,
        'native_language' => $native_language,
        'featured'        => $featured ? '1' : '',
    ];
}

function e360_get_instructor_front_profile_fields_schema(): array {
    return [
        'e360_teacher_headline' => [
            'label'       => 'Professional Headline',
            'type'        => 'text',
            'placeholder' => 'Certified English tutor for beginners and kids',
        ],
        'e360_teacher_intro' => [
            'label'       => 'Short Intro',
            'type'        => 'textarea',
            'placeholder' => 'A short intro for your teacher card',
        ],
        'e360_teacher_country' => [
            'label'       => 'Country',
            'type'        => 'text',
            'placeholder' => 'Portugal',
        ],
        'e360_teacher_languages' => [
            'label'       => 'Languages Spoken',
            'type'        => 'text',
            'placeholder' => 'English (Native), Portuguese (B2)',
        ],
        'e360_teacher_native_language' => [
            'label'       => 'Native Language',
            'type'        => 'text',
            'placeholder' => 'English',
        ],
        'e360_teacher_rating' => [
            'label'       => 'Teacher Rating',
            'type'        => 'number',
            'placeholder' => '4.9',
            'step'        => '0.1',
            'min'         => '0',
            'max'         => '5',
        ],
        'e360_teacher_price' => [
            'label'       => 'Price per Lesson',
            'type'        => 'number',
            'placeholder' => '25',
            'step'        => '0.01',
            'min'         => '0',
        ],
        'e360_teacher_price_label' => [
            'label'       => 'Price Label',
            'type'        => 'text',
            'placeholder' => '50-min lesson',
        ],
        'e360_teacher_badges' => [
            'label'       => 'Badges',
            'type'        => 'text',
            'placeholder' => 'Professional, Kids specialist',
        ],
        'e360_teacher_intro_video' => [
            'label'       => 'Intro Video URL',
            'type'        => 'url',
            'placeholder' => 'https://www.youtube.com/watch?v=...',
        ],
        'e360_teacher_featured' => [
            'label' => 'Featured Tutor',
            'type'  => 'checkbox',
        ],
    ];
}

function e360_teacher_intro_video_embed_url(string $url): string {
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    $parts = wp_parse_url($url);
    if (!is_array($parts)) {
        return '';
    }

    $host = strtolower((string) ($parts['host'] ?? ''));
    $path = (string) ($parts['path'] ?? '');
    parse_str((string) ($parts['query'] ?? ''), $query);

    if (strpos($host, 'youtu.be') !== false) {
        $video_id = trim($path, '/');
        return $video_id !== '' ? 'https://www.youtube.com/embed/' . rawurlencode($video_id) : '';
    }

    if (strpos($host, 'youtube.com') !== false) {
        $video_id = sanitize_text_field((string) ($query['v'] ?? ''));
        if ($video_id === '' && preg_match('#/embed/([^/?]+)#', $path, $m)) {
            $video_id = sanitize_text_field((string) ($m[1] ?? ''));
        }
        return $video_id !== '' ? 'https://www.youtube.com/embed/' . rawurlencode($video_id) : '';
    }

    if (strpos($host, 'vimeo.com') !== false && preg_match('#/(\d+)#', $path, $m)) {
        return 'https://player.vimeo.com/video/' . rawurlencode((string) $m[1]);
    }

    return '';
}


function e360_course_base_title(string $title): string {
    $t = trim($title);

    // отрежем " — Teacher", " - Teacher", " – Teacher"
    $t = preg_split('/\s[—–-]\s/u', $t)[0] ?? $t;

    return trim($t);
}

function e360_booking_placeholder_image_url(): string {
    if (function_exists('e360_course_placeholder_image_url')) {
        return (string) e360_course_placeholder_image_url();
    }
    return 'https://lms.english360.ca/wp-content/uploads/2026/02/course-placeholder-english360.png';
}

function e360_booking_prefill_from_course(int $course_id, string $taxonomy = 'course-category'): array {
    $result = [
        'course_id' => $course_id,
        'language_term_id' => 0,
        'level_term_id' => 0,
    ];
    if ($course_id <= 0) {
        return $result;
    }

    $terms = wp_get_post_terms($course_id, $taxonomy, ['fields' => 'all']);
    if (is_wp_error($terms) || !$terms) {
        return $result;
    }

    foreach ($terms as $term) {
        $parent = (int) $term->parent;
        if ($parent > 0 && $result['level_term_id'] === 0) {
            $result['level_term_id'] = (int) $term->term_id;
            $result['language_term_id'] = $parent;
            break;
        }
    }

    if ($result['language_term_id'] === 0) {
        foreach ($terms as $term) {
            if ((int) $term->parent === 0) {
                $result['language_term_id'] = (int) $term->term_id;
                break;
            }
        }
    }

    return $result;
}

function e360_get_courses_by_term() {
    if (is_user_logged_in() && !e360_booking_nonce_valid()) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

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
        $course_image = get_the_post_thumbnail_url($course_post_id, 'medium_large');
        if (!$course_image) {
            $course_image = e360_booking_placeholder_image_url();
        }

        if (!isset($groups[$key])) {
            $groups[$key] = [
                'course_key'   => $key,
                'course_title' => $base_title,
                'image_url'    => $course_image,
                'course_ids'   => [],
                'variants'     => [],
                '_seen'        => [],
            ];
        } elseif (empty($groups[$key]['image_url']) && !empty($course_image)) {
            $groups[$key]['image_url'] = $course_image;
        }
        if (!in_array($course_post_id, $groups[$key]['course_ids'], true)) {
            $groups[$key]['course_ids'][] = $course_post_id;
        }

        $author_id = (int) $p->post_author;
        $instructor_ids = e360_get_course_instructor_ids($course_post_id);

        foreach ($instructor_ids as $tid) {
            $variant_key = $course_post_id . ':' . $tid;
            if (isset($groups[$key]['_seen'][$variant_key])) continue;
            $groups[$key]['_seen'][$variant_key] = 1;
            if (!e360_teacher_is_bookable_for_wizard($tid)) continue;

            $u = get_user_by('id', $tid);
            if (!$u) continue;

            $bio_html = e360_teacher_bio_html($tid);
            $bio_snip = e360_teacher_bio_snippet($tid, 140);
            $headline = trim((string) get_user_meta($tid, 'e360_teacher_headline', true));
            $intro = trim((string) get_user_meta($tid, 'e360_teacher_intro', true));
            $country = trim((string) get_user_meta($tid, 'e360_teacher_country', true));
            $languages = trim((string) get_user_meta($tid, 'e360_teacher_languages', true));
            $rating = trim((string) get_user_meta($tid, 'e360_teacher_rating', true));
            $price = trim((string) get_user_meta($tid, 'e360_teacher_price', true));
            $price_label = trim((string) get_user_meta($tid, 'e360_teacher_price_label', true));
            $badges = trim((string) get_user_meta($tid, 'e360_teacher_badges', true));
            $featured = (string) get_user_meta($tid, 'e360_teacher_featured', true) === '1';
            $native_language = trim((string) get_user_meta($tid, 'e360_teacher_native_language', true));
            $intro_video = trim((string) get_user_meta($tid, 'e360_teacher_intro_video', true));
            $intro_video_embed = e360_teacher_intro_video_embed_url($intro_video);

            $groups[$key]['variants'][] = [
                'course_id'        => $course_post_id,          // один и тот же course post
                'course_title'     => get_the_title($course_post_id),
                'teacher_id'       => $tid,                     // может быть author или attached instructor
                'teacher_name'     => e360_teacher_public_name($u),
                'teacher_avatar'   => get_avatar_url($tid, ['size' => 96]),
                'teacher_bio'      => $bio_snip,                // текстовое превью
                'teacher_bio_html' => $bio_html,                // полный HTML (safe)
                'teacher_role'     => ($tid === $author_id) ? 'Author' : 'Instructor',
                'teacher_headline' => $headline,
                'teacher_intro'    => $intro,
                'teacher_country'  => $country,
                'teacher_languages'=> $languages,
                'teacher_rating'   => $rating,
                'teacher_price'    => $price,
                'teacher_price_label' => $price_label,
                'teacher_badges'   => $badges,
                'teacher_featured' => $featured ? 1 : 0,
                'teacher_native_language' => $native_language,
                'teacher_intro_video' => esc_url_raw($intro_video),
                'teacher_intro_video_embed' => esc_url_raw($intro_video_embed),
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
    if (is_user_logged_in() && !e360_booking_nonce_valid()) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

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

        $items[$tid] = [
            'days'     => $out_days,
            'timezone' => $student_tz,
        ];
    }

    wp_send_json_success(['items' => $items]);
}


add_action('wp_ajax_e360_get_slots', 'e360_get_slots');
add_action('wp_ajax_nopriv_e360_get_slots', 'e360_get_slots');

function e360_get_slots() {
    if (is_user_logged_in() && !e360_booking_nonce_valid()) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

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

function e360_decode_slots_param(string $slots_param): array {
    $raw = trim($slots_param);
    if ($raw === '') {
        return [];
    }

    $candidates = [$raw];
    $decoded_once = rawurldecode($raw);
    if ($decoded_once !== $raw) {
        $candidates[] = $decoded_once;
    }
    $decoded_twice = rawurldecode($decoded_once);
    if ($decoded_twice !== $decoded_once) {
        $candidates[] = $decoded_twice;
    }

    foreach ($candidates as $candidate) {
        $json = json_decode($candidate, true);
        if (is_array($json)) {
            return $json;
        }
    }

    return [];
}

function e360_build_booking_context_from_request(array $source): array {
    $ctx = [
        'language_term_id' => (int)($source['language_term_id'] ?? 0),
        'level_term_id'    => (int)($source['level_term_id'] ?? 0),
        'course_id'        => (int)($source['course_id'] ?? 0),
        'teacher_id'       => (int)($source['teacher_id'] ?? 0),
        'date'             => sanitize_text_field((string)($source['date'] ?? '')),
        'time'             => sanitize_text_field((string)($source['time'] ?? '')),
        'plan_product_id'  => (int)($source['plan_product_id'] ?? 0),
        'duration'         => (int)($source['duration'] ?? 60),
        'repeat'           => (($source['repeat'] ?? '') === 'once') ? 'once' : 'weekly',
        'booking_format'   => e360_resolve_booking_format($source),
        'created_at'       => current_time('mysql'),
    ];

    if ($ctx['duration'] <= 0) {
        $ctx['duration'] = 60;
    }

    $slots_raw = $source['slots'] ?? [];
    if (is_string($slots_raw)) {
        $slots_raw = e360_decode_slots_param($slots_raw);
    }

    $ctx['slots'] = e360_sanitize_ctx_slots($slots_raw, $ctx['repeat'], (int)$ctx['duration']);
    if (!$ctx['slots'] && $ctx['date'] !== '' && $ctx['time'] !== '') {
        $ctx['slots'] = [[
            'date' => $ctx['date'],
            'time' => substr((string)$ctx['time'], 0, 5),
            'repeat' => $ctx['repeat'],
            'duration' => (int)$ctx['duration'],
        ]];
    }

    if ($ctx['slots']) {
        $ctx['date'] = (string)$ctx['slots'][0]['date'];
        $ctx['time'] = (string)$ctx['slots'][0]['time'];
        $ctx['repeat'] = (string)$ctx['slots'][0]['repeat'];
    }

    return $ctx;
}

function e360_store_booking_context_and_prepare_checkout(int $user_id, array $ctx): array {
    $clean = e360_build_booking_context_from_request($ctx);

    if ($clean['course_id'] <= 0 || $clean['teacher_id'] <= 0 || !$clean['slots'] || $clean['plan_product_id'] <= 0) {
        return ['ok' => false, 'message' => 'Missing required fields.'];
    }

    update_user_meta($user_id, 'e360_booking_context', $clean);
    update_user_meta($user_id, 'e360_primary_teacher_id', $clean['teacher_id']);
    update_user_meta($user_id, 'e360_primary_course_id', $clean['course_id']);

    if (!function_exists('WC') || !WC()->cart) {
        return ['ok' => false, 'message' => 'WooCommerce cart is unavailable.'];
    }

    WC()->session->set('e360_course_id', (int)$clean['course_id']);
    WC()->cart->empty_cart();
    WC()->cart->add_to_cart((int)$clean['plan_product_id'], 1, 0, [], [
        'e360_course_id' => (int)$clean['course_id'],
        'e360_booking_context' => $clean,
    ]);

    $checkout_url = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');

    return [
        'ok' => true,
        'ctx' => $clean,
        'checkout_url' => $checkout_url,
    ];
}

function e360_count_courses_for_language_term(int $term_id, string $taxonomy): int {
    if ($term_id <= 0 || $taxonomy === '') {
        return 0;
    }

    $term_ids = [$term_id];
    $children = get_term_children($term_id, $taxonomy);
    if (!is_wp_error($children) && is_array($children) && $children) {
        $term_ids = array_merge($term_ids, array_map('intval', $children));
    }

    $q = new WP_Query([
        'post_type'      => ['courses', 'tutor_course'],
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'tax_query'      => [[
            'taxonomy'         => $taxonomy,
            'field'            => 'term_id',
            'terms'            => array_values(array_unique($term_ids)),
            'include_children' => true,
        ]],
    ]);

    $count = (int) $q->found_posts;
    wp_reset_postdata();

    return $count;
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

    $result = e360_store_booking_context_and_prepare_checkout($uid, $ctx);
    if (!$result['ok']) {
        wp_send_json_error(['message' => $result['message']], 400);
    }

    wp_send_json_success(['checkout_url' => $result['checkout_url']]);
});

add_shortcode('e360_booking_wizard', function($atts){
    $atts = shortcode_atts([
        'taxonomy'        => 'course-category',
        'duration'        => 60,
        'registration_url'=> 'https://lms.english360.ca/student-registration/',
        'only_parent_terms' => 1,
        'other_language_form_shortcode' => '',
        'other_language_form_id' => '',
        'other_language_form_title' => '',
    ], $atts);

    $taxonomy = sanitize_key($atts['taxonomy']);
    $duration = (int) $atts['duration'];
    $registration_url = esc_url_raw($atts['registration_url']);
    $only_parent = (int) $atts['only_parent_terms'];
    $other_language_form_shortcode = (string) $atts['other_language_form_shortcode'];
    $other_language_form_id = sanitize_text_field((string) $atts['other_language_form_id']);
    $other_language_form_title = sanitize_text_field((string) $atts['other_language_form_title']);

    if ($other_language_form_shortcode === '' && $other_language_form_id !== '') {
        $other_language_form_shortcode = sprintf(
            '[contact-form-7 id="%s"%s]',
            esc_attr($other_language_form_id),
            $other_language_form_title !== '' ? ' title="' . esc_attr($other_language_form_title) . '"' : ''
        );
    }

    $term_args = [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ];
    if ($only_parent) $term_args['parent'] = 0;

    $languages = get_terms($term_args);
    if (is_wp_error($languages)) return '<p>Cannot load languages.</p>';

    wp_enqueue_script('jquery');
    wp_enqueue_style(
        'e360-booking-wizard',
        E360_LESSONS_URL . 'assets/css/booking-wizard.css',
        [],
        '0.1.0'
    );
    $nonce = wp_create_nonce('e360_booking_nonce');
    $placeholder = e360_booking_placeholder_image_url();
    $prefill_course_id = isset($_GET['course_id']) ? (int) $_GET['course_id'] : 0;
    $prefill = e360_booking_prefill_from_course($prefill_course_id, $taxonomy);
    $prefill_lang_qs = isset($_GET['language_term_id']) ? (int) $_GET['language_term_id'] : 0;
    $prefill_level_qs = isset($_GET['level_term_id']) ? (int) $_GET['level_term_id'] : 0;
    if ($prefill_lang_qs > 0) {
        $prefill['language_term_id'] = $prefill_lang_qs;
    }
    if ($prefill_level_qs > 0) {
        $prefill['level_term_id'] = $prefill_level_qs;
    }

    ob_start();
    ?>
<div class="e360-booking-wizard-area">
    <div class="container">
        <div id="e360-wizard" data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
            data-duration="<?php echo esc_attr($duration); ?>"
            data-registration-url="<?php echo esc_attr($registration_url); ?>"
            data-is-logged-in="<?php echo is_user_logged_in() ? '1' : '0'; ?>">
            <h2 class="e360-step-title">What language would you like to learn?</h2>
            <div id="e360-language" class="e360-language-cards">
                <div class="row g-3">
                    <?php foreach ($languages as $t): ?>
                    <?php
                        $term_id = (int) $t->term_id;
                        $thumb_id = get_term_meta($term_id, 'thumbnail_id', true);
                        $img = '';
                        $course_count = e360_count_courses_for_language_term($term_id, $taxonomy);
                        if ($thumb_id) $img = wp_get_attachment_image_url($thumb_id, 'medium');
                        if (!$img) $img = $placeholder;
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="single-courses-box e360-choice-card e360-language-card e360-language-card-row"
                            data-term-id="<?php echo $term_id; ?>">
                            <div class="e360-language-thumb">
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($t->name); ?>">
                            </div>
                            <div class="content e360-language-content">
                                <h3><span><?php echo esc_html($t->name); ?></span></h3>
                                <div class="e360-language-count"><?php echo esc_html($course_count); ?>
                                    course<?php echo $course_count === 1 ? '' : 's'; ?></div>
                            </div>
                            <div class="e360-language-arrow" aria-hidden="true">&gt;</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="single-courses-box e360-choice-card e360-language-card e360-language-card-row e360-other-language-card"
                            data-term-id="other-language" data-other-language="1">
                            <div class="e360-language-thumb">
                                <img src="<?php echo esc_url($placeholder); ?>" alt="Other language">
                            </div>
                            <div class="content e360-language-content">
                                <h3><span>Other language</span></h3>
                                <div class="e360-language-count">Request a custom language</div>
                            </div>
                            <div class="e360-language-arrow" aria-hidden="true">&gt;</div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="e360-step-other-language" style="display:none;">
                <h2 class="e360-step-title">Tell us which language you need</h2>
                <div id="e360-other-language-form" class="e360-other-language-form-wrap">
                    <?php if ($other_language_form_shortcode !== ''): ?>
                    <?php echo do_shortcode($other_language_form_shortcode); ?>
                    <?php else: ?>
                    <div class="e360-other-language-placeholder">
                        Add your Contact Form 7 shortcode to `other_language_form_shortcode` in `[e360_booking_wizard]`.
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="e360-step-level" style="display:none;">
                <h2 class="e360-step-title">What's your level?</h2>
                <div id="e360-level" class="e360-level-cards">
                    <div class="row g-3">
                        <div class="col-12" style="opacity:.7">Select language first…</div>
                    </div>
                </div>
            </div>

            <div id="e360-step-course" style="display:none;">
                <h2 class="e360-step-title">Choose the course</h2>
                <div id="e360-course" class="e360-course-cards">
                    <div class="row g-3">
                        <div class="col-12" style="opacity:.7">Select level first…</div>
                    </div>
                </div>

                <div id="e360-teacher-list" style="margin:10px 0;"></div>
            </div>

            <div id="e360-step-offer" style="display:none;">
                <div id="e360-offer-storage">
                    <div id="e360-inline-offer-ui">
                        <div style="margin-top:8px;">
                            <label style="display:block;margin-bottom:8px;font-weight:600;">Choose format</label>
                            <div id="e360-purchase-options"
                                style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;">
                                <button type="button" class="e360-purchase-card tutor-btn tutor-btn-outline-primary"
                                    data-plan-kind="trial">Trial lesson</button>
                                <button type="button" class="e360-purchase-card tutor-btn tutor-btn-outline-primary"
                                    data-plan-kind="package">Buy a package</button>
                            </div>
                        </div>

                        <div id="e360-plan-wrap" style="display:none;margin-top:12px;">
                            <label style="display:block;margin-bottom:8px;">Choose package</label>
                            <div id="e360-plan-options"
                                style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;"></div>
                        </div>

                        <div id="e360-offer-msg" style="margin-top:10px;opacity:.85;"></div>
                    </div>
                </div>
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
                <p id="e360-repeat-wrap" style="display:none;">
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
    </div>
</div>

<div id="e360-teacher-video-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.58);z-index:99999;padding:20px;">
    <div style="max-width:880px;margin:40px auto;background:#fff;border-radius:18px;padding:18px;position:relative;">
        <button type="button" class="e360-teacher-video-close tutor-iconic-btn" style="position:absolute;top:12px;right:12px;"><span class="tutor-icon-times"></span></button>
        <div style="padding-right:40px;">
            <div id="e360-teacher-video-title" style="font-size:22px;font-weight:700;color:#0f1720;">Teacher intro video</div>
        </div>
        <div id="e360-teacher-video-content" style="margin-top:16px;"></div>
    </div>
</div>

<div id="e360-teacher-schedule-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.58);z-index:99999;padding:20px;">
    <div style="max-width:980px;margin:40px auto;background:#fff;border-radius:18px;padding:18px;position:relative;">
        <button type="button" class="e360-teacher-schedule-close tutor-iconic-btn" style="position:absolute;top:12px;right:12px;"><span class="tutor-icon-times"></span></button>
        <div style="padding-right:40px;">
            <div id="e360-teacher-schedule-title" style="font-size:22px;font-weight:700;color:#0f1720;">Teacher schedule</div>
        </div>
        <div id="e360-teacher-schedule-content" style="margin-top:16px;"></div>
    </div>
</div>

<script>
jQuery(function($) {
    const nonce = <?php echo json_encode($nonce); ?>;
    const ajaxurl = <?php echo json_encode(admin_url('admin-ajax.php')); ?>;
    const placeholderImage = <?php echo json_encode($placeholder); ?>;
    const prefill = <?php echo wp_json_encode($prefill); ?>;

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

    function escapeHtml(value) {
        return $('<div>').text(value || '').html();
    }

    function resetAfterLanguage() {
        // visually unselect any language cards
        $('.e360-language-card').removeClass('e360-language-selected');
        $('.e360-level-card').removeClass('e360-level-selected');
        $('.e360-course-card').removeClass('e360-course-selected');
        $('#e360-step-other-language').hide();
        $('#e360-level').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Select language first…</div></div>'
            );
        $('#e360-course').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Select level first…</div></div>');
        $('#e360-teacher-list').empty();
        $('#e360-step-offer').hide();
        $('#e360-offer-msg').text('');
        $('#e360-plan-wrap').hide();
        $('#e360-plan-options').html('');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-level, #e360-step-course, #e360-step-offer, #e360-step-time').hide();
        selected.level_term_id = selected.course_id = selected.teacher_id = null;
        selected.teacher_name = selected.course_title = null;
        selected.date = selected.time = null;
        selected.plan_product_id = null;
        selected.plan_kind = null;
        selected.language_term_id = null;
        selected.repeat = 'weekly';
        selected.slots = [];
    }

    function resetAfterLevel() {
        // keep selected level visible; only reset lower steps
        $('.e360-course-card').removeClass('e360-course-selected');
        $('#e360-course').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Loading…</div></div>');
        $('#e360-teacher-list').empty();
        $('#e360-step-offer').hide();
        $('#e360-offer-msg').text('');
        $('#e360-plan-wrap').hide();
        $('#e360-plan-options').html('');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-course').show();
        $('#e360-step-offer').hide();
        $('#e360-step-time').hide();
        selected.course_key = null;
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

    function moveOfferUiToStorage() {
        const $ui = $('#e360-inline-offer-ui');
        const $storage = $('#e360-offer-storage');
        if ($ui.length && $storage.length && !$storage.find('#e360-inline-offer-ui').length) {
            $storage.append($ui);
        }
        $('.e360-teacher-offer-host').hide().empty();
    }

    function mountOfferUiIntoSelectedTeacherCard() {
        const $selectedCard = $('.e360-teacher-card.e360-teacher-selected').first();
        const $host = $selectedCard.find('.e360-teacher-offer-host').first();
        const $ui = $('#e360-inline-offer-ui');

        if (!$selectedCard.length || !$host.length || !$ui.length) {
            moveOfferUiToStorage();
            return;
        }

        $host.show().append($ui);
    }

    function scrollStepTitleIntoView(stepSelector) {
        const $title = $(stepSelector).find('.e360-step-title').first();
        if (!$title.length) return;

        $('html, body').animate({
            scrollTop: Math.max($title.offset().top - 24, 0)
        }, 300);
    }

    function scrollElementIntoView(selector, offset) {
        const $target = $(selector).first();
        if (!$target.length) return;

        $('html, body').animate({
            scrollTop: Math.max($target.offset().top - (offset || 24), 0)
        }, 300);
    }

    function clearValidationErrors() {
        $('#e360-wizard .e360-validation-error').removeClass('e360-validation-error');
        $('#e360-wizard .e360-validation-error-section').removeClass('e360-validation-error-section');
    }

    function buildTeacherIntroVideoMarkup(embedUrl, directUrl) {
        const safeEmbedUrl = (embedUrl || '').toString().trim();
        const safeDirectUrl = (directUrl || '').toString().trim();

        if (safeEmbedUrl) {
            return `<div style="border-radius:16px;overflow:hidden;background:#0f1720;">
                <div style="position:relative;padding-top:56.25%;">
                    <iframe src="${escapeHtml(safeEmbedUrl)}" title="Teacher intro video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;border:0;"></iframe>
                </div>
            </div>`;
        }

        if (safeDirectUrl) {
            const videoUrl = escapeHtml(safeDirectUrl);
            const isDirectVideo = /\.(mp4|webm|ogg)(\?.*)?$/i.test(safeDirectUrl);
            if (isDirectVideo) {
                return `<div style="border-radius:16px;overflow:hidden;background:#0f1720;">
                    <video controls preload="metadata" style="display:block;width:100%;height:auto;max-height:70vh;">
                        <source src="${videoUrl}">
                    </video>
                </div>`;
            }
            return `<div style="padding:12px 0;">
                <a href="${videoUrl}" target="_blank" rel="noopener noreferrer" class="tutor-btn tutor-btn-primary">Open intro video</a>
            </div>`;
        }

        return '<div style="color:#5f6b7a;">Video is not available.</div>';
    }

    function openTeacherIntroVideoModal(teacherName, embedUrl, directUrl) {
        $('#e360-teacher-video-title').text(teacherName ? (teacherName + ' · Intro video') : 'Teacher intro video');
        $('#e360-teacher-video-content').html(buildTeacherIntroVideoMarkup(embedUrl, directUrl));
        $('#e360-teacher-video-modal').show();
    }

    function closeTeacherIntroVideoModal() {
        $('#e360-teacher-video-content').html('');
        $('#e360-teacher-video-modal').hide();
    }

    function renderTeacherSchedulePreviewHtml(data, teacherId) {
        if (!data || !data.days) {
            return '<em>No schedule</em>';
        }

        let s = '<div style="font-weight:600;margin-bottom:4px;">Next 7 days</div>';
        if (data.timezone) {
            s += `<div style="margin-bottom:10px;font-size:13px;color:#5f6b7a;">All times are shown in your timezone: <strong>${escapeHtml(data.timezone)}</strong>.</div>`;
        }
        s += '<div class="e360-days-grid" style="display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px;">';

        data.days.forEach(function(d) {
            const dateObj = new Date(d.date);
            const weekday = dateObj.toLocaleDateString('en-US', { weekday: 'short' });
            const day = d.date.slice(5);
            const daySelected = (selected.slots || []).some(function(s) {
                return s && s.date === d.date;
            });
            const dayBorder = daySelected ? '#3e64de' : '#eee';
            s += `<div class="e360-day-card" data-date="${escapeHtml(d.date)}" style="border:1px solid ${dayBorder};border-radius:10px;padding:6px;">
                    <div style="font-size:12px;opacity:.8;">${escapeHtml(weekday)}, ${escapeHtml(day)}</div>`;
            if (d.times && d.times.length) {
                s += '<div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:6px;">';
                d.times.forEach(function(t) {
                    const isActive = (selected.slots || []).some(function(s) {
                        return s && s.date === d.date && s.time === t;
                    });
                    const btnStyle = isActive ?
                        'border:1px solid #3e64de;background:#eef3ff;color:#1f3fb4;' :
                        'border:1px solid #ddd;background:#fff;color:#222;';
                    const btnClass = isActive ? 'e360-slot-btn e360-slot-active' : 'e360-slot-btn';
                    s += `<button type="button" class="${btnClass}" data-date="${escapeHtml(d.date)}" data-time="${escapeHtml(t)}" data-teacher-id="${escapeHtml(String(teacherId || ''))}" style="font-size:12px;padding:2px 6px;border-radius:999px;cursor:pointer;${btnStyle}">${escapeHtml(t)}</button>`;
                });
                s += '</div>';
            } else {
                s += '<div style="font-size:12px;opacity:.6;margin-top:6px;">—</div>';
            }
            s += '</div>';
        });

        s += '</div>';
        s += '<div style="margin-top:12px;font-size:15px;font-weight:600;line-height:1.5;color:#15314b;">Click a time slot to select your lesson day and time.</div>';
        return s;
    }

    function fetchTeacherSchedulePreview(teacherId) {
        return $.post(ajaxurl, {
            action: 'e360_get_schedule_preview_bulk',
            nonce,
            duration: selected.duration,
            include_past_today: 0,
            teacher_ids: JSON.stringify([teacherId])
        });
    }

    function openTeacherScheduleModal(teacherId, teacherName) {
        if (!teacherId) return;
        $('#e360-teacher-schedule-title').text(teacherName ? (teacherName + ' · Schedule') : 'Teacher schedule');
        $('#e360-teacher-schedule-content').html('<em>Loading schedule…</em>');
        $('#e360-teacher-schedule-modal').show();

        fetchTeacherSchedulePreview(teacherId).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-teacher-schedule-content').html('<em>Schedule unavailable</em>');
                return;
            }
            const map = resp.data.items || {};
            const data = map[teacherId];
            $('#e360-teacher-schedule-content').html(renderTeacherSchedulePreviewHtml(data, teacherId));
            refreshSelectedScheduleUi();
        }).fail(function() {
            $('#e360-teacher-schedule-content').html('<em>Schedule unavailable</em>');
        });
    }

    function closeTeacherScheduleModal() {
        $('#e360-teacher-schedule-content').html('');
        $('#e360-teacher-schedule-modal').hide();
    }

    function syncSelectedSlotsToInputs() {
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
    }

    function renderPlansByKind(planKind) {
        const $planOptions = $('#e360-plan-options');
        const trialItems = plansIndex.filter(function(it) {
            return (it.plan_kind || '') === 'trial';
        });
        const otherItems = plansIndex.filter(function(it) {
            return (it.plan_kind || '') !== 'trial';
        });

        if (planKind === 'package') {
            $('#e360-plan-wrap').show();
            $planOptions.html('');
            selected.plan_product_id = null;
            if (!otherItems.length) {
                $('#e360-offer-msg').text('No package products configured.');
            } else {
                $('#e360-offer-msg').text('');
                otherItems.forEach(function(it) {
                    const title = escapeHtml(it.title || 'Package');
                    const price = it.price_text ? `<div style="margin-top:6px;font-size:14px;color:#15314b;font-weight:600;">${escapeHtml(it.price_text)}</div>` : '';
                    const credits = parseInt(it.credits_qty || 0, 10) > 0 ? `<div style="margin-top:4px;font-size:12px;color:#617083;">${escapeHtml(String(it.credits_qty))} lessons</div>` : '';
                    $planOptions.append(
                        `<button type="button" class="e360-plan-option-card tutor-btn tutor-btn-outline-primary" data-product-id="${escapeHtml(String(it.product_id || ''))}" style="text-align:left;display:block;border-radius:14px;padding:14px;white-space:normal;">
                            <div style="font-size:15px;font-weight:700;color:#0f1720;">${title}</div>
                            ${price}
                            ${credits}
                        </button>`
                    );
                });
            }
            return;
        }

        // trial: только "1 lesson subscription"
        $('#e360-plan-wrap').show();
        $planOptions.html('');

        const trialOne = trialItems.find(function(it) {
            return /1\s*lesson\s*subscription/i.test((it.title || '').toString());
        }) || trialItems[0] || null;

        if (!trialOne) {
            selected.plan_product_id = null;
            $('#e360-offer-msg').text('Trial lesson product was not found.');
            return;
        }

        selected.plan_product_id = parseInt(trialOne.product_id, 10) || null;
        $planOptions.html(
            `<div class="e360-plan-option-card e360-plan-option-card-active" style="border:1px solid #3e64de;background:#eef3ff;border-radius:14px;padding:14px;">
                <div style="font-size:15px;font-weight:700;color:#0f1720;">${escapeHtml(trialOne.title || 'Trial lesson')}</div>
                ${trialOne.price_text ? `<div style="margin-top:6px;font-size:14px;color:#15314b;font-weight:600;">${escapeHtml(trialOne.price_text)}</div>` : ''}
            </div>`
        );
        $('#e360-offer-msg').text(trialOne.title ? ('Selected: ' + trialOne.title) : '');
    }

    function loadTeacherSchedulePreview(teacherId) {
        const $selectedCard = $(`.e360-teacher-card[data-teacher-id="${teacherId}"]`).first();
        const $box = $selectedCard.find('.e360-teacher-schedule').first();
        if (!teacherId) {
            $('.e360-teacher-schedule').hide().html('');
            return;
        }

        $('.e360-teacher-schedule').not($box).hide().html('');
        $box.show().html('<em>Loading schedule…</em>');

        fetchTeacherSchedulePreview(teacherId).done(function(resp) {
            if (!resp || !resp.success) {
                $box.html('<em>Schedule unavailable</em>');
                return;
            }

            const map = resp.data.items || {};
            const data = map[teacherId];
            $box.html(renderTeacherSchedulePreviewHtml(data, teacherId));
        }).fail(function() {
            $box.html('<em>Schedule unavailable</em>');
        });
    }

    function refreshSelectedScheduleUi() {
        $('.e360-teacher-schedule .e360-day-card, #e360-teacher-schedule-content .e360-day-card').each(function() {
            const $day = $(this);
            const date = ($day.data('date') || '').toString();
            const daySelected = (selected.slots || []).some(function(slot) {
                return slot && slot.date === date;
            });
            $day.css('borderColor', daySelected ? '#3e64de' : '#eee');
        });

        $('.e360-teacher-schedule .e360-slot-btn, #e360-teacher-schedule-content .e360-slot-btn').each(function() {
            const $btn = $(this);
            const date = ($btn.data('date') || '').toString();
            const time = ($btn.data('time') || '').toString();
            const isActive = (selected.slots || []).some(function(slot) {
                return slot && slot.date === date && slot.time === time;
            });

            $btn.toggleClass('e360-slot-active', isActive);
            $btn.css({
                border: isActive ? '1px solid #3e64de' : '1px solid #ddd',
                background: isActive ? '#eef3ff' : '#fff',
                color: isActive ? '#1f3fb4' : '#222'
            });
        });
    }

    function selectPreviewSlot(date, time) {
        clearValidationErrors();
        if (!date || !time) return;
        var dt = new Date(date + 'T' + time + ':00');
        if (!isNaN(dt.getTime()) && dt.getTime() < Date.now()) {
            $('#e360-msg').text('This time slot is already in the past. Please choose a future time.');
            return;
        }
        if (!Array.isArray(selected.slots)) selected.slots = [];
        const key = date + '|' + time;
        const idx = selected.slots.findIndex(function(s) {
            return (s && (s.date + '|' + s.time) === key);
        });

        const singleSlotMode = (selected.plan_kind === 'trial') || (selected.repeat === 'once');

        if (singleSlotMode) {
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

        syncSelectedSlotsToInputs();
        refreshSelectedScheduleUi();
        $('#e360-msg').text('');
    }

    function applyPlanKind(planKind) {
        const prevSlots = Array.isArray(selected.slots) ? selected.slots.slice() : [];

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
            $('#e360-repeat-wrap').hide();
            if (prevSlots.length) {
                selected.slots = prevSlots.map(function(slot) {
                    if (!slot || !slot.date || !slot.time) return null;
                    return {
                        date: String(slot.date),
                        time: String(slot.time),
                        repeat: 'weekly'
                    };
                }).filter(Boolean);
            }
        } else {
            selected.repeat = 'once';
            $('#e360-repeat').val('once');
            $('#e360-repeat-wrap').hide();

            if (prevSlots.length) {
                const last = prevSlots[prevSlots.length - 1];
                if (last && last.date && last.time) {
                    selected.slots = [{
                        date: String(last.date),
                        time: String(last.time),
                        repeat: 'once'
                    }];
                }
            }
        }

        syncSelectedSlotsToInputs();
        renderPlansByKind(planKind);
        updateTimeStepVisibility();
    }

    function keepOnlyLastSelectedSlot() {
        if (!Array.isArray(selected.slots) || !selected.slots.length) {
            return;
        }

        const last = selected.slots[selected.slots.length - 1];
        if (!last || !last.date || !last.time) {
            return;
        }

        selected.slots = [{
            date: String(last.date),
            time: String(last.time),
            repeat: 'once'
        }];
        selected.date = selected.slots[0].date;
        selected.time = selected.slots[0].time;

        $('#e360-date').val(selected.date);
        $('#e360-time').html('<option value="">Select…</option>');
        $('#e360-time').append($('<option>', {
            value: selected.time,
            text: selected.time
        }));
        $('#e360-time').val(selected.time);
    }

    function escapeHtml(value) {
        return $('<div>').text(value || '').html();
    }

    function renderChoiceCard(cardClass, idAttr, id, title, imageUrl, extraAttrs, colClass) {
        const attrs = Object.assign({}, extraAttrs || {});
        attrs['data-' + idAttr] = id;

        const attrsHtml = Object.keys(attrs).map(function(key) {
            return `${key}="${escapeHtml(attrs[key])}"`;
        }).join(' ');

        return (
            `<div class="${colClass || 'col-12 col-md-6 col-lg-4'}">` +
            `<div class="single-courses-box e360-choice-card ${cardClass}" ${attrsHtml}>` +
            `<div class="image">` +
            `<img src="${escapeHtml(imageUrl || placeholderImage)}" alt="${escapeHtml(title)}">` +
            `<span class="link-btn" aria-hidden="true"></span>` +
            `</div>` +
            `<div class="content">` +
            `<h3><span>${escapeHtml(title)}</span></h3>` +
            `</div>` +
            `<span class="e360-choice-arrow" aria-hidden="true">›</span>` +
            `</div>` +
            `</div>`
        );
    }

    function renderNoTeacherCard(message) {
        return (
            `<div class="e360-teachers">` +
            `<div class="e360-teacher-card e360-teacher-selected e360-teacher-card-empty">` +
            `<div class="e360-teacher-main">` +
            `<div class="e360-teacher-info">` +
            `<div class="e360-teacher-name">${escapeHtml(message)}</div>` +
            `</div>` +
            `</div>` +
            `</div>` +
            `</div>`
        );
    }

    function loadLevels(languageTermId) {
        resetAfterLevel();
        $('#e360-step-level').show();
        $('#e360-level').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Loading…</div></div>');
        // Не показываем блок Course/Loading… до выбора уровня
        $('#e360-step-course').hide();
        $('#e360-course').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Select level first…</div></div>');

        return $.post(ajaxurl, {
            action: 'e360_get_child_terms',
            nonce,
            taxonomy: selected.taxonomy,
            parent_term_id: languageTermId
        }).done(function(resp) {
            if (!resp.success) {
                $('#e360-level').html('<div class="row g-3"><div class="col-12">Error</div></div>');
                return;
            }
            const items = resp.data.items || [];
            if (!items.length) {
                $('#e360-level').html('<div class="row g-3"><div class="col-12">No levels</div></div>');
                return;
            }

            const levelOrder = {
                beginner: 1,
                intermediate: 2,
                advanced: 3
            };

            items.sort(function(a, b) {
                const aName = ((a && a.name) || '').toString().trim().toLowerCase();
                const bName = ((b && b.name) || '').toString().trim().toLowerCase();
                const aPriority = levelOrder[aName] || 999;
                const bPriority = levelOrder[bName] || 999;

                if (aPriority !== bPriority) {
                    return aPriority - bPriority;
                }

                return aName.localeCompare(bName);
            });

            // render level cards
            let html = '<div class="row g-3">';
            items.forEach(function(it) {
                html += renderChoiceCard('e360-level-card', 'term-id', it.term_id, it.name, it
                    .image_url || placeholderImage);
            });
            html += '</div>';

            $('#e360-level').html(html);
        });
    }

    function loadCourses(levelTermId) {
        resetAfterLevel();

        return $.post(ajaxurl, {
            action: 'e360_get_courses_by_term',
            nonce,
            taxonomy: selected.taxonomy,
            term_id: levelTermId
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-course').html('<div class="row g-3"><div class="col-12">Error</div></div>');
                return;
            }

            const items = resp.data.items || [];
            coursesIndex = {};

            if (!items.length) {
                $('#e360-course').html(
                    '<div class="row g-3"><div class="col-12">No courses</div></div>');
                return;
            }

            // render course cards (was a <select> before)
            let courseHtml = '<div class="row g-3">';
            items.forEach(function(group) {
                coursesIndex[group.course_key] = group;
                const ids = Array.isArray(group.course_ids) ? group.course_ids.map(function(v) {
                    return parseInt(v, 10) || 0;
                }).filter(function(v) {
                    return v > 0;
                }) : [];
                courseHtml += renderChoiceCard('e360-course-card', 'course-key', group
                    .course_key, group.course_title, group.image_url || placeholderImage, {
                        'data-course-ids': ids.join(','),
                        'data-course-title': group.course_title
                    }, 'col-12 col-md-6 col-lg-4');
            });
            courseHtml += '</div>';
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
            include_past_today: 0
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
        clearValidationErrors();
        resetAfterLanguage();
        $('.e360-language-card').removeClass('e360-language-selected');
        $(this).addClass('e360-language-selected');
        console.log('LANGUAGE CLICKED', $(this).data('term-id'));

        if (String($(this).data('other-language')) === '1') {
            $('#e360-step-other-language').show();
            const $step = $('#e360-step-other-language');
            if ($step.length) {
                $('html, body').animate({
                    scrollTop: $step.offset().top - 80
                }, 250);
            }
            return;
        }

        // Скрыть блок Course до выбора уровня
        $('#e360-step-course').hide();
        // Сбросить контент и показать заглушку
        $('#e360-course').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Select level first…</div></div>'
            );

        const langId = parseInt($(this).data('term-id'), 10) || 0;
        if (!langId) return;
        selected.language_term_id = langId;
        const reqLevels = loadLevels(langId);
        if (reqLevels && reqLevels.done) {
            reqLevels.done(function() {
                scrollStepTitleIntoView('#e360-step-level');
            });
        }
    });

    // Step 2: level (cards)
    $(document).on('click', '.e360-level-card', function() {
        clearValidationErrors();
        $('.e360-level-card').removeClass('e360-level-selected');
        $(this).addClass('e360-level-selected');
        console.log('LEVEL CLICKED', $(this).data('term-id'));
        // Показать блок Course после выбора уровня и показать лоадер
        $('#e360-step-course').show();
        $('#e360-course').html(
            '<div class="row g-3"><div class="col-12" style="opacity:.7">Loading…</div></div>');

        const levelId = parseInt($(this).data('term-id'), 10) || 0;
        selected.level_term_id = levelId || null;
        if (!levelId) return;
        const reqCourses = loadCourses(levelId);
        if (reqCourses && reqCourses.done) {
            reqCourses.done(function() {
                scrollStepTitleIntoView('#e360-step-course');
            });
        }
    });

    // Step 3: course (+ teacher auto) — course cards are clickable
    $(document).on('click', '.e360-course-card', function() {
        clearValidationErrors();
        const courseKey = $(this).data('course-key') || '';
        selected.course_key = courseKey || null;

        $('.e360-course-card').removeClass('e360-course-selected');
        $(this).addClass('e360-course-selected');
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
            $('#e360-teacher-list').html(renderNoTeacherCard("Sorry, that course doesn't have any teacher now."));
            scrollElementIntoView('#e360-teacher-list', 24);
            return;
        }

        // Рисуем карточки учителей
        const teachers = group.variants;

        let html = '<div class="e360-teachers">';
        teachers.forEach(function(v) {
            const avatar = v.teacher_avatar ?
                `<img src="${v.teacher_avatar}" alt="" style="width:72px;height:72px;border-radius:50%;object-fit:cover;">` :
                '';

            // short snippet removed — keep only full bio behind the Bio button

            // full html уже sanitized на сервере, но защитим template literal от ` (редко, но бывает)
            const fullBioSafe = (v.teacher_bio_html || '').replace(/`/g, '&#96;');
            const bioFull = fullBioSafe ?
                `<div class="e360-bio-full" style="display:none;margin-top:8px;">${fullBioSafe}</div>` :
                '';

            const headline = (v.teacher_headline || '').toString().trim();
            const intro = ((v.teacher_intro || v.teacher_bio || '')).toString().trim();
            const country = (v.teacher_country || '').toString().trim();
            const languages = (v.teacher_languages || '').toString().trim();
            const rating = (v.teacher_rating || '').toString().trim();
            const price = (v.teacher_price || '').toString().trim();
            const priceLabel = (v.teacher_price_label || 'lesson').toString().trim();
            const nativeLanguage = (v.teacher_native_language || '').toString().trim();
            const introVideo = (v.teacher_intro_video || '').toString().trim();
            const introVideoEmbed = (v.teacher_intro_video_embed || '').toString().trim();
            const badges = ((v.teacher_badges || '').toString().split(',')).map(function(item) {
                return item.trim();
            }).filter(Boolean);
            const featured = parseInt(v.teacher_featured, 10) === 1;

            const badgeHtml = []
                .concat(featured ? ['Featured Tutor'] : [])
                .concat(badges)
                .slice(0, 4)
                .map(function(label) {
                    return `<span style="display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;background:#eef5ff;color:#195ca8;font-size:12px;font-weight:600;">${escapeHtml(label)}</span>`;
                }).join('');

            const ratingHtml = rating ?
                `<div style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:5px 10px;border-radius:999px;background:#fff7e8;color:#8b5a00;font-size:13px;font-weight:700;">
                    <span aria-hidden="true" style="color:#f59e0b;font-size:14px;line-height:1;">★</span>
                    <span>${escapeHtml(rating)}</span>
                </div>` :
                '';

            const countryHtml = country ?
                `<div style="margin-top:8px;color:#5f6b7a;font-size:13px;line-height:1.5;"><strong>Country:</strong> ${escapeHtml(country)}</div>` :
                '';
            const languagesHtml = languages ?
                `<div style="margin-top:6px;color:#5f6b7a;font-size:13px;line-height:1.5;"><strong>Languages:</strong> ${escapeHtml(languages)}</div>` :
                '';
            const nativeLanguageHtml = nativeLanguage ?
                `<div style="margin-top:6px;color:#5f6b7a;font-size:13px;line-height:1.5;"><strong>Native:</strong> ${escapeHtml(nativeLanguage)}</div>` :
                '';

            const introHtml = intro ?
                `<div style="margin-top:10px;color:#2f3b4a;font-size:14px;line-height:1.6;">${escapeHtml(intro)}</div>` :
                '';

            const hasIntroVideo = !!(introVideoEmbed || introVideo);
            const introVideoBtn = hasIntroVideo ?
                `<button type="button" class="e360-watch-intro-video tutor-btn tutor-btn-outline-primary tutor-btn-sm" data-video-embed="${escapeHtml(introVideoEmbed)}" data-video-url="${escapeHtml(introVideo)}" data-teacher-name="${escapeHtml(v.teacher_name || '')}" style="margin-top:8px;">Watch intro video</button>` :
                '';

            const headlineHtml = headline ?
                `<div style="margin-top:4px;font-size:14px;font-weight:600;color:#15314b;">${escapeHtml(headline)}</div>` :
                '';

            const priceHtml = price ?
                `<div style="min-width:132px;text-align:right;">
                    <div style="font-size:28px;line-height:1;font-weight:700;color:#0f1720;">$${escapeHtml(price)}</div>
                    <div style="margin-top:6px;font-size:12px;color:#617083;">${escapeHtml(priceLabel)}</div>
                </div>` :
                '';

            const scheduleBtn =
                `<button type="button" class="e360-view-teacher-schedule tutor-btn tutor-btn-outline-primary tutor-btn-sm" data-teacher-id="${escapeHtml(String(v.teacher_id || ''))}" data-teacher-name="${escapeHtml(v.teacher_name || '')}" style="margin-top:8px;">View schedule</button>`;

            html += `
        <div class="e360-teacher-card"
             data-teacher-id="${v.teacher_id}"
             data-course-id="${v.course_id}"
             data-teacher-name="${escapeHtml(v.teacher_name || '')}"
             style="border:1px solid #ddd;border-radius:18px;padding:16px;background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);box-shadow:0 10px 30px rgba(16,48,78,0.08);">
            <div class="e360-teacher-main" style="display:flex;gap:14px;align-items:flex-start;justify-content:space-between;">
                <div class="e360-teacher-photo">${avatar}</div>
                <div class="e360-teacher-info" style="flex:1;">
                    <div style="display:flex;gap:12px;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;">
                        <div style="flex:1;min-width:220px;">
                            <div class="e360-teacher-name" style="font-size:20px;line-height:1.2;font-weight:700;color:#0f1720;">${escapeHtml(v.teacher_name || '')}</div>
                            ${headlineHtml}
                            ${ratingHtml}
                            ${badgeHtml ? `<div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">${badgeHtml}</div>` : ''}
                            ${countryHtml}
                            ${languagesHtml}
                            ${nativeLanguageHtml}
                            ${introHtml}
                        </div>
                        ${priceHtml}
                    </div>
                    <div style="margin-top:8px;">
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;">
                            ${introVideoBtn}
                            ${scheduleBtn}
                        </div>
                        <div class="e360-teacher-offer-host" style="display:none;"></div>
                    </div>
                </div>
            </div>
            <div class="e360-teacher-schedule" style="display:none;margin-top:10px;font-size:13px;"></div>
        </div>`;
        });

        html += '</div>';

        $('#e360-teacher-list').html(html);
        moveOfferUiToStorage();
        scrollElementIntoView('#e360-teacher-list', 24);

        $(document).off('click.e360watchvideo').on('click.e360watchvideo', '.e360-watch-intro-video', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $btn = $(this);
            openTeacherIntroVideoModal(
                ($btn.data('teacher-name') || '').toString(),
                ($btn.data('video-embed') || '').toString(),
                ($btn.data('video-url') || '').toString()
            );
        });

        $(document).off('click.e360viewschedule').on('click.e360viewschedule', '.e360-view-teacher-schedule', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $btn = $(this);
            openTeacherScheduleModal(
                parseInt($btn.data('teacher-id'), 10) || 0,
                ($btn.data('teacher-name') || '').toString()
            );
        });

        // card click = select teacher
        $(document).off('click.e360card').on('click.e360card', '.e360-teacher-card', function() {
            if ($(this).hasClass('e360-teacher-card-empty')) {
                return;
            }
            clearValidationErrors();
            const alreadySelected = $(this).hasClass('e360-teacher-selected');
            if (alreadySelected) {
                return;
            }
            $('.e360-teacher-card').removeClass('e360-teacher-selected');
            $(this).addClass('e360-teacher-selected');
            $('.e360-teacher-schedule').not($(this).find('.e360-teacher-schedule')).hide().html('');

            const teacherId = parseInt($(this).data('teacher-id'), 10) || 0;
            const courseId = parseInt($(this).data('course-id'), 10) || 0;
            const teacherName = $(this).data('teacher-name') || null;

            selected.teacher_id = teacherId || null;
            selected.course_id = courseId || null;
            selected.teacher_name = teacherName || null;
            selected.date = null;
            selected.time = null;
            selected.slots = [];

            $('#e360-date').val('');
            $('#e360-time').html('<option value="">Select date first…</option>');
            $('#e360-offer-msg').text('');
            mountOfferUiIntoSelectedTeacherCard();
            updateTimeStepVisibility();

            loadPlans();
            loadTeacherSchedulePreview(teacherId);
            scrollElementIntoView(this, 24);
        });

        $(document).off('click.e360videoclose').on('click.e360videoclose', '.e360-teacher-video-close', function(e) {
            e.preventDefault();
            closeTeacherIntroVideoModal();
        });

        $(document).off('click.e360scheduleclose').on('click.e360scheduleclose', '.e360-teacher-schedule-close', function(e) {
            e.preventDefault();
            closeTeacherScheduleModal();
        });

        $(document).off('click.e360videobackdrop').on('click.e360videobackdrop', function(e) {
            const $modal = $('#e360-teacher-video-modal');
            if ($modal.length && e.target === $modal.get(0)) {
                closeTeacherIntroVideoModal();
            }
            const $scheduleModal = $('#e360-teacher-schedule-modal');
            if ($scheduleModal.length && e.target === $scheduleModal.get(0)) {
                closeTeacherScheduleModal();
            }
        });

        const $firstTeacherCard = $('#e360-teacher-list .e360-teacher-card').not('.e360-teacher-card-empty').first();
        if ($firstTeacherCard.length) {
            $firstTeacherCard.trigger('click');
        }

    });


    // Step 4: date -> slots
    $('#e360-date').on('change', function() {
        clearValidationErrors();
        const date = $(this).val();
        selected.date = date || null;
        if (!date || !selected.teacher_id || !canShowTimeStep()) return;
        loadSlots(selected.teacher_id, date);
    });

    $('#e360-time').on('change', function() {
        clearValidationErrors();
        selected.time = $(this).val() || null;
    });

    $(document).on('click', '.e360-slot-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const date = ($(this).data('date') || '').toString();
        const time = ($(this).data('time') || '').toString();
        if (!date || !time) return;
        selectPreviewSlot(date, time);
    });

    $(document).on('click', '.e360-plan-option-card[data-product-id]', function() {
        clearValidationErrors();
        const productId = parseInt($(this).data('product-id'), 10) || null;
        selected.plan_product_id = productId;
        $('.e360-plan-option-card[data-product-id]').removeClass('tutor-btn-primary e360-plan-option-card-active').addClass('tutor-btn-outline-primary');
        $(this).removeClass('tutor-btn-outline-primary').addClass('tutor-btn-primary e360-plan-option-card-active');
        updateTimeStepVisibility();

        if (selected.plan_product_id && selected.date && selected.teacher_id) {
            loadSlots(selected.teacher_id, selected.date);
        }
    });

    $(document).on('click', '.e360-purchase-card', function() {
        clearValidationErrors();
        if (!selected.teacher_id) return;
        const planKind = ($(this).data('plan-kind') || '').toString();
        if (!planKind) return;

        $('.e360-purchase-card').removeClass('tutor-btn-primary').addClass('tutor-btn-outline-primary');
        $(this).removeClass('tutor-btn-outline-primary').addClass('tutor-btn-primary');

        if (planKind === 'trial') {
            keepOnlyLastSelectedSlot();
        }
        applyPlanKind(planKind);
        if (planKind === 'trial') {
            keepOnlyLastSelectedSlot();
            if (selected.teacher_id) {
                loadTeacherSchedulePreview(selected.teacher_id);
            }
        }
    });

    $('#e360-repeat').on('change', function() {
        clearValidationErrors();
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
        clearValidationErrors();
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

        if (!selected.language_term_id) {
            $('#e360-language').addClass('e360-validation-error-section');
        }
        if (!selected.level_term_id) {
            $('#e360-level').addClass('e360-validation-error-section');
        }
        if (!selected.course_key) {
            $('#e360-course').addClass('e360-validation-error-section');
        }
        if (!selected.teacher_id) {
            $('#e360-teacher-list').addClass('e360-validation-error-section');
        }
        if (!selected.plan_kind) {
            $('#e360-purchase-options').addClass('e360-validation-error-section');
        }
        if (!selected.plan_product_id) {
            $('#e360-plan-options').addClass('e360-validation-error');
            $('#e360-plan-wrap').addClass('e360-validation-error-section');
        }
        if (!selected.date) {
            $('#e360-date').addClass('e360-validation-error');
        }
        if (!selected.time) {
            $('#e360-time').addClass('e360-validation-error');
        }
        if (!selected.slots || !selected.slots.length) {
            $('#e360-step-time').addClass('e360-validation-error-section');
        }

        if (!selected.language_term_id || !selected.level_term_id || !selected.course_key || !selected
            .course_id || !selected
            .teacher_id || !selected.slots || !selected.slots.length) {
            $('#e360-msg').text(
                'Select language, level, course, teacher, lesson option, date and time first.');
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
        $('#e360-plan-options').html('<div style="opacity:.7;">Loading…</div>');

        $.post(ajaxurl, {
            action: 'e360_get_plans',
            nonce
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-offer-msg').text('Could not load payment options.');
                $('#e360-plan-options').html('<div style="opacity:.7;">Error</div>');
                return;
            }

            const items = resp.data.items || [];
            if (!items.length) {
                $('#e360-offer-msg').text('No payment options are available.');
                $('#e360-plan-options').html('<div style="opacity:.7;">No packages found</div>');
                return;
            }

            plansIndex = items;
            if (selected.plan_kind) applyPlanKind(selected.plan_kind);
        });
    }

    function findCourseCardById(courseId) {
        let $match = $();
        if (!courseId) return $match;
        $('.e360-course-card').each(function() {
            const raw = ($(this).attr('data-course-ids') || '').toString();
            if (!raw) return;
            const ids = raw.split(',').map(function(v) {
                return parseInt(v, 10) || 0;
            });
            if (ids.indexOf(courseId) !== -1) {
                $match = $(this);
                return false;
            }
        });
        return $match;
    }

    function applyInitialPrefill() {
        const langId = parseInt(prefill.language_term_id, 10) || 0;
        const levelId = parseInt(prefill.level_term_id, 10) || 0;
        const courseId = parseInt(prefill.course_id, 10) || 0;
        if (!langId || !levelId || !courseId) return;

        const $lang = $(`.e360-language-card[data-term-id="${langId}"]`);
        if (!$lang.length) return;

        resetAfterLanguage();
        $('.e360-language-card').removeClass('e360-language-selected');
        $lang.addClass('e360-language-selected');
        selected.language_term_id = langId;

        const reqLevels = loadLevels(langId);
        if (!reqLevels || !reqLevels.done) return;

        reqLevels.done(function() {
            const $level = $(`.e360-level-card[data-term-id="${levelId}"]`);
            if (!$level.length) return;

            $('.e360-level-card').removeClass('e360-level-selected');
            $level.addClass('e360-level-selected');
            selected.level_term_id = levelId;
            $('#e360-step-course').show();

            const reqCourses = loadCourses(levelId);
            if (!reqCourses || !reqCourses.done) return;

            reqCourses.done(function() {
                const $course = findCourseCardById(courseId);
                if ($course.length) {
                    $course.trigger('click');
                }
            });
        });
    }

    applyInitialPrefill();


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

add_action('template_redirect', function() {
    if (is_admin() || wp_doing_ajax() || !is_page('student-registration')) {
        return;
    }

    if (empty($_GET['e360_checkout_booking'])) {
        return;
    }

    if (!is_user_logged_in()) {
        $current_url = (is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');
        wp_safe_redirect(wp_login_url($current_url));
        exit;
    }

    $result = e360_store_booking_context_and_prepare_checkout(get_current_user_id(), $_GET);
    if (!$result['ok']) {
        wp_safe_redirect(remove_query_arg('e360_checkout_booking'));
        exit;
    }

    wp_safe_redirect($result['checkout_url']);
    exit;
});



add_action('wp_ajax_e360_get_child_terms', 'e360_get_child_terms');
add_action('wp_ajax_nopriv_e360_get_child_terms', 'e360_get_child_terms');

function e360_get_child_terms() {
    if (is_user_logged_in() && !e360_booking_nonce_valid()) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

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
        $thumb_id = (int) get_term_meta((int) $t->term_id, 'thumbnail_id', true);
        $img = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium_large') : '';
        if (!$img) {
            $img = e360_booking_placeholder_image_url();
        }
        $items[] = [
            'term_id' => (int) $t->term_id,
            'name'    => $t->name,
            'slug'    => $t->slug,
            'image_url' => $img,
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
    $slots = e360_sanitize_ctx_slots(e360_decode_slots_param($slots_param), 'weekly', 60);
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
    $current_url = (is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');
    $login_url = wp_login_url($current_url);
    $checkout_from_booking_url = add_query_arg('e360_checkout_booking', '1', $current_url);
    $is_logged_in = is_user_logged_in();

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

<div id="e360-reg-actions" style="display:none;margin:14px 0 0;">
    <?php if ($is_logged_in): ?>
    <a href="<?php echo esc_url($checkout_from_booking_url); ?>"
        class="tutor-btn tutor-btn-primary e360-booking-login-btn">Continue to checkout</a>
    <?php else: ?>
    <a href="<?php echo esc_url($login_url); ?>" class="tutor-btn tutor-btn-outline-primary e360-booking-login-btn">Log
        in</a>
    <?php endif; ?>
</div>

<script>
(function() {
    // 1) Вставляем блок перед регистрационной формой
    var box = document.getElementById('e360-reg-context');
    var actions = document.getElementById('e360-reg-actions');
    if (!box) return;

    var form = document.querySelector('form'); // fallback
    // попробуем найти “правильную” форму Tutor
    var tutorForm = document.querySelector('form input[name="tutor_register_nonce"]');
    if (tutorForm) form = tutorForm.closest('form');

    if (form && form.parentNode) {
        form.parentNode.insertBefore(box, form);
        if (actions) {
            form.insertAdjacentElement('afterend', actions);
            actions.style.display = 'block';
        }
    } else if (box.parentNode && actions) {
        box.insertAdjacentElement('afterend', actions);
        actions.style.display = 'block';
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
    if (is_user_logged_in() && !e360_booking_nonce_valid()) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
    }

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

function e360_render_instructor_front_profile_settings(): void {
    if (!is_user_logged_in()) {
        return;
    }

    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        return;
    }

    $user_id = get_current_user_id();
    $fields = e360_get_instructor_front_profile_fields_schema();

    echo '<div class="e360-instructor-card-settings tutor-card" style="margin:0 0 18px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">';
    echo '<div style="font-size:20px;font-weight:700;margin-bottom:6px;">Teacher Card Profile</div>';
    echo '<div style="margin-bottom:14px;color:#6b7280;">Update the information shown on your teacher card.</div>';
    echo '<div class="e360-instructor-card-settings-msg" style="margin:0 0 12px;"></div>';
    echo '<div class="e360-instructor-card-settings-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;">';

    foreach ($fields as $meta_key => $field) {
        $value = get_user_meta($user_id, $meta_key, true);
        echo '<label style="display:flex;flex-direction:column;gap:6px;">';
        echo '<span style="font-size:13px;font-weight:600;color:#111827;">' . esc_html($field['label']) . '</span>';

        if ($field['type'] === 'textarea') {
            echo '<textarea class="tutor-form-control e360-instructor-card-field" rows="4" data-meta-key="' . esc_attr($meta_key) . '" placeholder="' . esc_attr($field['placeholder'] ?? '') . '">' . esc_textarea((string) $value) . '</textarea>';
        } elseif ($field['type'] === 'checkbox') {
            echo '<span style="display:flex;align-items:center;gap:8px;height:42px;">';
            echo '<input type="checkbox" class="e360-instructor-card-field" data-meta-key="' . esc_attr($meta_key) . '" value="1" ' . checked(!empty($value), true, false) . '>';
            echo '<span style="font-size:13px;color:#4b5563;">Enabled</span>';
            echo '</span>';
        } else {
            $extra = '';
            if (!empty($field['step'])) $extra .= ' step="' . esc_attr((string) $field['step']) . '"';
            if (!empty($field['min'])) $extra .= ' min="' . esc_attr((string) $field['min']) . '"';
            if (!empty($field['max'])) $extra .= ' max="' . esc_attr((string) $field['max']) . '"';
            echo '<input type="' . esc_attr($field['type']) . '" class="tutor-form-control e360-instructor-card-field" data-meta-key="' . esc_attr($meta_key) . '" value="' . esc_attr((string) $value) . '" placeholder="' . esc_attr($field['placeholder'] ?? '') . '"' . $extra . '>';
        }

        echo '</label>';
    }

    echo '</div>';
    echo '<div style="margin-top:16px;"><button type="button" class="tutor-btn tutor-btn-primary e360-save-instructor-card-settings">Save Profile</button></div>';
    echo '</div>';
    ?>
<script>
jQuery(function($) {
    const $box = $('.e360-instructor-card-settings').first();
    if (!$box.length || $box.data('bound') === 1) return;
    $box.data('bound', 1);

    const ajaxurl = <?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>;
    const nonce = <?php echo wp_json_encode(wp_create_nonce('e360_instructor_card_settings')); ?>;

    $box.on('click', '.e360-save-instructor-card-settings', function() {
        const payload = {
            action: 'e360_save_instructor_card_settings',
            nonce: nonce
        };

        $box.find('.e360-instructor-card-field').each(function() {
            const key = $(this).data('meta-key');
            if (!key) return;
            if ($(this).is(':checkbox')) {
                payload[key] = $(this).is(':checked') ? '1' : '';
            } else {
                payload[key] = $(this).val() || '';
            }
        });

        const $msg = $box.find('.e360-instructor-card-settings-msg');
        $msg.text('Saving...').css('color', '#4b5563');

        $.post(ajaxurl, payload).done(function(resp) {
            if (!resp || !resp.success) {
                const message = (resp && resp.data && resp.data.message) ? resp.data.message : 'Could not save profile.';
                $msg.text(message).css('color', '#b91c1c');
                return;
            }
            $msg.text('Profile saved.').css('color', '#047857');
        }).fail(function() {
            $msg.text('Could not save profile.').css('color', '#b91c1c');
        });
    });
});
</script>
<?php
}

add_action('tutor_load_dashboard_template_before', function($dashboard_page_name){
    if ($dashboard_page_name !== 'settings') return;
    e360_render_instructor_front_profile_settings();
}, 6, 1);

function e360_handle_save_instructor_card_settings(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }

    check_ajax_referer('e360_instructor_card_settings', 'nonce');

    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $user_id = get_current_user_id();
    $fields = e360_get_instructor_front_profile_fields_schema();

    foreach ($fields as $meta_key => $field) {
        $raw = $_POST[$meta_key] ?? '';
        if ($field['type'] === 'checkbox') {
            update_user_meta($user_id, $meta_key, !empty($raw) ? '1' : '');
            continue;
        }

        $value = is_string($raw) ? wp_unslash($raw) : '';
        if ($field['type'] === 'textarea') {
            $value = sanitize_textarea_field($value);
        } elseif ($field['type'] === 'url') {
            $value = esc_url_raw($value);
        } else {
            $value = sanitize_text_field($value);
        }

        update_user_meta($user_id, $meta_key, $value);
    }

    wp_send_json_success(['message' => 'Profile saved.']);
}
add_action('wp_ajax_e360_save_instructor_card_settings', 'e360_handle_save_instructor_card_settings');
