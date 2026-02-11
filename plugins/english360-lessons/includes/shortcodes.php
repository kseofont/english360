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