@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Modifier un enseignant</h3>
    <form action="{{ route('enseignants.update', $enseignant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $enseignant->nom }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" value="{{ $enseignant->prenom }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $enseignant->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" value="{{ $enseignant->telephone }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Matière enseignée</label>
            <input type="text" name="matiere" value="{{ $enseignant->matiere }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning">Mettre à jour</button>
        <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection