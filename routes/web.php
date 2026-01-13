<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// 1. RESOURCES ROUTES (M-SAHAH)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Routes STATIQUES lowlin (bach may-trach 404)
    Route::get('/all-resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'create'])
        ->middleware('role:admin,responsable')
        ->name('resources.create');
    
    // HADI HIYA LI KANT NAQSA (resources.store)
    Route::post('/resources', [ResourceController::class, 'store'])
        ->middleware('role:admin,responsable')
        ->name('resources.store');

    // Route dyal SHOW (Dima t-koun teht men create)
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])
        ->name('resources.show');

    // Edit, Update, Delete
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

    Route::post('/resources/{resource}/comments', [ResourceController::class, 'storeComment'])->name('comments.store');
Route::delete('/comments/{id}', [ResourceController::class, 'destroyComment'])->name('comments.destroy');
});

// ==========================================
// 2. DASHBOARDS & REDIRECTIONS
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Dashboard redirect route
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif (auth()->user()->role === 'responsable') {
            return redirect()->route('dashboard.responsable');
        }
        return redirect()->route('dashboard.user');
    })->name('dashboard');

    // Utilisateur interne
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->middleware('role:user')->name('dashboard.user');

    // Responsable technique
    Route::get('/responsable/dashboard', function () {
        return view('responsable.dashboard');
    })->middleware('role:responsable')->name('dashboard.responsable');

    // Administrateur
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('dashboard.admin');
});

// ==========================================
// 3. RESERVATIONS ROUTES
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reservations/quick/{resourceId}', [ReservationController::class, 'quickReserve'])->name('reservations.quick');
    
    Route::get('/reservations/admin', [ReservationController::class, 'adminIndex'])->name('reservations.admin');
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
});

// ==========================================
// 4. USERS, PROFILE, NOTIFS & STATS
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Users Management
    Route::middleware(['active', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');

    // Statistics
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});

require __DIR__.'/auth.php';