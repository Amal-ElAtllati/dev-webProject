<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Resource Management') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .resource-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .resource-card:hover {
            transform: translateY(-5px);
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-disponible {
            background: #10b981;
            color: white;
        }
        .rule-card {
            padding: 1rem;
            border-radius: 8px;
            background: #88abf0ff;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 min-h-screen py-12 px-4 sm:px-6 lg:px-8">

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 mb-8">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg mb-4">
                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-2">
                Resource Management
            </h1>

            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Gérez vos ressources informatiques efficacement
            </p>
        </div>
    </div>

    <!-- Resources -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
            📦 Ressources Disponibles
        </h2>

        @php
            $publicResources = \App\Models\Resource::where('etat', 'disponible')
                                ->latest()
                                ->limit(12)
                                ->get();
        @endphp

        @if($publicResources->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($publicResources as $resource)
                    <div class="resource-card">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            {{ $resource->nom }}
                        </h3>

                        <p class="text-gray-600 mb-1">
                            <strong>Type :</strong> {{ ucfirst($resource->type) }}
                        </p>

                        @if($resource->cpu)
                            <p class="text-gray-600 mb-1">
                                <strong>CPU :</strong> {{ $resource->cpu }} cores
                            </p>
                        @endif

                        @if($resource->ram)
                            <p class="text-gray-600 mb-1">
                                <strong>RAM :</strong> {{ $resource->ram }} GB
                            </p>
                        @endif

                        @if($resource->stockage)
                            <p class="text-gray-600 mb-1">
                                <strong>Stockage :</strong> {{ $resource->stockage }} GB
                            </p>
                        @endif

                        <div class="mt-3">
                            <span class="status-badge status-disponible">
                                ✓ Disponible
                            </span>
                        </div>

                        <!-- Bouton Voir détails -->
                        <button
                            onclick="toggleDetails(this)"
                            class="mt-4 w-full px-4 py-2 rounded-lg
                                   bg-gradient-to-r from-purple-600 to-pink-600
                                   text-white font-semibold
                                   hover:from-purple-700 hover:to-pink-700
                                   transition-all duration-200"
                        >
                            Voir détails
                        </button>

                        <!-- Détails supplémentaires cachés -->
                        <div class="extra-details mt-4 text-gray-700" style="display: none;">
                            <p><strong>Catégorie :</strong> {{ $resource->category->nom ?? '—' }}</p>
                            <p><strong>OS :</strong> {{ $resource->os ?? '—' }}</p>
                            <p><strong>Capacité :</strong> {{ $resource->capacite ?? '—' }}</p>
                            <p><strong>Responsable :</strong> {{ $resource->responsable->name ?? '—' }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <p class="text-center text-gray-600 dark:text-gray-400 py-8">
                Aucune ressource disponible pour le moment
            </p>
        @endif

        <p class="text-center text-gray-700 dark:text-gray-300 text-lg mt-8">
            🔐 Connectez-vous pour réserver vos ressources
        </p>
    </div>

    <!-- Règles d'utilisation -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
            📜 Règles d'utilisation des ressources
        </h2>

        <div class="space-y-4 max-w-3xl mx-auto text-gray-700 dark:text-gray-300">
            <div class="rule-card">
                Utiliser les ressources uniquement pour des projets internes.
            </div>
            <div class="rule-card">
                Réserver les ressources à l'avance via le système de réservation.
            </div>
            <div class="rule-card">
                Ne pas modifier la configuration des ressources sans autorisation.
            </div>
            <div class="rule-card">
                Signaler immédiatement tout problème ou panne.
            </div>
            <div class="rule-card">
               Libérer les ressources après utilisation.
            </div>
        </div>
    </div>

    <!-- Auth -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
         @auth
            <div class="text-center space-y-4">
                <p class="text-gray-700 dark:text-gray-300 text-lg">
                    Bienvenue,
                    <strong class="text-purple-600 dark:text-purple-400">
                        {{ Auth::user()->name }}
                    </strong>
                </p>

                <a href="{{ route('dashboard.' . Auth::user()->role) }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3
                          rounded-lg text-white font-medium
                          bg-gradient-to-r from-purple-600 to-pink-600
                          hover:scale-105 transition shadow-lg">
                   Accéder au Dashboard
                </a>
            </div>
         @else
            <div class="space-y-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3
                          rounded-lg text-white font-medium
                          bg-gradient-to-r from-purple-600 to-pink-600
                          hover:scale-105 transition shadow-lg">
                🔑 Se connecter
                </a>

                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3
                          rounded-lg border-2 border-purple-600
                          text-purple-600 font-medium
                          hover:bg-purple-50 transition">
                Demande d'ouverture de compte
                </a>
            </div>
         @endauth
    </div>

</div>

<!-- JS pour toggle détails -->
<script>
    function toggleDetails(button) {
        const card = button.parentElement;
        const details = card.querySelector('.extra-details');

        if (details.style.display === 'none' || details.style.display === '') {
            details.style.display = 'block';
            button.textContent = 'Cacher détails';
        } else {
            details.style.display = 'none';
            button.textContent = 'Voir détails';
        }
    }
</script>



</body>
</html>