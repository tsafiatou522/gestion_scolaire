<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Scolaire') — {{ config('app.school_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
body{
    background:#f4f7fb;
    font-family:'Segoe UI',sans-serif;
}

.sidebar{
    min-height:100vh;
    background:linear-gradient(180deg,#0f172a,#1e293b);
    color:#fff;
    box-shadow:4px 0 15px rgba(0,0,0,.08);
}

.sidebar .nav-link{
    color:rgba(255,255,255,.75);
    padding:.75rem 1rem;
    border-radius:12px;
    margin-bottom:5px;
    transition:.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active{
    background:rgba(255,255,255,.15);
    color:#fff;
    transform:translateX(5px);
}

.sidebar .nav-link i{
    width:20px;
}

.sidebar .sidebar-heading{
    font-size: 10px;
    text-uppercase: uppercase;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.4);
    margin-top: 15px;
    margin-bottom: 5px;
    padding-left: 10px;
    font-weight: 700;
}

.main-content{
    padding:0;
    /* Correction : Empêche le contenu de pousser le layout général */
    overflow-x: hidden; 
}

.card{
    border:none;
    border-radius:18px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
    margin-bottom: 1.5rem;
}

.stat-card{
    border:none;
    color:white;
    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-4px);
}

.primary{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
}

.success{
    background:linear-gradient(135deg,#059669,#10b981);
}

.warning{
    background:linear-gradient(135deg,#d97706,#f59e0b);
}

.danger{
    background:linear-gradient(135deg,#dc2626,#ef4444);
}

.stat-card .text-muted{
    color:rgba(255,255,255,.85)!important;
}

/* ======================================================= */
/* CORRECTIF GLOBAL POUR TOUS LES TABLEAUX DU PROJET       */
/* ======================================================= */
.table {
    border-radius: 12px;
    overflow: hidden;
}

.table thead {
    background: #f8fafc;
}

.table th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    padding: 12px 16px !important;
}

.table td {
    padding: 14px 16px !important;
    font-size: 13.5px;
}

.table-hover tbody tr:hover {
    background: #eef4ff;
}

/* Sécurité anti-débordement sur les cartes contenant des tables */
.card .table-responsive {
    border: none;
    margin: 0;
}
/* ======================================================= */
</style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3 d-flex flex-column" style="width:240px; min-width:240px;">
        <div class="mb-4 mt-1">
            <h6 class="fw-bold text-white mb-0">{{ config('app.school_name') }}</h6>
            <small class="text-white-50">Gestion Scolarité</small>
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