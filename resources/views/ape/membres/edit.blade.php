@extends('layouts.app')
@section('title', 'Modifier membre APE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier — {{ $membre->nom_complet }}</h4>
    <a href="{{ route('ape.membres.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:580px">
    <form method="POST" action="{{ route('ape.membres.update', $membre) }}">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                <input type="text" name="nom"
                       class="form-control @error('nom') is-invalid @enderror"
                       value="{{ old('nom', $membre->nom) }}" required>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                <input type="text" name="prenom"
                       class="form-control @error('prenom') is-invalid @enderror"
                       value="{{ old('prenom', $membre->prenom) }}" required>
                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Téléphone</label>
                <input type="text" name="telephone" class="form-control"
                       value="{{ old('telephone', $membre->telephone) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $membre->email) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Fonction <span class="text-danger">*</span></label>
                <select name="fonction" class="form-select" required>
                    <option value="president"      {{ old('fonction', $membre->fonction) == 'president'      ? 'selected' : '' }}>Président(e)</option>
                    <option value="vice_president" {{ old('fonction', $membre->fonction) == 'vice_president' ? 'selected' : '' }}>Vice-Président(e)</option>
                    <option value="secretaire"     {{ old('fonction', $membre->fonction) == 'secretaire'     ? 'selected' : '' }}>Secrétaire</option>
                    <option value="tresorier"      {{ old('fonction', $membre->fonction) == 'tresorier'      ? 'selected' : '' }}>Trésorier(ère)</option>
                    <option value="membre"         {{ old('fonction', $membre->fonction) == 'membre'         ? 'selected' : '' }}>Membre</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Élève lié</label>
                <select name="eleve_id" class="form-select">
                    <option value="">-- Aucun --</option>
                    @foreach($eleves as $eleve)
                        <option value="{{ $eleve->id }}"
                            {{ old('eleve_id', $membre->eleve_id) == $eleve->id ? 'selected' : '' }}>
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