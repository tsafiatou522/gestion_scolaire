@extends('layouts.app')
@section('title', 'Nouveau paiement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Enregistrer un paiement</h4>
    <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:580px">
    <form method="POST" action="{{ route('paiements.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Élève <span class="text-danger">*</span></label>
            <select name="eleve_id" class="form-select @error('eleve_id') is-invalid @enderror" required>
                <option value="">-- Choisir un élève --</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}"
                        {{ (old('eleve_id', $eleveId) == $eleve->id) ? 'selected' : '' }}>
                        {{ $eleve->nom_complet }} — {{ $eleve->classe->nom }}
                    </option>
                @endforeach
            </select>
            @error('eleve_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Montant versé (FCFA) <span class="text-danger">*</span></label>
            <input type="number" name="montant_verse"
                   class="form-control @error('montant_verse') is-invalid @enderror"
                   value="{{ old('montant_verse') }}" min="1" step="500" required>
            @error('montant_verse')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Date du paiement <span class="text-danger">*</span></label>
            <input type="date" name="date_paiement"
                   class="form-control @error('date_paiement') is-invalid @enderror"
                   value="{{ old('date_paiement', date('Y-m-d')) }}" required>
            @error('date_paiement')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Observation</label>
            <input type="text" name="observation" class="form-control"
                   value="{{ old('observation') }}"
                   placeholder="Ex : 1er versement, solde final...">
        </div>

        <div class="alert alert-info small py-2">
            <i class="bi bi-info-circle me-1"></i>
            Un reçu PDF sera automatiquement généré après l'enregistrement.
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-cash-coin me-1"></i> Enregistrer
            </button>
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection