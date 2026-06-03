@extends('layouts.app')
@section('title', 'Inscrire un élève')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Inscrire un élève</h4>
    <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card p-4">
    <form method="POST" action="{{ route('eleves.store') }}" enctype="multipart/form-data">
        @csrf
        @include('eleves._form')
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Inscrire
            </button>
            <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection