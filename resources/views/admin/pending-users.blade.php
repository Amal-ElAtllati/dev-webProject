@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">
        ⏳ Demandes d'inscription en attente
    </h1>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nom
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Date demande
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Message
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[200px]">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($pendingUsers as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                            <span class="block text-xs text-gray-400">
                                {{ $user->created_at->diffForHumans() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->request_message ?? 'Aucun message' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <!-- Bouton Approuver -->
                                <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir approuver cet utilisateur ?')"
                                            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md shadow-sm hover:shadow-md transition-all whitespace-nowrap min-w-[100px]">
                                        ✓ Approuver
                                    </button>
                                </form>
                                
                                <!-- Bouton Rejeter -->
                                <form action="{{ route('admin.users.reject', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet utilisateur ?')"
                                            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md shadow-sm hover:shadow-md transition-all whitespace-nowrap min-w-[100px]">
                                        ✗ Rejeter
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                                    Aucune demande en attente
                                </p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">
                                    Toutes les demandes ont été traitées
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistiques -->
    @if($pendingUsers->count() > 0)
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-blue-700 dark:text-blue-300 font-medium">
                    {{ $pendingUsers->count() }} demande(s) en attente de traitement
                </p>
            </div>
        </div>
    @endif
</div>
@endsection
