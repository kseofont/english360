<?php
/**
 * Plugin Name: English360 Lessons
 * Description: Entitlements, bookings, availability, logs for English360.
 * Version: 0.1.0
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/includes/install.php';
require_once __DIR__ . '/includes/wc-hooks.php';
require_once __DIR__ . '/includes/shortcodes.php';
require_once __DIR__ . '/includes/admin-order.php';
require_once __DIR__ . '/includes/student-registration.php';
require_once __DIR__ . '/includes/credits-functions.php';
require_once __DIR__ . '/includes/lessons-functions.php';
require_once __DIR__ . '/includes/teacher-course-sidebar.php';
require_once __DIR__ . '/includes/admin-credits-ui.php';
require_once __DIR__ . '/includes/students-lessons.php';
require_once __DIR__ . '/includes/teacher-calendar.php';



register_activation_hook(__FILE__, 'e360_install');