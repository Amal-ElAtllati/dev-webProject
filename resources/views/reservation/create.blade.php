@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-2xl font-bold mb-6 text-center">Créer une réservation</h1>

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reservations.store') }}" method="POST" class="max-w-2xl mx-auto">
                @csrf
                
                <div class="mb-4">
                    <label for="resource_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Ressource:
                    </label>
                    <select name="resource_id" id="resource_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Sélectionner une ressource</option>
                        @foreach($resources as $r)
                            <option value="{{ $r->id }}">{{ $r->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date de début:
                    </label>
                    <input type="datetime-local" 
                           name="date_debut" 
                           id="date_debut" 
                           required
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                </div>

                <div class="mb-4">
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date de fin:
                    </label>
                    <input type="datetime-local" 
                           name="date_fin" 
                           id="date_fin" 
                           required
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                </div>

                <div class="mb-6">
                    <label for="justification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Justification:
                    </label>
                    <textarea name="justification" 
                              id="justification" 
                              required 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                              placeholder="Expliquez la raison de cette réservation..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('reservations.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded transition duration-200">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition duration-200">
                        Réserver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set minimum date for end date based on start date
    const startDateInput = document.getElementById('date_debut');
    const endDateInput = document.getElementById('date_fin');
    
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = '';
        }
    });
</script>
@endsection
