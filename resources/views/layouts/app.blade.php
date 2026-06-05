<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Scolaire') â€” {{ config('app.school_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3 d-flex flex-column" style="width:240px; min-width:240px;">
        <div class="text-center mb-3">
            <div style="font-size: 48px; margin-bottom: 0.5rem; color: white;"><i class="bi bi-mortarboard-fill"></i></div>
        </div>
        <div class="mb-4 mt-1">
            <h6 class="fw-bold text-white mb-0">{{ config('app.school_name') }}</h6>
            <small class="text-white-50">Gestion Scolarité</small>
            <div class="sidebar-devise">âœ¨ Excellence - Intégrité - Succès</div>
        </div>

        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
            </a>

            @if(auth()->user()->isDirecteur())
            <a href="{{ route('classes.index') }}"
               class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i> Classes
            </a>
            @endif

            @if(auth()->user()->isDirecteur() || auth()->user()->isGestionnaire())
            <a href="{{ route('eleves.index') }}"
               class="nav-link {{ request()->routeIs('eleves.*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Élèves
            </a>
            <a href="{{ route('paiements.index') }}"
               class="nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin me-2"></i> Paiements
                @php
                    $nbImpayes = \App\Models\Eleve::with('classe.fraisScolarite')
                        ->get()
                        ->filter(function($e) {
                            $frais = $e->classe?->fraisScolarite?->montant ?? 0;
                            $verse = $e->paiements()->sum('montant_verse');
                            return $frais > $verse;
                        })->count();
                @endphp
                @if($nbImpayes > 0)
                    <span class="badge bg-danger ms-auto">{{ $nbImpayes }}</span>
                @endif
            </a>
            @endif

            <div class="sidebar-heading">Association Parents (APE)</div>
            
            <a href="{{ route('ape.membres.index') }}"
               class="nav-link {{ request()->routeIs('ape.membres.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill me-2"></i> Membres Bureau
            </a>
            
            <a href="{{ route('ape.cotisations.index') }}"
               class="nav-link {{ request()->routeIs('ape.cotisations.*') ? 'active' : '' }}">
                <i class="bi bi-piggy-bank-fill me-2"></i> Cotisations APE
            </a>

            <div class="sidebar-heading">Historique</div>
            <a href="{{ route('activities.index') }}"
               class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> Activités
            </a>

            @if(auth()->user()->isDirecteur() || auth()->user()->isEnseignant())
            <div class="sidebar-heading">Pédagogie</div>
            <a href="{{ route('matieres.index') }}"
               class="nav-link {{ request()->routeIs('matieres.*') ? 'active' : '' }}">
                <i class="bi bi-book me-2"></i> Matières
            </a>
            <a href="{{ route('notes.grille') }}"
               class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}">
                <i class="bi bi-journal-check me-2"></i> Notes
            </a>
            @endif

            @if(auth()->user()->isDirecteur())
            <div class="sidebar-heading">Administration</div>
            <a href="{{ route('users.index') }}"
               class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Utilisateurs
            </a>
            @endif
        </nav>

        <div class="mt-auto pt-4">
            <hr class="border-secondary">
            <div class="text-white-50 small mb-2">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth()->user()->name }}
                <span class="ms-1">
                    @if(auth()->user()->isDirecteur())
                        <span class="badge bg-danger" style="font-size:9px">Directeur</span>
                    @elseif(auth()->user()->isEnseignant())
                        <span class="badge bg-primary" style="font-size:9px">Enseignant</span>
                    @else
                        <span class="badge bg-success" style="font-size:9px">Gestionnaire</span>
                    @endif
                </span>
            </div>
            <a href="{{ route('profil.index') }}" class="btn btn-sm btn-outline-light w-100 mb-2">
                <i class="bi bi-gear me-1"></i> Mon profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <div class="main-content flex-grow-1">
        <div class="bg-white border-bottom px-4 py-2 d-flex align-items-center gap-3">
            <form method="GET" action="{{ route('recherche.index') }}" class="d-flex gap-2 w-100" style="max-width:500px">
                <input type="text" name="q" class="form-control form-control-sm"
                       placeholder="Rechercher un élève..."
                       value="{{ request('q') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <small class="text-muted ms-auto">{{ now()->format('d/m/Y') }}</small>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Correction ici : Enveloppement fluide --}}
        <div class="p-4 container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>





