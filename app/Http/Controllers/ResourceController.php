<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment; 


class ResourceController extends Controller
{
    /**
     * Display all resources
     */
    public function index()
    {
        $user = Auth::user();
        
        // Regular users see only available resources
        if ($user->role === 'user') {
            $resources = Resource::with(['category', 'responsable'])
                ->where('etat', 'disponible')
                ->get();
        } else {
            // Admin and responsable see all resources
            $resources = Resource::with(['category', 'responsable'])->get();
        }
        
        return view('resources.index', compact('resources'));
    }

    /**
     * Show resource details
     */
    public function show($id)
{
    // Kan-jibo r-ressource b l-comments dyalha
    $resource = Resource::with('comments.user')->findOrFail($id);
    
    // Kan-yiftoha l-vwa show (machi welcome)
    return view('resources.show', compact('resource'));
}
    /**
     * Show form to create new resource
     */
    public function create()
    {
        // Check permission
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'responsable') {
            abort(403, 'Accès non autorisé');
        }
        
        $categories = ResourceCategory::all();
        $responsables = User::where('role', 'responsable')->get();
        
        return view('resources.create', compact('categories', 'responsables'));
    }

    /**
     * Store new resource
     */
    public function store(Request $request)
    {
        // Check permission
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'responsable') {
            abort(403, 'Accès non autorisé');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cpu' => 'nullable|integer|min:1',
            'ram' => 'nullable|integer|min:1',
            'capacite' => 'nullable|integer|min:1',
            'os' => 'nullable|string|max:100',
            'categorie_id' => 'required|exists:resource_categories,id',
            'responsable_id' => 'required|exists:users,id',
            'etat' => 'nullable|in:disponible,maintenance,desactive',
        ], [
            'nom.required' => 'Le nom de la ressource est obligatoire.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'responsable_id.required' => 'Le responsable est obligatoire.',
        ]);
        
        // Set default state
        $validated['etat'] = $validated['etat'] ?? 'disponible';
        
        // If user is responsable, auto-assign to them
        if (Auth::user()->role === 'responsable') {
            $validated['responsable_id'] = Auth::id();
        }
        
        $resource = Resource::create($validated);
        
        // Send notification to assigned responsable
        if ($validated['responsable_id'] != Auth::id()) {
            Notification::create([
                'user_id' => $validated['responsable_id'],
                'message' => "📦 Une nouvelle ressource '{$resource->nom}' vous a été assignée.",
                'lu' => false,
            ]);
        }
        
        return redirect()->route('resources.index')
            ->with('success', '✅ Ressource ajoutée avec succès!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        
        // Check permission
        $user = Auth::user();
        if ($user->role !== 'admin' && $resource->responsable_id !== $user->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres ressources.');
        }
        
        $categories = ResourceCategory::all();
        $responsables = User::where('role', 'responsable')->get();
        
        return view('resources.edit', compact('resource', 'categories', 'responsables'));
    }

    /**
     * Update resource
     */
    public function update(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);
        
        // Check permission
        $user = Auth::user();
        if ($user->role !== 'admin' && $resource->responsable_id !== $user->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres ressources.');
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cpu' => 'nullable|integer|min:1',
            'ram' => 'nullable|integer|min:1',
            'capacite' => 'nullable|integer|min:1',
            'os' => 'nullable|string|max:100',
            'categorie_id' => 'required|exists:resource_categories,id',
            'responsable_id' => 'required|exists:users,id',
        ]);
        
        $resource->update($validated);
        
        return redirect()->route('resources.index')
            ->with('success', '✅ Ressource modifiée avec succès!');
    }

    /**
     * Change resource state (maintenance, disponible, desactive)
     */
    public function changeEtat(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);
        
        // Check permission
        $user = Auth::user();
        if ($user->role !== 'admin' && $resource->responsable_id !== $user->id) {
            abort(403, 'Vous ne pouvez gérer que vos propres ressources.');
        }
        
        $validated = $request->validate([
            'etat' => 'required|in:disponible,maintenance,desactive',
            'raison' => 'nullable|string|max:500',
        ]);
        
        $oldEtat = $resource->etat;
        $resource->update(['etat' => $validated['etat']]);
        
        // Get emoji for state
        $emoji = [
            'disponible' => '✅',
            'maintenance' => '🔧',
            'desactive' => '❌',
        ];
        
        // Notify users with active reservations
        $activeReservations = \App\Models\Reservation::where('resource_id', $resource->id)
            ->where('statut', 'approuve')
            ->get();
        
        foreach ($activeReservations as $reservation) {
            $message = "{$emoji[$validated['etat']]} La ressource '{$resource->nom}' est maintenant: " . ucfirst($validated['etat']);
            
            if (!empty($validated['raison'])) {
                $message .= "\n\nRaison: {$validated['raison']}";
            }
            
            Notification::create([
                'user_id' => $reservation->user_id,
                'message' => $message,
                'lu' => false,
            ]);
        }
        
        $messages = [
            'disponible' => '✅ Ressource activée et disponible!',
            'maintenance' => '🔧 Ressource mise en maintenance.',
            'desactive' => '❌ Ressource désactivée.',
        ];
        
        return redirect()->route('resources.index')
            ->with('success', $messages[$validated['etat']]);
    }

    /**
     * Delete resource (soft delete or hard delete)
     */
    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);
        
        // Check permission (only admin can delete)
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Seul un administrateur peut supprimer une ressource.');
        }
        
        // Check if resource has active reservations
        $activeReservations = \App\Models\Reservation::where('resource_id', $resource->id)
            ->whereIn('statut', ['en_attente', 'approuve'])
            ->count();
        
        if ($activeReservations > 0) {
            return redirect()->route('resources.index')
                ->with('error', '❌ Impossible de supprimer: cette ressource a des réservations actives.');
        }
        
        $resource->delete();
        
        return redirect()->route('resources.index')
            ->with('success', '🗑️ Ressource supprimée avec succès.');
    }



    public function storeComment(Request $request, $resourceId) {
    $request->validate(['content' => 'required']);
    
    Comment::create([
        'user_id' => auth()->id(),
        'resource_id' => $resourceId,
        'content' => $request->content
    ]);
    
    return back()->with('success', 'Message envoyé!');
    }

    public function destroyComment($id) {
    $comment = Comment::findOrFail($id);
    // Modération: seul le responsable ou l'admin
    $comment->delete();
    return back()->with('success', 'Message modéré.');
    }

    
}
