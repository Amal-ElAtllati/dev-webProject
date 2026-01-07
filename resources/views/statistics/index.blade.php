@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-3xl font-bold mb-6">Statistiques</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Statistics -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Utilisateurs</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_users'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Actifs:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['active_users'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ressources</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_resources'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Disponibles:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['available_resources'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">En attente:</span>
                                    <span class="font-semibold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Approuvées:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['approved_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Rejetées:</span>
                                    <span class="font-semibold text-red-600 dark:text-red-400">{{ $stats['rejected_reservations'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations (Ce Mois)</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Ce mois:</span>
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $stats['reservations_this_month'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Cette semaine:</span>
                                    <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $stats['reservations_this_week'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif(auth()->user()->role === 'responsable')
                    <!-- Responsable Statistics -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Mes Ressources</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['my_resources'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Disponibles:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['available_resources'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">En attente:</span>
                                    <span class="font-semibold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Approuvées:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['approved_reservations'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations (Ce Mois)</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Ce mois:</span>
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $stats['reservations_this_month'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Cette semaine:</span>
                                    <span class="font-semibold text-purple-600 dark:text-purple-400">{{ $stats['reservations_this_week'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- User Statistics -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Mes Réservations</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['my_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">En attente:</span>
                                    <span class="font-semibold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Approuvées:</span>
                                    <span class="font-semibold text-green-600 dark:text-green-400">{{ $stats['approved_reservations'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Rejetées:</span>
                                    <span class="font-semibold text-red-600 dark:text-red-400">{{ $stats['rejected_reservations'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations (Ce Mois)</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Ce mois:</span>
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $stats['reservations_this_month'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(isset($stats['reservations_by_month']) && $stats['reservations_by_month']->count() > 0)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Réservations par mois</h3>
                        <div class="space-y-2">
                            @foreach($stats['reservations_by_month'] as $monthData)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::create($monthData->year, $monthData->month, 1)->format('F Y') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $monthData->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stats['resources_by_category']) && $stats['resources_by_category']->count() > 0)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ressources par catégorie</h3>
                        <div class="space-y-2">
                            @foreach($stats['resources_by_category'] as $categoryData)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $categoryData->category_name }}</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $categoryData->count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

