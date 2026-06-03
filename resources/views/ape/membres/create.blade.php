@extends('layouts.app')
@section('title', 'Nouveau membre APE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouveau membre APE</h4>
    <a href="{{ route('ape.membres.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:580px">
    <form method="POST" action="{{ route('ape.membres.store') }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                <input type="text" name="nom"
                       class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom') }}" required>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                <input type="text" name="prenom"
                       class="form-control @error('prenom') is-invalid @enderror"
                       value="{{ old('prenom') }}" required>
                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Téléphone</label>
                <input type="text" name="telephone" class="form-control"
                       value="{{ old('telephone') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Fonction <span class="text-danger">*</span></label>
                <select name="fonction" class="form-select @error('fonction') is-invalid @enderror" required>
                    <option value="">-- Choisir --</option>
                    <option value="president"      {{ old('fonction') == 'president'      ? 'selected' : '' }}>Président(e)</option>
                    <option value="vice_president" {{ old('fonction') == 'vice_president' ? 'selected' : '' }}>Vice-Président(e)</option>
                    <option value="secretaire"     {{ old('fonction') == 'secretaire'     ? 'selected' : '' }}>Secrétaire</option>
                    <option value="tresorier"      {{ old('fonction') == 'tresorier'      ? 'selected' : '' }}>Trésorier(ère)</option>
                    <option value="membre"         {{ old('fonction') == 'membre'         ? 'selected' : '' }}>Membre</option>
                </select>
                @error('fonction')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                <input type="text" name="annee_scolaire" class="form-control"
                       value="{{ old('annee_scolaire', '2025-2026') }}" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Élève lié (optionnel)</label>
                <select name="eleve_id" class="form-select">
                    <option value="">-- Aucun --</option>
                    @foreach($eleves as $eleve)
                        <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                            {{ $eleve->nom_complet }} — {{ $eleve->classe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Enregistrer
            </button>
            <a href="{{ route('ape.membres.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection