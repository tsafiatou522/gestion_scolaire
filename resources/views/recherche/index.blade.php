@extends('layouts.app')
@section('title', 'Recherche')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-search me-2"></i>
        Résultats pour "{{ $query }}"
    </h4>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

{{-- Barre de recherche --}}
<div class="card p-3 mb-4">
    <form method="GET" action="{{ route('recherche.index') }}" class="row g-2 align-items-end">
        <div class="col-md-8">
            <input type="text" name="q" class="form-control"
                   value="{{ $query }}"
                   placeholder="Rechercher un élève par nom, prénom ou parent..."
                   autofocus>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i> Rechercher
            </button>
        </div>
    </form>
</div>

@if($query && strlen($query) >= 2)

    {{-- Résultats élèves --}}
    <div class="card p-3 mb-3">
        <h6 class="fw-bold mb-3">
            <i class="bi bi-people me-2 text-primary"></i>
            Élèves trouvés ({{ $eleves->count() }})
        </h6>
        @if($eleves->count() === 0)
            <p class="text-muted small mb-0">Aucun élève trouvé.</p>
        @else
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px"></th>
                        <th>Nom & Prénom</th>
                        <th>Classe</th>
                        <th>Parent</th>
                        <th>Téléphone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                    <tr>
                        <td>
                            @if($eleve->photo)
                                <img src="{{ asset('storage/'.$eleve->photo) }}"
                                     class="rounded-circle"
                                     style="width:36px;height:36px;object-fit:cover">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                                     style="width:36px;height:36px;font-size:13px">
                                    {{ strtoupper(substr($eleve->prenom,0,1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $eleve->nom_complet }}</td>
                        <td><span class="badge bg-primary">{{ $eleve->classe->nom }}</span></td>
                        <td class="text-muted small">{{ $eleve->nom_parent ?? '—' }}</td>
                        <td class="text-muted small">{{ $eleve->telephone_parent ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('eleves.show', $eleve) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Résultats paiements --}}
    <div class="card p-3">
        <h6 class="fw-bold mb-3">
            <i class="bi bi-cash-coin me-2 text-success"></i>
            Paiements associés ({{ $paiements->count() }})
        </h6>
        @if($paiements->count() === 0)
            <p class="text-muted small mb-0">Aucun paiement trouvé.</p>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Reçu</th>
                        <th>Élève</th>
                        <th>Date</th>
                        <th class="text-end">Montant</th>
                        <th class="text-center">Reçu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                    <tr>
                        <td class="text-muted small">
                            #{{ str_pad($paiement->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="fw-semibold">{{ $paiement->eleve->nom_complet }}</td>
                        <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                        <td class="text-end text-success fw-semibold">
                            {{ number_format($paiement->montant_verse, 0, ',', ' ') }} F
                        </td>
                        <td class="text-center">
                            @if($paiement->recu_pdf)
                                <a href="{{ route('paiements.recu', $paiement) }}"
                                   class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@elseif($query)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Veuillez saisir au moins 2 caractères.
    </div>
@endif
@endsection