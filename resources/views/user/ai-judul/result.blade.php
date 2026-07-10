<x-user-layout>
    <x-slot name="header">
        Hasil Generate Judul AI
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('user.ai-judul.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Kembali ke Form
            </a>
            <h2 class="text-2xl font-bold text-gray-900">Rekomendasi Judul</h2>
            <p class="text-sm text-gray-500 mt-1">Berdasarkan Minat: <span class="font-semibold text-gray-700">{{ $topicIdea->input_minat }}</span> • Bidang: <span class="font-semibold text-gray-700">{{ $topicIdea->input_bidang }}</span> {{ $topicIdea->input_lokasi ? '• Lokasi: '.$topicIdea->input_lokasi : '' }}</p>
        </div>
    </div>

    @if(empty($topicIdea->results))
        <div class="p-8 text-center bg-white rounded-xl shadow-sm border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <h3 class="text-lg font-bold text-gray-900">Gagal Memproses</h3>
            <p class="text-gray-500 mt-2">Maaf, AI gagal mengembalikan format yang valid atau terjadi gangguan jaringan. Silakan coba lagi.</p>
            <a href="{{ route('user.ai-judul.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Coba Lagi</a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6">
            @foreach($topicIdea->results as $index => $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6 items-start md:items-center hover:border-blue-300 transition-colors">
                    <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 font-bold text-lg border border-blue-100">
                        {{ $index + 1 }}
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $item['judul'] ?? 'Tanpa Judul' }}</h3>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <!-- Kebaruan -->
                            @php $kebaruan = strtolower($item['kebaruan'] ?? ''); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md border {{ $kebaruan == 'tinggi' ? 'bg-green-50 border-green-200 text-green-700' : ($kebaruan == 'sedang' ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : 'bg-gray-50 border-gray-200 text-gray-700') }}" title="Kebaruan / Novelty">
                                💡 Kebaruan: {{ ucfirst($kebaruan) }}
                            </span>
                            
                            <!-- Kesulitan -->
                            @php $kesulitan = strtolower($item['kesulitan'] ?? ''); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md border {{ $kesulitan == 'mudah' || $kesulitan == 'rendah' ? 'bg-green-50 border-green-200 text-green-700' : ($kesulitan == 'sedang' ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : 'bg-red-50 border-red-200 text-red-700') }}" title="Tingkat Kesulitan Pengerjaan">
                                ⚙️ Kesulitan: {{ ucfirst($kesulitan) }}
                            </span>
                            
                            <!-- Referensi -->
                            @php $referensi = strtolower($item['referensi'] ?? ''); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md border {{ $referensi == 'mudah' || $referensi == 'banyak' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-gray-50 border-gray-200 text-gray-700' }}" title="Ketersediaan Jurnal/Referensi">
                                📚 Referensi: {{ ucfirst($referensi) }}
                            </span>

                            <!-- Peluang Lulus -->
                            @php $peluang = strtolower($item['peluang_lulus'] ?? ''); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md border {{ $peluang == 'tinggi' ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-gray-50 border-gray-200 text-gray-700' }}" title="Peluang Diterima Dosen">
                                🎯 Peluang ACC: {{ ucfirst($peluang) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-shrink-0 w-full md:w-auto">
                        <a href="{{ route('user.projects.create', ['title' => $item['judul'] ?? '']) }}" class="block w-full text-center px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-transparent">
                            Gunakan Judul Ini
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-user-layout>
