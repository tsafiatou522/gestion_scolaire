@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">Vérification du compte enseignant</h4>

            <p class="text-muted">
                Un code de vérification a été envoyé à votre adresse email.
                Veuillez le saisir ci-dessous.
            </p>

            {{-- Affichage des erreurs --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.check') }}">
                @csrf

                <div class="mb-3">
                    <label for="code" class="form-label">Code de vérification</label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        class="form-control"
                        placeholder="Ex: 123456"
                        required
                        maxlength="6"
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Valider le code
                </button>
            </form>

        </div>
    </div>

</div>
@endsection