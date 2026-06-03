@extends('layouts.app')
@section('title', 'Nouvelle classe')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Nouvelle classe</h4>
    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:540px">
    <form method="POST" action="{{ route('classes.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nom de la classe <span class="text-danger">*</span></label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                   value="{{ old('nom') }}" placeholder="ex : CP1 A" required>
            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Niveau <span class="text-danger">*</span></label>
            <select name="niveau" class="form-select @error('niveau') is-invalid @enderror" required>
                <option value="">-- Choisir --</option>
                @foreach(['CP1','CP2','CE1','CE2','CM1','CM2'] as $n)
                    <option value="{{ $n }}" {{ old('niveau') == $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
            @error('niveau')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Année scolaire <span class="text-danger">*</span></label>
            <input type="text" name="annee_scolaire" class="form-control @error('annee_scolaire') is-invalid @enderror"
                   value="{{ old('annee_scolaire', date('Y').'-'.(date('Y')+1)) }}"
                   placeholder="2025-2026" required>
            @error('annee_scolaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Frais de scolarité (FCFA) <span class="text-danger">*</span></labe