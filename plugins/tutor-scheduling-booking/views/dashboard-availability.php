<?php
/**
 * Teacher Availability Dashboard Page
 * 
 * Note: This is included within Tutor's dashboard template wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$availability = new Tutor_Scheduling_Availability();
$teacher_id = get_current_user_id();
$current_availability = $availability->get_availability( $teacher_id );

$days = array(
	0 => __( 'Sunday', 'tutor-scheduling' ),
	1 => __( 'Monday', 'tutor-scheduling' ),
	2 => __( 'Tuesday', 'tutor-scheduling' ),
	3 => __( 'Wednesday', 'tutor-scheduling' ),
	4 => __( 'Thursday', 'tutor-scheduling' ),
	5 => __( 'Friday', 'tutor-scheduling' ),
	6 => __( 'Saturday', 'tutor-scheduling' ),
);
?>

<div class="tutor-scheduling-availability">
	<h2><?php esc_html_e( 'Set Your Availability', 'tutor-scheduling' ); ?></h2>
	<p><?php esc_html_e( 'Set your available hours for each day of the week. Students will only be able to book lessons during these times.', 'tutor-scheduling' ); ?></p>
	
	<form id="tutor-availability-form">
		<?php foreach ( $days as $day_num => $day_name ) : 
			$day_availability = null;
			foreach ( $current_availability as $avail ) {
				if ( $avail->day_of_week == $day_num ) {
					$day_availability = $avail;
					break;
				}
			}
		?>
			<div class="availability-day-row">
				<div class="day-name">
					<label>
						<input type="checkbox" name="days[<?php echo esc_attr( $day_num ); ?>][enabled]" 
							<?php checked( $day_availability && $day_availability->is_available ); ?>>
						<?php echo esc_html( $day_name ); ?>
					</label>
				</div>
				<div class="day-times">
					<input type="time" name="days[<?php echo esc_attr( $day_num ); ?>][start_time]" 
						value="<?php echo $day_availability ? esc_attr( substr( $day_availability->start_time, 0, 5 ) ) : '09:00'; ?>">
					<span><?php esc_html_e( 'to', 'tutor-scheduling' ); ?></span>
					<input type="time" name="days[<?php echo esc_attr( $day_num ); ?>][end_time]" 
						value="<?php echo $day_availability ? esc_attr( substr( $day_availability->end_time, 0, 5 ) ) : '17:00'; ?>">
				</div>
			</div>
		<?php endforeach; ?>
		
		<button type="submit" class="tutor-btn tutor-btn-primary">
			<?php esc_html_e( 'Save Availability', 'tutor-scheduling' ); ?>
		</button>
	</form>
	
	<div id="availability-message" class="tutor-alert" style="display:none;"></div>
	
	<h3 style="margin-top: 30px;"><?php esc_html_e( 'Manage Google Meet Links for Bookings', 'tutor-scheduling' ); ?></h3>
	<p><?php esc_html_e( 'You can add Google Meet links to your scheduled lessons. Students will see these links in their calendar.', 'tutor-scheduling' ); ?></p>
	
	<?php
	// Get teacher's upcoming bookings
	$booking = new Tutor_Scheduling_Lesson_Booking();
	$upcoming_bookings = $booking->get_teacher_bookings( $teacher_id, 'scheduled' );
	$upcoming_bookings = array_filter( $upcoming_bookings, function( $b ) {
		return strtotime( $b->booking_date . ' ' . $b->booking_time ) >= time();
	} );
	?>
	
	<?php if ( ! empty( $upcoming_bookings ) ) : ?>
		<div class="tutor-bookings-list">
			<table class="tutor-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date & Time', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Student', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Course', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Google Meet Link', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Action', 'tutor-scheduling' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $upcoming_bookings as $b ) : 
						$student = get_userdata( $b->student_id );
						$course = get_post( $b->course_id );
					?>
						<tr>
							<td>
								<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $b->booking_date ) ) ); ?><br>
								<?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $b->booking_time ) ) ); ?>
							</td>
							<td><?php echo esc_html( $student->display_name ); ?></td>
							<td><?php echo esc_html( $course->post_title ); ?></td>
							<td>
								<input type="url" 
									class="google-meet-input" 
									data-booking-id="<?php echo esc_attr( $b->id ); ?>"
									value="<?php echo esc_attr( $b->google_meet_link ); ?>"
									placeholder="https://meet.google.com/xxx-xxxx-xxx">
							</td>
							<td>
								<button type="button" 
									class="tutor-btn tutor-btn-sm save-google-meet" 
									data-booking-id="<?php echo esc_attr( $b->id ); ?>">
									<?php esc_html_e( 'Save', 'tutor-scheduling' ); ?>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'No upcoming bookings found.', 'tutor-scheduling' ); ?></p>
	<?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
	// Save Google Meet link
	$(document).on('click', '.save-google-meet', function() {
		var $button = $(this);
		var bookingId = $button.data('booking-id');
		var $input = $('.google-meet-input[data-booking-id="' + bookingId + '"]');
		var googleMeetLink = $input.val();
		
		$button.prop('disabled', true).text('<?php esc_html_e( 'Saving...', 'tutor-scheduling' ); ?>');
		
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			data: {
				action: 'tutor_scheduling_save_google_meet',
				nonce: tutorScheduling.nonce,
				booking_id: bookingId,
				google_meet_link: googleMeetLink
			},
			success: function(response) {
				if (response.success) {
					$button.prop('disabled', false).text('<?php esc_html_e( 'Saved!', 'tutor-scheduling' ); ?>');
					setTimeout(function() {
						$button.text('<?php esc_html_e( 'Save', 'tutor-scheduling' ); ?>');
					}, 2000);
				} else {
					alert(response.data.message || '<?php esc_html_e( 'Failed to save', 'tutor-scheduling' ); ?>');
					$button.prop('disabled', false).text('<?php esc_html_e( 'Save', 'tutor-scheduling' ); ?>');
				}
			},
			error: function() {
				alert('<?php esc_html_e( 'Error saving Google Meet link', 'tutor-scheduling' ); ?>');
				$button.prop('disabled', false).text('<?php esc_html_e( 'Save', 'tutor-scheduling' ); ?>');
			}
		});
	});
});
</script>

<script>
jQuery(document).ready(function($) {
	$('#tutor-availability-form').on('submit', function(e) {
		e.preventDefault();
		
		var formData = $(this).serialize();
		var days = {};
		
		$('input[name^="days["]').each(function() {
			var name = $(this).attr('name');
			var match = name.match(/days\[(\d+)\]\[(\w+)\]/);
			if (match) {
				var dayNum = match[1];
				var field = match[2];
				
				if (!days[dayNum]) {
					days[dayNum] = {};
				}
				
				if ($(this).is(':checkbox')) {
					days[dayNum][field] = $(this).is(':checked');
				} else {
					days[dayNum][field] = $(this).val();
				}
			}
		});
		
		// Save each day
		var promises = [];
		for (var dayNum in days) {
			var day = days[dayNum];
			if (day.enabled) {
				var promise = $.ajax({
					url: tutorScheduling.ajaxurl,
					type: 'POST',
					data: {
						action: 'tutor_scheduling_save_availability',
						nonce: tutorScheduling.nonce,
						day_of_week: dayNum,
						start_time: day.start_time,
						end_time: day.end_time,
						is_available: true
					}
				});
				promises.push(promise);
			}
		}
		
		$.when.apply($, promises).done(function() {
			$('#availability-message').removeClass('tutor-alert-error').addClass('tutor-alert-success')
				.text('<?php esc_html_e( 'Availability saved successfully!', 'tutor-scheduling' ); ?>')
				.show();
			
			setTimeout(function() {
				$('#availability-message').fadeOut();
			}, 3000);
		});
	});
});
</script>

