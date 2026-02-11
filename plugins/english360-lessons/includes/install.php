<?php
defined('ABSPATH') || exit;

function e360_install() {
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset = $wpdb->get_charset_collate();

    $entitlements = $wpdb->prefix . 'e360_entitlements';
    $bookings     = $wpdb->prefix . 'e360_bookings';
    $avail        = $wpdb->prefix . 'e360_availability';
    $logs         = $wpdb->prefix . 'e360_action_logs';

    $sql = [];

    $sql[] = "CREATE TABLE $entitlements (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        order_id BIGINT UNSIGNED NULL,
        product_id BIGINT UNSIGNED NULL,
        plan_type VARCHAR(20) NOT NULL DEFAULT 'package',
        lessons_total INT UNSIGNED NOT NULL DEFAULT 0,
        lessons_remaining INT UNSIGNED NOT NULL DEFAULT 0,
        session_minutes INT UNSIGNED NOT NULL DEFAULT 60,
        valid_from DATETIME NULL,
        valid_until DATETIME NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY order_id (order_id),
        KEY status (status),
        KEY valid_until (valid_until)
    ) $charset;";

    $sql[] = "CREATE TABLE $bookings (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        student_id BIGINT UNSIGNED NOT NULL,
        teacher_id BIGINT UNSIGNED NOT NULL,
        entitlement_id BIGINT UNSIGNED NULL,
        order_id BIGINT UNSIGNED NULL,
        start_at_utc DATETIME NOT NULL,
        end_at_utc DATETIME NOT NULL,
        status VARCHAR(30) NOT NULL DEFAULT 'requested',
        charged TINYINT(1) NOT NULL DEFAULT 0,
        is_trial TINYINT(1) NOT NULL DEFAULT 0,
        meeting_provider VARCHAR(20) NULL,
        meeting_join_url TEXT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY teacher_start (teacher_id, start_at_utc),
        KEY student_start (student_id, start_at_utc),
        KEY status (status),
        KEY entitlement_id (entitlement_id)
    ) $charset;";

    $sql[] = "CREATE TABLE $avail (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        teacher_id BIGINT UNSIGNED NOT NULL,
        start_at_utc DATETIME NOT NULL,
        end_at_utc DATETIME NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'open',
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY teacher_start (teacher_id, start_at_utc),
        KEY status (status)
    ) $charset;";

    $sql[] = "CREATE TABLE $logs (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        actor_user_id BIGINT UNSIGNED NULL,
        action VARCHAR(50) NOT NULL,
        object_type VARCHAR(30) NOT NULL,
        object_id BIGINT UNSIGNED NULL,
        meta_json LONGTEXT NULL,
        created_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY action (action),
        KEY object_type (object_type),
        KEY object_id (object_id)
    ) $charset;";

    foreach ($sql as $q) {
        dbDelta($q);
    }
}