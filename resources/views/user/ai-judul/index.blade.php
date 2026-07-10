<x-user-layout>
    <x-slot name="header">
        AI Topik & Judul Generator
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg border border-transparent overflow-hidden mb-8">
            <div class="px-8 py-10 text-center">
                <svg class="mx-auto h-12 w-12 text-white mb-4 opacity-90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Brainstorming dengan AI</h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">Cukup masukkan minat dan bidang studi Anda, AI akan memberikan 20 ide judul terbaik lengkap dengan analisis kelayakan.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Parameter Pencarian</h3>
                <a href="{{ route('user.ai-judul.history') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat Riwayat</a>
            </div>
            
            <div class="p-6">
                <form action="{{ route('user.ai-judul.generate') }}" method="POST" id="ai-form" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang / Program Studi <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Contoh: Teknik Informatika, Pendidikan Bahasa Inggris, Hukum Bisnis</p>
                        <input type="text" name="bidang" id="bidang" required value="{{ old('bidang') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                    </div>

                    <div>
                        <label for="minat" class="block text-sm font-medium text-gray-700">Minat Spesifik / Topik <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Contoh: Kecerdasan Buatan (AI), Kinerja Karyawan, E-commerce</p>
                        <input type="text" name="minat" id="minat" required value="{{ old('minat') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Studi Kasus (Opsional)</label>
                        <p class="text-xs text-gray-500 mb-2">Contoh: UMKM di Bandung, Rumah Sakit X, Sekolah Dasar Y</p>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" id="btn-submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all w-full sm:w-auto">
                            <span id="btn-text">Generate Judul (AI)</span>
                            <svg id="btn-icon" class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.428-1.428L13.5 18.75l1.183-.394a2.25 2.25 0 001.428-1.428l.394-1.183.394 1.183a2.25 2.25 0 001.428 1.428l1.183.394-1.183.394a2.25 2.25 0 00-1.428 1.428z" />
                            </svg>
                            <svg id="btn-spinner" class="ml-2 -mr-1 h-5 w-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('ai-form').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit');
            const text = document.getElementById('btn-text');
            const icon = document.getElementById('btn-icon');
            const spinner = document.getElementById('btn-spinner');

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            text.innerText = 'AI sedang berpikir...';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    </script>
</x-user-layout>
