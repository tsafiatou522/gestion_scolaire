@extends('layouts.app')
@section('title', 'Créer une matière')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Créer une matière</h4>

    <a href="{{ route('matieres.index', ['classe_id' => $classeId]) }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:540px">
    <form method="POST" action="{{ route('matieres.store') }}">
        @csrf

        <input type="hidden" name="classe_id" value="{{ $classeId }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">Nom de la matière <span class="text-danger">*</span></label>
            <input type="text" name="nom"
                   class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom') }}" required>
            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Coefficient <span class="text-danger">*</span></label>
            <input type="number" name="coefficient"
                   class="form-control @error('coefficient') is-invalid @enderror"
                   value="{{ old('coefficient', 1) }}"
                   min="0.5" max="10" step="0.5" required>
            @error('coefficient')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Enregistrer
            </button>
            <a href="{{ route('matieres.index', ['classe_id' => $classeId]) }}"
               class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection