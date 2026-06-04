@extends('layouts.app')
@section('title', 'Matières')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Gestion des matières</h4>
    @if($classeId)
    <a href="{{ route('matieres.create', ['classe_id' => $classeId]) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle matière
    </a>
    @endif
</div>

{{-- Filtre par classe --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('matieres.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Choisir une classe</label>
            <select name="classe_id" class="form-select form-select-sm">
                <option value="">-- Choisir --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Afficher</button>
        </div>
    </form>
</div>

@if(!$classeId)
    <div class="alert alert-info">Veuillez sélectionner une classe pour voir ses matières.</div>
@elseif($classeId)
<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>Matière</th>
                <th class="text-center">Coefficient</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($matieres as $matiere)
            <tr>
                <td class="fw-semibold">{{ $matiere->nom }}</td>
                <td class="text-center">
                    <span class="badge bg-secondary">{{ $matiere->pivot->coefficient ?? '-' }}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('matieres.edit', [$matiere, 'classe_id' => $classeId]) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('matieres.destroy', $matiere) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer cette matière ?')">
                        @csrf @method('DELETE')
                        <input type="hidden" name="classe_id" value="{{ $classeId }}">
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted py-4">
                    Aucune matière pour cette classe.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif
@endsection