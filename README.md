# FastBite — Notification System Integration Guide

## What's Changed

| Before | After |
|--------|-------|
| Dark mode toggle in sidebar | **Notification Bell** with red badge |
| User types DELETE → account deleted immediately | User types DELETE → **sends request to admin** |
| No admin visibility | Admin sees pending requests in **slide-in notification panel** |
| — | Admin clicks **Approve & Delete** → confirmation modal → account erased |
| — | Admin can **Dismiss** to reject and close the request |

---

## Files in This Package

```
fastbite-notifications/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProfileController.php       ← updated
│   │   │   ├── NotificationController.php  ← NEW
│   │   │   └── SettingController.php       ← updated (passes $pendingDeletionCount)
│   │   └── Middleware/
│   │       └── AdminMiddleware.php         ← NEW (if you don't already have one)
│   └── Models/
│       └── DeletionRequest.php             ← NEW
├── database/migrations/
│   └── 2024_01_01_000001_create_deletion_requests_table.php  ← NEW
├── resources/views/
│   ├── components/
│   │   ├── asidebar.blade.php              ← REPLACED (bell replaces dark toggle)
│   │   └── notifications-panel.blade.php   ← NEW
│   └── settings/
│       └── index.blade.php                 ← REPLACED
└── routes_web_additions.php                ← add these to your routes/web.php
```

---

## Step-by-Step Integration

### 1. Run the Migration
```bash
php artisan migrate
```

### 2. Copy Model
Copy `app/Models/DeletionRequest.php` into your project's `app/Models/` folder.

### 3. Copy Controllers
Replace/update the three controllers in `app/Http/Controllers/`:
- `ProfileController.php`
- `NotificationController.php`  
- `SettingController.php`

### 4. Register Admin Middleware
In `app/Http/Kernel.php`, add to `$routeMiddleware`:
php
'admin' => \App\Http\Middleware\AdminMiddleware::class,

If you already have an admin middleware, update the name in `routes_web_additions.php` accordingly.

### 5. Add Routes
Open `routes/web.php` and paste in the contents of `routes_web_additions.php`.

### 6. Copy Blade Views
- Replace `resources/views/components/asidebar.blade.php`
- Add `resources/views/components/notifications-panel.blade.php`  
- Replace `resources/views/settings/index.blade.php`

### 7. Gate Policy (optional but recommended)
In `NotificationController`, the `$this->authorize('admin')` calls use Gates.  
Add this to `App\Providers\AuthServiceProvider::boot()`:
php
Gate::define('admin', function ($user) {
    return $user->role === 'Admin';
});
Or remove the `$this->authorize('admin')` lines if you rely on the middleware alone.

---

## How the Flow Works

### User Side
1. User goes to Settings → Profile → Danger Zone
2. Types `DELETE` to unlock the button
3. Clicks **Request Deletion** — a `DeletionRequest` record is created (`status = pending`)
4. The button disappears; a yellow "pending" badge appears instead
5. Admin gets a notification with the badge count on the bell

### Admin Side
1. Bell icon in sidebar shows red badge with count
2. Admin clicks bell → right-side panel slides open
3. Admin sees each pending request with username + timestamp
4. Two options per request:
   - **Approve & Delete** → opens confirmation modal → clicks OK → account + all data deleted
   - **Dismiss** → marks request as dismissed, user account kept, notification clears
5. Toast confirms the action

---

## Notes
- A user can only have **one pending request at a time** (enforced in `ProfileController::requestDeletion`)
- If the user is deleted, the `deletion_requests` row is cascade-deleted (via the migration foreign key)
- The `reviewed_by` column records which admin took the action
- The notification panel is **only rendered for Admin users** — regular users see nothing


## INSTALL (PHP 8.4 , LARAVEL 12)
<!-- PHP 8.4 version -->
composer update
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate (SELCET) -> yes FOR Create table on BD
<!-- Tailwindcss -->
npm install tailwindcss @tailwindcss/vite
<!-- RUN FOR Store Picture -->
php artisan storage:link

## RUN (Open Terminal)
RUN FOR MAC : npm run dev & php artisan serve 
RUN FOR WINDONW : npm run dev , (NEW TERMINAL) : php artisan serve 

## RUN INSERT USERNAME AND PASSWORD FOR LOGIN WHEN DELETE DEFAULT ADMIN RUN THE THIS COMMAND
<!-- LOGIN USERNAME AND PASSWORD -->
php artisan db:seed --class=AdminSeeder