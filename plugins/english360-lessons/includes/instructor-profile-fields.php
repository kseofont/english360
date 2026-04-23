<?php
defined('ABSPATH') || exit;

function e360_instructor_profile_meta_schema(): array {
    return [
        'e360_teacher_headline'        => ['label' => 'Professional Headline', 'type' => 'text', 'placeholder' => 'Certified English tutor for beginners and kids'],
        'e360_teacher_intro'           => ['label' => 'Short Intro', 'type' => 'textarea', 'placeholder' => 'Write a short introduction for the teacher card'],
        'e360_teacher_country'         => ['label' => 'Country', 'type' => 'text', 'placeholder' => 'Portugal'],
        'e360_teacher_languages'       => ['label' => 'Languages Spoken', 'type' => 'textarea', 'placeholder' => 'English (Native), Spanish (C1), Ukrainian (Native)'],
        'e360_teacher_rating'          => ['label' => 'Teacher Rating', 'type' => 'number', 'placeholder' => '4.9'],
        'e360_teacher_price'           => ['label' => 'Price per Lesson', 'type' => 'number', 'placeholder' => '25'],
        'e360_teacher_price_label'     => ['label' => 'Price Label', 'type' => 'text', 'placeholder' => '50-min lesson'],
        'e360_teacher_badges'          => ['label' => 'Badges', 'type' => 'text', 'placeholder' => 'Professional, Kids specialist, Exam prep'],
        'e360_teacher_featured'        => ['label' => 'Featured Tutor', 'type' => 'checkbox'],
        'e360_teacher_intro_video'     => ['label' => 'Intro Video URL', 'type' => 'url', 'placeholder' => 'https://...'],
        'e360_teacher_native_language' => ['label' => 'Native Language', 'type' => 'text', 'placeholder' => 'English'],
    ];
}

function e360_instructor_country_options(): array {
    return [
        ''   => 'Select country',
        'CA' => 'Canada',
        'GB' => 'United Kingdom',
        'IE' => 'Ireland',
        'PT' => 'Portugal',
        'ES' => 'Spain',
        'UA' => 'Ukraine',
        'US' => 'United States',
    ];
}

function e360_user_can_have_teacher_card_fields($user): bool {
    $user_id = is_object($user) ? (int) $user->ID : (int) $user;
    if ($user_id <= 0) {
        return false;
    }

    return user_can($user_id, 'tutor_instructor')
        || user_can($user_id, 'manage_options')
        || (bool) get_user_meta($user_id, '_is_tutor_instructor', true);
}

function e360_render_instructor_profile_fields_html(int $user_id = 0, bool $with_wrapper = true): string {
    $schema = e360_instructor_profile_meta_schema();

    ob_start();
    if ($with_wrapper) {
        echo '<h2>Teacher Card Profile</h2>';
        echo '<table class="form-table" role="presentation"><tbody>';
    }

    foreach ($schema as $meta_key => $field) {
        $value = $user_id > 0 ? get_user_meta($user_id, $meta_key, true) : '';
        $label = (string) ($field['label'] ?? $meta_key);
        $type = (string) ($field['type'] ?? 'text');
        $placeholder = (string) ($field['placeholder'] ?? '');

        if ($with_wrapper) {
            echo '<tr>';
            echo '<th><label for="' . esc_attr($meta_key) . '">' . esc_html($label) . '</label></th>';
            echo '<td>';
        } else {
            echo '<div class="tutor-mb-16">';
            echo '<label class="tutor-form-label" for="' . esc_attr($meta_key) . '">' . esc_html($label) . '</label>';
        }

        if ($type === 'textarea') {
            echo '<textarea id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" class="' . ($with_wrapper ? 'large-text' : 'tutor-form-control tutor-mt-8') . '" rows="4" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea((string) $value) . '</textarea>';
        } elseif ($type === 'checkbox') {
            echo '<label>';
            echo '<input type="checkbox" id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" value="1" ' . checked((string) $value, '1', false) . ' />';
            echo ' ' . esc_html__('Enable', 'english360-lessons');
            echo '</label>';
        } else {
            $input_type = in_array($type, ['number', 'url', 'text'], true) ? $type : 'text';
            $step_attr = ($type === 'number') ? ' step="0.1"' : '';
            $min_attr = ($meta_key === 'e360_teacher_rating') ? ' min="0" max="5"' : '';
            echo '<input type="' . esc_attr($input_type) . '" id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" value="' . esc_attr((string) $value) . '" class="' . ($with_wrapper ? 'regular-text' : 'tutor-form-control tutor-mt-8') . '" placeholder="' . esc_attr($placeholder) . '"' . $step_attr . $min_attr . ' />';
        }

        if ($with_wrapper) {
            echo '</td></tr>';
        } else {
            echo '</div>';
        }
    }

    if ($with_wrapper) {
        echo '</tbody></table>';
    }

    return (string) ob_get_clean();
}

function e360_render_instructor_profile_fields_table_rows(int $user_id = 0): string {
    $schema = e360_instructor_profile_meta_schema();

    ob_start();
    echo '<tr><th colspan="2"><h3 style="margin:12px 0 4px;">Teacher Card Profile</h3></th></tr>';

    foreach ($schema as $meta_key => $field) {
        $value = $user_id > 0 ? get_user_meta($user_id, $meta_key, true) : '';
        $label = (string) ($field['label'] ?? $meta_key);
        $type = (string) ($field['type'] ?? 'text');
        $placeholder = (string) ($field['placeholder'] ?? '');

        echo '<tr class="user-description-wrap">';
        echo '<th><label for="' . esc_attr($meta_key) . '">' . esc_html($label) . '</label></th>';
        echo '<td>';

        if ($type === 'textarea') {
            echo '<textarea id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" class="large-text" rows="4" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea((string) $value) . '</textarea>';
        } elseif ($type === 'checkbox') {
            echo '<label>';
            echo '<input type="checkbox" id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" value="1" ' . checked((string) $value, '1', false) . ' />';
            echo ' ' . esc_html__('Enable', 'english360-lessons');
            echo '</label>';
        } else {
            $input_type = in_array($type, ['number', 'url', 'text'], true) ? $type : 'text';
            $step_attr = ($type === 'number') ? ' step="0.1"' : '';
            $min_attr = ($meta_key === 'e360_teacher_rating') ? ' min="0" max="5"' : '';
            echo '<input type="' . esc_attr($input_type) . '" id="' . esc_attr($meta_key) . '" name="' . esc_attr($meta_key) . '" value="' . esc_attr((string) $value) . '" class="regular-text" placeholder="' . esc_attr($placeholder) . '"' . $step_attr . $min_attr . ' />';
        }

        echo '</td></tr>';
    }

    return (string) ob_get_clean();
}

function e360_render_instructor_profile_fields($user): void {
    if (!e360_user_can_have_teacher_card_fields($user)) {
        return;
    }

    echo e360_render_instructor_profile_fields_html((int) $user->ID, true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('show_user_profile', 'e360_render_instructor_profile_fields', 40);
add_action('edit_user_profile', 'e360_render_instructor_profile_fields', 40);

function e360_render_tutor_backend_instructor_profile_fields($user): void {
    if (!e360_user_can_have_teacher_card_fields($user)) {
        return;
    }

    echo e360_render_instructor_profile_fields_table_rows((int) $user->ID); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('tutor_backend_profile_fields_after', 'e360_render_tutor_backend_instructor_profile_fields', 20);

function e360_sanitize_instructor_profile_field(string $meta_key, $value) {
    $schema = e360_instructor_profile_meta_schema();
    $type = (string) ($schema[$meta_key]['type'] ?? 'text');

    if ($type === 'textarea') {
        return sanitize_textarea_field((string) $value);
    }
    if ($type === 'number') {
        return $value === '' ? '' : (string) floatval($value);
    }
    if ($type === 'url') {
        return esc_url_raw((string) $value);
    }
    if ($type === 'checkbox') {
        return !empty($value) ? '1' : '';
    }

    return sanitize_text_field((string) $value);
}

function e360_save_instructor_profile_fields(int $user_id): void {
    if ($user_id <= 0 || !current_user_can('edit_user', $user_id)) {
        return;
    }

    if (!e360_user_can_have_teacher_card_fields($user_id)) {
        return;
    }

    foreach (array_keys(e360_instructor_profile_meta_schema()) as $meta_key) {
        $raw = $_POST[$meta_key] ?? '';
        $value = e360_sanitize_instructor_profile_field($meta_key, wp_unslash($raw));
        if ($value === '') {
            delete_user_meta($user_id, $meta_key);
        } else {
            update_user_meta($user_id, $meta_key, $value);
        }
    }
}
add_action('personal_options_update', 'e360_save_instructor_profile_fields');
add_action('edit_user_profile_update', 'e360_save_instructor_profile_fields');

function e360_render_add_instructor_profile_fields(): void {
    echo '<div class="tutor-row"><div class="tutor-col">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '<div class="tutor-mb-8 tutor-fw-medium tutor-color-black">Teacher Card Profile</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo e360_render_instructor_profile_fields_html(0, false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('tutor_add_new_instructor_form_fields_after', 'e360_render_add_instructor_profile_fields', 20);

function e360_render_edit_instructor_profile_fields(int $user_id): void {
    if (!e360_user_can_have_teacher_card_fields($user_id)) {
        return;
    }

    echo '<div class="tutor-row"><div class="tutor-col">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '<div class="tutor-mb-8 tutor-fw-medium tutor-color-black">Teacher Card Profile</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo e360_render_instructor_profile_fields_html($user_id, false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action('tutor_edit_instructor_form_fields_after', 'e360_render_edit_instructor_profile_fields', 20);

function e360_save_new_instructor_profile_fields(int $user_id): void {
    if ($user_id <= 0) {
        return;
    }

    foreach (array_keys(e360_instructor_profile_meta_schema()) as $meta_key) {
        if (!isset($_POST[$meta_key])) {
            continue;
        }
        $value = e360_sanitize_instructor_profile_field($meta_key, wp_unslash($_POST[$meta_key]));
        if ($value === '') {
            delete_user_meta($user_id, $meta_key);
        } else {
            update_user_meta($user_id, $meta_key, $value);
        }
    }
}
add_action('tutor_new_instructor_after', 'e360_save_new_instructor_profile_fields', 20);

function e360_save_updated_instructor_profile_fields(int $user_id): void {
    if ($user_id <= 0 || !current_user_can('administrator')) {
        return;
    }

    foreach (array_keys(e360_instructor_profile_meta_schema()) as $meta_key) {
        $raw = $_POST[$meta_key] ?? '';
        $value = e360_sanitize_instructor_profile_field($meta_key, wp_unslash($raw));
        if ($value === '') {
            delete_user_meta($user_id, $meta_key);
        } else {
            update_user_meta($user_id, $meta_key, $value);
        }
    }
}
add_action('tutor_after_instructor_update', 'e360_save_updated_instructor_profile_fields', 20);
