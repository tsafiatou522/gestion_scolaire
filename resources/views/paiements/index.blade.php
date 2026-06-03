@extends('layouts.app')
@section('title', 'Paiements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Paiements</h4>
    <a href="{{ route('paiements.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nouveau paiement
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('paiements.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Filtrer par élève</label>
            <select name="eleve_id" class="form-select form-select-sm">
                <option value="">Tous les élèves</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}" {{ $eleveId == $eleve->id ? 'selected' : '' }}>
                        {{ $eleve->nom_complet }} ({{ $eleve->classe->nom }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Filtrer</button>
        </div>
        @if($eleveId)
        <div class="col-md-2">
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary btn-sm w-100">Réinitialiser</a>
        </div>
        @endif
    </form>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>N° Reçu</th>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th class="text-end">Montant versé</th>
                <th class="text-center">Reçu PDF</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paiements as $paiement)
            <tr>
                <td class="text-muted small">#{{ str_pad($paiement->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <a href="{{ route('eleves.show', $paiement->eleve) }}" class="fw-semibold text-decoration-none">
                        {{ $paiement->eleve->nom_complet }}
                    </a>
                </td>
                <td><span class="badge bg-primary">{{ $paiement->eleve->classe->nom }}</span></td>
                <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                <td class="text-end fw-semibold text-success">
                    {{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA
                </td>
                <td class="text-center">
                    @if($paiement->recu_pdf)
                        <a href="{{ route('paiements.recu', $paiement) }}" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-pdf me-1"></i> Télécharger
                        </a>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer ce paiement ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Aucun paiement enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($paiements->hasPages())
    <div class="p-3">{{ $paiements->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection