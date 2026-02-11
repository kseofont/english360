<?php
defined('ABSPATH') || exit;

/**
 * Student UI:
 * - Course page (/courses/.../): show credits remaining + next lesson (from schedule events)
 * - Lesson page (/courses/.../lessons/.../): show credits remaining + next lesson in topbar
 *
 * Uses:
 *  - e360_get_credits_balance($student_id, $course_id)
 *  - e360_is_course_instructor($user_id, $course_id)
 *  - e360_is_student_enrolled_in_course($student_id, $course_id)  (fallback exists in your code)
 */

// -------- helpers --------

function e360_student_is_enrolled_safe(int $student_id, int $course_id): bool {
    if (function_exists('e360_is_student_enrolled_in_course')) {
        return (bool) e360_is_student_enrolled_in_course($student_id, $course_id);
    }

    // fallback via Tutor utils if available
    if (function_exists('tutor_utils')) {
        $u = tutor_utils();
        foreach (['is_enrolled', 'is_enrolled_course'] as $m) {
            if (is_object($u) && method_exists($u, $m)) {
                try { return (bool) $u->{$m}($course_id, $student_id); } catch (\Throwable $e) {}
            }
        }
    }

    return false;
}

function e360_student_next_lesson_ts(int $student_id, int $course_id): int {
    $key = 'e360_schedule_events_' . $course_id;
    $events = get_user_meta($student_id, $key, true);
    if (!is_array($events)) return 0;

    $now = current_time('timestamp');
    $future = [];
    foreach ($events as $ev) {
        $ts = isset($ev['ts']) ? (int) $ev['ts'] : 0;
        if ($ts && $ts >= $now) $future[] = $ts;
    }
    sort($future);
    return $future[0] ?? 0;
}

function e360_student_credit_balance(int $student_id, int $course_id): int {
    if (!function_exists('e360_get_credits_balance')) return 0;
    return (int) e360_get_credits_balance($student_id, $course_id);
}

// -------- 1) course page widget --------

add_action('wp_footer', function () {
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    // If URL contains /lessons/ we are on course lesson view (Tutor), not course overview
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/lessons/') !== false || strpos($uri, '/zoom-lessons/') !== false) return;

    $course_id  = (int) get_the_ID();
    $student_id = (int) get_current_user_id();
    if (!$course_id || !$student_id) return;

    // Don’t show to instructors here (they already have teacher widget)
    if (function_exists('e360_is_course_instructor') && e360_is_course_instructor($student_id, $course_id)) return;

    // Only enrolled students (or admins)
    if (!current_user_can('manage_options') && !e360_student_is_enrolled_safe($student_id, $course_id)) return;

    $bal = e360_student_credit_balance($student_id, $course_id);
    $next_ts = e360_student_next_lesson_ts($student_id, $course_id);
    $next_txt = $next_ts ? date_i18n('Y-m-d H:i', $next_ts) : '';

    ob_start(); ?>
<div id="e360-student-credits-box" style="margin-top:14px;">
    <div class="tutor-course-progress-wrapper tutor-mb-32">
        <h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">Your lessons</h3>

        <div style="display:flex;justify-content:space-between;gap:10px;border-top:1px solid #f0f0f0;padding-top:8px;">
            <div>Credits remaining</div>
            <div><strong><?php echo esc_html($bal); ?></strong></div>
        </div>

        <div style="display:flex;justify-content:space-between;gap:10px;border-top:1px solid #f0f0f0;padding-top:8px;">
            <div>Next lesson</div>
            <div style="opacity:.8;">
                <?php echo $next_txt ? esc_html($next_txt) : 'not scheduled'; ?>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var box = document.getElementById('e360-student-credits-box');
    if (!box) return;

    // Insert into Tutor sidebar card (where Course Progress + Start Learning)
    var sidebarCardBody =
        document.querySelector('.tutor-sidebar-card .tutor-card-body') ||
        document.querySelector('.courses-details-info .tutor-card-body') ||
        document.querySelector('.courses-details-info');

    if (sidebarCardBody) {
        sidebarCardBody.appendChild(box);
    }
})();
</script>
<?php
    echo ob_get_clean();
});

// -------- 2) lesson page topbar widget --------

add_action('wp_footer', function () {
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/lessons/') === false && strpos($uri, '/zoom-lessons/') === false) return;

    $course_id  = (int) get_the_ID();           // Tutor lesson view still uses course as main post
    $student_id = (int) get_current_user_id();
    if (!$course_id || !$student_id) return;

    // Don’t show to instructors here (they have teacher tools in topbar)
    if (function_exists('e360_is_course_instructor') && e360_is_course_instructor($student_id, $course_id)) return;

    if (!current_user_can('manage_options') && !e360_student_is_enrolled_safe($student_id, $course_id)) return;

    $bal = e360_student_credit_balance($student_id, $course_id);
    $next_ts = e360_student_next_lesson_ts($student_id, $course_id);
    $next_txt = $next_ts ? date_i18n('D, M j H:i', $next_ts) : '';

    ob_start(); ?>
<div id="e360-student-topbar-credits" style="display:none;">
    <div class="tutor-fs-7 tutor-color-secondary tutor-mr-20" style="white-space:nowrap;">
        Credits remaining: <strong><?php echo esc_html($bal); ?></strong>
        <?php if ($next_txt): ?>
        <span style="opacity:.75;"> · Next: <?php echo esc_html($next_txt); ?></span>
        <?php endif; ?>
    </div>
</div>

<script>
(function() {
    var box = document.getElementById('e360-student-topbar-credits');
    if (!box) return;

    // Student topbar right area (where "Your Progress" + Mark as Complete usually lives)
    var target =
        document.querySelector(
            '.tutor-course-topic-single-header .tutor-ml-auto.tutor-align-center.tutor-d-none.tutor-d-xl-flex') ||
        document.querySelector('.tutor-course-topic-single-header .tutor-ml-auto.tutor-align-center') ||
        document.querySelector('.tutor-course-topic-single-header');

    if (!target) return;

    box.style.display = 'block';
    target.insertBefore(box, target.firstChild);
})();
</script>
<?php
    echo ob_get_clean();
});