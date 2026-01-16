@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Mes signalements d'incidents</h2>
        <a href="{{ route('incidents.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Signaler un problème
        </a>
    </div>

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

    @if($incidents->isEmpty())
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 px-6 py-4 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <span>Vous n'avez aucun incident signalé.</span>
            </div>
        </div>
    @else
        @foreach($incidents as $incident)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 mb-4 overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $incident->titre }}</h3>
                    <span class="px-3 py-1.5 text-xs font-semibold rounded-full shadow-sm
                        @if($incident->statut == 'ouvert') 
                            bg-gradient-to-r from-yellow-500 to-amber-600 text-white
                        @elseif($incident->statut == 'en_cours') 
                            bg-gradient-to-r from-blue-500 to-indigo-600 text-white
                        @elseif($incident->statut == 'resolu') 
                            bg-gradient-to-r from-green-500 to-emerald-600 text-white
                        @else 
                            bg-gradient-to-r from-gray-500 to-gray-600 text-white
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $incident->statut)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-1-3M15 13h-6M5 17H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-1" />
                                </svg>
                                Ressource:
                            </span>
                            <span class="ml-6">{{ $incident->resource->nom ?? 'N/A' }}</span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Type:
                            </span>
                            <span class="ml-6">{{ ucfirst($incident->type) }}</span>
                        </p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Priorité:
                            </span>
                            <span class="ml-6">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($incident->priorite == 'urgente') 
                                        bg-gradient-to-r from-red-500 to-rose-600 text-white
                                    @elseif($incident->priorite == 'haute') 
                                        bg-gradient-to-r from-yellow-500 to-amber-600 text-white
                                    @elseif($incident->priorite == 'moyenne') 
                                        bg-gradient-to-r from-blue-500 to-indigo-600 text-white
                                    @else 
                                        bg-gradient-to-r from-gray-500 to-gray-600 text-white
                                    @endif">
                                    {{ ucfirst($incident->priorite) }}
                                </span>
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Signalé le:
                            </span>
                            <span class="ml-6">{{ $incident->date_signalement->format('d/m/Y à H:i') }}</span>
                        </p>
                    </div>
                </div>

                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                    {{ Str::limit($incident->description, 150) }}
                </p>

                <a href="{{ route('incidents.show', $incident) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Voir détails
                </a>
            </div>
        </div>
        @endforeach

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
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
