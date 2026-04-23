# Debug: Availability Menu Not Showing

If the "Availability" menu item is not showing in the instructor dashboard, try these steps:

## 1. Check User Role

Make sure the user is actually an instructor:
- Go to: Users > All Users
- Find your test teacher user
- Check the role is "Tutor Instructor" (not just "Instructor")

## 2. Clear Cache

- Clear browser cache (Ctrl+F5)
- Clear WordPress cache if using a caching plugin
- Clear object cache if using Redis/Memcached

## 3. Check Plugin Activation

- Make sure "Tutor Scheduling & Booking" plugin is activated
- Make sure "Tutor LMS" is activated
- Make sure "Tutor Pro" is activated (if using)

## 4. Verify Filter Hook

The menu item is added via:
```php
add_filter( 'tutor_dashboard/instructor_nav_items', array( $this, 'add_instructor_nav_items' ) );
```

## 5. Test with Different Icon

If the icon class doesn't exist, try changing the icon in:
`wp-content/plugins/tutor-scheduling-booking/includes/class-frontend.php`

Line 88, change:
```php
'icon' => 'tutor-icon-calendar-line',
```

To a known icon like:
```php
'icon' => 'tutor-icon-gear',  // Settings icon
'icon' => 'tutor-icon-rocket', // My Courses icon
'icon' => 'tutor-icon-wallet', // Withdrawals icon
```

## 6. Check for Conflicts

- Disable other plugins temporarily
- Switch to default theme temporarily
- Check if Tutor Pro Calendar addon is conflicting

## 7. Manual Test

Add this to your theme's functions.php temporarily to test:

```php
add_filter( 'tutor_dashboard/instructor_nav_items', function( $nav_items ) {
	$nav_items['test-availability'] = array(
		'title'    => 'Test Availability',
		'icon'     => 'tutor-icon-gear',
		'auth_cap' => tutor()->instructor_role,
	);
	return $nav_items;
} );
```

If this shows up, the filter works and the issue is with our plugin.

## 8. Check Error Logs

- Check WordPress debug.log
- Check PHP error logs
- Enable WP_DEBUG in wp-config.php

## 9. Verify File Permissions

Make sure plugin files are readable:
- `includes/class-frontend.php` should be readable
- Check file permissions (644 for files, 755 for directories)

## 10. Re-activate Plugin

- Deactivate "Tutor Scheduling & Booking"
- Activate it again
- Clear all caches

