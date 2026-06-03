@extends('layouts.app')
@section('title', 'Classes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Classes</h4>
    <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle classe
    </a>
</div>

<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Classe</th>
                <th>Niveau</th>
                <th>Année scolaire</th>
                <th class="text-center">Nb élèves</th>
                <th class="text-end">Frais (FCFA)</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $classe)
            <tr>
                <td class="fw-semibold">{{ $classe->nom }}</td>
                <td><span class="badge bg-primary">{{ $classe->niveau }}</span></td>
                <td>{{ $classe->annee_scolaire }}</td>
                <td class="text-center">{{ $classe->eleves_count }}</td>
                <td class="text-end">{{ number_format($classe->fraisScolarite->montant ?? 0, 0, ',', ' ') }}</td>
                <td class="text-center">
                    <a href="{{ route('classes.edit', $classe) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('classes.destroy', $classe) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer cette classe ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Aucune classe enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection