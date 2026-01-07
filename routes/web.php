<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});


// Resources routes
use App\Http\Controllers\ResourceController;
Route::middleware(['auth'])->group(function () {
    Route::get('/all-resources', [ResourceController::class, 'index'])->name('resources.index');
});
// Utilisateur interne
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard.user');
});

// Responsable technique
Route::middleware(['auth', 'role:responsable'])->group(function () {
    Route::get('/responsable/dashboard', function () {
        return view('responsable.dashboard');
    })->name('dashboard.responsable');
});

// Administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Gestion des utilisateurs (Admin only)
Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/users', [UserController::class, 'index'])
            ->name('admin.users.index');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('admin.users.update');
    });

require __DIR__.'/auth.php';

// Dashboard redirect route
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('dashboard.admin');
    } elseif (auth()->user()->role === 'responsable') {
        return redirect()->route('dashboard.responsable');
    }
    return redirect()->route('dashboard.user');
})->middleware(['auth'])->name('dashboard');


// Reservation routes
use App\Http\Controllers\ReservationController;
Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reservations/quick/{resourceId}', [ReservationController::class, 'quickReserve'])->name('reservations.quick');
    
    // Admin/Responsable routes
    Route::get('/reservations/admin', [ReservationController::class, 'adminIndex'])->name('reservations.admin');
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
});

// Notifications routes
use App\Http\Controllers\NotificationController;
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
});

// Statistics routes
use App\Http\Controllers\StatisticsController;
Route::middleware(['auth'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});




























































































































































































































































































































































































































