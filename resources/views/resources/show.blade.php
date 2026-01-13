@extends('layouts.app') @content
<div class="py-12 bg-gray-900 min-h-screen text-white">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h2 class="text-3xl font-bold mb-4">{{ $resource->nom }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-400"><strong>Type:</strong> {{ $resource->type }}</p>
                    <p class="text-gray-400"><strong>État:</strong> 
                        <span class="px-2 py-1 rounded text-xs {{ $resource->etat == 'disponible' ? 'bg-green-500' : 'bg-orange-500' }}">
                            {{ $resource->etat }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-400"><strong>Description:</strong> {{ $resource->description }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-6 border-b border-gray-700 pb-2">🗨️ Espace de Discussion & Modération</h3>

            <div class="space-y-4 mb-8">
                @forelse($resource->comments as $comment)
                    <div class="p-4 bg-gray-700 rounded-lg relative">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-blue-400">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-200">{{ $comment->content }}</p>

                        @if(auth()->user()->role == 'admin' || auth()->id() == $resource->responsable_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2 text-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 text-xs hover:text-red-600 underline">
                                    🗑️ Supprimer ce message (Modérer)
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Aucun message pour le moment. Signalez un incident si besoin.</p>
                @endforelse
            </div>

            <form action="{{ route('comments.store', $resource->id) }}" method="POST" class="mt-6 border-t border-gray-700 pt-6">
                @csrf
                <label class="block text-sm font-medium mb-2">Nouveau message / Signalement :</label>
                <textarea name="content" rows="3" required
                    class="w-full bg-gray-900 border-gray-600 rounded-lg text-white p-3 focus:ring-blue-500"
                    placeholder="Décrivez l'incident ou posez une question..."></textarea>
                <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Envoyer le message
                </button>
            </form>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('resources.index') }}" class="text-gray-400 hover:text-white">← Retour à la liste</a>
        </div>
    </div>
</div>
@endcontent