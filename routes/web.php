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



use App\Http\Controllers\ReservationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});



// Zidi hadchi f l'akhir d web.php
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('dashboard.admin');
    } elseif (auth()->user()->role === 'responsable') {
        return redirect()->route('dashboard.responsable');
    }
    return redirect()->route('dashboard.user');
})->middleware(['auth'])->name('dashboard');



























































































































































































































































































































































































































