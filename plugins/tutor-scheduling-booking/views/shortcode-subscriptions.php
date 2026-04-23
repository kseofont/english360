<?php
/**
 * My Subscriptions Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	echo '<p>' . esc_html__( 'Please log in to view your subscriptions.', 'tutor-scheduling' ) . '</p>';
	return;
}

$tracker = new Tutor_Scheduling_Subscription_Tracker();
$user_id = get_current_user_id();
$subscriptions = $tracker->get_student_subscriptions( $user_id );
?>

<div class="tutor-my-subscriptions">
	<h3><?php esc_html_e( 'My Subscriptions', 'tutor-scheduling' ); ?></h3>
	
	<?php if ( empty( $subscriptions ) ) : ?>
		<p><?php esc_html_e( 'No active subscriptions found.', 'tutor-scheduling' ); ?></p>
	<?php else : ?>
		<div class="subscriptions-list">
			<?php foreach ( $subscriptions as $subscription ) : 
				$details = $tracker->get_subscription_details( $user_id, $subscription->subscription_id );
				$course = $details['course'];
			?>
				<div class="subscription-item">
					<h4><?php echo esc_html( $course->post_title ); ?></h4>
					<div class="subscription-info">
						<p>
							<strong><?php esc_html_e( 'Total Lessons:', 'tutor-scheduling' ); ?></strong>
							<?php echo esc_html( $subscription->total_lessons ); ?>
						</p>
						<p>
							<strong><?php esc_html_e( 'Used:', 'tutor-scheduling' ); ?></strong>
							<?php echo esc_html( $subscription->used_lessons ); ?>
						</p>
						<p>
							<strong><?php esc_html_e( 'Remaining:', 'tutor-scheduling' ); ?></strong>
							<span class="<?php echo $subscription->remaining_lessons <= 2 ? 'warning' : ''; ?>">
								<?php echo esc_html( $subscription->remaining_lessons ); ?>
							</span>
						</p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

