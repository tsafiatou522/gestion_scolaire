<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Activity; // 🔹 Import du modèle Activity

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:directeur,enseignant,gestionnaire',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        // 🔹 Journalisation création
        Activity::create([
            'action'  => 'Utilisateur créé',
            'details' => "Nom: {$user->name}, Email: {$user->email}, Rôle: {$user->role}",
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:directeur,enseignant,gestionnaire',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // 🔹 Journalisation modification
        Activity::create([
            'action'  => 'Utilisateur modifié',
            'details' => "Nom: {$user->name}, Email: {$user->email}, Rôle: {$user->role}",
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // 🔹 Journalisation suppression (avant delete)
        Activity::create([
            'action'  => 'Utilisateur supprimé',
            'details' => "Nom: {$user->name}, Email: {$user->email}, Rôle: {$user->role}",
            'user_id' => auth()->id(),
        ]);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
