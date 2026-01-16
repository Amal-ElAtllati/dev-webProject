<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom right, #e0f2fe, #bfdbfe, #93c5fd);">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo/Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #2563eb;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-4xl font-extrabold mb-2" style="color: #1e40af;">
                Connexion
            </h2>
            <p class="text-lg" style="color: #475569;">
                Gestion des Ressources IT
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <strong class="font-bold">Erreur:</strong>
                    <span class="block sm:inline">Les identifiants sont incorrects.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="votre@email.com"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 transition duration-150"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mot de passe
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 transition duration-150"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        type="checkbox" 
                        name="remember"
                        class="h-4 w-4 border-gray-300 rounded"
                        style="accent-color: #3b82f6;"
                    />
                    <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Se souvenir de moi
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105 shadow-lg" style="background: linear-gradient(to right, #60a5fa, #3b82f6);" onmouseover="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'" onmouseout="this.style.background='linear-gradient(to right, #60a5fa, #3b82f6)'">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white opacity-80 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="text-center space-y-2">
                <a href="{{ route('register') }}" class="text-sm font-medium transition-colors" style="color: #3b82f6;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#3b82f6'">
                    Pas encore de compte ? S'inscrire
                </a>
                <div>
                    <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                        ← Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
