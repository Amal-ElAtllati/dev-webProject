<?php
use App\Http\Controllers\ReservationController;

// CRUD standard
Route::resource('reservations', ReservationController::class);

// Route pour changer le statut (admin/responsable)
Route::post('reservations/{id}/status', [ReservationController::class, 'updateStatus'])
     ->name('reservations.updateStatus');
?>