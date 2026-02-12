<?php
add_action('wp_footer', function () {
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    $course_id  = get_the_ID();
    $teacher_id = get_current_user_id();

    if (!e360_is_course_instructor($teacher_id, $course_id)) return;

    $student_ids = function_exists('e360_get_course_enrolled_student_ids')
        ? e360_get_course_enrolled_student_ids((int)$course_id, 500)
        : [];
    if ($student_ids && function_exists('e360_is_student_enrolled_in_course')) {
        $student_ids = array_values(array_filter($student_ids, function($sid) use ($course_id) {
            return e360_is_student_enrolled_in_course((int)$sid, (int)$course_id);
        }));
    }
    if (!$student_ids) return;

    ob_start();
    ?>
<div id="e360-course-teacher-box" style="margin-top:14px;">
    <div class="tutor-course-progress-wrapper tutor-mb-32">
        <h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">Your students (this course)</h3>

        <div style="display:flex;flex-direction:column;gap:10px;">
            <?php foreach ($student_ids as $sid):
                    $u = get_user_by('id', $sid);
                    if (!$u) continue;

                    // твои функции (если уже есть)
                   $bal  = function_exists('e360_get_credits_balance') ? (int)e360_get_credits_balance($sid, $course_id) : 0;
                    $used = function_exists('e360_get_credits_used') ? (int)e360_get_credits_used($sid, $course_id) : 0;


                    $first = (string) get_user_meta($sid, 'first_name', true);
                    $last  = (string) get_user_meta($sid, 'last_name', true);
                    $label = trim($first . ' ' . ($last ? mb_substr($last,0,1).'.' : ''));
                    if ($label === '') $label = $u->display_name;
                ?>
            <div
                style="display:flex;justify-content:space-between;gap:10px;border-top:1px solid #f0f0f0;padding-top:8px;">
                <div><?php echo esc_html($label); ?></div>
                <div><strong><?php echo esc_html($bal); ?></strong> remaining <span style="opacity:.7;">(completed:
                        <?php echo esc_html($used); ?>)</span></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<script>
(function() {
    // пытаемся вставить в Tutor sidebar card (туда, где Course Progress)
    var box = document.getElementById('e360-course-teacher-box');
    if (!box) return;

    var sidebarCardBody =
        document.querySelector('.tutor-sidebar-card .tutor-card-body') ||
        document.querySelector('.courses-details-info .tutor-card-body');

    if (sidebarCardBody) {
        sidebarCardBody.appendChild(box);
    }
})();
</script>
<?php
    echo ob_get_clean();
});


// AJAX: teacher adds schedule event to student for this course
add_action('wp_ajax_e360_teacher_add_schedule_event', function(){
    if (!is_user_logged_in()) wp_send_json_error(['message'=>'Not logged in'], 401);
    check_ajax_referer('e360_teacher_sidebar', 'nonce');

    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        wp_send_json_error(['message'=>'Forbidden'], 403);
    }

    $teacher_id = get_current_user_id();
    $course_id  = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
    $student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
    $dt         = isset($_POST['dt']) ? sanitize_text_field(wp_unslash($_POST['dt'])) : '';

    if (!$course_id || !$student_id || !$dt) wp_send_json_error(['message'=>'Missing data'], 400);

    // course owner check (or admin)
    if (!current_user_can('manage_options')) {
        $author = (int) get_post_field('post_author', $course_id);
        if ($author !== $teacher_id) wp_send_json_error(['message'=>'Not your course'], 403);
    }

    // student linked to this teacher/course
  if (!e360_is_course_instructor($teacher_id, $course_id)) {
    wp_send_json_error(['message'=>'Not your course'], 403);
}

if (!e360_is_student_enrolled_in_course($student_id, $course_id)) {
    wp_send_json_error(['message'=>'Student not enrolled in this course'], 403);
}


    // dt -> timestamp (local WP timezone)
    $ts = strtotime($dt);
    if (!$ts) wp_send_json_error(['message'=>'Invalid datetime'], 400);

    $key = 'e360_schedule_events_' . $course_id;
    $events = get_user_meta($student_id, $key, true);
    if (!is_array($events)) $events = [];

    $events[] = [
        'ts' => $ts,
        'by' => $teacher_id,
        'created_at' => current_time('mysql'),
    ];

    update_user_meta($student_id, $key, $events);

    wp_send_json_success(['ok'=>1]);
});
add_action('wp_footer', function () {
    if (!is_user_logged_in()) return;

    $teacher_id = get_current_user_id();
    if (!$teacher_id) return;

    $lesson_id = 0;
    $course_id = 0;

    // 1) Если это отдельный post типа lesson
    if (is_singular(['lesson','tutor_lesson','tutor_course_lesson'])) {
        $lesson_id = (int) get_the_ID();
        $course_id = function_exists('e360_get_course_id_by_lesson') ? (int) e360_get_course_id_by_lesson($lesson_id) : 0;
    }
    // 2) Если это courses URL вида /courses/.../lessons/...
    elseif (is_singular('courses')) {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($uri, '/lessons/') === false) return;

        $course_id = (int) get_the_ID();

        if (function_exists('e360_detect_lesson_id_from_course_lesson_url')) {
            $lesson_id = (int) e360_detect_lesson_id_from_course_lesson_url();
        }
    } else {
        return;
    }

    if (!$course_id || !$lesson_id) return;

    // teacher/admin check — НЕ current_user_can('tutor_instructor'), а твой helper
    if (!current_user_can('manage_options') && !e360_is_course_instructor($teacher_id, $course_id)) return;

    $student_ids = function_exists('e360_get_course_enrolled_student_ids')
        ? e360_get_course_enrolled_student_ids($course_id)
        : [];

    if (!$student_ids) return;

    // total lessons in course (topics -> lessons)
    $topic_ids = get_posts([
        'post_type'      => ['topic','tutor_topic','topics'],
        'post_parent'    => $course_id,
        'fields'         => 'ids',
        'posts_per_page' => -1,
    ]);

    $lesson_ids = [];
    if ($topic_ids) {
        $lesson_ids = get_posts([
            'post_type'      => ['lesson','tutor_lesson','tutor_course_lesson'],
            'post_parent__in'=> $topic_ids,
            'fields'         => 'ids',
            'posts_per_page' => -1,
        ]);
    }
    $total_lessons = is_array($lesson_ids) ? count($lesson_ids) : 0;

    $nonce = wp_create_nonce('e360_mark_lesson');
    $ajax  = admin_url('admin-ajax.php');
    ?>
<div id="e360-teacher-topbar-tools" data-lesson-id="<?php echo esc_attr($lesson_id); ?>"
    data-course-id="<?php echo esc_attr($course_id); ?>" data-total="<?php echo esc_attr($total_lessons); ?>"
    data-ajax="<?php echo esc_attr($ajax); ?>" data-nonce="<?php echo esc_attr($nonce); ?>" style="display:none;">
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <select id="e360-topbar-student-id" class="tutor-form-select tutor-ws-nowrap" style="min-width:220px;">
            <option value="">Student…</option>
            <?php foreach ($student_ids as $sid):
                    $sid = (int)$sid;
                    $used = function_exists('e360_get_credits_used') ? (int)e360_get_credits_used($sid, $course_id) : 0;
                    $bal  = function_exists('e360_get_credits_balance') ? (int)e360_get_credits_balance($sid, $course_id) : 0;
                ?>
            <option value="<?php echo $sid; ?>" data-used="<?php echo esc_attr($used); ?>"
                data-balance="<?php echo esc_attr($bal); ?>">
                <?php echo esc_html(e360_student_public_label($sid)); ?>
            </option>
            <?php endforeach; ?>
        </select>

        <button type="button" id="e360-topbar-mark-lesson-btn"
            class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-ws-nowrap">
            Mark lesson complete (teacher)
        </button>

        <span id="e360-teacher-topbar-msg" class="tutor-fs-7 tutor-color-secondary"></span>
    </div>
</div>

<script>
(function() {
    var box = document.getElementById('e360-teacher-topbar-tools');
    if (!box) return;

    // Найдём ВИДИМЫЙ правый блок в топбаре
    var candidates = document.querySelectorAll(
        '.tutor-course-topic-single-header .tutor-ml-auto.tutor-align-center');
    var target = null;

    for (var i = 0; i < candidates.length; i++) {
        if (candidates[i].offsetParent !== null) {
            target = candidates[i];
            break;
        }
    }
    // fallback: просто в header
    if (!target) target = document.querySelector('.tutor-course-topic-single-header');
    if (!target) return;

    box.style.display = 'block';
    target.insertBefore(box, target.firstChild);

    var sel = document.getElementById('e360-topbar-student-id');
    var btn = document.getElementById('e360-topbar-mark-lesson-btn');
    var msgEl = document.getElementById('e360-teacher-topbar-msg');

    var total = parseInt(box.getAttribute('data-total'), 10) || 0;

    function setMsg(html) {
        msgEl.innerHTML = html;
    }

    function renderProgress() {
        var opt = sel.options[sel.selectedIndex];
        if (!opt || !opt.value) {
            setMsg('');
            return;
        }

        var used = parseInt(opt.dataset.used || '0', 10) || 0;
        var bal = parseInt(opt.dataset.balance || '0', 10) || 0;

        var pct = total ? Math.round((used / total) * 100) : 0;

        setMsg(
            'Progress: <strong>' + used + '</strong>/' + (total || '?') +
            ' (' + pct + '%) · Credits remaining: <strong>' + bal + '</strong>'
        );
    }

    sel.addEventListener('change', renderProgress);
    renderProgress();

    btn.addEventListener('click', function() {
        var studentId = parseInt(sel.value, 10) || 0;
        if (!studentId) {
            setMsg('<span style="color:#b00;">Select student</span>');
            return;
        }

        setMsg('Saving…');

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

                // обновим данные в option (used/balance) из ответа
                var opt = sel.options[sel.selectedIndex];
                if (opt && opt.value) {
                    if (resp.data && resp.data.used !== undefined) opt.dataset.used = resp.data.used;
                    if (resp.data && resp.data.balance !== undefined) opt.dataset.balance = resp.data
                        .balance;
                }
                renderProgress();
            })
            .catch(() => setMsg('<span style="color:#b00;">Request failed</span>'));
    });
})();
</script>
<?php
});