<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Administrator - Master Skripsi</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-gray-900 font-sans antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo -->
            <div class="flex justify-center">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-700 to-red-900 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-red-900/20">
                        M
                    </div>
                </a>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Administrator
            </h2>
            <p class="mt-2 text-center text-sm text-gray-500">
                Halaman otentikasi khusus staf
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-xl sm:px-10 border border-gray-100">
                <form class="space-y-6" action="{{ route('admin.login.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Admin
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Masuk ke Dashboard Admin
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Master Skripsi. Restricted Access.
            </div>
        </div>
    </div>
</body>
</html>
