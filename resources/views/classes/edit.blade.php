@extends('layouts.app')
@section('title', 'Modifier la classe')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier — {{ $classe->nom }}</h4>
    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:540px">
    <form method="POST" action="{{ route('classes.update', ['class' => $classe->id]) }}">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-semibold">Nom de la classe</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom', $classe->nom) }}" required>
            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Niveau</label>
            <input type="text" class="form-control" value="{{ $classe->niveau }}" disabled>
            <small class="text-muted">Le niveau ne peut pas être modifié.</small>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Frais de scolarité (FCFA)</label>
            <input type="number" name="montant_frais" class="form-control @error('montant_frais') is-invalid @enderror"
                   value="{{ old('montant_frais', $classe->fraisScolarite->montant ?? 0) }}"
                   min="0" step="500" required>
            @error('montant_frais')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Enregistrer
            </button>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection