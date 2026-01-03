<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th>Ressource</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res)
                            <tr>
                                <td>{{ $res->resource->nom }}</td>
                                <td>{{ $res->date_debut }}</td>
                                <td>{{ $res->date_fin }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>