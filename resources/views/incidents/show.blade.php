@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3">
                <a href="{{ route('incidents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-exclamation-circle"></i> Détails de l'incident</h4>
                    <span class="badge 
                        @if($incident->statut == 'ouvert') bg-warning
                        @elseif($incident->statut == 'en_cours') bg-info
                        @elseif($incident->statut == 'resolu') bg-success
                        @else bg-secondary
                        @endif fs-6">
                        {{ ucfirst(str_replace('_', ' ', $incident->statut)) }}
                    </span>
                </div>
                <div class="card-body">
                    <h3 class="mb-4">{{ $incident->titre }}</h3>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-desktop"></i> Ressource:</strong> {{ $incident->resource->nom ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-tag"></i> Type:</strong> {{ ucfirst($incident->type) }}</p>
                            <p>
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
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Signalé par:</strong> {{ $incident->user->name }}</p>
                            <p><strong><i class="fas fa-calendar"></i> Date de signalement:</strong> {{ $incident->date_signalement->format('d/m/Y à H:i') }}</p>
                            @if($incident->date_resolution)
                                <p><strong><i class="fas fa-check-circle"></i> Date de résolution:</strong> {{ $incident->date_resolution->format('d/m/Y à H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5><i class="fas fa-align-left"></i> Description:</h5>
                        <p class="border p-3 rounded bg-light">{{ $incident->description }}</p>
                    </div>

                    @if($incident->fichiers && count($incident->fichiers) > 0)
                        <div class="mb-4">
                            <h5><i class="fas fa-paperclip"></i> Fichiers joints:</h5>
                            <div class="row">
                                @foreach($incident->fichiers as $fichier)
                                    <div class="col-md-3 mb-3">
                                        @if(Str::endsWith($fichier, '.pdf'))
                                            <a href="{{ asset('storage/' . $fichier) }}" target="_blank" class="btn btn-outline-danger w-100">
                                                <i class="fas fa-file-pdf fa-2x"></i><br>
                                                <small>PDF</small>
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $fichier) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $fichier) }}" class="img-thumbnail" alt="Photo">
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($incident->reponse_admin)
                        <div class="alert alert-info">
                            <h5><i class="fas fa-reply"></i> Réponse de l'administrateur:</h5>
                            <p class="mb-0">{{ $incident->reponse_admin }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection