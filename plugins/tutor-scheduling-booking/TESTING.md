# Testing Guide

This guide will help you test all the functionality of the Tutor Scheduling & Booking plugin.

## 📚 Documentation Files

- **QUICK_START.md** - Fast setup guide with step-by-step instructions
- **FIND_TEST_SETUP.md** - Detailed guide on how to find the test setup menu
- **TESTING.md** - This file (complete testing checklist)

## Quick Setup (Recommended)

> **💡 Can't find the menu?** See **FIND_TEST_SETUP.md** for detailed navigation instructions!

### Method 1: Quick Setup Script

1. Make sure you're logged in as an administrator
2. Visit: `yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-quick-setup.php`
3. The script will automatically create all test data
4. Check your email (dmitry.stepanov28@gmail.com) for notifications

### Method 2: Admin Panel Setup

**Step-by-step instructions:**

1. **Login to WordPress Admin**
   - Go to: `yoursite.com/wp-admin`
   - Login with your administrator account

2. **Navigate to Test Setup**
   - In the left sidebar, find **"Tutor"** menu (Tutor LMS plugin menu)
   - Click on **"Tutor"** to expand it
   - Look for **"Scheduling Test Setup"** in the submenu
   - Click on **"Scheduling Test Setup"**

   **Alternative path:**
   - Go to: **Tutor > Scheduling** (main scheduling page)
   - At the top of that page, you'll see a blue button **"Go to Test Setup"**
   - Click that button

3. **Create Test Data**
   - On the Test Setup page, you'll see checkboxes for different test data
   - Check all the options you want to create (or leave all checked)
   - Click the **"Create Test Data"** button at the bottom
   - Wait for the success message

4. **Verify Creation**
   - Check your email (dmitry.stepanov28@gmail.com) for notifications
   - Login as student/teacher to verify data

**Visual Guide:**
```
WordPress Admin Sidebar:
├── Dashboard
├── Tutor ← Click here
│   ├── Courses
│   ├── Students
│   ├── Instructors
│   ├── Settings
│   ├── Scheduling ← Main scheduling page
│   └── Scheduling Test Setup ← Test setup page (NEW!)
```

**Direct URL:**
If you can't find the menu, you can access it directly:
- `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`

## Test Accounts Created

- **Teacher Email:** teacher@test.com
- **Teacher Password:** password123
- **Student Email:** dmitry.stepanov28@gmail.com
- **Student Password:** password123

## What Gets Created

1. **Test Teacher** - User with tutor_instructor role
2. **Test Student** - User with subscriber role (Dmitry Stepanov)
3. **Test Course** - "Test Course - Scheduling & Booking"
4. **WooCommerce Product** - "Test Course Subscription - 10 Lessons" (linked to course)
5. **Subscription/Order** - Active subscription with 10 lessons
6. **Teacher Availability** - Monday-Friday 9am-5pm, Saturday 10am-2pm
7. **Test Bookings** - 3 bookings for upcoming days
8. **Notifications** - Subscription ending notification (2 lessons remaining)

## Testing Checklist

### 1. Teacher Availability
- [ ] Login as teacher (teacher@test.com)
- [ ] Go to Tutor Dashboard > Availability
- [ ] Verify availability is set for weekdays
- [ ] Try modifying availability and saving

### 2. Subscription Tracking
- [ ] Login as student (dmitry.stepanov28@gmail.com)
- [ ] Go to Tutor Dashboard > Subscriptions
- [ ] Verify you see: Total: 10, Used: 3, Remaining: 7
- [ ] Check that remaining lessons shows correctly

### 3. Bookings
- [ ] Login as student
- [ ] Go to Tutor Dashboard > My Bookings
- [ ] Verify 3 bookings are listed
- [ ] Try canceling a booking (should work if >24 hours away)
- [ ] Try rescheduling a booking

### 4. Booking a New Lesson
- [ ] Login as student
- [ ] Go to the test course page
- [ ] Use the booking form or shortcode
- [ ] Select a date and time
- [ ] Book a lesson
- [ ] Verify remaining lessons decreased by 1

### 5. Notifications
- [ ] Check email inbox (dmitry.stepanov28@gmail.com)
- [ ] Should receive:
  - Subscription ending notification (admin)
  - Subscription ending notification (student)
  - Payment reminder (if subscription exists)

### 6. Teacher View
- [ ] Login as teacher
- [ ] Go to Tutor Dashboard > My Bookings
- [ ] Verify you can see student bookings
- [ ] Check subscription details for students

### 7. Admin View
- [ ] Login as admin
- [ ] Go to Tutor > Scheduling
- [ ] Check statistics dashboard
- [ ] Verify all data is displayed correctly

## Testing Notifications

To test notifications manually:

**Option 1: Via Admin Panel**
1. Go to WordPress Admin
2. Navigate to: **Tutor > Scheduling Test Setup** (or use direct URL: `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`)
3. Check "Trigger Test Notifications"
4. Click "Create Test Data"
5. Check email inbox

**Option 2: Direct URL**
- Visit: `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`
- Check "Trigger Test Notifications"
- Click "Create Test Data"

Or manually trigger:

```php
// In WordPress admin or via code
$notifications = new Tutor_Scheduling_Notifications();
$notifications->check_subscription_endings();
```

## Testing Subscription Ending

To test the "2 lessons remaining" notification:

1. Login as admin
2. Go to phpMyAdmin or use a database tool
3. Find the subscription in `wp_tutor_subscription_lessons`
4. Set `remaining_lessons` to 2
5. Set `used_lessons` to 8 (if total is 10)
6. Save
7. The notification should trigger on next cron run or manually trigger

## Troubleshooting

### No notifications received?
- Check spam folder
- Verify email settings in WordPress
- Check if WP_DEBUG is enabled (required for test setup)
- Verify admin_email is set correctly

### Bookings not showing?
- Check if teacher availability is set
- Verify subscription has remaining lessons
- Check booking date is in the future

### Subscription not tracking?
- Verify WooCommerce product is linked to course
- Check product has `_tutor_total_lessons` meta
- Verify order/subscription status is "completed" or "active"

## Clean Up Test Data

To remove test data:

1. Delete test users from Users > All Users
2. Delete test course from Courses
3. Delete test product from Products
4. Delete test orders/subscriptions from WooCommerce
5. Optionally clear database tables (be careful!)

## Production Warning

⚠️ **IMPORTANT:** Remove or disable test setup files before going to production:
- `includes/class-test-setup.php`
- `test-quick-setup.php`

These files should only be used in development/testing environments.

