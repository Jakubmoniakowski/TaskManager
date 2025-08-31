<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
                ✅ Rejestracja zakończona pomyślnie
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Twoje konto zostało utworzone. Możesz się teraz zalogować.
            </p>
            <a href="{{ route('login') }}"
               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                Chcę się zalogować
            </a>
        </div>
    </div>
</x-app-layout>
