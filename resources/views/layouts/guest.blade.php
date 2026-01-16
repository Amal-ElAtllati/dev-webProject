<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestion Ressources') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo / Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4">
                <svg class="h-12 w-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-white">Gestion des Ressources</h2>
        </div>

        <!-- Card Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white/80 text-sm">
                &copy; {{ date('Y') }} Gestion Ressources. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>