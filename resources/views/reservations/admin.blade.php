@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-3xl font-bold mb-6">Gestion des Réservations</h1>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $user = Auth::user();
                // Logic b7al Controller bach njib l-data
                if ($user->role === 'admin') {
                    $reservations = \App\Models\Reservation::with(['resource', 'user'])->orderBy('created_at', 'desc')->get();
                } else {
                    $resourceIds = \App\Models\Resource::where('responsable_id', $user->id)->pluck('id');
                    $reservations = \App\Models\Reservation::with(['resource', 'user'])->whereIn('resource_id', $resourceIds)->orderBy('created_at', 'desc')->get();
                }
            @endphp

            @if($reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ressource</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($reservations as $res)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium">{{ $res->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $res->user->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $res->resource->nom ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($res->date_debut)->format('d/m/Y H:i') }} <br>
                                        {{ \Carbon\Carbon::parse($res->date_fin)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($res->statut == 'en_attente')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">⏳ En attente</span>
                                        @elseif($res->statut == 'approuve')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✅ Approuvée</span>
                                        @elseif($res->statut == 'refuse')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">❌ Refusée</span>
                                        @endif
                                    </td>
<td class="px-6 py-4">
    @php
        // 1. Kan-7eydo ay espace zayd mn l-jihteyn (trim)
        // 2. Kan-re-ddo koulshi minuscule (strtolower) bach n-tfadaw En_Attente vs en_attente
        $dbStatus = strtolower(trim($res->statut));
    @endphp

    @if($dbStatus === 'en_attente')
        <div class="flex space-x-2">
            <form action="{{ route('reservations.approve', $res->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                    APPROUVER
                </button>
            </form>

            <button type="button" 
                    onclick="openRejectModal({{ $res->id }}, '{{ addslashes($res->user->name) }}', '{{ addslashes($res->resource->nom) }}')" 
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold transition">
                REFUSER
            </button>
        </div>
    @else
        {{-- Hna mli kiy-welli l-statut tbeddel f l-DB, l-boutonnat kiy-ghibro nichan --}}
        <div class="flex flex-col space-y-1">
            @if($dbStatus === 'approuve')
                <span class="text-green-600 font-bold text-xs">✅ DÉJÀ APPROUVÉE</span>
            @elseif($dbStatus === 'refuse')
                <span class="text-red-600 font-bold text-xs">❌ DÉJÀ REFUSÉE</span>
            @else
                <span class="text-gray-400 italic text-xs">Traitée ({{ $dbStatus }})</span>
            @endif
        </div>
    @endif
</td>

                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">Aucune réservation à afficher.</div>
            @endif
        </div>
    </div>
</div>

<div id="rejectModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">❌ Refuser la réservation</h3>
            <button onclick="closeRejectModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded text-sm">
            <p><strong>Utilisateur:</strong> <span id="rejectUserName"></span></p>
            <p><strong>Ressource:</strong> <span id="rejectResourceName"></span></p>
        </div>

        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Justification du refus (min 10 car.)</label>
                <textarea id="justification" name="justification" rows="4" required minlength="10"
                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-900 dark:text-white" 
                    placeholder="Raison du refus..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-gray-600 hover:underline">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700 transition">Confirmer le Refus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id, user, resource) {
        document.getElementById('rejectUserName').textContent = user;
        document.getElementById('rejectResourceName').textContent = resource;
        
        // Dynamic Route
        let url = "{{ route('reservations.reject', ':id') }}";
        document.getElementById('rejectForm').action = url.replace(':id', id);
        
        // Show Modal
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('rejectForm').reset();
    }

    // Close on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target == modal) closeRejectModal();
    }
</script>
@endsection