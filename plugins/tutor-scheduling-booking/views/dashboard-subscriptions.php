<?php
/**
 * Subscriptions Dashboard Page
 * 
 * Note: This is included within Tutor's dashboard template wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tracker = new Tutor_Scheduling_Subscription_Tracker();
$user_id = get_current_user_id();

// Check if viewing as teacher (for student subscriptions)
$viewing_student_id = isset( $_GET['student_id'] ) ? intval( $_GET['student_id'] ) : $user_id;
$is_teacher_view = ( $viewing_student_id != $user_id && current_user_can( 'tutor_instructor' ) );

$subscriptions = $tracker->get_student_subscriptions( $viewing_student_id );
?>

<div class="tutor-scheduling-subscriptions">
	<div class="subscriptions-header">
		<h2><?php esc_html_e( 'My Subscriptions', 'tutor-scheduling' ); ?></h2>
		<a href="<?php echo esc_url( tutor_utils()->get_tutor_dashboard_page_permalink( 'purchase-subscription' ) ); ?>" class="tutor-btn tutor-btn-primary">
			<?php esc_html_e( 'Purchase Subscription', 'tutor-scheduling' ); ?>
		</a>
	</div>
	
	<?php if ( empty( $subscriptions ) ) : ?>
		<div class="no-subscriptions">
			<p><?php esc_html_e( 'No active subscriptions found.', 'tutor-scheduling' ); ?></p>
			<a href="<?php echo esc_url( tutor_utils()->get_tutor_dashboard_page_permalink( 'purchase-subscription' ) ); ?>" class="tutor-btn tutor-btn-primary">
				<?php esc_html_e( 'Purchase Your First Subscription', 'tutor-scheduling' ); ?>
			</a>
		</div>
	<?php else : ?>
		<div class="subscriptions-grid">
			<?php foreach ( $subscriptions as $subscription ) : 
				$details = $tracker->get_subscription_details( $viewing_student_id, $subscription->subscription_id );
				$course = $details['course'];
				$wc_subscription = $details['wc_subscription'];
			?>
				<div class="subscription-card">
					<h3><?php echo esc_html( $course->post_title ); ?></h3>
					
					<div class="subscription-stats">
						<div class="stat-item">
							<strong><?php esc_html_e( 'Total Lessons:', 'tutor-scheduling' ); ?></strong>
							<span><?php echo esc_html( $subscription->total_lessons ); ?></span>
						</div>
						<div class="stat-item">
							<strong><?php esc_html_e( 'Used:', 'tutor-scheduling' ); ?></strong>
							<span><?php echo esc_html( $subscription->used_lessons ); ?></span>
						</div>
						<div class="stat-item">
							<strong><?php esc_html_e( 'Remaining:', 'tutor-scheduling' ); ?></strong>
							<span class="remaining-lessons <?php echo $subscription->remaining_lessons <= 2 ? 'warning' : ''; ?>">
								<?php echo esc_html( $subscription->remaining_lessons ); ?>
							</span>
						</div>
					</div>
					
					<?php if ( $wc_subscription ) : 
						$next_payment = $wc_subscription->get_date( 'next_payment' );
					?>
						<div class="subscription-info">
							<p>
								<strong><?php esc_html_e( 'Status:', 'tutor-scheduling' ); ?></strong>
								<?php echo esc_html( ucfirst( $subscription->status ) ); ?>
							</p>
							<?php if ( $next_payment ) : ?>
								<p>
									<strong><?php esc_html_e( 'Next Payment:', 'tutor-scheduling' ); ?></strong>
									<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $next_payment ) ) ); ?>
								</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $subscription->remaining_lessons <= 2 && $subscription->remaining_lessons > 0 ) : ?>
						<div class="subscription-warning">
							<?php esc_html_e( '⚠️ Your subscription is ending soon!', 'tutor-scheduling' ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<style>
.subscriptions-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 20px;
}

.subscriptions-header h2 {
	margin: 0;
}

.no-subscriptions {
	text-align: center;
	padding: 40px 20px;
	background: #f9f9f9;
	border-radius: 8px;
	margin-top: 20px;
}

.no-subscriptions p {
	margin-bottom: 20px;
	font-size: 16px;
	color: #666;
}

.subscriptions-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
	gap: 20px;
	margin-top: 20px;
}

.subscription-card {
	border: 1px solid #ddd;
	border-radius: 8px;
	padding: 20px;
	background: #fff;
}

.subscription-stats {
	display: flex;
	justify-content: space-between;
	margin: 15px 0;
	padding: 15px;
	background: #f5f5f5;
	border-radius: 5px;
}

.stat-item {
	text-align: center;
}

.stat-item strong {
	display: block;
	margin-bottom: 5px;
}

.stat-item span {
	font-size: 24px;
	font-weight: bold;
	color: #333;
}

.remaining-lessons.warning {
	color: #d63638;
}

.subscription-warning {
	background: #fff3cd;
	border: 1px solid #ffc107;
	padding: 10px;
	border-radius: 5px;
	margin-top: 15px;
	color: #856404;
}
</style>

