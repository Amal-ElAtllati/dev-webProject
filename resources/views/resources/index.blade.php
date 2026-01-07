
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ressources Disponibles') }}
        </h2>
    

    

    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($resources->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($resources as $resource)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $resource->nom }}
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($resource->etat === 'disponible') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($resource->etat === 'maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        {{ ucfirst($resource->etat) }}
                                    </span>
                                </div>

                                @if($resource->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        {{ $resource->description }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-4">
                                    @if($resource->category)
    <p class="text-sm text-gray-600 dark:text-gray-400">
        <span class="font-medium">Catégorie:</span> {{ $resource->category->nom }}
    </p>
@endif
                                    @if($resource->cpu)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">CPU:</span> {{ $resource->cpu }}
                                        </p>
                                    @endif
                                    @if($resource->ram)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">RAM:</span> {{ $resource->ram }} GB
                                        </p>
                                    @endif
                                    @if($resource->capacite)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">Capacité:</span> {{ $resource->capacite }} GB
                                        </p>
                                    @endif
                                    @if($resource->os)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">OS:</span> {{ $resource->os }}
                                        </p>
                                    @endif
                                    @if($resource->responsable)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">Responsable:</span> {{ $resource->responsable->name }}
                                        </p>
                                    @endif
                                </div>

                                @if($resource->etat === 'disponible')
                                    <button 
                                        onclick="openReservationModal({{ $resource->id }}, '{{ $resource->nom }}')"
                                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                        Réserver
                                    </button>
                                @else
                                    <button 
                                        disabled
                                        class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed">
                                        Non disponible
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <p class="text-lg mb-4">Aucune ressource disponible</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Il n'y a actuellement aucune ressource disponible pour réservation.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Reservation Modal -->
    <div id="reservationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Réserver: <span id="modalResourceName"></span>
                    </h3>
                    <button onclick="closeReservationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="reservationForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de début
                        </label>
                        <input 
                            type="datetime-local" 
                            id="date_debut" 
                            name="date_debut" 
                            required
                            min="{{ date('Y-m-d\TH:i') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date de fin
                        </label>
                        <input 
                            type="datetime-local" 
                            id="date_fin" 
                            name="date_fin" 
                            required
                            min="{{ date('Y-m-d\TH:i') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button 
                            type="button"
                            onclick="closeReservationModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded transition duration-200">
                            Annuler
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-medium rounded transition duration-200">
                            Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openReservationModal(resourceId, resourceName) {
            document.getElementById('modalResourceName').textContent = resourceName;
            document.getElementById('reservationForm').action = '{{ route("reservations.quick", ":id") }}'.replace(':id', resourceId);
            document.getElementById('reservationModal').classList.remove('hidden');
            
            // Set minimum date for end date based on start date
            const startDateInput = document.getElementById('date_debut');
            const endDateInput = document.getElementById('date_fin');
            
            startDateInput.addEventListener('change', function() {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    endDateInput.value = '';
                }
            });
        }

        function closeReservationModal() {
            document.getElementById('reservationModal').classList.add('hidden');
            document.getElementById('reservationForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('reservationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReservationModal();
            }
        });
    </script>
        </x-slot>

</x-app-layout>

