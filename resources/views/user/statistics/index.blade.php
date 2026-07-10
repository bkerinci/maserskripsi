<x-user-layout>
    <x-slot name="header">
        AI Statistik & Metodologi - {{ $project->title }}
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">AI Statistik & Metodologi</h1>
            <p class="mt-1 text-sm text-gray-500">Desain riset dan analisis data otomatis berbasis AI.</p>
        </div>
        <a href="{{ route('user.projects.show', $project) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali ke Project
        </a>
    </div>

    <!-- Tabs -->
    <div>
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" onclick="switchTab('metodologi')" id="tab-btn-metodologi" class="border-orange-500 text-orange-600 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium">
                    <svg id="tab-icon-metodologi" class="text-orange-500 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    AI Metodologi
                </button>
                <button type="button" onclick="switchTab('statistik')" id="tab-btn-statistik" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium">
                    <svg id="tab-icon-statistik" class="text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    Analisis Data & Statistik
                </button>
            </nav>
        </div>

        <!-- AI Metodologi Tab -->
        <div id="tab-content-metodologi" class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <form onsubmit="generateMethodology(event)" class="space-y-4">
                    <div>
                        <label for="research_type" class="block text-sm font-medium text-gray-700">Jenis Penelitian</label>
                        <select id="research_type" name="research_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            <option value="Kuantitatif">Kuantitatif (Angka & Statistik)</option>
                            <option value="Kualitatif">Kualitatif (Wawancara & Deskripsi)</option>
                        </select>
                    </div>
                    <div>
                        <label for="topic" class="block text-sm font-medium text-gray-700">Topik atau Judul Penelitian</label>
                        <input type="text" id="topic" name="topic" value="{{ $project->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" required>
                    </div>
                    <button type="submit" id="btn-metodologi" class="inline-flex w-full justify-center items-center gap-2 rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500">
                        <span id="btn-text-metodologi">Generate Rancangan Metodologi</span>
                    </button>
                </form>
            </div>

            <!-- Methodology Result -->
            <div id="metodologi-result-container" class="hidden bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Hasil Rancangan Metodologi</h3>
                <div class="prose prose-sm prose-orange max-w-none">
                    <p id="metodologi-content" class="whitespace-pre-wrap text-gray-700"></p>
                </div>
            </div>
        </div>

        <!-- Statistik Tab -->
        <div id="tab-content-statistik" style="display: none;" class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Upload Data CSV</h3>
                <p class="mt-1 text-sm text-gray-500">Upload file CSV Anda (seperti dari Excel) untuk dianalisis oleh AI (Deskriptif, Normalitas, Regresi, dsb).</p>
                <div class="mt-6 flex justify-center">
                    <label for="csv-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-orange-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-orange-600 focus-within:ring-offset-2 hover:text-orange-500">
                        <span class="inline-flex items-center gap-2 rounded-md bg-orange-50 px-3 py-2 text-sm font-semibold text-orange-600 shadow-sm hover:bg-orange-100">Pilih File CSV</span>
                        <input id="csv-upload" type="file" accept=".csv,text/csv" class="sr-only" onchange="uploadCsvFile(event)">
                    </label>
                </div>
            </div>

            <!-- Upload Progress/Result -->
            <div id="upload-result-container" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-6">
                <div id="upload-loading" class="hidden flex-col items-center justify-center py-6">
                    <svg class="animate-spin h-8 w-8 text-orange-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-sm text-gray-600">Menganalisis dataset Anda...</p>
                </div>

                <div id="upload-success" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Analisis Data Berhasil
                        </h4>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600" id="data-dimensions"></p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="prose prose-sm max-w-none text-gray-800" id="analysis-summary">
                            <!-- Injected by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function switchTab(tab) {
            if (tab === 'metodologi') {
                document.getElementById('tab-content-metodologi').style.display = 'block';
                document.getElementById('tab-content-statistik').style.display = 'none';
                
                document.getElementById('tab-btn-metodologi').className = 'border-orange-500 text-orange-600 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                document.getElementById('tab-icon-metodologi').className = 'text-orange-500 mr-2 h-5 w-5';
                
                document.getElementById('tab-btn-statistik').className = 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                document.getElementById('tab-icon-statistik').className = 'text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5';
            } else {
                document.getElementById('tab-content-metodologi').style.display = 'none';
                document.getElementById('tab-content-statistik').style.display = 'block';
                
                document.getElementById('tab-btn-statistik').className = 'border-orange-500 text-orange-600 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                document.getElementById('tab-icon-statistik').className = 'text-orange-500 mr-2 h-5 w-5';
                
                document.getElementById('tab-btn-metodologi').className = 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                document.getElementById('tab-icon-metodologi').className = 'text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5';
            }
        }

        function generateMethodology(e) {
            e.preventDefault();
            const type = document.getElementById('research_type').value;
            const topic = document.getElementById('topic').value;

            document.getElementById('btn-metodologi').disabled = true;
            document.getElementById('btn-text-metodologi').innerText = 'Memproses dengan AI...';
            document.getElementById('metodologi-result-container').classList.add('hidden');

            const formData = new FormData();
            formData.append('research_type', type);
            formData.append('topic', topic);

            fetch('{{ route("user.statistics.methodology", $project) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('btn-metodologi').disabled = false;
                document.getElementById('btn-text-metodologi').innerText = 'Generate Rancangan Metodologi';
                
                if(data.success) {
                    document.getElementById('metodologi-content').innerHTML = data.result.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    document.getElementById('metodologi-result-container').classList.remove('hidden');
                } else {
                    alert('Gagal menghasilkan rancangan');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('btn-metodologi').disabled = false;
                document.getElementById('btn-text-metodologi').innerText = 'Generate Rancangan Metodologi';
                alert('Terjadi kesalahan koneksi.');
            });
        }

        function uploadCsvFile(e) {
            const file = e.target.files[0];
            if(!file) return;

            document.getElementById('upload-result-container').classList.remove('hidden');
            document.getElementById('upload-loading').classList.remove('hidden');
            document.getElementById('upload-loading').classList.add('flex');
            document.getElementById('upload-success').classList.add('hidden');

            const formData = new FormData();
            formData.append('csv_file', file);

            fetch('{{ route("user.statistics.upload", $project) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('upload-loading').classList.add('hidden');
                document.getElementById('upload-loading').classList.remove('flex');
                
                if(data.success) {
                    let colsList = data.columns.join(', ');
                    document.getElementById('data-dimensions').innerHTML = `Dataset berhasil diproses. Ditemukan <strong>${data.rows} baris</strong> dan <strong>${data.cols} kolom</strong>.<br>Kolom: <span class="text-xs text-gray-500">${colsList}</span>`;
                    
                    document.getElementById('analysis-summary').innerHTML = data.summary.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    document.getElementById('upload-success').classList.remove('hidden');
                } else {
                    document.getElementById('upload-result-container').classList.add('hidden');
                    alert(data.message || 'Gagal menganalisis CSV');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('upload-loading').classList.add('hidden');
                document.getElementById('upload-loading').classList.remove('flex');
                document.getElementById('upload-result-container').classList.add('hidden');
                alert('Terjadi kesalahan koneksi atau format file tidak valid.');
            });
            
            // Reset file input so same file can be uploaded again if needed
            e.target.value = '';
        }
    </script>
    @endpush
</x-user-layout>
