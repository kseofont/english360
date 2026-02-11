<?php
add_action('wp_ajax_e360_get_courses_by_term', 'e360_get_courses_by_term');
add_action('wp_ajax_nopriv_e360_get_courses_by_term', 'e360_get_courses_by_term');

function e360_teacher_public_name($user): string {
    if (!$user) return '';

    $first = trim((string) get_user_meta($user->ID, 'first_name', true));
    $last  = trim((string) get_user_meta($user->ID, 'last_name', true));

    if ($first === '' && $last === '') {
        $parts = preg_split('/\s+/', trim((string) $user->display_name));
        $first = $parts[0] ?? '';
        $last  = $parts[1] ?? '';
    }

    if ($first === '') $first = (string) $user->display_name;

    $initial = '';
    if ($last !== '') {
        $initial = mb_substr($last, 0, 1) . '.';
    }

    return trim($first . ' ' . $initial);
}


function e360_get_course_instructor_ids(int $course_id): array {
    $ids = [];

    $author_id = (int) get_post_field('post_author', $course_id);
    if ($author_id) $ids[] = $author_id;

    // Tutor LMS (включая co-instructors)
    if (function_exists('tutor_utils') && is_object(tutor_utils()) && method_exists(tutor_utils(), 'get_instructors_by_course')) {
        $list = tutor_utils()->get_instructors_by_course($course_id);
        foreach ((array)$list as $it) {
            if (is_numeric($it)) {
                $ids[] = (int)$it;
            } elseif (is_object($it) && isset($it->ID)) {
                $ids[] = (int)$it->ID;
            } elseif (is_array($it) && isset($it['ID'])) {
                $ids[] = (int)$it['ID'];
            }
        }
    }

    $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
    return $ids;
}

/**
 * Полный HTML bio из Tutor профиля.
 * Разрешаем базовый HTML + iframe ТОЛЬКО с youtube доменов.
 */
function e360_teacher_bio_html(int $user_id): string {
    $bio = (string) get_user_meta($user_id, '_tutor_profile_bio', true); // Tutor LMS bio meta :contentReference[oaicite:1]{index=1}
    if ($bio === '') {
        $u = get_user_by('id', $user_id);
        $bio = $u ? (string)$u->description : '';
    }
    $bio = trim($bio);
    if ($bio === '') return '';

    // Вырезаем iframe, если src НЕ youtube
    $bio = preg_replace_callback('~<iframe\b[^>]*\bsrc=(["\'])(.*?)\1[^>]*>(.*?)</iframe>~is', function($m){
        $src  = $m[2] ?? '';
        $host = strtolower((string) parse_url($src, PHP_URL_HOST));
        $host = preg_replace('~^www\.~', '', $host);

        $ok_hosts = ['youtube.com', 'youtube-nocookie.com', 'youtu.be'];
        if (!in_array($host, $ok_hosts, true)) {
            return '';
        }
        return $m[0];
    }, $bio);

    $allowed = [
        'p' => [], 'br' => [],
        'strong' => [], 'b' => [],
        'em' => [], 'i' => [],
        'ul' => [], 'ol' => [], 'li' => [],
        'a' => ['href'=>true,'title'=>true,'target'=>true,'rel'=>true],
        'iframe' => [
            'src'=>true,'width'=>true,'height'=>true,'frameborder'=>true,
            'allow'=>true,'allowfullscreen'=>true,'referrerpolicy'=>true,'title'=>true
        ],
        'div' => [], 'span' => [],
    ];

    return wp_kses($bio, $allowed);
}

/**
 * Короткий текстовый сниппет (для компактного превью в карточке)
 */
function e360_teacher_bio_snippet(int $user_id, int $limit = 140): string {
    $html = e360_teacher_bio_html($user_id);
    $bio  = trim(wp_strip_all_tags($html));

    if ($bio === '') return '';
    if (mb_strlen($bio) > $limit) $bio = mb_substr($bio, 0, $limit - 1) . '…';
    return $bio;
}


function e360_course_base_title(string $title): string {
    $t = trim($title);

    // отрежем " — Teacher", " - Teacher", " – Teacher"
    $t = preg_split('/\s[—–-]\s/u', $t)[0] ?? $t;

    return trim($t);
}

function e360_get_courses_by_term() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $term_id = isset($_POST['term_id']) ? (int) $_POST['term_id'] : 0;
    if ($term_id <= 0) {
        wp_send_json_error(['message' => 'term_id required']);
    }

    $taxonomy = isset($_POST['taxonomy']) ? sanitize_key($_POST['taxonomy']) : 'course-category';

    $q = new WP_Query([
        'post_type'      => 'courses',
        'post_status'    => 'publish',
        'posts_per_page' => 500,
        'tax_query'      => [[
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => [$term_id],
        ]],
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    // Группируем по base_title => список вариантов (учителей)
    $groups = [];

    foreach ($q->posts as $p) {
        $course_post_id = (int) $p->ID;
        $base_title = e360_course_base_title(get_the_title($course_post_id));
        $key = sanitize_title($base_title);

        if (!isset($groups[$key])) {
            $groups[$key] = [
                'course_key'   => $key,
                'course_title' => $base_title,
                'variants'     => [],
                '_seen'        => [],
            ];
        }

        $author_id = (int) $p->post_author;
        $instructor_ids = e360_get_course_instructor_ids($course_post_id);

        foreach ($instructor_ids as $tid) {
            $variant_key = $course_post_id . ':' . $tid;
            if (isset($groups[$key]['_seen'][$variant_key])) continue;
            $groups[$key]['_seen'][$variant_key] = 1;

            $u = get_user_by('id', $tid);
            if (!$u) continue;

            $bio_html = e360_teacher_bio_html($tid);
            $bio_snip = e360_teacher_bio_snippet($tid, 140);

            $groups[$key]['variants'][] = [
                'course_id'        => $course_post_id,          // один и тот же course post
                'course_title'     => get_the_title($course_post_id),
                'teacher_id'       => $tid,                     // может быть author или attached instructor
                'teacher_name'     => e360_teacher_public_name($u),
                'teacher_avatar'   => get_avatar_url($tid, ['size' => 96]),
                'teacher_bio'      => $bio_snip,                // текстовое превью
                'teacher_bio_html' => $bio_html,                // полный HTML (safe)
                'teacher_role'     => ($tid === $author_id) ? 'Author' : 'Instructor',
            ];
        }
    }

    // перед отдачей JSON убираем служебное поле
    foreach ($groups as &$g) {
        unset($g['_seen']);
    }


    // В массив для JSON
    $items = array_values($groups);

    wp_send_json_success(['items' => $items]);
}

add_action('wp_ajax_e360_get_schedule_preview_bulk', 'e360_get_schedule_preview_bulk');
add_action('wp_ajax_nopriv_e360_get_schedule_preview_bulk', 'e360_get_schedule_preview_bulk');

function e360_slot_hhmm($s): string {
    if (is_string($s)) {
        if (preg_match('/^\d{2}:\d{2}/', $s, $m)) return substr($s, 0, 5);
        // если вдруг вернёт ISO
        if (($ts = strtotime($s)) !== false) return date('H:i', $ts);
        return $s;
    }
    return '';
}

function e360_get_schedule_preview_bulk() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;

    $raw = isset($_POST['teacher_ids']) ? wp_unslash($_POST['teacher_ids']) : '[]';
    $teacher_ids = json_decode($raw, true);
    if (!is_array($teacher_ids)) $teacher_ids = [];

    $teacher_ids = array_values(array_unique(array_filter(array_map('intval', $teacher_ids))));
    if (!$teacher_ids) wp_send_json_success(['items' => []]);

    $days = 7;
    $start = current_time('timestamp'); // WP timezone
    $items = [];

    // viewer (student) timezone: prefer current user or explicit student_id POST
    $viewer_id = get_current_user_id();
    if (!$viewer_id && isset($_POST['student_id'])) {
        $viewer_id = (int) $_POST['student_id'];
    }

    // helper: resolve timezone for a user (try personal setting, then fallback to site tz)
    $resolve_user_tz = function($uid) {
        if (!$uid) return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        $tz = get_user_option('timezone_string', $uid);
        if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
        return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
    };

    $student_tz = $resolve_user_tz($viewer_id);

    foreach ($teacher_ids as $tid) {
        $out_days = [];

        $teacher_tz = e360_get_teacher_timezone_string((int)$tid);
        // compute start date in teacher's timezone so slots align with teacher local days
        try {
            $teacher_now = new DateTimeImmutable('now', new DateTimeZone($teacher_tz));
        } catch (Exception $e) {
            $teacher_now = new DateTimeImmutable('now', new DateTimeZone((function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC')));
        }

        for ($i = 0; $i < $days; $i++) {
            $date = $teacher_now->modify("+$i day")->format('Y-m-d');

            $slots = function_exists('e360_generate_slots_for_teacher_date')
                ? e360_generate_slots_for_teacher_date((int)$tid, $date, $duration)
                : [];

            $count = is_array($slots) ? count($slots) : 0;
            $times = [];
            foreach ((array)$slots as $s) {
                $t = e360_slot_hhmm($s);
                if ($t === '') continue;

                // convert teacher local slot (date + time) into student's timezone for display
                try {
                    $dtTeacher = new DateTimeImmutable($date . ' ' . $t, new DateTimeZone($teacher_tz));
                    $dtStudent = $dtTeacher->setTimezone(new DateTimeZone($student_tz));
                    $times[] = $dtStudent->format('H:i');
                } catch (Exception $e) {
                    // fallback to raw hh:mm
                    $times[] = $t;
                }
            }

            $out_days[] = [
                'date'  => $date,
                'count' => $count,
                'times' => $times,
            ];
        }

        $items[$tid] = ['days' => $out_days];
    }

    wp_send_json_success(['items' => $items]);
}


add_action('wp_ajax_e360_get_slots', 'e360_get_slots');
add_action('wp_ajax_nopriv_e360_get_slots', 'e360_get_slots');

function e360_get_slots() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $teacher_id = isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0;
    $date       = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $duration   = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;

    if (!$teacher_id || !$date) {
        wp_send_json_error(['message' => 'teacher_id and date required']);
    }

    $slots = function_exists('e360_generate_slots_for_teacher_date')
        ? e360_generate_slots_for_teacher_date($teacher_id, $date, $duration)
        : [];

    // Determine student timezone (viewer)
    $viewer_id = get_current_user_id();
    $resolve_user_tz = function($uid) {
        if (!$uid) return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        $tz = get_user_option('timezone_string', $uid);
        if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
        return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
    };
    $student_tz = $resolve_user_tz($viewer_id);

    // Get teacher timezone
    if (!function_exists('e360_get_teacher_timezone_string')) {
        function e360_get_teacher_timezone_string($uid) {
            $tz = get_user_option('timezone_string', $uid);
            if ($tz && in_array($tz, timezone_identifiers_list(), true)) return $tz;
            return (function_exists('wp_timezone_string') ? wp_timezone_string() : 'UTC');
        }
    }
    $teacher_tz = e360_get_teacher_timezone_string($teacher_id);

    $times = [];
    foreach ((array)$slots as $s) {
        $t = e360_slot_hhmm($s);
        if ($t === '') continue;
        try {
            $dtTeacher = new DateTimeImmutable($date . ' ' . $t, new DateTimeZone($teacher_tz));
            $dtStudent = $dtTeacher->setTimezone(new DateTimeZone($student_tz));
            $times[] = $dtStudent->format('H:i');
        } catch (Exception $e) {
            $times[] = $t;
        }
    }

    wp_send_json_success(['slots' => $times]);
}
add_shortcode('e360_booking_wizard', function($atts){
    $atts = shortcode_atts([
        'taxonomy'        => 'course-category',
        'duration'        => 60,
        'registration_url'=> 'https://lms.english360.ca/student-registration/',
        'only_parent_terms' => 1,
    ], $atts);

    $taxonomy = sanitize_key($atts['taxonomy']);
    $duration = (int) $atts['duration'];
    $registration_url = esc_url_raw($atts['registration_url']);
    $only_parent = (int) $atts['only_parent_terms'];

    $term_args = [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ];
    if ($only_parent) $term_args['parent'] = 0;

    $languages = get_terms($term_args);
    if (is_wp_error($languages)) return '<p>Cannot load languages.</p>';

    wp_enqueue_script('jquery');
    $nonce = wp_create_nonce('e360_booking_nonce');

    ob_start();
    ?>
<div id="e360-wizard" data-taxonomy="<?php echo esc_attr($taxonomy); ?>"
    data-duration="<?php echo esc_attr($duration); ?>"
    data-registration-url="<?php echo esc_attr($registration_url); ?>">
    <p>
        <label>Language</label><br>
    <div id="e360-language" class="e360-language-cards"
        style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;">
        <?php foreach ($languages as $t): ?>
        <?php
                $term_id = (int) $t->term_id;
                $thumb_id = get_term_meta($term_id, 'thumbnail_id', true);
                $img = '';
                if ($thumb_id) $img = wp_get_attachment_image_url($thumb_id, 'medium');
            ?>
        <div class="e360-language-card" data-term-id="<?php echo $term_id; ?>"
            style="border:1px solid #ddd;border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;">
            <?php if ($img): ?>
            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($t->name); ?>"
                style="width:48px;height:48px;border-radius:6px;object-fit:cover;">
            <?php else: ?>
            <div
                style="width:48px;height:48px;border-radius:6px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-weight:600;color:#555;">
                <?php echo esc_html(mb_substr($t->name,0,1)); ?>
            </div>
            <?php endif; ?>
            <div style="flex:1;">
                <div style="font-weight:600;"><?php echo esc_html($t->name); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </p>

    <div id="e360-step-level" style="display:none;">
        <p>
            <label>Level</label><br>
        <div id="e360-level" class="e360-level-cards"
            style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;">
            <div style="opacity:.7">Select language first…</div>
        </div>
        </p>
    </div>

    <div id="e360-step-course" style="display:none;">
        <p>
            <label>Course</label><br>
        <div id="e360-course" class="e360-course-cards"
            style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:10px;">
            <div style="opacity:.7">Select level first…</div>
        </div>
        </p>

        <div id="e360-teacher-list" style="margin:10px 0;"></div>
    </div>

    <div id="e360-step-time" style="display:none;">
        <p>
            <label>Select Date</label><br>
            <input type="date" id="e360-date" min="<?php echo esc_attr(date('Y-m-d')); ?>">
        </p>
        <p>
            <label>Available times</label><br>
            <select id="e360-time">
                <option value="">Select date first…</option>
            </select>
        </p>
        <p>
            <label>Choose package</label><br>
            <select id="e360-plan">
                <option value="">Select…</option>
            </select>
        </p>

        <p>
            <label>Lesson type</label><br>
            <select id="e360-repeat">
                <option value="weekly" selected>Weekly</option>
                <option value="once">One-time</option>
            </select>
        </p>



        <p>
            <button type="button" id="e360-continue" class="tutor-btn tutor-btn-primary">Continue</button>
        </p>

        <div id="e360-msg" style="margin-top:10px;"></div>
    </div>
</div>

<script>
jQuery(function($) {
    const nonce = <?php echo json_encode($nonce); ?>;
    const ajaxurl = <?php echo json_encode(admin_url('admin-ajax.php')); ?>;

    const $wiz = $('#e360-wizard');

    let coursesIndex = {}; // course_key => {course_title, variants:[]}


    let selected = {
        taxonomy: $wiz.data('taxonomy'),
        duration: parseInt($wiz.data('duration'), 10) || 60,
        language_term_id: null,
        level_term_id: null,
        course_id: null,
        teacher_id: null,
        teacher_name: null,
        course_title: null,
        date: null,
        time: null,
        plan_product_id: null,
        course_key: null,
        repeat: 'weekly',
    };

    function resetAfterLanguage() {
        // visually unselect any language cards
        $('.e360-language-card').css('border-color', '#ddd');
        $('#e360-level').html('<div style="opacity:.7">Select language first…</div>');
        $('#e360-course').html('<div style="opacity:.7">Select level first…</div>');
        $('#e360-teacher-list').empty();
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-level, #e360-step-course, #e360-step-time').hide();
        selected.level_term_id = selected.course_id = selected.teacher_id = null;
        selected.teacher_name = selected.course_title = null;
        selected.date = selected.time = null;
    }

    function resetAfterLevel() {
        // visually unselect any level cards
        $('.e360-level-card').css('border-color', '#ddd');
        $('#e360-course').html('<div style="opacity:.7">Loading…</div>');
        $('#e360-teacher-list').empty();
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-date').val('');
        $('#e360-step-course').show();
        $('#e360-step-time').hide();
        selected.course_id = selected.teacher_id = null;
        selected.teacher_name = selected.course_title = null;
        selected.date = selected.time = null;
    }

    function loadLevels(languageTermId) {
        $('#e360-step-level').show();
        $('#e360-level').html('<div style="opacity:.7">Loading…</div>');

        $.post(ajaxurl, {
            action: 'e360_get_child_terms',
            nonce,
            taxonomy: selected.taxonomy,
            parent_term_id: languageTermId
        }).done(function(resp) {
            if (!resp.success) {
                $('#e360-level').html('<div>Error</div>');
                return;
            }
            const items = resp.data.items || [];
            if (!items.length) {
                $('#e360-level').html('<div>No levels</div>');
                return;
            }

            // render level cards
            let html = '';
            items.forEach(function(it) {
                html +=
                    `<div class="e360-level-card" data-term-id="${it.term_id}" style="border:1px solid #ddd;border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;gap:8px;">` +
                    `<div style="flex:1;font-weight:600;">${$('<div>').text(it.name).html()}</div>` +
                    `</div>`;
            });

            $('#e360-level').html(html);
        });
    }

    function loadCourses(levelTermId) {
        resetAfterLevel();

        $.post(ajaxurl, {
            action: 'e360_get_courses_by_term',
            nonce,
            taxonomy: selected.taxonomy,
            term_id: levelTermId
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('#e360-course').html('<option value="">Error</option>');
                return;
            }

            const items = resp.data.items || [];
            coursesIndex = {};

            if (!items.length) {
                $('#e360-course').html('<option value="">No courses</option>');
                return;
            }

            // render course cards (was a <select> before)
            let courseHtml = '';
            items.forEach(function(group) {
                coursesIndex[group.course_key] = group;
                courseHtml +=
                    `<div class="e360-course-card" data-course-key="${group.course_key}" data-course-title="${$('<div>').text(group.course_title).html()}" style="border:1px solid #ddd;border-radius:8px;padding:8px;cursor:pointer;display:flex;align-items:center;">` +
                    `<div style="flex:1;font-weight:600;">${$('<div>').text(group.course_title).html()}</div>` +
                    `</div>`;
            });
            $('#e360-course').html(courseHtml);

            // Спрячем учителей/время пока курс не выбран
            $('#e360-teacher-list').empty();
            $('#e360-step-time').hide();
            selected.course_key = null;
            selected.course_id = null;
            selected.teacher_id = null;
            selected.teacher_name = null;
            selected.course_title = null;
        });
    }


    function loadSlots(teacherId, date) {
        $('#e360-time').html('<option value="">Loading…</option>');

        $.post(ajaxurl, {
            action: 'e360_get_slots',
            nonce,
            teacher_id: teacherId,
            date: date,
            duration: selected.duration
        }).done(function(resp) {
            if (!resp.success) {
                $('#e360-time').html('<option value="">Error</option>');
                return;
            }
            const slots = resp.data.slots || [];
            if (!slots.length) {
                $('#e360-time').html('<option value="">No available slots</option>');
                return;
            }
            $('#e360-time').html('<option value="">Select…</option>');
            slots.forEach(function(s) {
                $('#e360-time').append($('<option>', {
                    value: s,
                    text: s.substring(0, 5)
                }));
            });
        });
    }

    // Step 1: language (cards)
    $(document).on('click', '.e360-language-card', function() {
        resetAfterLanguage();
        $('.e360-language-card').css('border-color', '#ddd');
        $(this).css('border-color', '#333');

        const langId = parseInt($(this).data('term-id'), 10) || 0;
        if (!langId) return;
        selected.language_term_id = langId;
        loadLevels(langId);
    });

    // Step 2: level (cards)
    $(document).on('click', '.e360-level-card', function() {
        $('.e360-level-card').css('border-color', '#ddd');
        $(this).css('border-color', '#333');

        const levelId = parseInt($(this).data('term-id'), 10) || 0;
        selected.level_term_id = levelId || null;
        if (!levelId) return;
        loadCourses(levelId);
    });

    // Step 3: course (+ teacher auto) — course cards are clickable
    $(document).on('click', '.e360-course-card', function() {
        const courseKey = $(this).data('course-key') || '';
        selected.course_key = courseKey || null;

        // reset selection
        selected.course_id = null;
        selected.teacher_id = null;
        selected.teacher_name = null;
        selected.course_title = null;
        selected.date = null;
        selected.time = null;

        $('#e360-date').val('');
        $('#e360-time').html('<option value="">Select date first…</option>');
        $('#e360-step-time').hide();

        const group = coursesIndex[courseKey];
        if (!group || !group.variants || !group.variants.length) {
            $('#e360-teacher-list').html('<div>No teachers found for this course.</div>');
            return;
        }

        // Рисуем карточки учителей
        const teachers = group.variants;
        const teacherIds = [];

        let html =
            '<div class="e360-teachers" style="display:grid;grid-template-columns:1fr;gap:10px;">';
        teachers.forEach(function(v) {
            teacherIds.push(parseInt(v.teacher_id, 10));

            const avatar = v.teacher_avatar ?
                `<img src="${v.teacher_avatar}" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;">` :
                '';

            // short snippet removed — keep only full bio behind the Bio button

            // full html уже sanitized на сервере, но защитим template literal от ` (редко, но бывает)
            const fullBioSafe = (v.teacher_bio_html || '').replace(/`/g, '&#96;');
            const bioFull = fullBioSafe ?
                `<div class="e360-bio-full" style="display:none;margin-top:8px;">${fullBioSafe}</div>` :
                '';

            const role = v.teacher_role ?
                `<div style="font-size:12px;opacity:.7;margin-top:2px;">${$('<div>').text(v.teacher_role).html()}</div>` :
                '';

            const bioBtn = fullBioSafe ?
                `<button type="button" class="e360-toggle-bio tutor-btn tutor-btn-outline-primary tutor-btn-sm" style="margin-top:8px;">Bio</button>` :
                '';

            const chooseBtn =
                `<button type="button" class="e360-choose-teacher tutor-btn tutor-btn-primary tutor-btn-sm tutor-ws-nowrap" style="margin-top:8px;">
            Choose this teacher
         </button>`;

            html += `
        <div class="e360-teacher-card"
             data-teacher-id="${v.teacher_id}"
             data-course-id="${v.course_id}"
             data-teacher-name="${$('<div>').text(v.teacher_name||'').html()}"
             style="border:1px solid #ddd;border-radius:12px;padding:10px;">
            <div style="display:flex;gap:10px;align-items:flex-start;">
                <div>${avatar}</div>
                <div style="flex:1;">
                    <div style="font-weight:600;">${$('<div>').text(v.teacher_name || '').html()}</div>
                    ${role}
                    ${bioBtn}
                    ${bioFull}

                    <div class="e360-schedule" style="margin-top:10px;font-size:13px;">
                        <em>Loading schedule…</em>
                    </div>

                    <div style="margin-top:10px;">
                        ${chooseBtn}
                    </div>
                </div>
            </div>
        </div>`;
        });

        html += '</div>';

        $('#e360-teacher-list').html(html);

        // toggle bio
        $(document).off('click.e360bio').on('click.e360bio', '.e360-toggle-bio', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.e360-teacher-card').find('.e360-bio-full').toggle();
        });

        // choose teacher (кнопка)
        $(document).off('click.e360choosebtn').on('click.e360choosebtn', '.e360-choose-teacher',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).closest('.e360-teacher-card').trigger('click');

                // мягко докрутим к выбору времени
                const $step = $('#e360-step-time');
                if ($step.length) {
                    $('html, body').animate({
                        scrollTop: $step.offset().top - 80
                    }, 250);
                }
            });

        // card click = select teacher
        $(document).off('click.e360card').on('click.e360card', '.e360-teacher-card', function() {
            $('.e360-teacher-card').css('border-color', '#ddd');
            $(this).css('border-color', '#333');

            const teacherId = parseInt($(this).data('teacher-id'), 10) || 0;
            const courseId = parseInt($(this).data('course-id'), 10) || 0;
            const teacherName = $(this).data('teacher-name') || null;

            selected.teacher_id = teacherId || null;
            selected.course_id = courseId || null;
            selected.teacher_name = teacherName || null;

            $('#e360-step-time').show();
        });


        // одним запросом подтягиваем расписание на 7 дней
        $.post(ajaxurl, {
            action: 'e360_get_schedule_preview_bulk',
            nonce,
            duration: selected.duration,
            teacher_ids: JSON.stringify([...new Set(teacherIds)])
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $('.e360-schedule').html('<em>Schedule unavailable</em>');
                return;
            }

            const map = resp.data.items || {};
            $('.e360-teacher-card').each(function() {
                const tid = parseInt($(this).data('teacher-id'), 10);
                const data = map[tid];
                if (!data || !data.days) {
                    $(this).find('.e360-schedule').html('<em>No schedule</em>');
                    return;
                }

                let s =
                    '<div style="font-weight:600;margin-bottom:4px;">Next 7 days</div>';
                s +=
                    '<div style="display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px;">';

                data.days.forEach(function(d) {
                    const dateObj = new Date(d.date);
                    const weekday = dateObj.toLocaleDateString('en-US', {
                        weekday: 'short'
                    });
                    const day = d.date.slice(5); // MM-DD
                    const times = (d.times && d.times.length) ? d.times.join(
                        ', ') : '—';
                    s += `<div style="border:1px solid #eee;border-radius:10px;padding:6px;">
                        <div style="font-size:12px;opacity:.8;">${weekday}, ${day}</div>
                        <div style="font-size:12px;">${times}</div>
                      </div>`;
                });

                s += '</div>';
                $(this).find('.e360-schedule').html(s);
            });
        });

        // Пакеты можно грузить сразу (они универсальные)
        loadPlans();

        $('#e360-repeat').on('change', function() {
            selected.repeat = $(this).val() || 'weekly';
        });


        $(document).on('click', '.e360-teacher-card', function() {
            // визуально выделяем
            $('.e360-teacher-card').css('border-color', '#ddd');
            $(this).css('border-color', '#333');

            const teacherId = parseInt($(this).data('teacher-id'), 10) || 0;
            const courseId = parseInt($(this).data('course-id'), 10) || 0;
            const teacherName = $(this).data('teacher-name') || null;

            selected.teacher_id = teacherId || null;
            selected.course_id = courseId || null;
            selected.teacher_name = teacherName || null;

            // course_title на registration покажем как реальный title выбранного course post
            selected.course_title = courseId ? null :
                null; // можно не хранить, ты и так берёшь title по ID на registration

            if (!teacherId || !courseId) return;

            $('#e360-step-time').show();
        });

    });


    // Step 4: date -> slots
    $('#e360-date').on('change', function() {
        const date = $(this).val();
        selected.date = date || null;
        if (!date || !selected.teacher_id) return;
        loadSlots(selected.teacher_id, date);
    });

    $('#e360-time').on('change', function() {
        selected.time = $(this).val() || null;
    });

    $('#e360-plan').on('change', function() {
        selected.plan_product_id = parseInt($(this).val(), 10) || null;
    });


    // Continue -> student registration
    $('#e360-continue').on('click', function() {
        if (!selected.language_term_id || !selected.level_term_id || !selected.course_id || !selected
            .teacher_id || !selected.date || !selected.time) {
            $('#e360-msg').text('Select language, level, course, date and time first.');
            return;
        }
        if (!selected.plan_product_id) {
            $('#e360-msg').text('Select a package first.');
            return;
        }

        const regUrl = $wiz.data('registration-url');
        const url = new URL(regUrl);

        url.searchParams.set('language_term_id', selected.language_term_id);
        url.searchParams.set('level_term_id', selected.level_term_id);
        url.searchParams.set('course_id', selected.course_id);
        url.searchParams.set('teacher_id', selected.teacher_id);
        url.searchParams.set('date', selected.date);
        url.searchParams.set('time', selected.time);
        url.searchParams.set('plan_product_id', selected.plan_product_id);
        url.searchParams.set('duration', selected.duration);
        url.searchParams.set('repeat', selected.repeat);



        window.location.href = url.toString();
    });


    function loadPlans() {
        const $plan = $('#e360-plan');
        $plan.html('<option value="">Loading…</option>');

        $.post(ajaxurl, {
            action: 'e360_get_plans',
            nonce
        }).done(function(resp) {
            if (!resp || !resp.success) {
                $plan.html('<option value="">Error</option>');
                return;
            }

            const items = resp.data.items || [];
            if (!items.length) {
                $plan.html('<option value="">No packages found</option>');
                return;
            }

            $plan.html('<option value="">Select…</option>');
            items.forEach(function(it) {
                $plan.append($('<option>', {
                    value: it.product_id,
                    text: it.title + (it.price_text ? ' — ' + it.price_text : '')
                }));
            });
        });
    }


});
</script>
<?php
    return ob_get_clean();
});


add_shortcode('e360_registration_booking_context', function () {
    $term_id    = isset($_GET['term_id']) ? (int) $_GET['term_id'] : 0;
    $course_id  = isset($_GET['course_id']) ? (int) $_GET['course_id'] : 0;
    $teacher_id = isset($_GET['teacher_id']) ? (int) $_GET['teacher_id'] : 0;
    $date       = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $time       = isset($_GET['time']) ? sanitize_text_field($_GET['time']) : '';

    if (!$course_id || !$teacher_id || !$date || !$time) {
        return ''; // если пришли без параметров — ничего не показываем
    }

    $course  = get_post($course_id);
    $teacher = get_user_by('id', $teacher_id);

    $course_title  = $course ? $course->post_title : ('Course #' . $course_id);
    $teacher_name  = $teacher ? $teacher->display_name : ('Teacher #' . $teacher_id);

    // имя категории (языка)
    $term_name = '';
    if ($term_id) {
        $t = get_term($term_id);
        if ($t && !is_wp_error($t)) $term_name = $t->name;
    }

    ob_start(); ?>
<div class="e360-selected-booking" style="padding:12px;border:1px solid #ddd;margin:12px 0;">
    <strong>Your selection:</strong><br>
    <?php if ($term_name) : ?>
    Language: <?php echo esc_html($term_name); ?><br>
    <?php endif; ?>
    Teacher: <?php echo esc_html($teacher_name); ?><br>
    Course: <?php echo esc_html($course_title); ?><br>
    Date/Time: <?php echo esc_html($date . ' ' . substr($time, 0, 5)); ?>
</div>

<div id="e360-hidden-context" style="display:none;">
    <input type="hidden" name="e360_term_id" value="<?php echo esc_attr($term_id); ?>">
    <input type="hidden" name="e360_course_id" value="<?php echo esc_attr($course_id); ?>">
    <input type="hidden" name="e360_teacher_id" value="<?php echo esc_attr($teacher_id); ?>">
    <input type="hidden" name="e360_booking_date" value="<?php echo esc_attr($date); ?>">
    <input type="hidden" name="e360_booking_time" value="<?php echo esc_attr($time); ?>">
</div>

<script>
jQuery(function($) {
    // Пытаемся найти форму регистрации и добавить hidden-поля внутрь
    const $form =
        $('.tutor-register-wrap form').first().length ? $('.tutor-register-wrap form').first() :
        $('form').first();

    if ($form.length) {
        $('#e360-hidden-context input').each(function() {
            const $i = $(this);
            // не дублировать если уже вставлено
            if (!$form.find('input[name="' + $i.attr('name') + '"]').length) {
                $form.append($i.clone());
            }
        });
    }
});
</script>
<?php
    return ob_get_clean();
});


add_action('user_register', function($user_id){

    $ctx = null;

    // preferred: full JSON context (injected by some registration shortcode)
    if (!empty($_POST['e360_booking_ctx'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx']);
        $ctx = json_decode($raw, true);
    }

    // fallback: individual hidden inputs (older shortcode / simple hidden fields)
    if (!is_array($ctx) || !$ctx) {
        // collect from various possible input names
        $course_id = isset($_POST['e360_course_id']) ? (int) $_POST['e360_course_id'] : (isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0);
        $teacher_id = isset($_POST['e360_teacher_id']) ? (int) $_POST['e360_teacher_id'] : (isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0);
        $date = isset($_POST['e360_booking_date']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_date'])) : (isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '');
        $time = isset($_POST['e360_booking_time']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_time'])) : (isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '');
        $language_term_id = isset($_POST['e360_term_id']) ? (int) $_POST['e360_term_id'] : (isset($_POST['language_term_id']) ? (int) $_POST['language_term_id'] : 0);
        $level_term_id = isset($_POST['level_term_id']) ? (int) $_POST['level_term_id'] : (isset($_POST['e360_level_id']) ? (int) $_POST['e360_level_id'] : 0);
        $plan_product_id = isset($_POST['plan_product_id']) ? (int) $_POST['plan_product_id'] : (isset($_POST['plan']) ? (int) $_POST['plan'] : 0);

        if ($course_id && $teacher_id && $date && $time) {
            $ctx = [
                'language_term_id' => $language_term_id,
                'level_term_id'    => $level_term_id,
                'course_id'        => $course_id,
                'teacher_id'       => $teacher_id,
                'date'             => $date,
                'time'             => $time,
                'plan_product_id'  => $plan_product_id,
            ];
        }
    }

    if (!is_array($ctx)) return;

    $plan_id = (int)($ctx['plan_product_id'] ?? 0);

    $clean = [
        'language_term_id' => (int)($ctx['language_term_id'] ?? 0),
        'level_term_id'    => (int)($ctx['level_term_id'] ?? 0),
        'course_id'        => (int)($ctx['course_id'] ?? 0),
        'teacher_id'       => (int)($ctx['teacher_id'] ?? 0),
        'date'             => sanitize_text_field($ctx['date'] ?? ''),
        'time'             => sanitize_text_field($ctx['time'] ?? ''),
        'plan_product_id'  => $plan_id,
        'created_at'       => current_time('mysql'),
    ];

    update_user_meta($user_id, 'e360_booking_context', $clean);
    update_user_meta($user_id, 'e360_primary_teacher_id', (int)($ctx['teacher_id'] ?? 0));
    update_user_meta($user_id, 'e360_primary_course_id', (int)($ctx['course_id'] ?? 0));
    if (function_exists('e360_create_booking_from_context')) {
    e360_create_booking_from_context((int)$user_id, $clean);
    }



    if ($plan_id) {
        update_user_meta($user_id, 'e360_plan_to_checkout_once', $plan_id);

        // cookie на 10 минут, чтобы пережить любые редиректы после регистрации
        setcookie('e360_go_checkout', '1', time() + 600, COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), true);
    }

}, 10, 1);


add_action('template_redirect', function(){
    if (is_admin() || wp_doing_ajax()) return;

    // запускаем только если cookie есть
    if (empty($_COOKIE['e360_go_checkout'])) return;

    // если не залогинен — на логин, потом вернёмся сюда же
    if (!is_user_logged_in()) {
        $here = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        wp_safe_redirect( wp_login_url($here) );
        exit;
    }

    // залогинен — убираем cookie, чтобы не зациклить
    setcookie('e360_go_checkout', '', time() - 3600, COOKIEPATH ?: '/', COOKIE_DOMAIN);

    $user_id = get_current_user_id();
    $plan_id = (int) get_user_meta($user_id, 'e360_plan_to_checkout_once', true);
    if (!$plan_id) return;

    delete_user_meta($user_id, 'e360_plan_to_checkout_once');

    if (function_exists('WC') && WC()->cart) {
        // обычно лучше чистить, чтобы в оплате был 1 пакет
        WC()->cart->empty_cart();
        WC()->cart->add_to_cart($plan_id);
    }

    wp_safe_redirect( wc_get_checkout_url() );
    exit;
});



add_action('wp_ajax_e360_get_child_terms', 'e360_get_child_terms');
add_action('wp_ajax_nopriv_e360_get_child_terms', 'e360_get_child_terms');

function e360_get_child_terms() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    $parent_id = isset($_POST['parent_term_id']) ? (int) $_POST['parent_term_id'] : 0;
    $taxonomy  = isset($_POST['taxonomy']) ? sanitize_key($_POST['taxonomy']) : 'course-category';

    if ($parent_id <= 0) {
        wp_send_json_error(['message' => 'parent_term_id required']);
    }

    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => $parent_id,
    ]);

    if (is_wp_error($terms)) {
        wp_send_json_error(['message' => 'Cannot load terms']);
    }

    $items = [];
    foreach ($terms as $t) {
        $items[] = [
            'term_id' => (int) $t->term_id,
            'name'    => $t->name,
            'slug'    => $t->slug,
        ];
    }

    wp_send_json_success(['items' => $items]);
}

// 1) Рендерим блок на странице student-registration
add_action('wp_footer', function () {
    if (!is_page('student-registration')) return;

    $course_id  = isset($_GET['course_id']) ? (int) $_GET['course_id'] : 0;
    $teacher_id = isset($_GET['teacher_id']) ? (int) $_GET['teacher_id'] : 0;
    $date       = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $time       = isset($_GET['time']) ? sanitize_text_field($_GET['time']) : '';

    $language_term_id = isset($_GET['language_term_id']) ? (int) $_GET['language_term_id'] : 0;
    $level_term_id    = isset($_GET['level_term_id']) ? (int) $_GET['level_term_id'] : 0;

    $plan_product_id = isset($_GET['plan_product_id']) ? (int) $_GET['plan_product_id'] : 0;


    // Если параметров нет — ничего не показываем.
    if (!$course_id || !$teacher_id || !$date || !$time) return;

    $course_title = $course_id ? get_the_title($course_id) : '';
    $teacher = get_user_by('id', $teacher_id);
    $teacher_name = $teacher ? $teacher->display_name : ('Teacher #'.$teacher_id);
    $duration = isset($_GET['duration']) ? (int) $_GET['duration'] : 60;
    $repeat   = isset($_GET['repeat']) ? sanitize_text_field($_GET['repeat']) : 'weekly';


    $ctx = [
        'language_term_id' => $language_term_id,
        'level_term_id'    => $level_term_id,
        'course_id'        => $course_id,
        'teacher_id'       => $teacher_id,
        'date'             => $date,
        'time'             => $time,
        'plan_product_id' => $plan_product_id,
        'duration' => $duration,
        'repeat'   => $repeat,


    ];
    $ctx_json = wp_json_encode($ctx);

    $plan_title = '';
$plan_price = '';
if ($plan_product_id && function_exists('wc_get_product')) {
    $p = wc_get_product($plan_product_id);
    if ($p) {
        $plan_title = $p->get_name();
        $plan_price = trim(wp_strip_all_tags($p->get_price_html()));
    }
}


    ?>
<div id="e360-reg-context" style="padding:12px;border:1px solid #ddd;border-radius:10px;margin:12px 0;">
    <div style="font-weight:600;margin-bottom:6px;">Your lesson request</div>
    <div><strong>Course:</strong> <?php echo esc_html($course_title ?: ('#'.$course_id)); ?></div>
    <div><strong>Teacher:</strong> <?php echo esc_html($teacher_name); ?></div>
    <div><strong>Date/time:</strong> <?php echo esc_html($date . ' ' . substr($time,0,5)); ?></div>
    <?php if ($plan_title): ?>
    <div><strong>Package:</strong> <?php echo esc_html($plan_title . ($plan_price ? ' — ' . $plan_price : '')); ?></div>
    <div><strong>Type:</strong> <?php echo esc_html($repeat === 'once' ? 'One-time' : 'Weekly'); ?></div>

    <?php endif; ?>

</div>

<script>
(function() {
    // 1) Вставляем блок перед регистрационной формой
    var box = document.getElementById('e360-reg-context');
    if (!box) return;

    var form = document.querySelector('form'); // fallback
    // попробуем найти “правильную” форму Tutor
    var tutorForm = document.querySelector('form input[name="tutor_register_nonce"]');
    if (tutorForm) form = tutorForm.closest('form');

    if (form && form.parentNode) {
        form.parentNode.insertBefore(box, form);
    }

    // 2) Добавляем скрытое поле с контекстом, чтобы на user_register это поймать
    if (form) {
        var hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'e360_booking_ctx';
        hidden.value = <?php echo json_encode($ctx_json); ?>;
        form.appendChild(hidden);
    }
})();
</script>
<?php
});

function e360_render_booking_context_in_profile($user){
    $ctx = get_user_meta($user->ID, 'e360_booking_context', true);
    if (empty($ctx) || !is_array($ctx)) return;

    $course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
    $teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;

    ?>
<h2>English360 Booking Context</h2>
<table class="form-table" role="presentation">
    <tr>
        <th>Course</th>
        <td><?php echo esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))); ?></td>
    </tr>
    <tr>
        <th>Teacher</th>
        <td><?php echo esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? ''))); ?></td>
    </tr>
    <tr>
        <th>Date / time</th>
        <td><?php echo esc_html(($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5)); ?></td>
    </tr>
    <tr>
        <th>Saved</th>
        <td><?php echo esc_html($ctx['created_at'] ?? ''); ?></td>
    </tr>
</table>
<?php
}
add_action('show_user_profile', 'e360_render_booking_context_in_profile');
add_action('edit_user_profile', 'e360_render_booking_context_in_profile');

add_action('wp_ajax_e360_get_plans', 'e360_get_plans');
add_action('wp_ajax_nopriv_e360_get_plans', 'e360_get_plans');

function e360_get_plans() {
    check_ajax_referer('e360_booking_nonce', 'nonce');

    if ( ! function_exists('wc_get_product') ) {
        wp_send_json_error(['message' => 'WooCommerce not active']);
    }

    // Можно оставить whitelist (как у тебя)
    $plan_ids = [196, 158, 156, 57];

    $items = [];
    foreach ($plan_ids as $pid) {
        $product = wc_get_product($pid);
        if (!$product) continue;

        // НЕ отбрасываем purchasable — иногда плагины/подписки дают false в неожиданных местах
        $price_html = $product->get_price_html();
        $price_text = trim(wp_strip_all_tags($price_html));

        $items[] = [
            'product_id' => (int) $pid,
            'title'      => $product->get_name(),
            'price_html' => $price_html,
            'price_text' => $price_text,
            'type'       => $product->get_type(),
        ];
    }

    wp_send_json_success(['items' => $items]);
}

/**
 * Берём значение из $_POST по списку возможных ключей.
 */
function e360_post_first_nonempty(array $keys): string {
    foreach ($keys as $k) {
        if (!empty($_POST[$k])) {
            return sanitize_text_field(wp_unslash($_POST[$k]));
        }
    }
    return '';
}

/**
 * При регистрации: переносим данные в Woo billing_* meta,
 * чтобы checkout был предзаполнен.
 */
add_action('user_register', function($user_id){

    // если WooCommerce не активен — просто выходим
    if (!function_exists('wc_get_checkout_url')) return;

    $user = get_userdata($user_id);

    // Tutor/WordPress формы могут использовать разные name=""
    $first = e360_post_first_nonempty(['first_name', 'fname', 'tutor_first_name', 'student_first_name']);
    $last  = e360_post_first_nonempty(['last_name', 'lname', 'tutor_last_name', 'student_last_name']);
    $phone = e360_post_first_nonempty(['phone', 'billing_phone', 'tutor_phone', 'student_phone', 'phone_number']);

    // На всякий: email обычно уже в $user->user_email
    $email = ($user && !empty($user->user_email)) ? sanitize_email($user->user_email) : '';
    if (!$email) {
        $email = sanitize_email(e360_post_first_nonempty(['email', 'user_email']));
    }

    // Не перетираем, если у пользователя уже заполнено
    $set_if_empty = function(string $meta_key, string $value) use ($user_id) {
        if ($value === '') return;
        $existing = get_user_meta($user_id, $meta_key, true);
        if ($existing === '' || $existing === null) {
            update_user_meta($user_id, $meta_key, $value);
        }
    };

    // WP core (иногда полезно для профиля)
    $set_if_empty('first_name', $first);
    $set_if_empty('last_name',  $last);

    // Woo billing (это подтянется на checkout автоматически)
    $set_if_empty('billing_first_name', $first);
    $set_if_empty('billing_last_name',  $last);
    $set_if_empty('billing_phone',      $phone);
    $set_if_empty('billing_email',      $email);

}, 20, 1);

add_filter('woocommerce_checkout_get_value', function($value, $input){
    if (!empty($value)) return $value;
    if (!is_user_logged_in()) return $value;

    $uid = get_current_user_id();

    switch ($input) {
        case 'billing_first_name':
            return get_user_meta($uid, 'billing_first_name', true) ?: get_user_meta($uid, 'first_name', true);
        case 'billing_last_name':
            return get_user_meta($uid, 'billing_last_name', true) ?: get_user_meta($uid, 'last_name', true);
        case 'billing_phone':
            return get_user_meta($uid, 'billing_phone', true);
        case 'billing_email':
            $u = wp_get_current_user();
            return get_user_meta($uid, 'billing_email', true) ?: ($u->user_email ?? '');
    }
    return $value;
}, 10, 2);

// 1) Секция в Checkout settings
add_filter('woocommerce_get_sections_checkout', function($sections){
    $sections['english360'] = 'English360';
    return $sections;
});

// 2) Поля настроек секции
add_filter('woocommerce_get_settings_checkout', function($settings, $current_section){

    if ($current_section !== 'english360') return $settings;

    $settings = [];

    $settings[] = [
        'title' => 'English360 checkout fields',
        'type'  => 'title',
        'id'    => 'e360_checkout_fields_title',
    ];

    $settings[] = [
        'title'   => 'Referral sources (one per line)',
        'desc'    => 'These values will be used in "How did you hear about us?" dropdown.',
        'id'      => 'e360_referral_sources',
        'type'    => 'textarea',
        'css'     => 'min-width:400px;min-height:120px;',
        'default' => "Google\nInstagram\nFriend recommendation\nOther",
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id'   => 'e360_checkout_fields_title',
    ];

    return $settings;

}, 10, 2);

/**
 * Достаём варианты из опции (по 1 в строке)
 */
function e360_get_referral_sources(): array {
    $raw = (string) get_option('e360_referral_sources', '');
    $lines = preg_split("/\r\n|\n|\r/", $raw);
    $out = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line !== '') $out[] = $line;
    }
    return $out;
}

add_filter('woocommerce_checkout_fields', function($fields){

    // Убедимся что телефон есть и обязателен
    if (!empty($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required'] = true;
        $fields['billing']['billing_phone']['priority'] = 25;
    }

    // How did you hear about us? (select)
    $options = ['' => 'Select…'];
    foreach (e360_get_referral_sources() as $src) {
        $options[$src] = $src;
    }

    $fields['billing']['e360_referral_source'] = [
        'type'     => 'select',
        'label'    => 'How did you hear about us?',
        'required' => true, // если хочешь optional — поставь false
        'options'  => $options,
        'priority' => 60,
        'class'    => ['form-row-wide'],
    ];

    // Birthday (optional)
    $fields['billing']['e360_birthdate'] = [
        'type'        => 'date',
        'label'       => 'Birthday (optional)',
        'required'    => false,
        'priority'    => 70,
        'class'       => ['form-row-first'],
        'placeholder' => '',
    ];

    // Has WhatsApp checkbox
    $fields['billing']['e360_has_whatsapp'] = [
        'type'     => 'checkbox',
        'label'    => 'My phone has WhatsApp',
        'required' => false,
        'priority' => 80,
        'class'    => ['form-row-last'],
        'default'  => 1, // по умолчанию включено
    ];

    // WhatsApp number (покажем/спрячем через JS)
    $fields['billing']['e360_whatsapp_number'] = [
        'type'        => 'text',
        'label'       => 'WhatsApp number',
        'required'    => false, // требование сделаем валидатором
        'priority'    => 90,
        'class'       => ['form-row-wide', 'e360-whatsapp-number-row'],
        'placeholder' => '+1 555 123 4567',
    ];

    return $fields;
});


add_action('wp_footer', function(){
    if (!function_exists('is_checkout') || !is_checkout()) return;
    ?>
<script>
(function($) {
    function toggleWhatsappField() {
        var checked = $('#e360_has_whatsapp').is(':checked');
        var $row = $('.e360-whatsapp-number-row');
        if (checked) {
            $row.hide();
            $('#e360_whatsapp_number').val('');
        } else {
            $row.show();
        }
    }

    $(document).on('change', '#e360_has_whatsapp', toggleWhatsappField);
    $(document).ready(function() {
        toggleWhatsappField();
    });
})(jQuery);
</script>
<?php
});


// Валидация
add_action('woocommerce_checkout_process', function(){

    $ref = isset($_POST['e360_referral_source']) ? trim(wp_unslash($_POST['e360_referral_source'])) : '';
    if ($ref === '') {
        wc_add_notice('Please select how you heard about us.', 'error');
    }

    $has_whatsapp = !empty($_POST['e360_has_whatsapp']);
    $wa_number = isset($_POST['e360_whatsapp_number']) ? trim(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    // Если НЕ отмечено "есть WhatsApp" — требуем номер WhatsApp
    if (!$has_whatsapp && $wa_number === '') {
        wc_add_notice('Please enter a WhatsApp number (or check "My phone has WhatsApp").', 'error');
    }

    // Birthdate (если заполнено — проверим формат YYYY-MM-DD)
    $birth = isset($_POST['e360_birthdate']) ? trim(wp_unslash($_POST['e360_birthdate'])) : '';
    if ($birth !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth)) {
        wc_add_notice('Birthday format is invalid.', 'error');
    }
});

// Сохранение в заказ
add_action('woocommerce_checkout_create_order', function($order){

    $ref = isset($_POST['e360_referral_source']) ? sanitize_text_field(wp_unslash($_POST['e360_referral_source'])) : '';
    $birth = isset($_POST['e360_birthdate']) ? sanitize_text_field(wp_unslash($_POST['e360_birthdate'])) : '';
    $has_whatsapp = !empty($_POST['e360_has_whatsapp']) ? 'yes' : 'no';
    $wa_number = isset($_POST['e360_whatsapp_number']) ? sanitize_text_field(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    if ($ref !== '') $order->update_meta_data('_e360_referral_source', $ref);
    if ($birth !== '') $order->update_meta_data('_e360_birthdate', $birth);
    $order->update_meta_data('_e360_has_whatsapp', $has_whatsapp);
    if ($wa_number !== '') $order->update_meta_data('_e360_whatsapp_number', $wa_number);
    
    // Save booking context to order meta
    $ctx = null;
    if (!empty($_POST['e360_booking_ctx'])) {
        $raw = wp_unslash($_POST['e360_booking_ctx']);
        $ctx = json_decode($raw, true);
    }
    if (!is_array($ctx) || !$ctx) {
        $course_id = isset($_POST['e360_course_id']) ? (int) $_POST['e360_course_id'] : (isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0);
        $teacher_id = isset($_POST['e360_teacher_id']) ? (int) $_POST['e360_teacher_id'] : (isset($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : 0);
        $date = isset($_POST['e360_booking_date']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_date'])) : (isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '');
        $time = isset($_POST['e360_booking_time']) ? sanitize_text_field(wp_unslash($_POST['e360_booking_time'])) : (isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '');
        $language_term_id = isset($_POST['e360_term_id']) ? (int) $_POST['e360_term_id'] : (isset($_POST['language_term_id']) ? (int) $_POST['language_term_id'] : 0);
        $level_term_id = isset($_POST['level_term_id']) ? (int) $_POST['level_term_id'] : (isset($_POST['e360_level_id']) ? (int) $_POST['e360_level_id'] : 0);
        $plan_product_id = isset($_POST['plan_product_id']) ? (int) $_POST['plan_product_id'] : (isset($_POST['plan']) ? (int) $_POST['plan'] : 0);
        $duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 60;
        $repeat = isset($_POST['repeat']) ? sanitize_text_field($_POST['repeat']) : 'weekly';
        if ($course_id && $teacher_id && $date && $time) {
            $ctx = [
                'language_term_id' => $language_term_id,
                'level_term_id'    => $level_term_id,
                'course_id'        => $course_id,
                'teacher_id'       => $teacher_id,
                'date'             => $date,
                'time'             => $time,
                'plan_product_id'  => $plan_product_id,
                'duration'         => $duration,
                'repeat'           => $repeat,
            ];
        }
    }
    if (is_array($ctx) && $ctx) {
        $order->update_meta_data('_e360_booking_context', $ctx);
    }

}, 20, 1);

// Сохранение в user meta (если юзер залогинен)
add_action('woocommerce_checkout_update_user_meta', function($customer_id){

    if (!$customer_id) return;

    $ref = isset($_POST['e360_referral_source']) ? sanitize_text_field(wp_unslash($_POST['e360_referral_source'])) : '';
    $birth = isset($_POST['e360_birthdate']) ? sanitize_text_field(wp_unslash($_POST['e360_birthdate'])) : '';
    $has_whatsapp = !empty($_POST['e360_has_whatsapp']) ? 'yes' : 'no';
    $wa_number = isset($_POST['e360_whatsapp_number']) ? sanitize_text_field(wp_unslash($_POST['e360_whatsapp_number'])) : '';

    if ($ref !== '') update_user_meta($customer_id, 'e360_referral_source', $ref);
    if ($birth !== '') update_user_meta($customer_id, 'e360_birthdate', $birth);
    update_user_meta($customer_id, 'e360_has_whatsapp', $has_whatsapp);
    if ($wa_number !== '') update_user_meta($customer_id, 'e360_whatsapp_number', $wa_number);

}, 20, 1);


add_action('woocommerce_admin_order_data_after_billing_address', function($order){

    $ref  = $order->get_meta('_e360_referral_source');
    $birth = $order->get_meta('_e360_birthdate');
    $has = $order->get_meta('_e360_has_whatsapp');
    $wa  = $order->get_meta('_e360_whatsapp_number');

    echo '<div style="margin-top:10px;padding-top:10px;border-top:1px solid #eee;">';
    echo '<h4 style="margin:0 0 6px;">English360</h4>';
    if ($ref)   echo '<p><strong>Referral:</strong> ' . esc_html($ref) . '</p>';
    if ($birth) echo '<p><strong>Birthday:</strong> ' . esc_html($birth) . '</p>';
    echo '<p><strong>Has WhatsApp:</strong> ' . esc_html($has === 'yes' ? 'Yes' : 'No') . '</p>';
    if ($wa)    echo '<p><strong>WhatsApp number:</strong> ' . esc_html($wa) . '</p>';
    
    $ctx = $order->get_meta('_e360_booking_context');
    // Show booking context
    if (is_array($ctx) && !empty($ctx)) {
        echo '<div style="margin-top:10px;">';
        echo '<strong>Booking details:</strong><br>';
        $course_title = !empty($ctx['course_id']) ? get_the_title((int)$ctx['course_id']) : '';
        $teacher = !empty($ctx['teacher_id']) ? get_user_by('id', (int)$ctx['teacher_id']) : null;
        echo '<p><strong>Course:</strong> ' . esc_html($course_title ?: ('#'.($ctx['course_id'] ?? ''))) . '</p>';
        echo '<p><strong>Teacher:</strong> ' . esc_html($teacher ? $teacher->display_name : ('#'.($ctx['teacher_id'] ?? ''))) . '</p>';
        echo '<p><strong>Date/time:</strong> ' . esc_html(($ctx['date'] ?? '') . ' ' . substr(($ctx['time'] ?? ''),0,5)) . '</p>';
        if (!empty($ctx['plan_product_id'])) {
            $plan_title = function_exists('wc_get_product') ? (wc_get_product($ctx['plan_product_id'])->get_name() ?? '') : '';
            echo '<p><strong>Package:</strong> ' . esc_html($plan_title) . '</p>';
        }
        echo '<p><strong>Type:</strong> ' . esc_html(($ctx['repeat'] ?? '') === 'once' ? 'One-time' : 'Weekly') . '</p>';
        echo '</div>';
    }
    echo '</div>';

});

/**
 * WooCommerce -> Settings -> English360 tab
 */
add_filter('woocommerce_settings_tabs_array', function($tabs) {
    $tabs['e360'] = 'English360';
    return $tabs;
}, 50);

add_action('woocommerce_settings_tabs_e360', function() {
    woocommerce_admin_fields(e360_wc_settings_fields());
});

add_action('woocommerce_update_options_e360', function() {
    // Небольшая доп.санитизация textarea (на всякий)
    if (isset($_POST['e360_referral_sources'])) {
        $_POST['e360_referral_sources'] = wp_unslash($_POST['e360_referral_sources']);
    }
    woocommerce_update_options(e360_wc_settings_fields());
});

function e360_wc_settings_fields() {
    return [
        [
            'title' => 'English360 settings',
            'type'  => 'title',
            'id'    => 'e360_settings_section',
            'desc'  => 'Admin-controlled fields used on checkout.',
        ],

        [
            'title' => 'How did you hear about us? (options)',
            'id'    => 'e360_referral_sources',
            'type'  => 'textarea',
            'css'   => 'min-width:420px;height:160px;',
            'desc'  => "One option per line.\nExample:\nGoogle\nInstagram\nFriend referral",
            'default' => '',
        ],

        [
            'type' => 'sectionend',
            'id'   => 'e360_settings_section',
        ],
    ];
}

add_action('wp_footer', function () {
    if (!is_singular('courses')) return;
    if (!is_user_logged_in()) return;

    // студент = НЕ instructor и НЕ admin
    if (current_user_can('tutor_instructor') || current_user_can('manage_options')) return;

    ?>
<style>
/* названия классов могут отличаться по теме/версии — это safe вариант: скрываем любые кнопки “complete” */
.tutor-lesson-complete,
.tutor-course-complete,
button[name*="complete"],
a[href*="complete"],
[data-action*="complete"] {
    display: none !important;
}
</style>
<?php
});


add_action('tutor_dashboard/before/container', function($page){
    if ($page !== 'dashboard') return;
    if (!is_user_logged_in()) return;

    $uid = get_current_user_id();
    $course_id = (int) get_user_meta($uid, 'e360_primary_course_id', true);
    if (!$course_id) return;

    $bal  = e360_get_credits_balance($uid, $course_id);
    $used = e360_get_credits_used($uid, $course_id);

    // студент
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) {
        echo '<div style="margin:0 0 12px;padding:12px;border:1px solid #e5e5e5;border-radius:10px;">';
        echo '<strong>Lessons remaining:</strong> ' . esc_html($bal) . ' ';
        echo '<span style="opacity:.7;">(completed: ' . esc_html($used) . ')</span>';
        echo '</div>';
    }
}, 10, 1);


add_action('wp_footer', function(){
    if (!is_user_logged_in()) return;

    // иногда Tutor кладёт slug страницы в body class: tutor-dashboard-page-availability
    if (!is_admin() && strpos((string)implode(' ', get_body_class()), 'tutor-dashboard-page-availability') !== false) {
        echo '<style>
            /* подстрой селекторы под реальную разметку на странице */
            .tutor-dashboard-content .tutor-scheduling-wrap,
            .tutor-dashboard-content .tutor-availability-wrap {
                display:none !important;
            }
        </style>';
    }
});



add_action('tutor_dashboard/before/container', function($page){
    if ($page !== 'dashboard') return;
    if (!is_user_logged_in()) return;

    $teacher_id = get_current_user_id();
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    $students = get_users([
        'number' => 50,
        'fields' => ['ID','display_name','user_email'],
        'meta_key' => 'e360_primary_teacher_id',
        'meta_value' => $teacher_id,
    ]);

    if (!$students) return;

    echo '<div style="margin:0 0 12px;padding:12px;border:1px solid #e5e5e5;border-radius:10px;">';
    echo '<strong>Your students (lessons remaining)</strong>';
    echo '<div style="margin-top:8px;">';

    foreach ($students as $s) {
        $bal  = e360_get_credits_balance($s->ID);
        $used = e360_get_credits_used($s->ID);

        // имя без фамилии: берём first_name и первую букву last_name, иначе display_name
        $first = get_user_meta($s->ID, 'first_name', true);
        $last  = get_user_meta($s->ID, 'last_name', true);
        $label = $first ? ($first . ($last ? ' ' . mb_substr($last,0,1) . '.' : '')) : $s->display_name;

        echo '<div style="display:flex;gap:10px;justify-content:space-between;border-top:1px solid #f0f0f0;padding:8px 0;">';
        echo '<div>' . esc_html($label) . '</div>';
        echo '<div><strong>' . esc_html($bal) . '</strong> remaining <span style="opacity:.7;">(completed: ' . esc_html($used) . ')</span></div>';
        echo '</div>';
    }

    echo '</div></div>';
}, 20, 1);

/**
 * Detect Tutor dashboard availability page
 */
function e360_is_tutor_availability_page($dashboard_page_name = ''): bool {
    $dashboard_page_name = (string) $dashboard_page_name;

    // If Tutor passes page name
    if ($dashboard_page_name !== '' && stripos($dashboard_page_name, 'availability') !== false) {
        return true;
    }

    // Fallback by URL
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return (strpos($uri, '/dashboard/availability') !== false);
}

/**
 * Render our availability UI and hide Tutor original block
 */
function e360_render_availability_override(): void {
    if (!is_user_logged_in()) return;

    // только учитель/админ
    if (!current_user_can('tutor_instructor') && !current_user_can('manage_options')) return;

    // маркер для проверки в исходнике страницы
    echo "\n<!-- e360 availability override -->\n";

    // скрываем оригинальный Tutor LMS блок
    echo '<style>
        .tutor-dashboard-content .tutor-scheduling-availability { display:none !important; }
    </style>';

    // показываем наш UI
    echo '<div style="margin:0 0 14px;">' . do_shortcode('[e360_teacher_calendar_settings]') . '</div>';
}

/**
 * Main hook (recommended) — Tutor passes dashboard page name here
 */
add_action('tutor_load_dashboard_template_before', function($dashboard_page_name){
    if (!e360_is_tutor_availability_page($dashboard_page_name)) return;
    e360_render_availability_override();
}, 5, 1);

/**
 * Fallback hook — if the one above doesn’t exist in your Tutor version
 */
add_action('tutor_dashboard/before/wrap', function(){
    if (!e360_is_tutor_availability_page('')) return;
    e360_render_availability_override();
}, 5);