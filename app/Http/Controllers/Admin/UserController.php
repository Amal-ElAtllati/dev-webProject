<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Update role / active
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,responsable,admin',
            'active' => 'required|boolean',
        ]);

        $user->update([
            'role' => $request->role,
            'active' => $request->active,
        ]);

        return back()->with('success', 'Utilisateur mis à jour');
    }
    
    //////////////////////////////////////////////////////////////
    // DEMANDES EN ATTENTE
    //////////////////////////////////////////////////////////////
    
    public function pendingUsers()
    {
        $pendingUsers = User::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pending-users', compact('pendingUsers'));
    }

    // Approuver un utilisateur
    public function approveUser(User $user)
    {
        // Vérifier que le user est bien en pending
        if ($user->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée');
        }
        
        // Mettre à jour le statut
        $user->update([
            'status' => 'approved',
            'active' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
        
        // Créer notification pour l'utilisateur
        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_approved',
            'message' => 'Votre compte a été approuvé! Vous pouvez maintenant vous connecter.',
            'lu' => false,
        ]);
        
        return redirect()->back()->with('success', 'Utilisateur approuvé avec succès!');
    }
    
    // Rejeter un utilisateur
    public function rejectUser(User $user)
    {
        // Vérifier que le user est bien en pending
        if ($user->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée');
        }
        
        // Mettre à jour le statut
        $user->update([
            'status' => 'rejected',
            'active' => false,
        ]);
        
        // Créer notification pour l'utilisateur
        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_rejected',
            'message' => 'Votre demande d\'inscription a été rejetée.',
            'lu' => false,
        ]);
        
        return redirect()->back()->with('success', 'Demande rejetée.');
    }
}