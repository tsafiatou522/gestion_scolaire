@extends('layouts.app')
@section('title', 'Saisie des notes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Saisie des notes</h4>
</div>

<div class="card p-3 mb-4">
    <form method="GET" action="{{ route('notes.grille') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Classe</label>
            <select name="classe_id" class="form-select form-select-sm">
                <option value="">-- Choisir --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Trimestre</label>
            <select name="trimestre" class="form-select form-select-sm">
                @foreach([1,2,3] as $t)
                    <option value="{{ $t }}" {{ $trimestre == $t ? 'selected' : '' }}>
                        Trimestre {{ $t }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Année scolaire</label>
            <input type="text" name="annee_scolaire" class="form-control form-control-sm"
                   value="{{ $anneeScolaire }}" placeholder="2025-2026">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">Afficher</button>
        </div>
    </form>
</div>

@if($classeId && count($eleves) > 0)
<div class="card p-3">
    <div class="alert alert-info mb-3">
        <strong>Niveau {{ $niveau }}</strong> — Les notes doivent être entre <strong>0 et {{ $noteMax }}</strong>
    </div>
    
    <form method="POST" action="{{ route('notes.enregistrer') }}">
        @csrf
        <input type="hidden" name="classe_id" value="{{ $classeId }}">
        <input type="hidden" name="trimestre" value="{{ $trimestre }}">
        <input type="hidden" name="annee_scolaire" value="{{ $anneeScolaire }}">

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Élève</th>
                        @foreach($matieres as $matiere)
                            <th class="text-center" style="min-width:90px">
                                {{ $matiere->nom }}<br>
                                <small class="fw-normal">coef {{ $matiere->pivot->coefficient ?? '-' }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                    <tr>
                        <td class="fw-semibold">{{ $eleve->nom_complet }}</td>
                        @foreach($matieres as $matiere)
                        <td>
                            <input type="number"
                                   name="notes[{{ $eleve->id }}][{{ $matiere->id }}]"
                                   class="form-control form-control-sm text-center"
                                   min="0" max="{{ $noteMax }}" step="0.25"
                                   value="{{ $notes[$eleve->id][$matiere->id] ?? '' }}"
                                   placeholder="—">
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Enregistrer les notes
            </button>
            <a href="{{ route('notes.classement', ['classe_id'=>$classeId,'trimestre'=>$trimestre,'annee_scolaire'=>$anneeScolaire]) }}"
               class="btn btn-outline-primary">
                <i class="bi bi-trophy me-1"></i> Voir le classement
            </a>
        </div>
    </form>
</div>
@elseif($classeId)
    <div class="alert alert-info">Aucun élève ou matière trouvé pour cette classe.</div>
@endif
@endsection