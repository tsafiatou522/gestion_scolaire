@extends('layouts.app')
@section('title', 'Suivi des Cotisations APE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">💰 Caisse & Cotisations APE</h4>
        <small class="text-muted">Année Scolaire en cours : <strong>{{ $anneeScolaire }}</strong></small>
    </div>
    <a href="{{ route('ape.cotisations.create') }}" class="btn btn-success rounded-pill btn-sm px-3">
        <i class="bi bi-plus-circle-fill me-1"></i> Enregistrer une cotisation
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card success h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted small uppercase mb-1">Total Encaissé APE</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($totalCollecte, 0, ',', ' ') }} FCFA</h3>
                </div>
                <i class="bi bi-piggy-bank fs-1"></i>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <form method="GET" action="{{ route('ape.cotisations.index') }}" class="row g-2 w-100 align-items-center">
                    <input type="hidden" name="annee_scolaire" value="{{ $anneeScolaire }}">
                    
                    <div class="col-sm-5">
                        <label for="annee_scolaire_select" class="form-label small mb-1 text-muted fw-bold">Filtrer par année</label>
                        <select id="annee_scolaire_select" name="annee_scolaire" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="2025-2026" {{ $anneeScolaire == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                            <option value="2026-2027" {{ $anneeScolaire == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                        </select>
                    </div>

                    <div class="col-sm-7">
                        <label for="eleve_id" class="form-label small mb-1 text-muted fw-bold">Filtrer par élève</label>
                        <select id="eleve_id" name="eleve_id" class="form-select form-select-sm text-uppercase" onchange="this.form.submit()">
                            <option value="">Tous les élèves</option>
                            @foreach($eleves as $el)
                                <option value="{{ $el->id }}" {{ $eleveId == $el->id ? 'selected' : '' }}>
                                    {{ $el->nom_complet }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead>
                    <tr class="text-muted small uppercase">
                        <th class="ps-4">Élève</th>
                        <th>Classe</th>
                        <th>Montant Versé</th>
                        <th>Date de paiement</th>
                        <th>Observation</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cotisations as $cotisation)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark text-uppercase">
                                <i class="bi bi-person text-muted me-1"></i>
                                {{ $cotisation->eleve->nom_complet ?? 'Inconnu' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $cotisation->eleve->classe->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <i class="bi bi-calendar-event text-muted me-1"></i> 
                            {{ $cotisation->date_paiement ? $cotisation->date_paiement->format('d/m/Y') : '-' }}
                        </td>
                        <td><small class="text-muted">{{ $cotisation->observation ?? '-' }}</small></td>
                        <td class="text-end pe-4">
                            <a href="{{ route('ape.cotisations.recu', $cotisation->id) }}" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 12px;" title="Télécharger le reçu">
                                <i class="bi bi-download"></i> Reçu
                            </a>
                            <form action="{{ route('ape.cotisations.destroy', $cotisation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Annuler et supprimer ce versement ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2">
                                    <i class="bi bi-trash3 fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Aucune cotisation enregistrée pour ces critères.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $cotisations->appends(request()->query())->links() }}
</div>
@endsection
