<?php
add_action('show_user_profile', 'e360_admin_credits_box');
add_action('edit_user_profile', 'e360_admin_credits_box');

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

<?php wp_nonce_field('e360_admin_credits_save', 'e360_admin_credits_nonce'); ?>
<?php
}

add_action('personal_options_update', 'e360_admin_credits_save');
add_action('edit_user_profile_update', 'e360_admin_credits_save');

function e360_admin_credits_save($user_id){
    if (!current_user_can('manage_options')) return;
    if (empty($_POST['e360_admin_credits_nonce']) || !wp_verify_nonce($_POST['e360_admin_credits_nonce'], 'e360_admin_credits_save')) return;

    $course_id = isset($_POST['e360_admin_course_id']) ? (int)$_POST['e360_admin_course_id'] : 0;
    if (!$course_id) return;

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