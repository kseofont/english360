# Fix "Page Not Found" for Purchase Subscription Page

If you're getting a "Page not found" error when accessing `/dashboard/purchase-subscription/`, follow these steps:

## Solution 1: Flush Rewrite Rules (Recommended)

1. Go to **WordPress Admin > Settings > Permalinks**
2. Click **"Save Changes"** (you don't need to change anything)
3. This will regenerate all rewrite rules including the new purchase-subscription page
4. Try accessing the page again: `/dashboard/purchase-subscription/`

## Solution 2: Deactivate and Reactivate Plugin

1. Go to **WordPress Admin > Plugins**
2. Deactivate **"Tutor Scheduling & Booking"**
3. Reactivate it
4. The plugin will automatically flush rewrite rules on activation
5. Try accessing the page again

## Solution 3: Run Flush Script

If you have command line access, run:

```bash
php wp-content/plugins/tutor-scheduling-booking/flush-rewrite-rules.php
```

## Solution 4: Clear WordPress Cache

If you're using a caching plugin:

1. Clear all caches
2. Clear browser cache
3. Try accessing the page again

## Verify the Page is Working

After flushing rewrite rules, you can verify the page is registered by running:

```bash
php wp-content/plugins/tutor-scheduling-booking/test-purchase-page.php
```

All checks should show ✓ (green checkmarks).

## Still Not Working?

If the page still doesn't work after trying all solutions:

1. Check that the page is registered:
   - Go to WordPress Admin > Tutor > Scheduling
   - The page should be listed in the dashboard pages

2. Check file permissions:
   - Ensure these files exist:
     - `templates/dashboard-purchase-subscription.php`
     - `views/dashboard-purchase-subscription.php`

3. Enable WordPress debug mode:
   - Add to `wp-config.php`: `define('WP_DEBUG', true);`
   - Check for any error messages

4. Check browser console:
   - Open browser developer tools (F12)
   - Look for any JavaScript errors

