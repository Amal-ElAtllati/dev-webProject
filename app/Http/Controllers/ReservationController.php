<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Bach t'shof l'historique (index.blade.php)
public function index()
{
    // 1. Kan'jibo les réservations dyal l'user li m'connecter
    $reservations = Reservation::where('user_id', Auth::id())->with('resource')->get();

    // 2. Darori n'sifto 'reservations' machi 'resources'
    return view('reservation.index', compact('reservations'));
}
    // Bach t'shof l'formulaire (create.blade.php)
    public function create()
    {
        // Kan'jibo ghi l'matériel li khdam (disponible) bach user y'khtar menno
        $resources = Resource::where('etat', 'disponible')->get();
        return view('reservations.create', compact('resources'));
    }

    // Bach t'sajel l'reservation f Base de données
    public function store(Request $request)
    {
        // 1. Validation: t'akked ana l'ma3loumat s-hiha
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        // 2. Enregistrement f table 'reservations'
        Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'En attente', // Kifma mktouba f index.blade.php
        ]);

        // 3. Revenir l'page dyal l'historique b message d'najah
        return redirect()->route('reservations.index')->with('success', 'Votre réservation a été envoyée !');
    }
}