@extends('layouts.app')
@section('title', 'Historique des activités')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Historique des activités</h4>
</div>

<div class="card">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>Action</th>
                <th>Détails</th>
                <th>Utilisateur</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
            <tr>
                <td><span class="badge bg-primary">{{ $activity->action }}</span></td>
                <td>{{ $activity->details }}</td>
                <td>{{ $activity->user->name ?? '-' }}</td>
                <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">Aucune activité.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($activities->hasPages())
    <div class="p-3">{{ $activities->links() }}</div>
    @endif
</div>
@endsection