<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminResourceController extends Controller
{
    /**
     * Display all resources (Admin only).
     */
    public function index()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        // Get all resources with their responsable and category
        $resources = Resource::with(['responsable', 'category'])->orderBy('created_at', 'desc')->get();
        
        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        // Get all responsables and categories for the dropdowns
        $responsables = User::where('role', 'responsable')->where('active', true)->get();
        $categories = ResourceCategory::all();
        
        return view('admin.resources.create', compact('responsables', 'categories'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        // Validate the request
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|integer|min:1',
            'ram' => 'nullable|integer|min:1',
            'capacite' => 'nullable|integer|min:1',
            'os' => 'nullable|string|max:255',
            'emplacement' => 'nullable|string|max:255',
            'responsable_id' => 'required|exists:users,id',
        ]);

        // Create the resource
        Resource::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'categorie_id' => $request->categorie_id,
            'cpu' => $request->cpu,
            'ram' => $request->ram,
            'capacite' => $request->capacite,
            'os' => $request->os,
            'emplacement' => $request->emplacement,
            'etat' => 'disponible', // Default state
            'responsable_id' => $request->responsable_id,
        ]);

        return redirect()->route('admin.resources.index')
                         ->with('success', 'Ressource ajoutée avec succès ✅');
    }

    /**
     * Toggle resource status (disponible/indisponible).
     */
    public function toggleStatus($id)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        $resource = Resource::findOrFail($id);
        
        // Toggle between disponible and indisponible
        if ($resource->etat === 'disponible') {
            $resource->etat = 'indisponible';
            $message = 'Ressource désactivée avec succès 🚫';
        } else {
            $resource->etat = 'disponible';
            $message = 'Ressource activée avec succès ✅';
        }
        
        $resource->save();

        return redirect()->back()->with('success', $message);
    }
}