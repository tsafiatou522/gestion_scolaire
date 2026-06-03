@extends('layouts.app')
@section('title', 'Classement — ' . $classe->nom)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Classement — {{ $classe->nom }} — Trimestre {{ $trimestre }}</h4>
    <a href="{{ route('notes.grille', ['classe_id'=>$classe->id,'trimestre'=>$trimestre,'annee_scolaire'=>$anneeScolaire]) }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-pencil me-1"></i> Modifier les notes
    </a>
</div>

<div class="card p-3">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th style="width:60px">Rang</th>
                <th>Élève</th>
                <th class="text-center">Moyenne / 20</th>
                <th class="text-center">Appréciation</th>
                <th class="text-center">Bulletin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classement as $item)
            @php
                $moy = $item['moyenne'];
                $appreciation = match(true) {
                    $moy >= 16 => ['Très bien', 'success'],
                    $moy >= 14 => ['Bien', 'primary'],
                    $moy >= 12 => ['Assez bien', 'info'],
                    $moy >= 10 => ['Passable', 'warning'],
                    default    => ['Insuffisant', 'danger'],
                };
            @endphp
            <tr>
                <td>
                    @if($item['rang'] <= 3)
                        <span class="badge bg-warning text-dark">{{ $item['rang'] }}</span>
                    @else
                        {{ $item['rang'] }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('eleves.show', $item['eleve']) }}"
                       class="text-decoration-none fw-semibold">
                        {{ $item['eleve']->nom_complet }}
                    </a>
                </td>
                <td class="text-center fw-bold fs-5">{{ $moy }}</td>
                <td class="text-center">
                    <span class="badge bg-{{ $appreciation[1] }}">{{ $appreciation[0] }}</span>
                </td>
                <td class="text-center">
                    <a href="{{ route('notes.bulletin', [$item['eleve'], $trimestre, $anneeScolaire]) }}"
                       class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-file-pdf me-1"></i> PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection