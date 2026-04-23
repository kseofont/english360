<?php
/**
 * Instructors Widget
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ellen_Instructors extends Widget_Base {

	public function get_name() {
        return 'Ellen_Instructors';
    }

	public function get_title() {
        return __( 'LearnPress Instructors', 'ellen-toolkit' );
    }

	public function get_icon() {
        return 'eicon-person';
    }

	public function get_categories() {
        return [ 'ellen-elements' ];
	}
	protected function register_controls() {

        $this->start_controls_section(
			'Ellen_Instructors',
			[
				'label' => __( 'Ellen Instructors', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

            $this->add_control(
                'count',
                [
                    'label' => __( 'Count Instructors', 'ellen-toolkit' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 8,
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Order By', 'ellen-toolkit' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'DESC'      => __( 'DESC', 'ellen-toolkit' ),
                        'ASC'       => __( 'ASC', 'ellen-toolkit' ),
                    ],
                    'default' => 'DESC',
                ]
            );

            if ( class_exists('LearnPress') ) {
                $this->add_control(
                    'student',
                    [
                        'label' => __( 'Student Text', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXT,
                    ]
                );
                $this->add_control(
                    'course',
                    [
                        'label' => __( 'Course Text', 'ellen-toolkit' ),
                        'type' => Controls_Manager::TEXT,
                    ]
                );
            }

        $this->end_controls_section();

        $this->start_controls_section(
			'team_style',
			[
				'label' => __( 'Style', 'ellen-toolkit' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'name_color',
                [
                    'label' => __( 'Name Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-instructor-box h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => esc_html__( 'Name Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-instructor-box h3',
                ]
            );

            $this->add_control(
                'designation_color',
                [
                    'label' => __( 'Designation Color', 'ellen-toolkit' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .single-instructor-box .designation' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'designation_typography',
                    'label' => esc_html__( 'Designation Typography', 'ellen-toolkit' ),
                    
                    'selector' => '{{WRAPPER}} .single-instructor-box .designation',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings_for_display();



        if ( function_exists('tutor') ) {
            $args = array(
                'role'          => 'tutor_instructor',
                'order'         => $settings['order'],
                'number'         => $settings['count'],
            );
            $user_query     = new \WP_User_Query( $args );
            $instructors    = $user_query->get_results();
            ?>
            <div class="container">
                <div class="row">
                    <?php if ( ! empty( $instructors ) ) {
                        foreach ( $instructors as $instructor ) {
                            $profile_url        = tutor_utils()->profile_url( $instructor->ID );
							$profile_url		= str_replace("?view=student","", $profile_url);
                            $user               = tutor_utils()->get_tutor_user( $instructor->ID );
                            $image              = wp_get_attachment_image($user->tutor_profile_photo, array('150', '150'));
                            $job_title          = get_user_meta( $instructor->ID, '_tutor_profile_job_title', true );
                            $total_courses      = ellen_get_total_courses_by_instructor( $instructor->ID );
                            $total_students     = tutor_utils()->get_total_students_by_instructor($instructor->ID);
                            $instructor_rating  = tutor_utils()->get_instructor_ratings( $instructor->ID );

                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="single-instructor-box">
                                    <?php if($image): ?>
                                        <?php echo wp_kses_post($image); ?>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html( $instructor->display_name ); ?></h3>
                                    <?php if($job_title): ?>
                                        <span class="designation"><?php echo esc_html( $job_title ); ?></span>
                                    <?php endif; ?>
                                    <div class="info">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span><i class="flaticon-file"></i>
                                            <?php echo esc_html( sprintf( _n( '%s course', '%s courses', $total_courses, 'ellen-toolkit' ), number_format_i18n( $total_courses ) ) ); ?>
                                            </span>
                                            <span><i class="flaticon-people"></i>
                                                <?php echo esc_html( sprintf(
                                                    _n( '%s student', '%s students', $total_students, 'ellen-toolkit' ),
                                                    number_format_i18n( $total_students )
                                                ) ); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <?php if ( $instructor_rating->rating_count > 0 ): ?>
                                            <div class="d-flex align-items-center">
                                                <?php echo ellen_render_rating($instructor_rating->rating_avg); ?>

                                                <span class="count"><?php echo ellen_number_format_nice_float($instructor_rating->rating_avg); ?><?php echo esc_html_e('/5', 'ellen-toolkit'); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="d-flex align-items-center">
                                                <i class='bx bx-star'></i>
                                                <i class='bx bx-star'></i>
                                                <i class='bx bx-star'></i>
                                                <i class='bx bx-star'></i>
                                                <i class='bx bx-star'></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo esc_url( $profile_url ); ?>" class="link-btn"></a>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                </div>
            </div>
            <?php
        }elseif( class_exists('LearnPress') ){
            $args = array(
                'role'          => 'lp_teacher',
                'order'         => $settings['order'],
                'number'         => $settings['count'],
            );
            $user_query     = new \WP_User_Query( $args );
            $instructors    = $user_query->get_results();
            ?>
            <div class="container">
                <div class="row">
                    <?php if ( ! empty( $instructors ) ) {
                        foreach ( $instructors as $instructor ) {
                            $teacher_info = get_userdata( $instructor->ID );
                            $user = \LP_Profile::instance()->get_user();
                            $lp_settings = \LP()->settings();
                            $profile_link       = get_page_link( $lp_settings->get( 'profile_page_id' ) );
                            $total_courses = count_user_posts( $instructor->ID, LP_COURSE_CPT );
                            $profile = learn_press_get_profile( $instructor->ID );

                            $students = $profile->get_statistic_info();

                            $user_image = \get_field('teacher_image_for_elementor_widget', 'user_' .$teacher_info->ID );

                            $socials = $user->get_profile_socials( $instructor->ID );
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="single-instructor-box">
                                    <?php if($user_image): ?>
                                        <img src="<?php echo esc_url($user_image); ?>" alt="instructors-image">
                                    <?php endif; ?>
                                    <h3><?php echo esc_html( $teacher_info->display_name ); ?></h3>
                                    <span class="designation"><?php the_field('learnpress_teacher__designation', 'user_' .$teacher_info->ID ); ?></span>
                                    <div class="info">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span><i class="flaticon-file"></i> <?php echo esc_html($total_courses); ?> <?php echo esc_html($settings['course']); ?></span>
                                            <span><i class="flaticon-people"></i> <?php echo esc_html($students['enrolled_courses']); ?> <?php echo esc_html($settings['student']); ?></span>
                                        </div>
                                    </div>
                                    <div class="rating social">
                                        <?php echo implode( "\n", $socials ); ?>
                                    </div>
                                    <a href="<?php echo esc_url($profile_link); ?><?php echo $teacher_info->user_login; ?>/" class="link-btn"></a>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                </div>
            </div>
            <?php
        }
	}


}

Plugin::instance()->widgets_manager->register( new Ellen_Instructors );