<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900">
<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end h-16 items-center space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-gray-700 dark:text-gray-200 hover:text-indigo-500">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600">
                        Zaloguj się
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                        Załóż nowe konto
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>

<main class="p-6 flex flex-col items-center space-y-8">
    <!-- Obrazek -->
    <img src="{{ asset('Tekst.png') }}"
         alt="Tekst"
         class="rounded-lg shadow-lg max-w-md h-auto">

    <!-- Opis systemu -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 max-w-xl text-center">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">
            📚 Witaj w systemie do dodawania zadań
        </h2>
        <p class="text-gray-600 dark:text-gray-300">
            Ten system pozwala w łatwy sposób dodawać, edytować i zarządzać zadaniami.
            Dzięki intuicyjnemu interfejsowi możesz szybko wprowadzać dane i monitorować postępy.
        </p>
    </div>

    <div class="bg-indigo-50 dark:bg-gray-700 shadow rounded-lg p-4 max-w-xl">
        <p class="text-indigo-700 dark:text-indigo-300 font-medium">
            ✨ Zacznij od zalogowania się lub założenia konta, aby uzyskać pełen dostęp do funkcji systemu.
        </p>
    </div>
</main>

</body>
</html>
