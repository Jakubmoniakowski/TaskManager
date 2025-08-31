<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md p-8 space-y-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white">
                ✨ Rejestracja
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate>
            @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imię</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hasło</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Potwierdź hasło</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                    Zarejestruj się
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Masz już konto?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Zaloguj się</a>
            </p>
        </div>
    </div>
</x-guest-layout>
