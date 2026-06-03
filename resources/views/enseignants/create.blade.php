@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Ajouter un enseignant</h3>
    <form action="{{ route('enseignants.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Matière enseignée</label>
            <input type="text" name="matiere" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection