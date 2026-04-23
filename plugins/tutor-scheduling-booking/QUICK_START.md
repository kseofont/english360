# Quick Start Guide - Test Setup

## 🚀 Fastest Way to Create Test Data

### Method 1: Quick Setup Script (EASIEST - Recommended)

1. **Make sure you're logged in as Administrator**
   - Go to: `yoursite.com/wp-admin`
   - Login with admin credentials

2. **Run the Quick Setup Script**
   - Visit: `yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-quick-setup.php`
   - The script will automatically create everything
   - You'll see a success message with all the details

3. **Done!** Check your email and start testing

---

### Method 2: WordPress Admin Panel

#### Step 1: Access WordPress Admin
- URL: `yoursite.com/wp-admin`
- Login with administrator account

#### Step 2: Find the Test Setup Menu

**Option A: Via Tutor Menu (Recommended)**
1. In the **left sidebar**, look for **"Tutor"** menu
2. Click on **"Tutor"** to expand the menu
3. Scroll down and find **"Scheduling Test Setup"**
4. Click on it

**Visual Guide:**
```
Left Sidebar Menu:
┌─────────────────┐
│ Dashboard       │
│ Posts           │
│ Media           │
│ Pages           │
│ ...             │
│ Tutor ▼         │ ← Click to expand
│   Courses       │
│   Students      │
│   Instructors   │
│   Settings      │
│   Scheduling    │
│   Scheduling    │
│   Test Setup ←  │ ← Click here!
└─────────────────┘
```

**Option B: Via Scheduling Page**
1. Go to: **Tutor > Scheduling**
2. At the top of the page, you'll see a blue button: **"Go to Test Setup"**
3. Click that button

**Option C: Direct URL**
- Copy and paste this URL in your browser:
- `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`

#### Step 3: Create Test Data
1. On the Test Setup page, you'll see checkboxes:
   - ☑ Create Test Users (Teacher & Student)
   - ☑ Create Test Course
   - ☑ Create WooCommerce Product
   - ☑ Create Subscription/Order
   - ☑ Set Teacher Availability
   - ☑ Create Test Bookings
   - ☑ Trigger Test Notifications

2. **Leave all checked** (or uncheck what you don't need)

3. Click the **"Create Test Data"** button at the bottom

4. Wait for the success message: "Test data created successfully!"

---

## 📧 Test Accounts Created

After running the setup, you can login with:

**Teacher Account:**
- Email: `teacher@test.com`
- Password: `password123`
- Role: Tutor Instructor

**Student Account:**
- Email: `dmitry.stepanov28@gmail.com`
- Password: `password123`
- Role: Subscriber

---

## ✅ What Gets Created

1. ✅ **Test Teacher** - Can set availability and see bookings
2. ✅ **Test Student** - Can book lessons and see subscriptions
3. ✅ **Test Course** - "Test Course - Scheduling & Booking"
4. ✅ **WooCommerce Product** - "Test Course Subscription - 10 Lessons"
5. ✅ **Subscription** - Active with 10 lessons (3 used, 7 remaining)
6. ✅ **Teacher Availability** - Monday-Friday 9am-5pm, Saturday 10am-2pm
7. ✅ **Test Bookings** - 3 bookings for upcoming days
8. ✅ **Notifications** - Sent to dmitry.stepanov28@gmail.com

---

## 🔍 Troubleshooting

### Can't find the menu?

**Solution 1: Use Direct URL**
- `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`

**Solution 2: Use Quick Setup Script**
- `yoursite.com/wp-content/plugins/tutor-scheduling-booking/test-quick-setup.php`

**Solution 3: Check if plugin is active**
- Go to: **Plugins > Installed Plugins**
- Make sure "Tutor Scheduling & Booking" is **Activated**

### Menu not showing?

1. **Clear browser cache** and refresh
2. **Check user permissions** - You must be Administrator
3. **Try direct URL** method instead

### Test setup page shows error?

1. Make sure **Tutor LMS** is installed and activated
2. Make sure **WooCommerce** is installed and activated
3. Check WordPress error logs

---

## 📱 Quick Access Links

After setup, you can quickly access:

- **Student Dashboard:** `yoursite.com/dashboard` (login as student)
- **Teacher Dashboard:** `yoursite.com/dashboard` (login as teacher)
- **Admin Scheduling:** `yoursite.com/wp-admin/admin.php?page=tutor-scheduling`
- **Test Setup:** `yoursite.com/wp-admin/admin.php?page=tutor-scheduling-test`

---

## 🎯 Next Steps After Setup

1. **Check Email** - Look for notifications in dmitry.stepanov28@gmail.com
2. **Login as Student** - Test booking functionality
3. **Login as Teacher** - Test availability and view bookings
4. **Check Subscriptions** - Verify lesson tracking works
5. **Test Notifications** - Verify emails are sent correctly

---

## ⚠️ Important Notes

- **Remove test files before production:**
  - `test-quick-setup.php`
  - `includes/class-test-setup.php`

- **Test accounts are for development only**
- **Don't use test data in production**

---

## 📞 Need Help?

If you still can't find the menu:
1. Use the **Quick Setup Script** (Method 1) - it's the easiest
2. Or use the **Direct URL** method
3. Check that you're logged in as Administrator

