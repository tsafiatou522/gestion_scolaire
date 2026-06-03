@extends('layouts.app')
@section('title', 'Paiement #' . str_pad($paiement->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Paiement #{{ str_pad($paiement->id, 5, '0', STR_PAD_LEFT) }}</h4>
    <div class="d-flex gap-2">
        @if($paiement->recu_pdf)
        <a href="{{ route('paiements.recu', $paiement) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-pdf me-1"></i> Télécharger le reçu
        </a>
        @endif
        <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-3" style="max-width:700px">
    <div class="col-12">
        <div class="card p-4">
            <h6 class="fw-bold mb-3 text-primary">Détails du versement</h6>
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="text-muted" style="width:200px">Élève</td>
                    <td>
                        <a href="{{ route('eleves.show', $paiement->eleve) }}"
                           class="fw-semibold text-decoration-none">
                            {{ $paiement->eleve->nom_complet }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted">Classe</td>
                    <td><span class="badge bg-primary">{{ $paiement->eleve->classe->nom }}</span></td>
                </tr>
                <tr>
                    <td class="text-muted">Date du paiement</td>
                    <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Montant versé</td>
                    <td class="fw-bold text-success fs-5">
                        {{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                @if($paiement->observation)
                <tr>
                    <td class="text-muted">Observation</td>
                    <td>{{ $paiement->observation }}</td>
                </tr>
                @endif
            </table>

            <hr>

            <h6 class="fw-bold mb-3 text-primary">Situation financière après versement</h6>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="border rounded p-2">
                        <div class="text-muted small">Frais dus</div>
                        <div class="fw-bold">
                            {{ number_format($paiement->eleve->classe->fraisScolarite->montant ?? 0, 0, ',', ' ') }} F
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="border rounded p-2 border-success">
                        <div class="text-muted small">Total versé</div>
                        <div class="fw-bold text-success">{{ number_format($totalVerse, 0, ',', ' ') }} F</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="border rounded p-2 {{ $resteAPayer > 0 ? 'border-danger' : 'border-success' }}">
                        <div class="text-muted small">Reste à payer</div>
                        <div class="fw-bold {{ $resteAPayer > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $resteAPayer > 0 ? number_format($resteAPayer, 0, ',', ' ').' F' : 'Soldé ✓' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection