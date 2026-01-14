@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mes signalements d'incidents</h2>
        <a href="{{ route('incidents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Signaler un problème
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($incidents->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Vous n'avez aucun incident signalé.
        </div>
    @else
        @foreach($incidents as $incident)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ $incident->titre }}</h5>
                    <span class="badge 
                        @if($incident->statut == 'ouvert') bg-warning
                        @elseif($incident->statut == 'en_cours') bg-info
                        @elseif($incident->statut == 'resolu') bg-success
                        @else bg-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $incident->statut)) }}
                    </span>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong><i class="fas fa-desktop"></i> Ressource:</strong> 
                            {{ $incident->resource->nom ?? 'N/A' }}
                        </p>
                        <p class="mb-1">
                            <strong><i class="fas fa-tag"></i> Type:</strong> 
                            {{ ucfirst($incident->type) }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong><i class="fas fa-exclamation-triangle"></i> Priorité:</strong> 
                            <span class="badge 
                                @if($incident->priorite == 'urgente') bg-danger
                                @elseif($incident->priorite == 'haute') bg-warning
                                @elseif($incident->priorite == 'moyenne') bg-info
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($incident->priorite) }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <strong><i class="fas fa-calendar"></i> Signalé le:</strong> 
                            {{ $incident->date_signalement->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                </div>

                <p class="card-text text-muted">
                    {{ Str::limit($incident->description, 150) }}
                </p>

                <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Voir détails
                </a>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $incidents->links() }}
        </div>
    @endif
</div>
@endsection