@extends('layouts.app')
@section('title', $eleve->nom_complet)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $eleve->nom_complet }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('eleves.edit', $eleve) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
        <a href="{{ route('paiements.create', ['eleve_id' => $eleve->id]) }}" class="btn btn-success btn-sm">
            <i class="bi bi-cash-coin me-1"></i> Enregistrer un paiement
        </a>
        <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            @if($eleve->photo)
                <img src="{{ asset('storage/'.$eleve->photo) }}" class="rounded-circle mx-auto mb-3"
                     style="width:90px;height:90px;object-fit:cover">
            @else
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white mx-auto mb-3"
                     style="width:90px;height:90px;font-size:30px">
                    {{ strtoupper(substr($eleve->prenom,0,1)) }}
                </div>
            @endif
            <h5 class="fw-bold mb-1">{{ $eleve->nom_complet }}</h5>
            <span class="badge bg-primary mb-2">{{ $eleve->classe->nom }}</span>
            <hr>
            <div class="text-start small">
                <div class="mb-1"><strong>Date de naissance :</strong> {{ $eleve->date_naissance->format('d/m/Y') }}</div>
                <div class="mb-1"><strong>Sexe :</strong> {{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</div>
                <div class="mb-1"><strong>Parent :</strong> {{ $eleve->nom_parent ?? '—' }}</div>
                <div><strong>Téléphone :</strong> {{ $eleve->telephone_parent ?? '—' }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-cash-coin me-2 text-success"></i>Situation financière</h6>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Frais dus</span>
                <span class="fw-semibold">{{ number_format($montantDu, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-muted">Total versé</span>
                <span class="fw-semibold text-success">{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Reste à payer</span>
                <span class="{{ $resteAPayer > 0 ? 'text-danger' : 'text-success' }}">
                    {{ $resteAPayer > 0 ? number_format($resteAPayer, 0, ',', ' ').' FCFA' : 'Soldé ✓' }}
                </span>
            </div>
            @if($eleve->paiements->count() > 0)
            <hr>
            <h6 class="fw-semibold small mb-2">Historique des versements</h6>
            @foreach($eleve->paiements->sortByDesc('date_paiement') as $p)
            <div class="d-flex justify-content-between align-items-center small mb-1">
                <span>{{ $p->date_paiement->format('d/m/Y') }}</span>
                <span class="fw-semibold">{{ number_format($p->montant_verse, 0, ',', ' ') }} F</span>
                @if($p->recu_pdf)
                <a href="{{ route('paiements.recu', $p) }}" class="btn btn-outline-danger py-0 px-1" style="font-size:10px">
                    <i class="bi bi-file-pdf"></i>
                </a>
                @endif
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-journal-check me-2 text-primary"></i>Notes récentes</h6>
            @php $notesParTrimestre = $eleve->notes->groupBy('trimestre'); @endphp
            @forelse($notesParTrimestre as $trimestre => $notes)
            <div class="mb-3">
                <div class="fw-semibold small text-muted mb-1">Trimestre {{ $trimestre }}</div>
                @foreach($notes as $note)
                <div class="d-flex justify-content-between small">
                    <span>{{ $note->matiere->nom }}</span>
                    <span class="fw-bold {{ $note->note >= 10 ? 'text-success' : 'text-danger' }}">
                        {{ $note->note }}/20
                    </span>
                </div>
                @endforeach
            </div>
            @empty
            <p class="text-muted small">Aucune note enregistrée.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection