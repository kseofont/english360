<?php
add_action('show_user_profile', 'e360_admin_credits_box');
add_action('edit_user_profile', 'e360_admin_credits_box');

function e360_admin_credit_course_ids(int $user_id): array {
    $all = get_user_meta($user_id);
    if (!is_array($all)) $all = [];

    $ids = [];
    foreach (array_keys($all) as $k) {
        if (preg_match('/^e360_credits_(?:total|used|ledger)_(\d+)$/', (string)$k, $m)) {
            $ids[] = (int)$m[1];
        }
    }

    $primary = (int) get_user_meta($user_id, 'e360_primary_course_id', true);
    if ($primary > 0) $ids[] = $primary;

    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    sort($ids);
    return $ids;
}

function e360_admin_credit_add_sources(int $user_id, int $course_id): array {
    $ledger = get_user_meta($user_id, 'e360_credits_ledger_' . $course_id, true);
    if (!is_array($ledger)) return [];

    $out = [];
    foreach ($ledger as $row) {
        if (!is_array($row)) continue;
        if (($row['type'] ?? '') !== 'add') continue;

        $qty = (int)($row['qty'] ?? 0);
        $reason = (string)($row['reason'] ?? '');
        $ts = (string)($row['ts'] ?? '');
        $by = (int)($row['by'] ?? 0);
        $line = '';

        if (preg_match('/Woo order #(\d+)/i', $reason, $m) && function_exists('wc_get_order')) {
            $oid = (int)$m[1];
            $order = wc_get_order($oid);
            $order_date = $order && $order->get_date_created() ? $order->get_date_created()->date_i18n('Y-m-d H:i') : '';
            $pay_method = $order ? (string)$order->get_payment_method_title() : '';
            $line = 'Woo order #' . $oid;
            if ($order_date !== '') $line .= ' (' . $order_date . ')';
            if ($pay_method !== '') $line .= ' via ' . $pay_method;
        } elseif (stripos($reason, 'Admin:') === 0) {
            $admin_name = '';
            if ($by > 0) {
                $u = get_user_by('id', $by);
                if ($u) $admin_name = (string)$u->display_name;
            }
            $line = 'Admin';
            if ($admin_name !== '') $line .= ' (' . $admin_name . ')';
            if ($ts !== '') $line .= ' ' . $ts;
            $extra = trim(substr($reason, 6));
            if ($extra !== '') $line .= ': ' . $extra;
        } else {
            $line = ($reason !== '' ? $reason : 'Manual add');
            if ($ts !== '') $line .= ' (' . $ts . ')';
        }

        if ($qty > 0) $line .= ' +' . $qty;
        $out[] = $line;
    }

    if (!$out) return [];
    $out = array_values(array_reverse($out)); // latest first
    return array_slice($out, 0, 5);
}

function e360_admin_get_student_bookings(int $student_id): array {
    return get_posts([
        'post_type' => 'e360_booking',
        'post_status' => ['publish', 'pending'],
        'fields' => 'ids',
        'numberposts' => 200,
        'orderby' => 'ID',
        'order' => 'DESC',
        'meta_query' => [
            ['key' => 'student_id', 'value' => $student_id, 'compare' => '=', 'type' => 'NUMERIC'],
        ],
    ]);
}

function e360_admin_booking_teacher_tz(int $booking_id): string {
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    if ($teacher_id > 0 && function_exists('e360_get_teacher_timezone_string')) {
        return e360_get_teacher_timezone_string($teacher_id);
    }
    $wp_tz = function_exists('wp_timezone_string') ? (string) wp_timezone_string() : '';
    return $wp_tz ?: 'UTC';
}

function e360_admin_booking_current_date_time(int $booking_id): array {
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    $tz = new DateTimeZone(e360_admin_booking_teacher_tz($booking_id));

    if ($repeat === 'once') {
        $d = (string) get_post_meta($booking_id, 'local_date', true);
        $t = (string) get_post_meta($booking_id, 'local_time', true);
        if ($d !== '' && $t !== '') return ['repeat' => 'once', 'date' => $d, 'time' => $t];

        $startUtc = (int) get_post_meta($booking_id, 'start_ts_utc', true);
        if ($startUtc > 0) {
            $dt = (new DateTimeImmutable('@' . $startUtc))->setTimezone($tz);
            return ['repeat' => 'once', 'date' => $dt->format('Y-m-d'), 'time' => $dt->format('H:i')];
        }
        return ['repeat' => 'once', 'date' => '', 'time' => ''];
    }

    $date = (string) get_post_meta($booking_id, 'start_date', true);
    $startMin = (int) get_post_meta($booking_id, 'start_min', true);
    $hh = floor(max(0, $startMin) / 60);
    $mm = max(0, $startMin) % 60;
    $time = sprintf('%02d:%02d', $hh, $mm);
    return ['repeat' => 'weekly', 'date' => $date, 'time' => $time];
}

function e360_admin_booking_occurrences(int $booking_id, int $past_limit = 8, int $future_limit = 8): array {
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    $tzName = e360_admin_booking_teacher_tz($booking_id);
    $tz = new DateTimeZone($tzName);
    $nowUtc = current_time('timestamp', true);
    $past = [];
    $future = [];

    if ($repeat === 'once') {
        $startUtc = (int) get_post_meta($booking_id, 'start_ts_utc', true);
        if ($startUtc > 0) {
            $txt = (new DateTimeImmutable('@' . $startUtc))->setTimezone($tz)->format('Y-m-d H:i');
            if ($startUtc < $nowUtc) $past[] = $txt;
            else $future[] = $txt;
        }
        return ['past' => $past, 'future' => $future, 'tz' => $tzName];
    }

    $nextUtc = function_exists('e360_booking_next_occurrence_ts') ? (int) e360_booking_next_occurrence_ts($booking_id) : 0;
    if ($nextUtc <= 0) return ['past' => $past, 'future' => $future, 'tz' => $tzName];

    $startDate = (string) get_post_meta($booking_id, 'start_date', true);
    $startMin = (int) get_post_meta($booking_id, 'start_min', true);
    $startUtc = 0;
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
        $hh = floor(max(0, $startMin) / 60);
        $mm = max(0, $startMin) % 60;
        $dtStart = DateTimeImmutable::createFromFormat('Y-m-d H:i', $startDate . ' ' . sprintf('%02d:%02d', $hh, $mm), $tz);
        if ($dtStart) $startUtc = (int)$dtStart->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
    }

    for ($i = $past_limit; $i >= 1; $i--) {
        $ts = $nextUtc - ($i * 7 * DAY_IN_SECONDS);
        if ($startUtc > 0 && $ts < $startUtc) continue;
        if ($ts >= $nowUtc) continue;
        $past[] = (new DateTimeImmutable('@' . $ts))->setTimezone($tz)->format('Y-m-d H:i');
    }

    for ($i = 0; $i < $future_limit; $i++) {
        $ts = $nextUtc + ($i * 7 * DAY_IN_SECONDS);
        if ($startUtc > 0 && $ts < $startUtc) continue;
        if ($ts < $nowUtc) continue;
        $future[] = (new DateTimeImmutable('@' . $ts))->setTimezone($tz)->format('Y-m-d H:i');
    }

    return ['past' => $past, 'future' => $future, 'tz' => $tzName];
}

function e360_admin_update_booking_from_profile(int $booking_id, array $input): bool {
    $booking = get_post($booking_id);
    if (!$booking || $booking->post_type !== 'e360_booking') return false;

    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    if ($teacher_id <= 0) return false;

    $repeat = (isset($input['repeat']) && $input['repeat'] === 'once') ? 'once' : 'weekly';
    $date = isset($input['date']) ? sanitize_text_field((string)$input['date']) : '';
    $time = isset($input['time']) ? sanitize_text_field((string)$input['time']) : '';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return false;
    if (!preg_match('/^\d{2}:\d{2}$/', $time)) return false;

    $duration = (int) get_post_meta($booking_id, 'duration_min', true);
    if ($duration <= 0) $duration = 60;

    $tz = new DateTimeZone(e360_admin_booking_teacher_tz($booking_id));
    update_post_meta($booking_id, 'repeat', $repeat);

    if ($repeat === 'once') {
        $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $time, $tz);
        if (!$dtLocal) return false;
        $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
        $endUtc = $startUtc + ($duration * 60);

        if (function_exists('e360_booking_conflict_once') && e360_booking_conflict_once($teacher_id, $startUtc, $endUtc, $booking_id)) {
            return false;
        }

        update_post_meta($booking_id, 'start_ts_utc', $startUtc);
        update_post_meta($booking_id, 'end_ts_utc', $endUtc);
        update_post_meta($booking_id, 'local_date', $date);
        update_post_meta($booking_id, 'local_time', $time);
        delete_post_meta($booking_id, 'weekday');
        delete_post_meta($booking_id, 'start_min');
        delete_post_meta($booking_id, 'end_min');
        delete_post_meta($booking_id, 'start_date');
        return true;
    }

    $weekday = function_exists('e360_weekday_key_from_date')
        ? e360_weekday_key_from_date($date, $tz)
        : strtolower((new DateTimeImmutable($date . ' 00:00:00', $tz))->format('D'));
    if (strlen($weekday) > 3) $weekday = substr($weekday, 0, 3);

    $startMin = function_exists('e360_minutes_from_hhmm')
        ? e360_minutes_from_hhmm($time)
        : ((int)substr($time, 0, 2) * 60 + (int)substr($time, 3, 2));
    $endMin = $startMin + $duration;

    if (function_exists('e360_booking_conflict_weekly') && e360_booking_conflict_weekly($teacher_id, $weekday, $startMin, $endMin, $booking_id)) {
        return false;
    }

    update_post_meta($booking_id, 'weekday', $weekday);
    update_post_meta($booking_id, 'start_min', $startMin);
    update_post_meta($booking_id, 'end_min', $endMin);
    update_post_meta($booking_id, 'start_date', $date);
    delete_post_meta($booking_id, 'start_ts_utc');
    delete_post_meta($booking_id, 'end_ts_utc');
    delete_post_meta($booking_id, 'local_date');
    delete_post_meta($booking_id, 'local_time');
    return true;
}

function e360_admin_credits_box($user){
    if (!current_user_can('manage_options')) return;

    $courses = get_posts([
        'post_type' => 'courses',
        'numberposts' => 200,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    ]);

    $primary_course = (int) get_user_meta($user->ID, 'e360_primary_course_id', true);
    $credit_course_ids = e360_admin_credit_course_ids((int)$user->ID);

    ?>
<h2>English360 Credits (per course)</h2>
<table class="form-table" role="presentation">
    <tr>
        <th><label>Course</label></th>
        <td>
            <select name="e360_admin_course_id">
                <option value="">Select…</option>
                <?php foreach ($courses as $c): ?>
                <option value="<?php echo (int)$c->ID; ?>" <?php selected((int)$c->ID, $primary_course); ?>>
                    <?php echo esc_html($c->post_title); ?> (#<?php echo (int)$c->ID; ?>)
                </option>
                <?php endforeach; ?>
            </select>
            <p class="description">Select a course to view/update credits for this student.</p>
        </td>
    </tr>

    <tr>
        <th><label>Add credits</label></th>
        <td>
            <input type="number" name="e360_admin_add_credits" value="0" min="0">
            <input type="text" name="e360_admin_reason" placeholder="Reason (optional)" style="min-width:260px;">
        </td>
    </tr>

    <tr>
        <th><label>Set totals (optional)</label></th>
        <td>
            <input type="number" name="e360_admin_set_total" value="" min="0" placeholder="total">
            <input type="number" name="e360_admin_set_used" value="" min="0" placeholder="used">
            <p class="description">If provided, these overwrite values.</p>
        </td>
    </tr>
</table>

<h2>Credits Summary</h2>
<table class="widefat striped" style="max-width:900px;">
    <thead>
        <tr>
            <th>Course</th>
            <th>Total</th>
            <th>Used</th>
            <th>Remaining</th>
            <th>Added via</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$credit_course_ids): ?>
        <tr>
            <td colspan="5" style="opacity:.7;">No credits data found for this student yet.</td>
        </tr>
        <?php else: ?>
        <?php foreach ($credit_course_ids as $cid):
            $title = get_the_title($cid);
            if (!$title) $title = 'Course #' . $cid;
            $total = function_exists('e360_get_credits_total') ? (int)e360_get_credits_total((int)$user->ID, $cid) : 0;
            $used = function_exists('e360_get_credits_used') ? (int)e360_get_credits_used((int)$user->ID, $cid) : 0;
            $bal = function_exists('e360_get_credits_balance') ? (int)e360_get_credits_balance((int)$user->ID, $cid) : max(0, $total - $used);
            $sources = e360_admin_credit_add_sources((int)$user->ID, $cid);
        ?>
        <tr>
            <td><?php echo esc_html($title); ?> (#<?php echo (int)$cid; ?>)</td>
            <td><?php echo esc_html((string)$total); ?></td>
            <td><?php echo esc_html((string)$used); ?></td>
            <td><strong><?php echo esc_html((string)$bal); ?></strong></td>
            <td>
                <?php if (!$sources): ?>
                <span style="opacity:.7;">—</span>
                <?php else: ?>
                <?php foreach ($sources as $s): ?>
                <div style="margin-bottom:4px;"><?php echo esc_html($s); ?></div>
                <?php endforeach; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php
    $usage_rows = [];
    foreach ($credit_course_ids as $cid) {
        $ledger = get_user_meta((int)$user->ID, 'e360_credits_ledger_' . $cid, true);
        if (!is_array($ledger)) continue;
        foreach ($ledger as $row) {
            if (!is_array($row)) continue;
            if (($row['type'] ?? '') !== 'spend') continue;
            $usage_rows[] = [
                'course_id' => (int)$cid,
                'qty' => (int)($row['qty'] ?? 0),
                'reason' => (string)($row['reason'] ?? ''),
                'ts' => (string)($row['ts'] ?? ''),
            ];
        }
    }
    usort($usage_rows, function($a, $b){
        return strcmp((string)$b['ts'], (string)$a['ts']);
    });
?>
<h2>Credits Usage History</h2>
<table class="widefat striped" style="max-width:1100px;">
    <thead>
        <tr>
            <th>Date</th>
            <th>Course</th>
            <th>Used</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$usage_rows): ?>
        <tr>
            <td colspan="4" style="opacity:.7;">No credit usage yet.</td>
        </tr>
        <?php else: ?>
        <?php foreach ($usage_rows as $r):
            $cid = (int)$r['course_id'];
            $title = get_the_title($cid);
            if (!$title) $title = 'Course #' . $cid;
        ?>
        <tr>
            <td><?php echo esc_html((string)$r['ts']); ?></td>
            <td><?php echo esc_html($title); ?> (#<?php echo (int)$cid; ?>)</td>
            <td><?php echo esc_html((string)$r['qty']); ?></td>
            <td><?php echo esc_html((string)$r['reason']); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php
    $bookings = e360_admin_get_student_bookings((int)$user->ID);
?>
<h2>Student Schedule</h2>
<table class="widefat striped" style="max-width:1200px;">
    <thead>
        <tr>
            <th>Course</th>
            <th>Teacher</th>
            <th>Timezone (teacher)</th>
            <th>Current schedule</th>
            <th>Edit schedule</th>
            <th>History (past lessons)</th>
            <th>Upcoming lessons</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$bookings): ?>
        <tr>
            <td colspan="7" style="opacity:.7;">No bookings found for this student.</td>
        </tr>
        <?php else: ?>
        <?php foreach ($bookings as $bid):
            $bid = (int)$bid;
            $course_id = (int)get_post_meta($bid, 'course_id', true);
            $teacher_id = (int)get_post_meta($bid, 'teacher_id', true);
            $course_title = $course_id ? get_the_title($course_id) : '';
            if (!$course_title) $course_title = 'Course #' . $course_id;
            $teacher = $teacher_id ? get_user_by('id', $teacher_id) : null;
            $teacher_label = $teacher ? $teacher->display_name : ('Teacher #' . $teacher_id);
            $tz = e360_admin_booking_teacher_tz($bid);
            $curr = e360_admin_booking_current_date_time($bid);
            $occ = e360_admin_booking_occurrences($bid, 8, 8);
        ?>
        <tr>
            <td><?php echo esc_html($course_title); ?> (#<?php echo (int)$course_id; ?>)</td>
            <td><?php echo esc_html($teacher_label); ?> (#<?php echo (int)$teacher_id; ?>)</td>
            <td><?php echo esc_html($tz); ?></td>
            <td>
                <?php if (function_exists('e360_next_occurrence_label')):
                    $label = e360_next_occurrence_label($bid);
                    echo esc_html((string)($label['when'] ?? ''));
                else: ?>
                <?php echo esc_html(($curr['date'] ?? '') . ' ' . ($curr['time'] ?? '')); ?>
                <?php endif; ?>
            </td>
            <td>
                <input type="hidden" name="e360_admin_booking[<?php echo (int)$bid; ?>][booking_id]"
                    value="<?php echo (int)$bid; ?>">
                <select name="e360_admin_booking[<?php echo (int)$bid; ?>][repeat]">
                    <option value="weekly" <?php selected(($curr['repeat'] ?? ''), 'weekly'); ?>>Weekly</option>
                    <option value="once" <?php selected(($curr['repeat'] ?? ''), 'once'); ?>>One-time</option>
                </select>
                <br>
                <input type="date" name="e360_admin_booking[<?php echo (int)$bid; ?>][date]"
                    value="<?php echo esc_attr((string)($curr['date'] ?? '')); ?>">
                <input type="time" name="e360_admin_booking[<?php echo (int)$bid; ?>][time]"
                    value="<?php echo esc_attr((string)($curr['time'] ?? '')); ?>">
            </td>
            <td>
                <?php if (empty($occ['past'])): ?>
                <span style="opacity:.7;">No past lessons</span>
                <?php else: ?>
                <?php foreach ($occ['past'] as $d): ?>
                <div><?php echo esc_html($d); ?> <span style="opacity:.65;">(<?php echo esc_html($occ['tz']); ?>)</span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if (empty($occ['future'])): ?>
                <span style="opacity:.7;">No upcoming lessons</span>
                <?php else: ?>
                <?php foreach ($occ['future'] as $d): ?>
                <div><?php echo esc_html($d); ?> <span style="opacity:.65;">(<?php echo esc_html($occ['tz']); ?>)</span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<p class="description">To apply schedule edits, click "Update User" at the bottom of the profile page.</p>

<?php wp_nonce_field('e360_admin_credits_save', 'e360_admin_credits_nonce'); ?>
<?php
}

add_action('personal_options_update', 'e360_admin_credits_save');
add_action('edit_user_profile_update', 'e360_admin_credits_save');

function e360_admin_credits_save($user_id){
    if (!current_user_can('manage_options')) return;
    if (empty($_POST['e360_admin_credits_nonce']) || !wp_verify_nonce($_POST['e360_admin_credits_nonce'], 'e360_admin_credits_save')) return;

    $course_id = isset($_POST['e360_admin_course_id']) ? (int)$_POST['e360_admin_course_id'] : 0;

    if ($course_id > 0) {
        // overwrite totals
        $set_total = isset($_POST['e360_admin_set_total']) && $_POST['e360_admin_set_total'] !== '' ? (int)$_POST['e360_admin_set_total'] : null;
        $set_used  = isset($_POST['e360_admin_set_used'])  && $_POST['e360_admin_set_used']  !== '' ? (int)$_POST['e360_admin_set_used']  : null;

        if ($set_total !== null) update_user_meta($user_id, e360_credits_key_total($course_id), max(0,$set_total));
        if ($set_used  !== null) update_user_meta($user_id, e360_credits_key_used($course_id),  max(0,$set_used));

        // add credits
        $add = isset($_POST['e360_admin_add_credits']) ? (int)$_POST['e360_admin_add_credits'] : 0;
        $reason = isset($_POST['e360_admin_reason']) ? sanitize_text_field(wp_unslash($_POST['e360_admin_reason'])) : '';
        if ($add > 0) {
            e360_add_credits($user_id, $course_id, $add, 'Admin: ' . $reason);
        }
    }

    // booking schedule edits from admin profile
    $booking_rows = isset($_POST['e360_admin_booking']) ? wp_unslash($_POST['e360_admin_booking']) : [];
    if (is_array($booking_rows)) {
        foreach ($booking_rows as $bid => $row) {
            $bid = (int)$bid;
            if ($bid <= 0 || !is_array($row)) continue;
            e360_admin_update_booking_from_profile($bid, $row);
        }
    }
}