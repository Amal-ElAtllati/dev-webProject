@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-exclamation-circle"></i> Signaler un problème technique</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="resource_id" class="form-label">Ressource concernée <span class="text-danger">*</span></label>
                            <select name="resource_id" id="resource_id" class="form-select @error('resource_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une ressource --</option>
                                @foreach($resources as $resource)
                                    <option value="{{ $resource->id }}" {{ old('resource_id') == $resource->id ? 'selected' : '' }}>
                                        {{ $resource->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resource_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type de problème <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="panne" {{ old('type') == 'panne' ? 'selected' : '' }}>Panne</option>
                                    <option value="dysfonctionnement" {{ old('type') == 'dysfonctionnement' ? 'selected' : '' }}>Dysfonctionnement</option>
                                    <option value="dommage" {{ old('type') == 'dommage' ? 'selected' : '' }}>Dommage</option>
                                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="priorite" class="form-label">Priorité <span class="text-danger">*</span></label>
                                <select name="priorite" id="priorite" class="form-select @error('priorite') is-invalid @enderror" required>
                                    <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                                    <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                                    <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('priorite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" 
                                   value="{{ old('titre') }}" placeholder="Ex: Écran ne s'allume pas" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description détaillée <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="5" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Décrivez le problème en détail..." required>{{ old('description') }}</textarea>
                            <small class="text-muted">Minimum 10 caractères</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fichiers" class="form-label">Photos ou documents <small class="text-muted">(optionnel)</small></label>
                            <input type="file" name="fichiers[]" id="fichiers" class="form-control @error('fichiers.*') is-invalid @enderror" 
                                   multiple accept="image/*,.pdf">
                            <small class="text-muted">Formats acceptés: JPG, PNG, PDF (max 5MB par fichier)</small>
                            @error('fichiers.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('incidents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Signaler l'incident
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .btn-primary, .btn-secondary {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        padding: 10px 25px !important;
        font-size: 16px !important;
    }
    
    form .d-flex {
        margin-top: 30px !important;
        padding-top: 20px !important;
        border-top: 2px solid #dee2e6 !important;
    }
</style>
@endsection