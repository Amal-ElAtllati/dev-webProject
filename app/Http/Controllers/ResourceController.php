<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    //  Afficher tous les resources 
    public function index()
    {
        $resources = Resource::with(['category', 'responsable'])->get();
        return view('resources.index', compact('resources'));
    }

    // formulaire création réservation
    public function create()
    {
        $categories = ResourceCategory::all();
        $users = User::all();
        return view('resources.create', compact('categories', 'users'));
    }

    //   Stocker neveau resource
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'cpu' => 'required|integer',
            'ram' => 'required|integer',
            'capacite' => 'required|integer',
            'os' => 'required|string',
            'categorie_id' => 'required|exists:resource_categories,id',
            'responsable_id' => 'required|exists:users,id',
        ]);

        Resource::create($request->all());

        return redirect()->route('resources.index')
                         ->with('success', 'Resource ajoutée avec succès');
    }

    // // Formulaire de modification du ressource
    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        $categories = ResourceCategory::all();
        $users = User::all();

        return view('resources.edit', compact('resource', 'categories', 'users'));
    }

    //  Mise à jour de la ressource 
    public function update(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        $request->validate([
            'nom' => 'required|string',
            'cpu' => 'required|integer',
            'ram' => 'required|integer',
            'capacite' => 'required|integer',
            'os' => 'required|string',
            'etat' => 'required|string',
        ]);

        $resource->update($request->all());

        return redirect()->route('resources.index')
                         ->with('success', 'Resource modifiée avec succès');
    }

    // Supprimer recource 
    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();

        return redirect()->route('resources.index')
                         ->with('success', 'Resource supprimée');
    }
}
