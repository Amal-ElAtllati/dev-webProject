<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // عرض جميع الحجوزات
    public function index()
    {
        $reservations = Reservation::with(['resource', 'user'])
            ->where('user_id', Auth::id())
            ->get();
        return view('reservation.index', compact('reservations'));
    }

    // formulaire création réservation
    public function create()
    {
        $resources = Resource::where('etat', 'disponible')->get();
        return view('reservation.create', compact('resources'));
    }

    // تخزين حجز جديد
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
            'justification' => 'nullable|string|max:500',
        ]);

        Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation créée avec succès');
    }

    // تحديث حالة الحجز (admin/responsable)
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:approuve,refuse',
        ]);

        $reservation->update([
            'statut' => $request->statut === 'approuve' ? 'approuve' : 'refuse',
        ]);

        return redirect()->back()
                         ->with('success', 'Statut de la réservation mis à jour');
    }

    // حذف حجز
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Allow user to delete only their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès interdit');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation supprimée');
    }
}

