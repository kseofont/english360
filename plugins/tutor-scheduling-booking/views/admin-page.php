<?php
/**
 * Admin Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Tutor Scheduling & Booking', 'tutor-scheduling' ); ?></h1>
	
	<?php
	// Show test setup link if available
	$test_setup_url = admin_url( 'admin.php?page=tutor-scheduling-test' );
	$quick_setup_url = TUTOR_SCHEDULING_URL . 'test-quick-setup.php';
	?>
	
	<div class="notice notice-info" style="margin: 20px 0; padding: 15px;">
		<h3 style="margin-top: 0;"><?php esc_html_e( '🚀 Quick Test Setup', 'tutor-scheduling' ); ?></h3>
		<p>
			<strong><?php esc_html_e( 'Need to create test data?', 'tutor-scheduling' ); ?></strong>
		</p>
		<p>
			<a href="<?php echo esc_url( $test_setup_url ); ?>" class="button button-primary button-large" style="margin-right: 10px;">
				<?php esc_html_e( '📋 Go to Test Setup Page', 'tutor-scheduling' ); ?>
			</a>
			<a href="<?php echo esc_url( $quick_setup_url ); ?>" target="_blank" class="button button-secondary button-large">
				<?php esc_html_e( '⚡ Quick Setup Script', 'tutor-scheduling' ); ?>
			</a>
		</p>
		<p style="margin-top: 10px; color: #666;">
			<strong><?php esc_html_e( 'Direct URL:', 'tutor-scheduling' ); ?></strong> 
			<code><?php echo esc_url( $test_setup_url ); ?></code>
		</p>
	</div>
	
	<div class="tutor-scheduling-admin">
		<h2><?php esc_html_e( 'Statistics', 'tutor-scheduling' ); ?></h2>
		
		<?php
		global $wpdb;
		$bookings_table = $wpdb->prefix . 'tutor_lesson_bookings';
		$subscriptions_table = $wpdb->prefix . 'tutor_subscription_lessons';
		
		$total_bookings = $wpdb->get_var( "SELECT COUNT(*) FROM {$bookings_table}" );
		$active_subscriptions = $wpdb->get_var( "SELECT COUNT(*) FROM {$subscriptions_table} WHERE status = 'active'" );
		$upcoming_bookings = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$bookings_table} WHERE booking_date >= %s AND status IN ('scheduled', 'rescheduled')",
			current_time( 'Y-m-d' )
		) );
		?>
		
		<div class="stats-grid">
			<div class="stat-card">
				<h3><?php echo esc_html( $total_bookings ); ?></h3>
				<p><?php esc_html_e( 'Total Bookings', 'tutor-scheduling' ); ?></p>
			</div>
			<div class="stat-card">
				<h3><?php echo esc_html( $active_subscriptions ); ?></h3>
				<p><?php esc_html_e( 'Active Subscriptions', 'tutor-scheduling' ); ?></p>
			</div>
			<div class="stat-card">
				<h3><?php echo esc_html( $upcoming_bookings ); ?></h3>
				<p><?php esc_html_e( 'Upcoming Bookings', 'tutor-scheduling' ); ?></p>
			</div>
		</div>
	</div>
</div>

<style>
.stats-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
	gap: 20px;
	margin-top: 20px;
}

.stat-card {
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 8px;
	padding: 20px;
	text-align: center;
}

.stat-card h3 {
	font-size: 36px;
	margin: 0;
	color: #2271b1;
}

.stat-card p {
	margin: 10px 0 0;
	color: #666;
}
</style>

