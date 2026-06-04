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
{{-- PREMIÈRE LIGNE DE TABLEAUX : Paiements du jour & Activités Enseignants --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-cash-coin me-2 text-success"></i>
                    Paiements d'aujourd'hui
                </h6>
                <span class="badge bg-success">
                    {{ number_format($totalAujourdhui, 0, ',', ' ') }} FCFA
                </span>
            </div>
            @if($paiementsAujourdhui->count() === 0)
                <p class="text-muted small mb-0">Aucun paiement aujourd'hui.</p>
            @else
                <div style="max-height:180px;overflow-y:auto">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
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
                                <td><span class="badge bg-primary">{{ $p->eleve->classe->nom }}</span></td>
                                <td class="text-end text-success fw-semibold">
                                    {{ number_format($p->montant_verse, 0, ',', ' ') }} F
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-person-badge me-2 text-primary"></i>
                Activité des enseignants
            </h6>
            @if($activiteEnseignants->count() === 0)
                <p class="text-muted small mb-0">Aucun enseignant enregistré.</p>
            @else
                <div style="max-height:180px; overflow-y:auto;">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Enseignant</th>
                                <th>Dernière saisie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activiteEnseignants as $e)
                            <tr>
                                <td>{{ $e['nom'] }}</td>
                                <td class="text-muted small">
                                    {{ $e['derniere_note'] ? $e['derniere_note']->format('d/m/Y H:i') : '—' }}
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

{{-- DEUXIÈME LIGNE DE TABLEAUX : Résumé par classe & Élèves en retard --}}
<div class="row g-3 mb-4">
    {{-- Résumé complet par classe (7/12 de la largeur totale) --}}
    <div class="col-lg-7">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-building me-2 text-primary"></i>
                Résumé complet par classe
            </h6>
            <div style="max-height: 250px; overflow-y: auto;">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th>Classe</th>
                            <th class="text-center">Effectif</th>
                            <th class="text-end">Attendus</th>
                            <th class="text-end">Collectés</th>
                            <th class="text-end">Reste</th>
                            <th class="text-center">Impayés</th>
                            <th class="text-center">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statsClasses as $key => $stat)
                        <tr>
                            <td class="fw-semibold">{{ $stat['nom'] }}</td>
                            <td class="text-center">{{ $stat['effectif'] }}</td>
                            <td class="text-end">{{ number_format($stat['attendu'], 0, ',', ' ') }} F</td>
                            <td class="text-end text-success">{{ number_format($stat['collecte'], 0, ',', ' ') }} F</td>
                            <td class="text-end text-danger">{{ number_format($stat['reste'], 0, ',', ' ') }} F</td>
                            <td class="text-center">
                                @if($stat['nb_impayes'] > 0)
                                    <span class="badge bg-danger">{{ $stat['nb_impayes'] }}</span>
                                @else
                                    <span class="badge bg-success">0</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($resumeClasses[$key]['moyenne_classe'] !== null)
                                    <span class="fw-bold {{ $resumeClasses[$key]['moyenne_classe'] >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ $resumeClasses[$key]['moyenne_classe'] }}/20
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Élèves en retard de paiement (5/12 de la largeur totale) --}}
    <div class="col-lg-5">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3 text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Élèves en retard de paiement ({{ count($elevesImpayes) }})
            </h6>
            @if(count($elevesImpayes) === 0)
                <p class="text-muted small">Aucun impayé.</p>
            @else
                <div style="max-height:250px;overflow-y:auto">
                    <table class="table table-sm mb-0">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
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

{{-- TROISIÈME LIGNE DE TABLEAUX : Dernières notes saisies --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-journal-check me-2 text-primary"></i>
                Dernières notes saisies
            </h6>
            @if($dernieresNotes->count() === 0)
                <p class="text-muted small mb-0">Aucune note saisie.</p>
            @else
                <div style="max-height:180px; overflow-y:auto;">
                    <table class="table table-sm mb-0">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th>Élève</th>
                                <th>Matière</th>
                                <th class="text-center">Note</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dernieresNotes as $note)
                            <tr>
                                <td>{{ $note->eleve->nom_complet }}</td>
                                <td>{{ $note->matiere->nom }}</td>
                                <td class="text-center fw-bold {{ $note->note >= 10 ? 'text-success' : 'text-danger' }}">
                                    {{ $note->note }}/20
                                </td>
                                <td class="text-muted small">{{ $note->updated_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- QUATRIÈME LIGNE : Graphiques (Toujours visibles en bas) --}}
<div class="row g-3">
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">Frais collectés vs attendus par classe</h6>
            <canvas id="chartClasses" height="120"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">Paiements des 6 derniers mois</h6>
            <canvas id="chartPaiements" height="120"></canvas>
        </div>
    </div>
</div>
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

const ctx2 = document.getElementById('chartPaiements').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: {!! json_encode($moisLabels) !!},
        datasets: [{
            label: 'Paiements (FCFA)',
            data: {!! json_encode($moisData) !!},
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush