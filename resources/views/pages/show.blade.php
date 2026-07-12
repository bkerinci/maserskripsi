<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $page->title }} - {{ config('app.name', 'Master Skripsi') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    <meta name="keywords" content="{{ $page->title }}, Master Skripsi, Legal">
    <meta name="author" content="Master Skripsi">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $page->title }} - {{ config('app.name', 'Master Skripsi') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $page->title }} - {{ config('app.name', 'Master Skripsi') }}">
    <meta property="twitter:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-blue-900/10">
                        M
                    </div>
                    <span class="font-heading font-bold text-xl text-slate-900 tracking-tight">Master<span class="text-blue-700">Skripsi</span></span>
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Home</a></li>
                <li><span class="text-gray-300">/</span></li>
                <li class="text-gray-800 font-medium">{{ $page->title }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="border-b border-gray-100 bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-8 sm:px-12">
                <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
                <p class="text-gray-500 text-sm mt-2">
                    Terakhir diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }} &middot; 
                    Versi: {{ $page->version }} &middot; 
                    Bahasa: {{ $page->language }}
                </p>
            </div>

            <!-- Body -->
            <div class="px-8 py-10 sm:px-12 prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-blue-600 prose-li:marker:text-blue-500">
                {!! $page->content !!}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white mt-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Fayel Intelligence Labs. All rights reserved.</p>
            <div class="flex gap-6 text-sm text-gray-400">
                <a href="{{ route('legal.show', 'terms') }}" class="hover:text-blue-600 transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('legal.show', 'privacy-policy') }}" class="hover:text-blue-600 transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>
