<?php
/**
 * Home Page Template with Login Buttons
 * 
 * This is a simple landing page with login buttons for students and teachers.
 * You can use this as a custom page template or integrate it into your theme.
 */

// Load WordPress
if ( ! defined( 'ABSPATH' ) ) {
	require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );
}

// If user is already logged in, redirect to dashboard
if ( is_user_logged_in() ) {
	if ( function_exists( 'tutor_utils' ) ) {
		wp_safe_redirect( tutor_utils()->tutor_dashboard_url() );
		exit;
	} else {
		wp_safe_redirect( home_url( '/wp-admin' ) );
		exit;
	}
}

// Get login URLs
$student_login_url = function_exists( 'tutor_utils' ) 
	? tutor_utils()->tutor_dashboard_url() 
	: wp_login_url();

$teacher_login_url = function_exists( 'tutor_utils' ) 
	? tutor_utils()->tutor_dashboard_url() 
	: wp_login_url();

// Get site name
$site_name = get_bloginfo( 'name' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo esc_html( $site_name ? $site_name . ' - ' : '' ); ?>Login</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.container {
			background: white;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			padding: 60px 40px;
			max-width: 500px;
			width: 100%;
			text-align: center;
			animation: fadeInUp 0.6s ease-out;
		}

		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.logo {
			font-size: 32px;
			font-weight: 700;
			color: #667eea;
			margin-bottom: 10px;
		}

		.subtitle {
			color: #666;
			font-size: 16px;
			margin-bottom: 40px;
		}

		.login-buttons {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.btn {
			display: inline-block;
			padding: 18px 40px;
			font-size: 18px;
			font-weight: 600;
			text-decoration: none;
			border-radius: 12px;
			transition: all 0.3s ease;
			cursor: pointer;
			border: none;
			width: 100%;
			position: relative;
			overflow: hidden;
		}

		.btn::before {
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			width: 0;
			height: 0;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.3);
			transform: translate(-50%, -50%);
			transition: width 0.6s, height 0.6s;
		}

		.btn:hover::before {
			width: 300px;
			height: 300px;
		}

		.btn-student {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
		}

		.btn-student:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
		}

		.btn-teacher {
			background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
			color: white;
		}

		.btn-teacher:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
		}

		.btn-icon {
			margin-right: 10px;
			font-size: 20px;
		}

		.divider {
			display: flex;
			align-items: center;
			margin: 30px 0;
			color: #999;
		}

		.divider::before,
		.divider::after {
			content: '';
			flex: 1;
			height: 1px;
			background: #e0e0e0;
		}

		.divider span {
			padding: 0 15px;
		}

		.footer {
			margin-top: 30px;
			color: #999;
			font-size: 14px;
		}

		@media (max-width: 480px) {
			.container {
				padding: 40px 30px;
			}

			.logo {
				font-size: 28px;
			}

			.btn {
				padding: 16px 30px;
				font-size: 16px;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="logo"><?php echo esc_html( $site_name ? $site_name : 'LMS' ); ?></div>
		<p class="subtitle">Welcome! Please select your login option</p>
		
		<div class="login-buttons">
			<a href="<?php echo esc_url( $student_login_url ); ?>" class="btn btn-student">
				<span class="btn-icon">👨‍🎓</span>
				Login as Student
			</a>
			
			<a href="<?php echo esc_url( $teacher_login_url ); ?>" class="btn btn-teacher">
				<span class="btn-icon">👨‍🏫</span>
				Login as Teacher
			</a>
		</div>

		<div class="footer">
			<p>&copy; <?php echo date( 'Y' ); ?> <?php echo esc_html( $site_name ? $site_name : 'LMS' ); ?>. All rights reserved.</p>
		</div>
	</div>
</body>
</html>

