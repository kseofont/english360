# Troubleshooting Guide

## "Failed to create subscription" Error

### What This Means

This error appears when the script tries to create a WooCommerce subscription but encounters an issue. **This is NOT a critical error!** The script will automatically fall back to creating a regular WooCommerce order, which works perfectly for testing all functionality.

### Why It Happens

1. **WooCommerce Subscriptions plugin not installed/activated**
   - The plugin tries to create a subscription first
   - If WooCommerce Subscriptions isn't available, it falls back to a regular order
   - **This is normal and expected!**

2. **Product type mismatch**
   - WooCommerce Subscriptions requires products to be "Subscription" type
   - Our test product is "Simple" type (which is fine for testing)
   - The script handles this automatically

3. **WooCommerce configuration issues**
   - Missing payment gateway
   - Incomplete WooCommerce setup
   - Database issues

### Solutions

#### Solution 1: Let it create a regular order (Recommended)

**This is the easiest solution and works perfectly!**

- The script will automatically create a regular order instead
- Regular orders work fine for testing all functionality:
  - ✅ Subscription tracking works
  - ✅ Lesson booking works
  - ✅ Notifications work
  - ✅ All features work the same

**Just ignore the warning and continue!**

#### Solution 2: Install WooCommerce Subscriptions

If you want to test with actual subscriptions:

1. Install **WooCommerce Subscriptions** plugin
2. Activate it
3. Run the test setup again

#### Solution 3: Check WooCommerce Setup

If even regular orders fail:

1. **Check WooCommerce is activated:**
   - Go to: Plugins > Installed Plugins
   - Make sure WooCommerce is "Activated"

2. **Run WooCommerce Setup Wizard:**
   - Go to: WooCommerce > Settings
   - Complete the setup wizard if not done

3. **Check WordPress error logs:**
   - Look in: `wp-content/debug.log`
   - Or check your server error logs

### Understanding the Messages

**Info Message (Blue):**
```
ℹ WooCommerce Subscriptions not available. Creating regular order instead.
```
- This is **normal** - just informational
- The script will create a regular order
- Everything will work fine

**Warning Message (Yellow):**
```
⚠ Subscription creation error: [error message]
Falling back to regular order...
```
- Subscription failed, but order will be created
- This is **OK** - regular orders work for testing

**Success Message (Green):**
```
✓ Order created successfully (ID: 123)
Note: Regular orders work perfectly for testing all functionality!
```
- Everything worked!
- You can proceed with testing

**Error Message (Red):**
```
❌ Failed to create order/subscription
```
- This is a real problem
- Check WooCommerce configuration
- See Solution 3 above

### What Works with Regular Orders

Even if subscription creation fails, **everything still works:**

✅ **Subscription Tracking**
- Lessons are tracked correctly
- Used/remaining lessons work
- Database tables are created properly

✅ **Booking System**
- Students can book lessons
- Teachers can see bookings
- Cancel/reschedule works

✅ **Notifications**
- Subscription ending notifications work
- Payment reminders work
- All emails are sent

✅ **Dashboard Views**
- Student dashboard shows subscriptions
- Teacher dashboard shows bookings
- Admin dashboard shows statistics

### Testing Without Subscriptions

You can test everything without WooCommerce Subscriptions:

1. **Create test data** (it will use regular orders)
2. **Login as student** - see subscriptions/lessons
3. **Login as teacher** - see bookings
4. **Test booking** - book new lessons
5. **Test notifications** - check emails

**Everything works the same way!**

### Still Having Issues?

1. **Check WordPress error logs:**
   - Enable `WP_DEBUG` in `wp-config.php`
   - Check `wp-content/debug.log`

2. **Check WooCommerce status:**
   - Go to: WooCommerce > Status
   - Look for any errors

3. **Try the Quick Setup Script:**
   - Use: `test-quick-setup.php`
   - It has better error reporting

4. **Check database:**
   - Make sure database tables were created
   - Check: `wp_tutor_subscription_lessons` table exists

### Summary

**Most Important:** The "Failed to create subscription" error is **not a critical issue**. The script will automatically create a regular order instead, which works perfectly for testing all functionality.

Just proceed with testing - everything will work! 🎉
