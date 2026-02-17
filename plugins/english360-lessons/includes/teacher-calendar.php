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

function e360_teacher_booked_notes_by_weekday(int $teacher_id, int $once_horizon_days = 90): array {
    $out = [
        'mon' => [], 'tue' => [], 'wed' => [], 'thu' => [], 'fri' => [], 'sat' => [], 'sun' => []
    ];
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));

    $append = function(string $weekday, int $fromMin, int $toMin, string $note) use (&$out) {
        if (!isset($out[$weekday])) return;
        if ($toMin <= $fromMin) return;
        $toStr = ($toMin >= 24 * 60) ? '24:00' : e360_hhmm_from_minutes($toMin);
        $out[$weekday][] = [
            'from' => e360_hhmm_from_minutes($fromMin),
            'to'   => $toStr,
            'note' => $note,
        ];
    };

    $ids = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => 500,
        'fields' => 'ids',
        'meta_query' => [
            ['key' => 'teacher_id', 'value' => $teacher_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ],
    ]);

    $nowUtc = current_time('timestamp', true);
    $horizonUtc = $nowUtc + ($once_horizon_days * DAY_IN_SECONDS);

    foreach ((array)$ids as $bid) {
        $bid = (int)$bid;
        $repeat = (string) get_post_meta($bid, 'repeat', true);
        $course_id = (int) get_post_meta($bid, 'course_id', true);
        $student_id = (int) get_post_meta($bid, 'student_id', true);

        $course_title = $course_id ? get_the_title($course_id) : '';
        if ($course_title === '') $course_title = 'Course #' . $course_id;
        $student_label = function_exists('e360_user_public_label_simple')
            ? e360_user_public_label_simple($student_id)
            : ('Student #' . $student_id);

        if ($repeat === 'weekly') {
            $weekday = (string) get_post_meta($bid, 'weekday', true);
            $fromMin = (int) get_post_meta($bid, 'start_min', true);
            $toMin   = (int) get_post_meta($bid, 'end_min', true);
            $append($weekday, $fromMin, $toMin, $course_title . ' — ' . $student_label . ' (weekly)');
            continue;
        }

        $startUtc = (int) get_post_meta($bid, 'start_ts_utc', true);
        $endUtc   = (int) get_post_meta($bid, 'end_ts_utc', true);
        if ($startUtc <= 0 || $endUtc <= 0) continue;
        if ($endUtc < $nowUtc || $startUtc > $horizonUtc) continue;

        $startLocal = (new DateTimeImmutable('@' . $startUtc))->setTimezone($tz);
        $endLocal   = (new DateTimeImmutable('@' . $endUtc))->setTimezone($tz);
        $weekday = strtolower(substr($startLocal->format('D'), 0, 3));
        $fromMin = ((int)$startLocal->format('H')) * 60 + (int)$startLocal->format('i');
        $toMin   = ((int)$endLocal->format('H')) * 60 + (int)$endLocal->format('i');
        if ($toMin <= $fromMin) $toMin = $fromMin + 60;
        $dateTxt = $startLocal->format('Y-m-d');
        $append($weekday, $fromMin, $toMin, $course_title . ' — ' . $student_label . ' (' . $dateTxt . ')');
    }

    foreach (['mon','tue','wed','thu','fri','sat','sun'] as $d) {
        usort($out[$d], function($a, $b){
            return strcmp((string)$a['from'], (string)$b['from']);
        });
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
        <div style="font-size:12px;opacity:.8;margin:-4px 0 10px;">Use 24-hour format: <strong>HH:MM</strong> (example:
            09:00, 14:30)</div>

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
                    <input type="text" inputmode="numeric" class="e360-from" value="${esc(fromVal)}" placeholder="HH:MM" pattern="^([01]\\d|2[0-3]):[0-5]\\d$" title="Use 24-hour format HH:MM">
                    <span>–</span>
                    <input type="text" inputmode="numeric" class="e360-to" value="${esc(toVal)}" placeholder="HH:MM" pattern="^([01]\\d|2[0-3]):[0-5]\\d$" title="Use 24-hour format HH:MM">
                    <button type="button" class="button e360-del tutor-btn tutor-btn-danger tutor-create-new-course tutor-dashboard-create-course" style="margin-left:auto;">Remove</button>
                </div>`;
        }

        function normalizeHHMM(raw) {
            const s = (raw || '').trim().replace(/\s+/g, '');
            const m = s.match(/^(\d{1,2}):(\d{2})$/);
            if (!m) return '';
            const hh = parseInt(m[1], 10);
            const mm = parseInt(m[2], 10);
            if (Number.isNaN(hh) || Number.isNaN(mm)) return '';
            if (hh < 0 || hh > 23 || mm < 0 || mm > 59) return '';
            return String(hh).padStart(2, '0') + ':' + String(mm).padStart(2, '0');
        }

        function renderDays(data) {
            wrapDays.innerHTML = '';
            keys.forEach(k => {
                const ranges = (data && data[k]) ? data[k] : [];
                const booked = (window.__e360Booked && window.__e360Booked[k]) ? window.__e360Booked[k] :
            [];
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
                if (booked.length) {
                    html +=
                        `<div class="e360-booked" style="margin-top:8px;padding-top:8px;border-top:1px dashed #ddd;">
                        <div style="font-size:12px;font-weight:700;opacity:.85;margin-bottom:4px;">Booked lessons</div>`;
                    booked.forEach(function(b) {
                        const from = esc((b.from || '').toString());
                        const to = esc((b.to || '').toString());
                        const note = esc((b.note || '').toString());
                        html += `<div style="font-size:12px;line-height:1.35;margin-bottom:2px;">
                            <strong>${from}-${to}</strong> · ${note}
                        </div>`;
                    });
                    html += `</div>`;
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
                    window.__e360Booked = {};
                    renderDays({});
                    return;
                }
                window.__e360Booked = resp.data.booked || {};
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

        root.addEventListener('blur', function(e) {
            const input = e.target;
            if (!input || !(input.classList.contains('e360-from') || input.classList.contains('e360-to')))
                return;
            const norm = normalizeHHMM(input.value);
            if (norm) input.value = norm;
        }, true);

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
        'booked' => e360_teacher_booked_notes_by_weekday($uid),
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
        if (e360_booking_has_skip_date((int)$pid, $ymd)) continue;
        $s = (int) get_post_meta((int)$pid, 'start_min', true);
        $e = (int) get_post_meta((int)$pid, 'end_min', true);
        if ($e > $s) $intervals[] = [$s, $e];
    }

    return $intervals;
}

function e360_generate_slots_for_teacher_date(int $teacher_id, string $ymd, int $duration_min, bool $include_past_today = false): array {
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
        if ($end <= $start && $to === '00:00') {
            // Treat midnight as end-of-day for ranges like 09:00 -> 12:00 AM.
            $end = 24 * 60;
        }
        if ($end <= $start) continue;

        // step by duration
        for ($m = $start; ($m + $duration_min) <= $end; $m += $duration_min) {
            if (!$include_past_today && $isToday && $m < $nowMin) continue;

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

function e360_booking_skip_dates(int $booking_id): array {
    $rows = get_post_meta($booking_id, 'e360_skip_dates', true);
    if (!is_array($rows)) return [];
    $out = [];
    foreach ($rows as $d) {
        $d = sanitize_text_field((string)$d);
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) $out[] = $d;
    }
    $out = array_values(array_unique($out));
    sort($out);
    return $out;
}

function e360_booking_has_skip_date(int $booking_id, string $ymd): bool {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd)) return false;
    $skip = e360_booking_skip_dates($booking_id);
    return in_array($ymd, $skip, true);
}

function e360_booking_add_skip_date(int $booking_id, string $ymd): void {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd)) return;
    $skip = e360_booking_skip_dates($booking_id);
    if (!in_array($ymd, $skip, true)) $skip[] = $ymd;
    $skip = array_values(array_unique($skip));
    sort($skip);
    update_post_meta($booking_id, 'e360_skip_dates', $skip);
}

function e360_ctx_normalize_slots(array $ctx): array {
    $slots = [];
    $duration = (int)($ctx['duration'] ?? 60);
    if ($duration <= 0) $duration = 60;
    $default_repeat = (($ctx['repeat'] ?? '') === 'once') ? 'once' : 'weekly';

    if (!empty($ctx['slots']) && is_array($ctx['slots'])) {
        foreach ($ctx['slots'] as $row) {
            if (!is_array($row)) continue;
            $date = sanitize_text_field((string)($row['date'] ?? ''));
            $time = sanitize_text_field((string)($row['time'] ?? ''));
            $repeat = (($row['repeat'] ?? $default_repeat) === 'once') ? 'once' : 'weekly';
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) continue;
            if (!preg_match('/^\d{2}:\d{2}/', $time)) continue;
            $slots[] = [
                'date' => $date,
                'time' => substr($time, 0, 5),
                'repeat' => $repeat,
                'duration' => $duration,
            ];
        }
    }

    if (!$slots) {
        $date = sanitize_text_field((string)($ctx['date'] ?? ''));
        $time = sanitize_text_field((string)($ctx['time'] ?? ''));
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && preg_match('/^\d{2}:\d{2}/', $time)) {
            $slots[] = [
                'date' => $date,
                'time' => substr($time, 0, 5),
                'repeat' => $default_repeat,
                'duration' => $duration,
            ];
        }
    }

    return $slots;
}

function e360_booking_exists_for_slot_ctx(int $student_id, int $course_id, int $teacher_id, array $slot): bool {
    $repeat = (($slot['repeat'] ?? '') === 'once') ? 'once' : 'weekly';
    $date = sanitize_text_field((string)($slot['date'] ?? ''));
    $time = sanitize_text_field((string)($slot['time'] ?? ''));
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !preg_match('/^\d{2}:\d{2}$/', $time)) return false;

    $base_meta = [
        ['key' => 'course_id', 'value' => $course_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ['key' => 'student_id', 'value' => $student_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ['key' => 'teacher_id', 'value' => $teacher_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ['key' => 'repeat', 'value' => $repeat, 'compare' => '='],
    ];

    if ($repeat === 'once') {
        $ids = get_posts([
            'post_type' => 'e360_booking',
            'post_status' => ['publish', 'pending'],
            'numberposts' => 1,
            'fields' => 'ids',
            'meta_query' => array_merge($base_meta, [
                ['key' => 'local_date', 'value' => $date, 'compare' => '='],
                ['key' => 'local_time', 'value' => $time, 'compare' => '='],
            ]),
        ]);
        return !empty($ids);
    }

    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $weekday = e360_weekday_key_from_date($date, $tz);
    $start_min = e360_minutes_from_hhmm($time);
    $ids = get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => 1,
        'fields' => 'ids',
        'meta_query' => array_merge($base_meta, [
            ['key' => 'weekday', 'value' => $weekday, 'compare' => '='],
            ['key' => 'start_min', 'value' => $start_min, 'compare' => '=', 'type' => 'NUMERIC'],
        ]),
    ]);
    return !empty($ids);
}

function e360_create_bookings_from_context(int $student_id, array $ctx, array $opts = []): array {
    $teacher_id = (int)($ctx['teacher_id'] ?? 0);
    $course_id = (int)($ctx['course_id'] ?? 0);
    if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) return [];

    $slots = e360_ctx_normalize_slots($ctx);
    if (!$slots) return [];

    $created = [];
    foreach ($slots as $slot) {
        if (e360_booking_exists_for_slot_ctx($student_id, $course_id, $teacher_id, $slot)) {
            continue;
        }
        $one = $ctx;
        $one['date'] = $slot['date'];
        $one['time'] = $slot['time'];
        $one['repeat'] = $slot['repeat'];
        $one['duration'] = (int)($slot['duration'] ?? ($ctx['duration'] ?? 60));
        $id = e360_create_booking_from_context($student_id, $one, array_merge($opts, ['force_new' => true]));
        if ($id) $created[] = (int)$id;
    }
    return $created;
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
    $candidateUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();

    $safety = 0;
    while ($safety < 400) {
        $localYmd = (new DateTimeImmutable('@' . $candidateUtc))->setTimezone($tz)->format('Y-m-d');
        if (!e360_booking_has_skip_date($booking_id, $localYmd)) {
            return $candidateUtc;
        }
        $candidateUtc += 7 * DAY_IN_SECONDS;
        $safety++;
    }
    return 0;
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
    $current_repeat = (string) get_post_meta($booking_id, 'repeat', true);

    // One-time move for weekly booking: keep weekly pattern, move only nearest lesson.
    if ($repeat === 'once' && $current_repeat === 'weekly') {
        $hhmm = substr($time,0,5);
        $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date.' '.$hhmm, $tz);
        if (!$dtLocal) wp_send_json_error(['message'=>'Bad datetime'], 400);

        $slots = e360_generate_slots_for_teacher_date($teacher_id, $date, $duration);
        if (!in_array($hhmm, $slots, true)) {
            wp_send_json_error(['message'=>'Selected time is not available'], 409);
        }

        $nextOldUtc = e360_booking_next_occurrence_ts($booking_id);
        if ($nextOldUtc <= 0) wp_send_json_error(['message'=>'No upcoming weekly lesson to move'], 400);
        $nextOldYmd = (new DateTimeImmutable('@' . $nextOldUtc))->setTimezone($tz)->format('Y-m-d');

        $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
        $endUtc = $startUtc + $duration*60;
        if (e360_booking_conflict_once($teacher_id, $startUtc, $endUtc)) {
            wp_send_json_error(['message'=>'Time is already booked'], 409);
        }

        $student_id = (int) get_post_meta($booking_id, 'student_id', true);
        $course_id = (int) get_post_meta($booking_id, 'course_id', true);
        $new_id = wp_insert_post([
            'post_type' => 'e360_booking',
            'post_status' => 'publish',
            'post_author' => $student_id ?: get_current_user_id(),
            'post_title' => 'Course Enrolled – ' . date_i18n('d.m.Y @ H:i', $startUtc),
        ], true);
        if (is_wp_error($new_id) || !$new_id) {
            wp_send_json_error(['message'=>'Failed to create one-time booking'], 500);
        }

        update_post_meta($new_id, 'course_id', $course_id);
        update_post_meta($new_id, 'teacher_id', $teacher_id);
        update_post_meta($new_id, 'student_id', $student_id);
        update_post_meta($new_id, 'repeat', 'once');
        update_post_meta($new_id, 'duration_min', $duration);
        update_post_meta($new_id, 'start_ts_utc', $startUtc);
        update_post_meta($new_id, 'end_ts_utc', $endUtc);
        update_post_meta($new_id, 'local_date', $date);
        update_post_meta($new_id, 'local_time', $hhmm);
        update_post_meta($new_id, 'e360_parent_booking_id', (int)$booking_id);

        e360_booking_add_skip_date($booking_id, $nextOldYmd);

        e360_mark_matching_reschedule_request_status($booking_id, $date, $hhmm, 'approved', (int)$uid);
        $label = e360_next_occurrence_label($booking_id);
        wp_send_json_success(['label'=>$label, 'override_once' => 1]);
    }

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

    $req_time = substr($time, 0, 5);
    e360_mark_matching_reschedule_request_status($booking_id, $date, $req_time, 'approved', (int)$uid);
    $label = e360_next_occurrence_label($booking_id);
    wp_send_json_success(['label'=>$label]);
});

add_action('wp_ajax_e360_teacher_delete_booking', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_reschedule', 'nonce');

    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    if ($booking_id <= 0) wp_send_json_error(['message'=>'Missing booking'], 400);
    $p = get_post($booking_id);
    if (!$p || $p->post_type !== 'e360_booking') wp_send_json_error(['message'=>'Invalid booking'], 400);

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    if (!current_user_can('manage_options') && $teacher_id !== $uid) {
        wp_send_json_error(['message'=>'Not your booking'], 403);
    }

    wp_trash_post($booking_id);
    wp_send_json_success(['ok'=>1]);
});

add_action('wp_ajax_e360_teacher_add_booking', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_reschedule', 'nonce');

    $uid = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    $teacher_id = isset($_POST['teacher_id']) ? (int)$_POST['teacher_id'] : 0;
    $student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
    $course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
    $date = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $time = isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '';
    $repeat = isset($_POST['repeat']) ? sanitize_text_field(wp_unslash($_POST['repeat'])) : 'weekly';
    $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 60;
    if ($duration <= 0) $duration = 60;
    $repeat = ($repeat === 'once') ? 'once' : 'weekly';

    if ($teacher_id <= 0 || $student_id <= 0 || $course_id <= 0 || $date === '' || $time === '') {
        wp_send_json_error(['message'=>'Missing data'], 400);
    }
    if (!current_user_can('manage_options') && $teacher_id !== $uid) {
        wp_send_json_error(['message'=>'Not your course'], 403);
    }
    if (function_exists('e360_is_student_enrolled_in_course') && !e360_is_student_enrolled_in_course($student_id, $course_id)) {
        wp_send_json_error(['message'=>'Student not enrolled in this course'], 400);
    }

    $ctx = [
        'teacher_id' => $teacher_id,
        'student_id' => $student_id,
        'course_id' => $course_id,
        'date' => $date,
        'time' => $time,
        'repeat' => $repeat,
        'duration' => $duration,
    ];
    $new_id = e360_create_booking_from_context($student_id, $ctx, [
        'require_credit' => false,
        'force_new' => true,
    ]);
    if (!$new_id) {
        wp_send_json_error(['message'=>'Could not create booking (slot conflict or invalid data)'], 409);
    }
    wp_send_json_success(['booking_id' => (int)$new_id]);
});

function e360_student_course_booking_ids(int $student_id, int $course_id): array {
    if ($student_id <= 0 || $course_id <= 0) return [];
    return get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'numberposts' => 50,
        'fields' => 'ids',
        'orderby' => 'ID',
        'order' => 'DESC',
        'meta_query' => [
            ['key' => 'course_id', 'value' => $course_id, 'compare' => '=', 'type' => 'NUMERIC'],
            ['key' => 'student_id', 'value' => $student_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ],
    ]);
}

function e360_booking_occurrences_utc_for_range(int $booking_id, int $from_utc, int $to_utc): array {
    if ($booking_id <= 0 || $to_utc <= $from_utc) return [];

    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    if ($repeat === 'once') {
        $ts = (int) get_post_meta($booking_id, 'start_ts_utc', true);
        if ($ts >= $from_utc && $ts <= $to_utc) return [$ts];
        return [];
    }

    $next = e360_booking_next_occurrence_ts($booking_id);
    if ($next <= 0) return [];

    $out = [];
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    while ($next <= $to_utc) {
        if ($next >= $from_utc) {
            $ymd = (new DateTimeImmutable('@' . $next))->setTimezone($tz)->format('Y-m-d');
            if (!e360_booking_has_skip_date($booking_id, $ymd)) $out[] = $next;
        }
        $next += 7 * DAY_IN_SECONDS;
    }
    return $out;
}

function e360_student_course_calendar_data(int $student_id, int $course_id, int $days = 30, string $tz_name = ''): array {
    $ids = e360_student_course_booking_ids($student_id, $course_id);
    if (!$ids) return ['days' => [], 'timezone' => $tz_name];

    if ($tz_name === '') {
        $teacher_id = (int) get_post_meta((int)$ids[0], 'teacher_id', true);
        $tz_name = e360_get_teacher_timezone_string($teacher_id);
    }
    $tz = new DateTimeZone($tz_name ?: 'UTC');

    $from_utc = current_time('timestamp', true);
    $to_utc = $from_utc + (max(1, $days) * DAY_IN_SECONDS);
    $map = [];

    foreach ($ids as $bid) {
        $ts_list = e360_booking_occurrences_utc_for_range((int)$bid, $from_utc, $to_utc);
        foreach ($ts_list as $ts) {
            $dt = (new DateTimeImmutable('@' . $ts))->setTimezone($tz);
            $ymd = $dt->format('Y-m-d');
            $hhmm = $dt->format('H:i');
            if (!isset($map[$ymd])) $map[$ymd] = [];
            if (!in_array($hhmm, $map[$ymd], true)) $map[$ymd][] = $hhmm;
        }
    }

    foreach ($map as $k => $times) {
        sort($times);
        $map[$k] = $times;
    }
    ksort($map);

    return ['days' => $map, 'timezone' => $tz_name];
}

function e360_student_next_occurrence_for_course(int $student_id, int $course_id): array {
    $ids = e360_student_course_booking_ids($student_id, $course_id);
    $best = ['booking_id' => 0, 'ts_utc' => 0];
    foreach ($ids as $bid) {
        $ts = e360_booking_next_occurrence_ts((int)$bid);
        if ($ts <= 0) continue;
        if ($best['ts_utc'] === 0 || $ts < $best['ts_utc']) {
            $best = ['booking_id' => (int)$bid, 'ts_utc' => (int)$ts];
        }
    }
    return $best;
}

add_action('wp_ajax_e360_get_teacher_available_dates', function(){
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $teacher_id = isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0;
    $duration   = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
    $days       = isset($_POST['days']) ? (int) $_POST['days'] : 45;

    if ($teacher_id <= 0) {
        wp_send_json_error(['message' => 'teacher_id required'], 400);
    }
    if ($duration <= 0) $duration = 60;
    $days = max(7, min(90, $days));

    $tz_name = e360_get_teacher_timezone_string($teacher_id);
    $tz = new DateTimeZone($tz_name);
    $today = new DateTimeImmutable('today', $tz);
    $result = [];

    for ($i = 0; $i < $days; $i++) {
        $date = $today->modify('+' . $i . ' day')->format('Y-m-d');
        $slots = e360_generate_slots_for_teacher_date($teacher_id, $date, $duration);
        if (!$slots) continue;
        $result[] = [
            'date' => $date,
            'slots' => array_values($slots),
        ];
    }

    wp_send_json_success([
        'timezone' => $tz_name,
        'days' => $result,
    ]);
});

function e360_send_reschedule_request_email_to_teacher(int $booking_id, int $student_id, string $proposed_date, string $proposed_time, string $reason): void {
    if (!function_exists('wp_mail')) return;

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    if ($teacher_id <= 0) return;
    $teacher = get_user_by('id', $teacher_id);

    $course_id = (int) get_post_meta($booking_id, 'course_id', true);
    $course_title = $course_id ? get_the_title($course_id) : ('Course #' . $course_id);
    $student_label = e360_user_public_label_simple($student_id);
    $tz_name = e360_get_teacher_timezone_string($teacher_id);
    $site = wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES);
    $subject = '[' . $site . '] Reschedule request from student: ' . $student_label;

    $body = "Student: {$student_label} (ID {$student_id})\n";
    $body .= "Course: {$course_title} (#{$course_id})\n";
    $body .= "Requested new time: {$proposed_date} {$proposed_time} ({$tz_name})\n";
    if ($reason !== '') $body .= "Reason: {$reason}\n";
    $body .= "\nPlease review and reschedule from your course schedule tools.";

    $recipients = [];
    if ($teacher && !empty($teacher->user_email)) {
        $teacher_email = sanitize_email((string)$teacher->user_email);
        if ($teacher_email !== '') $recipients[] = $teacher_email;
    }

    $default_admin = sanitize_email((string)get_option('admin_email'));
    if ($default_admin !== '') $recipients[] = $default_admin;
    $admins = get_users(['role' => 'administrator', 'fields' => ['user_email']]);
    foreach ((array)$admins as $a) {
        $mail = sanitize_email((string)($a->user_email ?? ''));
        if ($mail !== '') $recipients[] = $mail;
    }

    $recipients = array_values(array_unique($recipients));
    if (!$recipients) return;

    wp_mail($recipients, $subject, $body, ['Content-Type: text/plain; charset=UTF-8']);
}

add_action('wp_ajax_e360_student_request_reschedule', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message' => 'Not logged in'], 401);
    check_ajax_referer('e360_student_reschedule_request', 'nonce');

    $uid = get_current_user_id();
    if (current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Only students can send requests'], 403);
    }

    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $date = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $time = isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '';
    $reason = isset($_POST['reason']) ? sanitize_textarea_field(wp_unslash($_POST['reason'])) : '';
    if ($reason === '') {
        wp_send_json_error(['message' => 'Reason is required'], 400);
    }

    if ($booking_id <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !preg_match('/^\d{2}:\d{2}$/', $time)) {
        wp_send_json_error(['message' => 'Invalid request data'], 400);
    }

    $student_id = (int) get_post_meta($booking_id, 'student_id', true);
    if (!current_user_can('manage_options') && $student_id !== (int)$uid) {
        wp_send_json_error(['message' => 'Not your booking'], 403);
    }

    $next_ts = e360_booking_next_occurrence_ts($booking_id);
    if ($next_ts <= 0) wp_send_json_error(['message' => 'No upcoming lesson found'], 400);
    if (($next_ts - current_time('timestamp', true)) < DAY_IN_SECONDS) {
        wp_send_json_error(['message' => 'You can request reschedule only earlier than 24 hours before the next lesson.'], 400);
    }

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $tz = new DateTimeZone(e360_get_teacher_timezone_string($teacher_id));
    $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $time, $tz);
    if (!$dt) wp_send_json_error(['message' => 'Invalid date/time'], 400);
    $duration = (int) get_post_meta($booking_id, 'duration_min', true);
    if ($duration <= 0) $duration = 60;
    $available_slots = e360_generate_slots_for_teacher_date($teacher_id, $date, $duration);
    if (!in_array($time, $available_slots, true)) {
        wp_send_json_error(['message' => 'Selected time is no longer available'], 409);
    }

    $requests = get_post_meta($booking_id, 'e360_reschedule_requests', true);
    if (!is_array($requests)) $requests = [];
    $requests[] = [
        'student_id' => (int)$uid,
        'proposed_date' => $date,
        'proposed_time' => $time,
        'reason' => $reason,
        'status' => 'pending',
        'created_at' => current_time('mysql'),
        'next_lesson_ts_utc' => $next_ts,
    ];
    update_post_meta($booking_id, 'e360_reschedule_requests', $requests);

    e360_send_reschedule_request_email_to_teacher($booking_id, (int)$uid, $date, $time, $reason);
    wp_send_json_success(['ok' => 1]);
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

function e360_course_enrolled_student_options(int $course_id): array {
    if ($course_id <= 0) return [];
    if (!function_exists('e360_get_course_enrolled_student_ids')) return [];
    $ids = e360_get_course_enrolled_student_ids($course_id, 500);
    if (!is_array($ids) || !$ids) return [];

    $out = [];
    foreach ($ids as $sid) {
        $sid = (int)$sid;
        if ($sid <= 0) continue;
        if (function_exists('e360_is_student_enrolled_in_course') && !e360_is_student_enrolled_in_course($sid, $course_id)) {
            continue;
        }
        $out[] = [
            'id' => $sid,
            'label' => e360_user_public_label_simple($sid),
        ];
    }

    usort($out, function($a, $b){
        return strcmp((string)$a['label'], (string)$b['label']);
    });
    return $out;
}

function e360_get_booking_reschedule_requests(int $booking_id, bool $only_pending = false): array {
    $rows = get_post_meta($booking_id, 'e360_reschedule_requests', true);
    if (!is_array($rows)) return [];
    $out = [];
    foreach ($rows as $idx => $r) {
        if (!is_array($r)) continue;
        $status = sanitize_key((string)($r['status'] ?? 'pending'));
        if (!in_array($status, ['pending', 'approved', 'rejected'], true)) $status = 'pending';
        if ($only_pending && $status !== 'pending') continue;
        $out[] = [
            'idx' => (int)$idx,
            'status' => $status,
            'student_id' => (int)($r['student_id'] ?? 0),
            'proposed_date' => (string)($r['proposed_date'] ?? ''),
            'proposed_time' => (string)($r['proposed_time'] ?? ''),
            'reason' => (string)($r['reason'] ?? ''),
            'created_at' => (string)($r['created_at'] ?? ''),
        ];
    }
    return $out;
}

function e360_mark_matching_reschedule_request_status(
    int $booking_id,
    string $date,
    string $time,
    string $status = 'approved',
    int $actor_user_id = 0
): void {
    if ($booking_id <= 0) return;
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return;
    if (!preg_match('/^\d{2}:\d{2}$/', $time)) return;
    if (!in_array($status, ['approved', 'rejected', 'pending'], true)) $status = 'approved';

    $rows = get_post_meta($booking_id, 'e360_reschedule_requests', true);
    if (!is_array($rows) || !$rows) return;

    for ($i = count($rows) - 1; $i >= 0; $i--) {
        if (!isset($rows[$i]) || !is_array($rows[$i])) continue;
        $r = $rows[$i];
        $r_status = sanitize_key((string)($r['status'] ?? 'pending'));
        $r_date = (string)($r['proposed_date'] ?? '');
        $r_time = (string)($r['proposed_time'] ?? '');
        if ($r_status !== 'pending') continue;
        if ($r_date !== $date || $r_time !== $time) continue;

        $rows[$i]['status'] = $status;
        $rows[$i]['updated_at'] = current_time('mysql');
        if ($actor_user_id > 0) $rows[$i]['updated_by'] = (int)$actor_user_id;
        update_post_meta($booking_id, 'e360_reschedule_requests', $rows);
        return;
    }
}

function e360_teacher_course_calendar_data(int $teacher_id, int $course_id, int $days = 30): array {
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, 300);
    if (!$bookings) return ['days' => [], 'timezone' => e360_get_teacher_timezone_string($teacher_id)];

    $tz_name = e360_get_teacher_timezone_string($teacher_id);
    $tz = new DateTimeZone($tz_name);
    $from_utc = current_time('timestamp', true);
    $to_utc = $from_utc + (max(1, $days) * DAY_IN_SECONDS);
    $map = [];

    foreach ($bookings as $bid) {
        $sid = (int) get_post_meta((int)$bid, 'student_id', true);
        $student_label = e360_user_public_label_simple($sid);
        $ts_list = e360_booking_occurrences_utc_for_range((int)$bid, $from_utc, $to_utc);
        foreach ($ts_list as $ts) {
            $dt = (new DateTimeImmutable('@' . $ts))->setTimezone($tz);
            $ymd = $dt->format('Y-m-d');
            $hhmm = $dt->format('H:i');
            if (!isset($map[$ymd])) $map[$ymd] = [];
            $map[$ymd][] = [
                'time' => $hhmm,
                'student' => $student_label,
                'student_id' => $sid,
                'booking_id' => (int)$bid,
            ];
        }
    }

    foreach ($map as $k => $rows) {
        usort($rows, function($a, $b){
            return strcmp((string)($a['time'] ?? ''), (string)($b['time'] ?? ''));
        });
        $map[$k] = $rows;
    }
    ksort($map);

    return ['days' => $map, 'timezone' => $tz_name];
}

function e360_render_teacher_course_calendar_html(int $teacher_id, int $course_id, int $days = 30): string {
    $calendar = e360_teacher_course_calendar_data($teacher_id, $course_id, $days);
    $days_map = (array)($calendar['days'] ?? []);
    $tz_name = (string)($calendar['timezone'] ?? '');
    $tz = new DateTimeZone($tz_name ?: 'UTC');
    $today = new DateTimeImmutable('now', $tz);

    $out = '<div style="margin:10px 0 14px;">';
    $out .= '<div style="font-weight:600;margin-bottom:8px;">Booked calendar (next ' . (int)$days . ' days)</div>';
    $out .= '<div style="opacity:.75;font-size:12px;margin-bottom:8px;">Timezone: ' . esc_html($tz_name) . '</div>';
    $out .= '<div style="display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px;">';
    for ($i = 0; $i < $days; $i++) {
        $d = $today->modify('+' . $i . ' day');
        $ymd = $d->format('Y-m-d');
        $rows = isset($days_map[$ymd]) && is_array($days_map[$ymd]) ? $days_map[$ymd] : [];
        $title = $d->format('D, M j');
        if (!$rows) {
            $out .= '<div style="border:1px solid #efefef;border-radius:8px;padding:8px;min-height:74px;opacity:.7;">';
            $out .= '<div style="font-size:12px;">' . esc_html($title) . '</div>';
            $out .= '</div>';
            continue;
        }
        $out .= '<div style="border:1px solid #d9e3f8;background:#f8fbff;border-radius:8px;padding:8px;min-height:74px;">';
        $out .= '<div style="font-size:12px;font-weight:600;margin-bottom:4px;">' . esc_html($title) . '</div>';
        foreach ($rows as $r) {
            $out .= '<div style="font-size:12px;line-height:1.35;margin-bottom:4px;">';
            $out .= '<strong>' . esc_html((string)($r['time'] ?? '')) . '</strong><br>';
            $out .= '<span style="opacity:.85;">' . esc_html((string)($r['student'] ?? '')) . '</span>';
            $out .= '</div>';
        }
        $out .= '</div>';
    }
    $out .= '</div></div>';
    return $out;
}

function e360_render_teacher_pending_reschedule_requests(int $teacher_id, int $course_id): string {
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, 300);
    if (!$bookings) return '';

    $rows = [];
    foreach ($bookings as $bid) {
        $reqs = e360_get_booking_reschedule_requests((int)$bid, true);
        if (!$reqs) continue;
        $sid = (int)get_post_meta((int)$bid, 'student_id', true);
        $student_label = e360_user_public_label_simple($sid);
        foreach ($reqs as $r) {
            $rows[] = [
                'booking_id' => (int)$bid,
                'student' => $student_label,
                'proposed_date' => (string)$r['proposed_date'],
                'proposed_time' => (string)$r['proposed_time'],
                'reason' => (string)$r['reason'],
                'created_at' => (string)$r['created_at'],
            ];
        }
    }
    if (!$rows) return '';
    usort($rows, function($a, $b){
        return strcmp((string)$b['created_at'], (string)$a['created_at']);
    });

    $out = '<div style="margin:10px 0 14px;">';
    $out .= '<div style="font-weight:600;margin-bottom:8px;">Pending reschedule requests</div>';
    $out .= '<div style="display:flex;flex-direction:column;gap:8px;">';
    foreach ($rows as $r) {
        $out .= '<div style="border:1px solid #ececec;border-radius:8px;padding:8px;">';
        $out .= '<div style="font-weight:600;">' . esc_html($r['student']) . '</div>';
        $out .= '<div style="font-size:13px;opacity:.9;">Requested: ' . esc_html($r['proposed_date'] . ' ' . $r['proposed_time']) . '</div>';
        if ($r['reason'] !== '') {
            $out .= '<div style="font-size:13px;opacity:.9;">Reason: ' . esc_html($r['reason']) . '</div>';
        }
        if ($r['created_at'] !== '') {
            $out .= '<div style="font-size:12px;opacity:.7;">Requested at: ' . esc_html($r['created_at']) . '</div>';
        }
        $out .= '</div>';
    }
    $out .= '</div></div>';
    return $out;
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
        'allow_add' => false,
        'course_id' => 0,
        'teacher_id' => 0,
    ]);

    $box_id = preg_replace('/[^a-zA-Z0-9\-_]/', '', (string)$args['box_id']);
    if ($box_id === '') $box_id = 'e360-teacher-bookings-box';

    $nonce = wp_create_nonce('e360_reschedule');
    $slots_nonce = wp_create_nonce('e360_booking_nonce');
    $ajax = admin_url('admin-ajax.php');
    $show_course = !empty($args['show_course']);
    $show_teacher = !empty($args['show_teacher']);
    $can_edit = !empty($args['can_edit']);
    $allow_add = !empty($args['allow_add']);
    $add_course_id = (int)$args['course_id'];
    $add_teacher_id = (int)$args['teacher_id'];
    $button_class = (string)$args['button_class'];
    $container_style = (string)$args['container_style'];
    $student_opts = ($allow_add && $add_course_id > 0) ? e360_course_enrolled_student_options($add_course_id) : [];

    $out  = '<div id="' . esc_attr($box_id) . '" class="tutor-course-progress-wrapper tutor-mb-32" style="' . esc_attr($container_style) . '"';
    $out .= ' data-ajax="' . esc_attr($ajax) . '" data-nonce="' . esc_attr($nonce) . '" data-slots-nonce="' . esc_attr($slots_nonce) . '">';
    $out .= '<div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">';
    $out .= '<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16" style="margin:0;">' . esc_html((string)$args['title']) . '</h3>';
    if ($can_edit && $allow_add && $add_course_id > 0 && $add_teacher_id > 0) {
        $out .= '<button type="button" class="tutor-btn tutor-btn-primary tutor-btn-sm e360-open-add-booking">Add lesson</button>';
    }
    $out .= '</div>';
    $out .= '<div style="display:flex;flex-direction:column;gap:10px;">';

    foreach ($booking_ids as $bid) {
        $bid = (int)$bid;
        $student_id = (int) get_post_meta($bid, 'student_id', true);
        $teacher_id = (int) get_post_meta($bid, 'teacher_id', true);
        $duration_min = (int) get_post_meta($bid, 'duration_min', true);
        if ($duration_min <= 0) $duration_min = 60;
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
            $out .= '<button type="button" class="' . esc_attr($button_class) . ' e360-open-reschedule" data-booking-id="' . (int)$bid . '" data-teacher-id="' . (int)$teacher_id . '" data-duration="' . (int)$duration_min . '">Reschedule</button>';
            $out .= ' <button type="button" class="tutor-btn tutor-btn-outline-danger tutor-btn-sm e360-delete-booking" data-booking-id="' . (int)$bid . '">Delete</button>';
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
            <div class="e360-teacher-available" style="margin-top:8px;font-size:12px;opacity:.85;"></div>
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

    if ($can_edit && $allow_add && $add_course_id > 0 && $add_teacher_id > 0) {
        $out .= '
    <div class="e360-add-booking-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:99999;padding:20px;">
      <div style="max-width:560px;margin:40px auto;background:#fff;border-radius:12px;padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div style="font-weight:700;">Add lesson</div>
            <button type="button" class="e360-close-add tutor-iconic-btn"><span class="tutor-icon-times"></span></button>
        </div>
        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Student</label>
            <select class="e360-add-student tutor-form-select">';
        if (!$student_opts) {
            $out .= '<option value="">No enrolled students</option>';
        } else {
            $out .= '<option value="">Select student…</option>';
            foreach ($student_opts as $s) {
                $out .= '<option value="' . (int)$s['id'] . '">' . esc_html((string)$s['label']) . '</option>';
            }
        }
        $out .= '</select>
        </div>
        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Type</label>
            <select class="e360-add-repeat tutor-form-select">
                <option value="weekly">Weekly</option>
                <option value="once">One-time</option>
            </select>
        </div>
        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Date</label>
            <input type="date" class="e360-add-date tutor-form-control" />
            <div class="e360-add-available" style="margin-top:8px;font-size:12px;opacity:.85;"></div>
        </div>
        <div style="margin-top:10px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Time</label>
            <select class="e360-add-time tutor-form-select"><option value="">Select date first…</option></select>
        </div>
        <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
            <button type="button" class="tutor-btn tutor-btn-primary e360-save-add-booking">Add</button>
            <span class="e360-add-booking-msg" style="opacity:.8;"></span>
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
        var availableEl = box.querySelector(".e360-teacher-available");
        var addModal = box.querySelector(".e360-add-booking-modal");
        var addOpenBtn = box.querySelector(".e360-open-add-booking");
        var addCloseBtn = box.querySelector(".e360-close-add");
        var addStudentEl = box.querySelector(".e360-add-student");
        var addRepeatEl = box.querySelector(".e360-add-repeat");
        var addDateEl = box.querySelector(".e360-add-date");
        var addTimeEl = box.querySelector(".e360-add-time");
        var addAvailableEl = box.querySelector(".e360-add-available");
        var addSaveBtn = box.querySelector(".e360-save-add-booking");
        var addMsgEl = box.querySelector(".e360-add-booking-msg");
        var addCourseId = ' . (int)$add_course_id . ';
        var addTeacherId = ' . (int)$add_teacher_id . ';
        var addDuration = 60;
        var addAvailableMap = {};
        var addAvailableLoaded = false;

        var currentBookingId = 0;
        var currentTeacherId = 0;
        var currentDuration = 60;
        var availableMap = {};
        var availableLoadedKey = "";

        function setMsg(t){ msgEl.textContent = t || ""; }
        function setAddMsg(t){ if (addMsgEl) addMsgEl.textContent = t || ""; }
        function syncTutorSelectUi(selectEl){
            if (!selectEl) return;
            var wrap = selectEl.parentElement ? selectEl.parentElement.querySelector(".tutor-js-form-select") : null;
            if (!wrap) return;
            var labelEl = wrap.querySelector("[tutor-dropdown-label]");
            var optsWrap = wrap.querySelector(".tutor-form-select-options");
            if (!labelEl || !optsWrap) return;

            var selectedText = "";
            if (selectEl.selectedIndex >= 0 && selectEl.options[selectEl.selectedIndex]) {
                selectedText = selectEl.options[selectEl.selectedIndex].textContent || "";
            }
            if (!selectedText && selectEl.options.length) {
                selectedText = selectEl.options[0].textContent || "";
            }
            labelEl.textContent = selectedText || "Select…";

            optsWrap.innerHTML = "";
            Array.prototype.forEach.call(selectEl.options, function(opt, idx){
                var item = document.createElement("div");
                item.className = "tutor-form-select-option" + ((opt.selected || (idx === 0 && !selectEl.value)) ? " is-active" : "");
                var span = document.createElement("span");
                span.setAttribute("tutor-dropdown-item", "");
                span.setAttribute("data-key", opt.value || "");
                span.className = "tutor-nowrap-ellipsis";
                span.title = opt.textContent || "";
                span.textContent = opt.textContent || "";
                item.appendChild(span);
                item.addEventListener("click", function(){
                    selectEl.value = opt.value || "";
                    labelEl.textContent = opt.textContent || "";
                    var ev = new Event("change", { bubbles: true });
                    selectEl.dispatchEvent(ev);
                    var active = optsWrap.querySelectorAll(".tutor-form-select-option");
                    active.forEach(function(a){ a.classList.remove("is-active"); });
                    item.classList.add("is-active");
                });
                optsWrap.appendChild(item);
            });
        }
        function setTimeOptions(slots){
            var list = Array.isArray(slots) ? slots : [];
            if (!list.length){
                timeEl.innerHTML = "<option value=\\"\\">No available slots</option>";
                syncTutorSelectUi(timeEl);
                return;
            }
            timeEl.innerHTML = "<option value=\\"\\">Select…</option>";
            list.forEach(function(s){
                var opt = document.createElement("option");
                opt.value = s;
                opt.textContent = (s || "").substring(0,5);
                timeEl.appendChild(opt);
            });
            syncTutorSelectUi(timeEl);
        }
        function renderAvailableDates(tzName){
            if (!availableEl) return;
            var dates = Object.keys(availableMap);
            if (!dates.length){
                availableEl.textContent = "No free dates in the next period.";
                return;
            }
            var html = "<div style=\\"margin-bottom:6px;\\">Available dates (timezone: <strong>" + (tzName || "") + "</strong>)</div>";
            html += "<div style=\\"display:flex;flex-wrap:wrap;gap:6px;\\">";
            dates.slice(0, 12).forEach(function(d){
                html += "<button type=\\"button\\" class=\\"button button-small e360-teacher-pick-date\\" data-date=\\"" + d + "\\">" + d + "</button>";
            });
            html += "</div>";
            availableEl.innerHTML = html;
            availableEl.querySelectorAll(".e360-teacher-pick-date").forEach(function(btn){
                btn.addEventListener("click", function(){
                    var d = btn.getAttribute("data-date") || "";
                    if (!d) return;
                    dateEl.value = d;
                    dateEl.dispatchEvent(new Event("change"));
                });
            });
        }
        function openModal(bookingId, teacherId, duration){
            currentBookingId = parseInt(bookingId,10) || 0;
            currentTeacherId = parseInt(teacherId,10) || 0;
            currentDuration = parseInt(duration,10) || 60;
            availableMap = {};
            availableLoadedKey = "";
            dateEl.value = "";
            setTimeOptions([]);
            if (availableEl) availableEl.textContent = "";
            setMsg("");
            modal.style.display = "block";
            loadAvailableDates();
        }
        function closeModal(){
            modal.style.display = "none";
            currentBookingId = 0;
            currentTeacherId = 0;
            currentDuration = 60;
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
                openModal(btn.getAttribute("data-booking-id"), btn.getAttribute("data-teacher-id"), btn.getAttribute("data-duration"));
                return;
            }
            var delBtn = e.target.closest(".e360-delete-booking");
            if (delBtn) {
                var bid = parseInt(delBtn.getAttribute("data-booking-id"), 10) || 0;
                if (!bid) return;
                if (!window.confirm("Delete this lesson slot?")) return;
                setMsg("Deleting…");
                post({
                    action: "e360_teacher_delete_booking",
                    nonce: box.getAttribute("data-nonce"),
                    booking_id: bid
                }).then(function(resp){
                    if (!resp || !resp.success){
                        var m = resp && resp.data && resp.data.message ? resp.data.message : "Error";
                        setMsg(m);
                        return;
                    }
                    window.location.reload();
                });
            }
        });

        closeBtn.addEventListener("click", closeModal);
        modal.addEventListener("click", function(e){
            if (e.target === modal) closeModal();
        });

        function loadSlotsForDate(date){
            if (!date || !currentTeacherId) { setTimeOptions([]); return; }
            setTimeOptions([]);
            setMsg("Loading available time…");
            post({
                action: "e360_get_slots",
                nonce: box.getAttribute("data-slots-nonce") || "",
                teacher_id: currentTeacherId,
                date: date,
                duration: currentDuration
            }).then(function(resp){
                if (!resp || !resp.success){
                    setTimeOptions([]);
                    setMsg("Failed to load available time.");
                    return;
                }
                var slots = (resp.data && resp.data.slots) ? resp.data.slots : [];
                setTimeOptions(slots);
                if (slots.length) setMsg("");
                else setMsg("No free time for this date.");
            });
        }
        function loadAvailableDates(){
            var key = String(currentTeacherId) + "|" + String(currentDuration);
            if (availableLoadedKey === key) return;
            availableLoadedKey = key;
            setMsg("Loading available dates…");
            post({
                action: "e360_get_teacher_available_dates",
                nonce: box.getAttribute("data-slots-nonce") || "",
                teacher_id: currentTeacherId,
                duration: currentDuration,
                days: 45
            }).then(function(resp){
                if (!resp || !resp.success){
                    availableMap = {};
                    if (availableEl) availableEl.textContent = "Failed to load available dates.";
                    setMsg("");
                    return;
                }
                availableMap = {};
                var items = (resp.data && resp.data.days) ? resp.data.days : [];
                items.forEach(function(it){
                    if (!it || !it.date) return;
                    availableMap[it.date] = true;
                });
                var keys = Object.keys(availableMap).sort();
                if (keys.length) dateEl.min = keys[0];
                renderAvailableDates((resp.data && resp.data.timezone) ? resp.data.timezone : "");
                setMsg("");
            }).catch(function(){
                if (availableEl) availableEl.textContent = "Failed to load available dates.";
                setMsg("");
            });
        }

        dateEl.addEventListener("change", function(){
            var date = this.value || "";
            if (!date) { setTimeOptions([]); return; }
            loadSlotsForDate(date);
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

        function setAddTimeOptions(slots){
            if (!addTimeEl) return;
            var list = Array.isArray(slots) ? slots : [];
            if (!list.length){
                addTimeEl.innerHTML = "<option value=\\"\\">No available slots</option>";
                syncTutorSelectUi(addTimeEl);
                return;
            }
            addTimeEl.innerHTML = "<option value=\\"\\">Select…</option>";
            list.forEach(function(s){
                var opt = document.createElement("option");
                opt.value = s;
                opt.textContent = (s || "").substring(0,5);
                addTimeEl.appendChild(opt);
            });
            syncTutorSelectUi(addTimeEl);
        }
        function renderAddAvailableDates(tzName){
            if (!addAvailableEl) return;
            var dates = Object.keys(addAvailableMap);
            if (!dates.length){
                addAvailableEl.textContent = "No free dates in the next period.";
                return;
            }
            var html = "<div style=\\"margin-bottom:6px;\\">Available dates (timezone: <strong>" + (tzName || "") + "</strong>)</div>";
            html += "<div style=\\"display:flex;flex-wrap:wrap;gap:6px;\\">";
            dates.slice(0, 12).forEach(function(d){
                html += "<button type=\\"button\\" class=\\"button button-small e360-add-pick-date\\" data-date=\\"" + d + "\\">" + d + "</button>";
            });
            html += "</div>";
            addAvailableEl.innerHTML = html;
            addAvailableEl.querySelectorAll(".e360-add-pick-date").forEach(function(btn){
                btn.addEventListener("click", function(){
                    var d = btn.getAttribute("data-date") || "";
                    if (!d || !addDateEl) return;
                    addDateEl.value = d;
                    addDateEl.dispatchEvent(new Event("change"));
                });
            });
        }
        function loadAddSlotsForDate(date){
            if (!date || !addTeacherId) { setAddTimeOptions([]); return; }
            setAddTimeOptions([]);
            setAddMsg("Loading available time…");
            post({
                action: "e360_get_slots",
                nonce: box.getAttribute("data-slots-nonce") || "",
                teacher_id: addTeacherId,
                date: date,
                duration: addDuration
            }).then(function(resp){
                if (!resp || !resp.success){
                    setAddTimeOptions([]);
                    setAddMsg("Failed to load available time.");
                    return;
                }
                var slots = (resp.data && resp.data.slots) ? resp.data.slots : [];
                setAddTimeOptions(slots);
                setAddMsg(slots.length ? "" : "No free time for this date.");
            });
        }
        function loadAddAvailableDates(){
            if (addAvailableLoaded) return;
            addAvailableLoaded = true;
            setAddMsg("Loading available dates…");
            post({
                action: "e360_get_teacher_available_dates",
                nonce: box.getAttribute("data-slots-nonce") || "",
                teacher_id: addTeacherId,
                duration: addDuration,
                days: 45
            }).then(function(resp){
                if (!resp || !resp.success){
                    addAvailableMap = {};
                    if (addAvailableEl) addAvailableEl.textContent = "Failed to load available dates.";
                    setAddMsg("");
                    return;
                }
                addAvailableMap = {};
                var items = (resp.data && resp.data.days) ? resp.data.days : [];
                items.forEach(function(it){
                    if (!it || !it.date) return;
                    addAvailableMap[it.date] = true;
                });
                var keys = Object.keys(addAvailableMap).sort();
                if (keys.length && addDateEl) addDateEl.min = keys[0];
                renderAddAvailableDates((resp.data && resp.data.timezone) ? resp.data.timezone : "");
                setAddMsg("");
            }).catch(function(){
                if (addAvailableEl) addAvailableEl.textContent = "Failed to load available dates.";
                setAddMsg("");
            });
        }

        if (addOpenBtn && addModal) {
            addOpenBtn.addEventListener("click", function(){
                addModal.style.display = "block";
                if (addDateEl) addDateEl.value = "";
                setAddTimeOptions([]);
                setAddMsg("");
                loadAddAvailableDates();
            });
        }
        if (addCloseBtn && addModal) {
            addCloseBtn.addEventListener("click", function(){ addModal.style.display = "none"; });
        }
        if (addModal) {
            addModal.addEventListener("click", function(e){ if (e.target === addModal) addModal.style.display = "none"; });
        }
        if (addDateEl) {
            addDateEl.addEventListener("change", function(){
                var date = this.value || "";
                if (!date) { setAddTimeOptions([]); return; }
                loadAddSlotsForDate(date);
            });
        }
        if (addSaveBtn) {
            addSaveBtn.addEventListener("click", function(){
                var studentId = addStudentEl ? (addStudentEl.value || "") : "";
                var repeat = addRepeatEl ? (addRepeatEl.value || "weekly") : "weekly";
                var date = addDateEl ? (addDateEl.value || "") : "";
                var time = addTimeEl ? (addTimeEl.value || "") : "";
                if (!studentId || !date || !time){
                    setAddMsg("Select student, date and time");
                    return;
                }
                setAddMsg("Saving…");
                post({
                    action: "e360_teacher_add_booking",
                    nonce: box.getAttribute("data-nonce"),
                    teacher_id: addTeacherId,
                    course_id: addCourseId,
                    student_id: studentId,
                    repeat: repeat,
                    date: date,
                    time: time,
                    duration: addDuration
                }).then(function(resp){
                    if (!resp || !resp.success){
                        var m = resp && resp.data && resp.data.message ? resp.data.message : "Error";
                        setAddMsg(m);
                        return;
                    }
                    window.location.reload();
                });
            });
        }
    })();
    </script>';
    }

    return $out;
}

function e360_course_schedule_box_html(int $course_id, int $uid): string {
    $is_teacher = current_user_can('tutor_instructor') || current_user_can('manage_options');
    $out = '';

    if (!$is_teacher) {
        if (function_exists('e360_is_student_enrolled_in_course') && !e360_is_student_enrolled_in_course($uid, $course_id)) {
            return '';
        }
        $next = e360_student_next_occurrence_for_course($uid, $course_id);
        if ((int)$next['booking_id'] <= 0) return '';
        $bid = (int)$next['booking_id'];
        $label = e360_next_occurrence_label($bid);
        $teacher_id = (int) get_post_meta($bid, 'teacher_id', true);
        $tz_name = e360_get_teacher_timezone_string($teacher_id);
        $calendar = e360_student_course_calendar_data($uid, $course_id, 30, $tz_name);
        $days_map = (array)($calendar['days'] ?? []);
        $req_nonce = wp_create_nonce('e360_student_reschedule_request');
        $slots_nonce = wp_create_nonce('e360_booking_nonce');
        $ajax = admin_url('admin-ajax.php');
        $duration = (int) get_post_meta($bid, 'duration_min', true);
        if ($duration <= 0) $duration = 60;
        $box_id = 'e360-student-reschedule-box-' . $course_id . '-' . $uid . '-' . $bid;
        $can_request = ((int)$next['ts_utc'] - current_time('timestamp', true)) >= DAY_IN_SECONDS;

        $out .= '<div class="tutor-course-progress-wrapper tutor-mb-32" style="margin-top:14px;">';
        $out .= '<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">Your lesson schedule</h3>';
        $out .= '<div style="font-size:14px;">';
        $out .= '<div><strong>Next:</strong> ' . esc_html($label['when']) . '</div>';
        $out .= '</div>';

        $out .= '<div class="e360-student-calendar-wrap" style="margin-top:10px;">';
        $out .= '<div style="font-weight:600;margin-bottom:8px;">Booked lessons (next 30 days)</div>';
        $out .= '<div style="display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px;">';
        $tz = new DateTimeZone($tz_name);
        $today = new DateTimeImmutable('now', $tz);
        for ($i = 0; $i < 30; $i++) {
            $d = $today->modify('+' . $i . ' day');
            $ymd = $d->format('Y-m-d');
            $times = isset($days_map[$ymd]) && is_array($days_map[$ymd]) ? $days_map[$ymd] : [];
            $title = $d->format('D, M j');
            if (!$times) {
                $out .= '<div style="border:1px solid #efefef;border-radius:8px;padding:8px;min-height:58px;opacity:.7;">';
                $out .= '<div style="font-size:12px;">' . esc_html($title) . '</div>';
                $out .= '</div>';
            } else {
                $out .= '<div style="border:1px solid #c9d7ff;background:#f6f9ff;border-radius:8px;padding:8px;min-height:58px;">';
                $out .= '<div style="font-size:12px;font-weight:600;margin-bottom:4px;">' . esc_html($title) . '</div>';
                $out .= '<div style="font-size:12px;line-height:1.35;">' . esc_html(implode(', ', $times)) . '</div>';
                $out .= '</div>';
            }
        }
        $out .= '</div></div>';

        $out .= '<div id="' . esc_attr($box_id) . '" style="margin-top:12px;" data-ajax="' . esc_attr($ajax) . '" data-req-nonce="' . esc_attr($req_nonce) . '" data-slots-nonce="' . esc_attr($slots_nonce) . '" data-booking-id="' . (int)$bid . '" data-teacher-id="' . (int)$teacher_id . '" data-duration="' . (int)$duration . '">';
        if ($can_request) {
            $out .= '<button type="button" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm e360-open-student-reschedule">Request time change</button>';
            $out .= '<div style="font-size:12px;opacity:.75;margin-top:4px;">Requests are allowed only earlier than 24 hours before next lesson.</div>';
        } else {
            $out .= '<div style="font-size:12px;opacity:.75;">Reschedule request is disabled: less than 24 hours before next lesson.</div>';
        }
        $out .= '<span class="e360-student-reschedule-msg" style="margin-left:8px;opacity:.8;"></span>';
        $out .= '
        <div class="e360-student-reschedule-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:99999;padding:20px;">
          <div style="max-width:520px;margin:40px auto;background:#fff;border-radius:12px;padding:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div style="font-weight:700;">Request lesson reschedule</div>
                <button type="button" class="e360-student-close tutor-iconic-btn"><span class="tutor-icon-times"></span></button>
            </div>
            <div style="margin-top:10px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">Date</label>
                <input type="date" class="e360-student-date tutor-form-control" />
                <div class="e360-student-available" style="margin-top:8px;font-size:12px;opacity:.85;"></div>
            </div>
            <div style="margin-top:10px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">Time</label>
                <select class="e360-student-time tutor-form-select"><option value="">Select available date first…</option></select>
            </div>
            <div style="margin-top:10px;">
                <label style="display:block;font-weight:600;margin-bottom:6px;">Reason</label>
                <textarea class="e360-student-reason tutor-form-control" rows="3" placeholder="Please provide reason"></textarea>
            </div>
            <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
                <button type="button" class="tutor-btn tutor-btn-primary e360-student-send">Send request</button>
                <span class="e360-student-modal-msg" style="opacity:.8;"></span>
            </div>
          </div>
        </div>';
        $out .= '</div>';

        $out .= '<script>
        (function(){
            var box = document.getElementById("' . esc_js($box_id) . '");
            if (!box || box.getAttribute("data-bound")==="1") return;
            box.setAttribute("data-bound","1");
            var openBtn = box.querySelector(".e360-open-student-reschedule");
            var modal = box.querySelector(".e360-student-reschedule-modal");
            var closeBtn = box.querySelector(".e360-student-close");
            var dateEl = box.querySelector(".e360-student-date");
            var availableEl = box.querySelector(".e360-student-available");
            var timeEl = box.querySelector(".e360-student-time");
            var reasonEl = box.querySelector(".e360-student-reason");
            var sendBtn = box.querySelector(".e360-student-send");
            var msgEl = box.querySelector(".e360-student-reschedule-msg");
            var modalMsg = box.querySelector(".e360-student-modal-msg");
            var teacherId = parseInt(box.getAttribute("data-teacher-id"),10)||0;
            var bookingId = parseInt(box.getAttribute("data-booking-id"),10)||0;
            var duration = parseInt(box.getAttribute("data-duration"),10)||60;
            var availableMap = {};
            var availableLoaded = false;

            function setMsg(t){ if(msgEl) msgEl.textContent = t||""; }
            function setModalMsg(t){ if(modalMsg) modalMsg.textContent = t||""; }
            function syncTutorSelectUi(selectEl){
                if (!selectEl) return;
                var wrap = selectEl.parentElement ? selectEl.parentElement.querySelector(".tutor-js-form-select") : null;
                if (!wrap) return;
                var labelEl = wrap.querySelector("[tutor-dropdown-label]");
                var optsWrap = wrap.querySelector(".tutor-form-select-options");
                if (!labelEl || !optsWrap) return;

                var selectedText = "";
                if (selectEl.selectedIndex >= 0 && selectEl.options[selectEl.selectedIndex]) {
                    selectedText = selectEl.options[selectEl.selectedIndex].textContent || "";
                }
                if (!selectedText && selectEl.options.length) {
                    selectedText = selectEl.options[0].textContent || "";
                }
                labelEl.textContent = selectedText || "Select…";

                optsWrap.innerHTML = "";
                Array.prototype.forEach.call(selectEl.options, function(opt, idx){
                    var item = document.createElement("div");
                    item.className = "tutor-form-select-option" + ((opt.selected || (idx === 0 && !selectEl.value)) ? " is-active" : "");
                    var span = document.createElement("span");
                    span.setAttribute("tutor-dropdown-item", "");
                    span.setAttribute("data-key", opt.value || "");
                    span.className = "tutor-nowrap-ellipsis";
                    span.title = opt.textContent || "";
                    span.textContent = opt.textContent || "";
                    item.appendChild(span);
                    item.addEventListener("click", function(){
                        selectEl.value = opt.value || "";
                        labelEl.textContent = opt.textContent || "";
                        var ev = new Event("change", { bubbles: true });
                        selectEl.dispatchEvent(ev);
                        var active = optsWrap.querySelectorAll(".tutor-form-select-option");
                        active.forEach(function(a){ a.classList.remove("is-active"); });
                        item.classList.add("is-active");
                    });
                    optsWrap.appendChild(item);
                });
            }
            function post(params){
                return fetch(box.getAttribute("data-ajax"),{
                    method:"POST",
                    credentials:"same-origin",
                    headers:{"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
                    body:(new URLSearchParams(params)).toString()
                }).then(function(r){ return r.json(); });
            }

            function setTimeOptions(slots){
                var list = Array.isArray(slots) ? slots : [];
                if (!list.length){
                    timeEl.innerHTML = "<option value=\\"\\">No available slots</option>";
                    syncTutorSelectUi(timeEl);
                    return;
                }
                timeEl.innerHTML = "<option value=\\"\\">Select…</option>";
                list.forEach(function(s){
                    var opt = document.createElement("option");
                    opt.value = s;
                    opt.textContent = (s||"").substring(0,5);
                    timeEl.appendChild(opt);
                });
                syncTutorSelectUi(timeEl);
            }

            function renderAvailableDates(tzName){
                if (!availableEl) return;
                var dates = Object.keys(availableMap);
                if (!dates.length){
                    availableEl.textContent = "No free dates in the next period.";
                    return;
                }
                var html = "<div style=\\"margin-bottom:6px;\\">Available dates (teacher timezone: <strong>" + (tzName || "") + "</strong>)</div>";
                html += "<div style=\\"display:flex;flex-wrap:wrap;gap:6px;\\">";
                dates.slice(0, 12).forEach(function(d){
                    html += "<button type=\\"button\\" class=\\"button button-small e360-pick-date\\" data-date=\\"" + d + "\\">" + d + "</button>";
                });
                html += "</div>";
                availableEl.innerHTML = html;
                var btns = availableEl.querySelectorAll(".e360-pick-date");
                btns.forEach(function(btn){
                    btn.addEventListener("click", function(){
                        var d = btn.getAttribute("data-date") || "";
                        if (!d) return;
                        dateEl.value = d;
                        dateEl.dispatchEvent(new Event("change"));
                    });
                });
            }

            function loadSlotsForDate(date){
                if (!date || !teacherId) { setTimeOptions([]); return; }
                setModalMsg("Loading available time…");
                setTimeOptions([]);
                post({
                    action:"e360_get_slots",
                    nonce: box.getAttribute("data-slots-nonce") || "",
                    teacher_id: teacherId,
                    date: date,
                    duration: duration
                }).then(function(resp){
                    if (!resp || !resp.success){
                        setTimeOptions([]);
                        setModalMsg("Failed to load available time.");
                        return;
                    }
                    var slots = (resp.data && resp.data.slots) ? resp.data.slots : [];
                    setTimeOptions(slots);
                    if (slots.length) {
                        setModalMsg("");
                    } else {
                        setModalMsg("No free time for this date.");
                    }
                }).catch(function(){
                    setTimeOptions([]);
                    setModalMsg("Failed to load available time.");
                });
            }

            function loadAvailableDates(){
                if (availableLoaded) return Promise.resolve();
                availableLoaded = true;
                setModalMsg("Loading available dates…");
                return post({
                    action:"e360_get_teacher_available_dates",
                    nonce: box.getAttribute("data-slots-nonce") || "",
                    teacher_id: teacherId,
                    duration: duration,
                    days: 45
                }).then(function(resp){
                    if (!resp || !resp.success){
                        availableMap = {};
                        if (availableEl) availableEl.textContent = "Failed to load available dates.";
                        setModalMsg("");
                        return;
                    }
                    availableMap = {};
                    var items = (resp.data && resp.data.days) ? resp.data.days : [];
                    items.forEach(function(it){
                        if (!it || !it.date) return;
                        availableMap[it.date] = true;
                    });
                    var keys = Object.keys(availableMap).sort();
                    if (keys.length && dateEl) {
                        dateEl.min = keys[0];
                    }
                    renderAvailableDates((resp.data && resp.data.timezone) ? resp.data.timezone : "");
                    setModalMsg("");
                }).catch(function(){
                    if (availableEl) availableEl.textContent = "Failed to load available dates.";
                    setModalMsg("");
                });
            }

            if (openBtn) openBtn.addEventListener("click", function(){
                modal.style.display="block";
                setModalMsg("");
                loadAvailableDates();
            });
            if (closeBtn) closeBtn.addEventListener("click", function(){ modal.style.display="none"; });
            if (modal) modal.addEventListener("click", function(e){ if(e.target===modal) modal.style.display="none"; });

            if (dateEl) dateEl.addEventListener("change", function(){
                var date = this.value || "";
                if (!date) { setTimeOptions([]); return; }
                if (!availableMap[date]) {
                    setModalMsg("This date may have no free slots. Checking...");
                }
                loadSlotsForDate(date);
            });

            if (sendBtn) sendBtn.addEventListener("click", function(){
                var date = (dateEl && dateEl.value) ? dateEl.value : "";
                var time = (timeEl && timeEl.value) ? timeEl.value : "";
                var reason = (reasonEl && reasonEl.value) ? reasonEl.value : "";
                if (!date || !time){ setModalMsg("Select date and time"); return; }
                if (!reason.trim()){ setModalMsg("Please provide reason"); return; }
                setModalMsg("Sending…");
                post({
                    action:"e360_student_request_reschedule",
                    nonce: box.getAttribute("data-req-nonce") || "",
                    booking_id: bookingId,
                    date: date,
                    time: time,
                    reason: reason
                }).then(function(resp){
                    if (!resp || !resp.success){
                        var m = resp && resp.data && resp.data.message ? resp.data.message : "Error";
                        setModalMsg(m);
                        return;
                    }
                    modal.style.display = "none";
                    setMsg("Request sent to teacher.");
                });
            });
        })();
        </script>';

        $out .= '</div>';
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

function e360_course_teacher_schedule_tab_html(int $course_id, int $teacher_id, bool $can_edit = true): string {
    $bookings = e360_get_teacher_bookings($teacher_id, $course_id, 100);

    $out = '<div style="padding:8px 0 4px;">';
    $out .= '<h4 style="margin:0 0 8px;">Course schedule</h4>';
    $out .= '<div style="opacity:.8;margin-bottom:10px;">Reschedule lessons within your available hours.</div>';
    $out .= e360_render_teacher_pending_reschedule_requests($teacher_id, $course_id);
    $out .= e360_render_teacher_course_calendar_html($teacher_id, $course_id, 30);

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
        'allow_add' => $can_edit,
        'course_id' => $course_id,
        'teacher_id' => $teacher_id,
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

function e360_course_schedule_tab_content_html(int $course_id, int $uid): string {
    if (!e360_can_view_course_schedule_tab($uid, $course_id)) return '';

    if (e360_can_manage_course_schedule($uid, $course_id)) {
        $teacher_id = e360_resolve_schedule_teacher_id_for_viewer($course_id, $uid);
        if ($teacher_id <= 0) return '';
        return e360_course_teacher_schedule_tab_html($course_id, $teacher_id, true);
    }

    return e360_course_schedule_box_html($course_id, $uid);
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
    echo e360_course_schedule_tab_content_html($course_id, $uid);
});

add_action('wp_footer', function () {
    if (!is_singular(['courses', 'tutor_course'])) return;
    if (!is_user_logged_in()) return;

    $course_id = (int) get_the_ID();
    $uid = (int) get_current_user_id();
    if (!$course_id || !$uid) return;
    if (!e360_can_view_course_schedule_tab($uid, $course_id)) return;

    $html = e360_course_schedule_tab_content_html($course_id, $uid);
    if ($html === '') return;
    ?>
<div id="e360-course-schedule-tab-content" style="display:none;"><?php echo $html; ?></div>
<script>
(function() {
    function tryMount() {
        var src = document.getElementById('e360-course-schedule-tab-content');
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