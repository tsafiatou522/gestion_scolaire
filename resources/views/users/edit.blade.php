@extends('layouts.app')
@section('title', 'Modifier — ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier — {{ $user->name }}</h4>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4" style="max-width:540px">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
            <small class="text-muted">L'email ne peut pas être modifié.</small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="directeur"    {{ old('role', $user->role) == 'directeur'    ? 'selected' : '' }}>Directeur</option>
                <option value="enseignant"   {{ old('role', $user->role) == 'enseignant'   ? 'selected' : '' }}>Enseignant</option>
                <option value="gestionnaire" {{ old('role', $user->role) == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
            </select>
            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr>
        <p class="text-muted small">Laisser vide pour ne pas changer le mot de passe.</p>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Enregistrer
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection