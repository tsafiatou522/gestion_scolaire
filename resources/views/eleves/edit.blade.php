@extends('layouts.app')
@section('title', 'Modifier — ' . $eleve->nom_complet)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Modifier — {{ $eleve->nom_complet }}</h4>
    <!-- Bouton retour vers la liste des élèves -->
    <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4">
    <form method="POST" action="{{ route('eleves.update', $eleve->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Formulaire réutilisé -->
        @include('eleves._form')

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Enregistrer
            </button>
            <!-- Annuler renvoie vers la liste -->
            <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
