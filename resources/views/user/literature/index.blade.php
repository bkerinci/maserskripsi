<x-user-layout>
    <x-slot name="header">
        Literature Review - {{ $project->title }}
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Referensi & Literature Review</h1>
            <p class="mt-1 text-sm text-gray-500">Cari jurnal, upload PDF, kelola daftar pustaka, dan generate sitasi otomatis.</p>
        </div>
        <a href="{{ route('user.projects.show', $project) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
    </div>

    <!-- Tabs -->
    <div>
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" onclick="switchTab('search')" id="tab-btn-search" class="border-emerald-500 text-emerald-600 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium">
                    <svg id="tab-icon-search" class="text-emerald-500 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    Pencarian Jurnal
                </button>
                <button type="button" onclick="switchTab('upload')" id="tab-btn-upload" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium">
                    <svg id="tab-icon-upload" class="text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                    Upload PDF
                </button>
                <button type="button" onclick="switchTab('refs')" id="tab-btn-refs" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium">
                    <svg id="tab-icon-refs" class="text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    Daftar Referensi
                    <span id="ref-count-badge" class="ml-2 inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">{{ count($references) }}</span>
                </button>
            </nav>
        </div>

        <!-- ============ Tab 1: Pencarian Jurnal ============ -->
        <div id="tab-content-search" class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <form onsubmit="performSearch(event)" class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/3">
                        <select id="search-source" class="block w-full rounded-md border-0 py-3 pl-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                            <option value="crossref">Crossref Database</option>
                            <option value="doaj">DOAJ (Directory of Open Access Journals)</option>
                        </select>
                    </div>
                    <div class="flex-1 relative">
                        <label for="query" class="sr-only">Kata Kunci Jurnal</label>
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                        </div>
                        <input type="text" id="query" class="block w-full rounded-md border-0 py-3 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6" placeholder="Cari topik, penulis, atau kata kunci...">
                    </div>
                    <button type="submit" id="btn-search" class="inline-flex justify-center items-center gap-2 rounded-md bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 disabled:opacity-50">
                        <span id="btn-text-search">Cari</span>
                    </button>
                </form>
            </div>

            <!-- Results List -->
            <div id="results-container" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <ul id="results-list" role="list" class="divide-y divide-gray-100"></ul>
            </div>

            <div id="no-results" class="hidden text-center py-12 bg-white rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500">Tidak ada jurnal ditemukan untuk pencarian ini.</p>
            </div>
        </div>

        <!-- ============ Tab 2: Upload PDF ============ -->
        <div id="tab-content-upload" style="display: none;" class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Upload PDF Jurnal</h3>
                <p class="mt-1 text-sm text-gray-500">Upload jurnal PDF untuk mengekstrak isi, lalu simpan sebagai referensi.</p>
                <div class="mt-6 flex justify-center">
                    <label for="pdf-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-emerald-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-emerald-600 focus-within:ring-offset-2 hover:text-emerald-500">
                        <span class="inline-flex items-center gap-2 rounded-md bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-600 shadow-sm hover:bg-emerald-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                            Pilih File PDF
                        </span>
                        <input id="pdf-upload" type="file" accept="application/pdf" class="sr-only" onchange="uploadPdfFile(event)">
                    </label>
                </div>
            </div>

            <!-- Upload Result -->
            <div id="upload-result-container" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-6">
                <div id="upload-loading" class="hidden flex-col items-center justify-center py-6">
                    <svg class="animate-spin h-8 w-8 text-emerald-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-sm text-gray-600">Mengupload dan mengekstrak teks...</p>
                </div>

                <div id="upload-success" class="hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Teks Berhasil Diekstrak
                        </h4>
                    </div>
                    
                    <!-- Form to save PDF as reference -->
                    <div class="bg-emerald-50 rounded-lg p-4 mb-4 border border-emerald-200">
                        <h5 class="text-sm font-semibold text-emerald-800 mb-3">Simpan sebagai Referensi</h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Judul</label>
                                <input type="text" id="pdf-ref-title" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Judul jurnal/paper">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Penulis</label>
                                <input type="text" id="pdf-ref-authors" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Nama penulis">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Jurnal</label>
                                <input type="text" id="pdf-ref-journal" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Nama jurnal">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                                <input type="text" id="pdf-ref-year" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="2024">
                            </div>
                        </div>
                        <button onclick="savePdfAsReference()" id="btn-save-pdf-ref" class="mt-3 inline-flex items-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Simpan ke Daftar Referensi
                        </button>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 max-h-64 overflow-y-auto">
                        <p id="extracted-text-content" class="text-xs text-gray-700 whitespace-pre-wrap"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ Tab 3: Daftar Referensi ============ -->
        <div id="tab-content-refs" style="display: none;" class="space-y-6">
            <!-- Tambah Manual -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <button onclick="toggleManualForm()" class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                    <span class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Referensi Manual
                    </span>
                    <svg id="manual-form-arrow" class="h-5 w-5 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </button>
                <div id="manual-form-container" class="hidden px-6 pb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                            <input type="text" id="manual-title" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Judul paper/jurnal" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                            <input type="text" id="manual-authors" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: Budi S., Andi P.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jurnal</label>
                            <input type="text" id="manual-journal" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Nama jurnal/prosiding">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <input type="text" id="manual-year" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">DOI</label>
                            <input type="text" id="manual-doi" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="10.xxxx/xxxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                            <input type="text" id="manual-url" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Format Sitasi</label>
                            <select id="manual-format" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="APA">APA</option>
                                <option value="IEEE">IEEE</option>
                                <option value="MLA">MLA</option>
                                <option value="CHICAGO">Chicago</option>
                                <option value="VANCOUVER">Vancouver</option>
                            </select>
                        </div>
                    </div>
                    <button onclick="saveManualReference()" id="btn-save-manual" class="mt-4 inline-flex items-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">
                        Simpan Referensi
                    </button>
                </div>
            </div>

            <!-- References List -->
            <div id="references-list-container" class="space-y-3">
                @forelse($references as $ref)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:border-emerald-200 transition" id="ref-item-{{ $ref->id }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 leading-snug">{{ $ref->title }}</h4>
                            <div class="mt-1 flex flex-wrap items-center gap-x-2 text-xs text-gray-500">
                                @if($ref->authors)<span>{{ $ref->authors }}</span>@endif
                                @if($ref->journal)<span>• {{ $ref->journal }}</span>@endif
                                @if($ref->year)<span>• {{ $ref->year }}</span>@endif
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $ref->source === 'crossref' ? 'bg-blue-100 text-blue-700' : ($ref->source === 'doaj' ? 'bg-orange-100 text-orange-700' : ($ref->source === 'pdf' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600')) }}">
                                    {{ strtoupper($ref->source) }}
                                </span>
                            </div>
                            @if($ref->citation_text)
                            <div class="mt-2 bg-gray-50 rounded-md px-3 py-2 text-xs text-gray-700 italic border border-gray-100">
                                <span class="text-emerald-600 font-semibold not-italic">[{{ $ref->citation_format }}]</span> {{ $ref->citation_text }}
                            </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <!-- Format Sitasi Dropdown -->
                            <select onchange="changeCitationFormat({{ $ref->id }}, this.value)" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-1">
                                <option value="APA" {{ $ref->citation_format === 'APA' ? 'selected' : '' }}>APA</option>
                                <option value="IEEE" {{ $ref->citation_format === 'IEEE' ? 'selected' : '' }}>IEEE</option>
                                <option value="MLA" {{ $ref->citation_format === 'MLA' ? 'selected' : '' }}>MLA</option>
                                <option value="CHICAGO" {{ $ref->citation_format === 'CHICAGO' ? 'selected' : '' }}>Chicago</option>
                                <option value="VANCOUVER" {{ $ref->citation_format === 'VANCOUVER' ? 'selected' : '' }}>Vancouver</option>
                            </select>
                            @if($ref->url || $ref->doi)
                            <a href="{{ $ref->url ?: 'https://doi.org/'.$ref->doi }}" target="_blank" class="p-1.5 text-gray-400 hover:text-emerald-600 transition" title="Buka Link">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                            @endif
                            <button onclick="copyReference({{ $ref->id }})" class="p-1.5 text-gray-400 hover:text-emerald-600 transition" title="Salin Sitasi">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg>
                            </button>
                            <button onclick="deleteReference({{ $ref->id }})" class="p-1.5 text-gray-400 hover:text-red-600 transition" title="Hapus">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div id="refs-empty" class="text-center py-12 bg-white rounded-xl border border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    <p class="text-sm text-gray-500">Belum ada referensi. Cari jurnal atau tambahkan secara manual.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const PROJECT_ID = {{ $project->id }};
        let extractedPdfText = '';

        // ===== Tab Switching =====
        function switchTab(tab) {
            const tabs = ['search', 'upload', 'refs'];
            tabs.forEach(t => {
                const content = document.getElementById('tab-content-' + t);
                const btn = document.getElementById('tab-btn-' + t);
                const icon = document.getElementById('tab-icon-' + t);
                if (t === tab) {
                    content.style.display = 'block';
                    btn.className = 'border-emerald-500 text-emerald-600 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                    icon.className = 'text-emerald-500 mr-2 h-5 w-5';
                } else {
                    content.style.display = 'none';
                    btn.className = 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium';
                    icon.className = 'text-gray-400 group-hover:text-gray-500 mr-2 h-5 w-5';
                }
            });
        }

        // ===== Manual Form Toggle =====
        function toggleManualForm() {
            const container = document.getElementById('manual-form-container');
            const arrow = document.getElementById('manual-form-arrow');
            container.classList.toggle('hidden');
            arrow.style.transform = container.classList.contains('hidden') ? '' : 'rotate(180deg)';
        }

        // ===== Crossref Search =====
        function formatAuthors(authors) {
            if (!authors) return 'Penulis Tidak Diketahui';
            return authors.map(a => `${a.given || ''} ${a.family || ''}`.trim()).join(', ');
        }

        function performSearch(e) {
            e.preventDefault();
            const query = document.getElementById('query').value;
            const source = document.getElementById('search-source').value;
            if (!query) return;

            document.getElementById('btn-search').disabled = true;
            document.getElementById('btn-text-search').innerText = 'Mencari...';
            document.getElementById('results-container').classList.add('hidden');
            document.getElementById('no-results').classList.add('hidden');

            if (source === 'crossref') {
                fetch(`https://api.crossref.org/works?query=${encodeURIComponent(query)}&select=title,author,DOI,URL,container-title,created&rows=10`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('btn-search').disabled = false;
                        document.getElementById('btn-text-search').innerText = 'Cari';

                        const items = data.message.items.filter(item => item.title && item.author);
                        renderSearchResults(items, 'crossref');
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('btn-search').disabled = false;
                        document.getElementById('btn-text-search').innerText = 'Cari';
                        alert('Gagal mengambil data dari Crossref.');
                    });
            } else if (source === 'doaj') {
                fetch(`https://doaj.org/api/search/articles/${encodeURIComponent(query)}?pageSize=10`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('btn-search').disabled = false;
                        document.getElementById('btn-text-search').innerText = 'Cari';

                        const items = data.results || [];
                        renderSearchResults(items, 'doaj');
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('btn-search').disabled = false;
                        document.getElementById('btn-text-search').innerText = 'Cari';
                        alert('Gagal mengambil data dari DOAJ.');
                    });
            }
        }

        function renderSearchResults(items, source) {
            if (items.length > 0) {
                let html = '';
                items.forEach(item => {
                    let title, authorsStr, containerTitle, dateStr, url, doi;

                    if (source === 'crossref') {
                        title = item.title ? item.title[0] : 'Tanpa Judul';
                        authorsStr = formatAuthors(item.author);
                        containerTitle = item['container-title'] ? item['container-title'][0] : '';
                        dateStr = item.created ? item.created['date-parts'][0][0] : '';
                        url = item.URL || '';
                        doi = item.DOI || '';
                    } else if (source === 'doaj') {
                        const bibjson = item.bibjson || {};
                        title = bibjson.title || 'Tanpa Judul';
                        authorsStr = bibjson.author ? bibjson.author.map(a => a.name).join(', ') : 'Penulis Tidak Diketahui';
                        containerTitle = bibjson.journal ? bibjson.journal.title : '';
                        dateStr = bibjson.year || '';
                        url = (bibjson.link && bibjson.link.length > 0) ? bibjson.link[0].url : '';
                        
                        // Extract DOI if exists
                        doi = '';
                        if (bibjson.identifier) {
                            const doiObj = bibjson.identifier.find(id => id.type === 'doi');
                            if (doiObj) doi = doiObj.id;
                        }
                    }

                    const safeTitle = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    const safeAuthors = authorsStr.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    const safeJournal = containerTitle.replace(/'/g, "\\'").replace(/"/g, '&quot;');

                    html += `
                    <li class="p-5 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-x-4">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    <a href="${url || '#'}" target="_blank" class="hover:underline hover:text-emerald-600">${title}</a>
                                </p>
                                <div class="mt-1 flex flex-wrap items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    <p class="truncate">${authorsStr}</p>
                                    ${containerTitle ? `<span>•</span><p>${containerTitle}</p>` : ''}
                                    ${dateStr ? `<span>•</span><p>${dateStr}</p>` : ''}
                                </div>
                            </div>
                            <button onclick="saveFromSearch('${safeTitle}', '${safeAuthors}', '${safeJournal}', '${dateStr}', '${doi}', '${url}', '${source}')" class="flex-shrink-0 rounded-md bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700 shadow-sm ring-1 ring-inset ring-emerald-200 hover:bg-emerald-100 transition">
                                + Simpan
                            </button>
                        </div>
                    </li>`;
                });
                document.getElementById('results-list').innerHTML = html;
                document.getElementById('results-container').classList.remove('hidden');
            } else {
                document.getElementById('no-results').classList.remove('hidden');
            }
        }

        // ===== Save from Crossref/DOAJ Search =====
        function saveFromSearch(title, authors, journal, year, doi, url, sourceName) {
            saveReference({
                title: title, authors: authors, journal: journal,
                year: year, doi: doi, url: url,
                source: sourceName, citation_format: 'APA'
            });
        }

        // ===== Save Manual Reference =====
        function saveManualReference() {
            const title = document.getElementById('manual-title').value;
            if (!title) { alert('Judul wajib diisi'); return; }

            saveReference({
                title: title,
                authors: document.getElementById('manual-authors').value,
                journal: document.getElementById('manual-journal').value,
                year: document.getElementById('manual-year').value,
                doi: document.getElementById('manual-doi').value,
                url: document.getElementById('manual-url').value,
                source: 'manual',
                citation_format: document.getElementById('manual-format').value
            });

            // Clear form
            ['manual-title', 'manual-authors', 'manual-journal', 'manual-year', 'manual-doi', 'manual-url'].forEach(id => {
                document.getElementById(id).value = '';
            });
        }

        // ===== Upload PDF =====
        function uploadPdfFile(e) {
            const file = e.target.files[0];
            if (!file) return;

            document.getElementById('upload-result-container').classList.remove('hidden');
            document.getElementById('upload-loading').classList.remove('hidden');
            document.getElementById('upload-loading').classList.add('flex');
            document.getElementById('upload-success').classList.add('hidden');

            const formData = new FormData();
            formData.append('pdf_file', file);

            fetch(`/user/projects/${PROJECT_ID}/literature/upload`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('upload-loading').classList.add('hidden');
                document.getElementById('upload-loading').classList.remove('flex');

                if (data.success) {
                    extractedPdfText = data.text;
                    document.getElementById('extracted-text-content').textContent = data.text;
                    document.getElementById('upload-success').classList.remove('hidden');
                    // Pre-fill filename as title
                    document.getElementById('pdf-ref-title').value = data.filename.replace('.pdf', '');
                } else {
                    document.getElementById('upload-result-container').classList.add('hidden');
                    alert(data.message || 'Gagal mengekstrak PDF');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('upload-loading').classList.add('hidden');
                document.getElementById('upload-loading').classList.remove('flex');
                document.getElementById('upload-result-container').classList.add('hidden');
                alert('Terjadi kesalahan koneksi.');
            });

            e.target.value = '';
        }

        // ===== Save PDF as Reference =====
        function savePdfAsReference() {
            const title = document.getElementById('pdf-ref-title').value;
            if (!title) { alert('Judul wajib diisi'); return; }

            saveReference({
                title: title,
                authors: document.getElementById('pdf-ref-authors').value,
                journal: document.getElementById('pdf-ref-journal').value,
                year: document.getElementById('pdf-ref-year').value,
                source: 'pdf',
                citation_format: 'APA',
                pdf_extracted_text: extractedPdfText.substring(0, 5000)
            });
        }

        // ===== Generic Save Reference =====
        function saveReference(data) {
            fetch(`/user/projects/${PROJECT_ID}/literature/references`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    // Add to DOM
                    addReferenceToList(result.reference);
                    updateRefCount(1);
                    alert('Referensi berhasil disimpan!');
                } else {
                    alert(result.message || 'Gagal menyimpan referensi');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            });
        }

        // ===== Add Reference to DOM =====
        function addReferenceToList(ref) {
            // Remove empty state
            const empty = document.getElementById('refs-empty');
            if (empty) empty.remove();

            const container = document.getElementById('references-list-container');
            const sourceClass = ref.source === 'crossref' ? 'bg-blue-100 text-blue-700' : (ref.source === 'doaj' ? 'bg-orange-100 text-orange-700' : (ref.source === 'pdf' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600'));
            const linkHtml = (ref.url || ref.doi) ? `<a href="${ref.url || 'https://doi.org/'+ref.doi}" target="_blank" class="p-1.5 text-gray-400 hover:text-emerald-600 transition" title="Buka Link"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg></a>` : '';

            const html = `
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:border-emerald-200 transition" id="ref-item-${ref.id}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 leading-snug">${ref.title}</h4>
                        <div class="mt-1 flex flex-wrap items-center gap-x-2 text-xs text-gray-500">
                            ${ref.authors ? `<span>${ref.authors}</span>` : ''}
                            ${ref.journal ? `<span>• ${ref.journal}</span>` : ''}
                            ${ref.year ? `<span>• ${ref.year}</span>` : ''}
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ${sourceClass}">${(ref.source||'manual').toUpperCase()}</span>
                        </div>
                        ${ref.citation_text ? `<div class="mt-2 bg-gray-50 rounded-md px-3 py-2 text-xs text-gray-700 italic border border-gray-100"><span class="text-emerald-600 font-semibold not-italic">[${ref.citation_format}]</span> ${ref.citation_text}</div>` : ''}
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <select onchange="changeCitationFormat(${ref.id}, this.value)" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-1">
                            <option value="APA" ${ref.citation_format==='APA'?'selected':''}>APA</option>
                            <option value="IEEE" ${ref.citation_format==='IEEE'?'selected':''}>IEEE</option>
                            <option value="MLA" ${ref.citation_format==='MLA'?'selected':''}>MLA</option>
                            <option value="CHICAGO" ${ref.citation_format==='CHICAGO'?'selected':''}>Chicago</option>
                            <option value="VANCOUVER" ${ref.citation_format==='VANCOUVER'?'selected':''}>Vancouver</option>
                        </select>
                        ${linkHtml}
                        <button onclick="copyReference(${ref.id})" class="p-1.5 text-gray-400 hover:text-emerald-600 transition" title="Salin Sitasi"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg></button>
                        <button onclick="deleteReference(${ref.id})" class="p-1.5 text-gray-400 hover:text-red-600 transition" title="Hapus"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>
                    </div>
                </div>
            </div>`;

            container.insertAdjacentHTML('afterbegin', html);
        }

        // ===== Change Citation Format =====
        function changeCitationFormat(refId, format) {
            fetch(`/user/projects/${PROJECT_ID}/literature/references/${refId}/citation`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ format: format })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update citation text in DOM
                    const item = document.getElementById('ref-item-' + refId);
                    if (item) {
                        const citDiv = item.querySelector('.italic');
                        if (citDiv) {
                            citDiv.innerHTML = `<span class="text-emerald-600 font-semibold not-italic">[${data.format}]</span> ${data.citation}`;
                        }
                    }
                }
            })
            .catch(err => console.error(err));
        }

        // ===== Copy Citation =====
        function copyReference(refId) {
            const item = document.getElementById('ref-item-' + refId);
            if (item) {
                const citDiv = item.querySelector('.italic');
                if (citDiv) {
                    const text = citDiv.textContent.replace(/\[.*?\]\s*/, '');
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Sitasi berhasil disalin ke clipboard!');
                    });
                }
            }
        }

        // ===== Delete Reference =====
        function deleteReference(refId) {
            if (!confirm('Yakin ingin menghapus referensi ini?')) return;

            fetch(`/user/projects/${PROJECT_ID}/literature/references/${refId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const item = document.getElementById('ref-item-' + refId);
                    if (item) item.remove();
                    updateRefCount(-1);
                }
            })
            .catch(err => console.error(err));
        }

        // ===== Update Badge Count =====
        function updateRefCount(delta) {
            const badge = document.getElementById('ref-count-badge');
            let count = parseInt(badge.textContent) + delta;
            if (count < 0) count = 0;
            badge.textContent = count;
        }
    </script>
    @endpush
</x-user-layout>
