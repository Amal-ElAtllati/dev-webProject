<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ressources Disponibles') }}
            </h2>
            
            @if(Auth::user()->role === 'responsable' || Auth::user()->role === 'admin')
                <button 
                    type="button"
                    onclick="openAddResourceModal()"
                    class="text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105"
                    style="background-color: #22c55e !important; color: #ffffff !important;"
                    onmouseover="this.style.backgroundColor='#16a34a'"
                    onmouseout="this.style.backgroundColor='#22c55e'">
                    <span style="color: #ffffff !important;">➕</span>
                    <span style="color: #ffffff !important;">Ajouter une ressource</span>
                </button>
            @endif
        </div>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative animate-fade-in" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate-fade-in" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($resources->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($resources as $resource)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold">
    <a href="{{ route('resources.show', $resource->id) }}" class="hover:text-blue-500">
        {{ $resource->nom }}
    </a>
</h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($resource->etat === 'disponible') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($resource->etat === 'maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        @if($resource->etat === 'disponible') ✅
                                        @elseif($resource->etat === 'maintenance') 🔧
                                        @else ❌
                                        @endif
                                        {{ ucfirst($resource->etat) }}
                                    </span>
                                </div>

                                @if($resource->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                        {{ $resource->description }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-4 text-sm">
                                    @if($resource->category)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">📁</span>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $resource->category->name }}</span>
                                        </div>
                                    @endif
                                    @if($resource->cpu)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">⚡</span>
                                            <span class="text-gray-600 dark:text-gray-400">CPU: {{ $resource->cpu }}</span>
                                        </div>
                                    @endif
                                    @if($resource->ram)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">💾</span>
                                            <span class="text-gray-600 dark:text-gray-400">RAM: {{ $resource->ram }} GB</span>
                                        </div>
                                    @endif
                                    @if($resource->capacite)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">💿</span>
                                            <span class="text-gray-600 dark:text-gray-400">Capacité: {{ $resource->capacite }} GB</span>
                                        </div>
                                    @endif
                                    @if($resource->os)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">🖥️</span>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $resource->os }}</span>
                                        </div>
                                    @endif
                                    @if($resource->responsable)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-500 dark:text-gray-400">👤</span>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $resource->responsable->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Management Buttons for Responsable/Admin ONLY -->
                                @if((Auth::user()->role === 'responsable' && $resource->responsable_id === Auth::id()) || Auth::user()->role === 'admin')
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2 uppercase tracking-wide">Gestion:</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            <button 
                                                onclick="openEditModal({{ $resource->id }}, '{{ $resource->nom }}', '{{ $resource->description }}', {{ $resource->cpu ?? 'null' }}, {{ $resource->ram ?? 'null' }}, {{ $resource->capacite ?? 'null' }}, '{{ $resource->os }}', {{ $resource->categorie_id }}, {{ $resource->responsable_id }})"
                                                class="text-xs bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-800 dark:text-blue-200 font-semibold py-2 px-3 rounded transition transform hover:scale-105">
                                                ✏️ Modifier
                                            </button>
                                            
                                            @if($resource->etat !== 'maintenance')
                                                <button 
                                                    onclick="openMaintenanceModal({{ $resource->id }}, '{{ $resource->nom }}')"
                                                    class="text-xs bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800 text-yellow-800 dark:text-yellow-200 font-semibold py-2 px-3 rounded transition transform hover:scale-105">
                                                    🔧 Maintenance
                                                </button>
                                            @else
                                                <button 
                                                    onclick="activateResource({{ $resource->id }}, '{{ $resource->nom }}')"
                                                    class="text-xs bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-800 dark:text-green-200 font-semibold py-2 px-3 rounded transition transform hover:scale-105">
                                                    ✅ Activer
                                                </button>
                                            @endif
                                            
                                            @if($resource->etat !== 'desactive')
                                                <button 
                                                    onclick="openDisableModal({{ $resource->id }}, '{{ $resource->nom }}')"
                                                    class="col-span-2 text-xs bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-800 dark:text-red-200 font-semibold py-2 px-3 rounded transition transform hover:scale-105">
                                                    ❌ Désactiver
                                                </button>
                                            @else
                                                <button 
                                                    onclick="activateResource({{ $resource->id }}, '{{ $resource->nom }}')"
                                                    class="col-span-2 text-xs bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-800 dark:text-green-200 font-semibold py-2 px-3 rounded transition transform hover:scale-105">
                                                    ✅ Réactiver
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Reserve Button for Users and Responsable (when resource is available) - NOT for Admin -->
                                @if($resource->etat === 'disponible' && Auth::user()->role !== 'admin')
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                        <button 
                                            type="button"
                                            onclick="openReservationModal({{ $resource->id }}, '{{ addslashes($resource->nom ?? '') }}')"
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200" 
                                            style="background: linear-gradient(to right, #60a5fa, #3b82f6) !important; background-color: #3b82f6 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important; color: #ffffff !important; border: none !important;"
                                            onmouseover="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.backgroundColor='#2563eb';"
                                            onmouseout="this.style.background='linear-gradient(to right, #60a5fa, #3b82f6)'; this.style.backgroundColor='#3b82f6';">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span style="color: #ffffff !important;">Réserver cette ressource</span>
                                        </button>
                                    </div>
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

    @php
        $categories = \App\Models\ResourceCategory::all();
        $responsables = \App\Models\User::where('role', 'responsable')->get();
    @endphp

    <!-- Modal: Ajouter Ressource -->
    <div id="addResourceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-2xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 mb-10">
            <div class="sticky top-0 bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 px-6 py-4 rounded-t-2xl flex justify-between items-center shadow-lg" style="background: linear-gradient(to right, #22c55e, #16a34a, #10b981) !important;">
                <h3 class="text-xl font-bold text-white flex items-center" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3) !important; color: #ffffff !important;">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter une nouvelle ressource
                </h3>
                <button onclick="closeAddResourceModal()" class="text-white hover:text-gray-100 transition-colors" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('resources.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nom" required
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="Ex: Serveur Web 01">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Description détaillée de la ressource..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select name="categorie_id" required
                                class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option value="">Sélectionner...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Responsable <span class="text-red-500">*</span>
                        </label>
                        <select name="responsable_id" required
                                class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            @if(Auth::user()->role === 'admin')
                                <option value="">Sélectionner...</option>
                                @foreach($responsables as $resp)
                                    <option value="{{ $resp->id }}">{{ $resp->name }}</option>
                                @endforeach
                            @else
                                <option value="{{ Auth::id() }}" selected>{{ Auth::user()->name }}</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            CPU (cores)
                        </label>
                        <input type="number" name="cpu" min="1"
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="Ex: 8">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            RAM (GB)
                        </label>
                        <input type="number" name="ram" min="1"
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="Ex: 32">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Capacité (GB)
                        </label>
                        <input type="number" name="capacite" min="1"
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="Ex: 500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Système d'exploitation
                        </label>
                        <input type="text" name="os"
                               class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="Ex: Ubuntu Server 22.04">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="closeAddResourceModal()"
                            class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-green-500 via-green-600 to-emerald-600 hover:from-green-600 hover:via-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3); background: linear-gradient(to right, #22c55e, #16a34a, #10b981) !important;">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Modifier Ressource -->
    <div id="editResourceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        ✏️ Modifier la ressource
                    </h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editResourceForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="edit_nom" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="edit_description" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <select name="categorie_id" id="edit_categorie_id" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Responsable <span class="text-red-500">*</span>
                            </label>
                            <select name="responsable_id" id="edit_responsable_id" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                                @foreach($responsables as $resp)
                                    <option value="{{ $resp->id }}">{{ $resp->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                CPU (cores)
                            </label>
                            <input type="number" name="cpu" id="edit_cpu" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                RAM (GB)
                            </label>
                            <input type="number" name="ram" id="edit_ram" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Capacité (GB)
                            </label>
                            <input type="number" name="capacite" id="edit_capacite" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Système d'exploitation
                            </label>
                            <input type="text" name="os" id="edit_os"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded transition">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition">
                            ✅ Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Maintenance -->
    <div id="maintenanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        🔧 Mettre en maintenance
                    </h3>
                    <button onclick="closeMaintenanceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    Ressource: <strong id="maintenance_resource_name"></strong>
                </p>

                <form id="maintenanceForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="etat" value="maintenance">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Raison de la maintenance (optionnel)
                        </label>
                        <textarea name="raison" rows="3" placeholder="Ex: Mise à jour système, réparation matérielle..."
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeMaintenanceModal()"
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded transition">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded transition">
                            🔧 Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Désactiver -->
    <div id="disableModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        ❌ Désactiver la ressource
                    </h3>
                    <button onclick="closeDisableModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    Ressource: <strong id="disable_resource_name"></strong>
                </p>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded p-3 mb-4">
                    <p class="text-sm text-red-700 dark:text-red-300">
                        ⚠️ Cette ressource ne sera plus disponible pour réservation.
                    </p>
                </div>

                <form id="disableForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="etat" value="desactive">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Raison de la désactivation (optionnel)
                        </label>
                        <textarea name="raison" rows="3" placeholder="Ex: Ressource obsolète, fin de vie..."
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-100"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeDisableModal()"
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded transition">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded transition">
                            ❌ Désactiver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reservation Modal -->
    <div id="reservationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-md shadow-2xl rounded-2xl bg-white dark:bg-gray-800 mb-10">
            <div class="sticky top-0 bg-gradient-to-r from-blue-800 via-blue-900 to-indigo-900 px-6 py-4 rounded-t-2xl flex justify-between items-center shadow-lg" style="background: linear-gradient(to right, #1e3a8a, #1e40af, #3730a3) !important;">
                <h3 class="text-xl font-bold text-white flex items-center" style="text-shadow: 0 2px 6px rgba(0,0,0,0.5), 0 0 2px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Réserver: <span id="modalResourceName" class="ml-2"></span>
                </h3>
                <button onclick="closeReservationModal()" class="text-white hover:text-gray-100 transition-colors" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5) !important; color: #ffffff !important;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="reservationForm" method="POST" action="" class="p-6">
                @csrf
                <div class="mb-6">
                    <label for="date_debut" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="date_debut" name="date_debut" required
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div class="mb-6">
                    <label for="date_fin" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="date_fin" name="date_fin" required
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="closeReservationModal()"
                            class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" 
                            style="background: linear-gradient(to right, #60a5fa, #3b82f6) !important; background-color: #3b82f6 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important; color: #ffffff !important; border: none !important;"
                            onmouseover="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.backgroundColor='#2563eb';"
                            onmouseout="this.style.background='linear-gradient(to right, #60a5fa, #3b82f6)'; this.style.backgroundColor='#3b82f6';">
                        Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        // Add Resource Modal
        function openAddResourceModal() {
            const modal = document.getElementById('addResourceModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeAddResourceModal() {
            const modal = document.getElementById('addResourceModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        
        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addResourceModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeAddResourceModal();
                    }
                });
            }
        });

        // Edit Resource Modal
        function openEditModal(id, nom, description, cpu, ram, capacite, os, categorie_id, responsable_id) {
            document.getElementById('edit_nom').value = nom;
            document.getElementById('edit_description').value = description || '';
            document.getElementById('edit_cpu').value = cpu || '';
            document.getElementById('edit_ram').value = ram || '';
            document.getElementById('edit_capacite').value = capacite || '';
            document.getElementById('edit_os').value = os || '';
            document.getElementById('edit_categorie_id').value = categorie_id;
            document.getElementById('edit_responsable_id').value = responsable_id;
            
            document.getElementById('editResourceForm').action = '{{ route("resources.update", ":id") }}'.replace(':id', id);
            document.getElementById('editResourceModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editResourceModal').classList.add('hidden');
        }

        // Maintenance Modal
        function openMaintenanceModal(id, nom) {
            document.getElementById('maintenance_resource_name').textContent = nom;
            document.getElementById('maintenanceForm').action = '{{ route("resources.change-etat", ":id") }}'.replace(':id', id);
            document.getElementById('maintenanceModal').classList.remove('hidden');
        }
        function closeMaintenanceModal() {
            document.getElementById('maintenanceModal').classList.add('hidden');
        }

        // Disable Modal
        function openDisableModal(id, nom) {
            document.getElementById('disable_resource_name').textContent = nom;
            document.getElementById('disableForm').action = '{{ route("resources.change-etat", ":id") }}'.replace(':id', id);
            document.getElementById('disableModal').classList.remove('hidden');
        }
        function closeDisableModal() {
            document.getElementById('disableModal').classList.add('hidden');
        }

        // Activate Resource (direct form submission)
        function activateResource(id, nom) {
            if(confirm('Activer la ressource "' + nom + '"?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("resources.change-etat", ":id") }}'.replace(':id', id);
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                
                const etat = document.createElement('input');
                etat.type = 'hidden';
                etat.name = 'etat';
                etat.value = 'disponible';
                
                form.appendChild(csrf);
                form.appendChild(etat);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Reservation Modal
        function openReservationModal(resourceId, resourceName) {
            const modal = document.getElementById('reservationModal');
            const form = document.getElementById('reservationForm');
            const nameElement = document.getElementById('modalResourceName');
            
            if (!modal || !form || !nameElement) {
                console.error('Reservation modal elements not found');
                return;
            }
            
            nameElement.textContent = resourceName || 'Ressource';
            form.action = '{{ route("reservations.quick", ":id") }}'.replace(':id', resourceId);
            modal.classList.remove('hidden');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            const startDateInput = document.getElementById('date_debut');
            const endDateInput = document.getElementById('date_fin');
            
            if (startDateInput && endDateInput) {
                // Remove existing listeners to avoid duplicates
                const newStartInput = startDateInput.cloneNode(true);
                startDateInput.parentNode.replaceChild(newStartInput, startDateInput);
                
                document.getElementById('date_debut').addEventListener('change', function() {
                    const endInput = document.getElementById('date_fin');
                    if (endInput && this.value) {
                        endInput.min = this.value;
                        if (endInput.value && endInput.value < this.value) {
                            endInput.value = '';
                        }
                    }
                });
            }
        }
        
        function closeReservationModal() {
            const modal = document.getElementById('reservationModal');
            const form = document.getElementById('reservationForm');
            
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
            
            if (form) {
                form.reset();
            }
        }

        // Close modals on outside click
        document.addEventListener('DOMContentLoaded', function() {
            ['addResourceModal', 'editResourceModal', 'maintenanceModal', 'disableModal', 'reservationModal'].forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            this.classList.add('hidden');
                            this.style.display = 'none';
                            document.body.style.overflow = '';
                        }
                    });
                }
            });
        });
    </script>
    </x-slot>
</x-app-layout>

