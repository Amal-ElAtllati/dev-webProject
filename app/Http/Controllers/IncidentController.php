<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    // Liste des incidents de l'utilisateur
    public function index()
    {
        $incidents = auth()->user()->incidents()
            ->with(['resource', 'reservation'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    // Formulaire de signalement
    public function create()
    {
        // Récupérer les ressources que l'utilisateur a réservées
        $resources = Resource::whereHas('reservations', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        // Si l'utilisateur n'a pas de réservations, afficher toutes les ressources
        if ($resources->isEmpty()) {
            $resources = Resource::all();
        }

        return view('incidents.create', compact('resources'));
    }

    // Enregistrer le signalement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'type' => 'required|in:panne,dysfonctionnement,dommage,autre',
            'priorite' => 'required|in:basse,moyenne,haute,urgente',
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'fichiers.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB max
        ]);

        $fichiers = [];
        if ($request->hasFile('fichiers')) {
            foreach ($request->file('fichiers') as $fichier) {
                $path = $fichier->store('incidents', 'public');
                $fichiers[] = $path;
            }
        }

        $incident = Incident::create([
            'user_id' => auth()->id(),
            'resource_id' => $validated['resource_id'],
            'reservation_id' => $validated['reservation_id'] ?? null,
            'type' => $validated['type'],
            'priorite' => $validated['priorite'],
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'fichiers' => $fichiers,
            'statut' => 'ouvert',
            'date_signalement' => now()
        ]);

        return redirect()->route('incidents.index')
            ->with('success', 'Incident signalé avec succès');
    }

    // Détails d'un incident
    public function show(Incident $incident)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($incident->user_id !== auth()->id()) {
            abort(403);
        }

        return view('incidents.show', compact('incident'));
    }
    /////////////////////////////////////
    // Pour afficher TOUS les incidents au Responsable
    public function adminIndex()
    {
        if (!in_array(auth()->user()->role, ['admin', 'responsable'])) {
            abort(403);
        }

        $incidents = Incident::with(['user', 'resource'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Incident::count(),
            'ouvert' => Incident::where('statut', 'ouvert')->count(),
            'en_cours' => Incident::where('statut', 'en_cours')->count(),
            'resolu' => Incident::where('statut', 'resolu')->count(),
        ];

        return view('incidents.admin-index', compact('incidents', 'stats'));
    }

    // Pour répondre et gérer l'incident
    public function respond(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'responsable'])) {
            abort(403);
        }

        $request->validate([
            'statut' => 'required|in:ouvert,en_cours,resolu,ferme',
            'reponse_admin' => 'nullable|string|max:1000'
        ]);

        $incident = Incident::findOrFail($id);
        $incident->statut = $request->statut;
    
        if ($request->reponse_admin) {
            $incident->reponse_admin = $request->reponse_admin;
        }
    
        if (in_array($request->statut, ['resolu', 'ferme'])) {
            $incident->date_resolution = now();
        }
    
        $incident->save();

        return redirect()->back()->with('success', 'Incident mis à jour ✅');
    }
}