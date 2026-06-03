@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Liste des enseignants</h3>
        <a href="{{ route('enseignants.create') }}" class="btn btn-primary">Ajouter un enseignant</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Matière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enseignants as $enseignant)
                <tr>
                    <td>{{ $enseignant->id }}</td>
                    <td>{{ $enseignant->nom }}</td>
                    <td>{{ $enseignant->prenom }}</td>
                    <td>{{ $enseignant->email }}</td>
                    <td>{{ $enseignant->telephone }}</td>
                    <td>{{ $enseignant->matiere }}</td>
                    <td>
                        <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Confirmer la suppression ?')" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection