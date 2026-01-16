@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('incidents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                <h4 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Détails de l'incident
                </h4>
                <span class="px-4 py-2 text-sm font-semibold rounded-full shadow-sm
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

            <!-- Card Body -->
            <div class="p-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ $incident->titre }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-3">
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-1-3M15 13h-6M5 17H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-1" />
                                </svg>
                                Ressource:
                            </span>
                            <span class="ml-7">{{ $incident->resource->nom ?? 'N/A' }}</span>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Type:
                            </span>
                            <span class="ml-7">{{ ucfirst($incident->type) }}</span>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Priorité:
                            </span>
                            <span class="ml-7">
                                <span class="px-3 py-1.5 text-xs font-semibold rounded-full
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
                    </div>
                    <div class="space-y-3">
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Signalé par:
                            </span>
                            <span class="ml-7">{{ $incident->user->name }}</span>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date de signalement:
                            </span>
                            <span class="ml-7">{{ $incident->date_signalement->format('d/m/Y à H:i') }}</span>
                        </p>
                        @if($incident->date_resolution)
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Date de résolution:
                                </span>
                                <span class="ml-7">{{ $incident->date_resolution->format('d/m/Y à H:i') }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Description:
                    </h5>
                    <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/50">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $incident->description }}</p>
                    </div>
                </div>

                @if($incident->fichiers && count($incident->fichiers) > 0)
                    <div class="mb-6">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Fichiers joints:
                        </h5>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($incident->fichiers as $fichier)
                                <div>
                                    @if(Str::endsWith($fichier, '.pdf'))
                                        <a href="{{ asset('storage/' . $fichier) }}" target="_blank" class="block p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-all text-center">
                                            <svg class="w-12 h-12 mx-auto text-red-600 dark:text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs font-semibold text-red-600 dark:text-red-400">PDF</span>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $fichier) }}" target="_blank" class="block rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all">
                                            <img src="{{ asset('storage/' . $fichier) }}" alt="Photo" class="w-full h-32 object-cover">
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($incident->reponse_admin)
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h5 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Réponse de l'administrateur:
                        </h5>
                        <p class="text-blue-800 dark:text-blue-200 whitespace-pre-wrap">{{ $incident->reponse_admin }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
