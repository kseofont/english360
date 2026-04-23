<?php
add_shortcode('e360_plans_button', function () {
    if (!is_singular()) return '';
    $course_id = get_the_ID();
    if ($course_id <= 0) return '';

    // куда вести: страница с планами (создай страницу /plans/ и выведи там список товаров)
    $url = add_query_arg('e360_course_id', $course_id, site_url('/plans/'));

    return '<a class="button" href="' . esc_url($url) . '">Choose a plan</a>';
});



add_shortcode('e360_course_teacher_availability', function($atts){
    $atts = shortcode_atts([
        'teacher_id' => 0,
        'course_id'  => 0,
    ], $atts);

    $course_id = (int) $atts['course_id'];

    if (!$course_id && is_singular()) {
        $course_id = get_the_ID();
    }

    if ($atts['teacher_id']) {
        $teacher_id = (int) $atts['teacher_id'];
    } else {
        $teacher_id = (int) get_post_field('post_author', $course_id);
    }

    if ($teacher_id <= 0) return '';

    return do_shortcode('[tutor_teacher_availability teacher_id="' . $teacher_id . '"]');
});



add_shortcode('e360_book_lesson_button', function(){
    if (!is_singular()) return '';
    $course_id = get_the_ID();
    if ($course_id <= 0) return '';

    $url = add_query_arg('course_id', $course_id, site_url('/book-lesson/'));
    return '<a class="button" href="' . esc_url($url) . '">Book a lesson</a>';
});


add_shortcode('e360_book_lesson_for_course', function($atts){
    $course_id = 0;
    if (!empty($_GET['course_id'])) $course_id = (int) $_GET['course_id'];
    if ($course_id <= 0 && is_singular()) $course_id = get_the_ID();
    if ($course_id <= 0) return '<p>Course not specified.</p>';

    $teacher_id = (int) get_post_field('post_author', $course_id);
    if ($teacher_id <= 0) return '<p>Teacher not found.</p>';

return do_shortcode('[tutor_book_lesson teacher_id="' . $teacher_id . '" course_id="' . $course_id . '"]');
});

function e360_teachers_directory_form_shortcode(): string {
    return '[contact-form-7 id="f4d0f8e" title="Message to teacher"]';
}

function e360_get_available_teacher_directory_ids(): array {
    $teacher_ids = [];

    if (class_exists('\TUTOR\Instructors_List')) {
        $rows = \TUTOR\Instructors_List::get_instructors(['approved', 'pending', 'blocked'], 0, 5000, '', '', '', 'ASC');
        foreach ((array) $rows as $row) {
            $teacher_id = isset($row->ID) ? (int) $row->ID : 0;
            if ($teacher_id > 0) {
                $teacher_ids[$teacher_id] = $teacher_id;
            }
        }
    }

    if (!$teacher_ids) {
        $courses = get_posts([
            'post_type' => 'courses',
            'post_status' => 'publish',
            'numberposts' => 500,
            'fields' => 'ids',
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        foreach ((array) $courses as $course_id) {
            foreach ((array) e360_get_course_instructor_ids((int) $course_id) as $teacher_id) {
                $teacher_id = (int) $teacher_id;
                if ($teacher_id <= 0) {
                    continue;
                }
                $teacher_ids[$teacher_id] = $teacher_id;
            }
        }
    }

    return array_values($teacher_ids);
}

function e360_get_teacher_directory_course_titles(int $teacher_id, int $limit = 3): array {
    $courses = get_posts([
        'post_type' => 'courses',
        'post_status' => 'publish',
        'numberposts' => 500,
        'fields' => 'ids',
        'orderby' => 'title',
        'order' => 'ASC',
    ]);

    $titles = [];
    foreach ((array) $courses as $course_id) {
        $instructor_ids = array_map('intval', (array) e360_get_course_instructor_ids((int) $course_id));
        if (!in_array($teacher_id, $instructor_ids, true)) {
            continue;
        }

        $titles[] = e360_course_base_title((string) get_the_title((int) $course_id));
    }

    $titles = array_values(array_unique(array_filter(array_map('trim', $titles))));
    return array_slice($titles, 0, $limit);
}

function e360_render_teacher_directory_card(int $teacher_id): string {
    $user = get_user_by('id', $teacher_id);
    if (!$user) {
        return '';
    }

    $name = e360_teacher_public_name($user);
    $avatar = get_avatar_url($teacher_id, ['size' => 160]);
    $bio_html = e360_teacher_bio_html($teacher_id);
    $headline = trim((string) get_user_meta($teacher_id, 'e360_teacher_headline', true));
    $intro = trim((string) get_user_meta($teacher_id, 'e360_teacher_intro', true));
    $country = trim((string) get_user_meta($teacher_id, 'e360_teacher_country', true));
    $languages = trim((string) get_user_meta($teacher_id, 'e360_teacher_languages', true));
    $rating = trim((string) get_user_meta($teacher_id, 'e360_teacher_rating', true));
    $price = trim((string) get_user_meta($teacher_id, 'e360_teacher_price', true));
    $price_label = trim((string) get_user_meta($teacher_id, 'e360_teacher_price_label', true));
    $badges = trim((string) get_user_meta($teacher_id, 'e360_teacher_badges', true));
    $featured = (string) get_user_meta($teacher_id, 'e360_teacher_featured', true) === '1';
    $native_language = trim((string) get_user_meta($teacher_id, 'e360_teacher_native_language', true));
    $intro_video = trim((string) get_user_meta($teacher_id, 'e360_teacher_intro_video', true));
    $intro_video_embed = function_exists('e360_teacher_intro_video_embed_url') ? e360_teacher_intro_video_embed_url($intro_video) : '';
    $course_titles = e360_get_teacher_directory_course_titles($teacher_id);

    if ($intro === '') {
        $intro = e360_teacher_bio_snippet($teacher_id, 180);
    }

    $badge_items = array_values(array_filter(array_map('trim', explode(',', $badges))));
    if ($featured) {
        array_unshift($badge_items, 'Featured Tutor');
    }
    $badge_items = array_slice(array_unique($badge_items), 0, 4);

    ob_start();
    ?>
    <article class="e360-directory-card e360-teacher-card" data-teacher-id="<?php echo esc_attr((string) $teacher_id); ?>" data-teacher-name="<?php echo esc_attr($name); ?>" data-teacher-email="<?php echo esc_attr((string) $user->user_email); ?>" style="border:1px solid #ddd;border-radius:18px;padding:16px;background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);box-shadow:0 10px 30px rgba(16,48,78,0.08);cursor:pointer;">
        <div style="display:flex;gap:16px;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;">
            <div style="display:flex;gap:14px;align-items:flex-start;flex:1;min-width:280px;">
                <div>
                    <?php if ($avatar) : ?>
                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($name); ?>" style="width:84px;height:84px;border-radius:50%;object-fit:cover;">
                    <?php endif; ?>
                </div>
                <div style="flex:1;min-width:220px;">
                    <div style="font-size:22px;line-height:1.2;font-weight:700;color:#0f1720;"><?php echo esc_html($name); ?></div>
                    <?php if ($headline !== '') : ?>
                        <div style="margin-top:4px;font-size:14px;font-weight:600;color:#15314b;"><?php echo esc_html($headline); ?></div>
                    <?php endif; ?>
                    <?php if ($rating !== '') : ?>
                        <div style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:5px 10px;border-radius:999px;background:#fff7e8;color:#8b5a00;font-size:13px;font-weight:700;">
                            <span aria-hidden="true" style="color:#f59e0b;font-size:14px;line-height:1;">★</span>
                            <span><?php echo esc_html($rating); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($badge_items) : ?>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                            <?php foreach ($badge_items as $badge) : ?>
                                <span style="display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;background:#eef5ff;color:#195ca8;font-size:12px;font-weight:600;"><?php echo esc_html($badge); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $meta_parts = [];
                    if ($country !== '') {
                        $meta_parts[] = $country;
                    }
                    if ($languages !== '') {
                        $meta_parts[] = 'Languages: ' . $languages;
                    }
                    if ($native_language !== '') {
                        $meta_parts[] = 'Native: ' . $native_language;
                    }
                    if ($course_titles) {
                        $meta_parts[] = 'Courses: ' . implode(', ', $course_titles);
                    }
                    ?>
                    <?php if ($meta_parts) : ?>
                        <div style="margin-top:8px;color:#5f6b7a;font-size:13px;line-height:1.5;"><?php echo esc_html(implode(' • ', $meta_parts)); ?></div>
                    <?php endif; ?>
                    <?php if ($intro !== '') : ?>
                        <div style="margin-top:10px;color:#2f3b4a;font-size:14px;line-height:1.6;"><?php echo esc_html($intro); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($price !== '') : ?>
                <div style="min-width:132px;text-align:right;">
                    <div style="font-size:28px;line-height:1;font-weight:700;color:#0f1720;">$<?php echo esc_html($price); ?></div>
                    <div style="margin-top:6px;font-size:12px;color:#617083;"><?php echo esc_html($price_label !== '' ? $price_label : 'lesson'); ?></div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($bio_html !== '') : ?>
            <div class="e360-directory-bio" style="display:none;margin-top:12px;"><?php echo $bio_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <?php endif; ?>

        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;">
            <?php if ($bio_html !== '') : ?>
                <button type="button" class="e360-directory-toggle-bio tutor-btn tutor-btn-outline-primary tutor-btn-sm">Bio</button>
            <?php endif; ?>
            <?php if ($intro_video_embed !== '' || $intro_video !== '') : ?>
                <button
                    type="button"
                    class="e360-directory-watch-video tutor-btn tutor-btn-outline-primary tutor-btn-sm"
                    data-video-embed="<?php echo esc_attr($intro_video_embed); ?>"
                    data-video-url="<?php echo esc_attr($intro_video); ?>"
                    data-teacher-name="<?php echo esc_attr($name); ?>"
                >Watch intro video</button>
            <?php endif; ?>
            <button type="button" class="e360-directory-contact tutor-btn tutor-btn-primary tutor-btn-sm">Message teacher</button>
        </div>
    </article>
    <?php
    return (string) ob_get_clean();
}

function e360_render_teachers_directory(): string {
    static $rendered = false;
    if ($rendered) {
        return '';
    }
    $rendered = true;

    $teacher_ids = e360_get_available_teacher_directory_ids();
    wp_enqueue_script('jquery');
    wp_enqueue_style('e360-booking-wizard', E360_LESSONS_URL . 'assets/css/booking-wizard.css', [], '0.1.0');

    ob_start();
    ?>
    <div class="e360-teachers-directory">
        <div class="container">
            <div style="max-width:920px;margin:0 auto 28px;">
                <h2 style="margin-bottom:8px;">Our Teachers</h2>
                <p style="margin:0;color:#5f6b7a;">Choose a teacher to learn more or send a message directly.</p>
            </div>

            <?php if (!$teacher_ids) : ?>
                <div class="e360-teacher-card e360-teacher-card-empty" style="border:1px solid #ddd;border-radius:18px;padding:18px;background:#fff;">No teachers are available right now.</div>
            <?php else : ?>
                <div class="e360-teachers" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:18px;">
                    <?php foreach ($teacher_ids as $teacher_id) : ?>
                        <?php echo e360_render_teacher_directory_card((int) $teacher_id); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="e360-teacher-contact-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.48);z-index:99999;padding:20px;">
        <div style="max-width:680px;margin:40px auto;background:#fff;border-radius:16px;padding:18px;position:relative;">
            <button type="button" class="e360-teacher-contact-close tutor-iconic-btn" style="position:absolute;top:12px;right:12px;"><span class="tutor-icon-times"></span></button>
            <div style="padding-right:40px;">
                <div style="font-size:22px;font-weight:700;color:#0f1720;">Message to teacher</div>
                <div id="e360-teacher-contact-meta" style="margin-top:6px;color:#5f6b7a;font-size:14px;"></div>
            </div>
            <div style="margin-top:16px;">
                <?php echo do_shortcode(e360_teachers_directory_form_shortcode()); ?>
            </div>
        </div>
    </div>

    <div id="e360-directory-video-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.58);z-index:99999;padding:20px;">
        <div style="max-width:880px;margin:40px auto;background:#fff;border-radius:18px;padding:18px;position:relative;">
            <button type="button" class="e360-directory-video-close tutor-iconic-btn" style="position:absolute;top:12px;right:12px;"><span class="tutor-icon-times"></span></button>
            <div style="padding-right:40px;">
                <div id="e360-directory-video-title" style="font-size:22px;font-weight:700;color:#0f1720;">Teacher intro video</div>
            </div>
            <div id="e360-directory-video-content" style="margin-top:16px;"></div>
        </div>
    </div>

    <script>
    jQuery(function($) {
        const $modal = $('#e360-teacher-contact-modal');
        const $meta = $('#e360-teacher-contact-meta');
        const $videoModal = $('#e360-directory-video-modal');

        function escapeHtml(value) {
            return $('<div>').text(value || '').html();
        }

        function buildTeacherIntroVideoMarkup(embedUrl, directUrl) {
            const safeEmbedUrl = (embedUrl || '').toString().trim();
            const safeDirectUrl = (directUrl || '').toString().trim();

            if (safeEmbedUrl) {
                return `<div style="border-radius:16px;overflow:hidden;background:#0f1720;">
                    <div style="position:relative;padding-top:56.25%;">
                        <iframe src="${escapeHtml(safeEmbedUrl)}" title="Teacher intro video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;inset:0;width:100%;height:100%;border:0;"></iframe>
                    </div>
                </div>`;
            }

            if (safeDirectUrl) {
                const videoUrl = escapeHtml(safeDirectUrl);
                const isDirectVideo = /\.(mp4|webm|ogg)(\?.*)?$/i.test(safeDirectUrl);
                if (isDirectVideo) {
                    return `<div style="border-radius:16px;overflow:hidden;background:#0f1720;">
                        <video controls preload="metadata" style="display:block;width:100%;height:auto;max-height:70vh;">
                            <source src="${videoUrl}">
                        </video>
                    </div>`;
                }

                return `<div style="padding:12px 0;">
                    <a href="${videoUrl}" target="_blank" rel="noopener noreferrer" class="tutor-btn tutor-btn-primary">Open intro video</a>
                </div>`;
            }

            return '<div style="color:#5f6b7a;">Video is not available.</div>';
        }

        function fillTeacherForm(teacherId, teacherName, teacherEmail) {
            $modal.find('input[name="teacher_id"]').val(teacherId || '');
            $modal.find('input[name="teacher_name"]').val(teacherName || '');
            $modal.find('input[name="teacher_email"]').val(teacherEmail || '');
            $modal.find('input[name="teacher_page"]').val(window.location.href);
            $meta.text(teacherName ? ('You are writing to ' + teacherName + '.') : '');
        }

        function openTeacherVideoModal(teacherName, embedUrl, directUrl) {
            $('#e360-directory-video-title').text(teacherName ? (teacherName + ' · Intro video') : 'Teacher intro video');
            $('#e360-directory-video-content').html(buildTeacherIntroVideoMarkup(embedUrl, directUrl));
            $videoModal.show();
        }

        function closeTeacherVideoModal() {
            $('#e360-directory-video-content').html('');
            $videoModal.hide();
        }

        $(document).off('click.e360DirectoryBio').on('click.e360DirectoryBio', '.e360-directory-toggle-bio', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.e360-directory-card').find('.e360-directory-bio').toggle();
        });

        $(document).off('click.e360DirectoryOpenModal').on('click.e360DirectoryOpenModal', '.e360-directory-card, .e360-directory-contact', function(e) {
            const $card = $(this).closest('.e360-directory-card');
            if (!$card.length) {
                return;
            }
            if ($(e.target).closest('.e360-directory-toggle-bio, .e360-directory-watch-video, a, iframe, video').length) {
                return;
            }
            e.preventDefault();
            fillTeacherForm($card.data('teacher-id'), $card.data('teacher-name'), $card.data('teacher-email'));
            $modal.show();
        });

        $(document).off('click.e360DirectoryWatchVideo').on('click.e360DirectoryWatchVideo', '.e360-directory-watch-video', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $btn = $(this);
            openTeacherVideoModal(
                ($btn.data('teacher-name') || '').toString(),
                ($btn.data('video-embed') || '').toString(),
                ($btn.data('video-url') || '').toString()
            );
        });

        $(document).off('click.e360DirectoryCloseModal').on('click.e360DirectoryCloseModal', '.e360-teacher-contact-close', function(e) {
            e.preventDefault();
            $modal.hide();
        });

        $(document).off('click.e360DirectoryCloseVideo').on('click.e360DirectoryCloseVideo', '.e360-directory-video-close', function(e) {
            e.preventDefault();
            closeTeacherVideoModal();
        });

        $(document).on('click.e360DirectoryModalBackdrop', function(e) {
            if (e.target === $modal.get(0)) {
                $modal.hide();
            }
            if (e.target === $videoModal.get(0)) {
                closeTeacherVideoModal();
            }
        });
    });
    </script>
    <?php

    return (string) ob_get_clean();
}

add_shortcode('e360_teachers_directory', 'e360_render_teachers_directory');

add_filter('the_content', function($content) {
    if (is_admin() || !is_main_query() || !in_the_loop()) {
        return $content;
    }

    if (!is_page('teachers')) {
        return $content;
    }

    if (has_shortcode((string) $content, 'e360_teachers_directory')) {
        return $content;
    }

    return $content . e360_render_teachers_directory();
}, 20);
