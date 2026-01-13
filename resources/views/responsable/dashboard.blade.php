@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <span class="sr-only">Fermer</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Welcome Card -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Bienvenue, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Vous êtes connecté en tant que <strong class="text-green-600 dark:text-green-400">Responsable Technique</strong>
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        ⚙️
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 border-l-4 border-cyan-500 rounded-lg p-4 mt-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Rôle</span>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Responsable Technique</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Email</span>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Statut</span>
                        <p class="text-lg font-semibold text-green-600 dark:text-green-400">Actif</p>
                    </div>
                </div>
            </div>

            <p class="text-gray-600 dark:text-gray-400 mt-6">
                Depuis ce tableau de bord, vous pouvez gérer vos ressources IT et les réservations qui vous sont assignées.
            </p>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        


    </div>

    <!-- Demandes Récentes Section -->
    @if(isset($recentReservations) && $recentReservations->count() > 0)
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    📋 Demandes Récentes
                </h2>
                <a href="{{ route('reservations.admin') }}" 
                   class="text-sm text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 font-medium">
                    Voir toutes →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Ressource
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Période
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentReservations as $reservation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $reservation->user->name ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $reservation->user->email ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $reservation->resource->nom ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    au {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reservation->status === 'en_attente')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                        En attente
                                    </span>
                                @elseif($reservation->status === 'approuve')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Approuvée
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Refusée
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($reservation->status === 'en_attente')
                                <div class="flex space-x-2">
                                    <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium"
                                                onclick="return confirm('Approuver cette réservation?')">
                                            ✓ Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium"
                                                onclick="return confirm('Refuser cette réservation?')">
                                            ✗ Refuser
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Gérer les Réservations -->
        <a href="{{ route('reservations.admin') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                            <span class="text-2xl">📋</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Réservations</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gérer les demandes</p>
                        </div>
                    </div>
                    @if(($stats['pending_reservations'] ?? 0) > 0)
                    <div class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                        {{ $stats['pending_reservations'] }}
                    </div>
                    @else
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    @endif
                </div>
            </div>
        </a>

        <!-- Mes Ressources -->
        <a href="{{ route('resources.index') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center group-hover:bg-cyan-200 dark:group-hover:bg-cyan-900/50 transition-colors">
                            <span class="text-2xl">🖥️</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Mes Ressources</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stats['my_resources'] ?? 0 }} ressources</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Statistiques -->
        <a href="{{ route('statistics.index') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:bg-purple-200 dark:group-hover:bg-purple-900/50 transition-colors">
                            <span class="text-2xl">📊</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Statistiques</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Analyses détaillées</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

   
@endsection
