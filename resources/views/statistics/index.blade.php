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

                    <!-- Resources Pie Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">État des Ressources</h3>
                            <div class="flex justify-center items-center" style="min-height: 250px;">
                                <canvas id="resourcesChart" style="max-width: 300px; max-height: 300px;"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_resources'] }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Reservations Bar Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">Statut des Réservations</h3>
                            <div class="flex justify-center items-center" style="min-height: 300px;">
                                <canvas id="reservationsChart" style="max-width: 100%; max-height: 300px;"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_reservations'] }}</span></p>
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
                    <!-- Resources Pie Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">État de mes Ressources</h3>
                            <div class="flex justify-center items-center" style="min-height: 250px;">
                                <canvas id="resourcesChart" style="max-width: 300px; max-height: 300px;"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['my_resources'] }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Reservations Bar Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">Statut des Réservations</h3>
                            <div class="flex justify-center items-center" style="min-height: 300px;">
                                <canvas id="reservationsChart" style="max-width: 100%; max-height: 300px;"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_reservations'] }}</span></p>
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
                    <!-- Reservations Bar Chart -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 text-center">Statut de mes Réservations</h3>
                            <div class="flex justify-center items-center" style="min-height: 300px;">
                                <canvas id="reservationsChart" style="max-width: 100%; max-height: 300px;"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $stats['my_reservations'] }}</span></p>
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

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Resources Chart
    @if(isset($stats['resource_states_data']) && !empty($stats['resource_states_data']['data']))
    const resourcesCtx = document.getElementById('resourcesChart');
    if (resourcesCtx) {
        new Chart(resourcesCtx, {
            type: 'pie',
            data: {
                labels: @json($stats['resource_states_data']['labels']),
                datasets: [{
                    data: @json($stats['resource_states_data']['data']),
                    backgroundColor: @json($stats['resource_states_data']['colors']),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                label += context.parsed + ' (' + percentage + '%)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
    @endif

    // Reservations Bar Chart
    @if(isset($stats['reservation_status_data']) && !empty($stats['reservation_status_data']['data']))
    const reservationsCtx = document.getElementById('reservationsChart');
    if (reservationsCtx) {
        new Chart(reservationsCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['reservation_status_data']['labels']),
                datasets: [{
                    label: 'Nombre de réservations',
                    data: @json($stats['reservation_status_data']['data']),
                    backgroundColor: @json($stats['reservation_status_data']['colors']),
                    borderColor: @json($stats['reservation_status_data']['colors']),
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                                label += context.parsed.y + ' (' + percentage + '%)';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    @endif
</script>
@endsection

