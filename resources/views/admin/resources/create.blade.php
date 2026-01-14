@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-3xl font-bold mb-6">➕ Ajouter une Ressource</h1>

            <form action="{{ route('admin.resources.store') }}" method="POST">
                @csrf

                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nom de la ressource <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nom" 
                           name="nom" 
                           required
                           value="{{ old('nom') }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Ex: Serveur Web 01">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Description détaillée de la ressource...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-4">
                    <label for="categorie_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select id="categorie_id" 
                            name="categorie_id" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emplacement -->
                <div class="mb-4">
                    <label for="emplacement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        📍 Emplacement
                    </label>
                    <input type="text" 
                           id="emplacement" 
                           name="emplacement" 
                           value="{{ old('emplacement') }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Ex: Salle Serveur A, Bâtiment 2, Étage 3">
                    @error('emplacement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Caractéristiques Techniques -->
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">⚙️ Caractéristiques Techniques</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- CPU -->
                        <div>
                            <label for="cpu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                💻 CPU (cores)
                            </label>
                            <input type="number" 
                                   id="cpu" 
                                   name="cpu" 
                                   min="1"
                                   value="{{ old('cpu') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: 8">
                            @error('cpu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RAM -->
                        <div>
                            <label for="ram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🧠 RAM (GB)
                            </label>
                            <input type="number" 
                                   id="ram" 
                                   name="ram" 
                                   min="1"
                                   value="{{ old('ram') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: 32">
                            @error('ram')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacité -->
                        <div>
                            <label for="capacite" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                💾 Capacité (GB)
                            </label>
                            <input type="number" 
                                   id="capacite" 
                                   name="capacite" 
                                   min="1"
                                   value="{{ old('capacite') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: 500">
                            @error('capacite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- OS -->
                        <div>
                            <label for="os" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🖥️ Système d'exploitation
                            </label>
                            <input type="text" 
                                   id="os" 
                                   name="os" 
                                   value="{{ old('os') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: Ubuntu Server 22.04">
                            @error('os')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Responsable -->
                <div class="mb-6">
                    <label for="responsable_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        👤 Responsable <span class="text-red-500">*</span>
                    </label>
                    <select id="responsable_id" 
                            name="responsable_id" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Sélectionner un responsable</option>
                        @foreach($responsables as $responsable)
                            <option value="{{ $responsable->id }}" {{ old('responsable_id') == $responsable->id ? 'selected' : '' }}>
                                {{ $responsable->name }} ({{ $responsable->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('responsable_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                        ✅ Ajouter la Ressource
                    </button>
                    <a href="{{ route('admin.resources.index') }}" 
                       class="flex-1 text-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        ❌ Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection