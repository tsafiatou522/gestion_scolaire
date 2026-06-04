@extends('layouts.app')
@section('title', 'Élèves')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Élèves</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('export.eleves', ['classe_id' => $classeId]) }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-file-excel me-1"></i> Exporter Excel
        </a>
        <a href="{{ route('eleves.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Inscrire un élève
        </a>
    </div>
</div>

<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('eleves.index') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Filtrer par classe</label>
            <select name="classe_id" class="form-select form-select-sm">
                <option value="">Toutes les classes</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Filtrer</button>
        </div>
        @if($classeId)
        <div class="col-md-2">
            <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary btn-sm w-100">Réinitialiser</a>
        </div>
        @endif
    </form>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th style="width:50px"></th>
                <th>Nom & Prénom</th>
                <th>Classe</th>
                <th>Sexe</th>
                <th>Date de naissance</th>
                <th>Parent</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($eleves as $eleve)
            <tr>
                <td>
                    @if($eleve->photo)
                        <img src="{{ asset('storage/'.$eleve->photo) }}" class="rounded-circle"
                             style="width:36px;height:36px;object-fit:cover">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                             style="width:36px;height:36px;font-size:13px">
                            {{ strtoupper(substr($eleve->prenom,0,1)) }}
                        </div>
                    @endif
                </td>
                <td class="fw-semibold">{{ $eleve->nom_complet }}</td>
                <td><span class="badge bg-primary">{{ $eleve->classe->nom }}</span></td>
                <td>{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
                <td>{{ $eleve->date_naissance->format('d/m/Y') }}</td>
                <td class="text-muted small">{{ $eleve->nom_parent ?? '—' }}</td>
                <td class="text-center">
    <a href="{{ route('eleves.show', $eleve) }}"
       class="btn btn-sm btn-outline-primary"
       title="Voir">
        <i class="bi bi-eye"></i>
    </a>

    <a href="{{ route('eleves.edit', $eleve) }}"
       class="btn btn-sm btn-outline-secondary"
       title="Modifier">
        <i class="bi bi-pencil"></i>
    </a>

    <a href="{{ route('eleves.carte', $eleve) }}"
       class="btn btn-sm btn-outline-success"
       title="Carte scolaire">
        <i class="bi bi-person-vcard"></i>
    </a>

    <form action="{{ route('eleves.destroy', $eleve) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Supprimer cet élève ?')">
        @csrf
        @method('DELETE')

        <button class="btn btn-sm btn-outline-danger"
                title="Supprimer">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Aucun élève trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($eleves->hasPages())
    <div class="p-3">{{ $eleves->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection