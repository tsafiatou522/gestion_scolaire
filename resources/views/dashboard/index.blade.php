@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<h4 class="fw-bold mb-4">
    Tableau de bord
    <small class="text-muted fs-6 ms-2">{{ now()->format('d/m/Y') }}</small>
</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary p-3">
            <div class="text-muted small">Total élèves</div>
            <div class="fs-3 fw-bold">{{ $totalEleves }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success p-3">
            <div class="text-muted small">Frais collectés</div>
            <div class="fs-3 fw-bold">{{ number_format($totalCollecte, 0, ',', ' ') }} F</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning p-3">
            <div class="text-muted small">Frais attendus</div>
            <div class="fs-3 fw-bold">{{ number_format($totalAttendu, 0, ',', ' ') }} F</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card danger p-3">
            <div class="text-muted small">Taux recouvrement</div>
            <div class="fs-3 fw-bold">{{ $tauxRecouvrement }} %</div>
        </div>
    </div>
</div>
@endsection
