@extends('layouts.app')
@section('title', 'Assemblée Générale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Assemblée Générale</h4>
    <a href="{{ route('assemblee.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Ajouter un membre
    </a>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>Nom & Prénom</th>
                <th>Rôle</th>
                <th>Catégorie</th>
                <th>Téléphone</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($membres as $membre)
            <tr>
                <td class="fw-semibold">{{ $membre->nom }} {{ $membre->prenom }}</td>
                <td><span class="badge bg-primary">{{ $membre->role }}</span></td>
                <td>{{ $membre->categorie }}</td>
                <td>{{ $membre->telephone ?? '-' }}</td>
                <td class="text-center">
                    <a href="{{ route('assemblee.edit', $membre) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('assemblee.destroy', $membre) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Aucun membre.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
