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
                        Vous êtes connecté en tant qu'<strong class="text-red-600 dark:text-red-400">administrateur</strong>
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        👑
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border-l-4 border-yellow-500 rounded-lg p-4 mt-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Rôle</span>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Administrateur</p>
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
                Depuis ce tableau de bord, vous avez un accès complet à la gestion du système.
            </p>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Gestion Utilisateurs -->
        <a href="{{ route('admin.users.index') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center group-hover:bg-red-200 dark:group-hover:bg-red-900/50 transition-colors">
                            <span class="text-2xl">👥</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Utilisateurs</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gestion</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Réservations -->
        <a href="{{ route('reservations.admin') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                            <span class="text-2xl">📋</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Réservations</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gérer</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Ressources -->
        <a href="{{ route('resources.index') }}" 
           class="group bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center group-hover:bg-cyan-200 dark:group-hover:bg-cyan-900/50 transition-colors">
                            <span class="text-2xl">🖥️</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ressources</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gestion</p>
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
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                            <span class="text-2xl">📊</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Statistiques</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Analyses</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
