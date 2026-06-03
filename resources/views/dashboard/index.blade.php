@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">📊 Tableau de bord</h2>
        <small class="text-muted">
            Vue générale de l'établissement
        </small>
    </div>

    <span class="badge bg-primary fs-6 px-3 py-2">
        {{ now()->format('d/m/Y') }}
    </span>
</div>

{{-- Statistiques principales --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary p-4">
            <div class="text-muted small">Total élèves</div>
            <h2 class="fw-bold mt-2">{{ $totalEleves }}</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card success p-4">
            <div class="text-muted small">Frais collectés</div>
            <h2 class="fw-bold mt-2">{{ number_format($totalCollecte,0,',',' ') }} F</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card warning p-4">
            <div class="text-muted small">Frais attendus</div>
            <h2 class="fw-bold mt-2">{{ number_format($totalAttendu,0,',',' ') }} F</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card danger p-4">
            <div class="text-muted small">Taux de recouvrement</div>
            <h2 class="fw-bold mt-2">{{ $tauxRecouvrement }} %</h2>
        </div>
    </div>
</div>

{{-- Section APE --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">💰 Cotisations APE</h5>
            <p>Total collecté : <strong>{{ number_format($totalCotisationsAPE,0,',',' ') }} FCFA</strong></p>

            @if($cotisationsRecentes->count())
                <ul class="list-group list-group-flush">
                    @foreach($cotisationsRecentes as $coti)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $coti->eleve->nom_complet ?? 'Élève inconnu' }}</span>
                            <span class="fw-bold text-success">
                                {{ number_format($coti->montant,0,',',' ') }} F
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info mb-0">
                    Aucune cotisation enregistrée récemment.
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('ape.cotisations.index') }}" class="btn btn-primary btn-sm">
                    Voir toutes les cotisations
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-3">👥 Membres APE</h5>
            <p class="fs-4 fw-bold">{{ $totalMembresAPE }}</p>
            <p class="text-muted">Membres enregistrés</p>
            <a href="{{ route('ape.membres.index') }}" class="btn btn-secondary btn-sm">
                Voir les membres
            </a>
        </div>
    </div>
</div>

{{-- Carte scolaire --}}
<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">📚 Carte scolaire</h5>
            <div class="d-flex justify-content-around">
                <div class="text-center">
                    <h2 class="fw-bold">{{ $totalClasses }}</h2>
                    <small class="text-muted">Classes</small>
                </div>
                <div class="text-center">
                    <h2 class="fw-bold">{{ $totalElevesCarte }}</h2>
                    <small class="text-muted">Élèves</small>
                </div>
            </div>
        </div>
    </div>
</div>

@if($user->isDirecteur())
<div class="row g-4 mb-4">
    <div class="col-md-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold mb-0">💰 Paiements du jour</h5>
                <span class="badge bg-success">
                    {{ number_format($totalAujourdhui,0,',',' ') }} FCFA
                </span>
            </div>

            @if($paiementsAujourdhui->count())
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th class="text-end">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiementsAujourdhui as $p)
                            <tr>
                                <td>{{ $p->eleve->nom_complet }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $p->eleve->classe->nom }}</span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    {{ number_format($p->montant_verse,0,',',' ') }} F
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-4 text-muted">
                    Aucun paiement enregistré aujourd'hui
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-5">
        <div class="card p-4 h-100">
            <h5 class="fw-bold text-danger mb-3">⚠ Élèves en retard</h5>
            <div class="text-center mb-4">
                <h1 class="fw-bold text-danger">{{ count($elevesImpayes) }}</h1>
                <p class="text-muted">élèves en retard de paiement</p>
            </div>

            @if(count($elevesImpayes))
                <div style="max-height:250px;overflow-y:auto">
                    @foreach($elevesImpayes as $item)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ $item['eleve']->nom_complet }}</div>
                                <small class="text-muted">{{ $item['classe'] }}</small>
                            </div>
                            <div class="text-danger fw-bold">
                                {{ number_format($item['reste'],0,',',' ') }} F
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-success mb-0">
                    Aucun impayé actuellement.
                </div>
            @endif
        </div>
    </div>
</div>
@endif

<div class="card p-4">
    <h5 class="fw-bold mb-4">📈 Paiements des 6 derniers mois</h5>
    <canvas id="chartPaiements" height="100"></canvas>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx2 = document.getElementById('chartPaiements').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: {!! json_encode($moisLabels) !!},
        datasets: [{
            label: 'Paiements',
            data: {!! json_encode($moisData) !!},
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            fill: true,
            tension: .4
        }]
    },
    options: { responsive: true }
});
</script>
@endpush
