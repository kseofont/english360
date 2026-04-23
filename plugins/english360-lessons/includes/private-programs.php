<?php
defined('ABSPATH') || exit;

function e360_program_post_type(): string {
    return 'e360_program';
}

function e360_lesson_session_post_type(): string {
    return 'e360_lesson_session';
}

function e360_get_program_statuses(): array {
    return [
        'active'    => 'Active',
        'paused'    => 'Paused',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
}

function e360_get_lesson_session_statuses(): array {
    return [
        'scheduled'   => 'Scheduled',
        'completed'   => 'Completed',
        'cancelled'   => 'Cancelled',
        'missed'      => 'Missed',
        'rescheduled' => 'Rescheduled',
    ];
}

function e360_private_learning_teacher_is_approved(int $teacher_id): bool {
    if ($teacher_id <= 0) {
        return false;
    }

    if (user_can($teacher_id, 'manage_options')) {
        return true;
    }

    if (function_exists('e360_teacher_is_bookable_for_wizard')) {
        return (bool) e360_teacher_is_bookable_for_wizard($teacher_id);
    }

    $status = sanitize_key((string) get_user_meta($teacher_id, '_tutor_instructor_status', true));
    if ($status !== '') {
        return $status === 'approved';
    }

    return user_can($teacher_id, 'tutor_instructor') ? false : true;
}

function e360_private_learning_teacher_belongs_to_course(int $teacher_id, int $course_id): bool {
    if ($teacher_id <= 0 || $course_id <= 0) {
        return false;
    }

    if (user_can($teacher_id, 'manage_options')) {
        return true;
    }

    if (function_exists('e360_get_course_instructor_ids')) {
        $ids = array_map('intval', (array) e360_get_course_instructor_ids($course_id));
        if (in_array($teacher_id, $ids, true)) {
            return true;
        }
    }

    if (function_exists('e360_is_course_instructor')) {
        return (bool) e360_is_course_instructor($teacher_id, $course_id);
    }

    return ((int) get_post_field('post_author', $course_id)) === $teacher_id;
}

function e360_private_learning_can_assign_teacher(int $teacher_id, int $course_id): bool {
    return e360_private_learning_teacher_is_approved($teacher_id)
        && e360_private_learning_teacher_belongs_to_course($teacher_id, $course_id);
}

function e360_private_learning_course_has_approved_teacher(int $course_id): bool {
    if ($course_id <= 0) {
        return false;
    }

    if (function_exists('e360_get_course_instructor_ids')) {
        foreach ((array) e360_get_course_instructor_ids($course_id) as $teacher_id) {
            if (e360_private_learning_can_assign_teacher((int) $teacher_id, $course_id)) {
                return true;
            }
        }
    }

    $author_id = (int) get_post_field('post_author', $course_id);
    return $author_id > 0 && e360_private_learning_can_assign_teacher($author_id, $course_id);
}

function e360_get_student_program_teacher_course_map(int $student_id): array {
    if ($student_id <= 0 || !function_exists('e360_get_user_programs')) {
        return [];
    }

    $programs = e360_get_user_programs('student_id', $student_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => -1,
    ]);

    $map = [];
    foreach ((array) $programs as $program) {
        $teacher_id = (int) ($program['teacher_id'] ?? 0);
        $course_id = (int) ($program['course_id'] ?? 0);
        if ($teacher_id <= 0 || $course_id <= 0) {
            continue;
        }
        if (!isset($map[$teacher_id])) {
            $map[$teacher_id] = [];
        }
        $map[$teacher_id][$course_id] = true;
    }

    return $map;
}

function e360_override_tutor_scheduling_available_teachers_ajax(): void {
    if (!is_user_logged_in()) {
        return;
    }

    if (current_user_can('tutor_instructor') || current_user_can('manage_options')) {
        return;
    }

    if (!isset($_POST['action']) || wp_unslash($_POST['action']) !== 'tutor_scheduling_get_available_teachers') {
        return;
    }

    check_ajax_referer('tutor_scheduling_nonce', 'nonce');

    $date = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $course_id = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;
    $student_id = get_current_user_id();

    if ($date === '') {
        wp_send_json_error(['message' => 'Date is required'], 400);
    }

    if (!class_exists('Tutor_Scheduling_Availability')) {
        wp_send_json_success(['teachers' => []]);
    }

    $allowed_map = e360_get_student_program_teacher_course_map($student_id);
    if (!$allowed_map) {
        wp_send_json_success(['teachers' => []]);
    }

    global $wpdb;
    $availability_table = $wpdb->prefix . 'tutor_teacher_availability';
    $day_of_week = (int) date('w', strtotime($date));
    $teachers = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT DISTINCT teacher_id FROM {$availability_table} WHERE day_of_week = %d AND is_available = 1",
            $day_of_week
        )
    );

    $availability = new Tutor_Scheduling_Availability();
    $teacher_list = [];

    foreach ((array) $teachers as $teacher_row) {
        $teacher_id = (int) ($teacher_row->teacher_id ?? 0);
        if ($teacher_id <= 0 || !isset($allowed_map[$teacher_id])) {
            continue;
        }

        $teacher = get_userdata($teacher_id);
        $is_allowed_teacher = $teacher && (
            user_can($teacher_id, 'manage_options')
            || (function_exists('tutor_utils') && tutor_utils()->is_instructor($teacher_id))
        );
        if (!$teacher || !$is_allowed_teacher) {
            continue;
        }

        $slots = function_exists('e360_generate_slots_for_teacher_date')
            ? (array) e360_generate_slots_for_teacher_date($teacher_id, $date, 60, false)
            : [];

        if (!$slots) {
            $slots = (array) $availability->get_available_slots($teacher_id, $date, 60);
        }
        if (empty($slots)) {
            continue;
        }

        if ($course_id > 0) {
            if (empty($allowed_map[$teacher_id][$course_id])) {
                continue;
            }

            $teacher_list[] = [
                'id'    => $teacher_id,
                'name'  => $teacher->display_name,
                'slots' => $slots,
            ];
            continue;
        }

        $courses = [];
        foreach (array_keys($allowed_map[$teacher_id]) as $allowed_course_id) {
            $course = get_post((int) $allowed_course_id);
            if ($course && $course->post_status === 'publish') {
                $courses[] = [
                    'id'    => (int) $course->ID,
                    'title' => (string) $course->post_title,
                ];
            }
        }

        if (!$courses) {
            continue;
        }

        $teacher_list[] = [
            'id'      => $teacher_id,
            'name'    => $teacher->display_name,
            'slots'   => $slots,
            'courses' => $courses,
        ];
    }

    wp_send_json_success(['teachers' => $teacher_list]);
}
add_action('wp_ajax_tutor_scheduling_get_available_teachers', 'e360_override_tutor_scheduling_available_teachers_ajax', 1);

function e360_get_program_meta_schema(): array {
    return [
        'student_id'       => ['type' => 'integer', 'default' => 0],
        'teacher_id'       => ['type' => 'integer', 'default' => 0],
        'course_id'        => ['type' => 'integer', 'default' => 0],
        'language_term_id' => ['type' => 'integer', 'default' => 0],
        'level_term_id'    => ['type' => 'integer', 'default' => 0],
        'plan_product_id'  => ['type' => 'integer', 'default' => 0],
        'order_id'         => ['type' => 'integer', 'default' => 0],
        'booking_format'   => ['type' => 'string',  'default' => ''],
        'status'           => ['type' => 'string',  'default' => 'active'],
        'total_credits'    => ['type' => 'integer', 'default' => 0],
        'used_credits'     => ['type' => 'integer', 'default' => 0],
        'remaining_credits'=> ['type' => 'integer', 'default' => 0],
        'start_date'       => ['type' => 'string',  'default' => ''],
        'end_date'         => ['type' => 'string',  'default' => ''],
        'timezone'         => ['type' => 'string',  'default' => ''],
        'price_paid'       => ['type' => 'number',  'default' => 0],
        'teacher_rate'     => ['type' => 'number',  'default' => 0],
        'currency'         => ['type' => 'string',  'default' => ''],
        'notes'            => ['type' => 'string',  'default' => ''],
    ];
}

function e360_get_lesson_session_meta_schema(): array {
    return [
        'program_id'           => ['type' => 'integer', 'default' => 0],
        'student_id'           => ['type' => 'integer', 'default' => 0],
        'teacher_id'           => ['type' => 'integer', 'default' => 0],
        'course_id'            => ['type' => 'integer', 'default' => 0],
        'order_id'             => ['type' => 'integer', 'default' => 0],
        'lesson_date'          => ['type' => 'string',  'default' => ''],
        'lesson_time'          => ['type' => 'string',  'default' => ''],
        'duration'             => ['type' => 'integer', 'default' => 60],
        'repeat_type'          => ['type' => 'string',  'default' => 'once'],
        'session_status'       => ['type' => 'string',  'default' => 'scheduled'],
        'zoom_meeting_id'      => ['type' => 'string',  'default' => ''],
        'zoom_start_url'       => ['type' => 'string',  'default' => ''],
        'zoom_join_url'        => ['type' => 'string',  'default' => ''],
        'zoom_host_id'         => ['type' => 'string',  'default' => ''],
        'zoom_sync_error'      => ['type' => 'string',  'default' => ''],
        'attendance_student'   => ['type' => 'string',  'default' => ''],
        'attendance_teacher'   => ['type' => 'string',  'default' => ''],
        'collab_notes_thread'  => ['type' => 'string',  'default' => ''],
        'session_notes'        => ['type' => 'string',  'default' => ''],
        'homework'             => ['type' => 'string',  'default' => ''],
        'student_session_notes'=> ['type' => 'string',  'default' => ''],
        'student_homework'     => ['type' => 'string',  'default' => ''],
        'teacher_earning'      => ['type' => 'number',  'default' => 0],
        'platform_earning'     => ['type' => 'number',  'default' => 0],
        'source_booking_id'    => ['type' => 'integer', 'default' => 0],
        'source_enrollment_id' => ['type' => 'integer', 'default' => 0],
    ];
}

function e360_register_private_learning_post_types(): void {
    register_post_type(e360_program_post_type(), [
        'labels' => [
            'name'               => 'Student Programs',
            'singular_name'      => 'Student Program',
            'add_new_item'       => 'Add Student Program',
            'edit_item'          => 'Edit Student Program',
            'new_item'           => 'New Student Program',
            'view_item'          => 'View Student Program',
            'search_items'       => 'Search Student Programs',
            'not_found'          => 'No student programs found',
            'not_found_in_trash' => 'No student programs found in Trash',
            'menu_name'          => 'Student Programs',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_admin_bar'  => false,
        'show_in_nav_menus'  => false,
        'exclude_from_search'=> true,
        'publicly_queryable' => false,
        'has_archive'        => false,
        'rewrite'            => false,
        'supports'           => ['title'],
        'map_meta_cap'       => true,
    ]);

    register_post_type(e360_lesson_session_post_type(), [
        'labels' => [
            'name'               => 'Private Lessons',
            'singular_name'      => 'Private Lesson',
            'add_new_item'       => 'Add Private Lesson',
            'edit_item'          => 'Edit Private Lesson',
            'new_item'           => 'New Private Lesson',
            'view_item'          => 'View Private Lesson',
            'search_items'       => 'Search Private Lessons',
            'not_found'          => 'No private lessons found',
            'not_found_in_trash' => 'No private lessons found in Trash',
            'menu_name'          => 'Private Lessons',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_admin_bar'  => false,
        'show_in_nav_menus'  => false,
        'exclude_from_search'=> true,
        'publicly_queryable' => false,
        'has_archive'        => false,
        'rewrite'            => false,
        'supports'           => ['title'],
        'map_meta_cap'       => true,
    ]);
}
add_action('init', 'e360_register_private_learning_post_types');

function e360_register_private_learning_admin_menu(): void {
    add_submenu_page(
        'tutor',
        'Student Programs',
        'Student Programs',
        'manage_options',
        'edit.php?post_type=' . e360_program_post_type()
    );

    add_submenu_page(
        'tutor',
        'Private Lessons',
        'Private Lessons',
        'manage_options',
        'edit.php?post_type=' . e360_lesson_session_post_type()
    );

    add_submenu_page(
        'tutor',
        'Private Reports',
        'Private Reports',
        'manage_options',
        'e360-private-reports',
        'e360_render_private_reports_page'
    );

    add_submenu_page(
        'tutor',
        'Private Migration',
        'Private Migration',
        'manage_options',
        'e360-private-migration',
        'e360_render_private_migration_page'
    );
}
add_action('admin_menu', 'e360_register_private_learning_admin_menu', 40);

function e360_hide_unused_ellen_cpt_menus(): void {
    remove_menu_page('edit.php?post_type=program');
    remove_menu_page('edit.php?post_type=success-stories');
}
add_action('admin_menu', 'e360_hide_unused_ellen_cpt_menus', 999);

function e360_private_learning_admin_parent_file(string $parent_file): string {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen) {
        return $parent_file;
    }

    if (in_array($screen->post_type, [e360_program_post_type(), e360_lesson_session_post_type()], true)) {
        return 'tutor';
    }

    return $parent_file;
}
add_filter('parent_file', 'e360_private_learning_admin_parent_file');

function e360_private_learning_admin_submenu_file(?string $submenu_file): ?string {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen) {
        if (isset($_GET['page']) && sanitize_key((string) $_GET['page']) === 'e360-private-reports') {
            return 'e360-private-reports';
        }
        if (isset($_GET['page']) && sanitize_key((string) $_GET['page']) === 'e360-private-migration') {
            return 'e360-private-migration';
        }
        return $submenu_file;
    }

    if ($screen->post_type === e360_program_post_type()) {
        return 'edit.php?post_type=' . e360_program_post_type();
    }

    if ($screen->post_type === e360_lesson_session_post_type()) {
        return 'edit.php?post_type=' . e360_lesson_session_post_type();
    }

    if ($screen->base === 'tutor_page_e360-private-reports') {
        return 'e360-private-reports';
    }

    if ($screen->base === 'tutor_page_e360-private-migration') {
        return 'e360-private-migration';
    }

    return $submenu_file;
}
add_filter('submenu_file', 'e360_private_learning_admin_submenu_file');

function e360_register_private_learning_meta(): void {
    foreach (e360_get_program_meta_schema() as $meta_key => $args) {
        register_post_meta(e360_program_post_type(), $meta_key, [
            'type'          => $args['type'],
            'single'        => true,
            'default'       => $args['default'],
            'show_in_rest'  => false,
            'auth_callback' => static function() {
                return current_user_can('manage_options');
            },
        ]);
    }

    foreach (e360_get_lesson_session_meta_schema() as $meta_key => $args) {
        register_post_meta(e360_lesson_session_post_type(), $meta_key, [
            'type'          => $args['type'],
            'single'        => true,
            'default'       => $args['default'],
            'show_in_rest'  => false,
            'auth_callback' => static function() {
                return current_user_can('manage_options');
            },
        ]);
    }
}
add_action('init', 'e360_register_private_learning_meta');

function e360_normalize_program_data(array $data): array {
    $out = [];
    foreach (e360_get_program_meta_schema() as $key => $schema) {
        $value = $data[$key] ?? $schema['default'];
        if ($schema['type'] === 'integer') {
            $out[$key] = (int) $value;
        } elseif ($schema['type'] === 'number') {
            $out[$key] = (float) $value;
        } else {
            $out[$key] = sanitize_textarea_field((string) $value);
        }
    }

    if (!isset(e360_get_program_statuses()[$out['status']])) {
        $out['status'] = 'active';
    }

    return $out;
}

function e360_normalize_lesson_session_data(array $data): array {
    $out = [];
    foreach (e360_get_lesson_session_meta_schema() as $key => $schema) {
        $value = $data[$key] ?? $schema['default'];
        if ($schema['type'] === 'integer') {
            $out[$key] = (int) $value;
        } elseif ($schema['type'] === 'number') {
            $out[$key] = (float) $value;
        } else {
            $out[$key] = sanitize_textarea_field((string) $value);
        }
    }

    if (!isset(e360_get_lesson_session_statuses()[$out['session_status']])) {
        $out['session_status'] = 'scheduled';
    }

    return $out;
}

function e360_program_build_title(array $data): string {
    $student = !empty($data['student_id']) ? get_user_by('id', (int) $data['student_id']) : null;
    $teacher = !empty($data['teacher_id']) ? get_user_by('id', (int) $data['teacher_id']) : null;
    $course  = !empty($data['course_id']) ? get_the_title((int) $data['course_id']) : '';

    $parts = array_filter([
        $student ? $student->display_name : '',
        $teacher ? $teacher->display_name : '',
        $course,
    ]);

    return $parts ? implode(' / ', $parts) : 'Program';
}

function e360_lesson_session_build_title(array $data): string {
    $student = !empty($data['student_id']) ? get_user_by('id', (int) $data['student_id']) : null;
    $date    = trim((string) ($data['lesson_date'] ?? ''));
    $time    = trim((string) ($data['lesson_time'] ?? ''));

    $parts = array_filter([
        $student ? $student->display_name : '',
        trim($date . ' ' . $time),
    ]);

    return $parts ? implode(' / ', $parts) : 'Lesson Session';
}

function e360_get_program(int $program_id): array {
    $post = get_post($program_id);
    if (!$post || $post->post_type !== e360_program_post_type()) {
        return [];
    }

    $data = ['ID' => $program_id];
    foreach (e360_get_program_meta_schema() as $key => $schema) {
        $data[$key] = get_post_meta($program_id, $key, true);
    }

    $normalized = e360_normalize_program_data($data);
    $normalized['ID'] = $program_id;
    return $normalized;
}

function e360_get_lesson_session(int $session_id): array {
    $post = get_post($session_id);
    if (!$post || $post->post_type !== e360_lesson_session_post_type()) {
        return [];
    }

    $data = ['ID' => $session_id];
    foreach (e360_get_lesson_session_meta_schema() as $key => $schema) {
        $data[$key] = get_post_meta($session_id, $key, true);
    }

    $normalized = e360_normalize_lesson_session_data($data);
    $normalized['ID'] = $session_id;
    return $normalized;
}

function e360_save_program(array $data, int $program_id = 0) {
    $data = e360_normalize_program_data($data);

    $postarr = [
        'post_type'   => e360_program_post_type(),
        'post_status' => 'publish',
        'post_title'  => e360_program_build_title($data),
    ];

    if ($program_id > 0) {
        $postarr['ID'] = $program_id;
        $program_id = wp_update_post($postarr, true);
    } else {
        $program_id = wp_insert_post($postarr, true);
    }

    if (is_wp_error($program_id)) {
        return $program_id;
    }

    foreach ($data as $key => $value) {
        if (!array_key_exists($key, e360_get_program_meta_schema())) {
            continue;
        }
        update_post_meta($program_id, $key, $value);
    }

    return (int) $program_id;
}

function e360_upsert_program(array $data, int $program_id = 0): int {
    $data = e360_normalize_program_data($data);
    $student_id = (int) ($data['student_id'] ?? 0);
    $course_id  = (int) ($data['course_id'] ?? 0);
    $teacher_id = (int) ($data['teacher_id'] ?? 0);

    if ($student_id <= 0 || $course_id <= 0 || $teacher_id <= 0) {
        return 0;
    }

    if (!e360_private_learning_course_has_approved_teacher($course_id)) {
        return 0;
    }

    if (!e360_private_learning_can_assign_teacher($teacher_id, $course_id)) {
        return 0;
    }

    if ($program_id <= 0) {
        $program_id = e360_find_program_id($student_id, $course_id, $teacher_id, ['active', 'paused', 'completed']);
    }

    $saved = e360_save_program($data, $program_id);
    if (is_wp_error($saved) || $saved <= 0) {
        return 0;
    }

    return (int) $saved;
}

function e360_save_lesson_session(array $data, int $session_id = 0) {
    $data = e360_normalize_lesson_session_data($data);
    $previous = $session_id > 0 ? e360_get_lesson_session($session_id) : [];

    $postarr = [
        'post_type'   => e360_lesson_session_post_type(),
        'post_status' => 'publish',
        'post_title'  => e360_lesson_session_build_title($data),
    ];

    if ($session_id > 0) {
        $postarr['ID'] = $session_id;
        $session_id = wp_update_post($postarr, true);
    } else {
        $session_id = wp_insert_post($postarr, true);
    }

    if (is_wp_error($session_id)) {
        return $session_id;
    }

    foreach ($data as $key => $value) {
        if (!array_key_exists($key, e360_get_lesson_session_meta_schema())) {
            continue;
        }
        update_post_meta($session_id, $key, $value);
    }

    do_action('e360_lesson_session_saved', (int) $session_id, $data, $previous);

    return (int) $session_id;
}

function e360_get_lesson_session_credit_lock(int $session_id): string {
    return 'session:' . max(0, $session_id);
}

function e360_get_lesson_session_credit_cost(array $session): int {
    $duration = (int) ($session['duration'] ?? 60);
    return $duration > 0 ? 1 : 1;
}

function e360_get_credit_adjustment_for_session_status_change(string $from_status, string $to_status): int {
    $credit_statuses = ['completed'];
    $from_uses_credit = in_array($from_status, $credit_statuses, true);
    $to_uses_credit   = in_array($to_status, $credit_statuses, true);

    if ($from_uses_credit === $to_uses_credit) {
        return 0;
    }

    return $to_uses_credit ? 1 : -1;
}

function e360_apply_lesson_session_credit_effect(array $session, string $from_status, string $to_status): bool {
    $student_id = (int) ($session['student_id'] ?? 0);
    $course_id  = (int) ($session['course_id'] ?? 0);
    $session_id = (int) ($session['ID'] ?? 0);
    if ($student_id <= 0 || $course_id <= 0 || $session_id <= 0) {
        return false;
    }

    $direction = e360_get_credit_adjustment_for_session_status_change($from_status, $to_status);
    if ($direction === 0) {
        return true;
    }

    $qty = e360_get_lesson_session_credit_cost($session);
    $lock = e360_get_lesson_session_credit_lock($session_id);

    if ($direction > 0) {
        if (!function_exists('e360_spend_credits')) {
            return false;
        }
        return e360_spend_credits($student_id, $course_id, $qty, $lock);
    }

    if (!function_exists('e360_restore_credits')) {
        return false;
    }

    return e360_restore_credits($student_id, $course_id, $qty, $lock);
}

function e360_refresh_program_from_sessions(int $program_id): void {
    if ($program_id <= 0) {
        return;
    }

    $program = e360_get_program($program_id);
    if (!$program) {
        return;
    }

    e360_sync_program_credit_totals($program_id);

    $summary = e360_get_program_summary($program_id);
    $remaining = (int) get_post_meta($program_id, 'remaining_credits', true);
    $current_status = (string) ($program['status'] ?? 'active');

    if ($current_status === 'cancelled') {
        return;
    }

    if ($remaining <= 0 && (int) ($summary['scheduled_count'] ?? 0) === 0 && (int) ($summary['completed_count'] ?? 0) > 0) {
        $program['status'] = 'completed';
        e360_save_program($program, $program_id);
        return;
    }

    if ($current_status === 'completed' && $remaining > 0) {
        $program['status'] = 'active';
        e360_save_program($program, $program_id);
    }
}

function e360_handle_lesson_session_saved(int $session_id, array $session, array $previous = []): void {
    static $running = [];

    if ($session_id <= 0 || isset($running[$session_id])) {
        return;
    }

    $running[$session_id] = true;

    try {
        $from_status = (string) ($previous['session_status'] ?? '');
        if ($from_status === '') {
            $from_status = 'scheduled';
        }
        $to_status = (string) ($session['session_status'] ?? 'scheduled');

        if (!e360_apply_lesson_session_credit_effect(array_merge($session, ['ID' => $session_id]), $from_status, $to_status)) {
            if ($to_status === 'completed' && $from_status !== 'completed') {
                $session['session_status'] = $from_status;
                e360_save_lesson_session($session, $session_id);
                return;
            }
        }

        $program_id = (int) ($session['program_id'] ?? 0);
        if ($program_id > 0) {
            e360_refresh_program_from_sessions($program_id);
        }
    } finally {
        unset($running[$session_id]);
    }
}
add_action('e360_lesson_session_saved', 'e360_handle_lesson_session_saved', 10, 3);

function e360_update_lesson_session_status(int $session_id, string $new_status, array $changes = []): bool {
    $session = e360_get_lesson_session($session_id);
    if (!$session) {
        return false;
    }

    $new_status = sanitize_key($new_status);
    if (!isset(e360_get_lesson_session_statuses()[$new_status])) {
        return false;
    }

    $changes['session_status'] = $new_status;
    $updated = array_merge($session, $changes);
    $saved = e360_save_lesson_session($updated, $session_id);

    return !is_wp_error($saved) && (int) $saved > 0;
}

function e360_find_matching_program_session(int $student_id, int $course_id, int $teacher_id): int {
    $program_id = e360_find_program_id($student_id, $course_id, $teacher_id, ['active', 'paused', 'completed']);
    if ($program_id <= 0) {
        return 0;
    }

    $sessions = e360_get_program_sessions($program_id, [
        'statuses' => ['scheduled', 'rescheduled'],
        'orderby'  => 'lesson_date',
        'order'    => 'ASC',
        'limit'    => -1,
    ]);
    if (!$sessions) {
        return 0;
    }

    $now = current_time('timestamp');
    $best_id = 0;
    $best_distance = null;

    foreach ($sessions as $session) {
        $date = trim((string) ($session['lesson_date'] ?? ''));
        $time = trim((string) ($session['lesson_time'] ?? '00:00'));
        if ($date === '') {
            continue;
        }

        $stamp = strtotime($date . ' ' . $time);
        if ($stamp === false) {
            $stamp = strtotime($date . ' 00:00');
        }
        if ($stamp === false) {
            continue;
        }

        $distance = abs($stamp - $now);
        if ($best_distance === null || $distance < $best_distance) {
            $best_distance = $distance;
            $best_id = (int) ($session['ID'] ?? 0);
        }
    }

    if ($best_id > 0) {
        return $best_id;
    }

    return (int) ($sessions[0]['ID'] ?? 0);
}

function e360_mark_matching_program_session_completed(int $student_id, int $course_id, int $teacher_id, int $lesson_id = 0): int {
    if ($student_id <= 0 || $course_id <= 0 || $teacher_id <= 0) {
        return 0;
    }

    $session_id = e360_find_matching_program_session($student_id, $course_id, $teacher_id);
    if ($session_id <= 0) {
        return 0;
    }

    $changes = [];
    if ($lesson_id > 0) {
        $changes['session_notes'] = trim((string) get_post_meta($session_id, 'session_notes', true));
    }

    if (!e360_update_lesson_session_status($session_id, 'completed', $changes)) {
        return 0;
    }

    return $session_id;
}

function e360_get_user_zoom_api_credentials(int $user_id): array {
    if ($user_id <= 0) {
        return [];
    }

    $raw = get_user_meta($user_id, 'tutor_zoom_api', true);
    if (is_string($raw)) {
        $raw = json_decode($raw, true);
    }
    if (!is_array($raw)) {
        return [];
    }

    $account_id = sanitize_text_field((string) ($raw['account_id'] ?? ''));
    $api_key    = sanitize_text_field((string) ($raw['api_key'] ?? ''));
    $api_secret = sanitize_text_field((string) ($raw['api_secret'] ?? ''));

    if ($account_id === '' || $api_key === '' || $api_secret === '') {
        return [];
    }

    return [
        'account_id' => $account_id,
        'api_key'    => $api_key,
        'api_secret' => $api_secret,
    ];
}

function e360_get_user_zoom_settings(int $user_id): array {
    if ($user_id <= 0) {
        return [];
    }

    $raw = get_user_meta($user_id, 'tutor_zoom_settings', true);
    if (is_string($raw)) {
        $raw = json_decode($raw, true);
    }

    return is_array($raw) ? $raw : [];
}

function e360_get_zoom_host_id_for_user(int $user_id, array $creds = []): string {
    if ($user_id <= 0 || !function_exists('tutor_utils')) {
        return '';
    }

    $cached = get_transient('e360_zoom_host_id_' . $user_id);
    if (is_string($cached) && $cached !== '') {
        return $cached;
    }

    if (!$creds) {
        $creds = e360_get_user_zoom_api_credentials($user_id);
    }
    if (!$creds) {
        return '';
    }

    $users_endpoint = tutor_utils()->get_package_object(true, '\Zoom\Endpoint\Users', $creds['api_key'], $creds['api_secret']);
    if (!is_object($users_endpoint) || !method_exists($users_endpoint, 'userlist')) {
        return '';
    }

    $host_id = '';
    $teacher = get_user_by('id', $user_id);
    $users_list = $users_endpoint->userlist();
    $users = is_array($users_list) && !empty($users_list['users']) && is_array($users_list['users']) ? $users_list['users'] : [];

    if ($teacher && $users) {
        foreach ($users as $zoom_user) {
            if (!empty($zoom_user['email']) && strtolower((string) $zoom_user['email']) === strtolower((string) $teacher->user_email) && !empty($zoom_user['id'])) {
                $host_id = (string) $zoom_user['id'];
                break;
            }
        }
    }

    if ($host_id === '' && !empty($users[0]['id'])) {
        $host_id = (string) $users[0]['id'];
    }

    if ($host_id !== '') {
        set_transient('e360_zoom_host_id_' . $user_id, $host_id, 12 * HOUR_IN_SECONDS);
    }

    return $host_id;
}

function e360_build_session_zoom_payload(array $session): array {
    $teacher_id = (int) ($session['teacher_id'] ?? 0);
    $lesson_date = sanitize_text_field((string) ($session['lesson_date'] ?? ''));
    $lesson_time = sanitize_text_field((string) ($session['lesson_time'] ?? ''));
    $duration = max(1, (int) ($session['duration'] ?? 60));
    $program_id = (int) ($session['program_id'] ?? 0);
    $program = $program_id > 0 ? e360_get_program($program_id) : [];

    $timezone = '';
    if (!empty($program['timezone'])) {
        $timezone = sanitize_text_field((string) $program['timezone']);
    } elseif ($teacher_id > 0 && function_exists('e360_get_teacher_timezone_string')) {
        $timezone = sanitize_text_field((string) e360_get_teacher_timezone_string($teacher_id));
    }
    if ($timezone === '') {
        $timezone = wp_timezone_string() ?: 'UTC';
    }

    $topic = e360_lesson_session_build_title($session);
    $zoom_settings = e360_get_user_zoom_settings($teacher_id);

    return [
        'topic'      => $topic,
        'type'       => 2,
        'start_time' => $lesson_date . 'T' . ($lesson_time !== '' ? $lesson_time : '00:00') . ':00',
        'timezone'   => $timezone,
        'duration'   => $duration,
        'settings'   => [
            'join_before_host'  => !empty($zoom_settings['join_before_host']),
            'host_video'        => !empty($zoom_settings['host_video']),
            'participant_video' => !empty($zoom_settings['participants_video']),
            'mute_upon_entry'   => !empty($zoom_settings['mute_participants']),
            'auto_recording'    => !empty($zoom_settings['auto_recording']) ? sanitize_text_field((string) $zoom_settings['auto_recording']) : '',
            'enforce_login'     => !empty($zoom_settings['enforce_login']),
        ],
    ];
}

function e360_sync_session_zoom_meeting(int $session_id): bool {
    if ($session_id <= 0 || !function_exists('tutor_utils')) {
        return false;
    }

    $session = e360_get_lesson_session($session_id);
    if (!$session) {
        return false;
    }

    $status = (string) ($session['session_status'] ?? 'scheduled');
    if (!in_array($status, ['scheduled', 'rescheduled'], true)) {
        update_post_meta($session_id, 'zoom_sync_error', '');
        return true;
    }

    $teacher_id = (int) ($session['teacher_id'] ?? 0);
    $lesson_date = trim((string) ($session['lesson_date'] ?? ''));
    if ($teacher_id <= 0 || $lesson_date === '') {
        update_post_meta($session_id, 'zoom_sync_error', 'Missing teacher or lesson date for Zoom sync.');
        return false;
    }

    $creds = e360_get_user_zoom_api_credentials($teacher_id);
    if (!$creds) {
        update_post_meta($session_id, 'zoom_sync_error', 'Teacher Zoom credentials are missing.');
        return false;
    }

    $host_id = e360_get_zoom_host_id_for_user($teacher_id, $creds);
    if ($host_id === '') {
        update_post_meta($session_id, 'zoom_sync_error', 'Could not resolve Zoom host user.');
        return false;
    }

    $zoom_endpoint = tutor_utils()->get_package_object(true, '\Zoom\Endpoint\Meetings', $creds['api_key'], $creds['api_secret']);
    if (!is_object($zoom_endpoint)) {
        update_post_meta($session_id, 'zoom_sync_error', 'Zoom meetings endpoint is unavailable.');
        return false;
    }

    $payload = e360_build_session_zoom_payload($session);
    $saved_meeting = [];
    $meeting_id = trim((string) ($session['zoom_meeting_id'] ?? ''));

    try {
        if ($meeting_id !== '' && method_exists($zoom_endpoint, 'update') && method_exists($zoom_endpoint, 'meeting')) {
            $zoom_endpoint->update($meeting_id, $payload);
            $saved_meeting = $zoom_endpoint->meeting($meeting_id);
        } elseif (method_exists($zoom_endpoint, 'create')) {
            $saved_meeting = $zoom_endpoint->create($host_id, $payload);
        }
    } catch (Throwable $e) {
        update_post_meta($session_id, 'zoom_sync_error', $e->getMessage());
        return false;
    }

    if (!is_array($saved_meeting) || empty($saved_meeting['id'])) {
        update_post_meta($session_id, 'zoom_sync_error', 'Zoom did not return a meeting id.');
        return false;
    }

    update_post_meta($session_id, 'zoom_meeting_id', sanitize_text_field((string) $saved_meeting['id']));
    update_post_meta($session_id, 'zoom_host_id', $host_id);
    update_post_meta($session_id, 'zoom_start_url', esc_url_raw((string) ($saved_meeting['start_url'] ?? '')));
    update_post_meta($session_id, 'zoom_join_url', esc_url_raw((string) ($saved_meeting['join_url'] ?? '')));
    update_post_meta($session_id, 'zoom_sync_error', '');

    return true;
}

function e360_maybe_sync_session_zoom_on_save(int $session_id, array $session, array $previous = []): void {
    static $syncing = [];

    if ($session_id <= 0 || isset($syncing[$session_id])) {
        return;
    }

    $watch = ['teacher_id', 'lesson_date', 'lesson_time', 'duration', 'session_status'];
    $should_sync = empty($previous);

    foreach ($watch as $key) {
        $before = (string) ($previous[$key] ?? '');
        $after  = (string) ($session[$key] ?? '');
        if ($before !== $after) {
            $should_sync = true;
            break;
        }
    }

    if (!$should_sync) {
        return;
    }

    $syncing[$session_id] = true;
    try {
        e360_sync_session_zoom_meeting($session_id);
    } finally {
        unset($syncing[$session_id]);
    }
}
add_action('e360_lesson_session_saved', 'e360_maybe_sync_session_zoom_on_save', 20, 3);

function e360_get_program_sessions(int $program_id, array $args = []): array {
    if ($program_id <= 0) {
        return [];
    }

    $defaults = [
        'statuses' => [],
        'orderby'  => 'lesson_date',
        'order'    => 'ASC',
        'limit'    => -1,
        'ids_only' => false,
    ];
    $args = wp_parse_args($args, $defaults);

    $meta_query = [
        [
            'key'     => 'program_id',
            'value'   => $program_id,
            'compare' => '=',
            'type'    => 'NUMERIC',
        ],
    ];

    $statuses = array_values(array_filter(array_map('sanitize_key', (array) $args['statuses'])));
    if ($statuses) {
        $meta_query[] = [
            'key'     => 'session_status',
            'value'   => $statuses,
            'compare' => 'IN',
        ];
    }

    $orderby = $args['orderby'] === 'ID' ? 'ID' : 'meta_value';
    $query = [
        'post_type'      => e360_lesson_session_post_type(),
        'post_status'    => 'publish',
        'numberposts'    => (int) $args['limit'],
        'fields'         => $args['ids_only'] ? 'ids' : 'ids',
        'orderby'        => $orderby,
        'order'          => strtoupper((string) $args['order']) === 'DESC' ? 'DESC' : 'ASC',
        'meta_query'     => $meta_query,
    ];

    if ($orderby === 'meta_value') {
        $query['meta_key'] = in_array($args['orderby'], ['lesson_time', 'session_status'], true) ? $args['orderby'] : 'lesson_date';
    }

    $ids = get_posts($query);
    if ($args['ids_only']) {
        return array_map('intval', $ids);
    }

    $sessions = [];
    foreach ($ids as $session_id) {
        $session = e360_get_lesson_session((int) $session_id);
        if ($session) {
            $sessions[] = $session;
        }
    }

    return $sessions;
}

function e360_get_user_lesson_sessions(string $meta_key, int $user_id, array $args = []): array {
    if ($user_id <= 0 || !in_array($meta_key, ['student_id', 'teacher_id'], true)) {
        return [];
    }

    $defaults = [
        'statuses' => [],
        'limit'    => 20,
        'future_only' => false,
    ];
    $args = wp_parse_args($args, $defaults);

    $meta_query = [
        [
            'key'     => $meta_key,
            'value'   => $user_id,
            'compare' => '=',
            'type'    => 'NUMERIC',
        ],
    ];

    $statuses = array_values(array_filter(array_map('sanitize_key', (array) $args['statuses'])));
    if ($statuses) {
        $meta_query[] = [
            'key'     => 'session_status',
            'value'   => $statuses,
            'compare' => 'IN',
        ];
    }

    $ids = get_posts([
        'post_type'      => e360_lesson_session_post_type(),
        'post_status'    => 'publish',
        'numberposts'    => max(20, (int) $args['limit'] * 3),
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => 'DESC',
        'meta_query'     => $meta_query,
    ]);

    $sessions = [];
    foreach ($ids as $session_id) {
        $session = e360_get_lesson_session((int) $session_id);
        if (!$session) {
            continue;
        }

        $date = trim((string) ($session['lesson_date'] ?? ''));
        $time = trim((string) ($session['lesson_time'] ?? '00:00'));
        $stamp = $date !== '' ? strtotime($date . ' ' . $time) : false;
        if (!empty($args['future_only']) && ($stamp === false || $stamp < current_time('timestamp'))) {
            continue;
        }

        $session['_sort_stamp'] = $stamp ?: PHP_INT_MAX;
        $sessions[] = $session;
    }

    usort($sessions, static function(array $a, array $b): int {
        return ($a['_sort_stamp'] ?? PHP_INT_MAX) <=> ($b['_sort_stamp'] ?? PHP_INT_MAX);
    });

    $sessions = array_slice($sessions, 0, max(1, (int) $args['limit']));
    foreach ($sessions as &$session) {
        unset($session['_sort_stamp']);
    }

    return $sessions;
}

function e360_get_user_programs(string $meta_key, int $user_id, array $args = []): array {
    if ($user_id <= 0 || !in_array($meta_key, ['student_id', 'teacher_id'], true)) {
        return [];
    }

    $defaults = [
        'statuses' => [],
        'limit'    => 20,
        'order'    => 'DESC',
    ];
    $args = wp_parse_args($args, $defaults);

    $meta_query = [
        [
            'key'     => $meta_key,
            'value'   => $user_id,
            'compare' => '=',
            'type'    => 'NUMERIC',
        ],
    ];

    $statuses = array_values(array_filter(array_map('sanitize_key', (array) $args['statuses'])));
    if ($statuses) {
        $meta_query[] = [
            'key'     => 'status',
            'value'   => $statuses,
            'compare' => 'IN',
        ];
    }

    $ids = get_posts([
        'post_type'      => e360_program_post_type(),
        'post_status'    => 'publish',
        'numberposts'    => (int) $args['limit'],
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => strtoupper((string) $args['order']) === 'ASC' ? 'ASC' : 'DESC',
        'meta_query'     => $meta_query,
    ]);

    $programs = [];
    foreach ($ids as $program_id) {
        $program = e360_get_program((int) $program_id);
        if ($program) {
            $programs[] = $program;
        }
    }

    return $programs;
}

function e360_get_private_reports_filters(): array {
    return [
        'teacher_id' => isset($_GET['teacher_id']) ? max(0, (int) $_GET['teacher_id']) : 0,
        'student_id' => isset($_GET['student_id']) ? max(0, (int) $_GET['student_id']) : 0,
        'course_id'  => isset($_GET['course_id']) ? max(0, (int) $_GET['course_id']) : 0,
        'status'     => isset($_GET['status']) ? sanitize_key((string) $_GET['status']) : '',
        'date_from'  => isset($_GET['date_from']) ? sanitize_text_field((string) $_GET['date_from']) : '',
        'date_to'    => isset($_GET['date_to']) ? sanitize_text_field((string) $_GET['date_to']) : '',
    ];
}

function e360_get_private_reports_programs(array $filters = []): array {
    $meta_query = [];

    if (!empty($filters['teacher_id'])) {
        $meta_query[] = [
            'key'     => 'teacher_id',
            'value'   => (int) $filters['teacher_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['student_id'])) {
        $meta_query[] = [
            'key'     => 'student_id',
            'value'   => (int) $filters['student_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['course_id'])) {
        $meta_query[] = [
            'key'     => 'course_id',
            'value'   => (int) $filters['course_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['status']) && isset(e360_get_program_statuses()[$filters['status']])) {
        $meta_query[] = [
            'key'     => 'status',
            'value'   => (string) $filters['status'],
            'compare' => '=',
        ];
    }

    $ids = get_posts([
        'post_type'   => e360_program_post_type(),
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields'      => 'ids',
        'orderby'     => 'ID',
        'order'       => 'DESC',
        'meta_query'  => $meta_query,
    ]);

    $programs = [];
    foreach ($ids as $program_id) {
        $program = e360_get_program((int) $program_id);
        if ($program) {
            $programs[] = $program;
        }
    }

    return $programs;
}

function e360_get_private_reports_sessions(array $filters = []): array {
    $meta_query = [];

    if (!empty($filters['teacher_id'])) {
        $meta_query[] = [
            'key'     => 'teacher_id',
            'value'   => (int) $filters['teacher_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['student_id'])) {
        $meta_query[] = [
            'key'     => 'student_id',
            'value'   => (int) $filters['student_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['course_id'])) {
        $meta_query[] = [
            'key'     => 'course_id',
            'value'   => (int) $filters['course_id'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ];
    }

    if (!empty($filters['status']) && isset(e360_get_lesson_session_statuses()[$filters['status']])) {
        $meta_query[] = [
            'key'     => 'session_status',
            'value'   => (string) $filters['status'],
            'compare' => '=',
        ];
    }

    $ids = get_posts([
        'post_type'   => e360_lesson_session_post_type(),
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields'      => 'ids',
        'orderby'     => 'ID',
        'order'       => 'DESC',
        'meta_query'  => $meta_query,
    ]);

    $sessions = [];
    $from_ts = !empty($filters['date_from']) ? strtotime($filters['date_from'] . ' 00:00:00') : false;
    $to_ts   = !empty($filters['date_to']) ? strtotime($filters['date_to'] . ' 23:59:59') : false;

    foreach ($ids as $session_id) {
        $session = e360_get_lesson_session((int) $session_id);
        if (!$session) {
            continue;
        }

        $stamp = e360_get_session_occurrence_ts_utc($session);
        if ($from_ts && $stamp < $from_ts) {
            continue;
        }
        if ($to_ts && $stamp > $to_ts) {
            continue;
        }

        $sessions[] = $session;
    }

    return $sessions;
}

function e360_get_private_reports_summary(array $filters = []): array {
    $programs = e360_get_private_reports_programs($filters);
    $sessions = e360_get_private_reports_sessions($filters);

    $summary = [
        'total_programs'          => count($programs),
        'active_programs'         => 0,
        'completed_sessions'      => 0,
        'total_minutes'           => 0,
        'total_hours_label'       => '0h',
        'teacher_earnings'        => 0.0,
        'active_students'         => 0,
        'active_teachers'         => 0,
        'students_with_activity'  => 0,
    ];

    $student_ids = [];
    $teacher_ids = [];
    $active_student_ids = [];

    foreach ($programs as $program) {
        if (in_array((string) ($program['status'] ?? ''), ['active', 'paused'], true)) {
            $summary['active_programs']++;
        }

        $student_id = (int) ($program['student_id'] ?? 0);
        $teacher_id = (int) ($program['teacher_id'] ?? 0);
        if ($student_id > 0) {
            $student_ids[] = $student_id;
        }
        if ($teacher_id > 0) {
            $teacher_ids[] = $teacher_id;
        }
    }

    foreach ($sessions as $session) {
        $status = (string) ($session['session_status'] ?? 'scheduled');
        $duration = max(0, (int) ($session['duration'] ?? 0));
        $student_id = (int) ($session['student_id'] ?? 0);
        if ($student_id > 0) {
            $active_student_ids[] = $student_id;
        }

        if ($status !== 'completed') {
            continue;
        }

        $summary['completed_sessions']++;
        $summary['total_minutes'] += $duration;

        $earning = (float) ($session['teacher_earning'] ?? 0);
        if ($earning <= 0) {
            $program_id = (int) ($session['program_id'] ?? 0);
            $program = $program_id > 0 ? e360_get_program($program_id) : [];
            $earning = (float) ($program['teacher_rate'] ?? 0);
        }
        $summary['teacher_earnings'] += $earning;
    }

    $summary['active_students'] = count(array_unique(array_filter(array_map('intval', $student_ids))));
    $summary['active_teachers'] = count(array_unique(array_filter(array_map('intval', $teacher_ids))));
    $summary['students_with_activity'] = count(array_unique(array_filter(array_map('intval', $active_student_ids))));
    $summary['total_hours_label'] = e360_format_minutes_label((int) $summary['total_minutes']);

    return $summary;
}

function e360_get_private_reports_breakdowns(array $filters = []): array {
    $programs = e360_get_private_reports_programs($filters);
    $sessions = e360_get_private_reports_sessions($filters);

    $teacher_rows = [];
    $student_rows = [];
    $course_rows  = [];

    foreach ($programs as $program) {
        $teacher_id = (int) ($program['teacher_id'] ?? 0);
        $student_id = (int) ($program['student_id'] ?? 0);
        $course_id  = (int) ($program['course_id'] ?? 0);
        $status     = (string) ($program['status'] ?? '');

        if ($teacher_id > 0) {
            if (!isset($teacher_rows[$teacher_id])) {
                $teacher_rows[$teacher_id] = [
                    'teacher_id' => $teacher_id,
                    'programs' => 0,
                    'active_programs' => 0,
                    'students' => [],
                    'remaining_lessons' => 0,
                    'completed_sessions' => 0,
                    'completed_minutes' => 0,
                    'earnings' => 0.0,
                ];
            }
            $teacher_rows[$teacher_id]['programs']++;
            if (in_array($status, ['active', 'paused'], true)) {
                $teacher_rows[$teacher_id]['active_programs']++;
            }
            if ($student_id > 0) {
                $teacher_rows[$teacher_id]['students'][$student_id] = true;
            }
            $teacher_rows[$teacher_id]['remaining_lessons'] += max(0, (int) ($program['remaining_credits'] ?? 0));
        }

        if ($student_id > 0) {
            if (!isset($student_rows[$student_id])) {
                $student_rows[$student_id] = [
                    'student_id' => $student_id,
                    'programs' => 0,
                    'teachers' => [],
                    'remaining_lessons' => 0,
                    'completed_sessions' => 0,
                    'completed_minutes' => 0,
                ];
            }
            $student_rows[$student_id]['programs']++;
            if ($teacher_id > 0) {
                $student_rows[$student_id]['teachers'][$teacher_id] = true;
            }
            $student_rows[$student_id]['remaining_lessons'] += max(0, (int) ($program['remaining_credits'] ?? 0));
        }

        if ($course_id > 0) {
            if (!isset($course_rows[$course_id])) {
                $course_rows[$course_id] = [
                    'course_id' => $course_id,
                    'programs' => 0,
                    'students' => [],
                    'teachers' => [],
                    'completed_sessions' => 0,
                    'completed_minutes' => 0,
                    'earnings' => 0.0,
                ];
            }
            $course_rows[$course_id]['programs']++;
            if ($student_id > 0) {
                $course_rows[$course_id]['students'][$student_id] = true;
            }
            if ($teacher_id > 0) {
                $course_rows[$course_id]['teachers'][$teacher_id] = true;
            }
        }
    }

    foreach ($sessions as $session) {
        if ((string) ($session['session_status'] ?? '') !== 'completed') {
            continue;
        }

        $teacher_id = (int) ($session['teacher_id'] ?? 0);
        $student_id = (int) ($session['student_id'] ?? 0);
        $course_id  = (int) ($session['course_id'] ?? 0);
        $duration   = max(0, (int) ($session['duration'] ?? 0));
        $earning    = (float) ($session['teacher_earning'] ?? 0);

        if ($earning <= 0) {
            $program_id = (int) ($session['program_id'] ?? 0);
            $program = $program_id > 0 ? e360_get_program($program_id) : [];
            $earning = (float) ($program['teacher_rate'] ?? 0);
        }

        if ($teacher_id > 0 && isset($teacher_rows[$teacher_id])) {
            $teacher_rows[$teacher_id]['completed_sessions']++;
            $teacher_rows[$teacher_id]['completed_minutes'] += $duration;
            $teacher_rows[$teacher_id]['earnings'] += $earning;
        }

        if ($student_id > 0 && isset($student_rows[$student_id])) {
            $student_rows[$student_id]['completed_sessions']++;
            $student_rows[$student_id]['completed_minutes'] += $duration;
        }

        if ($course_id > 0 && isset($course_rows[$course_id])) {
            $course_rows[$course_id]['completed_sessions']++;
            $course_rows[$course_id]['completed_minutes'] += $duration;
            $course_rows[$course_id]['earnings'] += $earning;
        }
    }

    foreach ($teacher_rows as &$row) {
        $row['students_count'] = count($row['students']);
        $row['hours_label'] = e360_format_minutes_label((int) $row['completed_minutes']);
    }
    unset($row);

    foreach ($student_rows as &$row) {
        $row['teachers_count'] = count($row['teachers']);
        $row['hours_label'] = e360_format_minutes_label((int) $row['completed_minutes']);
    }
    unset($row);

    foreach ($course_rows as &$row) {
        $row['students_count'] = count($row['students']);
        $row['teachers_count'] = count($row['teachers']);
        $row['hours_label'] = e360_format_minutes_label((int) $row['completed_minutes']);
    }
    unset($row);

    usort($teacher_rows, static function(array $a, array $b): int {
        return $b['completed_sessions'] <=> $a['completed_sessions'];
    });
    usort($student_rows, static function(array $a, array $b): int {
        return $b['completed_sessions'] <=> $a['completed_sessions'];
    });
    usort($course_rows, static function(array $a, array $b): int {
        return $b['completed_sessions'] <=> $a['completed_sessions'];
    });

    return [
        'teachers' => $teacher_rows,
        'students' => $student_rows,
        'courses'  => $course_rows,
    ];
}

function e360_render_private_reports_filters(array $filters, array $programs, array $sessions): void {
    $teacher_ids = [];
    $student_ids = [];
    $course_ids = [];

    foreach ($programs as $program) {
        $teacher_ids[] = (int) ($program['teacher_id'] ?? 0);
        $student_ids[] = (int) ($program['student_id'] ?? 0);
        $course_ids[]  = (int) ($program['course_id'] ?? 0);
    }
    foreach ($sessions as $session) {
        $teacher_ids[] = (int) ($session['teacher_id'] ?? 0);
        $student_ids[] = (int) ($session['student_id'] ?? 0);
        $course_ids[]  = (int) ($session['course_id'] ?? 0);
    }

    $teacher_ids = array_values(array_unique(array_filter(array_map('intval', $teacher_ids))));
    $student_ids = array_values(array_unique(array_filter(array_map('intval', $student_ids))));
    $course_ids  = array_values(array_unique(array_filter(array_map('intval', $course_ids))));
    ?>
<form method="get" style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;margin:16px 0 20px;">
    <input type="hidden" name="page" value="e360-private-reports">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;align-items:end;">
        <p style="margin:0;">
            <label for="e360-report-teacher" style="display:block;font-weight:600;margin-bottom:6px;">Teacher</label>
            <select id="e360-report-teacher" name="teacher_id" style="width:100%;">
                <option value="0">All teachers</option>
                <?php foreach ($teacher_ids as $teacher_id) :
                        $teacher = get_user_by('id', $teacher_id);
                        if (!$teacher) { continue; }
                    ?>
                <option value="<?php echo (int) $teacher_id; ?>"
                    <?php selected((int) $filters['teacher_id'], $teacher_id); ?>>
                    <?php echo esc_html($teacher->display_name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p style="margin:0;">
            <label for="e360-report-student" style="display:block;font-weight:600;margin-bottom:6px;">Student</label>
            <select id="e360-report-student" name="student_id" style="width:100%;">
                <option value="0">All students</option>
                <?php foreach ($student_ids as $student_id) :
                        $student = get_user_by('id', $student_id);
                        if (!$student) { continue; }
                    ?>
                <option value="<?php echo (int) $student_id; ?>"
                    <?php selected((int) $filters['student_id'], $student_id); ?>>
                    <?php echo esc_html($student->display_name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p style="margin:0;">
            <label for="e360-report-course" style="display:block;font-weight:600;margin-bottom:6px;">Course</label>
            <select id="e360-report-course" name="course_id" style="width:100%;">
                <option value="0">All courses</option>
                <?php foreach ($course_ids as $course_id) : ?>
                <option value="<?php echo (int) $course_id; ?>"
                    <?php selected((int) $filters['course_id'], $course_id); ?>>
                    <?php echo esc_html(get_the_title($course_id)); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p style="margin:0;">
            <label for="e360-report-status" style="display:block;font-weight:600;margin-bottom:6px;">Status</label>
            <select id="e360-report-status" name="status" style="width:100%;">
                <option value="">All statuses</option>
                <?php foreach (array_merge(e360_get_program_statuses(), e360_get_lesson_session_statuses()) as $status_key => $label) : ?>
                <option value="<?php echo esc_attr($status_key); ?>"
                    <?php selected((string) $filters['status'], (string) $status_key); ?>>
                    <?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p style="margin:0;">
            <label for="e360-report-date-from" style="display:block;font-weight:600;margin-bottom:6px;">Date
                from</label>
            <input id="e360-report-date-from" type="date" name="date_from"
                value="<?php echo esc_attr((string) $filters['date_from']); ?>" style="width:100%;">
        </p>
        <p style="margin:0;">
            <label for="e360-report-date-to" style="display:block;font-weight:600;margin-bottom:6px;">Date to</label>
            <input id="e360-report-date-to" type="date" name="date_to"
                value="<?php echo esc_attr((string) $filters['date_to']); ?>" style="width:100%;">
        </p>
    </div>
    <p style="margin:14px 0 0;display:flex;gap:8px;">
        <button type="submit" class="button button-primary">Apply filters</button>
        <a class="button" href="<?php echo esc_url(admin_url('admin.php?page=e360-private-reports')); ?>">Reset</a>
    </p>
</form>
<?php
}

function e360_render_private_reports_table_teachers(array $rows): void {
    ?>
<table class="widefat striped">
    <thead>
        <tr>
            <th>Teacher</th>
            <th>Programs</th>
            <th>Students</th>
            <th>Remaining Lessons</th>
            <th>Completed Lessons</th>
            <th>Hours</th>
            <th>Earnings</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$rows) : ?>
        <tr>
            <td colspan="7">No teacher data found.</td>
        </tr>
        <?php else : foreach ($rows as $row) :
            $teacher = get_user_by('id', (int) $row['teacher_id']);
        ?>
        <tr>
            <td><?php echo esc_html($teacher ? $teacher->display_name : ('#' . (int) $row['teacher_id'])); ?></td>
            <td><?php echo esc_html((string) (int) $row['programs']); ?></td>
            <td><?php echo esc_html((string) (int) $row['students_count']); ?></td>
            <td><?php echo esc_html((string) (int) $row['remaining_lessons']); ?></td>
            <td><?php echo esc_html((string) (int) $row['completed_sessions']); ?></td>
            <td><?php echo esc_html((string) $row['hours_label']); ?></td>
            <td><?php echo wp_kses_post(wc_price((float) $row['earnings'])); ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
<?php
}

function e360_render_private_reports_table_students(array $rows): void {
    ?>
<table class="widefat striped">
    <thead>
        <tr>
            <th>Student</th>
            <th>Programs</th>
            <th>Teachers</th>
            <th>Remaining Lessons</th>
            <th>Completed Lessons</th>
            <th>Hours</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$rows) : ?>
        <tr>
            <td colspan="6">No student data found.</td>
        </tr>
        <?php else : foreach ($rows as $row) :
            $student = get_user_by('id', (int) $row['student_id']);
        ?>
        <tr>
            <td><?php echo esc_html($student ? $student->display_name : ('#' . (int) $row['student_id'])); ?></td>
            <td><?php echo esc_html((string) (int) $row['programs']); ?></td>
            <td><?php echo esc_html((string) (int) $row['teachers_count']); ?></td>
            <td><?php echo esc_html((string) (int) $row['remaining_lessons']); ?></td>
            <td><?php echo esc_html((string) (int) $row['completed_sessions']); ?></td>
            <td><?php echo esc_html((string) $row['hours_label']); ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
<?php
}

function e360_render_private_reports_table_courses(array $rows): void {
    ?>
<table class="widefat striped">
    <thead>
        <tr>
            <th>Course</th>
            <th>Programs</th>
            <th>Students</th>
            <th>Teachers</th>
            <th>Completed Lessons</th>
            <th>Hours</th>
            <th>Earnings</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$rows) : ?>
        <tr>
            <td colspan="7">No course data found.</td>
        </tr>
        <?php else : foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo esc_html(get_the_title((int) $row['course_id']) ?: ('#' . (int) $row['course_id'])); ?></td>
            <td><?php echo esc_html((string) (int) $row['programs']); ?></td>
            <td><?php echo esc_html((string) (int) $row['students_count']); ?></td>
            <td><?php echo esc_html((string) (int) $row['teachers_count']); ?></td>
            <td><?php echo esc_html((string) (int) $row['completed_sessions']); ?></td>
            <td><?php echo esc_html((string) $row['hours_label']); ?></td>
            <td><?php echo wp_kses_post(wc_price((float) $row['earnings'])); ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
<?php
}

function e360_render_private_reports_page(): void {
    if (!current_user_can('manage_options')) {
        wp_die('Forbidden');
    }

    $filters = e360_get_private_reports_filters();
    $programs = e360_get_private_reports_programs($filters);
    $sessions = e360_get_private_reports_sessions($filters);
    $summary = e360_get_private_reports_summary($filters);
    $breakdowns = e360_get_private_reports_breakdowns($filters);
    ?>
<div class="wrap">
    <h1>Private Reports</h1>
    <p>Operational overview for one-to-one programs and private lessons. Date filters affect lesson-based metrics and
        activity counts.</p>

    <?php e360_render_private_reports_filters($filters, $programs, $sessions); ?>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin:0 0 20px;">
        <?php
            $cards = [
                ['label' => 'Active Programs', 'value' => (string) (int) $summary['active_programs']],
                ['label' => 'Completed Sessions', 'value' => (string) (int) $summary['completed_sessions']],
                ['label' => 'Total Hours', 'value' => (string) $summary['total_hours_label']],
                ['label' => 'Teacher Earnings', 'value' => wc_price((float) $summary['teacher_earnings'])],
                ['label' => 'Active Students', 'value' => (string) (int) $summary['active_students']],
                ['label' => 'Students With Activity', 'value' => (string) (int) $summary['students_with_activity']],
            ];
            foreach ($cards as $card) :
            ?>
        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <div style="font-size:12px;color:#50575e;margin-bottom:6px;"><?php echo esc_html($card['label']); ?></div>
            <div style="font-size:24px;font-weight:700;line-height:1.2;">
                <?php echo is_string($card['value']) ? wp_kses_post($card['value']) : esc_html((string) $card['value']); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div style="display:grid;gap:20px;">
        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <h2 style="margin-top:0;">By Teacher</h2>
            <?php e360_render_private_reports_table_teachers($breakdowns['teachers']); ?>
        </div>

        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <h2 style="margin-top:0;">By Student</h2>
            <?php e360_render_private_reports_table_students($breakdowns['students']); ?>
        </div>

        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <h2 style="margin-top:0;">By Course</h2>
            <?php e360_render_private_reports_table_courses($breakdowns['courses']); ?>
        </div>
    </div>
</div>
<?php
}

function e360_get_private_migration_report_option_key(): string {
    return 'e360_private_migration_report';
}

function e360_get_private_migration_report(): array {
    $report = get_option(e360_get_private_migration_report_option_key(), []);
    return is_array($report) ? $report : [];
}

function e360_set_private_migration_report(array $report): void {
    update_option(e360_get_private_migration_report_option_key(), $report, false);
}

function e360_get_user_display_label(int $user_id, string $fallback_prefix = 'User'): string {
    $user = $user_id > 0 ? get_user_by('id', $user_id) : null;
    return $user ? (string) $user->display_name : ($fallback_prefix . ' #' . $user_id);
}

function e360_build_migration_candidate_key(int $student_id, int $teacher_id, int $course_id): string {
    return $student_id . ':' . $teacher_id . ':' . $course_id;
}

function e360_collect_private_migration_candidates(): array {
    $candidates = [];
    $skipped = [];

    $push_candidate = static function(array $candidate) use (&$candidates): void {
        $student_id = (int) ($candidate['student_id'] ?? 0);
        $teacher_id = (int) ($candidate['teacher_id'] ?? 0);
        $course_id  = (int) ($candidate['course_id'] ?? 0);
        if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
            return;
        }

        $key = e360_build_migration_candidate_key($student_id, $teacher_id, $course_id);
        if (!isset($candidates[$key])) {
            $candidates[$key] = [
                'student_id'       => $student_id,
                'teacher_id'       => $teacher_id,
                'course_id'        => $course_id,
                'language_term_id' => 0,
                'level_term_id'    => 0,
                'plan_product_id'  => 0,
                'order_id'         => 0,
                'booking_format'   => '',
                'start_date'       => '',
                'timezone'         => '',
                'price_paid'       => 0,
                'currency'         => '',
                'sources'          => [],
                'booking_ids'      => [],
                'order_ids'        => [],
                'enrollment_ids'   => [],
            ];
        }

        $row = &$candidates[$key];
        foreach (['language_term_id', 'level_term_id', 'plan_product_id', 'order_id'] as $int_key) {
            $value = (int) ($candidate[$int_key] ?? 0);
            if ($value > 0 && (int) $row[$int_key] <= 0) {
                $row[$int_key] = $value;
            }
        }

        foreach (['booking_format', 'start_date', 'timezone', 'currency'] as $string_key) {
            $value = trim((string) ($candidate[$string_key] ?? ''));
            if ($value !== '' && (string) $row[$string_key] === '') {
                $row[$string_key] = $value;
            }
        }

        if (!empty($candidate['price_paid']) && (float) $row['price_paid'] <= 0) {
            $row['price_paid'] = (float) $candidate['price_paid'];
        }

        if (!empty($candidate['source'])) {
            $row['sources'][] = (string) $candidate['source'];
        }
        if (!empty($candidate['booking_id'])) {
            $row['booking_ids'][] = (int) $candidate['booking_id'];
        }
        if (!empty($candidate['order_id'])) {
            $row['order_ids'][] = (int) $candidate['order_id'];
        }
        if (!empty($candidate['enrollment_id'])) {
            $row['enrollment_ids'][] = (int) $candidate['enrollment_id'];
        }

        $row['sources'] = array_values(array_unique(array_filter($row['sources'])));
        $row['booking_ids'] = array_values(array_unique(array_map('intval', $row['booking_ids'])));
        $row['order_ids'] = array_values(array_unique(array_map('intval', $row['order_ids'])));
        $row['enrollment_ids'] = array_values(array_unique(array_map('intval', $row['enrollment_ids'])));
        unset($row);
    };

    $booking_ids = get_posts([
        'post_type'   => 'e360_booking',
        'post_status' => ['publish', 'pending', 'trash'],
        'numberposts' => -1,
        'fields'      => 'ids',
        'orderby'     => 'ID',
        'order'       => 'ASC',
    ]);

    foreach ($booking_ids as $booking_id) {
        $student_id = (int) get_post_meta((int) $booking_id, 'student_id', true);
        $teacher_id = (int) get_post_meta((int) $booking_id, 'teacher_id', true);
        $course_id  = (int) get_post_meta((int) $booking_id, 'course_id', true);

        if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
            $skipped[] = [
                'type' => 'booking',
                'id'   => (int) $booking_id,
                'reason' => 'Missing student, teacher, or course meta',
            ];
            continue;
        }

        $push_candidate([
            'student_id'  => $student_id,
            'teacher_id'  => $teacher_id,
            'course_id'   => $course_id,
            'booking_id'  => (int) $booking_id,
            'order_id'    => (int) get_post_meta((int) $booking_id, 'e360_order_id', true),
            'start_date'  => (string) get_post_meta((int) $booking_id, 'local_date', true) ?: (string) get_post_meta((int) $booking_id, 'start_date', true),
            'source'      => 'booking',
        ]);
    }

    if (post_type_exists('tutor_enrolled')) {
        $enrollment_ids = get_posts([
            'post_type'   => 'tutor_enrolled',
            'post_status' => 'publish',
            'numberposts' => -1,
            'fields'      => 'ids',
            'orderby'     => 'ID',
            'order'       => 'ASC',
        ]);

        foreach ($enrollment_ids as $enrollment_id) {
            $student_id = (int) get_post_field('post_author', (int) $enrollment_id);
            $course_id = (int) get_post_meta((int) $enrollment_id, '_course_id', true);
            if ($course_id <= 0) {
                $course_id = (int) get_post_parent((int) $enrollment_id);
            }
            $teacher_id = (int) get_user_meta($student_id, 'e360_primary_teacher_id', true);
            $primary_course_id = (int) get_user_meta($student_id, 'e360_primary_course_id', true);
            if ($teacher_id <= 0 || $course_id <= 0) {
                $skipped[] = [
                    'type' => 'enrollment',
                    'id'   => (int) $enrollment_id,
                    'reason' => 'Missing teacher mapping or course id',
                ];
                continue;
            }
            if ($primary_course_id > 0 && $primary_course_id !== $course_id) {
                continue;
            }

            $push_candidate([
                'student_id'    => $student_id,
                'teacher_id'    => $teacher_id,
                'course_id'     => $course_id,
                'enrollment_id' => (int) $enrollment_id,
                'source'        => 'enrollment',
            ]);
        }
    }

    if (function_exists('wc_get_orders')) {
        $order_ids = wc_get_orders([
            'status' => ['processing', 'completed'],
            'limit'  => -1,
            'return' => 'ids',
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        foreach ($order_ids as $order_id) {
            $order = wc_get_order((int) $order_id);
            if (!$order instanceof WC_Order) {
                continue;
            }

            $ctx = $order->get_meta('_e360_booking_context');
            if (!is_array($ctx)) {
                continue;
            }

            $student_id = (int) $order->get_user_id();
            $teacher_id = (int) ($ctx['teacher_id'] ?? 0);
            $course_id  = (int) ($ctx['course_id'] ?? 0);
            if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
                continue;
            }

            $push_candidate([
                'student_id'       => $student_id,
                'teacher_id'       => $teacher_id,
                'course_id'        => $course_id,
                'language_term_id' => (int) ($ctx['language_term_id'] ?? 0),
                'level_term_id'    => (int) ($ctx['level_term_id'] ?? 0),
                'plan_product_id'  => (int) ($ctx['plan_product_id'] ?? 0),
                'order_id'         => (int) $order->get_id(),
                'booking_format'   => sanitize_key((string) ($ctx['booking_format'] ?? '')),
                'start_date'       => sanitize_text_field((string) ($ctx['date'] ?? '')),
                'timezone'         => $student_id > 0 ? (string) get_user_option('timezone_string', $student_id) : '',
                'price_paid'       => (float) $order->get_total(),
                'currency'         => (string) $order->get_currency(),
                'source'           => 'order',
            ]);
        }
    }

    $users = get_users([
        'fields' => 'ids',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'     => 'e360_primary_teacher_id',
                'compare' => 'EXISTS',
            ],
            [
                'key'     => 'e360_primary_course_id',
                'compare' => 'EXISTS',
            ],
        ],
    ]);

    foreach ($users as $student_id) {
        $student_id = (int) $student_id;
        $teacher_id = (int) get_user_meta($student_id, 'e360_primary_teacher_id', true);
        $course_id  = (int) get_user_meta($student_id, 'e360_primary_course_id', true);
        if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
            continue;
        }

        $push_candidate([
            'student_id' => $student_id,
            'teacher_id' => $teacher_id,
            'course_id'  => $course_id,
            'timezone'   => (string) get_user_option('timezone_string', $student_id),
            'source'     => 'user_meta',
        ]);
    }

    return [
        'candidates' => array_values($candidates),
        'skipped'    => $skipped,
        'stats'      => [
            'candidate_count' => count($candidates),
            'skipped_count'   => count($skipped),
            'booking_count'   => count($booking_ids),
        ],
    ];
}

function e360_run_private_migration(array $scan): array {
    $results = [];
    $summary = [
        'processed' => 0,
        'migrated'  => 0,
        'skipped'   => 0,
        'programs_created' => 0,
        'programs_updated' => 0,
        'bookings_linked'  => 0,
        'sessions_synced'  => 0,
    ];

    foreach ((array) ($scan['candidates'] ?? []) as $candidate) {
        $summary['processed']++;

        $student_id = (int) ($candidate['student_id'] ?? 0);
        $teacher_id = (int) ($candidate['teacher_id'] ?? 0);
        $course_id  = (int) ($candidate['course_id'] ?? 0);
        $existing_program_id = e360_find_program_id($student_id, $course_id, $teacher_id, ['active', 'paused', 'completed', 'cancelled']);

        if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
            $summary['skipped']++;
            $results[] = [
                'student_id' => $student_id,
                'teacher_id' => $teacher_id,
                'course_id'  => $course_id,
                'status'     => 'skipped',
                'message'    => 'Missing key ids',
            ];
            continue;
        }

        $data = [
            'student_id'       => $student_id,
            'teacher_id'       => $teacher_id,
            'course_id'        => $course_id,
            'language_term_id' => (int) ($candidate['language_term_id'] ?? 0),
            'level_term_id'    => (int) ($candidate['level_term_id'] ?? 0),
            'plan_product_id'  => (int) ($candidate['plan_product_id'] ?? 0),
            'order_id'         => (int) ($candidate['order_id'] ?? 0),
            'booking_format'   => (string) ($candidate['booking_format'] ?? ''),
            'status'           => 'active',
            'start_date'       => (string) ($candidate['start_date'] ?? ''),
            'timezone'         => (string) ($candidate['timezone'] ?? ''),
            'price_paid'       => (float) ($candidate['price_paid'] ?? 0),
            'currency'         => (string) ($candidate['currency'] ?? ''),
        ];

        $program_id = e360_upsert_program($data, $existing_program_id);
        if ($program_id <= 0) {
            $summary['skipped']++;
            $results[] = [
                'student_id' => $student_id,
                'teacher_id' => $teacher_id,
                'course_id'  => $course_id,
                'status'     => 'skipped',
                'message'    => 'Could not create or update program',
            ];
            continue;
        }

        if ($existing_program_id > 0) {
            $summary['programs_updated']++;
        } else {
            $summary['programs_created']++;
        }

        update_user_meta($student_id, 'e360_primary_program_id', $program_id);
        update_user_meta($student_id, 'e360_primary_teacher_id', $teacher_id);
        update_user_meta($student_id, 'e360_primary_course_id', $course_id);

        $enrollment_id = e360_ensure_tutor_enrollment($student_id, $course_id, (int) ($candidate['order_id'] ?? 0));
        e360_sync_program_credit_totals($program_id);

        $linked_bookings = [];
        foreach ((array) ($candidate['booking_ids'] ?? []) as $booking_id) {
            $linked_program_id = e360_link_booking_to_program((int) $booking_id, $program_id);
            if ($linked_program_id > 0) {
                $linked_bookings[] = (int) $booking_id;
            }
        }

        $backfilled_bookings = e360_backfill_program_bookings($program_id);
        $all_bookings = array_values(array_unique(array_merge($linked_bookings, $backfilled_bookings)));
        $summary['bookings_linked'] += count($all_bookings);

        $session_ids = e360_sync_program_bookings($program_id, (int) ($candidate['order_id'] ?? 0));
        $summary['sessions_synced'] += count($session_ids);

        e360_refresh_program_from_sessions($program_id);
        $program = e360_get_program($program_id);
        $summary['migrated']++;

        $results[] = [
            'student_id'        => $student_id,
            'teacher_id'        => $teacher_id,
            'course_id'         => $course_id,
            'program_id'        => $program_id,
            'enrollment_id'     => $enrollment_id,
            'status'            => $existing_program_id > 0 ? 'updated' : 'created',
            'sources'           => (array) ($candidate['sources'] ?? []),
            'booking_count'     => count($all_bookings),
            'session_count'     => count($session_ids),
            'total_credits'     => (int) ($program['total_credits'] ?? 0),
            'used_credits'      => (int) ($program['used_credits'] ?? 0),
            'remaining_credits' => (int) ($program['remaining_credits'] ?? 0),
        ];
    }

    return [
        'ran_at' => current_time('mysql'),
        'scan'   => $scan,
        'summary'=> $summary,
        'results'=> $results,
    ];
}

function e360_handle_private_migration_admin_post(): void {
    if (!current_user_can('manage_options')) {
        wp_die('Forbidden');
    }

    check_admin_referer('e360_run_private_migration');
    $scan = e360_collect_private_migration_candidates();
    $report = e360_run_private_migration($scan);
    e360_set_private_migration_report($report);

    wp_safe_redirect(admin_url('admin.php?page=e360-private-migration&migrated=1'));
    exit;
}
add_action('admin_post_e360_run_private_migration', 'e360_handle_private_migration_admin_post');

function e360_render_private_migration_page(): void {
    if (!current_user_can('manage_options')) {
        wp_die('Forbidden');
    }

    $scan = e360_collect_private_migration_candidates();
    $report = e360_get_private_migration_report();
    ?>
<div class="wrap">
    <h1>Private Migration</h1>
    <p>Scan existing bookings, orders, enrollments, and user meta, then create or update private programs without
        breaking old data.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin:16px 0 20px;">
        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <div style="font-size:12px;color:#50575e;margin-bottom:6px;">Migration Candidates</div>
            <div style="font-size:24px;font-weight:700;">
                <?php echo esc_html((string) (int) ($scan['stats']['candidate_count'] ?? 0)); ?></div>
        </div>
        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <div style="font-size:12px;color:#50575e;margin-bottom:6px;">Bookings Scanned</div>
            <div style="font-size:24px;font-weight:700;">
                <?php echo esc_html((string) (int) ($scan['stats']['booking_count'] ?? 0)); ?></div>
        </div>
        <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
            <div style="font-size:12px;color:#50575e;margin-bottom:6px;">Skipped Source Rows</div>
            <div style="font-size:24px;font-weight:700;">
                <?php echo esc_html((string) (int) ($scan['stats']['skipped_count'] ?? 0)); ?></div>
        </div>
    </div>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin:0 0 20px;">
        <?php wp_nonce_field('e360_run_private_migration'); ?>
        <input type="hidden" name="action" value="e360_run_private_migration">
        <button type="submit" class="button button-primary button-large">Run migration now</button>
    </form>

    <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;margin:0 0 20px;">
        <h2 style="margin-top:0;">Candidates Preview</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Sources</th>
                    <th>Bookings</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($scan['candidates'])) : ?>
                <tr>
                    <td colspan="6">No migration candidates found.</td>
                </tr>
                <?php else : foreach ((array) $scan['candidates'] as $row) : ?>
                <tr>
                    <td><?php echo esc_html(e360_get_user_display_label((int) $row['student_id'], 'Student')); ?></td>
                    <td><?php echo esc_html(e360_get_user_display_label((int) $row['teacher_id'], 'Teacher')); ?></td>
                    <td><?php echo esc_html(get_the_title((int) $row['course_id']) ?: ('Course #' . (int) $row['course_id'])); ?>
                    </td>
                    <td><?php echo esc_html(implode(', ', (array) ($row['sources'] ?? []))); ?></td>
                    <td><?php echo esc_html((string) count((array) ($row['booking_ids'] ?? []))); ?></td>
                    <td><?php echo esc_html((string) count((array) ($row['order_ids'] ?? []))); ?></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($scan['skipped'])) : ?>
    <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;margin:0 0 20px;">
        <h2 style="margin-top:0;">Skipped Source Rows</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>ID</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array) $scan['skipped'] as $row) : ?>
                <tr>
                    <td><?php echo esc_html((string) ($row['type'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) (int) ($row['id'] ?? 0)); ?></td>
                    <td><?php echo esc_html((string) ($row['reason'] ?? '')); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if (!empty($report['results'])) : ?>
    <div style="background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:16px;">
        <h2 style="margin-top:0;">Last Migration Report</h2>
        <p><strong>Ran at:</strong> <?php echo esc_html((string) ($report['ran_at'] ?? '')); ?></p>
        <p>
            <strong>Processed:</strong> <?php echo esc_html((string) (int) ($report['summary']['processed'] ?? 0)); ?>,
            <strong>Migrated:</strong> <?php echo esc_html((string) (int) ($report['summary']['migrated'] ?? 0)); ?>,
            <strong>Programs created:</strong>
            <?php echo esc_html((string) (int) ($report['summary']['programs_created'] ?? 0)); ?>,
            <strong>Programs updated:</strong>
            <?php echo esc_html((string) (int) ($report['summary']['programs_updated'] ?? 0)); ?>,
            <strong>Bookings linked:</strong>
            <?php echo esc_html((string) (int) ($report['summary']['bookings_linked'] ?? 0)); ?>,
            <strong>Sessions synced:</strong>
            <?php echo esc_html((string) (int) ($report['summary']['sessions_synced'] ?? 0)); ?>
        </p>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Program</th>
                    <th>Status</th>
                    <th>Bookings</th>
                    <th>Sessions</th>
                    <th>Credits</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ((array) $report['results'] as $row) : ?>
                <tr>
                    <td><?php echo esc_html(e360_get_user_display_label((int) $row['student_id'], 'Student')); ?></td>
                    <td><?php echo esc_html(e360_get_user_display_label((int) $row['teacher_id'], 'Teacher')); ?></td>
                    <td><?php echo esc_html(get_the_title((int) $row['course_id']) ?: ('Course #' . (int) $row['course_id'])); ?>
                    </td>
                    <td>
                        <?php if (!empty($row['program_id'])) : ?>
                        <a
                            href="<?php echo esc_url(admin_url('post.php?post=' . (int) $row['program_id'] . '&action=edit')); ?>">#<?php echo esc_html((string) (int) $row['program_id']); ?></a>
                        <?php else : ?>
                        &mdash;
                        <?php endif; ?>
                    </td>
                    <td><?php echo esc_html((string) ($row['status'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) (int) ($row['booking_count'] ?? 0)); ?></td>
                    <td><?php echo esc_html((string) (int) ($row['session_count'] ?? 0)); ?></td>
                    <td><?php echo esc_html(sprintf('%d / %d / %d', (int) ($row['total_credits'] ?? 0), (int) ($row['used_credits'] ?? 0), (int) ($row['remaining_credits'] ?? 0))); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php
}

function e360_format_minutes_label(int $minutes): string {
    $minutes = max(0, $minutes);
    if ($minutes === 0) {
        return '0h';
    }

    $hours = intdiv($minutes, 60);
    $mins = $minutes % 60;

    if ($mins === 0) {
        return $hours . 'h';
    }

    if ($hours === 0) {
        return $mins . 'm';
    }

    return $hours . 'h ' . $mins . 'm';
}

function e360_get_teacher_private_learning_stats(int $teacher_id): array {
    $stats = [
        'programs_count'         => 0,
        'active_programs_count'  => 0,
        'students_count'         => 0,
        'remaining_lessons'      => 0,
        'upcoming_lessons_count' => 0,
        'completed_lessons_count'=> 0,
        'completed_minutes'      => 0,
        'completed_hours_label'  => '0h',
        'earnings_total'         => 0.0,
    ];

    if ($teacher_id <= 0) {
        return $stats;
    }

    $programs = e360_get_user_programs('teacher_id', $teacher_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => -1,
    ]);

    $student_ids = [];
    foreach ($programs as $program) {
        $stats['programs_count']++;
        if (in_array((string) ($program['status'] ?? ''), ['active', 'paused'], true)) {
            $stats['active_programs_count']++;
        }
        $stats['remaining_lessons'] += max(0, (int) ($program['remaining_credits'] ?? 0));

        $student_id = (int) ($program['student_id'] ?? 0);
        if ($student_id > 0) {
            $student_ids[] = $student_id;
        }
    }
    $stats['students_count'] = count(array_unique($student_ids));

    $sessions = e360_get_user_lesson_sessions('teacher_id', $teacher_id, [
        'limit' => -1,
    ]);

    $now = current_time('timestamp');
    foreach ($sessions as $session) {
        $status = (string) ($session['session_status'] ?? 'scheduled');
        $duration = max(0, (int) ($session['duration'] ?? 0));
        $stamp = e360_get_session_occurrence_ts_utc($session);

        if (in_array($status, ['scheduled', 'rescheduled'], true) && $stamp >= $now) {
            $stats['upcoming_lessons_count']++;
        }

        if ($status === 'completed') {
            $stats['completed_lessons_count']++;
            $stats['completed_minutes'] += $duration;

            $earning = (float) ($session['teacher_earning'] ?? 0);
            if ($earning <= 0) {
                $program_id = (int) ($session['program_id'] ?? 0);
                $program = $program_id > 0 ? e360_get_program($program_id) : [];
                $rate = (float) ($program['teacher_rate'] ?? 0);
                if ($rate > 0) {
                    $earning = $rate;
                }
            }
            $stats['earnings_total'] += $earning;
        }
    }

    $stats['completed_hours_label'] = e360_format_minutes_label((int) $stats['completed_minutes']);

    return $stats;
}

function e360_get_teacher_student_pairings(int $teacher_id, int $limit = 20): array {
    if ($teacher_id <= 0) {
        return [];
    }

    $programs = e360_get_user_programs('teacher_id', $teacher_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => -1,
    ]);
    if (!$programs) {
        return [];
    }

    $rows = [];
    foreach ($programs as $program) {
        $program_id = (int) ($program['ID'] ?? 0);
        $student_id = (int) ($program['student_id'] ?? 0);
        $course_id = (int) ($program['course_id'] ?? 0);
        $key = $student_id . ':' . $course_id;
        $summary = $program_id > 0 ? e360_get_program_summary($program_id) : [];

        if (!isset($rows[$key])) {
            $rows[$key] = [
                'student_id'         => $student_id,
                'course_id'          => $course_id,
                'program_ids'        => [],
                'programs_count'     => 0,
                'remaining_lessons'  => 0,
                'next_lesson_date'   => '',
                'next_lesson_time'   => '',
                'last_lesson_date'   => '',
                'last_lesson_time'   => '',
                'completed_lessons'  => 0,
            ];
        }

        $rows[$key]['program_ids'][] = $program_id;
        $rows[$key]['programs_count']++;
        $rows[$key]['remaining_lessons'] += max(0, (int) ($program['remaining_credits'] ?? 0));
        $rows[$key]['completed_lessons'] += (int) ($summary['completed_count'] ?? 0);

        $next_stamp = trim((string) ($summary['next_lesson_date'] ?? '') . ' ' . (string) ($summary['next_lesson_time'] ?? ''));
        $prev_next_stamp = trim((string) ($rows[$key]['next_lesson_date'] ?? '') . ' ' . (string) ($rows[$key]['next_lesson_time'] ?? ''));
        if ($next_stamp !== '' && ($prev_next_stamp === '' || strcmp($next_stamp, $prev_next_stamp) < 0)) {
            $rows[$key]['next_lesson_date'] = (string) ($summary['next_lesson_date'] ?? '');
            $rows[$key]['next_lesson_time'] = (string) ($summary['next_lesson_time'] ?? '');
        }

        $last_stamp = trim((string) ($summary['last_lesson_date'] ?? '') . ' ' . (string) ($summary['last_lesson_time'] ?? ''));
        $prev_last_stamp = trim((string) ($rows[$key]['last_lesson_date'] ?? '') . ' ' . (string) ($rows[$key]['last_lesson_time'] ?? ''));
        if ($last_stamp !== '' && ($prev_last_stamp === '' || strcmp($last_stamp, $prev_last_stamp) > 0)) {
            $rows[$key]['last_lesson_date'] = (string) ($summary['last_lesson_date'] ?? '');
            $rows[$key]['last_lesson_time'] = (string) ($summary['last_lesson_time'] ?? '');
        }
    }

    usort($rows, static function(array $a, array $b): int {
        $a_stamp = trim(($a['next_lesson_date'] ?? '') . ' ' . ($a['next_lesson_time'] ?? ''));
        $b_stamp = trim(($b['next_lesson_date'] ?? '') . ' ' . ($b['next_lesson_time'] ?? ''));
        if ($a_stamp === '' && $b_stamp === '') {
            return strcmp((string) ($a['last_lesson_date'] ?? ''), (string) ($b['last_lesson_date'] ?? ''));
        }
        if ($a_stamp === '') {
            return 1;
        }
        if ($b_stamp === '') {
            return -1;
        }
        return strcmp($a_stamp, $b_stamp);
    });

    return array_slice(array_values($rows), 0, max(1, $limit));
}

function e360_get_teacher_completed_sessions(int $teacher_id, int $limit = 6): array {
    $sessions = e360_get_user_lesson_sessions('teacher_id', $teacher_id, [
        'statuses' => ['completed'],
        'limit'    => -1,
    ]);

    usort($sessions, static function(array $a, array $b): int {
        return strcmp(
            trim((string) ($b['lesson_date'] ?? '') . ' ' . (string) ($b['lesson_time'] ?? '')),
            trim((string) ($a['lesson_date'] ?? '') . ' ' . (string) ($a['lesson_time'] ?? ''))
        );
    });

    return array_slice($sessions, 0, max(1, $limit));
}

function e360_get_student_private_learning_stats(int $student_id): array {
    $stats = [
        'programs_count'          => 0,
        'remaining_lessons'       => 0,
        'upcoming_lessons_count'  => 0,
        'completed_lessons_count' => 0,
        'completed_minutes'       => 0,
        'completed_hours_label'   => '0h',
        'teacher_id'              => 0,
        'teacher_name'            => '',
        'program_id'              => 0,
        'program_status'          => '',
        'course_id'               => 0,
    ];

    if ($student_id <= 0) {
        return $stats;
    }

    $programs = e360_get_user_programs('student_id', $student_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => -1,
    ]);

    foreach ($programs as $index => $program) {
        $stats['programs_count']++;
        $stats['remaining_lessons'] += max(0, (int) ($program['remaining_credits'] ?? 0));

        if ($index === 0 || in_array((string) ($program['status'] ?? ''), ['active', 'paused'], true)) {
            $teacher_id = (int) ($program['teacher_id'] ?? 0);
            $teacher = $teacher_id > 0 ? get_user_by('id', $teacher_id) : null;
            $stats['teacher_id'] = $teacher_id;
            $stats['teacher_name'] = $teacher ? (string) $teacher->display_name : '';
            $stats['program_id'] = (int) ($program['ID'] ?? 0);
            $stats['program_status'] = (string) ($program['status'] ?? '');
            $stats['course_id'] = (int) ($program['course_id'] ?? 0);
        }
    }

    $sessions = e360_get_user_lesson_sessions('student_id', $student_id, [
        'limit' => -1,
    ]);
    $now = current_time('timestamp');

    foreach ($sessions as $session) {
        $status = (string) ($session['session_status'] ?? 'scheduled');
        $duration = max(0, (int) ($session['duration'] ?? 0));
        $stamp = e360_get_session_occurrence_ts_utc($session);

        if (in_array($status, ['scheduled', 'rescheduled'], true) && $stamp >= $now) {
            $stats['upcoming_lessons_count']++;
        }

        if ($status === 'completed') {
            $stats['completed_lessons_count']++;
            $stats['completed_minutes'] += $duration;
        }
    }

    $stats['completed_hours_label'] = e360_format_minutes_label((int) $stats['completed_minutes']);

    return $stats;
}

function e360_get_student_completed_sessions(int $student_id, int $limit = 10): array {
    $sessions = e360_get_user_lesson_sessions('student_id', $student_id, [
        'statuses' => ['completed', 'cancelled', 'missed'],
        'limit'    => -1,
    ]);

    usort($sessions, static function(array $a, array $b): int {
        return strcmp(
            trim((string) ($b['lesson_date'] ?? '') . ' ' . (string) ($b['lesson_time'] ?? '')),
            trim((string) ($a['lesson_date'] ?? '') . ' ' . (string) ($a['lesson_time'] ?? ''))
        );
    });

    return array_slice($sessions, 0, max(1, $limit));
}

function e360_render_student_private_metrics_cards(int $student_id): string {
    $stats = e360_get_student_private_learning_stats($student_id);
    $cards = [
        ['label' => 'My Teacher',         'value' => $stats['teacher_name'] !== '' ? $stats['teacher_name'] : '—'],
        ['label' => 'My Program',         'value' => $stats['course_id'] > 0 ? get_the_title((int) $stats['course_id']) : '—'],
        ['label' => 'Remaining Lessons',  'value' => (string) $stats['remaining_lessons']],
        ['label' => 'Upcoming Lessons',   'value' => (string) $stats['upcoming_lessons_count']],
        ['label' => 'Completed Lessons',  'value' => (string) $stats['completed_lessons_count']],
        ['label' => 'Hours Learned',      'value' => (string) $stats['completed_hours_label']],
    ];

    ob_start();
    ?>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin:0 0 16px;">
    <?php foreach ($cards as $card) : ?>
    <div style="padding:16px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
        <div style="font-size:13px;opacity:.72;"><?php echo esc_html($card['label']); ?></div>
        <div style="margin-top:8px;font-size:24px;font-weight:700;line-height:1.2;">
            <?php echo esc_html((string) $card['value']); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_student_teacher_program_block(int $student_id): string {
    $programs = e360_get_user_programs('student_id', $student_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => 6,
    ]);
    if (!$programs) {
        return '';
    }

    ob_start();
    ?>
<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:18px;margin-bottom:14px;">My Program</div>
    <div style="margin:-4px 0 12px;font-size:12px;opacity:.72;">
        <?php echo esc_html('All times are shown in your timezone.'); ?>
    </div>
    <div class="tutor-table-responsive">
        <table class="tutor-table">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Remaining</th>
                    <th>Next lesson</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program) : ?>
                <?php
                        $course_id = (int) ($program['course_id'] ?? 0);
                        $teacher = !empty($program['teacher_id']) ? get_user_by('id', (int) $program['teacher_id']) : null;
                        $summary = e360_get_program_summary((int) ($program['ID'] ?? 0));
                        $next_when_data = e360_get_private_datetime_for_viewer(
                            (string) ($summary['next_lesson_date'] ?? ''),
                            (string) ($summary['next_lesson_time'] ?? ''),
                            (int) ($program['teacher_id'] ?? 0),
                            $student_id
                        );
                        $next_session_id = (int) ($summary['next_session_id'] ?? 0);
                        $action_url = $next_session_id > 0
                            ? e360_get_private_lesson_dashboard_url($next_session_id)
                            : ($course_id > 0 ? get_permalink($course_id) : e360_get_private_lesson_dashboard_url());
                        $action_label = $next_session_id > 0 ? 'Open lesson' : 'Schedule your lesson';
                        ?>
                <tr>
                    <td><?php echo esc_html($teacher ? $teacher->display_name : '—'); ?></td>
                    <td><?php echo esc_html($course_id > 0 ? get_the_title($course_id) : '—'); ?></td>
                    <td><?php echo esc_html(e360_get_program_statuses()[(string) ($program['status'] ?? '')] ?? (string) ($program['status'] ?? '')); ?>
                    </td>
                    <td><?php echo esc_html((string) max(0, (int) ($program['remaining_credits'] ?? 0))); ?></td>
                    <td><?php echo esc_html(!empty($summary['next_lesson_date']) ? (string) ($next_when_data['label'] ?? '—') : '—'); ?>
                    </td>
                    <td>
                        <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm"
                            href="<?php echo esc_url($action_url); ?>"><?php echo esc_html($action_label); ?></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_student_history_block(int $student_id, int $limit = 10): string {
    $sessions = e360_get_student_completed_sessions($student_id, $limit);
    if (!$sessions) {
        return '';
    }

    ob_start();
    ?>
<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:18px;margin-bottom:14px;">Lesson History</div>
    <div class="tutor-table-responsive">
        <table class="tutor-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Homework</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $session) : ?>
                <?php
                        $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
                        $status = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
                        $homework = trim((string) ($session['homework'] ?? ''));
                        $notes = trim((string) ($session['session_notes'] ?? ''));
                        $when_data = e360_get_private_session_datetime_for_viewer($session, $student_id);
                        ?>
                <tr>
                    <td><?php echo esc_html((string) ($when_data['label'] ?? '—')); ?>
                    </td>
                    <td><?php echo esc_html($teacher ? $teacher->display_name : '—'); ?></td>
                    <td><?php echo esc_html(!empty($session['course_id']) ? get_the_title((int) $session['course_id']) : '—'); ?>
                    </td>
                    <td><?php echo esc_html($status); ?></td>
                    <td><?php echo esc_html($homework !== '' ? wp_trim_words($homework, 12, '…') : '—'); ?></td>
                    <td><?php echo esc_html($notes !== '' ? wp_trim_words($notes, 12, '…') : '—'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_get_dashboard_page_context(): array {
    global $wp_query;

    $page = '';
    $sub_page = '';
    if (isset($wp_query->query_vars['tutor_dashboard_page'])) {
        $page = sanitize_key((string) $wp_query->query_vars['tutor_dashboard_page']);
    }
    if (isset($wp_query->query_vars['tutor_dashboard_sub_page'])) {
        $sub_page = sanitize_key((string) $wp_query->query_vars['tutor_dashboard_sub_page']);
    }

    return [
        'page'     => $page,
        'sub_page' => $sub_page,
    ];
}

function e360_register_lessons_dashboard_nav(array $nav_items): array {
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        return $nav_items;
    }

    $lessons_url = function_exists('tutor_utils')
        ? add_query_arg('tutor_dashboard_page', 'lessons', tutor_utils()->tutor_dashboard_url())
        : home_url('/dashboard/?tutor_dashboard_page=lessons');

    $insert_after = 'analytics';
    $output = [];
    $inserted = false;

    foreach ($nav_items as $key => $item) {
        $output[$key] = $item;
        if ($key === $insert_after) {
            $output['lessons'] = [
                'title' => 'Lessons',
                'icon'  => 'tutor-icon-note ',
                'url'   => $lessons_url,
            ];
            $inserted = true;
        }
    }

    if (!$inserted) {
        $output['lessons'] = [
            'title' => 'Lessons',
            'icon'  => 'tutor-icon-note ',
            'url'   => $lessons_url,
        ];
    }

    return $output;
}
add_filter('tutor_dashboard/instructor_nav_items', 'e360_register_lessons_dashboard_nav', 30);

function e360_register_student_lessons_dashboard_nav(array $nav_items): array {
    if (!is_user_logged_in() || current_user_can('tutor_instructor') || current_user_can('manage_options')) {
        return $nav_items;
    }

    $lessons_url = function_exists('tutor_utils')
        ? add_query_arg('tutor_dashboard_page', 'lessons', tutor_utils()->tutor_dashboard_url())
        : home_url('/dashboard/?tutor_dashboard_page=lessons');

    $output = [];
    $inserted = false;
    $insert_after = ['my-courses', 'enrolled-courses', 'dashboard'];

    foreach ($nav_items as $key => $item) {
        $output[$key] = $item;
        if (in_array($key, $insert_after, true) && !$inserted) {
            $output['lessons'] = [
                'title' => 'Lessons',
                'icon'  => 'tutor-icon-note ',
                'url'   => $lessons_url,
            ];
            $inserted = true;
        }
    }

    if (!$inserted) {
        $output['lessons'] = [
            'title' => 'Lessons',
            'icon'  => 'tutor-icon-note ',
            'url'   => $lessons_url,
        ];
    }

    return $output;
}
add_filter('tutor_dashboard/nav_items', 'e360_register_student_lessons_dashboard_nav', 30);

function e360_register_lessons_dashboard_nav_ui(array $nav_items): array {
    if (!is_user_logged_in() || isset($nav_items['lessons'])) {
        return $nav_items;
    }

    $lessons_url = function_exists('tutor_utils')
        ? add_query_arg('tutor_dashboard_page', 'lessons', tutor_utils()->tutor_dashboard_url())
        : home_url('/dashboard/?tutor_dashboard_page=lessons');

    $insert_after = current_user_can('tutor_instructor') || current_user_can('manage_options')
        ? ['analytics', 'zoom']
        : ['my-courses', 'enrolled-courses', 'dashboard', 'index'];

    $output = [];
    $inserted = false;

    foreach ($nav_items as $key => $item) {
        $output[$key] = $item;
        if (!$inserted && in_array($key, $insert_after, true)) {
            $output['lessons'] = [
                'title' => 'Lessons',
                'icon'  => 'tutor-icon-note ',
                'url'   => $lessons_url,
            ];
            $inserted = true;
        }
    }

    if (!$inserted) {
        $output['lessons'] = [
            'title' => 'Lessons',
            'icon'  => 'tutor-icon-note ',
            'url'   => $lessons_url,
        ];
    }

    return $output;
}
add_filter('tutor_dashboard/nav_ui_items', 'e360_register_lessons_dashboard_nav_ui', 30);

function e360_get_private_lesson_dashboard_url(int $session_id = 0): string {
    $base = function_exists('tutor_utils')
        ? add_query_arg('tutor_dashboard_page', 'lessons', tutor_utils()->tutor_dashboard_url())
        : home_url('/dashboard/?tutor_dashboard_page=lessons');

    if ($session_id > 0) {
        $base = add_query_arg('lesson_session', $session_id, $base);
    }

    return $base;
}

function e360_get_next_user_course_session(int $user_id, int $course_id, string $role = 'student'): array {
    if ($user_id <= 0 || $course_id <= 0) {
        return [];
    }

    $meta_key = $role === 'teacher' ? 'teacher_id' : 'student_id';
    $sessions = e360_get_user_lesson_sessions($meta_key, $user_id, [
        'statuses'    => ['scheduled', 'rescheduled'],
        'limit'       => -1,
        'future_only' => true,
    ]);

    foreach ($sessions as $session) {
        if ((int) ($session['course_id'] ?? 0) === $course_id) {
            return $session;
        }
    }

    return [];
}

function e360_private_lesson_user_can_access(array $session, int $user_id): bool {
    if ($user_id <= 0 || !$session) {
        return false;
    }

    if (current_user_can('manage_options')) {
        return true;
    }

    $student_id = (int) ($session['student_id'] ?? 0);
    $teacher_id = (int) ($session['teacher_id'] ?? 0);

    if (current_user_can('tutor_instructor')) {
        return $teacher_id === $user_id;
    }

    return $student_id === $user_id;
}

function e360_get_private_session_zoom_state(array $session): array {
    $duration = max(1, (int) ($session['duration'] ?? 60));
    $status_key = sanitize_key((string) ($session['session_status'] ?? 'scheduled'));
    $start_ts = e360_get_session_occurrence_ts_utc($session);
    $now_ts = current_time('timestamp', true);
    $end_ts = $start_ts > 0 ? ($start_ts + ($duration * MINUTE_IN_SECONDS)) : 0;

    $state = [
        'key'            => 'scheduled',
        'label'          => 'Scheduled',
        'class'          => 'is-scheduled',
        'countdown_mode' => 'countdown',
        'countdown_text' => 'Meeting starts in',
        'timestamp'      => $start_ts,
    ];

    if (in_array($status_key, ['cancelled', 'missed', 'completed'], true)) {
        $labels = [
            'cancelled' => 'Cancelled',
            'missed'    => 'Missed',
            'completed' => 'Completed',
        ];
        $state['key'] = $status_key;
        $state['label'] = $labels[$status_key] ?? ucfirst($status_key);
        $state['class'] = 'is-' . $status_key;
        $state['countdown_mode'] = 'static';
        $state['countdown_text'] = $status_key === 'completed'
            ? 'This lesson has been completed.'
            : 'This lesson is no longer active.';
        return $state;
    }

    if ($start_ts > 0 && $now_ts >= $start_ts && $now_ts < $end_ts) {
        $state['key'] = 'live';
        $state['label'] = 'Live';
        $state['class'] = 'is-live';
        $state['countdown_mode'] = 'live';
        $state['countdown_text'] = 'Meeting is live now';
        return $state;
    }

    if ($end_ts > 0 && $now_ts >= $end_ts) {
        $state['key'] = 'expired';
        $state['label'] = 'Expired';
        $state['class'] = 'is-expired';
        $state['countdown_mode'] = 'static';
        $state['countdown_text'] = 'This meeting time has passed.';
        return $state;
    }

    if ($status_key === 'rescheduled') {
        $state['label'] = 'Rescheduled';
        $state['class'] = 'is-rescheduled';
    }

    return $state;
}

function e360_append_private_lesson_note_entry(string $existing, string $content, int $user_id = 0): string {
    $content = trim(wp_strip_all_tags($content));
    if ($content === '') {
        return trim($existing);
    }

    $label = current_time('Y-m-d H:i');
    if ($user_id > 0) {
        $user = get_user_by('id', $user_id);
        if ($user) {
            $label .= ' - ' . $user->display_name;
        }
    }

    $entry = '[' . $label . ']' . "\n" . $content;
    $existing = trim($existing);

    return $existing === '' ? $entry : ($existing . "\n\n" . $entry);
}

function e360_get_private_lesson_note_role_label(int $user_id): string {
    if ($user_id > 0 && user_can($user_id, 'manage_options')) {
        return 'Admin';
    }

    if ($user_id > 0 && user_can($user_id, 'tutor_instructor')) {
        return 'Teacher';
    }

    return 'Student';
}

function e360_format_private_lesson_file_size(int $bytes): string {
    if ($bytes <= 0) {
        return '0 KB';
    }

    if ($bytes >= 1048576) {
        return number_format_i18n($bytes / 1048576, 1) . ' MB';
    }

    return number_format_i18n($bytes / 1024, 0) . ' KB';
}

function e360_get_private_lesson_collab_entries(array $session): array {
    $raw = trim((string) ($session['collab_notes_thread'] ?? ''));
    if ($raw === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return [];
    }

    $entries = [];
    foreach ($decoded as $entry) {
        if (!is_array($entry)) {
            continue;
        }

        $attachments = [];
        foreach ((array) ($entry['attachments'] ?? []) as $attachment) {
            if (!is_array($attachment)) {
                continue;
            }

            $url = esc_url_raw((string) ($attachment['url'] ?? ''));
            if ($url === '') {
                continue;
            }

            $attachments[] = [
                'name' => sanitize_file_name((string) ($attachment['name'] ?? basename($url))),
                'url'  => $url,
                'type' => sanitize_text_field((string) ($attachment['type'] ?? '')),
                'size' => max(0, (int) ($attachment['size'] ?? 0)),
            ];
        }

        $entries[] = [
            'id'          => sanitize_text_field((string) ($entry['id'] ?? '')),
            'author_id'   => (int) ($entry['author_id'] ?? 0),
            'author_name' => sanitize_text_field((string) ($entry['author_name'] ?? '')),
            'role'        => sanitize_text_field((string) ($entry['role'] ?? '')),
            'created_at'  => sanitize_text_field((string) ($entry['created_at'] ?? '')),
            'message'     => sanitize_textarea_field((string) ($entry['message'] ?? '')),
            'attachments' => $attachments,
        ];
    }

    return $entries;
}

function e360_get_private_lesson_legacy_collab_entries(array $session): array {
    $legacy_map = [
        'session_notes'         => 'Teacher notes',
        'homework'              => 'Teacher homework',
        'student_session_notes' => 'Student notes',
        'student_homework'      => 'Student homework',
    ];

    $entries = [];
    foreach ($legacy_map as $key => $label) {
        $value = trim((string) ($session[$key] ?? ''));
        if ($value === '') {
            continue;
        }

        $entries[] = [
            'id'          => 'legacy-' . $key,
            'author_id'   => 0,
            'author_name' => $label,
            'role'        => 'Legacy',
            'created_at'  => '',
            'message'     => $value,
            'attachments' => [],
        ];
    }

    return $entries;
}

function e360_render_private_lesson_collab_thread_html(array $session): string {
    $entries = array_merge(
        e360_get_private_lesson_legacy_collab_entries($session),
        e360_get_private_lesson_collab_entries($session)
    );

    if (!$entries) {
        return '<div style="color:#6b7280;">No notes yet.</div>';
    }

    ob_start();
    foreach ($entries as $entry) :
        $author = trim((string) ($entry['author_name'] ?? ''));
        $role = trim((string) ($entry['role'] ?? ''));
        $created_at = trim((string) ($entry['created_at'] ?? ''));
        $message = trim((string) ($entry['message'] ?? ''));
        $attachments = (array) ($entry['attachments'] ?? []);
        ?>
<div style="padding:12px;border:1px solid #eef0f4;border-radius:12px;background:#fafbfc;">
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:8px;">
        <strong style="font-size:14px;color:#111827;"><?php echo esc_html($author !== '' ? $author : 'Note'); ?></strong>
        <?php if ($role !== '') : ?>
        <span style="font-size:11px;padding:4px 8px;border-radius:999px;background:#eef2ff;color:#3730a3;">
            <?php echo esc_html($role); ?>
        </span>
        <?php endif; ?>
        <?php if ($created_at !== '') : ?>
        <span style="font-size:12px;color:#6b7280;"><?php echo esc_html($created_at); ?></span>
        <?php endif; ?>
    </div>
    <?php if ($message !== '') : ?>
    <div style="line-height:1.65;color:#374151;"><?php echo nl2br(esc_html($message)); ?></div>
    <?php endif; ?>
    <?php if ($attachments) : ?>
    <div style="margin-top:10px;display:grid;gap:8px;">
        <?php foreach ($attachments as $attachment) : ?>
        <a href="<?php echo esc_url((string) $attachment['url']); ?>" target="_blank" rel="noopener noreferrer"
            style="display:flex;justify-content:space-between;gap:12px;align-items:center;padding:10px 12px;border:1px solid #dbe3ef;border-radius:10px;background:#fff;color:#1f4f7a;text-decoration:none;">
            <span style="overflow-wrap:anywhere;"><?php echo esc_html((string) $attachment['name']); ?></span>
            <span style="font-size:12px;color:#6b7280;white-space:nowrap;">
                <?php echo esc_html(e360_format_private_lesson_file_size((int) ($attachment['size'] ?? 0))); ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php
    endforeach;

    return (string) ob_get_clean();
}

function e360_handle_private_lesson_note_uploads(array $files): array|WP_Error {
    if (empty($files['name'])) {
        return [];
    }

    $uploads = [];
    $names = is_array($files['name']) ? $files['name'] : [$files['name']];
    $types = is_array($files['type']) ? $files['type'] : [$files['type']];
    $tmp_names = is_array($files['tmp_name']) ? $files['tmp_name'] : [$files['tmp_name']];
    $errors = is_array($files['error']) ? $files['error'] : [$files['error']];
    $sizes = is_array($files['size']) ? $files['size'] : [$files['size']];

    require_once ABSPATH . 'wp-admin/includes/file.php';

    $allowed_mimes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    foreach ($names as $index => $name) {
        $name = sanitize_file_name((string) $name);
        if ($name === '') {
            continue;
        }

        $error = (int) ($errors[$index] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if ($error !== UPLOAD_ERR_OK) {
            return new WP_Error('upload_error', 'Could not upload one of the files.');
        }

        $size = (int) ($sizes[$index] ?? 0);
        if ($size <= 0 || $size > (5 * 1024 * 1024)) {
            return new WP_Error('file_too_large', 'Each file must be 5 MB or smaller.');
        }

        $ext = strtolower((string) pathinfo($name, PATHINFO_EXTENSION));
        if (!isset($allowed_mimes[$ext])) {
            return new WP_Error('invalid_file_type', 'Only PDF, DOC, and DOCX files are allowed.');
        }

        $file = [
            'name'     => $name,
            'type'     => (string) ($types[$index] ?? ''),
            'tmp_name' => (string) ($tmp_names[$index] ?? ''),
            'error'    => $error,
            'size'     => $size,
        ];

        $uploaded = wp_handle_upload($file, [
            'test_form' => false,
            'mimes'     => $allowed_mimes,
        ]);

        if (!empty($uploaded['error'])) {
            return new WP_Error('upload_error', (string) $uploaded['error']);
        }

        $uploads[] = [
            'name' => $name,
            'url'  => esc_url_raw((string) ($uploaded['url'] ?? '')),
            'type' => sanitize_text_field((string) ($uploaded['type'] ?? '')),
            'size' => $size,
        ];
    }

    return $uploads;
}

function e360_add_private_lesson_collab_entry(int $session_id, array $session, string $message, int $user_id, array $attachments = []): bool|WP_Error {
    $message = sanitize_textarea_field($message);
    $message = trim($message);

    if ($message === '' && !$attachments) {
        return new WP_Error('empty_note', 'Add a note or attach at least one file.');
    }

    $user = $user_id > 0 ? get_user_by('id', $user_id) : null;
    $entries = e360_get_private_lesson_collab_entries($session);
    $entries[] = [
        'id'          => function_exists('wp_generate_uuid4') ? wp_generate_uuid4() : uniqid('note_', true),
        'author_id'   => $user_id,
        'author_name' => $user ? $user->display_name : 'User',
        'role'        => e360_get_private_lesson_note_role_label($user_id),
        'created_at'  => current_time('Y-m-d H:i'),
        'message'     => $message,
        'attachments' => array_values($attachments),
    ];

    $saved = update_post_meta($session_id, 'collab_notes_thread', wp_json_encode($entries));
    if ($saved === false) {
        return new WP_Error('save_failed', 'Could not save note.');
    }

    return true;
}

function e360_render_private_lesson_screen(int $session_id, int $user_id): string {
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_private_lesson_user_can_access($session, $user_id)) {
        return '<div class="tutor-dashboard-content-inner"><div class="tutor-alert tutor-alert-warning">You do not have access to this lesson.</div></div>';
    }

    $is_teacher = current_user_can('tutor_instructor') || current_user_can('manage_options');
    $course_id = (int) ($session['course_id'] ?? 0);
    $program_id = (int) ($session['program_id'] ?? 0);
    $student = !empty($session['student_id']) ? get_user_by('id', (int) $session['student_id']) : null;
    $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
    $status = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
    $viewer_when_data = $is_teacher ? null : e360_get_private_session_datetime_for_viewer($session, $user_id);
    $when = $viewer_when_data ? (string) ($viewer_when_data['label'] ?? '') : trim((string) ($session['lesson_date'] ?? '') . ' ' . (string) ($session['lesson_time'] ?? ''));
    $duration = e360_format_minutes_label((int) ($session['duration'] ?? 0));
    $back_url = e360_get_private_lesson_dashboard_url();
    $history = $is_teacher ? e360_get_teacher_completed_sessions((int) ($session['teacher_id'] ?? 0), 6) : e360_get_student_completed_sessions((int) ($session['student_id'] ?? 0), 6);
    $course_context = $course_id > 0 ? e360_get_private_lesson_course_context($course_id) : [];
    $ajax_url = admin_url('admin-ajax.php');
    $session_nonce = wp_create_nonce('e360_dashboard_session');
    $slots_nonce = wp_create_nonce('e360_booking_nonce');
    $student_req_nonce = wp_create_nonce('e360_student_reschedule_request');
    $booking_id = (int) ($session['source_booking_id'] ?? 0);
    $teacher_id = (int) ($session['teacher_id'] ?? 0);
    $duration_minutes = max(1, (int) ($session['duration'] ?? 60));
    $source_ts_utc = e360_get_session_occurrence_ts_utc($session);
    $zoom_state = e360_get_private_session_zoom_state($session);
    $meeting_id = trim((string) ($session['zoom_meeting_id'] ?? ''));
    $has_zoom_room = $meeting_id !== '' || !empty($session['zoom_join_url']) || !empty($session['zoom_start_url']);
    $counterpart_label = $is_teacher ? 'Student' : 'Teacher';
    $counterpart_name = $is_teacher ? ($student ? $student->display_name : '—') : ($teacher ? $teacher->display_name : '—');
    $teacher_email = $teacher ? (string) $teacher->user_email : '';
    $collab_thread_html = e360_render_private_lesson_collab_thread_html($session);
    $pending_requests_html = '';
    if ($is_teacher && $booking_id > 0 && function_exists('e360_render_teacher_pending_reschedule_requests')) {
        $pending_requests_html = e360_render_teacher_pending_reschedule_requests($teacher_id, $course_id, [
            'booking_id'      => $booking_id,
            'title'           => 'Pending requests for this lesson',
            'empty_message'   => 'No pending requests for this lesson.',
            'show_course'     => false,
            'show_teacher'    => false,
            'show_open_link'  => false,
            'container_style' => 'margin:0 0 16px;',
        ]);
    }

    ob_start();
    ?>
<div class="tutor-dashboard-content-inner e360-private-lesson-page" data-session-id="<?php echo (int) $session_id; ?>"
    data-booking-id="<?php echo (int) $booking_id; ?>" data-teacher-id="<?php echo (int) $teacher_id; ?>"
    data-duration="<?php echo (int) $duration_minutes; ?>" data-source-ts="<?php echo (int) $source_ts_utc; ?>"
    data-ajax="<?php echo esc_url($ajax_url); ?>" data-nonce="<?php echo esc_attr($session_nonce); ?>"
    data-is-teacher="<?php echo $is_teacher ? '1' : '0'; ?>">
    <div
        style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px;">
        <div>
            <div class="tutor-fs-5 tutor-fw-medium tutor-color-black">Private Lesson</div>
            <div style="margin-top:6px;opacity:.7;">
                <?php echo esc_html($course_id > 0 ? get_the_title($course_id) : 'Private lesson'); ?></div>
        </div>
        <a class="tutor-btn tutor-btn-outline-primary" href="<?php echo esc_url($back_url); ?>">Back to Lessons</a>
    </div>

    <style>
    .e360-private-zoom-hero {
        margin: 0 0 16px;
        padding: 24px;
        border: 1px solid #dbe8f7;
        border-radius: 18px;
        background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%);
    }
    .e360-private-zoom-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .02em;
    }
    .e360-private-zoom-badge.is-scheduled,
    .e360-private-zoom-badge.is-rescheduled {
        background: rgba(34, 113, 177, 0.12);
        color: #1f4f7a;
    }
    .e360-private-zoom-badge.is-live {
        background: rgba(16, 185, 129, 0.14);
        color: #047857;
    }
    .e360-private-zoom-badge.is-expired,
    .e360-private-zoom-badge.is-cancelled,
    .e360-private-zoom-badge.is-missed {
        background: rgba(239, 68, 68, 0.14);
        color: #b91c1c;
    }
    .e360-private-zoom-badge.is-completed {
        background: rgba(107, 114, 128, 0.14);
        color: #374151;
    }
    .e360-private-zoom-countdown {
        margin-top: 10px;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.1;
        color: #111827;
    }
    .e360-private-zoom-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-top: 22px;
    }
    .e360-private-zoom-meta span {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .e360-private-zoom-meta strong {
        display: block;
        font-size: 16px;
        color: #111827;
    }
    .e360-private-zoom-warning {
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 12px;
        background: rgba(245, 158, 11, 0.12);
        color: #92400e;
        font-size: 13px;
        font-weight: 600;
    }
    .e360-private-room-summary {
        color: #4b5563;
        line-height: 1.65;
        margin: 0 0 18px;
    }
    </style>

    <div class="e360-private-zoom-hero">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;">
            <div>
                <span class="e360-private-zoom-badge <?php echo esc_attr((string) $zoom_state['class']); ?>">
                    <?php echo esc_html((string) $zoom_state['label']); ?>
                </span>
                <h2 style="margin:14px 0 8px;font-size:32px;line-height:1.15;">
                    <?php echo esc_html($course_id > 0 ? get_the_title($course_id) : 'Private lesson'); ?>
                </h2>
                <p style="margin:0;color:#4b5563;"><?php echo esc_html((string) $zoom_state['countdown_text']); ?></p>
                <div class="e360-private-zoom-countdown"
                    data-mode="<?php echo esc_attr((string) $zoom_state['countdown_mode']); ?>"
                    data-target="<?php echo esc_attr((string) ($zoom_state['timestamp'] ?? 0)); ?>">—</div>
                <?php if (!$is_teacher && !empty($viewer_when_data['timezone'])) : ?>
                <div style="margin-top:8px;font-size:12px;opacity:.72;">
                    <?php echo esc_html('Shown in your timezone: ' . (string) $viewer_when_data['timezone']); ?>
                </div>
                <?php endif; ?>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <?php if ($is_teacher) : ?>
                <button type="button"
                    class="tutor-btn tutor-btn-outline-primary e360-private-session-sync-zoom"><?php echo $has_zoom_room ? 'Re-sync Zoom' : 'Create Zoom'; ?></button>
                <?php endif; ?>
                <?php if ($is_teacher && !empty($session['zoom_start_url'])) : ?>
                <a class="tutor-btn tutor-btn-primary"
                    href="<?php echo esc_url((string) $session['zoom_start_url']); ?>" target="_blank"
                    rel="noopener noreferrer">Start Meeting</a>
                <?php endif; ?>
                <?php if (!empty($session['zoom_join_url'])) : ?>
                <a class="tutor-btn tutor-btn-outline-primary"
                    href="<?php echo esc_url((string) $session['zoom_join_url']); ?>" target="_blank"
                    rel="noopener noreferrer">Join in Zoom App</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!$has_zoom_room && in_array((string) ($session['session_status'] ?? ''), ['scheduled', 'rescheduled'], true)) : ?>
        <div class="e360-private-zoom-warning">
            Zoom meeting has not been created for this session yet.
        </div>
        <?php endif; ?>
        <?php if (!empty($session['zoom_sync_error'])) : ?>
        <div class="e360-private-zoom-warning" style="margin-top:10px;background:rgba(239,68,68,.10);color:#b91c1c;">
            <?php echo esc_html((string) $session['zoom_sync_error']); ?>
        </div>
        <?php endif; ?>

        <div class="e360-private-zoom-meta">
            <div>
                <span>Meeting Date</span>
                <strong><?php echo esc_html($when ?: '—'); ?></strong>
            </div>
            <div>
                <span>Meeting Duration</span>
                <strong><?php echo esc_html($duration); ?></strong>
            </div>
            <div>
                <span><?php echo esc_html($counterpart_label); ?></span>
                <strong><?php echo esc_html($counterpart_name); ?></strong>
            </div>
            <div>
                <span>Program</span>
                <strong><?php echo esc_html($program_id > 0 ? ('#' . $program_id) : '—'); ?></strong>
            </div>
            <div>
                <span>Meeting ID</span>
                <strong><?php echo esc_html($meeting_id !== '' ? $meeting_id : 'Pending'); ?></strong>
            </div>
            <div>
                <span>Host Email</span>
                <strong><?php echo esc_html($teacher_email !== '' ? $teacher_email : '—'); ?></strong>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:minmax(0,2fr) minmax(320px,1fr);gap:16px;align-items:start;">
        <div style="padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
            <?php if ($pending_requests_html !== '') : ?>
            <?php echo $pending_requests_html; ?>
            <?php endif; ?>
            <div
                style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px;">
                <div style="font-weight:700;font-size:18px;">Lesson Room</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <?php if ($is_teacher) : ?>
                    <button type="button"
                        class="tutor-btn tutor-btn-outline-primary tutor-btn-sm e360-private-session-sync-zoom"><?php echo $has_zoom_room ? 'Re-sync Zoom' : 'Create Zoom'; ?></button>
                    <?php endif; ?>
                    <?php if ($is_teacher && !empty($session['zoom_start_url'])) : ?>
                    <a class="tutor-btn tutor-btn-primary tutor-btn-sm"
                        href="<?php echo esc_url((string) $session['zoom_start_url']); ?>" target="_blank"
                        rel="noopener noreferrer">Start meeting</a>
                    <?php endif; ?>
                    <?php if (!empty($session['zoom_join_url'])) : ?>
                    <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm"
                        href="<?php echo esc_url((string) $session['zoom_join_url']); ?>" target="_blank"
                        rel="noopener noreferrer">Join in Zoom App</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!$has_zoom_room && in_array((string) ($session['session_status'] ?? ''), ['scheduled', 'rescheduled'], true)) : ?>
            <div class="e360-private-zoom-warning" style="margin-top:0;margin-bottom:12px;">
                Zoom meeting has not been created for this session yet.
            </div>
            <?php endif; ?>
            <?php if (!empty($session['zoom_sync_error'])) : ?>
            <div class="e360-private-zoom-warning" style="margin-top:0;margin-bottom:12px;background:rgba(239,68,68,.10);color:#b91c1c;">
                <?php echo esc_html((string) $session['zoom_sync_error']); ?>
            </div>
            <?php endif; ?>

            <p class="e360-private-room-summary">
                This session is linked to <strong><?php echo esc_html($course_id > 0 ? get_the_title($course_id) : 'your private program'); ?></strong>.
                Use the Zoom actions above to enter the live lesson room. Your notes, files, and session history stay attached to this lesson.
            </p>
            <div style="margin-top:18px;display:grid;grid-template-columns:1fr;gap:12px;">
                <div style="font-weight:700;font-size:16px;margin-bottom:2px;">Lesson Notes</div>
                <div style="padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                    <div class="e360-collab-thread-display" style="display:grid;gap:10px;"><?php echo $collab_thread_html; ?></div>
                </div>
                <div style="padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                    <label style="display:block;font-size:12px;margin-bottom:6px;">Add note</label>
                    <textarea class="e360-private-collab-note-input tutor-form-control" rows="4"
                        placeholder="<?php echo esc_attr($is_teacher ? 'Add notes for this lesson' : 'Add your notes for this lesson'); ?>"></textarea>
                    <div style="margin-top:10px;">
                        <label style="display:block;font-size:12px;margin-bottom:6px;">Attachments</label>
                        <input type="file" class="e360-private-collab-note-files tutor-form-control"
                            accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            multiple>
                        <div style="margin-top:6px;font-size:12px;color:#6b7280;">PDF, DOC, or DOCX. Max 5 MB per file.</div>
                    </div>
                    <div style="margin-top:10px;">
                        <button type="button"
                            class="tutor-btn tutor-btn-primary tutor-btn-sm e360-private-collab-note-save">Save note</button>
                    </div>
                </div>
            </div>
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #eef0f4;">
                <div style="font-weight:700;font-size:16px;margin-bottom:12px;">Lesson Actions</div>
                <?php if ($is_teacher) : ?>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <button type="button"
                        class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-private-session-complete">Mark
                        completed</button>
                    <button type="button"
                        class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-private-session-reschedule-toggle">Reschedule</button>
                    <button type="button"
                        class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-private-session-cancel">Cancel</button>
                </div>

                <div class="e360-private-session-reschedule-box"
                    style="display:none;margin-top:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:end;">
                        <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                            <span>Date</span>
                            <input type="date" class="e360-private-session-reschedule-date tutor-form-control"
                                value="<?php echo esc_attr((string) ($session['lesson_date'] ?? '')); ?>">
                        </label>
                        <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                            <span>Time</span>
                            <input type="time" class="e360-private-session-reschedule-time tutor-form-control"
                                value="<?php echo esc_attr((string) ($session['lesson_time'] ?? '')); ?>">
                        </label>
                        <button type="button"
                            class="tutor-btn tutor-btn-primary tutor-btn-sm e360-private-session-reschedule-save">Save</button>
                    </div>
                </div>

                <?php elseif ($booking_id > 0) : ?>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <button type="button"
                        class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-private-student-reschedule-toggle">Request
                        reschedule</button>
                </div>
                <div class="e360-private-student-reschedule-box"
                    style="display:none;margin-top:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                    <div style="margin-bottom:10px;font-size:12px;opacity:.72;">
                        <?php echo esc_html('Available times are shown in the teacher timezone.'); ?>
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:end;">
                        <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                            <span>Date</span>
                            <input type="date" class="e360-private-student-date tutor-form-control">
                        </label>
                        <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                            <span>Time</span>
                            <select class="e360-private-student-time tutor-form-select">
                                <option value="">Select date first…</option>
                            </select>
                        </label>
                    </div>
                    <div class="e360-private-student-available" style="margin-top:8px;font-size:12px;opacity:.85;">
                    </div>
                    <div style="margin-top:10px;">
                        <label style="display:block;font-size:12px;margin-bottom:4px;">Reason</label>
                        <textarea class="e360-private-student-reason tutor-form-control" rows="3"
                            placeholder="Please provide reason"></textarea>
                    </div>
                    <div style="margin-top:10px;display:flex;gap:8px;align-items:center;">
                        <button type="button"
                            class="tutor-btn tutor-btn-primary tutor-btn-sm e360-private-student-reschedule-send">Send
                            request</button>
                        <span class="e360-private-student-modal-msg" style="font-size:12px;opacity:.8;"></span>
                    </div>
                </div>
                <?php endif; ?>
                <div class="e360-private-lesson-msg" style="margin-top:10px;font-size:13px;opacity:.75;"></div>
            </div>
        </div>

        <div style="padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
            <div style="font-weight:700;font-size:18px;margin-bottom:12px;">Recent Lesson History</div>
            <?php if (!$history) : ?>
            <p style="margin:0;">No lesson history yet.</p>
            <?php else : ?>
            <div style="display:grid;gap:10px;">
                <?php foreach ($history as $history_session) : ?>
                <?php $history_when = $is_teacher ? trim((string) ($history_session['lesson_date'] ?? '') . ' ' . (string) ($history_session['lesson_time'] ?? '')) : (string) (e360_get_private_session_datetime_for_viewer($history_session, $user_id)['label'] ?? ''); ?>
                <div style="border:1px solid #eef0f4;border-radius:10px;padding:10px;">
                    <div style="font-weight:600;">
                        <?php echo esc_html($history_when !== '' ? $history_when : '—'); ?>
                    </div>
                    <div style="margin-top:4px;font-size:13px;opacity:.75;">
                        <?php
                                    $history_status = e360_get_lesson_session_statuses()[(string) ($history_session['session_status'] ?? '')] ?? (string) ($history_session['session_status'] ?? '');
                                    echo esc_html($history_status . ' • ' . e360_format_minutes_label((int) ($history_session['duration'] ?? 0)));
                                    ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($course_context) : ?>
    <div style="margin-top:16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
        <div
            style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:14px;">
            <div style="font-weight:700;font-size:18px;">Course Context</div>
            <?php if (!empty($course_context['permalink'])) : ?>
            <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm"
                href="<?php echo esc_url((string) $course_context['permalink']); ?>">Open Course</a>
            <?php endif; ?>
        </div>

        <div style="display:grid;grid-template-columns:minmax(160px,220px) minmax(0,1fr);gap:16px;align-items:start;">
            <div>
                <?php if (!empty($course_context['thumbnail'])) : ?>
                <img src="<?php echo esc_url((string) $course_context['thumbnail']); ?>"
                    alt="<?php echo esc_attr((string) ($course_context['title'] ?? 'Course')); ?>"
                    style="display:block;width:100%;border-radius:12px;">
                <?php else : ?>
                <div style="border:1px solid #eef0f4;border-radius:12px;padding:24px;text-align:center;opacity:.65;">No
                    image</div>
                <?php endif; ?>
            </div>
            <div>
                <div style="font-size:20px;font-weight:700;line-height:1.3;">
                    <?php echo esc_html((string) ($course_context['title'] ?? 'Course')); ?></div>
                <div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:10px;font-size:13px;opacity:.8;">
                    <span><?php echo esc_html('Lessons: ' . (int) ($course_context['lesson_count'] ?? 0)); ?></span>
                    <span><?php echo esc_html('Topics: ' . (int) ($course_context['topic_count'] ?? 0)); ?></span>
                    <?php if (!empty($course_context['level'])) : ?>
                    <span><?php echo esc_html('Level: ' . (string) $course_context['level']); ?></span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($course_context['summary'])) : ?>
                <div style="margin-top:12px;line-height:1.6;opacity:.88;">
                    <?php echo esc_html((string) $course_context['summary']); ?></div>
                <?php endif; ?>

                <?php if (!empty($course_context['curriculum'])) : ?>
                <div style="margin-top:16px;">
                    <div style="font-weight:600;margin-bottom:8px;">Curriculum Preview</div>
                    <div style="display:grid;gap:8px;">
                        <?php foreach ((array) $course_context['curriculum'] as $row) : ?>
                        <div style="border:1px solid #eef0f4;border-radius:10px;padding:10px 12px;">
                            <div style="font-weight:600;"><?php echo esc_html((string) ($row['topic'] ?? 'Topic')); ?>
                            </div>
                            <?php if (!empty($row['items'])) : ?>
                            <div style="margin-top:6px;font-size:13px;opacity:.8;">
                                <?php echo esc_html(implode(' • ', (array) $row['items'])); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
(function() {
    var wrap = document.querySelector(
        '.e360-private-lesson-page[data-session-id="<?php echo (int) $session_id; ?>"]');
    if (!wrap || wrap.dataset.bound === '1') return;
    wrap.dataset.bound = '1';

    var countdown = wrap.querySelector('.e360-private-zoom-countdown');
    if (countdown) {
        var countdownMode = countdown.getAttribute('data-mode') || 'static';
        var countdownTarget = parseInt(countdown.getAttribute('data-target') || '0', 10);

        function formatRemaining(totalSeconds) {
            var days = Math.floor(totalSeconds / 86400);
            var hours = Math.floor((totalSeconds % 86400) / 3600);
            var minutes = Math.floor((totalSeconds % 3600) / 60);
            var seconds = totalSeconds % 60;
            if (days > 0) return days + 'd ' + hours + 'h ' + minutes + 'm';
            if (hours > 0) return hours + 'h ' + minutes + 'm ' + seconds + 's';
            if (minutes > 0) return minutes + 'm ' + seconds + 's';
            return seconds + 's';
        }

        function tickCountdown() {
            if (countdownMode === 'static') {
                countdown.textContent = '<?php echo esc_js((string) $zoom_state['label']); ?>';
                return;
            }
            if (countdownMode === 'live') {
                countdown.textContent = 'Live now';
                return;
            }
            if (!countdownTarget) {
                countdown.textContent = '—';
                return;
            }

            var nowTs = Math.floor(Date.now() / 1000);
            var diff = countdownTarget - nowTs;
            if (diff <= 0) {
                countdown.textContent = 'Live now';
                return;
            }

            countdown.textContent = formatRemaining(diff);
            window.setTimeout(tickCountdown, 1000);
        }

        tickCountdown();
    }

    var ajaxUrl = wrap.getAttribute('data-ajax');
    var nonce = wrap.getAttribute('data-nonce');
    var sessionId = wrap.getAttribute('data-session-id');
    var isTeacher = wrap.getAttribute('data-is-teacher') === '1';
    var bookingId = wrap.getAttribute('data-booking-id') || '';
    var teacherId = wrap.getAttribute('data-teacher-id') || '';
    var duration = wrap.getAttribute('data-duration') || '60';
    var sourceTs = wrap.getAttribute('data-source-ts') || '';
    var msg = wrap.querySelector('.e360-private-lesson-msg');

    function post(data) {
        return fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams(data).toString()
        }).then(function(r) {
            return r.json();
        });
    }

    function postFormData(formData) {
        return fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        }).then(function(r) {
            return r.json();
        });
    }

    function refreshCollabState(clearComposer) {
        return post({
            action: 'e360_dashboard_session_get_collab_state',
            nonce: nonce,
            session_id: sessionId
        }).then(function(resp) {
            if (!resp || !resp.success || !resp.data) {
                throw new Error(resp && resp.data && resp.data.message ? resp.data.message : 'Could not refresh lesson notes.');
            }

            var data = resp.data;
            var threadDisplay = wrap.querySelector('.e360-collab-thread-display');
            if (threadDisplay) {
                threadDisplay.innerHTML = data.thread_html || '<div style="color:#6b7280;">No notes yet.</div>';
            }

            if (clearComposer) {
                var noteInput = wrap.querySelector('.e360-private-collab-note-input');
                var filesInput = wrap.querySelector('.e360-private-collab-note-files');
                if (noteInput) noteInput.value = '';
                if (filesInput) filesInput.value = '';
            }
        });
    }

    function setTimeOptions(selectEl, slots) {
        if (!selectEl) return;
        var list = Array.isArray(slots) ? slots : [];
        if (!list.length) {
            selectEl.innerHTML = '<option value="">No available slots</option>';
            return;
        }
        selectEl.innerHTML = '<option value="">Select…</option>';
        list.forEach(function(slot) {
            var opt = document.createElement('option');
            opt.value = slot;
            opt.textContent = (slot || '').substring(0, 5);
            selectEl.appendChild(opt);
        });
    }

    wrap.addEventListener('click', function(e) {
        var btn = e.target.closest('button');
        if (!btn) return;

        if (btn.classList.contains('e360-private-room-copy')) {
            var value = btn.getAttribute('data-copy') || '';
            if (!value) return;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(value).then(function() {
                    if (msg) msg.textContent = 'Meeting ID copied.';
                }).catch(function() {
                    if (msg) msg.textContent = 'Could not copy meeting ID.';
                });
            } else if (msg) {
                msg.textContent = 'Clipboard is not available in this browser.';
            }
            return;
        }

        if (btn.classList.contains('e360-private-session-reschedule-toggle')) {
            var teacherBox = wrap.querySelector('.e360-private-session-reschedule-box');
            if (teacherBox) teacherBox.style.display = teacherBox.style.display === 'none' ? 'block' :
                'none';
            return;
        }

        if (btn.classList.contains('e360-private-session-sync-zoom')) {
            if (msg) msg.textContent = 'Syncing Zoom…';
            post({
                action: 'e360_dashboard_session_sync_zoom',
                nonce: nonce,
                session_id: sessionId
            }).then(function(resp) {
                if (!resp || !resp.success) {
                    throw new Error(resp && resp.data && resp.data.message ? resp.data.message : 'Could not sync Zoom meeting.');
                }
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not sync Zoom meeting.';
            });
            return;
        }

        if (btn.classList.contains('e360-private-student-reschedule-toggle')) {
            var studentBox = wrap.querySelector('.e360-private-student-reschedule-box');
            if (studentBox) studentBox.style.display = studentBox.style.display === 'none' ? 'block' :
                'none';
            return;
        }

        if (msg) msg.textContent = 'Saving…';

        if (btn.classList.contains('e360-private-session-complete')) {
            post({
                action: 'e360_dashboard_session_complete',
                nonce: nonce,
                session_id: sessionId
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not update lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not update lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-private-session-cancel')) {
            if (!window.confirm('Cancel this private lesson?')) {
                if (msg) msg.textContent = '';
                return;
            }
            post({
                action: 'e360_dashboard_session_cancel',
                nonce: nonce,
                session_id: sessionId
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not cancel lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not cancel lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-private-session-reschedule-save')) {
            var dateInput = wrap.querySelector('.e360-private-session-reschedule-date');
            var timeInput = wrap.querySelector('.e360-private-session-reschedule-time');
            post({
                action: 'e360_dashboard_session_reschedule',
                nonce: nonce,
                session_id: sessionId,
                date: dateInput ? dateInput.value : '',
                time: timeInput ? timeInput.value : ''
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not reschedule lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not reschedule lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-private-collab-note-save')) {
            var noteInput = wrap.querySelector('.e360-private-collab-note-input');
            var filesInput = wrap.querySelector('.e360-private-collab-note-files');
            var files = filesInput && filesInput.files ? Array.prototype.slice.call(filesInput.files) : [];
            var noteValue = noteInput ? noteInput.value : '';

            if (!noteValue.trim() && !files.length) {
                if (msg) msg.textContent = 'Add a note or attach a file first.';
                return;
            }

            for (var i = 0; i < files.length; i++) {
                if (files[i].size > 5 * 1024 * 1024) {
                    if (msg) msg.textContent = 'Each file must be 5 MB or smaller.';
                    return;
                }
            }

            var formData = new FormData();
            formData.append('action', 'e360_dashboard_session_add_note_entry');
            formData.append('nonce', nonce);
            formData.append('session_id', sessionId);
            formData.append('note_text', noteValue);
            files.forEach(function(file) {
                formData.append('attachments[]', file);
            });

            postFormData(formData).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not save note.');
                return refreshCollabState(true).then(function() {
                    if (msg) msg.textContent = 'Note saved.';
                });
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not save note.';
            });
            return;
        }

        if (btn.classList.contains('e360-private-student-reschedule-send')) {
            var dateEl = wrap.querySelector('.e360-private-student-date');
            var timeEl = wrap.querySelector('.e360-private-student-time');
            var reasonEl = wrap.querySelector('.e360-private-student-reason');
            var modalMsg = wrap.querySelector('.e360-private-student-modal-msg');
            if (!dateEl || !timeEl || !reasonEl) return;

            if (!dateEl.value || !timeEl.value) {
                if (modalMsg) modalMsg.textContent = 'Select date and time';
                if (msg) msg.textContent = '';
                return;
            }
            if (!reasonEl.value.trim()) {
                if (modalMsg) modalMsg.textContent = 'Reason is required';
                if (msg) msg.textContent = '';
                return;
            }

            if (modalMsg) modalMsg.textContent = 'Sending…';

            post({
                action: 'e360_student_request_reschedule',
                nonce: <?php echo wp_json_encode($student_req_nonce); ?>,
                booking_id: bookingId,
                request_type: 'once',
                source_ts_utc: sourceTs,
                date: dateEl.value,
                time: timeEl.value.substring(0, 5),
                reason: reasonEl.value
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not send request.');
                if (modalMsg) modalMsg.textContent = '';
                if (msg) msg.textContent = 'Request sent to teacher.';
                var studentBox = wrap.querySelector('.e360-private-student-reschedule-box');
                if (studentBox) studentBox.style.display = 'none';
            }).catch(function(err) {
                if (modalMsg) modalMsg.textContent = err.message || 'Could not send request.';
                if (msg) msg.textContent = '';
            });
        }
    });

    wrap.addEventListener('change', function(e) {
        var dateEl = e.target.closest('.e360-private-student-date');
        if (!dateEl) return;

        var timeEl = wrap.querySelector('.e360-private-student-time');
        var availableEl = wrap.querySelector('.e360-private-student-available');
        var modalMsg = wrap.querySelector('.e360-private-student-modal-msg');
        if (!dateEl.value) {
            setTimeOptions(timeEl, []);
            return;
        }

        if (modalMsg) modalMsg.textContent = 'Loading available time…';
        post({
            action: 'e360_get_slots',
            nonce: <?php echo wp_json_encode($slots_nonce); ?>,
            teacher_id: teacherId,
            date: dateEl.value,
            duration: duration
        }).then(function(resp) {
            var slots = (resp && resp.success && resp.data && Array.isArray(resp.data.slots)) ? resp
                .data.slots : [];
            setTimeOptions(timeEl, slots);
            if (availableEl) {
                availableEl.textContent = slots.length ?
                    'Available slots loaded for selected date.' :
                    'No free slots for selected date.';
            }
            if (modalMsg) modalMsg.textContent = '';
        }).catch(function() {
            setTimeOptions(timeEl, []);
            if (availableEl) availableEl.textContent = 'Could not load available slots.';
            if (modalMsg) modalMsg.textContent = '';
        });
    });

    refreshCollabState(false).catch(function() {});
    window.setInterval(function() {
        refreshCollabState(false).catch(function() {});
    }, 8000);
})();
</script>
<?php
    return (string) ob_get_clean();
}

function e360_render_course_private_lesson_cta($course_id = 0): void {
    if (!is_user_logged_in()) {
        return;
    }

    $course_id = (int) $course_id;
    $course_id = $course_id > 0 ? $course_id : (int) get_the_ID();
    if ($course_id <= 0) {
        return;
    }

    $user_id = get_current_user_id();
    $role = (current_user_can('tutor_instructor') || current_user_can('manage_options')) ? 'teacher' : 'student';
    $session = e360_get_next_user_course_session($user_id, $course_id, $role);
    $lessons_url = e360_get_private_lesson_dashboard_url();

    if (!$session) {
        if ($role !== 'student') {
            return;
        }
        ?>
<div class="e360-course-private-lesson-cta"
    style="margin-top:14px;padding:14px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:16px;">Private Lessons</div>
    <div style="margin-top:6px;opacity:.8;">Your live lessons for this course are managed here. If no lesson is
        scheduled yet, you can book one from this course.</div>
    <div style="margin-top:10px;">
        <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm"
            href="<?php echo esc_url(get_permalink($course_id)); ?>">Schedule your lesson</a>
    </div>
</div>
<?php
        return;
    }

    $session_id = (int) ($session['ID'] ?? 0);
    $when_data = $role === 'student'
        ? e360_get_private_session_datetime_for_viewer($session, $user_id)
        : null;
    $when = $when_data ? (string) ($when_data['label'] ?? '') : trim((string) ($session['lesson_date'] ?? '') . ' ' . (string) ($session['lesson_time'] ?? ''));
    $status = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
    $lesson_url = e360_get_private_lesson_dashboard_url($session_id);
    ?>
<div class="e360-course-private-lesson-cta"
    style="margin-top:14px;padding:14px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start;flex-wrap:wrap;">
        <div>
            <div style="font-weight:700;font-size:16px;">Next Private Lesson</div>
            <div style="margin-top:6px;opacity:.8;">
                <?php echo esc_html($when !== '' ? $when : 'Lesson time not set'); ?></div>
            <div style="margin-top:4px;font-size:13px;opacity:.75;"><?php echo esc_html($status); ?></div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a class="tutor-btn tutor-btn-primary tutor-btn-sm" href="<?php echo esc_url($lesson_url); ?>">Open
                lesson</a>
            <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm" href="<?php echo esc_url($lessons_url); ?>">All
                lessons</a>
        </div>
    </div>
</div>
<?php
}
add_action('tutor_course/single/actions_btn_group/after', 'e360_render_course_private_lesson_cta', 20, 1);

function e360_get_private_lesson_course_context(int $course_id): array {
    if ($course_id <= 0) {
        return [];
    }

    $course = get_post($course_id);
    if (!$course) {
        return [];
    }

    $title = (string) get_the_title($course_id);
    $summary = trim((string) get_the_excerpt($course_id));
    if ($summary === '') {
        $summary = trim(wp_strip_all_tags((string) $course->post_content));
    }
    if ($summary !== '') {
        $summary = wp_trim_words($summary, 40, '…');
    }

    $thumbnail = get_the_post_thumbnail_url($course_id, 'medium');
    $lesson_count = 0;
    if (function_exists('tutor_utils') && is_object(tutor_utils()) && method_exists(tutor_utils(), 'get_lesson_count_by_course')) {
        $lesson_count = (int) tutor_utils()->get_lesson_count_by_course($course_id);
    }

    $topics = [];
    if (function_exists('tutor_utils') && is_object(tutor_utils()) && method_exists(tutor_utils(), 'get_topics')) {
        $topics = tutor_utils()->get_topics($course_id);
    }

    $topic_count = 0;
    $curriculum = [];
    foreach ((array) $topics as $topic) {
        $topic_id = is_object($topic) ? (int) ($topic->ID ?? 0) : 0;
        $topic_title = is_object($topic) ? (string) ($topic->post_title ?? '') : '';
        if ($topic_id <= 0) {
            continue;
        }
        $topic_count++;

        $items = get_posts([
            'post_type'      => ['lesson', 'tutor_lesson', 'tutor_course_lesson', 'topic', 'tutor_topic'],
            'post_status'    => 'publish',
            'numberposts'    => 3,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_parent'    => $topic_id,
        ]);

        $curriculum[] = [
            'topic' => $topic_title !== '' ? $topic_title : ('Topic #' . $topic_id),
            'items' => array_values(array_filter(array_map(static function($item) {
                return $item instanceof WP_Post ? (string) $item->post_title : '';
            }, $items))),
        ];

        if (count($curriculum) >= 3) {
            break;
        }
    }

    $level = '';
    if (function_exists('get_tutor_course_level')) {
        $level = (string) get_tutor_course_level($course_id);
    }

    return [
        'title'       => $title,
        'summary'     => $summary,
        'thumbnail'   => $thumbnail ? (string) $thumbnail : '',
        'permalink'   => (string) get_permalink($course_id),
        'lesson_count'=> $lesson_count,
        'topic_count' => $topic_count,
        'level'       => $level,
        'curriculum'  => $curriculum,
    ];
}

function e360_render_teacher_private_metrics_cards(int $teacher_id): string {
    $stats = e360_get_teacher_private_learning_stats($teacher_id);
    $cards = [
        ['label' => 'My Students',        'value' => (string) $stats['students_count']],
        ['label' => 'My Programs',        'value' => (string) $stats['programs_count']],
        ['label' => 'Upcoming Lessons',   'value' => (string) $stats['upcoming_lessons_count']],
        ['label' => 'Completed Lessons',  'value' => (string) $stats['completed_lessons_count']],
        ['label' => 'Hours Taught',       'value' => (string) $stats['completed_hours_label']],
        ['label' => 'Earnings',           'value' => wc_price((float) $stats['earnings_total'])],
        ['label' => 'Remaining Lessons',  'value' => (string) $stats['remaining_lessons']],
    ];

    ob_start();
    ?>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin:0 0 16px;">
    <?php foreach ($cards as $card) : ?>
    <div style="padding:16px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
        <div style="font-size:13px;opacity:.72;"><?php echo esc_html($card['label']); ?></div>
        <div style="margin-top:8px;font-size:24px;font-weight:700;line-height:1.2;">
            <?php echo wp_kses_post($card['value']); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_lessons_dashboard_page(int $teacher_id): string {
    $upcoming_sessions = e360_get_user_lesson_sessions('teacher_id', $teacher_id, [
        'statuses'    => ['scheduled', 'rescheduled'],
        'limit'       => 12,
        'future_only' => true,
    ]);
    $inbox_teacher_id = current_user_can('manage_options') ? 0 : $teacher_id;
    $pending_requests_html = function_exists('e360_render_teacher_pending_reschedule_requests')
        ? e360_render_teacher_pending_reschedule_requests($inbox_teacher_id, 0, [
            'title'          => current_user_can('manage_options') ? 'Pending student requests inbox' : 'Pending student requests',
            'empty_message'  => 'No pending student requests right now.',
            'show_course'    => true,
            'show_teacher'   => current_user_can('manage_options'),
            'show_open_link' => true,
            'container_style'=> 'margin:0 0 16px;',
        ])
        : '';

    ob_start();
    ?>
<div class="tutor-dashboard-content-inner">
    <div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-text-capitalize tutor-mb-24">Lessons</div>
    <?php echo e360_render_teacher_private_metrics_cards($teacher_id); ?>
    <?php echo $pending_requests_html; ?>
    <?php echo e360_render_teacher_programs_block($teacher_id, 12); ?>
    <?php if ($upcoming_sessions) : ?>
    <?php echo e360_render_dashboard_private_lessons_card($upcoming_sessions, 'teacher'); ?>
    <?php endif; ?>
    <?php echo e360_render_teacher_completed_lessons_block($teacher_id, 12); ?>
    <?php echo e360_render_teacher_students_block($teacher_id, 20); ?>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_student_lessons_dashboard_page(int $student_id): string {
    $upcoming_sessions = e360_get_user_lesson_sessions('student_id', $student_id, [
        'statuses'    => ['scheduled', 'rescheduled'],
        'limit'       => 12,
        'future_only' => true,
    ]);

    ob_start();
    ?>
<div class="tutor-dashboard-content-inner">
    <div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-text-capitalize tutor-mb-24">Lessons</div>
    <?php echo e360_render_student_private_metrics_cards($student_id); ?>
    <?php echo e360_render_student_teacher_program_block($student_id); ?>
    <?php if ($upcoming_sessions) : ?>
    <?php echo e360_render_dashboard_private_lessons_card($upcoming_sessions, 'student'); ?>
    <?php endif; ?>
    <?php echo e360_render_student_history_block($student_id, 12); ?>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_teacher_programs_block(int $teacher_id, int $limit = 6): string {
    $programs = e360_get_user_programs('teacher_id', $teacher_id, [
        'statuses' => ['active', 'paused', 'completed'],
        'limit'    => $limit,
    ]);
    if (!$programs) {
        return '';
    }

    ob_start();
    ?>
<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:18px;margin-bottom:14px;">My Programs</div>
    <div class="tutor-table-responsive">
        <table class="tutor-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Remaining</th>
                    <th>Next lesson</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program) : ?>
                <?php
                        $student = !empty($program['student_id']) ? get_user_by('id', (int) $program['student_id']) : null;
                        $summary = e360_get_program_summary((int) ($program['ID'] ?? 0));
                        ?>
                <tr>
                    <td><?php echo esc_html($student ? $student->display_name : '—'); ?></td>
                    <td><?php echo esc_html(!empty($program['course_id']) ? get_the_title((int) $program['course_id']) : '—'); ?>
                    </td>
                    <td><?php echo esc_html(e360_get_program_statuses()[(string) ($program['status'] ?? '')] ?? (string) ($program['status'] ?? '')); ?>
                    </td>
                    <td><?php echo esc_html((string) max(0, (int) ($program['remaining_credits'] ?? 0))); ?></td>
                    <td><?php echo esc_html(!empty($summary['next_lesson_date']) ? trim(($summary['next_lesson_date'] ?? '') . ' ' . ($summary['next_lesson_time'] ?? '')) : '—'); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_teacher_students_block(int $teacher_id, int $limit = 12): string {
    $rows = e360_get_teacher_student_pairings($teacher_id, $limit);
    if (!$rows) {
        return '';
    }

    ob_start();
    ?>
<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:18px;margin-bottom:14px;">My Students</div>
    <div class="tutor-table-responsive">
        <table class="tutor-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Programs</th>
                    <th>Remaining</th>
                    <th>Next lesson</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                <?php $student = !empty($row['student_id']) ? get_user_by('id', (int) $row['student_id']) : null; ?>
                <tr>
                    <td><?php echo esc_html($student ? $student->display_name : '—'); ?></td>
                    <td><?php echo esc_html(!empty($row['course_id']) ? get_the_title((int) $row['course_id']) : '—'); ?>
                    </td>
                    <td><?php echo esc_html((string) ($row['programs_count'] ?? 0)); ?></td>
                    <td><?php echo esc_html((string) ($row['remaining_lessons'] ?? 0)); ?></td>
                    <td><?php echo esc_html(!empty($row['next_lesson_date']) ? trim(($row['next_lesson_date'] ?? '') . ' ' . ($row['next_lesson_time'] ?? '')) : '—'); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_teacher_completed_lessons_block(int $teacher_id, int $limit = 6): string {
    $sessions = e360_get_teacher_completed_sessions($teacher_id, $limit);
    if (!$sessions) {
        return '';
    }

    ob_start();
    ?>
<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="font-weight:700;font-size:18px;margin-bottom:14px;">Completed Lessons</div>
    <div class="tutor-table-responsive">
        <table class="tutor-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Earning</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $session) : ?>
                <?php
                        $student = !empty($session['student_id']) ? get_user_by('id', (int) $session['student_id']) : null;
                        $earning = (float) ($session['teacher_earning'] ?? 0);
                        if ($earning <= 0 && !empty($session['program_id'])) {
                            $program = e360_get_program((int) $session['program_id']);
                            $earning = (float) ($program['teacher_rate'] ?? 0);
                        }
                        ?>
                <tr>
                    <td><?php echo esc_html($student ? $student->display_name : '—'); ?></td>
                    <td><?php echo esc_html(!empty($session['course_id']) ? get_the_title((int) $session['course_id']) : '—'); ?>
                    </td>
                    <td><?php echo esc_html(trim((string) ($session['lesson_date'] ?? '') . ' ' . (string) ($session['lesson_time'] ?? ''))); ?>
                    </td>
                    <td><?php echo esc_html(e360_format_minutes_label((int) ($session['duration'] ?? 0))); ?></td>
                    <td><?php echo wp_kses_post(wc_price($earning)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    return (string) ob_get_clean();
}

function e360_render_teacher_private_analytics_sections(int $teacher_id, string $sub_page = 'overview'): string {
    ob_start();
    echo e360_render_teacher_private_metrics_cards($teacher_id);

    if ($sub_page === 'students') {
        echo e360_render_teacher_students_block($teacher_id, 20);
    } else {
        echo e360_render_teacher_students_block($teacher_id, 8);
        echo e360_render_teacher_programs_block($teacher_id, 8);
        echo e360_render_teacher_completed_lessons_block($teacher_id, 8);
    }

    return (string) ob_get_clean();
}

function e360_load_lessons_dashboard_template(string $template): string {
    global $wp_query;

    $page = isset($wp_query->query_vars['tutor_dashboard_page']) ? sanitize_key((string) $wp_query->query_vars['tutor_dashboard_page']) : '';
    if ($page !== 'lessons') {
        return $template;
    }

    if (!is_user_logged_in()) {
        return $template;
    }

    $template_path = plugin_dir_path(__FILE__) . 'dashboard-lessons-template.php';
    return file_exists($template_path) ? $template_path : $template;
}
add_filter('load_dashboard_template_part_from_other_location', 'e360_load_lessons_dashboard_template', 30);

function e360_get_private_viewer_timezone_string(int $user_id): string {
    if ($user_id > 0) {
        $candidates = [];

        $candidates[] = (string) get_user_option('timezone_string', $user_id);
        $candidates[] = (string) get_user_meta($user_id, 'timezone_string', true);

        $booking_ctx = get_user_meta($user_id, 'e360_booking_context', true);
        if (is_array($booking_ctx) && !empty($booking_ctx['timezone'])) {
            $candidates[] = (string) $booking_ctx['timezone'];
        }

        $program_id = (int) get_user_meta($user_id, 'e360_primary_program_id', true);
        if ($program_id > 0 && function_exists('e360_get_program')) {
            $program = e360_get_program($program_id);
            if (is_array($program) && !empty($program['timezone'])) {
                $candidates[] = (string) $program['timezone'];
            }
        }

        foreach ($candidates as $tz) {
            if ($tz !== '' && in_array($tz, timezone_identifiers_list(), true)) {
                return $tz;
            }
        }
    }

    $site_tz = function_exists('wp_timezone_string') ? (string) wp_timezone_string() : '';
    return $site_tz !== '' ? $site_tz : 'UTC';
}

function e360_get_session_occurrence_ts_utc(array $session): int {
    $lesson_date = trim((string) ($session['lesson_date'] ?? ''));
    $lesson_time = trim((string) ($session['lesson_time'] ?? '00:00'));
    $teacher_id = (int) ($session['teacher_id'] ?? 0);
    if ($lesson_date === '') {
        return 0;
    }

    $tz_name = 'UTC';
    if ($teacher_id > 0 && function_exists('e360_get_teacher_timezone_string')) {
        $tz_name = (string) e360_get_teacher_timezone_string($teacher_id);
    }

    try {
        $tz = new DateTimeZone($tz_name ?: 'UTC');
        $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $lesson_date . ' ' . $lesson_time, $tz);
        if (!$dt) {
            return 0;
        }
        return (int) $dt->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
    } catch (Throwable $e) {
        return 0;
    }
}

function e360_get_private_datetime_for_viewer(string $lesson_date, string $lesson_time, int $teacher_id, int $viewer_id): array {
    $label = trim($lesson_date . ' ' . $lesson_time);
    $viewer_tz = e360_get_private_viewer_timezone_string($viewer_id);

    if ($lesson_date === '') {
        return [
            'date'     => $lesson_date,
            'time'     => $lesson_time,
            'label'    => $label,
            'timezone' => $viewer_tz,
        ];
    }

    $teacher_tz = 'UTC';
    if ($teacher_id > 0 && function_exists('e360_get_teacher_timezone_string')) {
        $teacher_tz = (string) e360_get_teacher_timezone_string($teacher_id);
    }

    try {
        $source_tz = new DateTimeZone($teacher_tz ?: 'UTC');
        $target_tz = new DateTimeZone($viewer_tz ?: 'UTC');
        $dt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $lesson_date . ' ' . ($lesson_time !== '' ? $lesson_time : '00:00'), $source_tz);
        if ($dt instanceof DateTimeImmutable) {
            $dt = $dt->setTimezone($target_tz);

            return [
                'date'     => $dt->format('Y-m-d'),
                'time'     => $dt->format('H:i'),
                'label'    => $dt->format('Y-m-d H:i'),
                'timezone' => $viewer_tz,
            ];
        }
    } catch (Throwable $e) {
    }

    return [
        'date'     => $lesson_date,
        'time'     => $lesson_time,
        'label'    => $label,
        'timezone' => $viewer_tz,
    ];
}

function e360_get_private_session_datetime_for_viewer(array $session, int $viewer_id): array {
    return e360_get_private_datetime_for_viewer(
        (string) ($session['lesson_date'] ?? ''),
        (string) ($session['lesson_time'] ?? ''),
        (int) ($session['teacher_id'] ?? 0),
        $viewer_id
    );
}

function e360_render_dashboard_private_lessons_card(array $sessions, string $mode = 'student'): string {
    if (!$sessions) {
        return '';
    }

    $title = $mode === 'teacher' ? 'Upcoming private lessons' : 'Your upcoming lessons';
    $ajax_url = admin_url('admin-ajax.php');
    $nonce = wp_create_nonce('e360_dashboard_session');
    $slots_nonce = wp_create_nonce('e360_booking_nonce');
    $student_req_nonce = wp_create_nonce('e360_student_reschedule_request');
    $viewer_id = get_current_user_id();

    ob_start();
    ?>
<div class="e360-dashboard-private-lessons" data-mode="<?php echo esc_attr($mode); ?>"
    data-ajax="<?php echo esc_url($ajax_url); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"
    style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px;">
        <div style="font-weight:700;font-size:18px;"><?php echo esc_html($title); ?></div>
        <div style="opacity:.65;font-size:13px;"><?php echo esc_html(sprintf('%d scheduled', count($sessions))); ?>
        </div>
    </div>
    <?php if ($mode === 'student') : ?>
    <div style="margin:-4px 0 12px;font-size:12px;opacity:.72;">
        <?php echo esc_html('All times are shown in your timezone.'); ?>
    </div>
    <?php endif; ?>
    <div style="display:grid;gap:12px;">
        <?php foreach ($sessions as $session) : ?>
        <?php
                $course_id = (int) ($session['course_id'] ?? 0);
                $program_id = (int) ($session['program_id'] ?? 0);
                $student = !empty($session['student_id']) ? get_user_by('id', (int) $session['student_id']) : null;
                $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
                $status  = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
                $when_data = $mode === 'student' ? e360_get_private_session_datetime_for_viewer($session, $viewer_id) : null;
                $when    = $when_data ? (string) ($when_data['label'] ?? '') : trim((string) ($session['lesson_date'] ?? '') . ' ' . (string) ($session['lesson_time'] ?? ''));
                $session_id = (int) ($session['ID'] ?? 0);
                $booking_id = (int) ($session['source_booking_id'] ?? 0);
                $teacher_id = (int) ($session['teacher_id'] ?? 0);
                $duration = max(1, (int) ($session['duration'] ?? 60));
                $source_ts_utc = e360_get_session_occurrence_ts_utc($session);
                $lesson_url = e360_get_private_lesson_dashboard_url($session_id);
                ?>
        <div class="e360-dashboard-session-card" data-session-id="<?php echo (int) $session_id; ?>"
            data-booking-id="<?php echo (int) $booking_id; ?>" data-teacher-id="<?php echo (int) $teacher_id; ?>"
            data-duration="<?php echo (int) $duration; ?>" data-source-ts="<?php echo (int) $source_ts_utc; ?>"
            style="border:1px solid #eef0f4;border-radius:12px;padding:14px;">
            <div style="display:flex;justify-content:space-between;gap:16px;align-items:flex-start;flex-wrap:wrap;">
                <div>
                    <div style="font-weight:600;">
                        <?php echo esc_html($course_id > 0 ? get_the_title($course_id) : 'Private lesson'); ?></div>
                    <div style="margin-top:4px;opacity:.78;font-size:13px;">
                        <?php echo esc_html($when ?: 'Date not set'); ?></div>
                    <div style="margin-top:6px;font-size:13px;opacity:.85;">
                        <?php if ($mode === 'teacher') : ?>
                        <?php echo esc_html('Student: ' . ($student ? $student->display_name : '—')); ?>
                        <?php else : ?>
                        <?php echo esc_html('Teacher: ' . ($teacher ? $teacher->display_name : '—')); ?>
                        <?php endif; ?>
                    </div>
                    <div style="margin-top:4px;font-size:13px;opacity:.7;">
                        <?php echo esc_html('Program #' . ($program_id > 0 ? $program_id : 0) . ' • ' . $status); ?>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <?php if ($session_id > 0) : ?>
                    <a class="tutor-btn tutor-btn-secondary tutor-btn-sm"
                        href="<?php echo esc_url($lesson_url); ?>">Open lesson</a>
                    <?php endif; ?>
                    <?php if (!empty($session['zoom_join_url'])) : ?>
                    <a class="tutor-btn tutor-btn-outline-primary tutor-btn-sm"
                        href="<?php echo esc_url((string) $session['zoom_join_url']); ?>" target="_blank"
                        rel="noopener noreferrer">Join Zoom</a>
                    <?php endif; ?>
                    <?php if ($mode === 'teacher' && !empty($session['zoom_start_url'])) : ?>
                    <a class="tutor-btn tutor-btn-primary tutor-btn-sm"
                        href="<?php echo esc_url((string) $session['zoom_start_url']); ?>" target="_blank"
                        rel="noopener noreferrer">Start meeting</a>
                    <?php endif; ?>
                    <?php if ($program_id > 0) : ?>
                    <a class="tutor-btn tutor-btn-secondary tutor-btn-sm"
                        href="<?php echo esc_url(admin_url('post.php?post=' . $program_id . '&action=edit')); ?>">Program</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($mode === 'teacher') : ?>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;">
                <button type="button"
                    class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-session-complete">Mark
                    completed</button>
                <button type="button"
                    class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-session-reschedule-toggle">Reschedule</button>
                <button type="button"
                    class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-session-cancel">Cancel</button>
                <button type="button"
                    class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-session-notes-toggle">Add
                    notes</button>
            </div>
            <div class="e360-session-reschedule-box"
                style="display:none;margin-top:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:end;">
                    <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                        <span>Date</span>
                        <input type="date" class="e360-session-reschedule-date tutor-form-control"
                            value="<?php echo esc_attr((string) ($session['lesson_date'] ?? '')); ?>">
                    </label>
                    <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                        <span>Time</span>
                        <input type="time" class="e360-session-reschedule-time tutor-form-control"
                            value="<?php echo esc_attr((string) ($session['lesson_time'] ?? '')); ?>">
                    </label>
                    <button type="button"
                        class="tutor-btn tutor-btn-primary tutor-btn-sm e360-session-reschedule-save">Save</button>
                </div>
            </div>
            <div class="e360-session-notes-box"
                style="display:none;margin-top:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                <label style="display:block;font-size:12px;margin-bottom:4px;">Session notes</label>
                <textarea class="e360-session-notes tutor-form-control" rows="4"
                    placeholder="Add notes for this lesson"><?php echo esc_textarea((string) ($session['session_notes'] ?? '')); ?></textarea>
                <div style="margin-top:10px;display:flex;gap:8px;align-items:center;">
                    <button type="button" class="tutor-btn tutor-btn-primary tutor-btn-sm e360-session-notes-save">Save
                        notes</button>
                </div>
            </div>
            <?php elseif ($booking_id > 0) : ?>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;">
                <button type="button"
                    class="tutor-btn tutor-btn-sm tutor-btn-outline-primary e360-student-session-reschedule-toggle">Request
                    reschedule</button>
            </div>
            <div class="e360-student-session-reschedule-box"
                style="display:none;margin-top:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;background:#fafbfc;">
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:end;">
                    <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                        <span>Date</span>
                        <input type="date" class="e360-student-session-date tutor-form-control">
                    </label>
                    <label style="display:flex;flex-direction:column;gap:4px;font-size:12px;">
                        <span>Time</span>
                        <select class="e360-student-session-time tutor-form-select">
                            <option value="">Select date first…</option>
                        </select>
                    </label>
                </div>
                <div class="e360-student-session-available" style="margin-top:8px;font-size:12px;opacity:.85;"></div>
                <div style="margin-top:10px;">
                    <label style="display:block;font-size:12px;margin-bottom:4px;">Reason</label>
                    <textarea class="e360-student-session-reason tutor-form-control" rows="3"
                        placeholder="Please provide reason"></textarea>
                </div>
                <div style="margin-top:10px;display:flex;gap:8px;align-items:center;">
                    <button type="button"
                        class="tutor-btn tutor-btn-primary tutor-btn-sm e360-student-session-reschedule-send">Send
                        request</button>
                    <span class="e360-student-session-modal-msg" style="font-size:12px;opacity:.8;"></span>
                </div>
            </div>
            <?php endif; ?>
            <div class="e360-session-msg" style="margin-top:10px;font-size:13px;opacity:.75;"></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php if ($mode === 'teacher') : ?>
<script>
(function() {
    if (window.e360DashboardSessionActionsBound) return;
    window.e360DashboardSessionActionsBound = true;

    function post(url, data) {
        return fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams(data).toString()
        }).then(function(r) {
            return r.json();
        });
    }

    document.addEventListener('click', function(e) {
        var btn = e.target.closest(
            '.e360-session-complete, .e360-session-cancel, .e360-session-reschedule-toggle, .e360-session-reschedule-save, .e360-session-notes-toggle, .e360-session-notes-save'
            );
        if (!btn) return;

        var wrap = btn.closest('.e360-dashboard-private-lessons');
        var card = btn.closest('.e360-dashboard-session-card');
        if (!wrap || !card) return;

        var sessionId = card.getAttribute('data-session-id');
        var ajaxUrl = wrap.getAttribute('data-ajax');
        var nonce = wrap.getAttribute('data-nonce');
        var msg = card.querySelector('.e360-session-msg');
        var box = card.querySelector('.e360-session-reschedule-box');
        var notesBox = card.querySelector('.e360-session-notes-box');

        if (btn.classList.contains('e360-session-reschedule-toggle')) {
            if (box) box.style.display = box.style.display === 'none' ? 'block' : 'none';
            return;
        }

        if (btn.classList.contains('e360-session-notes-toggle')) {
            if (notesBox) notesBox.style.display = notesBox.style.display === 'none' ? 'block' : 'none';
            return;
        }

        if (msg) msg.textContent = 'Saving...';

        if (btn.classList.contains('e360-session-complete')) {
            post(ajaxUrl, {
                action: 'e360_dashboard_session_complete',
                nonce: nonce,
                session_id: sessionId
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not update lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not update lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-session-cancel')) {
            if (!window.confirm('Cancel this private lesson?')) {
                if (msg) msg.textContent = '';
                return;
            }
            post(ajaxUrl, {
                action: 'e360_dashboard_session_cancel',
                nonce: nonce,
                session_id: sessionId
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not cancel lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not cancel lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-session-reschedule-save')) {
            var dateInput = card.querySelector('.e360-session-reschedule-date');
            var timeInput = card.querySelector('.e360-session-reschedule-time');
            post(ajaxUrl, {
                action: 'e360_dashboard_session_reschedule',
                nonce: nonce,
                session_id: sessionId,
                date: dateInput ? dateInput.value : '',
                time: timeInput ? timeInput.value : ''
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not reschedule lesson.');
                window.location.reload();
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not reschedule lesson.';
            });
            return;
        }

        if (btn.classList.contains('e360-session-notes-save')) {
            var notesInput = card.querySelector('.e360-session-notes');
            post(ajaxUrl, {
                action: 'e360_dashboard_session_save_notes',
                nonce: nonce,
                session_id: sessionId,
                session_notes: notesInput ? notesInput.value : ''
            }).then(function(resp) {
                if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                    resp.data.message : 'Could not save notes.');
                if (msg) msg.textContent = 'Notes saved.';
            }).catch(function(err) {
                if (msg) msg.textContent = err.message || 'Could not save notes.';
            });
        }
    });
})();
</script>
<?php endif; ?>
<?php if ($mode === 'student') : ?>
<script>
(function() {
    if (window.e360DashboardStudentSessionActionsBound) return;
    window.e360DashboardStudentSessionActionsBound = true;

    function post(url, data) {
        return fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: new URLSearchParams(data).toString()
        }).then(function(r) {
            return r.json();
        });
    }

    function setTimeOptions(selectEl, slots) {
        if (!selectEl) return;
        var list = Array.isArray(slots) ? slots : [];
        if (!list.length) {
            selectEl.innerHTML = '<option value="">No available slots</option>';
            return;
        }
        selectEl.innerHTML = '<option value="">Select…</option>';
        list.forEach(function(slot) {
            var opt = document.createElement('option');
            opt.value = slot;
            opt.textContent = (slot || '').substring(0, 5);
            selectEl.appendChild(opt);
        });
    }

    document.addEventListener('click', function(e) {
        var toggleBtn = e.target.closest('.e360-student-session-reschedule-toggle');
        if (toggleBtn) {
            var card = toggleBtn.closest('.e360-dashboard-session-card');
            var box = card ? card.querySelector('.e360-student-session-reschedule-box') : null;
            if (box) box.style.display = box.style.display === 'none' ? 'block' : 'none';
            return;
        }

        var sendBtn = e.target.closest('.e360-student-session-reschedule-send');
        if (!sendBtn) return;

        var wrap = sendBtn.closest('.e360-dashboard-private-lessons');
        var card = sendBtn.closest('.e360-dashboard-session-card');
        if (!wrap || !card) return;

        var ajaxUrl = wrap.getAttribute('data-ajax');
        var reqNonce = <?php echo wp_json_encode($student_req_nonce); ?>;
        var slotsNonce = <?php echo wp_json_encode($slots_nonce); ?>;
        var bookingId = card.getAttribute('data-booking-id') || '';
        var teacherId = card.getAttribute('data-teacher-id') || '';
        var duration = card.getAttribute('data-duration') || '60';
        var sourceTs = card.getAttribute('data-source-ts') || '';
        var dateEl = card.querySelector('.e360-student-session-date');
        var timeEl = card.querySelector('.e360-student-session-time');
        var reasonEl = card.querySelector('.e360-student-session-reason');
        var availableEl = card.querySelector('.e360-student-session-available');
        var modalMsg = card.querySelector('.e360-student-session-modal-msg');
        var msg = card.querySelector('.e360-session-msg');

        if (e.target === timeEl || e.target.closest('.e360-student-session-date')) {
            return;
        }

        if (!dateEl || !timeEl || !reasonEl) return;
        if (!dateEl.value || !timeEl.value) {
            if (modalMsg) modalMsg.textContent = 'Select date and time';
            return;
        }
        if (!reasonEl.value.trim()) {
            if (modalMsg) modalMsg.textContent = 'Reason is required';
            return;
        }

        if (modalMsg) modalMsg.textContent = 'Sending…';

        post(ajaxUrl, {
            action: 'e360_student_request_reschedule',
            nonce: reqNonce,
            booking_id: bookingId,
            request_type: 'once',
            source_ts_utc: sourceTs,
            date: dateEl.value,
            time: timeEl.value.substring(0, 5),
            reason: reasonEl.value
        }).then(function(resp) {
            if (!resp || !resp.success) throw new Error(resp && resp.data && resp.data.message ?
                resp.data.message : 'Could not send request.');
            if (modalMsg) modalMsg.textContent = '';
            if (msg) msg.textContent = 'Request sent to teacher.';
            var box = card.querySelector('.e360-student-session-reschedule-box');
            if (box) box.style.display = 'none';
        }).catch(function(err) {
            if (modalMsg) modalMsg.textContent = err.message || 'Could not send request.';
        });

        return;
    });

    document.addEventListener('change', function(e) {
        var dateEl = e.target.closest('.e360-student-session-date');
        if (!dateEl) return;

        var wrap = dateEl.closest('.e360-dashboard-private-lessons');
        var card = dateEl.closest('.e360-dashboard-session-card');
        if (!wrap || !card) return;

        var ajaxUrl = wrap.getAttribute('data-ajax');
        var teacherId = card.getAttribute('data-teacher-id') || '';
        var duration = card.getAttribute('data-duration') || '60';
        var timeEl = card.querySelector('.e360-student-session-time');
        var availableEl = card.querySelector('.e360-student-session-available');
        var modalMsg = card.querySelector('.e360-student-session-modal-msg');
        if (!dateEl.value) {
            setTimeOptions(timeEl, []);
            return;
        }

        if (modalMsg) modalMsg.textContent = 'Loading available time…';
        post(ajaxUrl, {
            action: 'e360_get_slots',
            nonce: <?php echo wp_json_encode($slots_nonce); ?>,
            teacher_id: teacherId,
            date: dateEl.value,
            duration: duration
        }).then(function(resp) {
            var slots = (resp && resp.success && resp.data && Array.isArray(resp.data.slots)) ? resp
                .data.slots : [];
            setTimeOptions(timeEl, slots);
            if (availableEl) {
                availableEl.textContent = slots.length ?
                    'Available slots loaded for selected date.' :
                    'No free slots for selected date.';
            }
            if (modalMsg) modalMsg.textContent = '';
        }).catch(function() {
            setTimeOptions(timeEl, []);
            if (availableEl) availableEl.textContent = 'Could not load available slots.';
            if (modalMsg) modalMsg.textContent = '';
        });
    });
})();
</script>
<?php endif; ?>
<?php

    return (string) ob_get_clean();
}

function e360_render_dashboard_private_lessons_blocks($page): void {
    if (!is_user_logged_in()) {
        return;
    }

    static $rendered = [];

    $user_id = get_current_user_id();
    $context = e360_get_dashboard_page_context();
    $current_page = $context['page'] ?: sanitize_key((string) $page);
    $sub_page = $context['sub_page'] ?: 'overview';
    $render_key = $current_page . ':' . $sub_page . ':' . $user_id;

    if (isset($rendered[$render_key])) {
        return;
    }
    $rendered[$render_key] = true;

    if (current_user_can('tutor_instructor') || current_user_can('manage_options')) {
        if ($current_page === 'dashboard') {
            echo e360_render_teacher_private_metrics_cards($user_id);
            echo e360_render_teacher_students_block($user_id, 8);
            echo e360_render_teacher_programs_block($user_id, 8);

            $sessions = e360_get_user_lesson_sessions('teacher_id', $user_id, [
                'statuses'    => ['scheduled', 'rescheduled'],
                'limit'       => 6,
                'future_only' => true,
            ]);
            if ($sessions) {
                echo e360_render_dashboard_private_lessons_card($sessions, 'teacher');
            }

            echo e360_render_teacher_completed_lessons_block($user_id, 6);
            return;
        }

        if ($current_page === 'analytics') {
            echo e360_render_teacher_private_analytics_sections($user_id, $sub_page);
            return;
        }
        if ($current_page !== 'calendar') {
            return;
        }
    }

    if ($current_page === 'calendar') {
        $is_teacher_calendar = current_user_can('tutor_instructor') || current_user_can('manage_options');
        $sessions = e360_get_user_lesson_sessions($is_teacher_calendar ? 'teacher_id' : 'student_id', $user_id, [
            'statuses'    => ['scheduled', 'rescheduled'],
            'limit'       => -1,
            'future_only' => true,
        ]);
        $calendar_session_dates = [];
        $calendar_sessions_by_date = [];
        foreach ($sessions as $session) {
            $when_data = e360_get_private_session_datetime_for_viewer($session, $user_id);
            $date = (string) ($when_data['date'] ?? '');
            $time = (string) ($when_data['time'] ?? '');
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                continue;
            }

            $calendar_session_dates[] = $date;

            $course_title = !empty($session['course_id']) ? get_the_title((int) $session['course_id']) : 'Private lesson';
            $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
            $status = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
            $counterpart = $is_teacher_calendar
                ? (!empty($session['student_id']) ? get_user_by('id', (int) $session['student_id']) : null)
                : (!empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null);
            $lesson_url = e360_get_private_lesson_dashboard_url((int) ($session['ID'] ?? 0));

            $calendar_sessions_by_date[$date][] = [
                'time'    => $time,
                'course'  => $course_title ?: 'Private lesson',
                'teacher' => $teacher ? (string) $teacher->display_name : '—',
                'counterpart' => $counterpart ? (string) $counterpart->display_name : '—',
                'status'  => $status,
                'url'     => $lesson_url,
            ];
        }
        $calendar_session_dates = array_values(array_unique($calendar_session_dates));
        if ($sessions) {
            echo e360_render_dashboard_private_lessons_card($sessions, $is_teacher_calendar ? 'teacher' : 'student');
        } else {
            echo '<div style="margin:0 0 16px;padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;">';
            echo '<div style="font-weight:700;font-size:18px;margin-bottom:8px;">' . esc_html($is_teacher_calendar ? 'Upcoming private lessons' : 'Your upcoming lessons') . '</div>';
            echo '<div style="opacity:.8;">No upcoming private lessons have been confirmed yet.</div>';
            echo '</div>';
        }
        ?>
        <style>
        #tutor_calendar_wrapper .tutor-calendar-date.e360-private-lesson-date,
        #tutor_calendar_wrapper .tutor-calendar-date.e360-private-lesson-date:hover {
            background-color: rgba(34, 113, 177, 0.1);
            border-radius: 4px;
            transform: scale(1.05);
        }
        #tutor_calendar_wrapper .tutor-calendar-date.e360-private-lesson-date a {
            color: var(--tutor-color-primary);
            font-weight: 700;
        }
        #tutor-booking-modal .tutor-modal-actions .tutor-modal-close.tutor-btn-secondary {
            display: none !important;
        }
        .e360-no-teachers-modal {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.45);
        }
        .e360-no-teachers-modal.is-open {
            display: flex;
        }
        .e360-no-teachers-modal__dialog {
            width: min(100%, 480px);
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2);
            padding: 22px;
        }
        .e360-no-teachers-modal__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .e360-no-teachers-modal__title {
            margin: 0;
            font-size: 20px;
            line-height: 1.3;
        }
        .e360-no-teachers-modal__close {
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 22px;
            line-height: 1;
            color: #111827;
            padding: 0;
        }
        .e360-no-teachers-modal__date {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(34, 113, 177, 0.08);
            color: #1f4f7a;
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .e360-no-teachers-modal__text {
            margin: 0;
            color: #374151;
            line-height: 1.55;
        }
        .e360-no-teachers-modal__lessons {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid #eef0f4;
        }
        .e360-no-teachers-modal__lessons-title {
            margin: 0 0 8px;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .e360-no-teachers-modal__lessons-list {
            margin: 0;
            padding-left: 18px;
            color: #374151;
        }
        .e360-no-teachers-modal__lessons-list li {
            margin: 0 0 6px;
        }
        .e360-no-teachers-modal__actions {
            margin-top: 18px;
            display: flex;
            justify-content: flex-end;
        }
        </style>
        <div class="e360-no-teachers-modal" id="e360-no-teachers-modal" aria-hidden="true">
            <div class="e360-no-teachers-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="e360-no-teachers-modal-title">
                <div class="e360-no-teachers-modal__head">
                    <h3 class="e360-no-teachers-modal__title" id="e360-no-teachers-modal-title">No available teachers</h3>
                    <button type="button" class="e360-no-teachers-modal__close" aria-label="Close">&times;</button>
                </div>
                <div class="e360-no-teachers-modal__date" id="e360-no-teachers-modal-date" style="display:none;"></div>
                <p class="e360-no-teachers-modal__text" id="e360-no-teachers-modal-text">No available teachers for this date.</p>
                <div class="e360-no-teachers-modal__lessons" id="e360-no-teachers-modal-lessons" style="display:none;">
                    <div class="e360-no-teachers-modal__lessons-title">Your lessons on this date</div>
                    <ul class="e360-no-teachers-modal__lessons-list" id="e360-no-teachers-modal-lessons-list"></ul>
                </div>
                <div class="e360-no-teachers-modal__actions">
                    <button type="button" class="tutor-btn tutor-btn-primary e360-no-teachers-modal__ok">OK</button>
                </div>
            </div>
        </div>
        <script>
        (function() {
            if (window.e360PrivateCalendarBridgeBound) return;
            window.e360PrivateCalendarBridgeBound = true;

            var privateDates = <?php echo wp_json_encode($calendar_session_dates); ?>;
            var privateSessionsByDate = <?php echo wp_json_encode($calendar_sessions_by_date); ?>;
            var isTeacherCalendar = <?php echo $is_teacher_calendar ? 'true' : 'false'; ?>;
            var privateCalendarAjax = <?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>;
            var privateCalendarNonce = <?php echo wp_json_encode(wp_create_nonce('tutor_nonce')); ?>;

            var originalFetch = window.fetch;
            window.fetch = function(url, options) {
                if (options && options.method === 'POST' && options.body instanceof FormData) {
                    var action = options.body.get('action');
                    if (action === 'get_calendar_materials') {
                        return originalFetch.apply(this, arguments).then(function(response) {
                            return response.clone().json().then(function(data) {
                                if (!data || !data.success || !data.data || !Array.isArray(data.data.response)) {
                                    return response;
                                }

                                var month = parseInt(options.body.get('month') || '0', 10);
                                var year = parseInt(options.body.get('year') || '0', 10);
                                var payload = new FormData();
                                payload.set('action', 'e360_get_private_calendar_materials');
                                payload.set('month', isNaN(month) ? '0' : String(month));
                                payload.set('year', isNaN(year) ? '0' : String(year));
                                var tutorNonce = window.tutor_get_nonce_data ? window.tutor_get_nonce_data(true) : null;
                                if (tutorNonce && tutorNonce.key && tutorNonce.value) {
                                    payload.set(tutorNonce.key, tutorNonce.value);
                                } else {
                                    payload.set('_tutor_nonce', privateCalendarNonce);
                                }

                                return originalFetch(privateCalendarAjax, {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    body: payload
                                }).then(function(extraResponse) {
                                    return extraResponse.json().then(function(extraData) {
                                        if (extraData && extraData.success && extraData.data && Array.isArray(extraData.data.response)) {
                                            data.data.response = data.data.response.concat(extraData.data.response);
                                            data.data.upcoming = Number(data.data.upcoming || 0) + Number(extraData.data.upcoming || 0);
                                            data.data.overdue = Number(data.data.overdue || 0) + Number(extraData.data.overdue || 0);
                                        }

                                        return new Response(JSON.stringify(data), {
                                            status: response.status,
                                            statusText: response.statusText,
                                            headers: {
                                                'Content-Type': 'application/json'
                                            }
                                        });
                                    }).catch(function() {
                                        return response;
                                    });
                                }).catch(function() {
                                    return response;
                                });
                            }).catch(function() {
                                return response;
                            });
                        });
                    }
                }

                return originalFetch.apply(this, arguments);
            };

            function getVisibleMonthYear() {
                var monthEl = document.getElementById('tutor-c-calendar-month');
                var yearEl = document.getElementById('tutor-c-calendar-year');
                if (!monthEl || !yearEl) return null;
                var parsed = new Date((monthEl.textContent || '').trim() + ' 1, ' + (yearEl.textContent || '').trim());
                if (isNaN(parsed.getTime())) return null;
                return {
                    month: parsed.getMonth() + 1,
                    year: parsed.getFullYear()
                };
            }

            function markPrivateLessonDates(events) {
                var monthYear = getVisibleMonthYear();
                if (!monthYear) return;

                var days = {};
                (Array.isArray(events) ? events : []).forEach(function(item) {
                    var rawDate = item && item.zm_start_date ? item.zm_start_date : (item && item.post_date ? item.post_date : '');
                    if (!rawDate || !/^\d{4}-\d{2}-\d{2}$/.test(rawDate)) return;
                    var bits = rawDate.split('-');
                    var year = parseInt(bits[0], 10);
                    var month = parseInt(bits[1], 10);
                    var day = parseInt(bits[2], 10);
                    if (year === monthYear.year && month === monthYear.month && day > 0) {
                        days[day] = true;
                    }
                });

                document.querySelectorAll('#tutor_calendar_wrapper .tutor-calendar-date').forEach(function(node) {
                    node.classList.remove('e360-private-lesson-date');
                    node.style.backgroundColor = '';
                    node.style.borderRadius = '';
                    node.style.transform = '';
                    var text = node.textContent ? node.textContent.trim() : '';
                    var day = parseInt(text, 10);
                    if (!isNaN(day) && days[day]) {
                        node.classList.add('e360-private-lesson-date');
                        node.style.backgroundColor = 'rgba(34, 113, 177, 0.1)';
                        node.style.borderRadius = '4px';
                        node.style.transform = 'scale(1.05)';
                    }
                });
            }

            function loadAndMarkPrivateDates() {
                var events = privateDates.map(function(date) {
                    return { zm_start_date: date };
                });
                markPrivateLessonDates(events);
            }

            function formatDateLabel(date) {
                if (!date || !/^\d{4}-\d{2}-\d{2}$/.test(date)) return date || '';
                var parsed = new Date(date + 'T00:00:00');
                if (isNaN(parsed.getTime())) return date;
                return parsed.toLocaleDateString('en-US', {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric'
                });
            }

            function renderPrivateCalendarListings() {
                var wrapper = document.querySelector('#tutor_calendar_wrapper .tutor-calendar-events-wrapper');
                if (!wrapper) return;

                var monthYear = getVisibleMonthYear();
                if (!monthYear) return;

                var dates = Object.keys(privateSessionsByDate || {}).filter(function(date) {
                    if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) return false;
                    var bits = date.split('-');
                    return parseInt(bits[0], 10) === monthYear.year && parseInt(bits[1], 10) === monthYear.month;
                }).sort();

                if (!dates.length) {
                    var staleHeading = wrapper.querySelector('h5');
                    if (staleHeading && staleHeading.textContent && staleHeading.textContent.trim() === 'Please wait...') {
                        staleHeading.remove();
                    }
                    return;
                }

                var html = '<h5>' + (isTeacherCalendar ? 'Private Lessons' : 'Your Private Lessons') + '</h5>';
                html += '<div class="tutor-calendar-listings-wrapper">';

                dates.forEach(function(date) {
                    var entries = privateSessionsByDate[date] || [];
                    html += '<div class="tutor-event-listing">';
                    html += '<div class="icon-wrapper"><strong>' + formatDateLabel(date) + '</strong></div>';
                    entries.forEach(function(entry) {
                        var title = entry.course || 'Private lesson';
                        if (entry.counterpart) {
                            title += ' — ' + (isTeacherCalendar ? 'Student: ' : 'Teacher: ') + entry.counterpart;
                        }
                        html += '<div class="tutor-event-wrapper upcoming">';
                        html += '<div class="meta-info"><a href="' + (entry.url || '#') + '"><strong>' + (entry.time || '—') + '</strong><span>' + title + '</span></a></div>';
                        html += '<div class="time">' + (entry.status || '') + '</div>';
                        html += '</div>';
                    });
                    html += '</div>';
                });

                html += '</div>';
                wrapper.innerHTML = html;
            }

            var observer = new MutationObserver(function() {
                window.requestAnimationFrame(loadAndMarkPrivateDates);
                window.requestAnimationFrame(renderPrivateCalendarListings);
            });

            function bindObservers() {
                var monthEl = document.getElementById('tutor-c-calendar-month');
                var yearEl = document.getElementById('tutor-c-calendar-year');
                var calendarBody = document.getElementById('calendar_body');
                [monthEl, yearEl, calendarBody].forEach(function(node) {
                    if (node) observer.observe(node, { childList: true, subtree: true, characterData: true });
                });
            }

            window.addEventListener('load', function() {
                bindObservers();
                window.requestAnimationFrame(loadAndMarkPrivateDates);
                window.requestAnimationFrame(renderPrivateCalendarListings);
                window.setTimeout(loadAndMarkPrivateDates, 600);
                window.setTimeout(renderPrivateCalendarListings, 600);
                window.setTimeout(loadAndMarkPrivateDates, 1400);
                window.setTimeout(renderPrivateCalendarListings, 1400);
            });
        })();
        </script>
        <script>
        (function() {
            if (window.e360SchedulingAlertOverrideBound) return;
            window.e360SchedulingAlertOverrideBound = true;

            var modal = document.getElementById('e360-no-teachers-modal');
            var modalText = document.getElementById('e360-no-teachers-modal-text');
            var modalDate = document.getElementById('e360-no-teachers-modal-date');
            var modalLessons = document.getElementById('e360-no-teachers-modal-lessons');
            var modalLessonsList = document.getElementById('e360-no-teachers-modal-lessons-list');
            var lastRequestedDate = '';
            var privateSessionsByDate = <?php echo wp_json_encode($calendar_sessions_by_date); ?>;
            var nativeAlert = typeof window.alert === 'function' ? window.alert.bind(window) : function() {};

            function getVisibleMonthYear() {
                var monthEl = document.getElementById('tutor-c-calendar-month');
                var yearEl = document.getElementById('tutor-c-calendar-year');
                if (!monthEl || !yearEl) return null;
                var parsed = new Date((monthEl.textContent || '').trim() + ' 1, ' + (yearEl.textContent || '').trim());
                if (isNaN(parsed.getTime())) return null;
                return {
                    month: parsed.getMonth() + 1,
                    year: parsed.getFullYear()
                };
            }

            function normalizeDate(date) {
                if (!date || !/^\d{4}-\d{2}-\d{2}$/.test(date)) return '';
                return date;
            }

            function formatDate(date) {
                var normalized = normalizeDate(date);
                if (!normalized) return '';
                var parsed = new Date(normalized + 'T00:00:00');
                if (isNaN(parsed.getTime())) return normalized;
                return parsed.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            function extractDateFromClickTarget(target) {
                if (!target) return '';
                var cell = target.closest('#tutor_calendar_wrapper .tutor-calendar-date, #tutor_calendar_wrapper .tutor-calendar-day, #tutor_calendar_wrapper .tutor-calendar-body > div:not(.space), #tutor_calendar_wrapper .tutor-custom-calendar > div:not(.space)');
                if (!cell) return '';
                var dayMatch = (cell.textContent || '').trim().match(/\b([1-9]|[12][0-9]|3[01])\b/);
                if (!dayMatch) return '';
                var monthYear = getVisibleMonthYear();
                if (!monthYear) return '';
                return [
                    String(monthYear.year),
                    String(monthYear.month).padStart(2, '0'),
                    String(parseInt(dayMatch[1], 10)).padStart(2, '0')
                ].join('-');
            }

            function openNoTeachersModal(date, message) {
                if (!modal) {
                    nativeAlert(message);
                    return;
                }
                var readableDate = formatDate(date);
                if (modalDate) {
                    if (readableDate) {
                        modalDate.textContent = readableDate;
                        modalDate.style.display = 'inline-flex';
                    } else {
                        modalDate.textContent = '';
                        modalDate.style.display = 'none';
                    }
                }
                if (modalText) {
                    modalText.textContent = message || 'No available teachers for this date.';
                }
                if (modalLessons && modalLessonsList) {
                    var entries = date && privateSessionsByDate && privateSessionsByDate[date] ? privateSessionsByDate[date] : [];
                    if (entries.length) {
                        modalLessonsList.innerHTML = '';
                        entries.forEach(function(entry) {
                            var li = document.createElement('li');
                            var parts = [];
                            if (entry.time) parts.push(entry.time);
                            if (entry.course) parts.push(entry.course);
                            if (entry.teacher) parts.push('Teacher: ' + entry.teacher);
                            if (entry.status) parts.push(entry.status);
                            li.textContent = parts.join(' • ');
                            modalLessonsList.appendChild(li);
                        });
                        modalLessons.style.display = 'block';
                    } else {
                        modalLessonsList.innerHTML = '';
                        modalLessons.style.display = 'none';
                    }
                }
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeNoTeachersModal() {
                if (!modal) return;
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            }

            function hideTutorBookingCancelButton() {
                var cancelBtn = document.querySelector('#tutor-booking-modal .tutor-modal-actions .tutor-modal-close.tutor-btn-secondary');
                if (cancelBtn) {
                    cancelBtn.style.display = 'none';
                }
            }

            document.addEventListener('click', function(e) {
                var clickedDate = extractDateFromClickTarget(e.target);
                if (clickedDate) {
                    lastRequestedDate = clickedDate;
                }

                window.setTimeout(hideTutorBookingCancelButton, 60);

                if (!modal) return;
                if (e.target === modal || e.target.closest('.e360-no-teachers-modal__close') || e.target.closest('.e360-no-teachers-modal__ok')) {
                    closeNoTeachersModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeNoTeachersModal();
                }
            });

            if (window.jQuery) {
                window.jQuery(document).ajaxSend(function(_event, _xhr, settings) {
                    var rawData = settings && settings.data ? settings.data : '';
                    var params = new URLSearchParams(typeof rawData === 'string' ? rawData : '');
                    if (params.get('action') === 'tutor_scheduling_get_available_teachers') {
                        var requestedDate = normalizeDate(params.get('date') || '');
                        if (requestedDate) {
                            lastRequestedDate = requestedDate;
                        }
                    }
                });
            }

            var bookingModalObserver = new MutationObserver(function() {
                hideTutorBookingCancelButton();
            });

            bookingModalObserver.observe(document.body, {
                childList: true,
                subtree: true
            });

            window.alert = function(message) {
                var text = typeof message === 'string' ? message : '';
                if (text.indexOf('No available teachers for this date.') !== -1) {
                    openNoTeachersModal(lastRequestedDate, 'No available teachers for this date.');
                    return;
                }
                nativeAlert(message);
            };
        })();
        </script>
        <?php
        return;
    }

    if ($current_page !== 'dashboard') {
        return;
    }

    echo e360_render_student_private_metrics_cards($user_id);
    echo e360_render_student_teacher_program_block($user_id);

    $sessions = e360_get_user_lesson_sessions('student_id', $user_id, [
        'statuses'    => ['scheduled', 'rescheduled'],
        'limit'       => 6,
        'future_only' => true,
    ]);
    if ($sessions) {
        echo e360_render_dashboard_private_lessons_card($sessions, 'student');
    }

    echo e360_render_student_history_block($user_id, 10);
}
add_action('tutor_load_dashboard_template_before', 'e360_render_dashboard_private_lessons_blocks', 8, 1);

function e360_dashboard_can_manage_session(array $session, int $user_id): bool {
    if ($user_id <= 0 || !$session) {
        return false;
    }

    if (current_user_can('manage_options')) {
        return true;
    }

    return current_user_can('tutor_instructor') && (int) ($session['teacher_id'] ?? 0) === $user_id;
}

function e360_reschedule_session_and_booking(int $session_id, string $date, string $time): bool {
    $session = e360_get_lesson_session($session_id);
    if (!$session) {
        return false;
    }

    $date = sanitize_text_field($date);
    $time = substr(sanitize_text_field($time), 0, 5);
    if ($date === '' || $time === '') {
        return false;
    }

    $booking_id = (int) ($session['source_booking_id'] ?? 0);
    $teacher_id = (int) ($session['teacher_id'] ?? 0);
    $duration = max(1, (int) ($session['duration'] ?? 60));
    $repeat = (string) get_post_meta($booking_id, 'repeat', true);
    $repeat = $repeat === 'weekly' ? 'weekly' : 'once';

    if ($booking_id > 0 && get_post_type($booking_id) === 'e360_booking') {
        $tz = new DateTimeZone(function_exists('e360_get_teacher_timezone_string') ? e360_get_teacher_timezone_string($teacher_id) : 'UTC');

        if ($repeat === 'once') {
            $dtLocal = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $time, $tz);
            if (!$dtLocal) {
                return false;
            }

            $startUtc = (int) $dtLocal->setTimezone(new DateTimeZone('UTC'))->getTimestamp();
            $endUtc   = $startUtc + ($duration * 60);

            if (function_exists('e360_booking_conflict_once') && e360_booking_conflict_once($teacher_id, $startUtc, $endUtc, $booking_id)) {
                return false;
            }

            update_post_meta($booking_id, 'start_ts_utc', $startUtc);
            update_post_meta($booking_id, 'end_ts_utc', $endUtc);
            update_post_meta($booking_id, 'local_date', $date);
            update_post_meta($booking_id, 'local_time', $time);
        } else {
            if (!function_exists('e360_weekday_key_from_date') || !function_exists('e360_minutes_from_hhmm')) {
                return false;
            }

            $weekday = e360_weekday_key_from_date($date, $tz);
            $startMin = e360_minutes_from_hhmm($time);
            $endMin = $startMin + $duration;

            if (function_exists('e360_booking_conflict_weekly') && e360_booking_conflict_weekly($teacher_id, $weekday, $startMin, $endMin, $booking_id)) {
                return false;
            }

            update_post_meta($booking_id, 'weekday', $weekday);
            update_post_meta($booking_id, 'start_min', $startMin);
            update_post_meta($booking_id, 'end_min', $endMin);
            update_post_meta($booking_id, 'start_date', $date);
        }

        do_action('e360_booking_saved', $booking_id);
    }

    $changes = [
        'lesson_date' => $date,
        'lesson_time' => $time,
    ];

    return e360_update_lesson_session_status($session_id, 'rescheduled', $changes);
}

function e360_handle_dashboard_session_complete(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_dashboard_can_manage_session($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    if (!e360_update_lesson_session_status($session_id, 'completed')) {
        wp_send_json_error(['message' => 'Could not mark lesson completed.'], 500);
    }

    wp_send_json_success(['message' => 'Lesson completed.']);
}
add_action('wp_ajax_e360_dashboard_session_complete', 'e360_handle_dashboard_session_complete');

function e360_handle_dashboard_session_cancel(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_dashboard_can_manage_session($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $booking_id = (int) ($session['source_booking_id'] ?? 0);
    if ($booking_id > 0 && get_post_type($booking_id) === 'e360_booking') {
        wp_trash_post($booking_id);
        wp_send_json_success(['message' => 'Lesson cancelled.']);
    }

    if (!e360_update_lesson_session_status($session_id, 'cancelled')) {
        wp_send_json_error(['message' => 'Could not cancel lesson.'], 500);
    }

    wp_send_json_success(['message' => 'Lesson cancelled.']);
}
add_action('wp_ajax_e360_dashboard_session_cancel', 'e360_handle_dashboard_session_cancel');

function e360_handle_dashboard_session_reschedule(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $date = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $time = isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '';
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_dashboard_can_manage_session($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    if (!e360_reschedule_session_and_booking($session_id, $date, $time)) {
        wp_send_json_error(['message' => 'Could not reschedule lesson. Check date/time or teacher availability.'], 409);
    }

    wp_send_json_success(['message' => 'Lesson rescheduled.']);
}
add_action('wp_ajax_e360_dashboard_session_reschedule', 'e360_handle_dashboard_session_reschedule');

function e360_handle_dashboard_session_sync_zoom(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_dashboard_can_manage_session($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    if (!e360_sync_session_zoom_meeting($session_id)) {
        $error = (string) get_post_meta($session_id, 'zoom_sync_error', true);
        wp_send_json_error(['message' => $error !== '' ? $error : 'Could not sync Zoom meeting.'], 500);
    }

    wp_send_json_success(['message' => 'Zoom meeting synced.']);
}
add_action('wp_ajax_e360_dashboard_session_sync_zoom', 'e360_handle_dashboard_session_sync_zoom');

function e360_handle_dashboard_session_get_collab_state(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_private_lesson_user_can_access($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    wp_send_json_success([
        'thread_html'       => e360_render_private_lesson_collab_thread_html($session),
        'teacher_notes'    => (string) ($session['session_notes'] ?? ''),
        'teacher_homework' => (string) ($session['homework'] ?? ''),
        'student_notes'    => (string) ($session['student_session_notes'] ?? ''),
        'student_homework' => (string) ($session['student_homework'] ?? ''),
    ]);
}
add_action('wp_ajax_e360_dashboard_session_get_collab_state', 'e360_handle_dashboard_session_get_collab_state');

function e360_handle_dashboard_session_add_note_entry(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_private_lesson_user_can_access($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $note_text = isset($_POST['note_text']) ? sanitize_textarea_field(wp_unslash($_POST['note_text'])) : '';
    $attachments = [];

    if (!empty($_FILES['attachments'])) {
        $attachments = e360_handle_private_lesson_note_uploads($_FILES['attachments']);
        if (is_wp_error($attachments)) {
            wp_send_json_error(['message' => $attachments->get_error_message()], 400);
        }
    }

    $saved = e360_add_private_lesson_collab_entry($session_id, $session, $note_text, get_current_user_id(), $attachments);
    if (is_wp_error($saved)) {
        wp_send_json_error(['message' => $saved->get_error_message()], 400);
    }

    $fresh_session = e360_get_lesson_session($session_id);
    wp_send_json_success([
        'message'     => 'Note saved.',
        'thread_html' => e360_render_private_lesson_collab_thread_html($fresh_session ?: $session),
    ]);
}
add_action('wp_ajax_e360_dashboard_session_add_note_entry', 'e360_handle_dashboard_session_add_note_entry');

function e360_handle_dashboard_session_save_notes(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_private_lesson_user_can_access($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $notes = isset($_POST['session_notes']) ? sanitize_textarea_field(wp_unslash($_POST['session_notes'])) : '';
    $user_id = get_current_user_id();
    $is_teacher = current_user_can('tutor_instructor') || current_user_can('manage_options');

    if ($is_teacher) {
        $existing = (string) ($session['session_notes'] ?? '');
        $updated = array_merge($session, [
            'session_notes' => e360_append_private_lesson_note_entry($existing, $notes, $user_id),
        ]);
    } else {
        $existing = (string) ($session['student_session_notes'] ?? '');
        $updated = array_merge($session, [
            'student_session_notes' => e360_append_private_lesson_note_entry($existing, $notes, $user_id),
        ]);
    }

    $saved = e360_save_lesson_session($updated, $session_id);
    if (is_wp_error($saved) || (int) $saved <= 0) {
        wp_send_json_error(['message' => 'Could not save notes.'], 500);
    }

    wp_send_json_success(['message' => 'Notes saved.']);
}
add_action('wp_ajax_e360_dashboard_session_save_notes', 'e360_handle_dashboard_session_save_notes');

function e360_handle_dashboard_session_save_homework(): void {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in'], 401);
    }
    check_ajax_referer('e360_dashboard_session', 'nonce');

    $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
    $session = e360_get_lesson_session($session_id);
    if (!$session || !e360_private_lesson_user_can_access($session, get_current_user_id())) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $homework = isset($_POST['homework']) ? sanitize_textarea_field(wp_unslash($_POST['homework'])) : '';
    $user_id = get_current_user_id();
    $is_teacher = current_user_can('tutor_instructor') || current_user_can('manage_options');

    if ($is_teacher) {
        $existing = (string) ($session['homework'] ?? '');
        $updated = array_merge($session, [
            'homework' => e360_append_private_lesson_note_entry($existing, $homework, $user_id),
        ]);
    } else {
        $existing = (string) ($session['student_homework'] ?? '');
        $updated = array_merge($session, [
            'student_homework' => e360_append_private_lesson_note_entry($existing, $homework, $user_id),
        ]);
    }

    $saved = e360_save_lesson_session($updated, $session_id);
    if (is_wp_error($saved) || (int) $saved <= 0) {
        wp_send_json_error(['message' => 'Could not save homework.'], 500);
    }

    wp_send_json_success(['message' => 'Homework saved.']);
}
add_action('wp_ajax_e360_dashboard_session_save_homework', 'e360_handle_dashboard_session_save_homework');

function e360_get_private_calendar_events(int $user_id, int $month, int $year): array {
    if ($user_id <= 0 || $month < 1 || $month > 12 || $year < 1970) {
        return [];
    }

    $user_field = (user_can($user_id, 'tutor_instructor') || user_can($user_id, 'manage_options')) ? 'teacher_id' : 'student_id';
    $sessions = e360_get_user_lesson_sessions($user_field, $user_id, [
        'statuses' => ['scheduled', 'rescheduled'],
        'limit'    => -1,
    ]);
    if (!$sessions) {
        return [];
    }

    $events = [];
    foreach ($sessions as $session) {
        $when_data = e360_get_private_session_datetime_for_viewer($session, $user_id);
        $lesson_date = (string) ($when_data['date'] ?? '');
        $lesson_time = (string) ($when_data['time'] ?? '');
        if ($lesson_date === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $lesson_date)) {
            continue;
        }

        $date_bits = explode('-', $lesson_date);
        if ((int) ($date_bits[0] ?? 0) !== $year || (int) ($date_bits[1] ?? 0) !== $month) {
            continue;
        }

        $course_id = (int) ($session['course_id'] ?? 0);
        $teacher_id = (int) ($session['teacher_id'] ?? 0);
        $teacher = $teacher_id > 0 ? get_user_by('id', $teacher_id) : null;
        $student_id = (int) ($session['student_id'] ?? 0);
        $student = $student_id > 0 ? get_user_by('id', $student_id) : null;
        $lesson_url = e360_get_private_lesson_dashboard_url((int) ($session['ID'] ?? 0));
        $title_parts = [];
        $course_title = $course_id > 0 ? get_the_title($course_id) : 'Private Lesson';
        if ($course_title !== '') {
            $title_parts[] = $course_title;
        }
        if ($user_field === 'teacher_id' && $student && !empty($student->display_name)) {
            $title_parts[] = 'with ' . $student->display_name;
        } elseif ($teacher && !empty($teacher->display_name)) {
            $title_parts[] = 'with ' . $teacher->display_name;
        }

        $events[] = [
            'ID'              => (int) ($session['ID'] ?? 0),
            'post_type'       => 'tutor_zoom_meeting',
            'post_title'      => 'Private Lesson: ' . implode(' ', $title_parts),
            'post_date'       => $lesson_date,
            'month'           => gmdate('m', strtotime($lesson_date)),
            'created_at'      => $lesson_date,
            'guid'            => $lesson_url,
            'zoom_meeting_at' => trim($lesson_date . ' ' . ($lesson_time !== '' ? $lesson_time : '00:00')),
            'zm_start_date'   => $lesson_date,
            'meta_info'       => [
                'expire_date' => trim($lesson_date . ' ' . ($lesson_time !== '' ? $lesson_time : '00:00')),
                'is_expired'  => false,
            ],
        ];
    }

    return $events;
}

function e360_handle_private_calendar_materials(): void {
    if (!is_user_logged_in()) {
        wp_send_json_success(['response' => [], 'upcoming' => 0, 'overdue' => 0]);
    }

    $month = isset($_POST['month']) ? (int) wp_unslash($_POST['month']) : 0;
    $year = isset($_POST['year']) ? (int) wp_unslash($_POST['year']) : 0;
    $month = $month + 1;
    $events = e360_get_private_calendar_events(get_current_user_id(), $month, $year);

    wp_send_json_success([
        'response' => $events,
        'upcoming' => count($events),
        'overdue'  => 0,
    ]);
}
add_action('wp_ajax_e360_get_private_calendar_materials', 'e360_handle_private_calendar_materials');

function e360_get_program_summary(int $program_id): array {
    $program = e360_get_program($program_id);
    if (!$program) {
        return [];
    }

    $sessions = e360_get_program_sessions($program_id, ['orderby' => 'lesson_date', 'order' => 'ASC']);
    $summary = [
        'program_id'          => $program_id,
        'session_count'       => 0,
        'scheduled_count'     => 0,
        'completed_count'     => 0,
        'cancelled_count'     => 0,
        'missed_count'        => 0,
        'rescheduled_count'   => 0,
        'total_minutes'       => 0,
        'completed_minutes'   => 0,
        'next_session_id'     => 0,
        'next_lesson_date'    => '',
        'next_lesson_time'    => '',
        'last_session_id'     => 0,
        'last_lesson_date'    => '',
        'last_lesson_time'    => '',
    ];

    $now_stamp = current_time('Y-m-d H:i');
    $future = [];
    $past = [];

    foreach ($sessions as $session) {
        $summary['session_count']++;
        $status = (string) ($session['session_status'] ?? 'scheduled');
        $duration = (int) ($session['duration'] ?? 0);
        $date = (string) ($session['lesson_date'] ?? '');
        $time = (string) ($session['lesson_time'] ?? '');
        $stamp = trim($date . ' ' . $time);

        $summary['total_minutes'] += max(0, $duration);

        if ($status === 'scheduled') {
            $summary['scheduled_count']++;
        } elseif ($status === 'completed') {
            $summary['completed_count']++;
            $summary['completed_minutes'] += max(0, $duration);
        } elseif ($status === 'cancelled') {
            $summary['cancelled_count']++;
        } elseif ($status === 'missed') {
            $summary['missed_count']++;
        } elseif ($status === 'rescheduled') {
            $summary['rescheduled_count']++;
        }

        if ($date === '') {
            continue;
        }

        if ($status === 'scheduled' && $stamp !== '' && $stamp >= $now_stamp) {
            $future[] = ['id' => (int) $session['ID'], 'date' => $date, 'time' => $time, 'stamp' => $stamp];
        }

        if (in_array($status, ['completed', 'missed', 'cancelled', 'rescheduled'], true) && $stamp !== '') {
            $past[] = ['id' => (int) $session['ID'], 'date' => $date, 'time' => $time, 'stamp' => $stamp];
        }
    }

    if ($future) {
        usort($future, static function(array $a, array $b): int {
            return strcmp($a['stamp'], $b['stamp']);
        });
        $summary['next_session_id']  = (int) $future[0]['id'];
        $summary['next_lesson_date'] = (string) $future[0]['date'];
        $summary['next_lesson_time'] = (string) $future[0]['time'];
    }

    if ($past) {
        usort($past, static function(array $a, array $b): int {
            return strcmp($b['stamp'], $a['stamp']);
        });
        $summary['last_session_id']  = (int) $past[0]['id'];
        $summary['last_lesson_date'] = (string) $past[0]['date'];
        $summary['last_lesson_time'] = (string) $past[0]['time'];
    }

    return $summary;
}

function e360_reassign_program_teacher(int $program_id, int $teacher_id, array $opts = []): bool {
    if ($program_id <= 0 || $teacher_id <= 0) {
        return false;
    }

    $program = e360_get_program($program_id);
    if (!$program) {
        return false;
    }

    $old_teacher_id = (int) ($program['teacher_id'] ?? 0);
    if ($old_teacher_id === $teacher_id) {
        return true;
    }

    $course_id = (int) ($program['course_id'] ?? 0);
    if (!e360_private_learning_can_assign_teacher($teacher_id, $course_id)) {
        return false;
    }

    $defaults = [
        'sync_bookings'          => true,
        'sync_scheduled_sessions'=> true,
    ];
    $opts = wp_parse_args($opts, $defaults);

    $program['teacher_id'] = $teacher_id;
    $saved = e360_save_program($program, $program_id);
    if (is_wp_error($saved) || $saved <= 0) {
        return false;
    }

    if (!empty($opts['sync_bookings'])) {
        $booking_ids = get_posts([
            'post_type'      => 'e360_booking',
            'post_status'    => ['publish', 'pending'],
            'numberposts'    => -1,
            'fields'         => 'ids',
            'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => 'e360_program_id',
                    'value'   => $program_id,
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ],
                [
                    'key'     => 'teacher_id',
                    'value'   => $old_teacher_id,
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ],
            ],
        ]);

        foreach ($booking_ids as $booking_id) {
            update_post_meta((int) $booking_id, 'teacher_id', $teacher_id);
            do_action('e360_booking_saved', (int) $booking_id);
        }
    }

    if (!empty($opts['sync_scheduled_sessions'])) {
        $sessions = e360_get_program_sessions($program_id, ['statuses' => ['scheduled']]);
        foreach ($sessions as $session) {
            $session['teacher_id'] = $teacher_id;
            e360_save_lesson_session($session, (int) $session['ID']);
        }
    }

    return true;
}

function e360_find_program_id(int $student_id, int $course_id, int $teacher_id, array $statuses = ['active', 'paused']): int {
    if ($student_id <= 0 || $course_id <= 0 || $teacher_id <= 0) {
        return 0;
    }

    $statuses = array_values(array_filter(array_map('sanitize_key', $statuses)));
    if (!$statuses) {
        $statuses = ['active', 'paused'];
    }

    $q = get_posts([
        'post_type'      => e360_program_post_type(),
        'post_status'    => 'publish',
        'numberposts'    => 1,
        'orderby'        => 'ID',
        'order'          => 'DESC',
        'fields'         => 'ids',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => 'student_id',
                'value'   => $student_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'course_id',
                'value'   => $course_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'teacher_id',
                'value'   => $teacher_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'status',
                'value'   => $statuses,
                'compare' => 'IN',
            ],
        ],
    ]);

    return !empty($q[0]) ? (int) $q[0] : 0;
}

function e360_get_tutor_enrollment_id(int $student_id, int $course_id): int {
    if ($student_id <= 0 || $course_id <= 0 || !function_exists('tutor_utils')) {
        return 0;
    }

    $utils = tutor_utils();
    if (!is_object($utils) || !method_exists($utils, 'is_enrolled')) {
        return 0;
    }

    try {
        $enrolled = $utils->is_enrolled($course_id, $student_id);
        if (is_object($enrolled) && !empty($enrolled->ID)) {
            return (int) $enrolled->ID;
        }
    } catch (Throwable $e) {
    }

    return 0;
}

function e360_ensure_tutor_enrollment(int $student_id, int $course_id, int $order_id = 0): int {
    if ($student_id <= 0 || $course_id <= 0 || !function_exists('tutor_utils')) {
        return 0;
    }

    $utils = tutor_utils();
    if (!is_object($utils) || !method_exists($utils, 'do_enroll')) {
        return 0;
    }

    $enrollment_id = e360_get_tutor_enrollment_id($student_id, $course_id);
    if ($enrollment_id <= 0) {
        $enrollment_id = (int) $utils->do_enroll($course_id, $order_id, $student_id);
    }

    if ($enrollment_id <= 0) {
        return 0;
    }

    $status = get_post_status($enrollment_id);
    if ($status !== 'completed' && method_exists($utils, 'course_enrol_status_change')) {
        $utils->course_enrol_status_change($enrollment_id, 'completed');
    }

    if ($order_id > 0) {
        update_post_meta($enrollment_id, '_tutor_enrolled_by_order_id', $order_id);
    }

    return $enrollment_id;
}

function e360_find_lesson_session_id_by_booking(int $booking_id): int {
    if ($booking_id <= 0) {
        return 0;
    }

    $posts = get_posts([
        'post_type'      => e360_lesson_session_post_type(),
        'post_status'    => 'publish',
        'numberposts'    => 1,
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => 'DESC',
        'meta_query'     => [
            [
                'key'     => 'source_booking_id',
                'value'   => $booking_id,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
        ],
    ]);

    return !empty($posts[0]) ? (int) $posts[0] : 0;
}

function e360_get_booking_program_id(int $booking_id): int {
    if ($booking_id <= 0) {
        return 0;
    }

    $program_id = (int) get_post_meta($booking_id, 'e360_program_id', true);
    if ($program_id > 0) {
        return $program_id;
    }

    $student_id = (int) get_post_meta($booking_id, 'student_id', true);
    $course_id  = (int) get_post_meta($booking_id, 'course_id', true);
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);

    if ($student_id <= 0 || $course_id <= 0 || $teacher_id <= 0) {
        return 0;
    }

    return e360_find_program_id($student_id, $course_id, $teacher_id, ['active', 'paused', 'completed']);
}

function e360_resolve_program_id_for_booking_context(int $student_id, int $course_id, int $teacher_id, array $ctx = []): int {
    if ($student_id <= 0 || $course_id <= 0 || $teacher_id <= 0) {
        return 0;
    }

    $ctx_program_id = (int) ($ctx['program_id'] ?? 0);
    if ($ctx_program_id > 0) {
        $program = e360_get_program($ctx_program_id);
        if ($program
            && (int) ($program['student_id'] ?? 0) === $student_id
            && (int) ($program['course_id'] ?? 0) === $course_id
            && (int) ($program['teacher_id'] ?? 0) === $teacher_id) {
            return $ctx_program_id;
        }
    }

    $primary_program_id = (int) get_user_meta($student_id, 'e360_primary_program_id', true);
    if ($primary_program_id > 0) {
        $program = e360_get_program($primary_program_id);
        if ($program
            && (int) ($program['course_id'] ?? 0) === $course_id
            && (int) ($program['teacher_id'] ?? 0) === $teacher_id) {
            return $primary_program_id;
        }
    }

    return e360_find_program_id($student_id, $course_id, $teacher_id, ['active', 'paused', 'completed']);
}

function e360_link_booking_to_program(int $booking_id, int $program_id = 0): int {
    $booking_id = (int) $booking_id;
    if ($booking_id <= 0) {
        return 0;
    }

    if ($program_id <= 0) {
        $program_id = e360_get_booking_program_id($booking_id);
    }

    if ($program_id <= 0) {
        return 0;
    }

    update_post_meta($booking_id, 'e360_program_id', $program_id);
    return $program_id;
}

function e360_backfill_program_bookings(int $program_id): array {
    $program = e360_get_program($program_id);
    if (!$program) {
        return [];
    }

    $booking_ids = get_posts([
        'post_type'      => 'e360_booking',
        'post_status'    => ['publish', 'pending', 'trash'],
        'numberposts'    => -1,
        'fields'         => 'ids',
        'orderby'        => 'ID',
        'order'          => 'ASC',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => 'student_id',
                'value'   => (int) $program['student_id'],
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'teacher_id',
                'value'   => (int) $program['teacher_id'],
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
            [
                'key'     => 'course_id',
                'value'   => (int) $program['course_id'],
                'compare' => '=',
                'type'    => 'NUMERIC',
            ],
        ],
    ]);

    $linked = [];
    foreach ($booking_ids as $booking_id) {
        if (e360_link_booking_to_program((int) $booking_id, $program_id) > 0) {
            $linked[] = (int) $booking_id;
        }
    }

    return array_values(array_unique($linked));
}

function e360_get_lesson_session_data_from_booking(int $booking_id, int $program_id = 0, int $order_id = 0): array {
    $booking = get_post($booking_id);
    if (!$booking || $booking->post_type !== 'e360_booking') {
        return [];
    }

    $student_id = (int) get_post_meta($booking_id, 'student_id', true);
    $teacher_id = (int) get_post_meta($booking_id, 'teacher_id', true);
    $course_id  = (int) get_post_meta($booking_id, 'course_id', true);
    $repeat     = (string) get_post_meta($booking_id, 'repeat', true);
    $duration   = (int) get_post_meta($booking_id, 'duration_min', true);
    $duration   = $duration > 0 ? $duration : 60;

    if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
        return [];
    }

    if ($program_id <= 0) {
        $program_id = e360_get_booking_program_id($booking_id);
    }

    $enrollment_id = e360_get_tutor_enrollment_id($student_id, $course_id);

    $session_status = $booking->post_status === 'trash' ? 'cancelled' : 'scheduled';
    $lesson_date    = '';
    $lesson_time    = '';
    $repeat_type    = ($repeat === 'once') ? 'once' : 'weekly';

    if ($repeat_type === 'once') {
        $lesson_date = sanitize_text_field((string) get_post_meta($booking_id, 'local_date', true));
        $lesson_time = sanitize_text_field((string) get_post_meta($booking_id, 'local_time', true));
    } else {
        $lesson_date = sanitize_text_field((string) get_post_meta($booking_id, 'start_date', true));
        $start_min   = (int) get_post_meta($booking_id, 'start_min', true);
        if ($start_min >= 0 && $start_min <= 1439 && function_exists('e360_hhmm_from_minutes')) {
            $lesson_time = (string) e360_hhmm_from_minutes($start_min);
        }
    }

    return [
        'program_id'        => $program_id,
        'student_id'        => $student_id,
        'teacher_id'        => $teacher_id,
        'course_id'         => $course_id,
        'order_id'          => $order_id > 0 ? $order_id : (int) get_post_meta($booking_id, 'e360_order_id', true),
        'lesson_date'       => $lesson_date,
        'lesson_time'       => $lesson_time,
        'duration'          => $duration,
        'repeat_type'       => $repeat_type,
        'session_status'    => $session_status,
        'source_booking_id' => $booking_id,
        'source_enrollment_id' => $enrollment_id,
    ];
}

function e360_sync_lesson_session_from_booking(int $booking_id, int $program_id = 0, int $order_id = 0): int {
    $data = e360_get_lesson_session_data_from_booking($booking_id, $program_id, $order_id);
    if (!$data) {
        return 0;
    }

    $session_id = e360_find_lesson_session_id_by_booking($booking_id);
    $session_id = e360_save_lesson_session($data, $session_id);
    if (is_wp_error($session_id) || $session_id <= 0) {
        return 0;
    }

    if ($program_id <= 0) {
        $program_id = (int) ($data['program_id'] ?? 0);
    }

    if ($program_id > 0) {
        e360_link_booking_to_program($booking_id, $program_id);
    }
    update_post_meta($booking_id, 'e360_lesson_session_id', (int) $session_id);

    return (int) $session_id;
}

function e360_sync_program_bookings(int $program_id, int $order_id = 0): array {
    $program = e360_get_program($program_id);
    if (!$program) {
        return [];
    }

    $student_id = (int) ($program['student_id'] ?? 0);
    $teacher_id = (int) ($program['teacher_id'] ?? 0);
    $course_id  = (int) ($program['course_id'] ?? 0);
    if ($student_id <= 0 || $teacher_id <= 0 || $course_id <= 0) {
        return [];
    }

    $booking_ids = e360_backfill_program_bookings($program_id);

    $session_ids = [];
    foreach ($booking_ids as $booking_id) {
        $session_id = e360_sync_lesson_session_from_booking((int) $booking_id, $program_id, $order_id);
        if ($session_id > 0) {
            $session_ids[] = $session_id;
        }
    }

    return array_values(array_unique(array_map('intval', $session_ids)));
}

function e360_get_order_program_context(WC_Order $order): array {
    $ctx = $order->get_meta('_e360_booking_context');
    if (!is_array($ctx)) {
        $ctx = [];
    }

    $student_id = (int) $order->get_user_id();
    $course_id  = (int) ($ctx['course_id'] ?? 0);
    $teacher_id = (int) ($ctx['teacher_id'] ?? 0);
    $plan_id    = (int) ($ctx['plan_product_id'] ?? 0);

    $credits_added = 0;

    foreach ($order->get_items() as $item) {
        if (!$item instanceof WC_Order_Item_Product) {
            continue;
        }

        $product = $item->get_product();
        if (!$product) {
            continue;
        }

        $product_id = (int) $product->get_id();
        $qty = max(1, (int) $item->get_quantity());
        $item_course_id = (int) $item->get_meta('e360_course_id', true);
        if ($course_id <= 0 && $item_course_id > 0) {
            $course_id = $item_course_id;
        }
        if ($plan_id <= 0) {
            $ptype = sanitize_key((string) get_post_meta($product_id, 'e360_product_type', true));
            if (in_array($ptype, ['trial', 'single', 'package'], true)) {
                $plan_id = $product_id;
            }
        }

        if ($course_id > 0 && $item_course_id > 0 && $item_course_id !== $course_id) {
            continue;
        }

        if (function_exists('e360_get_product_credits_qty')) {
            $credits_added += max(0, (int) e360_get_product_credits_qty($product_id)) * $qty;
        }
    }

    if ($teacher_id <= 0 && $student_id > 0) {
        $teacher_id = (int) get_user_meta($student_id, 'e360_primary_teacher_id', true);
    }
    if ($course_id <= 0 && $student_id > 0) {
        $course_id = (int) get_user_meta($student_id, 'e360_primary_course_id', true);
    }

    return [
        'student_id'       => $student_id,
        'teacher_id'       => $teacher_id,
        'course_id'        => $course_id,
        'language_term_id' => (int) ($ctx['language_term_id'] ?? 0),
        'level_term_id'    => (int) ($ctx['level_term_id'] ?? 0),
        'plan_product_id'  => $plan_id,
        'order_id'         => (int) $order->get_id(),
        'booking_format'   => sanitize_key((string) ($ctx['booking_format'] ?? '')),
        'start_date'       => sanitize_text_field((string) ($ctx['date'] ?? '')),
        'timezone'         => $student_id > 0 ? (string) get_user_option('timezone_string', $student_id) : '',
        'price_paid'       => (float) $order->get_total(),
        'currency'         => sanitize_text_field((string) $order->get_currency()),
        'credits_added'    => $credits_added,
    ];
}

function e360_sync_program_credit_totals(int $program_id): void {
    $program = e360_get_program($program_id);
    if (!$program) {
        return;
    }

    $student_id = (int) ($program['student_id'] ?? 0);
    $course_id  = (int) ($program['course_id'] ?? 0);
    if ($student_id <= 0 || $course_id <= 0) {
        return;
    }

    if (!function_exists('e360_get_credits_total') || !function_exists('e360_get_credits_used') || !function_exists('e360_get_credits_balance')) {
        return;
    }

    update_post_meta($program_id, 'total_credits', (int) e360_get_credits_total($student_id, $course_id));
    update_post_meta($program_id, 'used_credits', (int) e360_get_credits_used($student_id, $course_id));
    update_post_meta($program_id, 'remaining_credits', (int) e360_get_credits_balance($student_id, $course_id));
}

function e360_upsert_program_from_order(int $order_id): int {
    if (!function_exists('wc_get_order')) {
        return 0;
    }

    $order = wc_get_order($order_id);
    if (!$order instanceof WC_Order) {
        return 0;
    }

    if ($order->get_meta('_e360_program_synced')) {
        return (int) $order->get_meta('_e360_program_id');
    }

    $ctx = e360_get_order_program_context($order);
    if (($ctx['student_id'] ?? 0) <= 0 || ($ctx['teacher_id'] ?? 0) <= 0 || ($ctx['course_id'] ?? 0) <= 0) {
        return 0;
    }

    $enrollment_id = e360_ensure_tutor_enrollment((int) $ctx['student_id'], (int) $ctx['course_id'], (int) $ctx['order_id']);

    $existing_id = e360_find_program_id((int) $ctx['student_id'], (int) $ctx['course_id'], (int) $ctx['teacher_id']);
    $existing = $existing_id > 0 ? e360_get_program($existing_id) : [];

    $program_data = [
        'student_id'       => (int) $ctx['student_id'],
        'teacher_id'       => (int) $ctx['teacher_id'],
        'course_id'        => (int) $ctx['course_id'],
        'language_term_id' => (int) $ctx['language_term_id'],
        'level_term_id'    => (int) $ctx['level_term_id'],
        'plan_product_id'  => (int) $ctx['plan_product_id'],
        'order_id'         => (int) $ctx['order_id'],
        'booking_format'   => (string) $ctx['booking_format'],
        'status'           => !empty($existing['status']) ? (string) $existing['status'] : 'active',
        'start_date'       => !empty($existing['start_date']) ? (string) $existing['start_date'] : (string) $ctx['start_date'],
        'end_date'         => !empty($existing['end_date']) ? (string) $existing['end_date'] : '',
        'timezone'         => (string) ($ctx['timezone'] ?: ($existing['timezone'] ?? '')),
        'price_paid'       => (float) $ctx['price_paid'],
        'teacher_rate'     => isset($existing['teacher_rate']) ? (float) $existing['teacher_rate'] : 0,
        'currency'         => (string) ($ctx['currency'] ?: ($existing['currency'] ?? '')),
        'notes'            => (string) ($existing['notes'] ?? ''),
    ];

    $program_id = e360_upsert_program($program_data, $existing_id);
    if ($program_id <= 0) {
        return 0;
    }

    e360_sync_program_credit_totals((int) $program_id);
    e360_sync_program_bookings((int) $program_id, (int) $ctx['order_id']);

    $order->update_meta_data('_e360_program_id', (int) $program_id);
    $order->update_meta_data('_e360_program_synced', 1);
    if ($enrollment_id > 0) {
        $order->update_meta_data('_e360_tutor_enrollment_id', (int) $enrollment_id);
    }
    $order->save();

    update_user_meta((int) $ctx['student_id'], 'e360_primary_program_id', (int) $program_id);

    return (int) $program_id;
}

add_action('woocommerce_order_status_processing', 'e360_upsert_program_from_order', 40);
add_action('woocommerce_order_status_completed', 'e360_upsert_program_from_order', 40);

function e360_sync_booking_to_program_and_session(int $booking_id): void {
    $booking_id = (int) $booking_id;
    if ($booking_id <= 0) {
        return;
    }

    $program_id = e360_get_booking_program_id($booking_id);
    if ($program_id <= 0) {
        return;
    }

    e360_sync_lesson_session_from_booking($booking_id, $program_id);
}
add_action('e360_booking_saved', 'e360_sync_booking_to_program_and_session', 10, 1);

function e360_sync_booking_session_on_trash(int $post_id): void {
    $post_id = (int) $post_id;
    if ($post_id <= 0 || get_post_type($post_id) !== 'e360_booking') {
        return;
    }

    $session_id = e360_find_lesson_session_id_by_booking($post_id);
    if ($session_id <= 0) {
        return;
    }

    $session = e360_get_lesson_session($session_id);
    if (!$session) {
        return;
    }

    $session['session_status'] = 'cancelled';
    e360_save_lesson_session($session, $session_id);
}
add_action('trashed_post', 'e360_sync_booking_session_on_trash', 10, 1);

function e360_private_learning_get_user_options(array $roles = []): array {
    $query = [
        'orderby' => 'display_name',
        'order'   => 'ASC',
        'fields'  => ['ID', 'display_name', 'user_email'],
    ];

    if ($roles) {
        $query['role__in'] = $roles;
    }

    $users = get_users($query);
    $out = [];
    foreach ($users as $user) {
        $out[(int) $user->ID] = sprintf('%s (#%d)', $user->display_name, $user->ID);
    }

    return $out;
}

function e360_private_learning_get_course_options(): array {
    $posts = get_posts([
        'post_type'      => 'courses',
        'post_status'    => ['publish', 'private', 'draft'],
        'numberposts'    => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'fields'         => 'ids',
        'suppress_filters' => false,
    ]);

    $out = [];
    foreach ($posts as $post_id) {
        $out[(int) $post_id] = sprintf('%s (#%d)', get_the_title((int) $post_id), (int) $post_id);
    }

    return $out;
}

function e360_private_learning_render_select(string $name, array $options, $selected = 0, string $placeholder = 'Select'): string {
    $html = '<select name="' . esc_attr($name) . '" style="width:100%;">';
    $html .= '<option value="0">' . esc_html($placeholder) . '</option>';
    foreach ($options as $value => $label) {
        $html .= '<option value="' . (int) $value . '"' . selected((int) $selected, (int) $value, false) . '>' . esc_html($label) . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function e360_private_learning_admin_columns(array $columns, string $post_type): array {
    if ($post_type === e360_program_post_type()) {
        return [
            'cb'              => $columns['cb'] ?? '<input type="checkbox" />',
            'title'           => 'Student Program',
            'student'         => 'Student',
            'teacher'         => 'Teacher',
            'course'          => 'Course',
            'status'          => 'Status',
            'credits'         => 'Credits',
            'next_lesson'     => 'Next Lesson',
            'last_lesson'     => 'Last Lesson',
            'order_id'        => 'Order',
            'date'            => 'Updated',
        ];
    }

    if ($post_type === e360_lesson_session_post_type()) {
        return [
            'cb'              => $columns['cb'] ?? '<input type="checkbox" />',
            'title'           => 'Private Lesson',
            'program'         => 'Program',
            'student'         => 'Student',
            'teacher'         => 'Teacher',
            'course'          => 'Course',
            'lesson_when'     => 'Lesson Time',
            'session_status'  => 'Status',
            'zoom'            => 'Zoom',
            'date'            => 'Updated',
        ];
    }

    return $columns;
}
add_filter('manage_edit-' . 'e360_program' . '_columns', static function(array $columns): array {
    return e360_private_learning_admin_columns($columns, e360_program_post_type());
});
add_filter('manage_edit-' . 'e360_lesson_session' . '_columns', static function(array $columns): array {
    return e360_private_learning_admin_columns($columns, e360_lesson_session_post_type());
});

function e360_private_learning_render_admin_column(string $column, int $post_id, string $post_type): void {
    if ($post_type === e360_program_post_type()) {
        $program = e360_get_program($post_id);
        $summary = e360_get_program_summary($post_id);
        if (!$program) {
            echo '&mdash;';
            return;
        }

        switch ($column) {
            case 'student':
            case 'teacher':
                $user_id = (int) ($program[$column . '_id'] ?? 0);
                $user = $user_id > 0 ? get_user_by('id', $user_id) : null;
                echo $user ? esc_html($user->display_name) : '&mdash;';
                break;
            case 'course':
                $course_id = (int) ($program['course_id'] ?? 0);
                echo $course_id > 0 ? esc_html(get_the_title($course_id)) : '&mdash;';
                break;
            case 'status':
                $status = (string) ($program['status'] ?? '');
                $label = e360_get_program_statuses()[$status] ?? $status;
                echo '<strong>' . esc_html($label) . '</strong>';
                break;
            case 'credits':
                echo esc_html(sprintf('%d / %d / %d', (int) ($program['total_credits'] ?? 0), (int) ($program['used_credits'] ?? 0), (int) ($program['remaining_credits'] ?? 0)));
                echo '<br><span style="opacity:.7;">total / used / left</span>';
                break;
            case 'next_lesson':
                if (!empty($summary['next_lesson_date'])) {
                    echo esc_html(trim(($summary['next_lesson_date'] ?? '') . ' ' . ($summary['next_lesson_time'] ?? '')));
                } else {
                    echo '&mdash;';
                }
                break;
            case 'last_lesson':
                if (!empty($summary['last_lesson_date'])) {
                    echo esc_html(trim(($summary['last_lesson_date'] ?? '') . ' ' . ($summary['last_lesson_time'] ?? '')));
                } else {
                    echo '&mdash;';
                }
                break;
            case 'order_id':
                $order_id = (int) ($program['order_id'] ?? 0);
                if ($order_id > 0) {
                    $url = admin_url('post.php?post=' . $order_id . '&action=edit');
                    echo '<a href="' . esc_url($url) . '">#' . (int) $order_id . '</a>';
                } else {
                    echo '&mdash;';
                }
                break;
        }
        return;
    }

    if ($post_type === e360_lesson_session_post_type()) {
        $session = e360_get_lesson_session($post_id);
        if (!$session) {
            echo '&mdash;';
            return;
        }

        switch ($column) {
            case 'program':
                $program_id = (int) ($session['program_id'] ?? 0);
                if ($program_id > 0) {
                    $url = admin_url('post.php?post=' . $program_id . '&action=edit');
                    echo '<a href="' . esc_url($url) . '">#' . (int) $program_id . '</a>';
                } else {
                    echo '&mdash;';
                }
                break;
            case 'student':
            case 'teacher':
                $user_id = (int) ($session[$column . '_id'] ?? 0);
                $user = $user_id > 0 ? get_user_by('id', $user_id) : null;
                echo $user ? esc_html($user->display_name) : '&mdash;';
                break;
            case 'course':
                $course_id = (int) ($session['course_id'] ?? 0);
                echo $course_id > 0 ? esc_html(get_the_title($course_id)) : '&mdash;';
                break;
            case 'lesson_when':
                echo esc_html(trim(($session['lesson_date'] ?? '') . ' ' . ($session['lesson_time'] ?? '')));
                echo '<br><span style="opacity:.7;">' . esc_html((string) ($session['repeat_type'] ?? '')) . '</span>';
                break;
            case 'session_status':
                $status = (string) ($session['session_status'] ?? '');
                $label = e360_get_lesson_session_statuses()[$status] ?? $status;
                echo '<strong>' . esc_html($label) . '</strong>';
                break;
            case 'zoom':
                if (!empty($session['zoom_join_url'])) {
                    echo '<a href="' . esc_url((string) $session['zoom_join_url']) . '" target="_blank" rel="noopener noreferrer">Join link</a>';
                } else {
                    echo '&mdash;';
                }
                break;
        }
    }
}
add_action('manage_' . 'e360_program' . '_posts_custom_column', static function(string $column, int $post_id): void {
    e360_private_learning_render_admin_column($column, $post_id, e360_program_post_type());
}, 10, 2);
add_action('manage_' . 'e360_lesson_session' . '_posts_custom_column', static function(string $column, int $post_id): void {
    e360_private_learning_render_admin_column($column, $post_id, e360_lesson_session_post_type());
}, 10, 2);

function e360_render_program_admin_filters(string $post_type): void {
    if ($post_type === e360_program_post_type()) {
        $teacher_id = isset($_GET['e360_teacher']) ? (int) $_GET['e360_teacher'] : 0;
        $student_id = isset($_GET['e360_student']) ? (int) $_GET['e360_student'] : 0;
        $course_id  = isset($_GET['e360_course']) ? (int) $_GET['e360_course'] : 0;
        $status     = isset($_GET['e360_program_status']) ? sanitize_key(wp_unslash($_GET['e360_program_status'])) : '';

        echo e360_private_learning_render_select('e360_teacher', e360_private_learning_get_user_options(['administrator', 'tutor_instructor']), $teacher_id, 'All teachers');
        echo e360_private_learning_render_select('e360_student', e360_private_learning_get_user_options(), $student_id, 'All students');
        echo e360_private_learning_render_select('e360_course', e360_private_learning_get_course_options(), $course_id, 'All courses');

        echo '<select name="e360_program_status">';
        echo '<option value="">' . esc_html('All statuses') . '</option>';
        foreach (e360_get_program_statuses() as $value => $label) {
            echo '<option value="' . esc_attr($value) . '"' . selected($status, $value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
        return;
    }

    if ($post_type === e360_lesson_session_post_type()) {
        $program_id = isset($_GET['e360_program']) ? (int) $_GET['e360_program'] : 0;
        $teacher_id = isset($_GET['e360_teacher']) ? (int) $_GET['e360_teacher'] : 0;
        $student_id = isset($_GET['e360_student']) ? (int) $_GET['e360_student'] : 0;
        $course_id  = isset($_GET['e360_course']) ? (int) $_GET['e360_course'] : 0;
        $status     = isset($_GET['e360_session_status']) ? sanitize_key(wp_unslash($_GET['e360_session_status'])) : '';

        $program_posts = get_posts([
            'post_type'   => e360_program_post_type(),
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby'     => 'title',
            'order'       => 'ASC',
        ]);
        $program_options = [];
        foreach ($program_posts as $program_post) {
            $program_options[(int) $program_post->ID] = $program_post->post_title . ' (#' . (int) $program_post->ID . ')';
        }

        echo e360_private_learning_render_select('e360_program', $program_options, $program_id, 'All programs');
        echo e360_private_learning_render_select('e360_teacher', e360_private_learning_get_user_options(['administrator', 'tutor_instructor']), $teacher_id, 'All teachers');
        echo e360_private_learning_render_select('e360_student', e360_private_learning_get_user_options(), $student_id, 'All students');
        echo e360_private_learning_render_select('e360_course', e360_private_learning_get_course_options(), $course_id, 'All courses');

        echo '<select name="e360_session_status">';
        echo '<option value="">' . esc_html('All statuses') . '</option>';
        foreach (e360_get_lesson_session_statuses() as $value => $label) {
            echo '<option value="' . esc_attr($value) . '"' . selected($status, $value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'e360_render_program_admin_filters');

function e360_filter_program_admin_query(WP_Query $query): void {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $post_type = $query->get('post_type');
    $meta_query = (array) $query->get('meta_query');

    if ($post_type === e360_program_post_type()) {
        $map = [
            'e360_teacher'        => 'teacher_id',
            'e360_student'        => 'student_id',
            'e360_course'         => 'course_id',
            'e360_program_status' => 'status',
        ];

        foreach ($map as $request_key => $meta_key) {
            $raw = isset($_GET[$request_key]) ? wp_unslash($_GET[$request_key]) : '';
            if ($raw === '' || $raw === null) {
                continue;
            }

            if ($request_key === 'e360_program_status') {
                $value = sanitize_key((string) $raw);
                if ($value === '') {
                    continue;
                }
                $meta_query[] = [
                    'key'   => $meta_key,
                    'value' => $value,
                ];
                continue;
            }

            $value = (int) $raw;
            if ($value <= 0) {
                continue;
            }
            $meta_query[] = [
                'key'     => $meta_key,
                'value'   => $value,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ];
        }
    } elseif ($post_type === e360_lesson_session_post_type()) {
        $map = [
            'e360_program'        => 'program_id',
            'e360_teacher'        => 'teacher_id',
            'e360_student'        => 'student_id',
            'e360_course'         => 'course_id',
            'e360_session_status' => 'session_status',
        ];

        foreach ($map as $request_key => $meta_key) {
            $raw = isset($_GET[$request_key]) ? wp_unslash($_GET[$request_key]) : '';
            if ($raw === '' || $raw === null) {
                continue;
            }

            if ($request_key === 'e360_session_status') {
                $value = sanitize_key((string) $raw);
                if ($value === '') {
                    continue;
                }
                $meta_query[] = [
                    'key'   => $meta_key,
                    'value' => $value,
                ];
                continue;
            }

            $value = (int) $raw;
            if ($value <= 0) {
                continue;
            }
            $meta_query[] = [
                'key'     => $meta_key,
                'value'   => $value,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ];
        }
    } else {
        return;
    }

    if ($meta_query) {
        $query->set('meta_query', $meta_query);
    }
}
add_action('pre_get_posts', 'e360_filter_program_admin_query');

function e360_register_private_learning_metaboxes(): void {
    add_meta_box('e360-program-details', 'Program Details', 'e360_render_program_details_metabox', e360_program_post_type(), 'normal', 'high');
    add_meta_box('e360-program-summary', 'Program Summary', 'e360_render_program_summary_metabox', e360_program_post_type(), 'side', 'high');
    add_meta_box('e360-program-actions', 'Program Actions', 'e360_render_program_actions_metabox', e360_program_post_type(), 'side', 'default');
    add_meta_box('e360-program-sessions', 'Linked Private Lessons', 'e360_render_program_sessions_metabox', e360_program_post_type(), 'normal', 'default');

    add_meta_box('e360-session-details', 'Private Lesson Details', 'e360_render_session_details_metabox', e360_lesson_session_post_type(), 'normal', 'high');
    add_meta_box('e360-session-zoom', 'Zoom & Notes', 'e360_render_session_zoom_metabox', e360_lesson_session_post_type(), 'normal', 'default');
    add_meta_box('e360-session-context', 'Program Context', 'e360_render_session_context_metabox', e360_lesson_session_post_type(), 'side', 'high');
    add_meta_box('e360-session-actions', 'Lesson Actions', 'e360_render_session_actions_metabox', e360_lesson_session_post_type(), 'side', 'default');
}
add_action('add_meta_boxes', 'e360_register_private_learning_metaboxes');

function e360_render_program_details_metabox(WP_Post $post): void {
    $program = e360_get_program((int) $post->ID);
    wp_nonce_field('e360_save_program_admin', 'e360_program_admin_nonce');

    $students = e360_private_learning_get_user_options();
    $teachers = e360_private_learning_get_user_options(['administrator', 'tutor_instructor']);
    $courses  = e360_private_learning_get_course_options();
    ?>
<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th><label for="e360_program_student_id">Student</label></th>
            <td><?php echo e360_private_learning_render_select('e360_program[student_id]', $students, (int) ($program['student_id'] ?? 0), 'Select student'); ?>
            </td>
        </tr>
        <tr>
            <th><label for="e360_program_teacher_id">Teacher</label></th>
            <td>
                <?php
                    $teacher = !empty($program['teacher_id']) ? get_user_by('id', (int) $program['teacher_id']) : null;
                    echo esc_html($teacher ? $teacher->display_name : '—');
                    ?>
                <p class="description" style="margin-top:6px;">Teacher changes are allowed only via the reassignment
                    action.</p>
            </td>
        </tr>
        <tr>
            <th><label for="e360_program_course_id">Course</label></th>
            <td><?php echo e360_private_learning_render_select('e360_program[course_id]', $courses, (int) ($program['course_id'] ?? 0), 'Select course'); ?>
            </td>
        </tr>
        <tr>
            <th><label for="e360_program_status">Status</label></th>
            <td>
                <select name="e360_program[status]" id="e360_program_status" style="width:100%;">
                    <?php foreach (e360_get_program_statuses() as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>"
                        <?php selected((string) ($program['status'] ?? 'active'), $value); ?>>
                        <?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="e360_program_booking_format">Booking Format</label></th>
            <td><input type="text" id="e360_program_booking_format" name="e360_program[booking_format]"
                    value="<?php echo esc_attr((string) ($program['booking_format'] ?? '')); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="e360_program_timezone">Timezone</label></th>
            <td><input type="text" id="e360_program_timezone" name="e360_program[timezone]"
                    value="<?php echo esc_attr((string) ($program['timezone'] ?? '')); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="e360_program_start_date">Start Date</label></th>
            <td><input type="date" id="e360_program_start_date" name="e360_program[start_date]"
                    value="<?php echo esc_attr((string) ($program['start_date'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th><label for="e360_program_end_date">End Date</label></th>
            <td><input type="date" id="e360_program_end_date" name="e360_program[end_date]"
                    value="<?php echo esc_attr((string) ($program['end_date'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th><label for="e360_program_notes">Notes</label></th>
            <td><textarea id="e360_program_notes" name="e360_program[notes]" rows="5"
                    style="width:100%;"><?php echo esc_textarea((string) ($program['notes'] ?? '')); ?></textarea></td>
        </tr>
    </tbody>
</table>
<?php
}

function e360_render_program_summary_metabox(WP_Post $post): void {
    $program_id = (int) $post->ID;
    $program = e360_get_program($program_id);
    $summary = e360_get_program_summary($program_id);
    $sync_url = wp_nonce_url(admin_url('admin-post.php?action=e360_sync_program&program_id=' . $program_id), 'e360_sync_program_' . $program_id);
    ?>
<p><strong>Credits:</strong><br><?php echo esc_html(sprintf('%d total / %d used / %d left', (int) ($program['total_credits'] ?? 0), (int) ($program['used_credits'] ?? 0), (int) ($program['remaining_credits'] ?? 0))); ?>
</p>
<p><strong>Lessons:</strong><br><?php echo esc_html(sprintf('%d scheduled / %d completed / %d cancelled', (int) ($summary['scheduled_count'] ?? 0), (int) ($summary['completed_count'] ?? 0), (int) ($summary['cancelled_count'] ?? 0))); ?>
</p>
<p><strong>Next
        lesson:</strong><br><?php echo !empty($summary['next_lesson_date']) ? esc_html(trim(($summary['next_lesson_date'] ?? '') . ' ' . ($summary['next_lesson_time'] ?? ''))) : '&mdash;'; ?>
</p>
<p><strong>Last
        lesson:</strong><br><?php echo !empty($summary['last_lesson_date']) ? esc_html(trim(($summary['last_lesson_date'] ?? '') . ' ' . ($summary['last_lesson_time'] ?? ''))) : '&mdash;'; ?>
</p>
<p><strong>Completed minutes:</strong><br><?php echo esc_html((string) ((int) ($summary['completed_minutes'] ?? 0))); ?>
</p>
<p><a class="button button-secondary" href="<?php echo esc_url($sync_url); ?>">Re-sync bookings and sessions</a></p>
<?php
}

function e360_render_program_actions_metabox(WP_Post $post): void {
    $program_id = (int) $post->ID;
    $program = e360_get_program($program_id);
    $teachers = e360_private_learning_get_user_options(['administrator', 'tutor_instructor']);
    $redirect = admin_url('post.php?post=' . $program_id . '&action=edit');
    $nonce = wp_create_nonce('e360_program_manage_' . $program_id);
    ?>
<div style="display:grid;gap:16px;">
    <div class="e360-admin-action-box" data-action="e360_program_manage"
        data-program-id="<?php echo (int) $program_id; ?>" data-redirect-to="<?php echo esc_url($redirect); ?>"
        data-nonce="<?php echo esc_attr($nonce); ?>" data-manage-action="reassign_teacher">
        <div style="font-weight:600;margin-bottom:6px;">Teacher reassignment</div>
        <?php echo e360_private_learning_render_select('teacher_id', $teachers, (int) ($program['teacher_id'] ?? 0), 'Select teacher'); ?>
        <p style="margin:8px 0 0;"><button type="button"
                class="button button-secondary e360-admin-post-action-btn">Reassign teacher</button></p>
    </div>

    <div class="e360-admin-action-box" data-action="e360_program_manage"
        data-program-id="<?php echo (int) $program_id; ?>" data-redirect-to="<?php echo esc_url($redirect); ?>"
        data-nonce="<?php echo esc_attr($nonce); ?>" data-manage-action="add_credits">
        <div style="font-weight:600;margin-bottom:6px;">Add credits</div>
        <p style="margin:0 0 8px;"><input type="number" min="1" name="credits_qty" value="1" style="width:100%;"></p>
        <p style="margin:0 0 8px;"><input type="text" name="credits_reason" value="" placeholder="Reason"
                style="width:100%;"></p>
        <p style="margin:0;"><button type="button" class="button button-secondary e360-admin-post-action-btn">Add
                credits</button></p>
    </div>

    <div class="e360-admin-action-box" data-action="e360_program_manage"
        data-program-id="<?php echo (int) $program_id; ?>" data-redirect-to="<?php echo esc_url($redirect); ?>"
        data-nonce="<?php echo esc_attr($nonce); ?>" data-manage-action="set_status">
        <div style="font-weight:600;margin-bottom:6px;">Program status</div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="active">Activate</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="paused">Pause</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="completed">Complete</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="cancelled">Cancel</button>
        </div>
    </div>
</div>
<?php
}

function e360_render_program_sessions_metabox(WP_Post $post): void {
    $sessions = e360_get_program_sessions((int) $post->ID, ['orderby' => 'lesson_date', 'order' => 'DESC']);
    if (!$sessions) {
        echo '<p>No private lessons linked yet.</p>';
        return;
    }

    echo '<table class="widefat striped"><thead><tr><th>Date</th><th>Status</th><th>Teacher</th><th>Zoom</th></tr></thead><tbody>';
    foreach ($sessions as $session) {
        $edit_url = admin_url('post.php?post=' . (int) $session['ID'] . '&action=edit');
        $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
        $status = e360_get_lesson_session_statuses()[(string) ($session['session_status'] ?? '')] ?? (string) ($session['session_status'] ?? '');
        echo '<tr>';
        echo '<td><a href="' . esc_url($edit_url) . '">' . esc_html(trim(($session['lesson_date'] ?? '') . ' ' . ($session['lesson_time'] ?? ''))) . '</a></td>';
        echo '<td>' . esc_html($status) . '</td>';
        echo '<td>' . esc_html($teacher ? $teacher->display_name : '—') . '</td>';
        echo '<td>';
        if (!empty($session['zoom_join_url'])) {
            echo '<a href="' . esc_url((string) $session['zoom_join_url']) . '" target="_blank" rel="noopener noreferrer">Join</a>';
        } else {
            echo '&mdash;';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}

function e360_render_session_details_metabox(WP_Post $post): void {
    $session = e360_get_lesson_session((int) $post->ID);
    wp_nonce_field('e360_save_session_admin', 'e360_session_admin_nonce');

    $students = e360_private_learning_get_user_options();
    $teachers = e360_private_learning_get_user_options(['administrator', 'tutor_instructor']);
    $courses  = e360_private_learning_get_course_options();
    $programs = get_posts([
        'post_type'   => e360_program_post_type(),
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'title',
        'order'       => 'ASC',
    ]);
    $program_options = [];
    foreach ($programs as $program_post) {
        $program_options[(int) $program_post->ID] = $program_post->post_title . ' (#' . (int) $program_post->ID . ')';
    }
    ?>
<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th>Program</th>
            <td><?php echo e360_private_learning_render_select('e360_session[program_id]', $program_options, (int) ($session['program_id'] ?? 0), 'Select program'); ?>
            </td>
        </tr>
        <tr>
            <th>Student</th>
            <td><?php echo e360_private_learning_render_select('e360_session[student_id]', $students, (int) ($session['student_id'] ?? 0), 'Select student'); ?>
            </td>
        </tr>
        <tr>
            <th>Teacher</th>
            <td>
                <?php
                    $teacher = !empty($session['teacher_id']) ? get_user_by('id', (int) $session['teacher_id']) : null;
                    echo esc_html($teacher ? $teacher->display_name : '—');
                    ?>
                <p class="description" style="margin-top:6px;">Teacher is inherited from the linked program.</p>
            </td>
        </tr>
        <tr>
            <th>Course</th>
            <td><?php echo e360_private_learning_render_select('e360_session[course_id]', $courses, (int) ($session['course_id'] ?? 0), 'Select course'); ?>
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <td><input type="date" name="e360_session[lesson_date]"
                    value="<?php echo esc_attr((string) ($session['lesson_date'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><input type="time" name="e360_session[lesson_time]"
                    value="<?php echo esc_attr((string) ($session['lesson_time'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th>Duration</th>
            <td><input type="number" min="1" name="e360_session[duration]"
                    value="<?php echo esc_attr((string) ((int) ($session['duration'] ?? 60))); ?>"></td>
        </tr>
        <tr>
            <th>Repeat</th>
            <td>
                <select name="e360_session[repeat_type]">
                    <option value="once" <?php selected((string) ($session['repeat_type'] ?? 'once'), 'once'); ?>>Once
                    </option>
                    <option value="weekly" <?php selected((string) ($session['repeat_type'] ?? 'once'), 'weekly'); ?>>
                        Weekly</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <select name="e360_session[session_status]">
                    <?php foreach (e360_get_lesson_session_statuses() as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>"
                        <?php selected((string) ($session['session_status'] ?? 'scheduled'), $value); ?>>
                        <?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>
<?php
}

function e360_render_session_zoom_metabox(WP_Post $post): void {
    $session = e360_get_lesson_session((int) $post->ID);
    $sync_url = wp_nonce_url(admin_url('admin-post.php?action=e360_sync_session_zoom&session_id=' . (int) $post->ID), 'e360_sync_session_zoom_' . (int) $post->ID);
    ?>
<?php if (!empty($session['zoom_sync_error'])) : ?>
<div class="notice notice-error inline">
    <p><?php echo esc_html((string) $session['zoom_sync_error']); ?></p>
</div>
<?php endif; ?>
<p><a class="button button-secondary" href="<?php echo esc_url($sync_url); ?>">Create / Re-sync Zoom meeting</a></p>
<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th>Zoom Host ID</th>
            <td><input type="text" class="regular-text" name="e360_session[zoom_host_id]"
                    value="<?php echo esc_attr((string) ($session['zoom_host_id'] ?? '')); ?>" readonly></td>
        </tr>
        <tr>
            <th>Zoom Meeting ID</th>
            <td><input type="text" class="regular-text" name="e360_session[zoom_meeting_id]"
                    value="<?php echo esc_attr((string) ($session['zoom_meeting_id'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th>Zoom Start URL</th>
            <td><input type="url" class="large-text" name="e360_session[zoom_start_url]"
                    value="<?php echo esc_attr((string) ($session['zoom_start_url'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th>Zoom Join URL</th>
            <td><input type="url" class="large-text" name="e360_session[zoom_join_url]"
                    value="<?php echo esc_attr((string) ($session['zoom_join_url'] ?? '')); ?>"></td>
        </tr>
        <tr>
            <th>Attendance</th>
            <td>
                <input type="text" class="regular-text" name="e360_session[attendance_teacher]"
                    value="<?php echo esc_attr((string) ($session['attendance_teacher'] ?? '')); ?>"
                    placeholder="Teacher attendance">
                <br><br>
                <input type="text" class="regular-text" name="e360_session[attendance_student]"
                    value="<?php echo esc_attr((string) ($session['attendance_student'] ?? '')); ?>"
                    placeholder="Student attendance">
            </td>
        </tr>
        <tr>
            <th>Session Notes</th>
            <td><textarea name="e360_session[session_notes]" rows="4"
                    style="width:100%;"><?php echo esc_textarea((string) ($session['session_notes'] ?? '')); ?></textarea>
            </td>
        </tr>
        <tr>
            <th>Homework</th>
            <td><textarea name="e360_session[homework]" rows="4"
                    style="width:100%;"><?php echo esc_textarea((string) ($session['homework'] ?? '')); ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
<?php
}

function e360_render_session_context_metabox(WP_Post $post): void {
    $session = e360_get_lesson_session((int) $post->ID);
    $program_id = (int) ($session['program_id'] ?? 0);
    $booking_id = (int) ($session['source_booking_id'] ?? 0);
    $order_id = (int) ($session['order_id'] ?? 0);
    ?>
<p><strong>Program:</strong><br>
    <?php if ($program_id > 0) : ?>
    <a
        href="<?php echo esc_url(admin_url('post.php?post=' . $program_id . '&action=edit')); ?>">#<?php echo (int) $program_id; ?></a>
    <?php else : ?>
    &mdash;
    <?php endif; ?>
</p>
<p><strong>Source Booking:</strong><br><?php echo $booking_id > 0 ? esc_html('#' . $booking_id) : '&mdash;'; ?></p>
<p><strong>Order:</strong><br><?php echo $order_id > 0 ? esc_html('#' . $order_id) : '&mdash;'; ?></p>
<?php
}

function e360_render_session_actions_metabox(WP_Post $post): void {
    $session_id = (int) $post->ID;
    $session = e360_get_lesson_session($session_id);
    $redirect = admin_url('post.php?post=' . $session_id . '&action=edit');
    $nonce = wp_create_nonce('e360_session_manage_' . $session_id);
    ?>
<div style="display:grid;gap:16px;">
    <div class="e360-admin-action-box" data-action="e360_session_manage"
        data-session-id="<?php echo (int) $session_id; ?>" data-redirect-to="<?php echo esc_url($redirect); ?>"
        data-nonce="<?php echo esc_attr($nonce); ?>" data-manage-action="set_status">
        <div style="font-weight:600;margin-bottom:6px;">Quick status</div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="scheduled">Schedule</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="completed">Complete</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="missed">Missed</button>
            <button type="button" class="button button-secondary e360-admin-post-action-btn" data-status="cancelled">Cancel</button>
        </div>
    </div>

    <div class="e360-admin-action-box" data-action="e360_session_manage"
        data-session-id="<?php echo (int) $session_id; ?>" data-redirect-to="<?php echo esc_url($redirect); ?>"
        data-nonce="<?php echo esc_attr($nonce); ?>" data-manage-action="reschedule">
        <div style="font-weight:600;margin-bottom:6px;">Reschedule</div>
        <p style="margin:0 0 8px;"><input type="date" name="lesson_date"
                value="<?php echo esc_attr((string) ($session['lesson_date'] ?? '')); ?>" style="width:100%;"></p>
        <p style="margin:0 0 8px;"><input type="time" name="lesson_time"
                value="<?php echo esc_attr((string) ($session['lesson_time'] ?? '')); ?>" style="width:100%;"></p>
        <p style="margin:0;"><button type="button" class="button button-secondary e360-admin-post-action-btn">Save
                reschedule</button></p>
    </div>

    <p style="margin:0;"><a class="button button-secondary"
            href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=e360_sync_session_zoom&session_id=' . $session_id), 'e360_sync_session_zoom_' . $session_id)); ?>">Re-sync
            Zoom</a></p>
</div>
<?php
}

function e360_output_private_learning_admin_action_script(): void {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || !in_array($screen->post_type, [e360_program_post_type(), e360_lesson_session_post_type()], true)) {
        return;
    }
    ?>
<script>
(function() {
    if (window.e360PrivateAdminActionsBound) return;
    window.e360PrivateAdminActionsBound = true;

    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.e360-admin-post-action-btn');
        if (!btn) return;

        e.preventDefault();

        var box = btn.closest('.e360-admin-action-box');
        if (!box) return;

        var form = document.createElement('form');
        form.method = 'post';
        form.action = <?php echo wp_json_encode(admin_url('admin-post.php')); ?>;
        form.style.display = 'none';

        function append(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        append('action', box.getAttribute('data-action') || '');
        append('_wpnonce', box.getAttribute('data-nonce') || '');
        append('manage_action', box.getAttribute('data-manage-action') || '');
        append('redirect_to', box.getAttribute('data-redirect-to') || window.location.href);

        var programId = box.getAttribute('data-program-id');
        var sessionId = box.getAttribute('data-session-id');
        if (programId) append('program_id', programId);
        if (sessionId) append('session_id', sessionId);

        var status = btn.getAttribute('data-status');
        if (status) append('status', status);

        box.querySelectorAll('input[name], select[name], textarea[name]').forEach(function(field) {
            if (field.disabled) return;
            if (status && field.name === 'status') return;
            append(field.name, field.value || '');
        });

        document.body.appendChild(form);
        form.submit();
    });
})();
</script>
<?php
}
add_action('admin_footer', 'e360_output_private_learning_admin_action_script');

function e360_save_private_learning_admin_post(int $post_id, WP_Post $post): void {
    static $saving = [];

    if (isset($saving[$post_id])) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if ($post->post_type === e360_program_post_type()) {
        if (empty($_POST['e360_program_admin_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['e360_program_admin_nonce'])), 'e360_save_program_admin')) {
            return;
        }
        $raw = isset($_POST['e360_program']) && is_array($_POST['e360_program']) ? wp_unslash($_POST['e360_program']) : [];
        $existing = e360_get_program($post_id);
        $program = array_merge($existing, $raw);
        $program['teacher_id'] = (int) ($existing['teacher_id'] ?? 0);
        $saving[$post_id] = true;
        try {
            $saved = e360_save_program($program, $post_id);
            if (!is_wp_error($saved)) {
                e360_refresh_program_from_sessions($post_id);
            }
        } finally {
            unset($saving[$post_id]);
        }
        return;
    }

    if ($post->post_type === e360_lesson_session_post_type()) {
        if (empty($_POST['e360_session_admin_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['e360_session_admin_nonce'])), 'e360_save_session_admin')) {
            return;
        }
        $raw = isset($_POST['e360_session']) && is_array($_POST['e360_session']) ? wp_unslash($_POST['e360_session']) : [];
        $session = array_merge(e360_get_lesson_session($post_id), $raw);
        $program_id = (int) ($session['program_id'] ?? 0);
        if ($program_id > 0) {
            $program = e360_get_program($program_id);
            if ($program) {
                $session['student_id'] = (int) ($program['student_id'] ?? 0);
                $session['teacher_id'] = (int) ($program['teacher_id'] ?? 0);
                $session['course_id'] = (int) ($program['course_id'] ?? 0);
            }
        }
        $saving[$post_id] = true;
        try {
            e360_save_lesson_session($session, $post_id);
        } finally {
            unset($saving[$post_id]);
        }
    }
}
add_action('save_post', 'e360_save_private_learning_admin_post', 20, 2);

function e360_handle_private_learning_admin_post_actions(): void {
    if (!current_user_can('manage_options')) {
        wp_die('Forbidden');
    }

    $action = isset($_REQUEST['action']) ? sanitize_key(wp_unslash($_REQUEST['action'])) : '';
    if ($action === 'e360_sync_program') {
        $program_id = isset($_GET['program_id']) ? (int) $_GET['program_id'] : 0;
        if ($program_id <= 0) {
            wp_safe_redirect(admin_url('edit.php?post_type=' . e360_program_post_type()));
            exit;
        }

        check_admin_referer('e360_sync_program_' . $program_id);
        e360_sync_program_bookings($program_id);
        e360_refresh_program_from_sessions($program_id);

        wp_safe_redirect(admin_url('post.php?post=' . $program_id . '&action=edit'));
        exit;
    }

    if ($action === 'e360_sync_session_zoom') {
        $session_id = isset($_GET['session_id']) ? (int) $_GET['session_id'] : 0;
        if ($session_id <= 0) {
            wp_safe_redirect(admin_url('edit.php?post_type=' . e360_lesson_session_post_type()));
            exit;
        }

        check_admin_referer('e360_sync_session_zoom_' . $session_id);
        e360_sync_session_zoom_meeting($session_id);
        wp_safe_redirect(admin_url('post.php?post=' . $session_id . '&action=edit'));
        exit;
    }

    if ($action === 'e360_program_manage') {
        $program_id = isset($_POST['program_id']) ? (int) $_POST['program_id'] : 0;
        if ($program_id <= 0) {
            wp_safe_redirect(admin_url('edit.php?post_type=' . e360_program_post_type()));
            exit;
        }

        check_admin_referer('e360_program_manage_' . $program_id);
        $manage_action = isset($_POST['manage_action']) ? sanitize_key(wp_unslash($_POST['manage_action'])) : '';
        $redirect_to = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : admin_url('post.php?post=' . $program_id . '&action=edit');

        if ($manage_action === 'reassign_teacher') {
            $teacher_id = isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0;
            if ($teacher_id > 0) {
                e360_reassign_program_teacher($program_id, $teacher_id);
            }
        } elseif ($manage_action === 'add_credits') {
            $program = e360_get_program($program_id);
            $student_id = (int) ($program['student_id'] ?? 0);
            $course_id = (int) ($program['course_id'] ?? 0);
            $qty = isset($_POST['credits_qty']) ? (int) $_POST['credits_qty'] : 0;
            $reason = isset($_POST['credits_reason']) ? sanitize_text_field(wp_unslash($_POST['credits_reason'])) : '';
            if ($student_id > 0 && $course_id > 0 && $qty > 0 && function_exists('e360_add_credits')) {
                e360_add_credits($student_id, $course_id, $qty, 'Program #' . $program_id . ': ' . $reason);
                e360_sync_program_credit_totals($program_id);
            }
        } elseif ($manage_action === 'set_status') {
            $status = isset($_POST['status']) ? sanitize_key(wp_unslash($_POST['status'])) : '';
            $program = e360_get_program($program_id);
            if ($program && isset(e360_get_program_statuses()[$status])) {
                $program['status'] = $status;
                e360_save_program($program, $program_id);
            }
        }

        e360_refresh_program_from_sessions($program_id);
        wp_safe_redirect($redirect_to);
        exit;
    }

    if ($action === 'e360_session_manage') {
        $session_id = isset($_POST['session_id']) ? (int) $_POST['session_id'] : 0;
        if ($session_id <= 0) {
            wp_safe_redirect(admin_url('edit.php?post_type=' . e360_lesson_session_post_type()));
            exit;
        }

        check_admin_referer('e360_session_manage_' . $session_id);
        $manage_action = isset($_POST['manage_action']) ? sanitize_key(wp_unslash($_POST['manage_action'])) : '';
        $redirect_to = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : admin_url('post.php?post=' . $session_id . '&action=edit');

        if ($manage_action === 'set_status') {
            $status = isset($_POST['status']) ? sanitize_key(wp_unslash($_POST['status'])) : '';
            if (isset(e360_get_lesson_session_statuses()[$status])) {
                e360_update_lesson_session_status($session_id, $status);
            }
        } elseif ($manage_action === 'reschedule') {
            $date = isset($_POST['lesson_date']) ? sanitize_text_field(wp_unslash($_POST['lesson_date'])) : '';
            $time = isset($_POST['lesson_time']) ? sanitize_text_field(wp_unslash($_POST['lesson_time'])) : '';
            if ($date !== '' && $time !== '') {
                e360_reschedule_session_and_booking($session_id, $date, $time);
            }
        }

        wp_safe_redirect($redirect_to);
        exit;
    }

    if (!in_array($action, ['e360_sync_program', 'e360_sync_session_zoom', 'e360_program_manage', 'e360_session_manage'], true)) {
        return;
    }
}
add_action('admin_post_e360_sync_program', 'e360_handle_private_learning_admin_post_actions');
add_action('admin_post_e360_sync_session_zoom', 'e360_handle_private_learning_admin_post_actions');
add_action('admin_post_e360_program_manage', 'e360_handle_private_learning_admin_post_actions');
add_action('admin_post_e360_session_manage', 'e360_handle_private_learning_admin_post_actions');
