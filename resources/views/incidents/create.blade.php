@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h4 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Signaler un problème technique
                </h4>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label for="resource_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Ressource concernée <span class="text-red-500">*</span>
                        </label>
                        <select name="resource_id" id="resource_id" 
                                class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('resource_id') border-red-500 @enderror" 
                                required>
                            <option value="">-- Sélectionner une ressource --</option>
                            @foreach($resources as $resource)
                                <option value="{{ $resource->id }}" {{ old('resource_id') == $resource->id ? 'selected' : '' }}>
                                    {{ $resource->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('resource_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Type de problème <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('type') border-red-500 @enderror" 
                                    required>
                                <option value="panne" {{ old('type') == 'panne' ? 'selected' : '' }}>Panne</option>
                                <option value="dysfonctionnement" {{ old('type') == 'dysfonctionnement' ? 'selected' : '' }}>Dysfonctionnement</option>
                                <option value="dommage" {{ old('type') == 'dommage' ? 'selected' : '' }}>Dommage</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="priorite" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Priorité <span class="text-red-500">*</span>
                            </label>
                            <select name="priorite" id="priorite" 
                                    class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('priorite') border-red-500 @enderror" 
                                    required>
                                <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                                <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                                <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            @error('priorite')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="titre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="titre" id="titre" 
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('titre') border-red-500 @enderror" 
                               value="{{ old('titre') }}" 
                               placeholder="Ex: Écran ne s'allume pas" 
                               required>
                        @error('titre')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Description détaillée <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" 
                                  class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror" 
                                  placeholder="Décrivez le problème en détail..." 
                                  required>{{ old('description') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimum 10 caractères</p>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="fichiers" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Photos ou documents <span class="text-gray-500 text-xs">(optionnel)</span>
                        </label>
                        <input type="file" name="fichiers[]" id="fichiers" 
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('fichiers.*') border-red-500 @enderror" 
                               multiple 
                               accept="image/*,.pdf">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Formats acceptés: JPG, PNG, PDF (max 5MB par fichier)</p>
                        @error('fichiers.*')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('incidents.index') }}" class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Signaler l'incident
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
