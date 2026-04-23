<?php
/**
 * Bookings Dashboard Page
 * 
 * Note: This is included within Tutor's dashboard template wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$booking = new Tutor_Scheduling_Lesson_Booking();
$user_id = get_current_user_id();

// Check if user is teacher or student
$is_teacher = current_user_can( 'tutor_instructor' );

if ( $is_teacher ) {
	$bookings = $booking->get_teacher_bookings( $user_id );
	$pending_bookings = $booking->get_pending_bookings( $user_id );
	$title = __( 'My Scheduled Lessons', 'tutor-scheduling' );
} else {
	$bookings = $booking->get_student_bookings( $user_id );
	$pending_bookings = array();
	$title = __( 'My Bookings', 'tutor-scheduling' );
}
?>

<div class="tutor-scheduling-bookings">
	<h2><?php echo esc_html( $title ); ?></h2>
	
	<?php if ( $is_teacher && ! empty( $pending_bookings ) ) : ?>
		<div class="pending-bookings-section" style="margin-bottom: 30px;">
			<h3><?php esc_html_e( 'Pending Approval', 'tutor-scheduling' ); ?></h3>
			<table class="tutor-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Time', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Student', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Course', 'tutor-scheduling' ); ?></th>
						<th><?php esc_html_e( 'Actions', 'tutor-scheduling' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $pending_bookings as $pending ) : 
						$student = get_userdata( $pending->student_id );
						$course = get_post( $pending->course_id );
					?>
						<tr>
							<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $pending->booking_date ) ) ); ?></td>
							<td><?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $pending->booking_time ) ) ); ?></td>
							<td><?php echo esc_html( $student->display_name ); ?></td>
							<td><?php echo esc_html( $course->post_title ); ?></td>
							<td>
								<button class="tutor-btn tutor-btn-sm tutor-btn-primary approve-booking" data-booking-id="<?php echo esc_attr( $pending->id ); ?>">
									<?php esc_html_e( 'Approve', 'tutor-scheduling' ); ?>
								</button>
								<button class="tutor-btn tutor-btn-sm tutor-btn-secondary reject-booking" data-booking-id="<?php echo esc_attr( $pending->id ); ?>">
									<?php esc_html_e( 'Reject', 'tutor-scheduling' ); ?>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
	
	<?php if ( empty( $bookings ) ) : ?>
		<p><?php esc_html_e( 'No bookings found.', 'tutor-scheduling' ); ?></p>
	<?php else : ?>
		<table class="tutor-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Date', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Time', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Course', 'tutor-scheduling' ); ?></th>
					<?php if ( ! $is_teacher ) : ?>
						<th><?php esc_html_e( 'Teacher', 'tutor-scheduling' ); ?></th>
					<?php else : ?>
						<th><?php esc_html_e( 'Student', 'tutor-scheduling' ); ?></th>
					<?php endif; ?>
					<th><?php esc_html_e( 'Status', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'tutor-scheduling' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $bookings as $booking_item ) : 
					$course = get_post( $booking_item->course_id );
					if ( $is_teacher ) {
						$other_user = get_userdata( $booking_item->student_id );
					} else {
						$other_user = get_userdata( $booking_item->teacher_id );
					}
				?>
					<tr>
						<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $booking_item->booking_date ) ) ); ?></td>
						<td><?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $booking_item->booking_time ) ) ); ?></td>
						<td><?php echo esc_html( $course->post_title ); ?></td>
						<td><?php echo esc_html( $other_user->display_name ); ?></td>
						<td>
							<span class="status-<?php echo esc_attr( $booking_item->status ); ?>">
								<?php echo esc_html( ucfirst( $booking_item->status ) ); ?>
							</span>
						</td>
						<td>
							<?php if ( $booking_item->status == 'scheduled' || $booking_item->status == 'rescheduled' ) : ?>
								<?php if ( ! $is_teacher ) : ?>
									<button class="tutor-btn tutor-btn-sm cancel-booking" data-booking-id="<?php echo esc_attr( $booking_item->id ); ?>">
										<?php esc_html_e( 'Cancel', 'tutor-scheduling' ); ?>
									</button>
									<button class="tutor-btn tutor-btn-sm reschedule-booking" data-booking-id="<?php echo esc_attr( $booking_item->id ); ?>">
										<?php esc_html_e( 'Reschedule', 'tutor-scheduling' ); ?>
									</button>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<div id="reschedule-modal" style="display:none;">
	<h3><?php esc_html_e( 'Reschedule Booking', 'tutor-scheduling' ); ?></h3>
	<form id="reschedule-form">
		<input type="hidden" id="reschedule-booking-id" name="booking_id">
		<p>
			<label><?php esc_html_e( 'New Date:', 'tutor-scheduling' ); ?></label>
			<input type="date" id="reschedule-date" name="new_date" required>
		</p>
		<p>
			<label><?php esc_html_e( 'New Time:', 'tutor-scheduling' ); ?></label>
			<input type="time" id="reschedule-time" name="new_time" required>
		</p>
		<button type="submit" class="tutor-btn tutor-btn-primary">
			<?php esc_html_e( 'Reschedule', 'tutor-scheduling' ); ?>
		</button>
	</form>
</div>

