@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tools text-primary"></i> Gestion des Incidents</h2>
        <div>
            <span class="badge bg-warning fs-6">{{ $stats['ouvert'] }} Ouverts</span>
            <span class="badge bg-info fs-6 ms-2">{{ $stats['en_cours'] }} En cours</span>
            <span class="badge bg-success fs-6 ms-2">{{ $stats['resolu'] }} Résolus</span>
        </div>
    </div>

    <!-- Message succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Si aucun incident -->
    @if($incidents->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Aucun incident signalé pour le moment
        </div>
    @else
        <!-- Liste des incidents -->
        @foreach($incidents as $incident)
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                        {{ $incident->titre }}
                    </h5>
                    <span class="badge bg-{{ 
                        $incident->statut == 'ouvert' ? 'warning' : 
                        ($incident->statut == 'en_cours' ? 'info' : 
                        ($incident->statut == 'resolu' ? 'success' : 'secondary')) 
                    }}">
                        {{ ucfirst(str_replace('_', ' ', $incident->statut)) }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <!-- Informations de l'incident -->
                    <div class="col-md-8">
                        <div class="mb-2">
                            <strong><i class="fas fa-user"></i> Signalé par:</strong> 
                            {{ $incident->user->name }}
                        </div>
                        <div class="mb-2">
                            <strong><i class="fas fa-desktop"></i> Ressource:</strong> 
                            {{ $incident->resource->nom }}
                        </div>
                        <div class="mb-2">
                            <strong><i class="fas fa-tag"></i> Type:</strong> 
                            {{ ucfirst($incident->type) }}
                            <span class="badge bg-{{ 
                                $incident->priorite == 'urgente' ? 'danger' : 
                                ($incident->priorite == 'haute' ? 'warning' : 
                                ($incident->priorite == 'moyenne' ? 'info' : 'secondary')) 
                            }} ms-2">
                                Priorité: {{ ucfirst($incident->priorite) }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <strong><i class="fas fa-clock"></i> Date:</strong> 
                            {{ $incident->created_at->format('d/m/Y à H:i') }}
                        </div>
                        
                        <div class="alert alert-light mt-3">
                            <strong>Description:</strong><br>
                            {{ $incident->description }}
                        </div>

                        @if($incident->reponse_admin)
                            <div class="alert alert-success">
                                <strong><i class="fas fa-reply"></i> Votre réponse:</strong><br>
                                {{ $incident->reponse_admin }}
                            </div>
                        @endif
                    </div>

                    <!-- Formulaire de gestion -->
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="mb-3"><i class="fas fa-cog"></i> Gérer cet incident</h6>
                            
                            <form action="{{ route('incidents.respond', $incident->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Statut:</label>
                                    <select name="statut" class="form-select" required>
                                        <option value="ouvert" {{ $incident->statut == 'ouvert' ? 'selected' : '' }}>
                                            ⚠️ Ouvert
                                        </option>
                                        <option value="en_cours" {{ $incident->statut == 'en_cours' ? 'selected' : '' }}>
                                            🔧 En cours
                                        </option>
                                        <option value="resolu" {{ $incident->statut == 'resolu' ? 'selected' : '' }}>
                                            ✅ Résolu
                                        </option>
                                        <option value="ferme" {{ $incident->statut == 'ferme' ? 'selected' : '' }}>
                                            🔒 Fermé
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Votre réponse:</label>
                                    <textarea name="reponse_admin" 
                                              class="form-control" 
                                              rows="4" 
                                              placeholder="Expliquer la solution ou les actions prises...">{{ $incident->reponse_admin }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i> Mettre à jour
                                </button>
                            </form>

                            <hr>

                            <a href="{{ route('incidents.show', $incident->id) }}" 
                               class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-eye"></i> Voir tous les détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $incidents->links() }}
        </div>
    @endif
</div>
@endsection