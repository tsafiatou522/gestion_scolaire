@extends('layouts.app')
@section('title', 'Ajouter un membre APE')

@section('content')
<div class="mb-4">
    <a href="{{ route('ape.membres.index') }}" class="btn btn-sm btn-link text-muted p-0 text-decoration-none">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
    <h4 class="fw-bold mb-0 mt-2">👥 Ajouter un membre au Bureau APE</h4>
</div>

<div class="card" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('ape.membres.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control form-control-sm text-uppercase @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" class="form-control form-control-sm text-capitalize @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Fonction <span class="text-danger">*</span></label>
                    <select name="fonction" class="form-select form-select-sm @error('fonction') is-invalid @enderror" required>
                        <option value="">-- Choisir une fonction --</option>
                        <option value="president" {{ old('fonction') == 'president' ? 'selected' : '' }}>Président(e)</option>
                        <option value="vice_president" {{ old('fonction') == 'vice_president' ? 'selected' : '' }}>Vice-Président(e)</option>
                        <option value="secretaire" {{ old('fonction') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                        <option value="tresorier" {{ old('fonction') == 'tresorier' ? 'selected' : '' }}>Trésorier(ère)</option>
                        <option value="membre" {{ old('fonction') == 'membre' ? 'selected' : '' }}>Membre</option>
                    </select>
                    @error('fonction') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Année scolaire <span class="text-danger">*</span></label>
                    <input type="text" name="annee_scolaire" class="form-control form-control-sm @error('annee_scolaire') is-invalid @enderror" value="{{ old('annee_scolaire', '2025-2026') }}" placeholder="Ex: 2025-2026" required>
                    @error('annee_scolaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control form-control-sm @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Adresse Email</label>
                    <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold">Élève lié (Optionnel - Pour associer le parent à un élève)</label>
                    <select name="eleve_id" class="form-select form-select-sm text-uppercase @error('eleve_id') is-invalid @enderror">
                        <option value="">-- Aucun élève lié --</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                {{ $eleve->nom_complet }} ({{ $eleve->classe->nom ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('eleve_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 pt-2 border-top text-end">
                <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">
                    <i class="bi bi-check-lg me-1"></i> Enregistrer le membre
                </button>
            </div>
        </form>
    </div>
</div>
@endsection