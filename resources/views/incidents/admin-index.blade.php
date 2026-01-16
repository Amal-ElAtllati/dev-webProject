@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Gestion des Incidents
        </h2>
        <div class="flex items-center space-x-3">
            <span class="px-3 py-1.5 text-white text-sm font-semibold rounded-full shadow-sm" style="background: linear-gradient(to right, #a16207, #854d0e, #92400e) !important; text-shadow: 0 2px 4px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                {{ $stats['ouvert'] }} Ouverts
            </span>
            <span class="px-3 py-1.5 text-white text-sm font-semibold rounded-full shadow-sm" style="background: linear-gradient(to right, #1d4ed8, #1e40af, #4338ca) !important; text-shadow: 0 2px 4px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                {{ $stats['en_cours'] }} En cours
            </span>
            <span class="px-3 py-1.5 text-white text-sm font-semibold rounded-full shadow-sm" style="background: linear-gradient(to right, #15803d, #166534, #065f46) !important; text-shadow: 0 2px 4px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                {{ $stats['resolu'] }} Résolus
            </span>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative animate-fade-in" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($incidents->isEmpty())
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 px-6 py-4 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <span>Aucun incident signalé pour le moment</span>
            </div>
        </div>
    @else
        <!-- Incidents List -->
        @foreach($incidents as $incident)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 mb-4 overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Card Header -->
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ $incident->titre }}
                    </h5>
                    <span class="px-3 py-1.5 text-xs font-semibold rounded-full shadow-sm
                        @if($incident->statut == 'ouvert') 
                            bg-gradient-to-r from-yellow-700 via-yellow-800 to-amber-800 text-white
                        @elseif($incident->statut == 'en_cours') 
                            bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-800 text-white
                        @elseif($incident->statut == 'resolu') 
                            bg-gradient-to-r from-green-700 via-green-800 to-emerald-800 text-white
                        @else 
                            bg-gradient-to-r from-gray-700 via-gray-800 to-gray-900 text-white
                        @endif" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        {{ ucfirst(str_replace('_', ' ', $incident->statut)) }}
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Incident Information -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Signalé par:
                                </span>
                                <span class="ml-6">{{ $incident->user->name }}</span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-1-3M15 13h-6M5 17H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-1" />
                                    </svg>
                                    Ressource:
                                </span>
                                <span class="ml-6">{{ $incident->resource->nom }}</span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Type:
                                </span>
                                <span class="ml-6">
                                    {{ ucfirst($incident->type) }}
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full
                                        @if($incident->priorite == 'urgente') 
                                            bg-gradient-to-r from-red-700 via-red-800 to-rose-800 text-white
                                        @elseif($incident->priorite == 'haute') 
                                            bg-gradient-to-r from-yellow-700 via-yellow-800 to-amber-800 text-white
                                        @elseif($incident->priorite == 'moyenne') 
                                            bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-800 text-white
                                        @else 
                                            bg-gradient-to-r from-gray-700 via-gray-800 to-gray-900 text-white
                                        @endif" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                        Priorité: {{ ucfirst($incident->priorite) }}
                                    </span>
                                </span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Date:
                                </span>
                                <span class="ml-6">{{ $incident->created_at->format('d/m/Y à H:i') }}</span>
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mt-4">
                            <strong class="text-gray-900 dark:text-gray-100">Description:</strong>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $incident->description }}</p>
                        </div>

                        @if($incident->reponse_admin)
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                <strong class="text-green-900 dark:text-green-100 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Votre réponse:
                                </strong>
                                <p class="text-green-800 dark:text-green-200 mt-2">{{ $incident->reponse_admin }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Management Form -->
                    <div class="lg:col-span-1">
                        <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/50">
                            <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Gérer cet incident
                            </h6>
                            
                            <form action="{{ route('incidents.respond', $incident->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Statut:
                                    </label>
                                    <select name="statut" 
                                            class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                            required>
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

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Votre réponse:
                                    </label>
                                    <textarea name="reponse_admin" 
                                              class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" 
                                              rows="4" 
                                              placeholder="Expliquer la solution ou les actions prises...">{{ $incident->reponse_admin }}</textarea>
                                </div>

                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-800 hover:from-blue-800 hover:via-blue-900 hover:to-indigo-900 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Mettre à jour
                                </button>
                            </form>

                            <hr class="my-4 border-gray-300 dark:border-gray-700">

                            <a href="{{ route('incidents.show', $incident->id) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir tous les détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $incidents->links() }}
        </div>
    @endif
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endsection
