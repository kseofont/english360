# Tutor Scheduling & Booking Plugin

A comprehensive scheduling and booking system for Tutor LMS with subscription management and notifications.

## Features

### 1. Teacher Availability Management
- Teachers can set their availability for each day of the week
- Define start and end times for each day
- Enable/disable availability for specific days

### 2. Lesson Booking System
- Students can book lessons based on teacher availability
- Real-time slot availability checking
- Automatic lesson deduction from subscription
- Booking validation and conflict prevention

### 3. Booking Management
- **Cancel Bookings**: Students and teachers can cancel bookings (with 24-hour minimum notice)
- **Reschedule Bookings**: Move bookings to different dates/times
- View all bookings in dashboard
- Status tracking (scheduled, completed, cancelled, rescheduled)

### 4. Subscription Tracking
- Track total lessons purchased
- Monitor used lessons
- Display remaining lessons
- Integration with WooCommerce Subscriptions
- Support for one-time purchases

### 5. Notifications
- **Admin Notifications**: Alert when subscription has 2 lessons remaining
- **Student Notifications**: Reminder about subscription ending and next payment
- Email notifications
- Integration with Tutor Notifications (if available)

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin requires Tutor LMS and WooCommerce to be installed

## Usage

### For Teachers

1. Go to Tutor Dashboard > Availability
2. Set your available hours for each day of the week
3. Save your availability
4. View your scheduled lessons in the Bookings section

### For Students

1. Purchase a course/subscription with lessons
2. Go to the course page or use the `[tutor_book_lesson]` shortcode
3. Select a date and available time slot
4. Book your lesson
5. View your bookings and subscription status in the dashboard

### Shortcodes

- `[tutor_book_lesson teacher_id="123" course_id="456"]` - Display booking form
- `[tutor_my_subscriptions]` - Display student's subscriptions
- `[tutor_teacher_availability teacher_id="123"]` - Display teacher availability

### Product Setup

When creating a WooCommerce product for a course:

1. Link the product to a Tutor course
2. In the product settings, set "Total Lessons in Subscription" field
3. This determines how many lessons are included in the purchase

## Database Tables

The plugin creates the following database tables:

- `wp_tutor_teacher_availability` - Teacher availability schedules
- `wp_tutor_lesson_bookings` - Lesson bookings
- `wp_tutor_subscription_lessons` - Subscription tracking
- `wp_tutor_scheduling_notifications` - Notification logs

## Requirements

- WordPress 5.0+
- PHP 7.2+
- Tutor LMS
- WooCommerce
- WooCommerce Subscriptions (optional, for recurring subscriptions)

## Support

For issues and feature requests, please contact support.

