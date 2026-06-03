@extends('layouts.app')
@section('title', 'Cotisations APE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-cash-coin me-2 text-success"></i>
        Cotisations APE
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('ape.membres.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-people me-1"></i> Membres APE
        </a>
        <a href="{{ route('ape.cotisations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouvelle cotisation
        </a>
    </div>
</div>

{{-- Statistique --}}
<div class="card stat-card success p-3 mb-3" style="max-width:300px">
    <div class="text-muted small">Total collecté ({{ $anneeScolaire }})</div>
    <div class="fs-3 fw-bold text-success">{{ number_format($totalCollecte, 0, ',', ' ') }} FCFA</div>
</div>

{{-- Filtres --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('ape.cotisations.index') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Année scolaire</label>
            <input type="text" name="annee_scolaire" class="form-control form-control-sm"
                   value="{{ $anneeScolaire }}">
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Filtrer par élève</label>
            <select name="eleve_id" class="form-select form-select-sm">
                <option value="">Tous les élèves</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}" {{ $eleveId == $eleve->id ? 'selected' : '' }}>
                        {{ $eleve->nom_complet }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Filtrer</button>
        </div>
    </form>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>N°</th>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th class="text-end">Montant</th>
                <th>Observation</th>
                <th class="text-center">Reçu</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cotisations as $cotisation)
            <tr>
                <td class="text-muted small">#{{ str_pad($cotisation->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="fw-semibold">{{ $cotisation->eleve->nom_complet }}</td>
                <td><span class="badge bg-primary">{{ $cotisation->eleve->classe->nom }}</span></td>
                <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
                <td class="text-end text-success fw-semibold">
                    {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA
                </td>
                <td class="text-muted small">{{ $cotisation->observation ?? '—' }}</td>
                <td class="text-center">
                    @if($cotisation->recu_pdf)
                        <a href="{{ route('ape.cotisations.recu', $cotisation) }}"
                           class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-pdf"></i>
                        </a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td class="text-center">
                    <form action="{{ route('ape.cotisations.destroy', $cotisation) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer cette cotisation ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    Aucune cotisation enregistrée.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($cotisations->hasPages())
    <div class="p-3">{{ $cotisations->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection