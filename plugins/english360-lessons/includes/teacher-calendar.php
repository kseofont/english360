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
    ?>
<h2>English360</h2>
<table class="form-table" role="presentation">
    <tr>
        <th><label for="e360_teacher_timezone">Teacher timezone</label></th>
        <td>
            <select name="e360_teacher_timezone" id="e360_teacher_timezone" class="regular-text">
                <?php echo wp_timezone_choice($current); ?>
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
            <select class="e360-tz" style="min-width:320px;">
                <?php echo wp_timezone_choice($tz); ?>
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

    $tz = isset($_POST['timezone']) ? sanitize_text_field(wp_unslash($_POST['timezone'])) : '';
    if ($tz && in_array($tz, timezone_identifiers_list(), true)) {
        update_user_meta($uid, 'e360_teacher_timezone', $tz);
    }

    $raw = isset($_POST['availability']) ? wp_unslash($_POST['availability']) : '[]';
    $arr = json_decode($raw, true);
    if (!is_array($arr)) $arr = [];

    $clean = e360_sanitize_availability($arr);
    update_user_meta($uid, 'e360_teacher_availability', $clean);

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

/**
 * Create booking from saved booking ctx (called from your user_register hook)
 */
function e360_create_booking_from_context(int $student_id, array $ctx) {
    $teacher_id = (int)($ctx['teacher_id'] ?? 0);
    $course_id  = (int)($ctx['course_id'] ?? 0);
    $date       = sanitize_text_field((string)($ctx['date'] ?? ''));
    $time       = sanitize_text_field((string)($ctx['time'] ?? ''));
    $repeat     = sanitize_text_field((string)($ctx['repeat'] ?? 'weekly'));
    $duration   = (int)($ctx['duration'] ?? 60);

    if (!$teacher_id || !$course_id || !$date || !$time) return;

    // Optional: block booking if no credits
    if (function_exists('e360_get_credits_balance')) {
        $bal = (int) e360_get_credits_balance($student_id, $course_id);
        if ($bal <= 0) return;
    }

    $repeat = ($repeat === 'once') ? 'once' : 'weekly';
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));

    $post_id = wp_insert_post([
        'post_type' => 'e360_booking',
        'post_status' => 'publish',
        'post_title' => 'Booking: student ' . $student_id,
    ], true);

    if (is_wp_error($post_id) || !$post_id) return;

    update_post_meta($post_id, 'teacher_id', $teacher_id);
    update_post_meta($post_id, 'student_id', $student_id);
    update_post_meta($post_id, 'course_id',  $course_id);
    update_post_meta($post_id, 'repeat', $repeat);
    update_post_meta($post_id, 'duration_min', $duration);

    if ($repeat === 'once') {
        $hhmm = substr($time, 0, 5);
        $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $hhmm, $tz);
        if (!$dtLocal) return;

        $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
        $endUtc   = $startUtc + ($duration * 60);

        // final conflict check (race condition safety)
        if (e360_booking_conflict_once($teacher_id, $startUtc, $endUtc)) {
            wp_delete_post($post_id, true);
            return;
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
            return;
        }

        update_post_meta($post_id, 'weekday', $weekday);
        update_post_meta($post_id, 'start_min', $startMin);
        update_post_meta($post_id, 'end_min', $endMin);
        update_post_meta($post_id, 'start_date', $date);
    }
}

/**
 * Next occurrence helper
 */
function e360_next_occurrence_label(int $booking_id): array {
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));

    if ($repeat === 'once') {
        $startUtc = (int) get_post_meta($booking_id, 'start_ts_utc', true);
        $dt = (new DateTimeImmutable('@' . $startUtc))->setTimezone($tz);
        return [
            'type' => 'one-time',
            'when' => $dt->format('Y-m-d H:i'),
            'tz'   => $tz->getName(),
        ];
    }

    // weekly
    $weekday = (string) get_post_meta($booking_id, 'weekday', true);
    $startMin = (int) get_post_meta($booking_id, 'start_min', true);
    $hhmm = e360_hhmm_from_minutes($startMin);

    // compute next date matching weekday
    $map = ['mon'=>1,'tue'=>2,'wed'=>3,'thu'=>4,'fri'=>5,'sat'=>6,'sun'=>7];
    $want = $map[$weekday] ?? 1;

    $now = new DateTimeImmutable('now', $tz);
    $todayN = (int)$now->format('N');
    $delta = ($want - $todayN + 7) % 7;
    $candidate = $now->modify('+' . $delta . ' day');
    $candidateYmd = $candidate->format('Y-m-d');

    // if same day but time already passed, move +7 days
    $nowMin = ((int)$now->format('H'))*60 + (int)$now->format('i');
    if ($delta === 0 && $startMin <= $nowMin) {
        $candidateYmd = $now->modify('+7 day')->format('Y-m-d');
    }

    return [
        'type' => 'weekly',
        'when' => $candidateYmd . ' ' . $hhmm . ' (weekly)',
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
    $bookings = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish','pending'],
        'numberposts' => 50,
        'fields' => 'ids',
        'meta_query' => [
            ['key'=>'course_id','value'=>$course_id,'compare'=>'=','type'=>'NUMERIC'],
            ['key'=>'teacher_id','value'=>$teacher_id,'compare'=>'=','type'=>'NUMERIC'],
        ]
    ]);
    if (!$bookings) return '';

    $nonce = wp_create_nonce('e360_reschedule');
    $ajax  = admin_url('admin-ajax.php');

    $out .= '<div id="e360-teacher-schedule-box" class="tutor-course-progress-wrapper tutor-mb-32" style="margin-top:14px;" data-ajax="'.esc_attr($ajax).'" data-nonce="'.esc_attr($nonce).'">';
    $out .= '<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">Lesson schedule (teacher)</h3>';
    $out .= '<div style="display:flex;flex-direction:column;gap:10px;">';

    foreach ($bookings as $bid) {
        $bid = (int)$bid;
        $student_id = (int) get_post_meta($bid, 'student_id', true);
        $studentLabel = e360_user_public_label_simple($student_id);
        $label = e360_next_occurrence_label($bid);

        $out .= '<div style="border-top:1px solid #f0f0f0;padding-top:8px;">';
        $out .= '<div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;">';
        $out .= '<div><div style="font-weight:600;">'.esc_html($studentLabel).'</div>';
        $out .= '<div style="opacity:.85;font-size:13px;">'.esc_html($label['when']).'</div>';
        $out .= '<div style="opacity:.65;font-size:12px;">TZ: '.esc_html($label['tz']).'</div></div>';

        $out .= '<div style="text-align:right;">';
        $out .= '<button type="button" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm e360-open-reschedule" data-booking-id="'.(int)$bid.'">Reschedule</button>';
        $out .= '</div>';

        $out .= '</div></div>';
    }

    // modal
    $out .= '
    <div id="e360-reschedule-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:99999;padding:20px;">
      <div style="max-width:520px;margin:40px auto;background:#fff;border-radius:12px;padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div style="font-weight:700;">Reschedule lesson</div>
            <button type="button" id="e360-close-modal" class="tutor-iconic-btn"><span class="tutor-icon-times"></span></button>
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Type</label>
            <select id="e360-reschedule-repeat" class="tutor-form-select">
                <option value="once">One-time</option>
                <option value="weekly">Weekly</option>
            </select>
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Date</label>
            <input type="date" id="e360-reschedule-date" class="tutor-form-control" />
        </div>

        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Time</label>
            <select id="e360-reschedule-time" class="tutor-form-select">
                <option value="">Select date first…</option>
            </select>
        </div>

        <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
            <button type="button" id="e360-save-reschedule" class="tutor-btn tutor-btn-primary">Save</button>
            <span id="e360-reschedule-msg" style="opacity:.8;"></span>
        </div>
      </div>
    </div>';

    $out .= '</div></div>';

    // script
    $out .= '<script>
    (function(){
        var box = document.getElementById("e360-teacher-schedule-box");
        if (!box) return;
        var modal = document.getElementById("e360-reschedule-modal");
        var currentBookingId = 0;

        function setMsg(t){ document.getElementById("e360-reschedule-msg").textContent = t || ""; }
        function openModal(id){
            currentBookingId = parseInt(id,10)||0;
            setMsg("");
            modal.style.display = "block";
        }
        function closeModal(){
            modal.style.display = "none";
            currentBookingId = 0;
        }

        document.addEventListener("click", function(e){
            var btn = e.target.closest(".e360-open-reschedule");
            if (btn){
                openModal(btn.getAttribute("data-booking-id"));
            }
        });

        document.getElementById("e360-close-modal").addEventListener("click", closeModal);
        modal.addEventListener("click", function(e){
            if (e.target === modal) closeModal();
        });

        function post(params){
            return fetch(box.getAttribute("data-ajax"), {
                method:"POST",
                credentials:"same-origin",
                headers:{ "Content-Type":"application/x-www-form-urlencoded; charset=UTF-8" },
                body: (new URLSearchParams(params)).toString()
            }).then(r=>r.json());
        }

        // load slots for teacher himself using existing endpoint e360_get_slots (you will patch it to use our availability)
        document.getElementById("e360-reschedule-date").addEventListener("change", function(){
            var date = this.value || "";
            var timeSel = document.getElementById("e360-reschedule-time");
            timeSel.innerHTML = "<option value=\\"\\">Loading…</option>";
            if (!date) return;

            // NOTE: we need teacher_id to load slots; on teacher page it is current user
            post({
                action:"e360_get_slots",
                nonce: window.e360_booking_nonce || "",
                teacher_id: '.$teacher_id.',
                date: date,
                duration: 60
            }).then(function(resp){
                if (!resp || !resp.success){
                    timeSel.innerHTML = "<option value=\\"\\">Error</option>";
                    return;
                }
                var slots = (resp.data && resp.data.slots) ? resp.data.slots : [];
                if (!slots.length){
                    timeSel.innerHTML = "<option value=\\"\\">No available slots</option>";
                    return;
                }
                timeSel.innerHTML = "<option value=\\"\\">Select…</option>";
                slots.forEach(function(s){
                    var opt = document.createElement("option");
                    opt.value = s;
                    opt.textContent = (s||"").substring(0,5);
                    timeSel.appendChild(opt);
                });
            });
        });

        document.getElementById("e360-save-reschedule").addEventListener("click", function(){
            if (!currentBookingId) return;
            var date = document.getElementById("e360-reschedule-date").value || "";
            var time = document.getElementById("e360-reschedule-time").value || "";
            var repeat = document.getElementById("e360-reschedule-repeat").value || "once";
            if (!date || !time){
                setMsg("Select date and time");
                return;
            }
            setMsg("Saving…");
            post({
                action:"e360_reschedule_booking",
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
                // simplest: refresh to redraw list
                window.location.reload();
            });
        });
    })();
    </script>';

    return $out;
}

add_action('wp_footer', function(){

    static $done = false;
    if ($done) return;
    $done = true;
    
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    $course_id = (int) get_the_ID();
    $uid = get_current_user_id();

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