<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
