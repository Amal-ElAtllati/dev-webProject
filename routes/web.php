<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AdminResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Guest registration (invité)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| Resources (lecture pour tout le monde)
|--------------------------------------------------------------------------
*/

Route::get('/resources/{resource}', [ResourceController::class, 'show'])
    ->name('resources.show');

Route::middleware('auth')->group(function () {
    Route::get('/all-resources', [ResourceController::class, 'index'])
        ->name('resources.index');
    
    // Routes pour créer/modifier resources
    Route::get('/resources/create', [ResourceController::class, 'create'])
        ->middleware('role:admin,responsable')
        ->name('resources.create');
    
    Route::post('/resources', [ResourceController::class, 'store'])
        ->middleware('role:admin,responsable')
        ->name('resources.store');

    Route::get('/resources/{id}/edit', [ResourceController::class, 'edit'])
        ->middleware('role:admin,responsable')
        ->name('resources.edit');
    
    Route::put('/resources/{id}', [ResourceController::class, 'update'])
        ->middleware('role:admin,responsable')
        ->name('resources.update');
    
    Route::post('/resources/{id}/change-etat', [ResourceController::class, 'changeEtat'])
        ->middleware('role:admin,responsable')
        ->name('resources.change-etat');
    
    Route::delete('/resources/{id}', [ResourceController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('resources.destroy');

    // Comments
    Route::post('/resources/{resource}/comments', [ResourceController::class, 'storeComment'])
        ->name('comments.store');
    Route::delete('/comments/{id}', [ResourceController::class, 'destroyComment'])
        ->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (selon le rôle)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('dashboard.admin'),
        'responsable' => redirect()->route('dashboard.responsable'),
        default => redirect()->route('dashboard.user'),
    };
})->middleware(['auth', 'check.approved'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboards par Rôle
|--------------------------------------------------------------------------
*/

// User Dashboard
Route::middleware(['auth', 'check.approved', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard.user');
});

// Responsable Dashboard
Route::middleware(['auth', 'check.approved', 'role:responsable'])->group(function () {
    Route::get('/responsable/dashboard', function () {
        return view('responsable.dashboard');
    })->name('dashboard.responsable');
});

// Admin Dashboard
Route::middleware(['auth', 'check.approved', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        // Users Management
        Route::get('/users', [UserController::class, 'index'])
            ->name('admin.users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('admin.users.update');
        Route::patch('/users/{user}', [UserController::class, 'update'])
            ->name('admin.users.patch');

        // Pending Users (Invités)
        Route::get('/pending-users', [UserController::class, 'pendingUsers'])
            ->name('admin.pending.users');
        Route::post('/users/{user}/approve', [UserController::class, 'approveUser'])
            ->name('admin.users.approve');
        Route::post('/users/{user}/reject', [UserController::class, 'rejectUser'])
            ->name('admin.users.reject');

        // Resources Management
        Route::get('/resources', [AdminResourceController::class, 'index'])
            ->name('admin.resources.index');
        Route::get('/resources/create', [AdminResourceController::class, 'create'])
            ->name('admin.resources.create');
        Route::post('/resources', [AdminResourceController::class, 'store'])
            ->name('admin.resources.store');
        Route::post('/resources/{id}/toggle-status', [AdminResourceController::class, 'toggleStatus'])
            ->name('admin.resources.toggle');
    });

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Reservations Routes (comptes approuvés seulement)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved'])->group(function () {
    
    // User Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])
        ->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])
        ->name('reservations.destroy');
    Route::post('/reservations/quick/{resourceId}', [ReservationController::class, 'quickReserve'])
        ->name('reservations.quick');

    // Admin/Responsable Reservations
    Route::get('/reservations/admin', [ReservationController::class, 'adminIndex'])
        ->name('reservations.admin');
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])
        ->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])
        ->name('reservations.reject');
});

/*
|--------------------------------------------------------------------------
| Notifications Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unread-count');
});

/*
|--------------------------------------------------------------------------
| Statistics Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index'])
        ->name('statistics.index');
});

/*
|--------------------------------------------------------------------------
| Incidents Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.approved'])->group(function () {
    
    // User Incidents
    Route::get('/incidents', [IncidentController::class, 'index'])
        ->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])
        ->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])
        ->name('incidents.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])
        ->name('incidents.show');

    // Admin/Responsable Incidents
    Route::get('/incidents-admin', [IncidentController::class, 'adminIndex'])
        ->name('incidents.admin');
    Route::post('/incidents/{id}/respond', [IncidentController::class, 'respond'])
        ->name('incidents.respond');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';