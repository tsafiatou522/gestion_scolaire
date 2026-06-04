@extends('layouts.app')
@section('title', 'Enregistrer une cotisation')

@section('content')
<div class="mb-4">
    <a href="{{ route('ape.cotisations.index') }}" class="btn btn-sm btn-link text-muted p-0 text-decoration-none">
        <i class="bi bi-arrow-left"></i> Retour au suivi
    </a>
    <h4 class="fw-bold mb-0 mt-2">💰 Enregistrer un versement APE</h4>
</div>

<div class="card" style="max-width: 650px;">
    <div class="card-body p-4">
        <form action="{{ route('ape.cotisations.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold">Élève concerné <span class="text-danger">*</span></label>
                    <select name="eleve_id" class="form-select form-select-sm text-uppercase @error('eleve_id') is-invalid @enderror" required>
                        <option value="">-- Sélectionner l'élève --</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->id }}" {{ (old('eleve_id') == $eleve->id || $eleveId == $eleve->id) ? 'selected' : '' }}>
                                {{ $eleve->nom_complet }} — Classe : {{ $eleve->classe->nom ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('eleve_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Montant (FCFA) <span class="text-danger">*</span></label>
                    <input type="number" name="montant" min="1" class="form-control form-control-sm fw-bold text-success @error('montant') is-invalid @enderror" value="{{ old('montant') }}" required>
                    @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                    <input type="text" name="annee_scolaire" class="form-control form-control-sm @error('annee_scolaire') is-invalid @enderror" value="{{ old('annee_scolaire', '2025-2026') }}" required>
                    @error('annee_scolaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Date de paiement <span class="text-danger">*</span></label>
                    <input type="date" name="date_paiement" class="form-control form-control-sm @error('date_paiement') is-invalid @enderror" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                    @error('date_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Observation / Commentaire</label>
                    <textarea name="observation" rows="3" class="form-control form-control-sm @error('observation') is-invalid @enderror" placeholder="Ex: Payé en espèces, reçu par le trésorier...">{{ old('observation') }}</textarea>
                    @error('observation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 pt-2 border-top text-end">
                <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill">
                    <i class="bi bi-printer me-1"></i> Valider & Générer le reçu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
