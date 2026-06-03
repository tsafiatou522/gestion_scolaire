@extends('layouts.app')
@section('title', 'Mon profil')

@section('content')
<h4 class="fw-bold mb-4">Mon profil</h4>

<div class="row g-3">
    {{-- Infos personnelles --}}
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-bold mb-3 text-primary">
                <i class="bi bi-person me-2"></i>Informations personnelles
            </h6>

            @if(session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profil.update') }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom complet</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rôle</label>
                    <div>
                        @if($user->role === 'directeur')
                            <span class="badge bg-danger fs-6">Directeur</span>
                        @elseif($user->role === 'enseignant')
                            <span class="badge bg-primary fs-6">Enseignant</span>
                        @else
                            <span class="badge bg-success fs-6">Gestionnaire</span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>

    {{-- Changer mot de passe --}}
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-bold mb-3 text-primary">
                <i class="bi bi-lock me-2"></i>Changer le mot de passe
            </h6>

            <form method="POST" action="{{ route('profil.password') }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mot de passe actuel</label>
                    <input type="password" name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nouveau mot de passe</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-lock me-1"></i> Changer le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection