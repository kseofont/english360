<?php
/**
 * Teacher Availability Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$teacher_id = isset( $atts['teacher_id'] ) ? intval( $atts['teacher_id'] ) : 0;

if ( ! $teacher_id ) {
	echo '<p>' . esc_html__( 'Teacher ID is required.', 'tutor-scheduling' ) . '</p>';
	return;
}

$availability = new Tutor_Scheduling_Availability();
$teacher_availability = $availability->get_availability( $teacher_id );
$teacher = get_userdata( $teacher_id );

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

<div class="tutor-teacher-availability">
	<h3><?php echo esc_html( sprintf( __( '%s Availability', 'tutor-scheduling' ), $teacher->display_name ) ); ?></h3>
	
	<?php if ( empty( $teacher_availability ) ) : ?>
		<p><?php esc_html_e( 'No availability set.', 'tutor-scheduling' ); ?></p>
	<?php else : ?>
		<table class="availability-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Day', 'tutor-scheduling' ); ?></th>
					<th><?php esc_html_e( 'Available Hours', 'tutor-scheduling' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $teacher_availability as $avail ) : ?>
					<tr>
						<td><?php echo esc_html( $days[ $avail->day_of_week ] ); ?></td>
						<td>
							<?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $avail->start_time ) ) ); ?>
							- 
							<?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $avail->end_time ) ) ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<style>
.availability-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 15px;
}

.availability-table th,
.availability-table td {
	padding: 10px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}

.availability-table th {
	background: #f5f5f5;
	font-weight: 600;
}
</style>

