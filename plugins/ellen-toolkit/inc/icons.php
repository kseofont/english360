<?php

// Flat icons
function ellen_flaticons() {
    return [
        // Box Icons
        'bx bx-info-circle'         => esc_html__( 'Info Circle', 'ellen-toolkit' ),
        'bx bx-book-open'           => esc_html__( 'Book Open', 'ellen-toolkit' ),
        'bx bx-shopping-bag'        => esc_html__( 'Shopping', 'ellen-toolkit' ),
        'bx bxs-badge-dollar'       => esc_html__( 'Dollar', 'ellen-toolkit' ),
        'bx bx-code-alt'            => esc_html__( 'Code', 'ellen-toolkit' ),
        'bx bx-flag'                => esc_html__( 'Flag', 'ellen-toolkit' ),
        'bx bx-camera'              => esc_html__( 'Camera', 'ellen-toolkit' ),
        'bx bx-layer'               => esc_html__( 'Layer', 'ellen-toolkit' ),
        'bx bxs-flag-checkered'     => esc_html__( 'Flag Checkered', 'ellen-toolkit' ),
        'bx bx-health'              => esc_html__( 'Star', 'ellen-toolkit' ),
        'bx bx-line-chart'          => esc_html__( 'LLine Chart', 'ellen-toolkit' ),
        'bx bx-book-reader'         => esc_html__( 'Book Reader', 'ellen-toolkit' ),
        'bx bx-target-lock'         => esc_html__( 'Target Lock', 'ellen-toolkit' ),
        'bx bxs-thermometer'        => esc_html__( 'Thermometer', 'ellen-toolkit' ),
        'bx bx-shape-triangle'      => esc_html__( 'Triangle', 'ellen-toolkit' ),
        'bx bx-font-family'         => esc_html__( 'Font Family', 'ellen-toolkit' ),
        'bx bxs-drink'              => esc_html__( 'Drink', 'ellen-toolkit' ),
        'bx bx-first-aid'           => esc_html__( 'First Aid', 'ellen-toolkit' ),
        'bx bx-bar-chart-alt-2'     => esc_html__( 'Chart', 'ellen-toolkit' ),
        'bx bx-briefcase-alt-2'     => esc_html__( 'Briefcase', 'ellen-toolkit' ),
        'bx bx-book-reader'         => esc_html__( 'Book Reader', 'ellen-toolkit' ),
        'bx bx-target-lock'         => esc_html__( 'Target Lock', 'ellen-toolkit' ),
        'bx bx-play-circle'         => esc_html__( 'Play Circle', 'ellen-toolkit' ),
        'bx bx-play'         => esc_html__( 'Play', 'ellen-toolkit' ),

        'flaticon-search'               => esc_html__('Search', 'ellen'),
        'flaticon-redo'                 => esc_html__('Redo', 'ellen'),
        'flaticon-books'                => esc_html__('Book', 'ellen'),
        'flaticon-teacher'              => esc_html__('Teacher', 'ellen'),
        'flaticon-people'               => esc_html__('People', 'ellen'),
        'flaticon-technology'           => esc_html__('Technology', 'ellen'),
        'flaticon-idea'                 => esc_html__('Idea', 'ellen'),
        'flaticon-laptop'               => esc_html__('Laptop', 'ellen'),
        'flaticon-web-programming'      => esc_html__('Web Programming', 'ellen'),
        'flaticon-megaphone'            => esc_html__('Megaphone', 'ellen'),
        'flaticon-paint-palette'        => esc_html__('Paint Palette', 'ellen'),
        'flaticon-dumbbell'             => esc_html__('Dumbbell', 'ellen'),
        'flaticon-career'               => esc_html__('Career', 'ellen'),
        'flaticon-data'                 => esc_html__('Data', 'ellen'),
        'flaticon-diet'                 => esc_html__('Diet', 'ellen'),
        'flaticon-photography'          => esc_html__('Photography', 'ellen'),
        'flaticon-right-arrow-outline'  => esc_html__('Arrow Outline', 'ellen'),
        'flaticon-coaching'             => esc_html__('Coaching', 'ellen'),
        'flaticon-user'                 => esc_html__('User', 'ellen'),
        'flaticon-essential'            => esc_html__('Essential', 'ellen'),
        'bx bx-map'                     => esc_html__('Map', 'ellen'),
        'bx bx-phone-call'              => esc_html__('Phone Call', 'ellen'),
        'bx bx-time-five'               => esc_html__('Time', 'ellen'),

    ];
}

function ellen_include_flaticons() {
    return array_keys(ellen_flaticons());
}