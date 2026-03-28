<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

// Admin routes
Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
    
    Route::resource('listings', ListingController::class);
    Route::post('/listings/{listing}/approve', [ListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [ListingController::class, 'reject'])->name('listings.reject');
    Route::post('/listings/{listing}/toggle-premium', [ListingController::class, 'togglePremium'])->name('listings.toggle-premium');

    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');

    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation');
    Route::post('/moderation/{report}/resolve', [ModerationController::class, 'resolve'])->name('moderation.resolve');
    Route::delete('/moderation/{report}', [ModerationController::class, 'destroy'])->name('moderation.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/categories', [SettingController::class, 'storeCategory'])->name('settings.categories.store');
    Route::patch('/settings/categories/{category}', [SettingController::class, 'updateCategory'])->name('settings.categories.update');
    Route::delete('/settings/categories/{category}', [SettingController::class, 'destroyCategory'])->name('settings.categories.destroy');
    Route::post('/settings/banners', [SettingController::class, 'storeBanner'])->name('settings.banners.store');
    Route::patch('/settings/banners/{banner}', [SettingController::class, 'updateBanner'])->name('settings.banners.update');
    Route::delete('/settings/banners/{banner}', [SettingController::class, 'destroyBanner'])->name('settings.banners.destroy');
    
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles-permissions');
    Route::post('/roles-permissions/roles', [RolePermissionController::class, 'storeRole'])->name('roles-permissions.store-role');
    Route::post('/roles-permissions/sync', [RolePermissionController::class, 'syncMatrix'])->name('roles-permissions.sync');

    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);
    Route::resource('permissions', PermissionController::class)->except(['create', 'show', 'edit']);

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::patch('/notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
