@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<h4 class="fw-bold mb-4">
    Tableau de bord
    <small class="text-muted fs-6 ms-2">{{ now()->format('d/m/Y') }}</small>
</h4>

{{-- Cartes statistiques --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary p-3">
            <div class="text-muted small">Total élèves</div>
            <div class="fs-3 fw-bold text-primary">{{ $totalEleves }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success p-3">
            <div class="text-muted small">Frais collectés</div>
            <div class="fs-3 fw-bold text-success">{{ number_format($totalCollecte, 0, ',', ' ') }} F</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning p-3">
            <div class="text-muted small">Frais attendus</div>
            <div class="fs-3 fw-bold text-warning">{{ number_format($totalAttendu, 0, ',', ' ') }} F</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card danger p-3">
            <div class="text-muted small">Taux recouvrement</div>
            <div class="fs-3 fw-bold text-danger">{{ $tauxRecouvrement }} %</div>
        </div>
    </div>
</div>

@if($user->isDirecteur())
{{-- ÉLÈVES EN RETARD DE PAIEMENT --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card p-3">
            <h6 class="fw-bold mb-3 text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Élèves en retard de paiement ({{ count($elevesImpayes) }})
            </h6>
            @if(count($elevesImpayes) === 0)
                <p class="text-muted small mb-0">Aucun impayé.</p>
            @else
                <div style="max-height:300px;overflow-y:auto">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Élève</th>
                                <th>Classe</th>
                                <th class="text-end">Reste</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($elevesImpayes as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('eleves.show', $item['eleve']) }}" class="text-decoration-none">
                                        {{ $item['eleve']->nom_complet }}
                                    </a>
                                </td>
                                <td class="text-muted small">{{ $item['classe'] }}</td>
                                <td class="text-end text-danger fw-semibold">
                                    {{ number_format($item['reste'], 0, ',', ' ') }} F
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- GRAPHIQUE : Frais collectés vs attendus --}}
<div class="row g-3">
    <div class="col-12">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-bar-chart me-2 text-primary"></i>
                Frais collectés vs attendus par classe
            </h6>
            <canvas id="chartClasses" height="100"></canvas>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('chartClasses').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: {!! json_encode($statsClasses->pluck('nom')) !!},
        datasets: [
            {
                label: 'Attendu',
                data: {!! json_encode($statsClasses->pluck('attendu')) !!},
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderRadius: 4,
            },
            {
                label: 'Collecté',
                data: {!! json_encode($statsClasses->pluck('collecte')) !!},
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderRadius: 4,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush