<x-user-layout>
    <x-slot name="header">
        Workspace: {{ Str::limit($project->title, 50) }}
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content Area -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Project Header Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $project->title }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $project->university ?? 'Universitas -' }} • {{ $project->study_program ?? 'Prodi -' }} • {{ $project->degree_level ?? 'Jenjang -' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ str_replace('_', ' ', ucfirst($project->status)) }}
                        </span>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1 text-xs uppercase font-semibold">Jenis Penelitian</p>
                        <p class="font-medium text-gray-900">{{ $project->research_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1 text-xs uppercase font-semibold">Topik</p>
                        <p class="font-medium text-gray-900">{{ $project->topic ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1 text-xs uppercase font-semibold">Pembimbing</p>
                        <p class="font-medium text-gray-900">{{ $project->advisor_name ?? '-' }}</p>
                    </div>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('user.projects.edit', $project) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit Data</a>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- AI Proposal Generator (Aktif) -->
                <a href="{{ route('user.proposal.index', $project) }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition cursor-pointer">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">AI Proposal Generator</h3>
                    <p class="mt-2 text-sm text-gray-500">Buat draf Bab 1, 2, dan 3 secara otomatis menggunakan AI.</p>
                </a>

                <!-- BAB Generator -->
                <a href="{{ $project->chapters->isNotEmpty() ? route('user.chapters.show', [$project, $project->chapters->first()]) : '#' }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition cursor-pointer">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">AI BAB Generator</h3>
                    <p class="mt-2 text-sm text-gray-500">Hasilkan pembahasan per subbab dengan AI Academic Writer.</p>
                </a>

                <!-- Literature Review -->
                <a href="{{ route('user.literature.index', $project) }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition cursor-pointer">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Literature Review</h3>
                    <p class="mt-2 text-sm text-gray-500">Cari referensi dari jurnal atau upload PDF untuk di-review otomatis.</p>
                </a>

                <!-- Statistik & Metodologi -->
                <a href="{{ route('user.statistics.index', $project) }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition cursor-pointer">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">AI Statistik & Metodologi</h3>
                    <p class="mt-2 text-sm text-gray-500">Buat instrumen penelitian, uji validitas, dan analisis data kuantitatif.</p>
                </a>
            </div>
        </div>

        <!-- Sidebar / Dokumen Status -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">Dokumen Skripsi</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4" id="chapters-list">
                        @forelse($project->chapters as $chapter)
                            @php
                                $totalSections = $chapter->sections->count();
                                $filledSections = $chapter->sections->whereNotNull('content')->count();
                                $progress = $totalSections > 0 ? round(($filledSections / $totalSections) * 100) : 0;
                            @endphp
                            <div class="chapter-item block p-3 rounded-lg border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 transition relative group" data-id="{{ $chapter->id }}">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="cursor-move text-gray-300 hover:text-gray-500 chapter-drag-handle">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                        </span>
                                        <a href="{{ route('user.chapters.show', [$project, $chapter]) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 flex items-center gap-2">
                                            {{ $chapter->title }}
                                        </a>
                                        <button onclick="openEditChapterModal(this, {{ $chapter->id }})" data-title="{{ $chapter->title }}" class="text-blue-600 bg-blue-50 p-1.5 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors border border-blue-100 shadow-sm" title="Edit Judul">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                        </button>
                                        <a href="{{ route('user.export.chapter.docx', [$project, $chapter]) }}" class="text-emerald-600 bg-emerald-50 p-1.5 rounded-md hover:bg-emerald-100 hover:text-emerald-700 transition-colors border border-emerald-100 shadow-sm" title="Download Word Bab">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-xs font-medium {{ $progress == 100 ? 'text-green-600' : 'text-gray-500' }}">{{ $progress }}%</span>
                                </div>
                                <!-- Progress Bar -->
                                <a href="{{ route('user.chapters.show', [$project, $chapter]) }}" class="block">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-{{ $progress == 100 ? 'green' : 'blue' }}-600 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="text-center text-sm text-gray-500 py-4">Belum ada struktur bab.</div>
                        @endforelse
                    </div>

                    <button onclick="document.getElementById('modal-tambah-bab').classList.remove('hidden')" class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Bab Manual
                    </button>
                    
                    <a href="{{ route('user.export.pdf', $project) }}" target="_blank" class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Export ke PDF
                    </a>

                    <a href="{{ route('user.export.docx', $project) }}" class="mt-2 w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm font-medium text-blue-700 hover:bg-blue-100 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Export DOCX (Word)
                    </a>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                <svg class="mx-auto h-10 w-10 text-blue-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.428-1.428L13.5 18.75l1.183-.394a2.25 2.25 0 001.428-1.428l.394-1.183.394 1.183a2.25 2.25 0 001.428 1.428l1.183.394-1.183.394a2.25 2.25 0 00-1.428 1.428z" /></svg>
                <h3 class="text-sm font-bold text-blue-900 mb-1">Butuh Bantuan AI?</h3>
                <p class="text-xs text-blue-700 mb-4">AI Writer siap membantu Anda merangkai kata secara otomatis.</p>
                <a href="{{ $project->chapters->isNotEmpty() ? route('user.chapters.show', [$project, $project->chapters->first()]) : '#' }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 shadow-sm transition-colors">
                    Buka Editor AI
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Bab -->
    <div id="modal-tambah-bab" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="document.getElementById('modal-tambah-bab').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-indigo-100 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Tambah Bab Baru</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Masukkan nomor dan judul bab yang ingin Anda tambahkan secara manual.</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('user.chapters.store', $project) }}" method="POST" class="mt-5 sm:mt-6">
                    @csrf
                    <div class="space-y-4 mb-5 text-left">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Bab</label>
                            <input type="number" name="chapter_number" required min="1" value="{{ $project->chapters->max('chapter_number') + 1 }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Bab</label>
                            <input type="text" name="title" required placeholder="Contoh: Bab 6 - Lampiran Tambahan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="document.getElementById('modal-tambah-bab').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Bab -->
    <div id="modal-edit-bab" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="document.getElementById('modal-edit-bab').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit Judul Bab</h3>
                    </div>
                </div>
                <form id="form-edit-bab" method="POST" class="mt-5 sm:mt-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 mb-5 text-left">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Bab</label>
                            <input type="text" id="edit-bab-title" name="title" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="document.getElementById('modal-edit-bab').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        // Modal Edit Bab
        function openEditChapterModal(first, second) {
            let title = '';
            let chapterId = null;

            if (typeof first === 'object' && first !== null) {
                title = first.getAttribute('data-title') || '';
                chapterId = second;
            } else {
                chapterId = first;
                title = second || '';
            }

            document.getElementById('edit-bab-title').value = title;
            document.getElementById('form-edit-bab').action = `/user/projects/{{ $project->id }}/chapters/${chapterId}/rename`;
            document.getElementById('modal-edit-bab').classList.remove('hidden');
        }

        // Sortable
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('chapters-list');
            if (el) {
                new Sortable(el, {
                    handle: '.chapter-drag-handle',
                    animation: 150,
                    ghostClass: 'bg-indigo-50',
                    onEnd: function (evt) {
                        let chapterOrder = [];
                        el.querySelectorAll('.chapter-item').forEach(function(item) {
                            chapterOrder.push(item.dataset.id);
                        });

                        fetch('{{ route("user.chapters.reorder", $project) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ order: chapterOrder })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                console.log('Reorder saved');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal menyimpan urutan.');
                        });
                    }
                });
            }
        });
    </script>
</x-user-layout>
