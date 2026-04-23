<?php
/**
 * Book Lesson Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$teacher_id = isset( $atts['teacher_id'] ) ? intval( $atts['teacher_id'] ) : 0;
$course_id = isset( $atts['course_id'] ) ? intval( $atts['course_id'] ) : 0;

if ( ! is_user_logged_in() ) {
	echo '<p>' . esc_html__( 'Please log in to book a lesson.', 'tutor-scheduling' ) . '</p>';
	return;
}

$student_id = get_current_user_id();

// Get student's active subscriptions
$tracker = new Tutor_Scheduling_Subscription_Tracker();
$subscriptions = $tracker->get_student_subscriptions( $student_id, $course_id );

if ( empty( $subscriptions ) ) {
	echo '<p>' . esc_html__( 'You need to purchase a subscription to book lessons.', 'tutor-scheduling' ) . '</p>';
	return;
}

// Get teacher availability
$availability = new Tutor_Scheduling_Availability();
?>

<div class="tutor-book-lesson">
	<h3><?php esc_html_e( 'Book a Lesson', 'tutor-scheduling' ); ?></h3>
	
	<form id="book-lesson-form">
		<?php if ( ! $teacher_id ) : ?>
			<p>
				<label><?php esc_html_e( 'Select Teacher:', 'tutor-scheduling' ); ?></label>
				<select name="teacher_id" id="teacher-select" required>
					<option value=""><?php esc_html_e( 'Loading teachers...', 'tutor-scheduling' ); ?></option>
				</select>
			</p>
		<?php else : ?>
			<input type="hidden" name="teacher_id" value="<?php echo esc_attr( $teacher_id ); ?>">
		<?php endif; ?>
		
		<?php if ( ! $course_id ) : ?>
			<p>
				<label><?php esc_html_e( 'Select Course:', 'tutor-scheduling' ); ?></label>
				<select name="course_id" id="course-select" required>
					<option value=""><?php esc_html_e( 'Select a course', 'tutor-scheduling' ); ?></option>
					<?php
					// Get student's enrolled courses
					$enrolled_courses = tutor_utils()->get_enrolled_courses_ids_by_user( get_current_user_id() );
					foreach ( $enrolled_courses as $course_id_option ) {
						$course_option = get_post( $course_id_option );
						if ( $course_option ) {
							echo '<option value="' . esc_attr( $course_id_option ) . '">' . esc_html( $course_option->post_title ) . '</option>';
						}
					}
					?>
				</select>
			</p>
		<?php else : ?>
			<input type="hidden" name="course_id" value="<?php echo esc_attr( $course_id ); ?>">
		<?php endif; ?>
		
		<?php if ( count( $subscriptions ) > 1 ) : ?>
			<p>
				<label><?php esc_html_e( 'Select Subscription:', 'tutor-scheduling' ); ?></label>
				<select name="subscription_id" required>
					<?php foreach ( $subscriptions as $sub ) : 
						$details = $tracker->get_subscription_details( $student_id, $sub->subscription_id );
					?>
						<option value="<?php echo esc_attr( $sub->subscription_id ); ?>">
							<?php echo esc_html( $details['course']->post_title ); ?> 
							(<?php echo esc_html( $sub->remaining_lessons ); ?> <?php esc_html_e( 'lessons remaining', 'tutor-scheduling' ); ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</p>
		<?php else : ?>
			<input type="hidden" name="subscription_id" value="<?php echo esc_attr( $subscriptions[0]->subscription_id ); ?>">
		<?php endif; ?>
		
		<p>
			<label><?php esc_html_e( 'Select Date:', 'tutor-scheduling' ); ?></label>
			<input type="date" name="booking_date" id="booking-date" required min="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>">
		</p>
		
		<p>
			<label><?php esc_html_e( 'Select Time:', 'tutor-scheduling' ); ?></label>
			<select name="booking_time" id="booking-time" required>
				<option value=""><?php esc_html_e( 'Select date first', 'tutor-scheduling' ); ?></option>
			</select>
		</p>
		
		<button type="submit" class="tutor-btn tutor-btn-primary">
			<?php esc_html_e( 'Book Lesson', 'tutor-scheduling' ); ?>
		</button>
	</form>
	
	<div id="booking-message" class="tutor-alert" style="display:none;"></div>
</div>

<script>
jQuery(document).ready(function($) {
	// Load teachers when course is selected (if teacher not pre-selected)
	<?php if ( ! $teacher_id ) : ?>
	$('#course-select').on('change', function() {
		var courseId = $(this).val();
		if (courseId) {
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_get_available_teachers',
					nonce: tutorScheduling.nonce,
					course_id: courseId
				},
				success: function(response) {
					if (response.success) {
						var $select = $('#teacher-select');
						$select.empty();
						if (response.data.teachers.length > 0) {
							$select.append($('<option>', { value: '', text: '<?php esc_html_e( 'Select a teacher', 'tutor-scheduling' ); ?>' }));
							$.each(response.data.teachers, function(i, teacher) {
								$select.append($('<option>', {
									value: teacher.id,
									text: teacher.name
								}));
							});
						} else {
							$select.append($('<option>', { value: '', text: '<?php esc_html_e( 'No available teachers', 'tutor-scheduling' ); ?>' }));
						}
					}
				}
			});
		}
	});
	<?php endif; ?>
	
	$('#booking-date').on('change', function() {
		var date = $(this).val();
		var teacherId = $('input[name="teacher_id"], #teacher-select').val();
		
		if (date) {
			$.ajax({
				url: tutorScheduling.ajaxurl,
				type: 'POST',
				data: {
					action: 'tutor_scheduling_get_available_slots',
					nonce: tutorScheduling.nonce,
					teacher_id: teacherId,
					date: date,
					duration: 60
				},
				success: function(response) {
					if (response.success) {
						var $select = $('#booking-time');
						$select.empty();
						
						if (response.data.slots.length > 0) {
							$.each(response.data.slots, function(i, slot) {
								var time = slot.substring(0, 5);
								$select.append($('<option>', {
									value: slot,
									text: time
								}));
							});
						} else {
							$select.append($('<option>', {
								value: '',
								text: '<?php esc_html_e( 'No available slots', 'tutor-scheduling' ); ?>'
							}));
						}
					}
				}
			});
		}
	});
	
	$('#book-lesson-form').on('submit', function(e) {
		e.preventDefault();
		
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			data: {
				action: 'tutor_scheduling_create_booking',
				nonce: tutorScheduling.nonce,
				teacher_id: $('input[name="teacher_id"]').val(),
				course_id: $('input[name="course_id"]').val(),
				booking_date: $('#booking-date').val(),
				booking_time: $('#booking-time').val(),
				subscription_id: $('input[name="subscription_id"], select[name="subscription_id"]').val()
			},
			success: function(response) {
				var $message = $('#booking-message');
				if (response.success) {
					$message.removeClass('tutor-alert-error').addClass('tutor-alert-success')
						.text(response.data.message || tutorScheduling.strings.booking_success)
						.show();
					
					// Reset form
					$('#book-lesson-form')[0].reset();
					
					setTimeout(function() {
						$message.fadeOut();
					}, 3000);
				} else {
					$message.removeClass('tutor-alert-success').addClass('tutor-alert-error')
						.text(response.data.message || tutorScheduling.strings.booking_error)
						.show();
				}
			}
		});
	});
});
</script>

