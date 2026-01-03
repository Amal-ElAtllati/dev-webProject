<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::where('user_id', Auth::id())->with('resource')->get();
        return view('reservation.index', compact('reservations'));
    }

    public function create() {
        $resources = Resource::all();
        return view('reservation.create', compact('resources'));
    }

    public function store(Request $request) {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'date_debut' => 'required|date|after:now', 
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $exists = Reservation::where('resource_id', $request->resource_id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->where(function ($query) use ($request) { 
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin]);
            })->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Had l-matériel m-hjouz f had l-weqt!']);
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,    
            'date_debut' => $request->date_debut,      
            'date_fin' => $request->date_fin,
            'justification' => $request->justification,
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Réservation envoyée!');
    }

    public function approve($id) {
        $res = Reservation::findOrFail($id);
        $res->update(['status' => 'approved']);        
        return back()->with('success', 'Demande Approuvée!');
    }

    public function reject(Request $request, $id) {    
        $res = Reservation::findOrFail($id);
        $res->update([
            'status' => 'refused',
            'justification' => $request->justification_admin
        ]);
        return back()->with('success', 'Demande Refusée!');
    }
}