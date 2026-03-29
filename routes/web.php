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
    Route::get('/premium-requests', [ListingController::class, 'premiumRequests'])->name('listings.premium-requests');
    Route::post('/listings/{listing}/approve', [ListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [ListingController::class, 'reject'])->name('listings.reject');
    Route::post('/listings/{listing}/approve-premium', [ListingController::class, 'approvePremium'])->name('listings.approve-premium');
    Route::post('/listings/{listing}/reject-premium', [ListingController::class, 'rejectPremium'])->name('listings.reject-premium');
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
});

// Owner routes
Route::middleware(['auth', 'verified', 'role:pemilik-kos'])->prefix('pemilik-kos')->name('pemilik-kos.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PemilikKos\DashboardController::class, 'index'])->name('dashboard');
    
    Route::patch('/listings/reorder-images', [App\Http\Controllers\PemilikKos\ListingController::class, 'reorderImages'])->name('listings.reorder-images');
    Route::resource('listings', App\Http\Controllers\PemilikKos\ListingController::class);

    Route::get('/listings/{listing}/rooms', [App\Http\Controllers\PemilikKos\RoomController::class, 'index'])->name('listings.rooms.index');
    Route::post('/listings/{listing}/rooms', [App\Http\Controllers\PemilikKos\RoomController::class, 'store'])->name('listings.rooms.store');
    Route::patch('/rooms/{room}', [App\Http\Controllers\PemilikKos\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [App\Http\Controllers\PemilikKos\RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::post('/rooms/{room}/toggle-status', [App\Http\Controllers\PemilikKos\RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');

    Route::get('/inquiries', [App\Http\Controllers\PemilikKos\InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [App\Http\Controllers\PemilikKos\InquiryController::class, 'show'])->name('inquiries.show');
    Route::post('/inquiries/{inquiry}/respond', [App\Http\Controllers\PemilikKos\InquiryController::class, 'respond'])->name('inquiries.respond');

    Route::get('/transactions', [App\Http\Controllers\PemilikKos\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [App\Http\Controllers\PemilikKos\TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/approve', [App\Http\Controllers\PemilikKos\TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [App\Http\Controllers\PemilikKos\TransactionController::class, 'reject'])->name('transactions.reject');
    
    Route::get('/tenants', [App\Http\Controllers\PemilikKos\TenantController::class, 'index'])->name('tenants.index');
    Route::get('/listings/{listing}/premium-payment', [App\Http\Controllers\PemilikKos\ListingController::class, 'premiumPayment'])->name('listings.premium-payment');
    Route::post('/listings/{listing}/request-premium', [App\Http\Controllers\PemilikKos\ListingController::class, 'requestPremium'])->name('listings.request-premium');
    Route::post('/listings/{listing}/submit-premium', [App\Http\Controllers\PemilikKos\ListingController::class, 'submitPremium'])->name('listings.submit-premium');
    Route::delete('/listings-image/{image}', [App\Http\Controllers\PemilikKos\ListingController::class, 'deleteGalleryImage'])->name('listings.delete-image');
});

// Pencari Kos routes
Route::middleware(['auth', 'verified', 'role:pencari-kos'])->prefix('pencari-kos')->name('pencari-kos.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PencariKos\DashboardController::class, 'index'])->name('dashboard');

    // Discovery
    Route::get('/discovery', [App\Http\Controllers\PencariKos\DiscoveryController::class, 'index'])->name('discovery.index');
    Route::get('/discovery/{listing}', [App\Http\Controllers\PencariKos\DiscoveryController::class, 'show'])->name('discovery.show');

    // Favorites
    Route::get('/favorites', [App\Http\Controllers\PencariKos\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{listing}/toggle', [App\Http\Controllers\PencariKos\FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Booking & Payments
    Route::get('/booking/{listing}', [App\Http\Controllers\PencariKos\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking/{listing}', [App\Http\Controllers\PencariKos\BookingController::class, 'store'])->name('bookings.store');

    Route::get('/payments/{transaction}', [App\Http\Controllers\PencariKos\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{transaction}/upload', [App\Http\Controllers\PencariKos\PaymentController::class, 'upload'])->name('payments.upload');

    // History & Reviews
    Route::get('/history', [App\Http\Controllers\PencariKos\MyBookingController::class, 'index'])->name('history.index');
    Route::get('/history/{transaction}', [App\Http\Controllers\PencariKos\MyBookingController::class, 'show'])->name('history.show');
    Route::post('/history/{transaction}/review', [App\Http\Controllers\PencariKos\ReviewController::class, 'store'])->name('reviews.store');

    // Inquiries / Chat
    Route::get('/inquiries', [App\Http\Controllers\PencariKos\InquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/inquiries/{listing}', [App\Http\Controllers\PencariKos\InquiryController::class, 'store'])->name('inquiries.store');
    Route::post('/inquiries/{listing}/respond', [App\Http\Controllers\PencariKos\InquiryController::class, 'respond'])->name('inquiries.respond');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Global notification routes (all roles)
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::patch('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

require __DIR__ . '/auth.php';
