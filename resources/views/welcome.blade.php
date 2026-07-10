<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Master Skripsi - Asisten AI Terbaik untuk Skripsi & Tesis</title>
    <meta name="description" content="Master Skripsi adalah platform asisten akademik berbasis AI untuk membantu mahasiswa menyusun skripsi, tesis, proposal, dan review jurnal dengan lebih cepat dan sesuai kaidah ilmiah.">
    <meta name="keywords" content="Master Skripsi, AI Skripsi, AI Tesis, Joki Skripsi AI, Literature Review AI, AI Proposal, Asisten Akademik AI, masterskripsi.my.id">
    <meta name="author" content="Master Skripsi">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Master Skripsi - Asisten AI Terbaik">
    <meta property="og:description" content="Platform AI untuk membantu penyusunan skripsi dan tesis sesuai kaidah akademik.">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Master Skripsi - Asisten AI Terbaik">
    <meta property="twitter:description" content="Platform AI untuk membantu penyusunan skripsi dan tesis sesuai kaidah akademik.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-200 selection:text-blue-900">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-900/20">
                        M
                    </div>
                    <span class="font-heading font-bold text-2xl text-slate-900 tracking-tight">Master<span class="text-blue-700">Skripsi</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fitur" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Fitur</a>
                    <a href="#solusi" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Solusi</a>
                    <a href="#harga" class="text-sm font-medium text-slate-600 hover:text-blue-700 transition-colors">Harga</a>
                    
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4 ml-4 border-l border-slate-200 pl-8">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-700 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-700 transition-colors">Masuk</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 transition-all hover:-translate-y-0.5">
                                        Daftar Gratis
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-50 via-slate-50 to-slate-50"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3">
            <div class="w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3">
            <div class="w-[30rem] h-[30rem] bg-indigo-400/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-heading text-5xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 max-w-4xl mx-auto leading-tight">
                Selesaikan Skripsi & Tesis <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-indigo-700">Lebih Cepat dengan AI</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Buat judul penelitian, proposal, Bab 1–Bab 5, cari referensi jurnal, parafrase akademik, sitasi otomatis, hingga analisis penelitian dalam satu platform AI yang dirancang untuk membantu mahasiswa menyusun karya ilmiah sesuai kaidah akademik.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-gradient-to-r from-blue-700 to-blue-800 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-blue-900/30 hover:shadow-blue-900/40 hover:scale-105 transition-all duration-300">
                        Mulai Project Pertama
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @else
                    <a href="#" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-gradient-to-r from-blue-700 to-blue-800 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-blue-900/30 hover:shadow-blue-900/40 hover:scale-105 transition-all duration-300">
                        Mulai Project Pertama
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                @endif
                <a href="#demo" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-white px-8 py-4 text-base font-semibold text-slate-700 border border-slate-200 shadow-sm hover:bg-slate-50 hover:text-blue-700 transition-all duration-300">
                    Lihat Cara Kerja
                </a>
            </div>

            <!-- Dashboard Mockup Image -->
            <div class="mt-20 relative max-w-5xl mx-auto">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-20"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-4 py-3 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        <div class="ml-4 text-xs font-medium text-slate-400">Master Skripsi Dashboard</div>
                    </div>
                    <!-- Realistic Dashboard Content -->
                    <div class="flex flex-col md:flex-row h-[400px] bg-white text-left">
                        <!-- Sidebar -->
                        <div class="hidden md:flex flex-col w-64 bg-slate-50 border-r border-slate-100 p-5">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Project Aktif</div>
                            <div class="bg-blue-50 text-blue-700 rounded-xl p-3 text-sm font-semibold border border-blue-100 mb-6 shadow-sm">
                                Analisis Sentimen NLP...
                                <div class="mt-3 w-full bg-blue-200/50 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: 45%"></div>
                                </div>
                                <div class="text-[10px] text-blue-500 mt-1.5 font-medium">Progress: 45% (Bab 2)</div>
                            </div>
                            
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Menu AI</div>
                            <div class="space-y-1">
                                <div class="flex items-center text-xs font-medium p-2.5 text-slate-600 hover:bg-slate-100 rounded-lg cursor-pointer transition-colors"><svg class="w-4 h-4 mr-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> AI Writer</div>
                                <div class="flex items-center text-xs font-semibold p-2.5 bg-blue-600/5 text-blue-700 rounded-lg cursor-pointer"><svg class="w-4 h-4 mr-2.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Literature Review</div>
                                <div class="flex items-center text-xs font-medium p-2.5 text-slate-600 hover:bg-slate-100 rounded-lg cursor-pointer transition-colors"><svg class="w-4 h-4 mr-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg> AI Statistik</div>
                            </div>
                        </div>
                        
                        <!-- Main Chat Area -->
                        <div class="flex-1 flex flex-col relative overflow-hidden bg-slate-50/30">
                            <!-- Topbar -->
                            <div class="h-14 border-b border-slate-100 flex items-center px-6 justify-between bg-white z-10">
                                <div class="text-sm font-semibold text-slate-800">Review Jurnal Otomatis</div>
                                <div class="flex gap-2">
                                    <div class="text-[10px] font-semibold tracking-wide bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full flex items-center"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> 2 PDF Terunggah</div>
                                </div>
                            </div>
                            
                            <!-- Chat History -->
                            <div class="flex-1 p-6 overflow-y-auto space-y-6">
                                <!-- User Message -->
                                <div class="flex items-start justify-end gap-3">
                                    <div class="bg-blue-600 text-white p-3.5 rounded-2xl rounded-tr-sm text-sm max-w-[80%] shadow-sm">
                                        Tolong carikan <span class="font-semibold text-blue-100">research gap</span> dari dua jurnal yang baru saya unggah. Fokus pada metode ekstraksi fitur.
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex-shrink-0 border-2 border-white shadow-sm flex items-center justify-center text-xs font-bold text-slate-500">U</div>
                                </div>
                                
                                <!-- AI Message -->
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-700 to-blue-900 flex-shrink-0 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-xs">M</div>
                                    <div class="bg-white border border-slate-200 p-4.5 rounded-2xl rounded-tl-sm text-sm max-w-[85%] shadow-sm leading-relaxed p-4">
                                        <p class="text-slate-700 mb-3">Tentu! Berdasarkan kedua jurnal tersebut, berikut adalah <strong>research gap</strong> yang dapat Anda angkat:</p>
                                        <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-3.5 text-slate-600 space-y-3 shadow-inner">
                                            <p class="text-xs"><strong>Jurnal 1 (Ahmad et al., 2023):</strong> Menggunakan TF-IDF konvensional, akurasi tinggi tapi kurang menangkap semantik kata.</p>
                                            <div class="w-full h-[1px] bg-slate-100"></div>
                                            <p class="text-xs"><strong>Jurnal 2 (Budi dkk., 2024):</strong> Menggunakan Word2Vec, menangkap semantik tapi gagal menangani kata-kata <em>OOV (Out of Vocabulary)</em>.</p>
                                        </div>
                                        <p class="text-slate-700 mt-4 font-semibold flex items-center text-sm">
                                            Rekomendasi Kebaruan: Menggabungkan FastText dengan...
                                            <span class="inline-block ml-2 w-1.5 h-4 bg-blue-600 animate-pulse"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bottom Input -->
                            <div class="p-4 bg-white border-t border-slate-100">
                                <div class="relative flex items-center">
                                    <div class="absolute left-3 text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg></div>
                                    <div class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-400 font-medium">Balas Master Skripsi di sini...</div>
                                    <div class="absolute right-2 p-2 bg-blue-600 hover:bg-blue-700 transition-colors cursor-pointer text-white rounded-lg shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-blue-700 font-semibold tracking-wide uppercase text-sm mb-3">Fitur Cerdas</h2>
                <p class="font-heading mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Lebih Cepat, Tetap Akademis
                </p>
                <p class="mt-4 max-w-2xl text-lg text-slate-500 mx-auto">
                    Kumpulan modul AI yang dirancang spesifik untuk metodologi penelitian dan kaidah karya tulis ilmiah.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="relative group bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-900/5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">AI Topik & Proposal</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Temukan ide penelitian sesuai minat Anda dan hasilkan struktur proposal BAB I hingga III secara instan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="relative group bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-900/5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Literature Review</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Unggah jurnal PDF dan biarkan AI merangkum, mencari gap penelitian, dan membuat matriks literatur.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="relative group bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-900/5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Academic Writer</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Editor pintar untuk memparafrase, menyempurnakan nada akademik, dan menyusun sitasi otomatis.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="relative group bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg hover:shadow-blue-900/5 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">AI Statistik</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Unggah data penelitian Anda dan dapatkan analisis deskriptif hingga uji hipotesis secara instan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Solution Section -->
    <div id="solusi" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-blue-900 via-slate-900 to-slate-900"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-blue-400 font-semibold tracking-wide uppercase text-sm mb-3">Untuk Semua Jenjang</h2>
                    <h3 class="font-heading text-3xl sm:text-4xl font-extrabold mb-6 leading-tight">Solusi Tepat untuk Perjalanan Akademik Anda</h3>
                    <p class="text-slate-400 text-lg mb-8 leading-relaxed">
                        Baik Anda mahasiswa yang sedang memulai skripsi, pascasarjana yang butuh kedalaman analisis, maupun dosen yang mengawasi puluhan bimbingan.
                    </p>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold font-heading">Mahasiswa S1/D3</h4>
                                <p class="mt-1 text-slate-400 text-sm">Panduan langkah demi langkah dari menentukan judul hingga presentasi sidang.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold font-heading">Mahasiswa S2/S3</h4>
                                <p class="mt-1 text-slate-400 text-sm">Alat bantu pencarian gap penelitian, analisis literatur mendalam, dan sitasi kompleks.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold font-heading">Dosen Pembimbing</h4>
                                <p class="mt-1 text-slate-400 text-sm">Dashboard pemantauan progres mahasiswa dan pengecekan integritas akademis.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="relative">
                    <div class="aspect-square md:aspect-auto md:h-[500px] rounded-2xl bg-gradient-to-tr from-slate-800 to-slate-800/50 border border-slate-700 shadow-2xl p-8 flex flex-col justify-center items-center overflow-hidden">
                        <!-- Abstract decorative tech elements -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
                        
                        <div class="relative z-10 w-full max-w-sm space-y-4">
                            <div class="bg-slate-700/50 backdrop-blur-sm p-4 rounded-xl border border-slate-600 transform -rotate-2 hover:rotate-0 transition-transform">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded bg-blue-500/20 text-blue-400 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                                    <div class="font-bold text-sm">Generasi Judul Berhasil</div>
                                </div>
                                <div class="text-xs text-slate-400">"Penerapan Machine Learning dalam Prediksi Hasil Panen Padi di Jawa Barat..."</div>
                            </div>
                            
                            <div class="bg-slate-700/50 backdrop-blur-sm p-4 rounded-xl border border-slate-600 transform translate-x-4 rotate-1 hover:rotate-0 transition-transform">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded bg-purple-500/20 text-purple-400 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <div class="font-bold text-sm">Kajian Pustaka Disusun</div>
                                </div>
                                <div class="text-xs text-slate-400">15 Jurnal terkait telah dirangkum dan gap penelitian berhasil diidentifikasi.</div>
                            </div>
                            
                            <div class="bg-slate-700/50 backdrop-blur-sm p-4 rounded-xl border border-slate-600 transform -rotate-1 -translate-x-2 hover:rotate-0 transition-transform">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded bg-green-500/20 text-green-400 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></div>
                                    <div class="font-bold text-sm">Format APA 7th Diterapkan</div>
                                </div>
                                <div class="text-xs text-slate-400">Daftar pustaka otomatis diformat dan disisipkan ke dalam dokumen akhir.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing / Target -->
    <div id="harga" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-heading text-3xl font-extrabold text-slate-900">Pilih Paket yang Sesuai</h2>
                <p class="mt-4 text-lg text-slate-600">Didesain khusus untuk memenuhi kebutuhan mahasiswa hingga tingkat institusi.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                @foreach($plans as $index => $plan)
                    @if($index == 0)
                        <!-- Basic -->
                        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col">
                            <h3 class="text-xl font-bold text-slate-900 font-heading">{{ $plan->name }}</h3>
                            <p class="text-slate-500 text-sm mt-2">Mulai tugas akhir.</p>
                            <div class="my-6">
                                @if($plan->price == 0)
                                    <span class="text-4xl font-extrabold text-slate-900">Custom</span>
                                @else
                                    <span class="text-4xl font-extrabold text-slate-900">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                                @endif
                            </div>
                            <ul class="space-y-4 mb-8 flex-1">
                                @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-center text-sm text-slate-600"><svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl transition-colors">Pilih Paket</a>
                        </div>
                    @elseif($index == 1)
                        <!-- Premium Bulanan -->
                        <div class="bg-blue-900 rounded-3xl p-8 border border-blue-800 shadow-xl shadow-blue-900/20 relative transform lg:-translate-y-4 flex flex-col">
                            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4">
                                <span class="bg-gradient-to-r from-blue-400 to-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Populer</span>
                            </div>
                            <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                            <p class="text-blue-200 text-sm mt-2">Untuk penelitian rutin.</p>
                            <div class="my-6">
                                @if($plan->price == 0)
                                    <span class="text-4xl font-extrabold text-white">Custom</span>
                                @else
                                    <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                                @endif
                            </div>
                            <ul class="space-y-4 mb-8 flex-1">
                                @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-center text-sm text-blue-50"><svg class="w-5 h-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-white hover:bg-blue-50 text-blue-900 font-semibold rounded-xl transition-colors shadow-sm">Pilih Paket</a>
                        </div>
                    @elseif($index == 2)
                        <!-- Premium Tahunan -->
                        <div class="bg-gradient-to-b from-indigo-900 to-blue-900 rounded-3xl p-8 border border-indigo-800 shadow-xl shadow-indigo-900/20 relative transform lg:-translate-y-4 flex flex-col">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-md">Best Value</span>
                            </div>
                            <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                            <p class="text-indigo-200 text-sm mt-2">Hemat lebih banyak.</p>
                            <div class="my-6">
                                @if($plan->price == 0)
                                    <span class="text-4xl font-extrabold text-white">Custom</span>
                                @else
                                    <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                                @endif
                            </div>
                            <ul class="space-y-4 mb-8 flex-1">
                                @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-center text-sm text-indigo-50"><svg class="w-5 h-5 text-amber-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white font-bold rounded-xl transition-colors shadow-sm">Pilih Paket</a>
                        </div>
                    @else
                        <!-- Custom -->
                        <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-xl shadow-slate-900/20 flex flex-col">
                            <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                            <p class="text-slate-400 text-sm mt-2">Untuk institusi pendidikan.</p>
                            <div class="my-6">
                                @if($plan->price == 0)
                                    <span class="text-4xl font-extrabold text-white">Custom</span>
                                @else
                                    <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                                @endif
                            </div>
                            <ul class="space-y-4 mb-8 flex-1">
                                @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-center text-sm text-slate-300"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                                @endforeach
                            </ul>
                            <a href="#" onclick="alert('Silakan hubungi kami via email.'); return false;" class="block w-full text-center py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">Hubungi Kami</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center text-white font-bold">M</div>
                <span class="font-heading font-bold text-xl text-white tracking-tight">Master<span class="text-blue-500">Skripsi</span></span>
            </div>
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} Fayel Intelligence Labs. All rights reserved.
            </p>
            <div class="flex gap-6 text-sm text-slate-400">
                <a href="{{ route('legal.show', 'terms') }}" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('legal.show', 'privacy-policy') }}" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>
