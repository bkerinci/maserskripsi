<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Master Skripsi') }} - Login / Register</title>
        <meta name="description" content="Masuk atau daftar ke Master Skripsi, platform asisten akademik AI terdepan untuk kemudahan menyusun skripsi dan tesis.">
        <meta name="keywords" content="Master Skripsi Login, Daftar Master Skripsi, Asisten AI Skripsi, masterskripsi.my.id">
        <meta name="author" content="Master Skripsi">
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name', 'Master Skripsi') }} - Login / Register">
        <meta property="og:description" content="Masuk atau daftar ke Master Skripsi untuk memulai perjalanan akademik Anda bersama AI.">
        <meta property="og:image" content="{{ asset('logo.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ config('app.name', 'Master Skripsi') }} - Login / Register">
        <meta property="twitter:description" content="Masuk atau daftar ke Master Skripsi untuk memulai perjalanan akademik Anda bersama AI.">
        <meta property="twitter:image" content="{{ asset('logo.png') }}">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-900/20">
                        M
                    </div>
                    <span class="font-heading font-bold text-3xl text-slate-900 tracking-tight">Master<span class="text-blue-700">Skripsi</span></span>
                </a>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
