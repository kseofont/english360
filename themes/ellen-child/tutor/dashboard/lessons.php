<?php
defined('ABSPATH') || exit;

if (!is_user_logged_in()) {
    return;
}

$user_id = get_current_user_id();
$session_id = isset($_GET['lesson_session']) ? (int) $_GET['lesson_session'] : 0;

if ($session_id > 0 && function_exists('e360_render_private_lesson_screen')) {
    echo e360_render_private_lesson_screen($session_id, $user_id);
    return;
}

if (current_user_can('tutor_instructor') || current_user_can('manage_options')) {
    if (function_exists('e360_render_lessons_dashboard_page')) {
        echo e360_render_lessons_dashboard_page($user_id);
    }
    return;
}

if (function_exists('e360_render_student_lessons_dashboard_page')) {
    echo e360_render_student_lessons_dashboard_page($user_id);
}
