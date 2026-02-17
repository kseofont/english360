<?php
/**
* ---------------------------
* Teacher: Mark lesson completed (spend 1 credit)
* ---------------------------
*/

// 1) helper: course_id by lesson_id (Tutor LMS / fallbacks)
function e360_get_course_id_by_lesson(int $lesson_id): int {
// Tutor LMS helper (если есть)
if (function_exists('tutor_utils')) {
$u = tutor_utils();
if (is_object($u) && method_exists($u, 'get_course_id_by_lesson')) {
$cid = (int) $u->get_course_id_by_lesson($lesson_id);
if ($cid) return $cid;
}
}

// частые варианты meta
$meta_keys = ['_tutor_course_id_for_lesson', '_tutor_course_id', 'tutor_course_id'];
foreach ($meta_keys as $k) {
$cid = (int) get_post_meta($lesson_id, $k, true);
if ($cid) return $cid;
}

// fallback: parent
$parent = (int) wp_get_post_parent_id($lesson_id);
return $parent;
}

// 2) helper: teacher can manage this lesson? (is course author or admin)
function e360_teacher_can_manage_lesson(int $teacher_id, int $lesson_id): bool {
    $course_id = e360_get_course_id_by_lesson($lesson_id);
    if (!$course_id) return false;

    return e360_is_course_instructor($teacher_id, $course_id);
}


// 3) student public label: First + last initial
function e360_student_public_label(int $student_id): string {
$u = get_user_by('id', $student_id);
if (!$u) return 'Student #' . $student_id;

$first = trim((string) get_user_meta($student_id, 'first_name', true));
$last = trim((string) get_user_meta($student_id, 'last_name', true));

if ($first === '') {
$parts = preg_split('/\s+/', trim((string) $u->display_name));
$first = $parts[0] ?? $u->display_name;
$last = $parts[1] ?? $last;
}

$initial = $last ? (mb_substr($last, 0, 1) . '.') : '';
return trim($first . ' ' . $initial);
}

// 4) render box on lesson page (ONLY teacher/admin)
add_filter('the_content', function($content){
if (!is_singular()) return $content;
if (!is_main_query()) return $content;
if (!in_the_loop()) return $content;
if (!is_user_logged_in()) return $content;

$pt = get_post_type(get_the_ID());
if (!in_array($pt, ['lesson','tutor_lesson','tutor_course_lesson','topic','tutor_topic'], true)) return $content;


// only teacher/admin
if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return $content;

$teacher_id = get_current_user_id();
$lesson_id = (int) get_the_ID();
$course_id = e360_get_course_id_by_lesson($lesson_id);

if (!$course_id) return $content;

if (!e360_is_course_instructor($teacher_id, $course_id)) return;


// only course owner teacher/admin
if (!e360_teacher_can_manage_lesson($teacher_id, $lesson_id)) return $content;

// students assigned to this teacher + this course
$student_ids = e360_get_course_enrolled_student_ids($course_id);
$students = array_map(function($sid){
    return (object) ['ID' => (int)$sid];
}, $student_ids);


if (!$students) {
$box = '<div style="margin:14px 0;padding:12px;border:1px solid #e5e5e5;border-radius:12px;">
    <strong>Teacher tools</strong>
    <div style="margin-top:6px;opacity:.8;">No students linked to you for this course yet.</div>
</div>';
return $content . $box;
}

wp_enqueue_script('jquery');
$nonce = wp_create_nonce('e360_mark_lesson');
$ajax = admin_url('admin-ajax.php');

ob_start(); ?>
<div id="e360-mark-lesson-box" data-lesson-id="<?php echo esc_attr($lesson_id); ?>"
    data-course-id="<?php echo esc_attr($course_id); ?>" data-ajax="<?php echo esc_attr($ajax); ?>"
    data-nonce="<?php echo esc_attr($nonce); ?>"
    style="margin:14px 0;padding:12px;border:1px solid #e5e5e5;border-radius:12px;">
    <div style="font-weight:700;margin-bottom:8px;">Teacher tools</div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
        <div style="min-width:240px;">
            <label style="display:block;font-size:13px;opacity:.8;margin-bottom:4px;">Student</label>
            <select id="e360-student-id" style="width:100%;max-width:360px;">
                <option value="">Select student…</option>
                <?php foreach ($students as $s): ?>
                <option value="<?php echo (int)$s->ID; ?>">
                    <?php echo esc_html(e360_student_public_label((int)$s->ID)); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" id="e360-mark-lesson-btn" class="button button-primary">
            Mark lesson completed (spend 1 credit)
        </button>
    </div>

    <div id="e360-mark-lesson-msg" style="margin-top:10px;"></div>
</div>

<script>
jQuery(function($) {
    const $box = $('#e360-mark-lesson-box');
    const ajaxurl = $box.data('ajax');
    const nonce = $box.data('nonce');
    const lessonId = parseInt($box.data('lesson-id'), 10) || 0;
    const courseId = parseInt($box.data('course-id'), 10) || 0;

    function msg(html) {
        $('#e360-mark-lesson-msg').html(html);
    }

    $('#e360-mark-lesson-btn').on('click', function() {
        const studentId = parseInt($('#e360-student-id').val(), 10) || 0;
        if (!studentId) {
            msg('<span style="color:#b00;">Select a student first.</span>');
            return;
        }

        msg('<em>Saving…</em>');

        $.post(ajaxurl, {
            action: 'e360_mark_lesson_completed',
            nonce: nonce,
            lesson_id: lessonId,
            course_id: courseId,
            student_id: studentId
        }).done(function(resp) {
            if (!resp || !resp.success) {
                const m = (resp && resp.data && resp.data.message) ? resp.data.message :
                    'Error';
                msg('<span style="color:#b00;">' + $('<div>').text(m).html() + '</span>');
                return;
            }

            const d = resp.data || {};
            msg(
                '<span style="color:#060;">Done.</span> ' +
                'Remaining credits: <strong>' + (d.balance ?? '?') + '</strong>' +
                (d.used !== undefined ? ' <span style="opacity:.7;">(completed: ' + d.used +
                    ')</span>' : '')
            );
        }).fail(function() {
            msg('<span style="color:#b00;">Request failed.</span>');
        });
    });
});
</script>
<?php
    $box = ob_get_clean();

    return $content . $box;
}, 50);

// 5) AJAX: teacher marks lesson completed + spends 1 credit
add_action('wp_ajax_e360_mark_lesson_completed', function(){
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }

    check_ajax_referer('e360_mark_lesson', 'nonce');

    $teacher_id = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $lesson_id  = isset($_POST['lesson_id']) ? (int) $_POST['lesson_id'] : 0;
    $course_id  = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;
    $student_id = isset($_POST['student_id']) ? (int) $_POST['student_id'] : 0;

    if (!$lesson_id || !$student_id) {
        wp_send_json_error(['message' => 'lesson_id and student_id required'], 400);
    }

    // verify course_id from lesson (trust server more than client)
    $real_course_id = e360_get_course_id_by_lesson($lesson_id);
    if ($real_course_id) $course_id = $real_course_id;

    if (!$course_id) {
        wp_send_json_error(['message' => 'Cannot detect course for this lesson'], 400);
    }

    // teacher must own this course (or be admin)
    if (!e360_teacher_can_manage_lesson($teacher_id, $lesson_id)) {
        wp_send_json_error(['message' => 'You cannot manage this lesson'], 403);
    }

    // student must be linked to this teacher + course
  if (!e360_is_course_instructor($teacher_id, $course_id)) {
    wp_send_json_error(['message' => 'Not your course'], 403);
}

if (!e360_is_student_enrolled_in_course($student_id, $course_id)) {
    wp_send_json_error(['message' => 'Student not enrolled in this course'], 403);
}


    // prevent double spending for same student+lesson
    $meta_key = 'e360_completed_lesson_' . $lesson_id;

    // lock via unique meta
    $locked = add_user_meta($student_id, $meta_key, 'pending', true);
    if (!$locked) {
        // already completed earlier
       $bal  = function_exists('e360_get_credits_balance') ? (int)e360_get_credits_balance($student_id, $course_id) : null;
$used = function_exists('e360_get_credits_used') ? (int)e360_get_credits_used($student_id, $course_id) : null;


        wp_send_json_success([
            'message' => 'Already marked earlier.',
            'balance' => $bal,
            'used'    => $used,
        ]);
    }

    // spend 1 credit
    if (!function_exists('e360_spend_credits')) {
        // rollback lock
        delete_user_meta($student_id, $meta_key);
        wp_send_json_error(['message' => 'e360_spend_credits() is missing'], 500);
    }

    $lock = 'lesson:' . $lesson_id;
    $ok = e360_spend_credits($student_id, $course_id, 1, $lock);
    // После того как кредит списан — отмечаем урок завершённым в Tutor LMS
if (class_exists('\Tutor\Models\LessonModel')) {
    \Tutor\Models\LessonModel::mark_lesson_complete($lesson_id, $student_id);
}
    if (!$ok) {
        delete_user_meta($student_id, $meta_key);
        wp_send_json_error(['message' => 'Not enough credits'], 400);
    }

    // finalize meta with details
    update_user_meta($student_id, $meta_key, [
        'course_id'     => $course_id,
        'teacher_id'    => $teacher_id,
        'completed_at'  => current_time('mysql'),
    ]);

    // OPTIONAL: try to mark as completed in Tutor LMS (if method exists)
    if (function_exists('tutor_utils')) {
        $u = tutor_utils();
        // разные версии Tutor могут иметь разные методы — пробуем безопасно
        foreach (['mark_lesson_complete', 'mark_lesson_complete_by_user'] as $m) {
            if (is_object($u) && method_exists($u, $m)) {
                try { $u->{$m}($lesson_id, $student_id); } catch (\Throwable $e) {}
                break;
            }
        }
    }

    $bal  = e360_get_credits_balance($student_id, $course_id);
    $used = e360_get_credits_used($student_id, $course_id);


    wp_send_json_success([
        'message' => 'Marked completed.',
        'balance' => $bal,
        'used'    => $used,
    ]);
});

/**
 * 1) На Approved/Completed enrollment — проставляем студенту primary teacher/course
 */
add_action('tutor/course/enrol_status_change', 'e360_sync_primary_teacher_on_enrol', 10, 2);

function e360_sync_primary_teacher_on_enrol($enrol_id, $new_status) {
    $enrol_id = (int) $enrol_id;
    $status   = strtolower((string) $new_status);

    // Tutor может отдавать разные статусы в зависимости от версии/настроек
    if (!in_array($status, ['approved', 'completed', 'publish'], true)) {
        return;
    }

    $enrol = get_post($enrol_id);
    if (!$enrol || $enrol->post_type !== 'tutor_enrolled') {
        return;
    }

    $student_id = (int) $enrol->post_author; // студент
    $course_id  = (int) $enrol->post_parent; // курс
    if (!$student_id || !$course_id) {
        return;
    }

    // Prefer teacher selected during booking, if this teacher belongs to the course.
    $teacher_id = 0;
    $ctx = get_user_meta($student_id, 'e360_booking_context', true);
    if (is_array($ctx) && !empty($ctx)) {
        $ctx_course_id = (int)($ctx['course_id'] ?? 0);
        $ctx_teacher_id = (int)($ctx['teacher_id'] ?? 0);
        if ($ctx_course_id === $course_id && $ctx_teacher_id > 0) {
            $allowed_ids = function_exists('e360_get_course_instructor_ids')
                ? e360_get_course_instructor_ids($course_id)
                : [];
            if (in_array($ctx_teacher_id, $allowed_ids, true)) {
                $teacher_id = $ctx_teacher_id;
            }
        }
    }

    if (!$teacher_id) {
        $teacher_id = (int) get_post_field('post_author', $course_id);
    }
    if (!$teacher_id) {
        return;
    }

    // Enrollment is authoritative for this course.
    update_user_meta($student_id, 'e360_primary_course_id', $course_id);
    update_user_meta($student_id, 'e360_primary_teacher_id', $teacher_id);

    // Ensure chosen slot is reserved after enrollment.
    if (is_array($ctx) && !empty($ctx)) {
        $ctx['course_id'] = $course_id;
        $ctx['teacher_id'] = $teacher_id;
        if (function_exists('e360_create_bookings_from_context')) {
            e360_create_bookings_from_context($student_id, $ctx, ['require_credit' => false]);
        } elseif (function_exists('e360_find_booking_for_student_course') && function_exists('e360_create_booking_from_context')) {
            $exists = e360_find_booking_for_student_course($student_id, $course_id);
            if (!$exists) {
                e360_create_booking_from_context($student_id, $ctx, ['require_credit' => false]);
            }
        }
    }

   

    // (опционально) на всякий — храним “последнюю синхру”
    update_user_meta($student_id, 'e360_last_enrol_sync', current_time('mysql'));
}


if (!function_exists('e360_is_course_instructor')) {

function e360_is_course_instructor(int $user_id, int $course_id): bool {
    if (user_can($user_id, 'manage_options')) return true;

    if (function_exists('tutor_utils')) {
        $u = tutor_utils();
        if ($u && method_exists($u, 'is_instructor_of_this_course')) {
            try {
                return (bool) $u->is_instructor_of_this_course($user_id, $course_id);
            } catch (Throwable $e) {
                // фолбэк ниже
            }
        }
    }

    $author = (int) get_post_field('post_author', $course_id);
    return $author === $user_id;
}
}

/**
 * Достаём студентов по факту enrollment в Tutor LMS (post_type = tutor_enrolled).
 */
if (!function_exists('e360_get_course_enrolled_student_ids')) {

function e360_active_enrollment_statuses(): array {
    $statuses = ['approved', 'completed', 'publish'];
    $statuses = apply_filters('e360_active_enrollment_statuses', $statuses);
    if (!is_array($statuses)) $statuses = ['approved', 'completed', 'publish'];
    return array_values(array_unique(array_map('sanitize_key', $statuses)));
}

function e360_normalize_enrollment_status($raw): string {
    if ($raw === null || $raw === '') return '';
    $s = sanitize_key((string)$raw);
    if ($s === '') return '';
    // ignore pure numeric statuses: mapping varies by Tutor version/DB schema.
    if (preg_match('/^\d+$/', $s)) return '';

    if ($s === 'approve') return 'approved';
    if ($s === 'complete') return 'completed';
    if ($s === 'cancel') return 'cancelled';
    if ($s === 'canceled') return 'cancelled';
    if ($s === 'enrolled') return 'approved';
    if ($s === 'active') return 'approved';
    return $s;
}

function e360_get_active_student_ids_from_tutor_enrollments_table(int $course_id, int $limit = 500): array {
    global $wpdb;
    if ($course_id <= 0 || !isset($wpdb)) return [];

    $tables = [
        $wpdb->prefix . 'tutor_enrollments',
        $wpdb->prefix . 'tutor_enrolments',
    ];

    foreach ($tables as $table) {
        $exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table));
        if ($exists !== $table) continue;

        $cols = $wpdb->get_col("SHOW COLUMNS FROM `{$table}`", 0);
        if (!is_array($cols) || !$cols) continue;

        $uid_col = '';
        foreach (['user_id', 'student_id'] as $c) {
            if (in_array($c, $cols, true)) { $uid_col = $c; break; }
        }
        $course_col = '';
        foreach (['course_id', 'object_id'] as $c) {
            if (in_array($c, $cols, true)) { $course_col = $c; break; }
        }
        $status_col = '';
        foreach (['status', 'enrolment_status', 'enrollment_status'] as $c) {
            if (in_array($c, $cols, true)) { $status_col = $c; break; }
        }
        $id_col = '';
        foreach (['enrollment_id', 'enrolment_id', 'id'] as $c) {
            if (in_array($c, $cols, true)) { $id_col = $c; break; }
        }

        if ($uid_col === '' || $course_col === '') continue;

        if ($status_col !== '') {
            $order_sql = $id_col !== '' ? "ORDER BY `{$id_col}` DESC" : "";
            $rows = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT `{$uid_col}` AS uid, `{$status_col}` AS st FROM `{$table}` WHERE `{$course_col}` = %d {$order_sql}",
                    $course_id
                ),
                ARRAY_A
            );
            if (!is_array($rows)) $rows = [];

            $seen = [];
            $out = [];
            foreach ($rows as $r) {
                $sid = isset($r['uid']) ? (int)$r['uid'] : 0;
                if ($sid <= 0 || isset($seen[$sid])) continue;
                $seen[$sid] = true;

                $st = e360_normalize_enrollment_status($r['st'] ?? '');
                if (in_array($st, ['cancel', 'cancelled', 'canceled', 'rejected', 'trash'], true)) continue;
                if (!e360_is_enrolment_status_active($st)) continue;

                $out[] = $sid;
                if ($limit > 0 && count($out) >= $limit) break;
            }
            return array_values(array_unique(array_filter($out)));
        }

        // Table without explicit status: fallback to distinct users for course.
        $ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT `{$uid_col}` FROM `{$table}` WHERE `{$course_col}` = %d LIMIT %d",
                $course_id,
                max(1, (int)$limit)
            )
        );
        $ids = array_values(array_unique(array_map('intval', (array)$ids)));
        return array_values(array_filter($ids));
    }

    return [];
}

function e360_get_enrollment_status_value(int $enrol_id): string {
    if ($enrol_id <= 0) return '';

    $keys = [
        'enrol_status',
        'enrollment_status',
        '_enrol_status',
        '_enrollment_status',
        'tutor_enrol_status',
        'tutor_enrollment_status',
        '_tutor_enrol_status',
        '_tutor_enrollment_status',
        'status',
    ];

    foreach ($keys as $k) {
        $v = get_post_meta($enrol_id, $k, true);
        if (!is_scalar($v)) continue;
        $v = e360_normalize_enrollment_status($v);
        if ($v !== '') return $v;
    }

    // Fallback: inspect all enrollment meta values and pick known status token.
    $all = get_post_meta($enrol_id);
    if (is_array($all) && !empty($all)) {
        $known = [
            'approved', 'complete', 'completed', 'publish',
            'cancel', 'cancelled', 'canceled',
            'pending', 'hold', 'on_hold', 'rejected', 'trash',
        ];
        foreach ($all as $mv) {
            if (!is_array($mv)) $mv = [$mv];
            foreach ($mv as $one) {
                if (!is_scalar($one)) continue;
                $s = e360_normalize_enrollment_status($one);
                if ($s === '') continue;
                if (in_array($s, $known, true)) return $s;
            }
        }
    }

    // Do not fallback to post_status here: Tutor often keeps post published even when enrollment is cancelled.
    return '';
}

function e360_is_enrolment_status_active(string $status): bool {
    $status = e360_normalize_enrollment_status($status);
    if ($status === '') return false;
    if (in_array($status, ['cancel', 'cancelled', 'canceled', 'rejected', 'trash'], true)) return false;
    return in_array($status, e360_active_enrollment_statuses(), true);
}

function e360_extract_user_ids_from_mixed($raw): array {
    $out = [];

    $push = function($v) use (&$out) {
        if ($v > 0) $out[] = (int)$v;
    };

    if (is_numeric($raw)) {
        $push((int)$raw);
    } elseif (is_object($raw)) {
        if (isset($raw->ID)) $push((int)$raw->ID);
        if (isset($raw->user_id)) $push((int)$raw->user_id);
        if (isset($raw->id)) $push((int)$raw->id);
        if (isset($raw->items)) $out = array_merge($out, e360_extract_user_ids_from_mixed($raw->items));
        if (isset($raw->results)) $out = array_merge($out, e360_extract_user_ids_from_mixed($raw->results));
        if (isset($raw->data)) $out = array_merge($out, e360_extract_user_ids_from_mixed($raw->data));
    } elseif (is_array($raw)) {
        if (isset($raw['ID'])) $push((int)$raw['ID']);
        if (isset($raw['user_id'])) $push((int)$raw['user_id']);
        if (isset($raw['id'])) $push((int)$raw['id']);
        foreach ($raw as $v) {
            if (is_array($v) || is_object($v) || is_numeric($v)) {
                $out = array_merge($out, e360_extract_user_ids_from_mixed($v));
            }
        }
    }

    return array_values(array_unique(array_filter(array_map('intval', $out))));
}

function e360_get_active_enrolled_student_ids_for_course(int $course_id, int $limit = 500): array {
    if ($course_id <= 0 || !function_exists('tutor_utils')) return [];
    $u = tutor_utils();
    if (!is_object($u)) return [];

    $methods = [
        'get_enrolled_user_ids_by_course',
        'get_enrolled_students_by_course',
        'get_enrolled_users_by_course',
        'get_students_by_course',
        'get_enrolled_users',
    ];

    foreach ($methods as $m) {
        if (!method_exists($u, $m)) continue;
        try {
            $raw = $u->{$m}($course_id);
            $ids = e360_extract_user_ids_from_mixed($raw);
            if ($ids) {
                if ($limit > 0 && count($ids) > $limit) $ids = array_slice($ids, 0, $limit);
                return $ids;
            }
        } catch (\Throwable $e) {}
    }

    // Fallback for Tutor builds exposing only is_enrolled(course_id, student_id).
    if (method_exists($u, 'is_enrolled')) {
        $enrol_ids = get_posts([
            'post_type'      => 'tutor_enrolled',
            'post_status'    => 'any',
            'post_parent'    => $course_id,
            'fields'         => 'ids',
            'posts_per_page' => max(500, $limit),
        ]);

        $candidates = [];
        foreach ($enrol_ids as $eid) {
            $p = get_post((int)$eid);
            if ($p && (int)$p->post_author > 0) $candidates[] = (int)$p->post_author;
        }
        $candidates = array_values(array_unique(array_filter($candidates)));

        $active = [];
        foreach ($candidates as $sid) {
            try {
                $v = $u->is_enrolled($course_id, $sid);
                if ($v) $active[] = (int)$sid;
            } catch (\Throwable $e) {}
        }
        if ($active) {
            if ($limit > 0 && count($active) > $limit) $active = array_slice($active, 0, $limit);
            return array_values(array_unique($active));
        }
    }

    return [];
}

function e360_get_course_enrolled_student_ids(int $course_id, int $limit = 500): array {
    // Preferred: Tutor API active enrolled users.
    $active_ids = e360_get_active_enrolled_student_ids_for_course($course_id, $limit);
    if (!empty($active_ids)) return $active_ids;

    $enrol_ids = get_posts([
        'post_type'      => 'tutor_enrolled',
        'post_status'    => 'any',
        'post_parent'    => $course_id,
        'fields'         => 'ids',
        'posts_per_page' => $limit,
    ]);

    $student_ids = [];
    foreach ($enrol_ids as $eid) {
        $p = get_post((int) $eid);
        if ($p && (int) $p->post_author) {
            $student_ids[] = (int) $p->post_author;
        }
    }

    $student_ids = array_values(array_unique(array_filter($student_ids)));
    return $student_ids;
}
}
/**
 * Быстрая проверка: студент реально зачислен на курс?
 */
if (!function_exists('e360_is_student_enrolled_in_course')) {

function e360_is_student_enrolled_in_course(int $student_id, int $course_id): bool {
    if (function_exists('tutor_utils')) {
        $u = tutor_utils();
        if (is_object($u) && method_exists($u, 'is_enrolled')) {
            try {
                $v = $u->is_enrolled($course_id, $student_id);
                if ($v !== null) return (bool)$v;
            } catch (\Throwable $e) {}
        }
    }

    $active_ids = e360_get_active_enrolled_student_ids_for_course($course_id, 2000);
    if (!empty($active_ids)) return in_array((int)$student_id, $active_ids, true);

    $ids = get_posts([
        'post_type'      => 'tutor_enrolled',
        'post_status'    => 'any',
        'post_parent'    => $course_id,
        'author'         => $student_id, // author у tutor_enrolled = student user_id
        'fields'         => 'ids',
        'posts_per_page' => 1,
    ]);
    return !empty($ids);
}
}


/**
 * На странице урока внутри курса (/courses/.../lessons/<slug>/) у Tutor нет single-урока,
 * поэтому the_content не подходит. Выводим в футере и вставляем в DOM.
 */
function e360_detect_lesson_id_from_course_lesson_url(): int {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (!preg_match('~\/lessons\/([^\/\?\#]+)~', $uri, $m)) return 0;

    $slug = sanitize_title($m[1]);
    $p = get_page_by_path($slug, OBJECT, ['lesson','tutor_lesson','tutor_course_lesson','topic','tutor_topic']);
    return $p ? (int) $p->ID : 0;
}

add_action('wp_footer', function () {
    // именно шаблон курса
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    // только если это урл урока внутри курса
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/lessons/') === false) return;

    // teacher/admin
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    $teacher_id = get_current_user_id();
    $course_id  = (int) get_the_ID();
    if (!$course_id) return;

    // разрешаем и author, и instructor
    if (!e360_is_course_instructor($teacher_id, $course_id)) return;

    $lesson_id = e360_detect_lesson_id_from_course_lesson_url();
    if (!$lesson_id) return;

    $student_ids = e360_get_course_enrolled_student_ids($course_id);
    if (!$student_ids) return;

    $nonce = wp_create_nonce('e360_mark_lesson');
    $ajax  = admin_url('admin-ajax.php');

    ob_start(); ?>
<div id="e360-mark-lesson-box" data-lesson-id="<?php echo esc_attr($lesson_id); ?>"
    data-course-id="<?php echo esc_attr($course_id); ?>" data-ajax="<?php echo esc_attr($ajax); ?>"
    data-nonce="<?php echo esc_attr($nonce); ?>"
    style="display:none;margin:14px 0;padding:12px;border:1px solid #e5e5e5;border-radius:12px;">
    <div style="font-weight:700;margin-bottom:8px;">Teacher tools</div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
        <div style="min-width:240px;">
            <label style="display:block;font-size:13px;opacity:.8;margin-bottom:4px;">Student</label>
            <select id="e360-student-id" style="width:100%;max-width:360px;">
                <option value="">Select student…</option>
                <?php foreach ($student_ids as $sid): ?>
                <option value="<?php echo (int)$sid; ?>">
                    <?php echo esc_html(e360_student_public_label((int)$sid)); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" id="e360-mark-lesson-btn" class="tutor-btn tutor-btn-primary tutor-btn-sm">
            Mark lesson completed (spend 1 credit)
        </button>
    </div>

    <div id="e360-mark-lesson-msg" style="margin-top:10px;"></div>
</div>

<script>
(function() {
    // вставляем в Overview прямо над текстом урока
    var box = document.getElementById('e360-mark-lesson-box');
    if (!box) return;

    var target =
        document.querySelector('#tutor-course-spotlight-overview .tutor-lesson-wrapper') ||
        document.querySelector('.tutor-course-topic-single-body') ||
        document.querySelector('#tutor-single-entry-content');

    if (target) {
        box.style.display = 'block';
        target.insertBefore(box, target.firstChild);
    }

    // обработчик кнопки (без jQuery)
    function setMsg(html) {
        document.getElementById('e360-mark-lesson-msg').innerHTML = html;
    }

    document.getElementById('e360-mark-lesson-btn').addEventListener('click', function() {
        var studentId = parseInt(document.getElementById('e360-student-id').value, 10) || 0;
        if (!studentId) {
            setMsg('<span style="color:#b00;">Select a student first.</span>');
            return;
        }

        setMsg('<em>Saving…</em>');

        var ajaxurl = box.getAttribute('data-ajax');
        var nonce = box.getAttribute('data-nonce');
        var lessonId = parseInt(box.getAttribute('data-lesson-id'), 10) || 0;
        var courseId = parseInt(box.getAttribute('data-course-id'), 10) || 0;

        var fd = new FormData();
        fd.append('action', 'e360_mark_lesson_completed');
        fd.append('nonce', nonce);
        fd.append('lesson_id', lessonId);
        fd.append('course_id', courseId);
        fd.append('student_id', studentId);

        fetch(ajaxurl, {
                method: 'POST',
                credentials: 'same-origin',
                body: fd
            })
            .then(r => r.json())
            .then(resp => {
                if (!resp || !resp.success) {
                    var m = resp && resp.data && resp.data.message ? resp.data.message : 'Error';
                    setMsg('<span style="color:#b00;">' + m + '</span>');
                    return;
                }
                var d = resp.data || {};
                setMsg(
                    '<span style="color:#060;">Done.</span> ' +
                    'Remaining credits: <strong>' + (d.balance ?? '?') + '</strong>' +
                    (d.used !== undefined ? ' <span style="opacity:.7;">(completed: ' + d.used +
                        ')</span>' : '')
                );
            })
            .catch(() => setMsg('<span style="color:#b00;">Request failed.</span>'));
    });
})();
</script>
<?php
    echo ob_get_clean();
});



add_action('wp_footer', function () {
    if (!is_user_logged_in()) return;

    // только для студентов (не instructor/admin)
    if (current_user_can('tutor_instructor') || current_user_can('manage_options')) return;

    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/lessons/') === false) return;

    echo '<style>
        .tutor-topbar-complete-btn { display:none !important; }
    </style>';
});