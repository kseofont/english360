<?php
/**
 * Pending Bookings Dashboard Page (Teacher)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$booking = new Tutor_Scheduling_Lesson_Booking();
$teacher_id = get_current_user_id();
$pending_bookings = $booking->get_pending_bookings( $teacher_id );
?>

<div class="tutor-scheduling-pending-bookings">
	<h2><?php esc_html_e( 'Pending Bookings', 'tutor-scheduling' ); ?></h2>
	<p><?php esc_html_e( 'Review and approve or reject lesson booking requests from students.', 'tutor-scheduling' ); ?></p>
	
	<?php if ( empty( $pending_bookings ) ) : ?>
		<p><?php esc_html_e( 'No pending bookings at this time.', 'tutor-scheduling' ); ?></p>
	<?php else : ?>
		<table class="tutor-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Date & Time', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Student', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Course', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'tutor-scheduling' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $pending_bookings as $b ) : 
					$student = get_userdata( $b->student_id );
					$course = get_post( $b->course_id );
				?>
					<tr data-booking-id="<?php echo esc_attr( $b->id ); ?>">
						<td>
							<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $b->booking_date ) ) ); ?><br>
							<?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $b->booking_time ) ) ); ?>
						</td>
						<td>
							<?php echo esc_html( $student->display_name ); ?><br>
							<small><?php echo esc_html( $student->user_email ); ?></small>
						</td>
						<td><?php echo esc_html( $course->post_title ); ?></td>
						<td>
							<button class="tutor-btn tutor-btn-sm tutor-btn-primary approve-booking" 
								data-booking-id="<?php echo esc_attr( $b->id ); ?>">
								<?php esc_html_e( 'Approve', 'tutor-scheduling' ); ?>
							</button>
							<button class="tutor-btn tutor-btn-sm tutor-btn-secondary reject-booking" 
								data-booking-id="<?php echo esc_attr( $b->id ); ?>">
								<?php esc_html_e( 'Reject', 'tutor-scheduling' ); ?>
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	
	<div id="pending-booking-message" class="tutor-alert" style="display:none;"></div>
</div>

<script>
jQuery(document).ready(function($) {
	// Approve booking
	$(document).on('click', '.approve-booking', function() {
		var $button = $(this);
		var bookingId = $button.data('booking-id');
		
		if (!confirm('<?php esc_html_e( 'Are you sure you want to approve this booking?', 'tutor-scheduling' ); ?>')) {
			return;
		}
		
		$button.prop('disabled', true).text('<?php esc_html_e( 'Approving...', 'tutor-scheduling' ); ?>');
		
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			data: {
				action: 'tutor_scheduling_approve_booking',
				nonce: tutorScheduling.nonce,
				booking_id: bookingId
			},
			success: function(response) {
				if (response.success) {
					$('#pending-booking-message').removeClass('tutor-alert-error')
						.addClass('tutor-alert-success')
						.text(response.data.message || '<?php esc_html_e( 'Booking approved successfully', 'tutor-scheduling' ); ?>')
						.show();
					
					// Remove row
					$button.closest('tr').fadeOut(function() {
						$(this).remove();
					});
					
					setTimeout(function() {
						$('#pending-booking-message').fadeOut();
					}, 3000);
				} else {
					$('#pending-booking-message').removeClass('tutor-alert-success')
						.addClass('tutor-alert-error')
						.text(response.data.message || '<?php esc_html_e( 'Failed to approve booking', 'tutor-scheduling' ); ?>')
						.show();
					$button.prop('disabled', false).text('<?php esc_html_e( 'Approve', 'tutor-scheduling' ); ?>');
				}
			},
			error: function() {
				$('#pending-booking-message').removeClass('tutor-alert-success')
					.addClass('tutor-alert-error')
					.text('<?php esc_html_e( 'Error approving booking', 'tutor-scheduling' ); ?>')
					.show();
				$button.prop('disabled', false).text('<?php esc_html_e( 'Approve', 'tutor-scheduling' ); ?>');
			}
		});
	});
	
	// Reject booking
	$(document).on('click', '.reject-booking', function() {
		var $button = $(this);
		var bookingId = $button.data('booking-id');
		
		if (!confirm('<?php esc_html_e( 'Are you sure you want to reject this booking?', 'tutor-scheduling' ); ?>')) {
			return;
		}
		
		$button.prop('disabled', true).text('<?php esc_html_e( 'Rejecting...', 'tutor-scheduling' ); ?>');
		
		$.ajax({
			url: tutorScheduling.ajaxurl,
			type: 'POST',
			data: {
				action: 'tutor_scheduling_reject_booking',
				nonce: tutorScheduling.nonce,
				booking_id: bookingId
			},
			success: function(response) {
				if (response.success) {
					$('#pending-booking-message').removeClass('tutor-alert-error')
						.addClass('tutor-alert-success')
						.text(response.data.message || '<?php esc_html_e( 'Booking rejected', 'tutor-scheduling' ); ?>')
						.show();
					
					// Remove row
					$button.closest('tr').fadeOut(function() {
						$(this).remove();
					});
					
					setTimeout(function() {
						$('#pending-booking-message').fadeOut();
					}, 3000);
				} else {
					$('#pending-booking-message').removeClass('tutor-alert-success')
						.addClass('tutor-alert-error')
						.text(response.data.message || '<?php esc_html_e( 'Failed to reject booking', 'tutor-scheduling' ); ?>')
						.show();
					$button.prop('disabled', false).text('<?php esc_html_e( 'Reject', 'tutor-scheduling' ); ?>');
				}
			},
			error: function() {
				$('#pending-booking-message').removeClass('tutor-alert-success')
					.addClass('tutor-alert-error')
					.text('<?php esc_html_e( 'Error rejecting booking', 'tutor-scheduling' ); ?>')
					.show();
				$button.prop('disabled', false).text('<?php esc_html_e( 'Reject', 'tutor-scheduling' ); ?>');
			}
		});
	});
});
</script>

