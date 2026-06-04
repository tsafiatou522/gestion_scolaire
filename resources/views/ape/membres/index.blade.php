@extends('layouts.app')
@section('title', 'Membres APE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-people-fill me-2 text-primary"></i>
        Association des Parents d'Élèves (APE)
    </h4>
    @if(auth()->user()->isDirecteur())
    <a href="{{ route('ape.membres.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Ajouter un membre
    </a>
    @endif
</div>

{{-- Filtre année scolaire --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('ape.membres.index') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Année scolaire</label>
            <input type="text" name="annee_scolaire" class="form-control form-control-sm"
                   value="{{ $anneeScolaire }}" placeholder="2025-2026">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Filtrer</button>
        </div>
    </form>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nom & Prénom</th>
                    <th>Fonction</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Élève lié</th>
                    @if(auth()->user()->isDirecteur())<th class="text-center pe-4">Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($membres as $membre)
                <tr>
                    {{-- Utilisation sécurisée de l'Accessor nom_complet --}}
                    <td class="ps-4 fw-semibold text-uppercase">
                        {{ $membre->nom_complet ?? ($membre->nom . ' ' . $membre->prenom) }}
                    </td>
                    <td>
                        @php
                            $colors = [
                                'president'      => 'danger',
                                'vice_president' => 'warning',
                                'secretaire'     => 'info',
                                'tresorier'      => 'success',
                                'membre'         => 'secondary',
                            ];
                        @endphp
                        {{-- Fallback si fonction_label n'est pas encore écrit dans le modèle --}}
                        <span class="badge bg-{{ $colors[$membre->fonction] ?? 'secondary' }}">
                            {{ $membre->fonction_label ?? ucfirst(str_replace('_', ' ', $membre->fonction)) }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $membre->telephone ?? '—' }}</td>
                    <td class="text-muted small">{{ $membre->email ?? '—' }}</td>
                    <td>
                        @if($membre->eleve)
                            <span class="badge bg-primary">
                                {{ $membre->eleve->nom }} {{ $membre->eleve->prenom }}
                                @if($membre->eleve->classe)
                                    <small class="text-white-50">({{ $membre->eleve->classe->nom }})</small>
                                @endif
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    @if(auth()->user()->isDirecteur())
                    <td class="text-center pe-4">
                        <a href="{{ route('ape.membres.edit', $membre) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('ape.membres.destroy', $membre) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer ce membre ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucun membre APE enregistré pour l'année {{ $anneeScolaire }}.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('ape.cotisations.index') }}" class="btn btn-success btn-sm">
        <i class="bi bi-cash-coin me-1"></i> Voir les cotisations APE
    </a>
</div>
@endsection