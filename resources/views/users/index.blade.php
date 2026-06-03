@extends('layouts.app')
@section('title', 'Utilisateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Gestion des utilisateurs</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nouvel utilisateur
    </a>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="fw-semibold">{{ $user->name }}</td>
                <td class="text-muted">{{ $user->email }}</td>
                <td>
                    @if($user->role === 'directeur')
                        <span class="badge bg-danger">Directeur</span>
                    @elseif($user->role === 'enseignant')
                        <span class="badge bg-primary">Enseignant</span>
                    @else
                        <span class="badge bg-success">Gestionnaire</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer cet utilisateur ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">Aucun utilisateur trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection