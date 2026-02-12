<?php
defined('ABSPATH') || exit;

/**
 * =========
 * Timezone
 * =========
 */
function e360_get_teacher_timezone_string(int $teacher_id): string {
    $tz = (string) get_user_meta($teacher_id, 'e360_teacher_timezone', true);
    if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;

    $wpTz = function_exists('wp_timezone_string') ? (string) wp_timezone_string() : '';
    return $wpTz ?: 'UTC';
}

function e360_minutes_from_hhmm(string $hhmm): int {
    if (!preg_match('/^\d{2}:\d{2}$/', $hhmm)) return 0;
    [$h,$m] = array_map('intval', explode(':', $hhmm));
    return max(0, min(23, $h))*60 + max(0, min(59, $m));
}

function e360_hhmm_from_minutes(int $min): string {
    $min = max(0, min(24*60-1, $min));
    $h = floor($min / 60);
    $m = $min % 60;
    return sprintf('%02d:%02d', $h, $m);
}

function e360_weekday_key_from_date(string $ymd, DateTimeZone $tz): string {
    $dt = new DateTimeImmutable($ymd . ' 00:00:00', $tz);
    $map = [1=>'mon',2=>'tue',3=>'wed',4=>'thu',5=>'fri',6=>'sat',7=>'sun'];
    return $map[(int)$dt->format('N')] ?? 'mon';
}

/**
 * ==========================
 * Teacher Profile: timezone
 * ==========================
 */
/**
 * ==========================
 * Teacher Profile: timezone
 * ==========================
 */
function e360_render_teacher_timezone_profile_field($user){
    if (!($user instanceof WP_User)) return;
    if (!user_can($user, 'tutor_instructor') && !user_can($user, 'manage_options')) return;

    $current = e360_get_teacher_timezone_string((int)$user->ID);
    // Список основных городов по часовым поясам
    $main_timezones = [
        'Pacific/Honolulu' => 'Honolulu',
        'America/Anchorage' => 'Anchorage',
        'America/Los_Angeles' => 'Los Angeles',
        'America/Denver' => 'Denver',
        'America/Chicago' => 'Chicago',
        'America/New_York' => 'New York',
        'America/Sao_Paulo' => 'São Paulo',
        'Europe/London' => 'London',
        'Europe/Berlin' => 'Berlin',
        'Europe/Moscow' => 'Moscow',
        'Asia/Dubai' => 'Dubai',
        'Asia/Kolkata' => 'Kolkata',
        'Asia/Bangkok' => 'Bangkok',
        'Asia/Hong_Kong' => 'Hong Kong',
        'Asia/Tokyo' => 'Tokyo',
        'Australia/Sydney' => 'Sydney',
        'Pacific/Auckland' => 'Auckland',
        'Africa/Johannesburg' => 'Johannesburg',
    ];
    ?>
<h2>English360</h2>
<table class="form-table" role="presentation">
    <tr>
        <th><label for="e360_teacher_timezone">Teacher timezone</label></th>
        <td>
            <select name="e360_teacher_timezone" id="e360_teacher_timezone" class="regular-text">
                <?php foreach ($main_timezones as $tz => $city): ?>
                <option value="<?php echo esc_attr($tz); ?>" <?php selected($current, $tz); ?>>
                    <?php echo esc_html($city . ' (' . $tz . ')'); ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description">Used for availability, bookings, and displaying lesson times.</p>
        </td>
    </tr>
</table>
<?php
}

add_action('show_user_profile', 'e360_render_teacher_timezone_profile_field');
add_action('edit_user_profile', 'e360_render_teacher_timezone_profile_field');

function e360_save_teacher_timezone_profile_field($user_id){
    if (!current_user_can('edit_user', $user_id)) return;
    if (!isset($_POST['e360_teacher_timezone'])) return;

    $tz = sanitize_text_field(wp_unslash($_POST['e360_teacher_timezone']));
    if ($tz && in_array($tz, timezone_identifiers_list(), true)) {
        update_user_meta($user_id, 'e360_teacher_timezone', $tz);
    }
}

add_action('personal_options_update', 'e360_save_teacher_timezone_profile_field');
add_action('edit_user_profile_update', 'e360_save_teacher_timezone_profile_field');

/**
 * ==========================
 * Availability (multi-ranges)
 * user_meta: e360_teacher_availability
 * structure:
 * [
 *   'mon' => [ ['from'=>'09:00','to'=>'12:00'], ['from'=>'14:00','to'=>'18:00'] ],
 *   ...
 * ]
 * ==========================
 */
function e360_get_teacher_availability(int $teacher_id): array {
    $a = get_user_meta($teacher_id, 'e360_teacher_availability', true);
    if (!is_array($a)) $a = [];
    $keys = ['mon','tue','wed','thu','fri','sat','sun'];
    foreach ($keys as $k) {
        if (empty($a[$k]) || !is_array($a[$k])) $a[$k] = [];
    }
    return $a;
}

function e360_sanitize_availability(array $input): array {
    $out = [];
    $keys = ['mon','tue','wed','thu','fri','sat','sun'];

    foreach ($keys as $k) {
        $out[$k] = [];
        $ranges = $input[$k] ?? [];
        if (!is_array($ranges)) continue;

        foreach ($ranges as $r) {
            $from = isset($r['from']) ? sanitize_text_field((string)$r['from']) : '';
            $to   = isset($r['to'])   ? sanitize_text_field((string)$r['to'])   : '';

            // normalize common formats: allow "9:00", "9:00 AM", localized spaces, etc.
            $normalize = function(string $s): string {
                $s = trim($s);
                // replace various spaces with normal space
                $s = preg_replace('/[\x{00A0}\x{202F}\s]+/u', ' ', $s);
                // if already HH:MM with two digits, accept
                if (preg_match('/^\d{2}:\d{2}$/', $s)) return $s;
                // try to parse via strtotime
                $ts = strtotime($s);
                if ($ts !== false) return date('H:i', $ts);
                // try to add leading zero for H:MM
                if (preg_match('/^\d:\d{2}$/', $s)) {
                    return '0' . $s;
                }
                return '';
            };

            $rawFrom = isset($r['from']) ? (string)$r['from'] : '';
            $rawTo = isset($r['to']) ? (string)$r['to'] : '';

            $from = $normalize($from);
            $to = $normalize($to);
            if (!preg_match('/^\d{2}:\d{2}$/', $from)) continue;
            if (!preg_match('/^\d{2}:\d{2}$/', $to)) continue;

            $f = e360_minutes_from_hhmm($from);
            $t = e360_minutes_from_hhmm($to);

            // if end <= start, allow treating midnight (00:00) as end-of-day (1440)
            if ($t <= $f) {
                if ($to === '00:00') {
                    $t = 24 * 60; // end of day
                }
            }

            if ($t <= $f) continue;

            $out[$k][] = ['from'=>$from, 'to'=>$to];
        }
    }
    return $out;
}

function e360_availability_equals(array $a, array $b): bool {
    $normalize = function(array $x): array {
        $x = e360_sanitize_availability($x);
        $days = ['mon','tue','wed','thu','fri','sat','sun'];
        foreach ($days as $d) {
            $rows = isset($x[$d]) && is_array($x[$d]) ? $x[$d] : [];
            usort($rows, function($r1, $r2){
                return strcmp((string)($r1['from'] ?? ''), (string)($r2['from'] ?? ''));
            });
            $x[$d] = $rows;
        }
        return $x;
    };
    return $normalize($a) === $normalize($b);
}

function e360_format_availability_text(array $availability): string {
    $days = [
        'mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu',
        'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun',
    ];
    $out = [];
    foreach ($days as $k => $label) {
        $rows = isset($availability[$k]) && is_array($availability[$k]) ? $availability[$k] : [];
        if (!$rows) {
            $out[] = $label . ': -';
            continue;
        }
        $parts = [];
        foreach ($rows as $r) {
            $f = (string)($r['from'] ?? '');
            $t = (string)($r['to'] ?? '');
            if ($f !== '' && $t !== '') $parts[] = $f . '-' . $t;
        }
        $out[] = $label . ': ' . ($parts ? implode(', ', $parts) : '-');
    }
    return implode("\n", $out);
}

function e360_get_teacher_student_emails(int $teacher_id): array {
    $emails = [];

    // Primary teacher links.
    $q = new WP_User_Query([
        'fields' => ['ID', 'user_email'],
        'number' => 1000,
        'meta_key' => 'e360_primary_teacher_id',
        'meta_value' => $teacher_id,
    ]);
    foreach ((array)$q->get_results() as $u) {
        $mail = sanitize_email((string)($u->user_email ?? ''));
        if ($mail !== '') $emails[] = $mail;
    }

    // Students from bookings with this teacher.
    $booking_ids = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'fields' => 'ids',
        'numberposts' => 500,
        'meta_query' => [
            ['key' => 'teacher_id', 'value' => $teacher_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ],
    ]);
    foreach ((array)$booking_ids as $bid) {
        $sid = (int) get_post_meta((int)$bid, 'student_id', true);
        if ($sid <= 0) continue;
        $u = get_user_by('id', $sid);
        if (!$u) continue;
        $mail = sanitize_email((string)$u->user_email);
        if ($mail !== '') $emails[] = $mail;
    }

    return array_values(array_unique($emails));
}

function e360_send_teacher_availability_notifications(int $teacher_id, array $old_availability, array $new_availability, string $old_tz, string $new_tz): void {
    if (!function_exists('wp_mail')) return;
    if (e360_availability_equals($old_availability, $new_availability) && $old_tz === $new_tz) return;

    $teacher = get_user_by('id', $teacher_id);
    $teacher_name = $teacher ? $teacher->display_name : ('Teacher #' . $teacher_id);
    $site = wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES);
    $subject = '[' . $site . '] Teacher availability updated: ' . $teacher_name;

    $body = "Teacher: {$teacher_name} (ID {$teacher_id})\n";
    $body .= "Timezone: {$old_tz} -> {$new_tz}\n\n";
    $body .= "Updated availability:\n";
    $body .= e360_format_availability_text($new_availability) . "\n";

    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    // Admins.
    $admin_emails = [];
    $default_admin = sanitize_email((string)get_option('admin_email'));
    if ($default_admin !== '') $admin_emails[] = $default_admin;
    $admins = get_users(['role' => 'administrator', 'fields' => ['user_email']]);
    foreach ((array)$admins as $a) {
        $mail = sanitize_email((string)($a->user_email ?? ''));
        if ($mail !== '') $admin_emails[] = $mail;
    }
    $admin_emails = array_values(array_unique($admin_emails));
    if ($admin_emails) wp_mail($admin_emails, $subject, $body, $headers);

    // Students connected to this teacher.
    $student_emails = e360_get_teacher_student_emails($teacher_id);
    foreach ($student_emails as $mail) {
        wp_mail($mail, $subject, $body, $headers);
    }
}

/**
 * ==================
 * Teacher calendar UI
 * shortcode: [e360_teacher_calendar_settings]
 * ==================
 */
add_shortcode('e360_teacher_calendar_settings', function(){
    if (!is_user_logged_in()) return '<p>Please log in.</p>';
    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        return '<p>Only instructors can edit availability.</p>';
    }

    $nonce = wp_create_nonce('e360_teacher_calendar');
    $ajax  = admin_url('admin-ajax.php');
    $tz    = e360_get_teacher_timezone_string($uid);

    ob_start();
    ?>
<div class="e360-teacher-calendar" data-ajax="<?php echo esc_attr($ajax); ?>"
    data-nonce="<?php echo esc_attr($nonce); ?>">
    <div style="padding:12px;border:1px solid #e5e5e5;border-radius:12px;">
        <div style="font-weight:700;margin-bottom:10px;">Teacher availability</div>

        <div style="margin:0 0 10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Your timezone</label>
            <?php
            // Ручной curated список городов по поясам, без российских, с канадскими для Америки, европейскими для Европы, Киев для UTC+2
            // По одному городу на каждый часовой пояс от UTC-12 до UTC+12 (без российских городов)
            $curated_timezones = [
                // UTC-12
                'Etc/GMT+12' => 'Baker Island',
                // UTC-11
                'Pacific/Pago_Pago' => 'Pago Pago',
                // UTC-10
                'Pacific/Honolulu' => 'Honolulu',
                // UTC-9
                'America/Anchorage' => 'Anchorage',
                // UTC-8
                'America/Vancouver' => 'Vancouver',
                // UTC-7
                'America/Edmonton' => 'Edmonton',
                // UTC-6
                'America/Winnipeg' => 'Winnipeg',
                // UTC-5
                'America/Toronto' => 'Toronto',
                // UTC-4
                'America/Halifax' => 'Halifax',
                // UTC-3
                'America/Sao_Paulo' => 'São Paulo',
                // UTC-2
                'America/Noronha' => 'Noronha',
                // UTC-1
                'Atlantic/Azores' => 'Azores',
                // UTC+0
                'Europe/Lisbon' => 'Lisbon',
                // UTC+1
                'Europe/Berlin' => 'Berlin',
                // UTC+2
                'Europe/Kyiv' => 'Kyiv',
                // UTC+3
                'Europe/Minsk' => 'Minsk',
                // UTC+4
                'Asia/Dubai' => 'Dubai',
                // UTC+5
                'Asia/Karachi' => 'Karachi',
                // UTC+6
                'Asia/Almaty' => 'Almaty',
                // UTC+7
                'Asia/Bangkok' => 'Bangkok',
                // UTC+8
                'Asia/Hong_Kong' => 'Hong Kong',
                // UTC+9
                'Asia/Tokyo' => 'Tokyo',
                // UTC+10
                'Australia/Sydney' => 'Sydney',
                // UTC+11
                'Pacific/Noumea' => 'Noumea',
                // UTC+12
                'Pacific/Auckland' => 'Auckland',
            ];
            ?>
            <select class="e360-tz" style="min-width:320px;">
                <?php foreach ($curated_timezones as $tz_id => $city):
                    try {
                        $dtz = new DateTimeZone($tz_id);
                        $now = new DateTime('now', $dtz);
                        $offset = $dtz->getOffset($now);
                        $hours = (int)($offset / 3600);
                        $minutes = abs($offset % 3600) / 60;
                        $sign = $hours >= 0 ? '+' : '-';
                        $offset_str = sprintf('UTC%s%02d%s', $sign, abs($hours), $minutes ? ':' . sprintf('%02d', $minutes) : '');
                    } catch (Exception $e) {
                        $offset_str = '';
                    }
                ?>
                <option value="<?php echo esc_attr($tz_id); ?>" <?php selected($tz, $tz_id); ?>>
                    <?php echo esc_html($city . ' (' . $offset_str . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="e360-days" style="display:grid;grid-template-columns:1fr;gap:10px;"></div>

        <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
            <button type="button"
                class="button button-primary e360-save-avail tutor-btn tutor-btn-primary ">Save</button>
            <span class="e360-avail-msg" style="opacity:.8;"></span>
        </div>
    </div>
</div>

<script>
(function() {
    // --- dedupe: оставляем календарь внутри .tutor-col-lg-9, остальные удаляем ---
    const all = Array.from(document.querySelectorAll('.e360-teacher-calendar'));
    if (all.length > 1) {
        const preferred = all.find(el => el.closest('.tutor-col-lg-9')) || all[0];
        all.forEach(el => {
            if (el !== preferred) el.remove();
        });
    }

    function init(root) {
        const ajax = root.getAttribute('data-ajax');
        const nonce = root.getAttribute('data-nonce');

        const tzSelect = root.querySelector('.e360-tz');
        const wrapDays = root.querySelector('.e360-days');
        const msgEl = root.querySelector('.e360-avail-msg');
        const saveBtn = root.querySelector('.e360-save-avail');

        const dayNames = {
            mon: 'Monday',
            tue: 'Tuesday',
            wed: 'Wednesday',
            thu: 'Thursday',
            fri: 'Friday',
            sat: 'Saturday',
            sun: 'Sunday'
        };
        const keys = Object.keys(dayNames);

        function esc(s) {
            return (s || '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [m]));
        }

        function setMsg(t) {
            msgEl.textContent = t || '';
        }

        function rangeRow(fromVal = '', toVal = '') {
            return `
                <div class="e360-range" style="display:flex;gap:8px;align-items:center;margin:6px 0;">
                    <input type="time" class="e360-from" value="${esc(fromVal)}">
                    <span>–</span>
                    <input type="time" class="e360-to" value="${esc(toVal)}">
                    <button type="button" class="button e360-del tutor-btn tutor-btn-danger tutor-create-new-course tutor-dashboard-create-course" style="margin-left:auto;">Remove</button>
                </div>`;
        }

        function renderDays(data) {
            wrapDays.innerHTML = '';
            keys.forEach(k => {
                const ranges = (data && data[k]) ? data[k] : [];
                let html = `
                    <div class="e360-day" data-day="${k}" style="border:1px solid #eee;border-radius:12px;padding:10px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div style="font-weight:700;">${dayNames[k]}</div>
                            <button type="button" class="button e360-add tutor-btn tutor-btn-primary tutor-create-new-course tutor-dashboard-create-course">+ Add time range</button>
                        </div>
                        <div class="e360-ranges" style="margin-top:6px;">
                `;
                if (!ranges.length) {
                    html +=
                        `<div class="e360-empty" style="opacity:.7;font-size:13px;margin-top:6px;">No ranges</div>`;
                } else {
                    ranges.forEach(r => html += rangeRow(r.from, r.to));
                }
                html += `</div></div>`;
                wrapDays.insertAdjacentHTML('beforeend', html);
            });
        }

        function collect() {
            const out = {};
            keys.forEach(k => out[k] = []);
            root.querySelectorAll('.e360-day').forEach(dayEl => {
                const k = dayEl.getAttribute('data-day');
                dayEl.querySelectorAll('.e360-range').forEach(r => {
                    const from = r.querySelector('.e360-from').value || '';
                    const to = r.querySelector('.e360-to').value || '';
                    if (from && to) out[k].push({
                        from,
                        to
                    });
                });
            });
            return out;
        }

        // load
        fetch(ajax, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'e360_teacher_get_availability',
                    nonce
                })
            })
            .then(r => r.json())
            .then(resp => {
                if (!resp || !resp.success) {
                    renderDays({});
                    return;
                }
                renderDays(resp.data.availability || {});
                if (resp.data.timezone) tzSelect.value = resp.data.timezone;
            });

        // add/remove (делаем через root, чтобы не ловить клики по всей странице)
        root.addEventListener('click', function(e) {
            const addBtn = e.target.closest('.e360-add');
            if (addBtn) {
                const day = addBtn.closest('.e360-day');
                const ranges = day.querySelector('.e360-ranges');
                const empty = ranges.querySelector('.e360-empty');
                if (empty) empty.remove();
                ranges.insertAdjacentHTML('beforeend', rangeRow('09:00', '12:00'));
                return;
            }

            const delBtn = e.target.closest('.e360-del');
            if (delBtn) {
                delBtn.closest('.e360-range').remove();
            }
        });

        // save
        saveBtn.addEventListener('click', function() {
            setMsg('Saving…');
            const availability = collect();
            const tz = tzSelect.value || '';
            fetch(ajax, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: new URLSearchParams({
                        action: 'e360_teacher_save_availability',
                        nonce,
                        timezone: tz,
                        availability: JSON.stringify(availability)
                    })
                })
                .then(r => r.json())
                .then(resp => {
                    if (!resp || !resp.success) {
                        setMsg((resp && resp.data && resp.data.message) ? resp.data.message : 'Error');
                        return;
                    }
                    setMsg('Saved');
                })
                .catch(() => setMsg('Request failed'));
        });
    }

    const root = document.querySelector('.e360-teacher-calendar');
    if (root) init(root);
})();
</script>
<?php
    return ob_get_clean();
});


add_action('wp_ajax_e360_teacher_get_availability', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_teacher_calendar', 'nonce');

    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    wp_send_json_success([
        'availability' => e360_get_teacher_availability($uid),
        'timezone' => e360_get_teacher_timezone_string($uid),
    ]);
});

add_action('wp_ajax_e360_teacher_save_availability', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_teacher_calendar', 'nonce');

    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    $old_tz = e360_get_teacher_timezone_string($uid);
    $old_availability = e360_get_teacher_availability($uid);

    $tz = isset($_POST['timezone']) ? sanitize_text_field(wp_unslash($_POST['timezone'])) : '';
    if ($tz && in_array($tz, timezone_identifiers_list(), true)) {
        update_user_meta($uid, 'e360_teacher_timezone', $tz);
    } else {
        $tz = $old_tz;
    }

    $raw = isset($_POST['availability']) ? wp_unslash($_POST['availability']) : '[]';
    $arr = json_decode($raw, true);
    if (!is_array($arr)) $arr = [];

    $clean = e360_sanitize_availability($arr);
    update_user_meta($uid, 'e360_teacher_availability', $clean);
    e360_send_teacher_availability_notifications($uid, $old_availability, $clean, $old_tz, $tz);

    wp_send_json_success(['ok'=>1]);
});


/**
 * ====================
 * Booking storage (CPT)
 * ====================
 * post_type: e360_booking
 * meta:
 * teacher_id, student_id, course_id
 * repeat: 'once'|'weekly'
 * duration_min
 * once: start_ts_utc, end_ts_utc
 * weekly: weekday (mon..sun), start_min, end_min, start_date (Y-m-d)
 */
add_action('init', function(){
    register_post_type('e360_booking', [
        'label' => 'English360 Bookings',
        'public' => false,
        'show_ui' => false, // включи true если хочешь дебажить в админке
        'supports' => ['title'],
    ]);
});

function e360_booking_conflict_once(int $teacher_id, int $new_start_utc, int $new_end_utc, int $exclude_booking_id = 0): bool {
    $q = new WP_Query([
        'post_type' => 'e360_booking',
        'post_status' => ['publish','pending'],
        'posts_per_page' => 1,
        'fields' => 'ids',
        'meta_query' => [
            ['key'=>'teacher_id','value'=>$teacher_id,'compare'=>'=','type'=>'NUMERIC'],
            ['key'=>'repeat','value'=>'once','compare'=>'='],
            ['key'=>'start_ts_utc','value'=>$new_end_utc,'compare'=>'<','type'=>'NUMERIC'],
            ['key'=>'end_ts_utc','value'=>$new_start_utc,'compare'=>'>','type'=>'NUMERIC'],
        ],
    ]);

    if (!$q->have_posts()) return false;

    if ($exclude_booking_id) {
        foreach ($q->posts as $id) {
            if ((int)$id !== (int)$exclude_booking_id) return true;
        }
        return false;
    }
    return true;
}

function e360_booking_conflict_weekly(int $teacher_id, string $weekday, int $start_min, int $end_min, int $exclude_booking_id = 0): bool {
    $posts = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish','pending'],
        'numberposts' => -1,
        'fields' => 'ids',
        'meta_query' => [
            ['key'=>'teacher_id','value'=>$teacher_id,'compare'=>'=','type'=>'NUMERIC'],
            ['key'=>'repeat','value'=>'weekly','compare'=>'='],
            ['key'=>'weekday','value'=>$weekday,'compare'=>'='],
        ]
    ]);

    foreach ($posts as $pid) {
        $pid = (int)$pid;
        if ($exclude_booking_id && $pid === (int)$exclude_booking_id) continue;

        $s = (int) get_post_meta($pid, 'start_min', true);
        $e = (int) get_post_meta($pid, 'end_min', true);

        // overlap
        if ($s < $end_min && $start_min < $e) return true;
    }
    return false;
}

function e360_get_booked_intervals_for_date(int $teacher_id, string $ymd, int $duration_min): array {
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $weekday = e360_weekday_key_from_date($ymd, $tz);

    $dayStartLocal = new DateTimeImmutable($ymd . ' 00:00:00', $tz);
    $dayEndLocal   = $dayStartLocal->modify('+1 day');
    $dayStartUtc = (int) $dayStartLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
    $dayEndUtc   = (int) $dayEndLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();

    $intervals = [];

    // once bookings overlapping this day
    $q = new WP_Query([
        'post_type' => 'e360_booking',
        'post_status' => ['publish','pending'],
        'posts_per_page' => 200,
        'fields' => 'ids',
        'meta_query' => [
            ['key'=>'teacher_id','value'=>$teacher_id,'compare'=>'=','type'=>'NUMERIC'],
            ['key'=>'repeat','value'=>'once','compare'=>'='],
            ['key'=>'start_ts_utc','value'=>$dayEndUtc,'compare'=>'<','type'=>'NUMERIC'],
            ['key'=>'end_ts_utc','value'=>$dayStartUtc,'compare'=>'>','type'=>'NUMERIC'],
        ],
    ]);

    foreach ($q->posts as $pid) {
        $startUtc = (int) get_post_meta($pid, 'start_ts_utc', true);
        $endUtc   = (int) get_post_meta($pid, 'end_ts_utc', true);

        $startLocal = (new DateTimeImmutable('@' . $startUtc))->setTimezone($tz);
        $endLocal   = (new DateTimeImmutable('@' . $endUtc))->setTimezone($tz);

        // clamp to this date
        $sDay = $startLocal->format('Y-m-d');
        $eDay = $endLocal->format('Y-m-d');

        $sMin = ($sDay < $ymd) ? 0 : ((int)$startLocal->format('H'))*60 + (int)$startLocal->format('i');
        $eMin = ($eDay > $ymd) ? 24*60 : ((int)$endLocal->format('H'))*60 + (int)$endLocal->format('i');

        $intervals[] = [$sMin, $eMin];
    }

    // weekly bookings for this weekday
    $weekly = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish','pending'],
        'numberposts' => 200,
        'fields' => 'ids',
        'meta_query' => [
            ['key'=>'teacher_id','value'=>$teacher_id,'compare'=>'=','type'=>'NUMERIC'],
            ['key'=>'repeat','value'=>'weekly','compare'=>'='],
            ['key'=>'weekday','value'=>$weekday,'compare'=>'='],
        ],
    ]);

    foreach ($weekly as $pid) {
        $s = (int) get_post_meta((int)$pid, 'start_min', true);
        $e = (int) get_post_meta((int)$pid, 'end_min', true);
        if ($e > $s) $intervals[] = [$s, $e];
    }

    return $intervals;
}

function e360_generate_slots_for_teacher_date(int $teacher_id, string $ymd, int $duration_min): array {
    $availability = e360_get_teacher_availability($teacher_id);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $weekday = e360_weekday_key_from_date($ymd, $tz);

    $ranges = $availability[$weekday] ?? [];
    if (!is_array($ranges) || !$ranges) return [];

    $nowLocal = new DateTimeImmutable('now', $tz);
    $isToday = ($nowLocal->format('Y-m-d') === $ymd);
    $nowMin = ((int)$nowLocal->format('H'))*60 + (int)$nowLocal->format('i');

    $booked = e360_get_booked_intervals_for_date($teacher_id, $ymd, $duration_min);

    $slots = [];
    foreach ($ranges as $r) {
        $from = (string)($r['from'] ?? '');
        $to   = (string)($r['to'] ?? '');
        $start = e360_minutes_from_hhmm($from);
        $end   = e360_minutes_from_hhmm($to);
        if ($end <= $start) continue;

        // step by duration
        for ($m = $start; ($m + $duration_min) <= $end; $m += $duration_min) {
            if ($isToday && $m < $nowMin) continue;

            // conflict check against booked intervals
            $mEnd = $m + $duration_min;
            $conflict = false;
            foreach ($booked as $it) {
                if ($it[0] < $mEnd && $m < $it[1]) { $conflict = true; break; }
            }
            if ($conflict) continue;

            $slots[] = e360_hhmm_from_minutes($m);
        }
    }

    // unique + sort
    $slots = array_values(array_unique($slots));
    sort($slots);
    return $slots;
}

function e360_find_booking_for_student_course(int $student_id, int $course_id, int $teacher_id = 0): int {
    if (!$student_id || !$course_id) return 0;

    $meta = [
        ['key' => 'course_id', 'value' => $course_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ['key' => 'student_id', 'value' => $student_id, 'compare' => '=', 'type' => 'NUMERIC'],
    ];
    if ($teacher_id > 0) {
        $meta[] = ['key' => 'teacher_id', 'value' => $teacher_id, 'compare' => '=', 'type' => 'NUMERIC'];
    }

    $posts = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => 1,
        'fields' => 'ids',
        'orderby' => 'ID',
        'order' => 'DESC',
        'meta_query' => $meta,
    ]);

    return !empty($posts) ? (int) $posts[0] : 0;
}

/**
 * Create booking from saved booking ctx (called from your user_register hook)
 */
function e360_create_booking_from_context(int $student_id, array $ctx, array $opts = []): int {
    $require_credit = array_key_exists('require_credit', $opts) ? (bool)$opts['require_credit'] : true;
    $force_new = !empty($opts['force_new']);

    $teacher_id = (int)($ctx['teacher_id'] ?? 0);
    $course_id  = (int)($ctx['course_id'] ?? 0);
    $date       = sanitize_text_field((string)($ctx['date'] ?? ''));
    $time       = sanitize_text_field((string)($ctx['time'] ?? ''));
    $repeat     = sanitize_text_field((string)($ctx['repeat'] ?? 'weekly'));
    $duration   = (int)($ctx['duration'] ?? 60);

    if (!$teacher_id || !$course_id || !$date || !$time) return 0;

    if (!$force_new) {
        $existing = e360_find_booking_for_student_course($student_id, $course_id);
        if ($existing) return $existing;
    }

    // Optional: block booking if no credits
    if ($require_credit && function_exists('e360_get_credits_balance')) {
        $bal = (int) e360_get_credits_balance($student_id, $course_id);
        if ($bal <= 0) return 0;
    }

    $repeat = ($repeat === 'once') ? 'once' : 'weekly';
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));

    $post_id = wp_insert_post([
        'post_type' => 'e360_booking',
        'post_status' => 'publish',
        'post_title' => 'Booking: student ' . $student_id,
    ], true);

    if (is_wp_error($post_id) || !$post_id) return 0;

    update_post_meta($post_id, 'teacher_id', $teacher_id);
    update_post_meta($post_id, 'student_id', $student_id);
    update_post_meta($post_id, 'course_id',  $course_id);
    update_post_meta($post_id, 'repeat', $repeat);
    update_post_meta($post_id, 'duration_min', $duration);

    if ($repeat === 'once') {
        $hhmm = substr($time, 0, 5);
        $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $hhmm, $tz);
        if (!$dtLocal) {
            wp_delete_post($post_id, true);
            return 0;
        }

        $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
        $endUtc   = $startUtc + ($duration * 60);

        // final conflict check (race condition safety)
        if (e360_booking_conflict_once($teacher_id, $startUtc, $endUtc)) {
            wp_delete_post($post_id, true);
            return 0;
        }

        update_post_meta($post_id, 'start_ts_utc', $startUtc);
        update_post_meta($post_id, 'end_ts_utc', $endUtc);
        update_post_meta($post_id, 'local_date', $date);
        update_post_meta($post_id, 'local_time', $hhmm);

    } else {
        // weekly
        $weekday = e360_weekday_key_from_date($date, $tz);
        $startMin = e360_minutes_from_hhmm(substr($time,0,5));
        $endMin   = $startMin + $duration;

        if (e360_booking_conflict_weekly($teacher_id, $weekday, $startMin, $endMin)) {
            wp_delete_post($post_id, true);
            return 0;
        }

        update_post_meta($post_id, 'weekday', $weekday);
        update_post_meta($post_id, 'start_min', $startMin);
        update_post_meta($post_id, 'end_min', $endMin);
        update_post_meta($post_id, 'start_date', $date);
    }

    return (int) $post_id;
}

function e360_booking_next_occurrence_ts(int $booking_id): int {
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    if ($repeat === 'once') {
        $startUtc = (int) get_post_meta($booking_id, 'start_ts_utc', true);
        if ($startUtc <= 0) return 0;
        return ($startUtc >= current_time('timestamp', true)) ? $startUtc : 0;
    }

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $weekday = (string) get_post_meta($booking_id, 'weekday', true);
    $startMin = (int) get_post_meta($booking_id, 'start_min', true);
    $startDate = (string) get_post_meta($booking_id, 'start_date', true);
    if ($startMin < 0 || $startMin > 1439) return 0;

    $map = ['mon' => 1, 'tue' => 2, 'wed' => 3, 'thu' => 4, 'fri' => 5, 'sat' => 6, 'sun' => 7];
    $want = $map[$weekday] ?? 0;
    if ($want === 0) return 0;

    $now = new DateTimeImmutable('now', $tz);
    $base = $now;
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
        try {
            $startLocal = new DateTimeImmutable($startDate . ' 00:00:00', $tz);
            if ($startLocal > $base) $base = $startLocal;
        } catch (Exception $e) {}
    }

    $delta = ($want - (int)$base->format('N') + 7) % 7;
    $candidate = $base->modify('+' . $delta . ' day');
    $candidateYmd = $candidate->format('Y-m-d');

    // If slot is today and already passed, move to next week.
    if ($candidateYmd === $now->format('Y-m-d')) {
        $nowMin = ((int)$now->format('H')) * 60 + (int)$now->format('i');
        if ($startMin <= $nowMin) {
            $candidate = $candidate->modify('+7 day');
            $candidateYmd = $candidate->format('Y-m-d');
        }
    }

    $hhmm = e360_hhmm_from_minutes($startMin);
    $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $candidateYmd . ' ' . $hhmm, $tz);
    if (!$dtLocal) return 0;

    return (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
}

/**
 * Next occurrence helper
 */
function e360_next_occurrence_label(int $booking_id): array {
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $nextUtc = e360_booking_next_occurrence_ts($booking_id);
    if (!$nextUtc) {
        return [
            'type' => ($repeat === 'once') ? 'one-time' : 'weekly',
            'when' => 'not scheduled',
            'tz'   => $tz->getName(),
        ];
    }
    $dt = (new DateTimeImmutable('@' . $nextUtc))->setTimezone($tz);
    $when = $dt->format('Y-m-d H:i');
    if ($repeat !== 'once') $when .= ' (weekly)';

    return [
        'type' => ($repeat === 'once') ? 'one-time' : 'weekly',
        'when' => $when,
        'tz'   => $tz->getName(),
    ];
}

/**
 * ======================
 * Teacher reschedule AJAX
 * ======================
 */
add_action('wp_ajax_e360_reschedule_booking', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_reschedule', 'nonce');

    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $date = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $time = isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '';
    $repeat = isset($_POST['repeat']) ? sanitize_text_field(wp_unslash($_POST['repeat'])) : 'once';

    if (!$booking_id || !$date || !$time) wp_send_json_error(['message'=>'Missing data'], 400);

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    if (!$teacher_id) wp_send_json_error(['message'=>'Invalid booking'], 400);

    // teacher owns booking (or admin)
    if (!current_user_can('manage_options') && $teacher_id !== $uid) {
        wp_send_json_error(['message'=>'Not your booking'], 403);
    }

    $duration = (int) get_post_meta($booking_id, 'duration_min', true);
    if ($duration <= 0) $duration = 60;

    $repeat = ($repeat === 'weekly') ? 'weekly' : 'once';
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));

    update_post_meta($booking_id, 'repeat', $repeat);

    if ($repeat === 'once') {
        $hhmm = substr($time,0,5);
        $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date.' '.$hhmm, $tz);
        if (!$dtLocal) wp_send_json_error(['message'=>'Bad datetime'], 400);

        $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
        $endUtc = $startUtc + $duration*60;

        if (e360_booking_conflict_once($teacher_id, $startUtc, $endUtc, $booking_id)) {
            wp_send_json_error(['message'=>'Time is already booked'], 409);
        }

        update_post_meta($booking_id, 'start_ts_utc', $startUtc);
        update_post_meta($booking_id, 'end_ts_utc', $endUtc);
        update_post_meta($booking_id, 'local_date', $date);
        update_post_meta($booking_id, 'local_time', $hhmm);

        // cleanup weekly meta
        delete_post_meta($booking_id, 'weekday');
        delete_post_meta($booking_id, 'start_min');
        delete_post_meta($booking_id, 'end_min');
        delete_post_meta($booking_id, 'start_date');

    } else {
        $weekday = e360_weekday_key_from_date($date, $tz);
        $startMin = e360_minutes_from_hhmm(substr($time,0,5));
        $endMin = $startMin + $duration;

        if (e360_booking_conflict_weekly($teacher_id, $weekday, $startMin, $endMin, $booking_id)) {
            wp_send_json_error(['message'=>'Weekly slot is already booked'], 409);
        }

        update_post_meta($booking_id, 'weekday', $weekday);
        update_post_meta($booking_id, 'start_min', $startMin);
        update_post_meta($booking_id, 'end_min', $endMin);
        update_post_meta($booking_id, 'start_date', $date);

        // cleanup once meta
        delete_post_meta($booking_id, 'start_ts_utc');
        delete_post_meta($booking_id, 'end_ts_utc');
        delete_post_meta($booking_id, 'local_date');
        delete_post_meta($booking_id, 'local_time');
    }

    $label = e360_next_occurrence_label($booking_id);
    wp_send_json_success(['label'=>$label]);
});


/**
 * ==========================
 * Course page: show schedule
 * student + teacher (and reschedule UI for teacher)
 * ==========================
 */
function e360_user_public_label_simple(int $uid): string {
    $u = get_user_by('id', $uid);
    if (!$u) return 'User #' . $uid;
    $first = (string) get_user_meta($uid, 'first_name', true);
    $last  = (string) get_user_meta($uid, 'last_name', true);
    $label = trim($first . ' ' . ($last ? mb_substr($last,0,1).'.' : ''));
    return $label !== '' ? $label : (string)$u->display_name;
}

function e360_get_teacher_bookings(int $teacher_id, int $course_id = 0, int $limit = 100): array {
    if ($teacher_id <= 0) return [];

    $meta = [
        ['key' => 'teacher_id', 'value' => $teacher_id, 'compare' => '=', 'type' => 'NUMERIC'],
    ];
    if ($course_id > 0) {
        $meta[] = ['key' => 'course_id', 'value' => $course_id, 'compare' => '=', 'type' => 'NUMERIC'];
    }

    $ids = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => $limit,
        'fields' => 'ids',
        'orderby' => 'ID',
        'order' => 'DESC',
        'meta_query' => $meta,
    ]);

    if (!$ids || $course_id <= 0 || !function_exists('e360_is_student_enrolled_in_course')) {
        return $ids;
    }

    $filtered = [];
    foreach ($ids as $bid) {
        $sid = (int) get_post_meta((int)$bid, 'student_id', true);
        if ($sid > 0 && e360_is_student_enrolled_in_course($sid, $course_id)) {
            $filtered[] = (int)$bid;
        }
    }

    return $filtered;
}

function e360_render_teacher_bookings_box(array $booking_ids, array $args = []): string {
    if (!$booking_ids) return '';

    $args = wp_parse_args($args, [
        'box_id' => 'e360-teacher-bookings-box',
        'title' => 'Lesson schedule (teacher)',
        'show_course' => false,
        'show_teacher' => false,
        'button_class' => 'tutor-btn tutor-btn-outline-primary tutor-btn-sm',
        'container_style' => 'margin-top:14px;',
        'can_edit' => true,
    ]);

    $box_id = preg_replace('/[^a-zA-Z0-9\-_]/', '', (string)$args['box_id']);
    if ($box_id === '') $box_id = 'e360-teacher-bookings-box';

    $nonce = wp_create_nonce('e360_reschedule');
    $slots_nonce = wp_create_nonce('e360_booking_nonce');
    $ajax = admin_url('admin-ajax.php');
    $show_course = !empty($args['show_course']);
    $show_teacher = !empty($args['show_teacher']);
    $can_edit = !empty($args['can_edit']);
    $button_class = (string)$args['button_class'];
    $container_style = (string)$args['container_style'];

    $out  = '<div id="' . esc_attr($box_id) . '" class="tutor-course-progress-wrapper tutor-mb-32" style="' . esc_attr($container_style) . '"';
    $out .= ' data-ajax="' . esc_attr($ajax) . '" data-nonce="' . esc_attr($nonce) . '" data-slots-nonce="' . esc_attr($slots_nonce) . '">';
    $out .= '<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">' . esc_html((string)$args['title']) . '</h3>';
    $out .= '<div style="display:flex;flex-direction:column;gap:10px;">';

    foreach ($booking_ids as $bid) {
        $bid = (int)$bid;
        $student_id = (int) get_post_meta($bid, 'student_id', true);
        $teacher_id = (int) get_post_meta($bid, 'teacher_id', true);
        $course_id = (int) get_post_meta($bid, 'course_id', true);
        $label = e360_next_occurrence_label($bid);
        $student_label = e360_user_public_label_simple($student_id);
        $teacher_label = e360_user_public_label_simple($teacher_id);
        $course_title = $course_id ? get_the_title($course_id) : '';

        $out .= '<div style="border-top:1px solid #f0f0f0;padding-top:8px;">';
        $out .= '<div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;">';
        $out .= '<div>';
        $out .= '<div style="font-weight:600;">' . esc_html($student_label) . '</div>';
        if ($show_teacher) {
            $out .= '<div style="opacity:.8;font-size:13px;">Teacher: ' . esc_html($teacher_label) . '</div>';
        }
        if ($show_course && $course_title) {
            $out .= '<div style="opacity:.8;font-size:13px;">Course: ' . esc_html($course_title) . '</div>';
        }
        $out .= '<div style="opacity:.85;font-size:13px;">' . esc_html($label['when']) . '</div>';
        $out .= '<div style="opacity:.65;font-size:12px;">TZ: ' . esc_html($label['tz']) . '</div>';
        $out .= '</div>';

        if ($can_edit) {
            $out .= '<div style="text-align:right;">';
            $out .= '<button type="button" class="' . esc_attr($button_class) . ' e360-open-reschedule" data-booking-id="' . (int)$bid . '" data-teacher-id="' . (int)$teacher_id . '">Reschedule</button>';
            $out .= '</div>';
        }

        $out .= '</div></div>';
    }

    if ($can_edit) {
    $out .= '
    <div class="e360-reschedule-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:99999;padding:20px;">
      <div style="max-width:520px;margin:40px auto;background:#fff;border-radius:12px;padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div style="font-weight:700;">Reschedule lesson</div>
            <button type="button" class="e360-close-modal tutor-iconic-btn"><span class="tutor-icon-times"></span></button>
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Type</label>
            <select class="e360-reschedule-repeat tutor-form-select">
                <option value="once">One-time</option>
                <option value="weekly">Weekly</option>
            </select>
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Date</label>
            <input type="date" class="e360-reschedule-date tutor-form-control" />
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Time</label>
            <select class="e360-reschedule-time tutor-form-select">
                <option value="">Select date first…</option>
            </select>
        </div>

        <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
            <button type="button" class="e360-save-reschedule tutor-btn tutor-btn-primary">Save</button>
            <span class="e360-reschedule-msg" style="opacity:.8;"></span>
        </div>
      </div>
    </div>';
    }

    $out .= '</div></div>';

    if ($can_edit) {
    $out .= '<script>
    (function(){
        var box = document.getElementById("' . esc_js($box_id) . '");
        if (!box || box.getAttribute("data-bound") === "1") return;
        box.setAttribute("data-bound", "1");

        var modal = box.querySelector(".e360-reschedule-modal");
        var repeatEl = box.querySelector(".e360-reschedule-repeat");
        var dateEl = box.querySelector(".e360-reschedule-date");
        var timeEl = box.querySelector(".e360-reschedule-time");
        var saveBtn = box.querySelector(".e360-save-reschedule");
        var msgEl = box.querySelector(".e360-reschedule-msg");
        var closeBtn = box.querySelector(".e360-close-modal");

        var currentBookingId = 0;
        var currentTeacherId = 0;

        function setMsg(t){ msgEl.textContent = t || ""; }
        function openModal(bookingId, teacherId){
            currentBookingId = parseInt(bookingId,10) || 0;
            currentTeacherId = parseInt(teacherId,10) || 0;
            setMsg("");
            modal.style.display = "block";
        }
        function closeModal(){
            modal.style.display = "none";
            currentBookingId = 0;
            currentTeacherId = 0;
        }
        function post(params){
            return fetch(box.getAttribute("data-ajax"), {
                method: "POST",
                credentials: "same-origin",
                headers: { "Content-Type":"application/x-www-form-urlencoded; charset=UTF-8" },
                body: (new URLSearchParams(params)).toString()
            }).then(function(r){ return r.json(); });
        }

        box.addEventListener("click", function(e){
            var btn = e.target.closest(".e360-open-reschedule");
            if (btn){
                openModal(btn.getAttribute("data-booking-id"), btn.getAttribute("data-teacher-id"));
            }
        });

        closeBtn.addEventListener("click", closeModal);
        modal.addEventListener("click", function(e){
            if (e.target === modal) closeModal();
        });

        dateEl.addEventListener("change", function(){
            var date = this.value || "";
            timeEl.innerHTML = "<option value=\\"\\">Loading…</option>";
            if (!date || !currentTeacherId) return;

            post({
                action: "e360_get_slots",
                nonce: box.getAttribute("data-slots-nonce") || "",
                teacher_id: currentTeacherId,
                date: date,
                duration: 60
            }).then(function(resp){
                if (!resp || !resp.success){
                    timeEl.innerHTML = "<option value=\\"\\">Error</option>";
                    return;
                }
                var slots = (resp.data && resp.data.slots) ? resp.data.slots : [];
                if (!slots.length){
                    timeEl.innerHTML = "<option value=\\"\\">No available slots</option>";
                    return;
                }
                timeEl.innerHTML = "<option value=\\"\\">Select…</option>";
                slots.forEach(function(s){
                    var opt = document.createElement("option");
                    opt.value = s;
                    opt.textContent = (s || "").substring(0,5);
                    timeEl.appendChild(opt);
                });
            });
        });

        saveBtn.addEventListener("click", function(){
            if (!currentBookingId) return;
            var date = dateEl.value || "";
            var time = timeEl.value || "";
            var repeat = repeatEl.value || "once";
            if (!date || !time){
                setMsg("Select date and time");
                return;
            }
            setMsg("Saving…");
            post({
                action: "e360_reschedule_booking",
                nonce: box.getAttribute("data-nonce"),
                booking_id: currentBookingId,
                date: date,
                time: time,
                repeat: repeat
            }).then(function(resp){
                if (!resp || !resp.success){
                    var m = resp && resp.data && resp.data.message ? resp.data.message : "Error";
                    setMsg(m);
                    return;
                }
                setMsg("Saved");
                window.location.reload();
            });
        });
    })();
    </script>';
    }

    return $out;
}

function e360_course_schedule_box_html(int $course_id, int $uid): string {
    $is_teacher = current_user_can('tutor_instructor') || current_user_can('manage_options');
    $out = '';

    if (!$is_teacher) {
        // student: find booking for this student+course
        $posts = get_posts([
            'post_type' => 'e360_booking',
            'post_status' => ['publish','pending'],
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => [
                ['key'=>'course_id','value'=>$course_id,'compare'=>'=','type'=>'NUMERIC'],
                ['key'=>'student_id','value'=>$uid,'compare'=>'=','type'=>'NUMERIC'],
            ]
        ]);

        if (!$posts) return '';

        $bid = (int)$posts[0];
        $label = e360_next_occurrence_label($bid);

        $out .= '<div class="tutor-course-progress-wrapper tutor-mb-32" style="margin-top:14px;">';
        $out .= '<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">Your lesson schedule</h3>';
        $out .= '<div style="font-size:14px;">';
        $out .= '<div><strong>Next:</strong> ' . esc_html($label['when']) . '</div>';
        $out .= '<div style="opacity:.75;">Timezone: ' . esc_html($label['tz']) . '</div>';
        $out .= '</div></div>';
        return $out;
    }

    // teacher: list bookings for this course
    $teacher_id = $uid;
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, 50);
    if (!$bookings) return '';

    return e360_render_teacher_bookings_box($bookings, [
        'box_id' => 'e360-teacher-schedule-box',
        'title' => 'Lesson schedule (teacher)',
        'show_course' => false,
        'show_teacher' => false,
        'button_class' => 'tutor-btn tutor-btn-outline-primary tutor-btn-sm',
        'container_style' => 'margin-top:14px;',
    ]);
}

add_action('wp_footer', function(){

    static $done = false;
    if ($done) return;
    $done = true;
    
    if (!is_singular(['courses', 'tutor_course'])) return;
    if (!is_user_logged_in()) return;

    $course_id = (int) get_the_ID();
    $uid = get_current_user_id();
    if (function_exists('e360_is_course_instructor') && e360_is_course_instructor($uid, $course_id)) {
        // Teacher schedule is rendered in a dedicated course tab.
        return;
    }

    $html = e360_course_schedule_box_html($course_id, $uid);
    if ($html === '') return;

    ?>
<div id="e360-course-schedule-box" style="display:none;"><?php echo $html; ?></div>
<script>
(function() {
    var box = document.getElementById("e360-course-schedule-box");
    if (!box) return;

    var target =
        document.querySelector(".tutor-sidebar-card .tutor-card-body") ||
        document.querySelector(".courses-details-info .tutor-card-body");

    if (!target) return;

    box.style.display = "block";
    if (target.querySelector('#e360-course-schedule-box')) return;

    target.appendChild(box);
})();
</script>
<?php
});

function e360_course_teacher_schedule_tab_html(int $course_id, int $teacher_id, bool $can_edit = true): string {
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, 100);

    $out = '<div style="padding:8px 0 4px;">';
    $out .= '<h4 style="margin:0 0 8px;">Course schedule</h4>';
    $out .= '<div style="opacity:.8;margin-bottom:10px;">Reschedule lessons within your available hours.</div>';

    if (!$bookings) {
        $out .= '<div style="padding:10px;border:1px solid #ececec;border-radius:8px;opacity:.8;">No booked lessons yet for this course.</div>';
        $out .= '</div>';
        return $out;
    }

    $out .= e360_render_teacher_bookings_box($bookings, [
        'box_id' => 'e360-course-tab-bookings-' . $course_id . '-' . $teacher_id,
        'title' => 'Booked lessons',
        'show_course' => false,
        'show_teacher' => false,
        'button_class' => 'tutor-btn tutor-btn-outline-primary tutor-btn-sm',
        'container_style' => 'margin-top:0;',
        'can_edit' => $can_edit,
    ]);
    $out .= '</div>';

    return $out;
}

function e360_can_manage_course_schedule(int $user_id, int $course_id): bool {
    if (!$user_id || !$course_id) return false;
    if (!is_user_logged_in()) return false;
    if (user_can($user_id, 'manage_options')) return true;
    if (function_exists('e360_is_course_instructor') && e360_is_course_instructor($user_id, $course_id)) {
        return true;
    }
    // Fallback: teacher has at least one booking for this course.
    $has_booking = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => 1,
        'fields' => 'ids',
        'meta_query' => [
            ['key' => 'teacher_id', 'value' => $user_id, 'compare' => '=', 'type' => 'NUMERIC'],
            ['key' => 'course_id', 'value' => $course_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ],
    ]);
    return !empty($has_booking);
}

function e360_can_view_course_schedule_tab(int $user_id, int $course_id): bool {
    if (!$user_id || !$course_id) return false;
    return is_user_logged_in();
}

function e360_resolve_schedule_teacher_id_for_viewer(int $course_id, int $viewer_id): int {
    if ($course_id <= 0) return 0;
    if ($viewer_id > 0 && e360_can_manage_course_schedule($viewer_id, $course_id)) {
        return $viewer_id;
    }

    if ($viewer_id > 0) {
        $booking_id = function_exists('e360_find_booking_for_student_course')
            ? e360_find_booking_for_student_course($viewer_id, $course_id)
            : 0;
        if ($booking_id) {
            $tid = (int) get_post_meta($booking_id, 'teacher_id', true);
            if ($tid > 0) return $tid;
        }
    }

    return (int) get_post_field('post_author', $course_id);
}

// Native Tutor LMS tab (works when theme/template uses Tutor tab hooks)
add_filter('tutor_course/single/nav_items', function($items, $course_id = 0){
    $uid = get_current_user_id();
    $course_id = (int)$course_id;
    if (!$course_id && is_singular(['courses', 'tutor_course'])) $course_id = (int)get_the_ID();
    if (!e360_can_view_course_schedule_tab($uid, $course_id)) return $items;

    if (!is_array($items)) $items = [];
    if (!isset($items['e360_schedule'])) {
        $items['e360_schedule'] = [
            'title' => __('Schedule', 'english360-lessons'),
        ];
    }
    return $items;
}, 30, 2);

add_action('tutor_course/single/tab/e360_schedule', function(){
    $course_id = (int) get_the_ID();
    $uid = (int) get_current_user_id();
    if (!e360_can_view_course_schedule_tab($uid, $course_id)) return;
    $teacher_id = e360_resolve_schedule_teacher_id_for_viewer($course_id, $uid);
    if ($teacher_id <= 0) return;
    echo e360_course_teacher_schedule_tab_html($course_id, $teacher_id, e360_can_manage_course_schedule($uid, $course_id));
});

add_action('wp_footer', function () {
    if (!is_singular(['courses', 'tutor_course'])) return;
    if (!is_user_logged_in()) return;

    $course_id = (int) get_the_ID();
    $uid = (int) get_current_user_id();
    if (!$course_id || !$uid) return;
    if (!e360_can_view_course_schedule_tab($uid, $course_id)) return;

    $teacher_id = e360_resolve_schedule_teacher_id_for_viewer($course_id, $uid);
    if ($teacher_id <= 0) return;

    $html = e360_course_teacher_schedule_tab_html($course_id, $teacher_id, e360_can_manage_course_schedule($uid, $course_id));
    if ($html === '') return;
    ?>
<div id="e360-course-teacher-schedule-tab-content" style="display:none;"><?php echo $html; ?></div>
<script>
(function() {
    function tryMount() {
        var src = document.getElementById('e360-course-teacher-schedule-tab-content');
        if (!src) return false;
        if (document.getElementById('e360-course-schedule-tab-nav')) return true;

        // If native Tutor hook already rendered the tab, JS fallback is not needed.
        if (document.querySelector(
                '[href="#e360-course-schedule-tab-pane"], [data-bs-target="#e360-course-schedule-tab-pane"]'))
            return true;

        var content = null;
        var tabNav = document.querySelector('#myTab');
        if (tabNav) {
            content = tabNav.parentElement ? tabNav.parentElement.querySelector('.tab-content') : null;
            if (!content) content = document.querySelector('.tab-content');
        }
        if (!content) content = document.querySelector('.tutor-course-details-content');
        if (!content) content = document.querySelector('.tutor-tab-content');
        if (!content) content = document.querySelector('.tab-content');
        var nav =
            document.querySelector('#myTab.nav.nav-tabs') ||
            document.querySelector('#myTab') ||
            document.querySelector('.tutor-course-details-tab .tutor-nav') ||
            document.querySelector('.tutor-nav-tabs') ||
            document.querySelector('.tutor-course-details-tab ul') ||
            document.querySelector('ul.tutor-nav') ||
            (content ? content.previousElementSibling : null);

        if (!nav || !content) return false;

        var firstCtrl =
            nav.querySelector('a[href^="#"]') ||
            nav.querySelector('[data-bs-toggle="tab"]') ||
            nav.querySelector('button[data-bs-target]') ||
            nav.querySelector('button');
        var firstPane =
            content.querySelector('.active[id]') ||
            content.querySelector('.show[id]') ||
            content.querySelector('[id]');
        if (!firstCtrl || !firstPane) return false;

        var tabId = 'e360-course-schedule-tab-pane';

        var li = document.createElement('li');
        li.id = 'e360-course-schedule-tab-nav';
        var firstItem = firstCtrl.closest('li');
        li.className = firstItem ? (firstItem.className || '') : '';
        li.classList.remove('active', 'is-active');

        var ctrl;
        if ((firstCtrl.tagName || '').toLowerCase() === 'button') {
            ctrl = document.createElement('button');
            ctrl.type = 'button';
            ctrl.className = firstCtrl.className || '';
            ctrl.classList.remove('active');
            ctrl.setAttribute('data-bs-toggle', 'tab');
            ctrl.setAttribute('data-bs-target', '#' + tabId);
            ctrl.setAttribute('aria-controls', tabId);
            ctrl.setAttribute('role', 'tab');
            ctrl.setAttribute('aria-selected', 'false');
            ctrl.textContent = 'Schedule';
        } else {
            ctrl = document.createElement('a');
            ctrl.href = '#' + tabId;
            ctrl.setAttribute('data-toggle', 'tab');
            ctrl.setAttribute('data-bs-toggle', 'tab');
            ctrl.className = firstCtrl.className || '';
            ctrl.classList.remove('active');
            ctrl.setAttribute('aria-selected', 'false');
            ctrl.textContent = 'Schedule';
        }
        if (firstItem) {
            li.appendChild(ctrl);
            nav.appendChild(li);
        } else {
            ctrl.id = 'e360-course-schedule-tab-nav';
            nav.appendChild(ctrl);
        }

        var pane = document.createElement('div');
        pane.id = tabId;
        pane.className = firstPane.className || '';
        pane.className = pane.className.replace(/\bactive\b/g, '').replace(/\bshow\b/g, '').trim();
        while (src.firstChild) {
            pane.appendChild(src.firstChild);
        }
        content.appendChild(pane);
        src.remove();

        function activate(controlEl) {
            var controls = nav.querySelectorAll('a,button');
            controls.forEach(function(c) {
                c.classList.remove('active');
                c.setAttribute('aria-selected', 'false');
                var parent = c.closest('li');
                if (parent) parent.classList.remove('active', 'is-active');
            });

            var panes = content.querySelectorAll('[id]');
            for (var i = 0; i < panes.length; i++) {
                panes[i].classList.remove('active');
                panes[i].classList.remove('show');
            }

            controlEl.classList.add('active');
            controlEl.setAttribute('aria-selected', 'true');
            var p = controlEl.closest('li');
            if (p) p.classList.add('active', 'is-active');
            pane.classList.add('active');
            pane.classList.add('show');
        }

        ctrl.addEventListener('click', function(e) {
            e.preventDefault();
            activate(ctrl);
        });
        return true;
    }

    if (tryMount()) return;
    var attempts = 0;
    var t = setInterval(function() {
        attempts++;
        if (tryMount() || attempts >= 20) clearInterval(t);
    }, 300);
})();
</script>
<?php
});

add_shortcode('e360_teacher_bookings_manager', function($atts){
    if (!is_user_logged_in()) return '<p>Please log in.</p>';
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        return '<p>Only instructors can manage bookings.</p>';
    }

    $atts = shortcode_atts([
        'teacher_id' => 0,
        'course_id' => 0,
        'limit' => 100,
        'title' => 'My lesson bookings',
    ], $atts);

    $viewer_id = get_current_user_id();
    $teacher_id = (int)$atts['teacher_id'];
    if (!current_user_can('manage_options') || $teacher_id <= 0) {
        $teacher_id = $viewer_id;
    }

    $course_id = (int)$atts['course_id'];
    $limit = max(1, min(500, (int)$atts['limit']));
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, $limit);
    if (!$bookings) {
        return '<div class="tutor-course-progress-wrapper tutor-mb-32" style="margin-top:14px;"><h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">' . esc_html((string)$atts['title']) . '</h3><div style="opacity:.75;">No bookings yet.</div></div>';
    }

    return e360_render_teacher_bookings_box($bookings, [
        'box_id' => 'e360-teacher-bookings-manager-' . $teacher_id . '-' . $course_id,
        'title' => (string)$atts['title'],
        'show_course' => true,
        'show_teacher' => false,
        'button_class' => 'tutor-btn tutor-btn-outline-primary tutor-btn-sm',
        'container_style' => 'margin-top:14px;',
    ]);
});

add_action('admin_menu', function(){
    if (!is_user_logged_in()) return;
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    add_menu_page(
        'E360 Bookings',
        'E360 Bookings',
        'read',
        'e360-bookings',
        'e360_render_admin_bookings_page',
        'dashicons-calendar-alt',
        58
    );
});

function e360_render_admin_bookings_page(): void {
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_die('Forbidden');
    }

    $is_admin = current_user_can('manage_options');
    $viewer_id = get_current_user_id();
    $teacher_filter = isset($_GET['teacher_id']) ? (int)$_GET['teacher_id'] : 0;

    if (!$is_admin || $teacher_filter <= 0) {
        $teacher_filter = $viewer_id;
    }

    $bookings = [];
    if ($is_admin && isset($_GET['teacher_id']) && (int)$_GET['teacher_id'] === 0) {
        $bookings = get_posts([
            'post_type' => 'e360_booking',
            'post_status' => ['publish', 'pending'],
            'numberposts' => 200,
            'fields' => 'ids',
            'orderby' => 'ID',
            'order' => 'DESC',
        ]);
    } else {
        $bookings = e360_get_teacher_bookings($teacher_filter, 0, 200);
    }

    echo '<div class="wrap">';
    echo '<h1>E360 Bookings</h1>';
    echo '<p>Manage lesson time reservations. Changes here are applied immediately.</p>';

    if ($is_admin) {
        echo '<form method="get" style="margin:0 0 14px;">';
        echo '<input type="hidden" name="page" value="e360-bookings" />';
        echo '<label for="e360-teacher-filter" style="margin-right:6px;">Teacher ID:</label>';
        echo '<input id="e360-teacher-filter" type="number" name="teacher_id" min="0" value="' . esc_attr((string)$teacher_filter) . '" />';
        echo ' <button class="button button-secondary" type="submit">Filter</button>';
        echo ' <a class="button" href="' . esc_url(admin_url('admin.php?page=e360-bookings&teacher_id=0')) . '">All teachers</a>';
        echo '</form>';
    }

    if (!$bookings) {
        echo '<div class="notice notice-info"><p>No bookings found.</p></div>';
        echo '</div>';
        return;
    }

    echo e360_render_teacher_bookings_box($bookings, [
        'box_id' => 'e360-admin-bookings-box',
        'title' => 'Bookings list',
        'show_course' => true,
        'show_teacher' => $is_admin,
        'button_class' => 'button button-secondary',
        'container_style' => 'margin-top:8px;background:#fff;padding:12px;border:1px solid #ccd0d4;border-radius:8px;',
    ]);

    echo '</div>';
}