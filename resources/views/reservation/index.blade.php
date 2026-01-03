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
                       <th>Statut</th> <th>Actions</th> </tr>
                    </thead>
                    <tbody>
                       @foreach($reservations as $res)
                       <tr>
                         <td>{{ $res->resource->nom }}</td>
                         <td>{{ $res->date_debut }}</td>
                         <td>
                           <span class="p-1 rounded {{ $res->status == 'approved' ? 'bg-green-200' : 'bg-yellow-200' }}">
                           {{ $res->status }}
                           </span>
                          </td>
                         <td>
                          @if($res->status == 'pending')
                         <form action="{{ route('reservations.approve', $res->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-green-600">Approuver</button>
                         </form>
                         <form action="{{ route('reservations.reject', $res->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-red-600">Refuser</button>
                         </form>
                           @endif
                         </td>
                     </tr>
                         @endforeach
                 </tbody>
              </table>

            </div>
        </div>
    </div>
</x-app-layout>