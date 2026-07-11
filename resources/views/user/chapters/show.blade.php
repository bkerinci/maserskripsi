<x-user-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('user.projects.show', $project) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    Kembali ke Project
                </a>
                <h2 class="text-2xl font-bold text-gray-900">{{ $chapter->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">Project: {{ $project->title }}</p>
            </div>
            
            <div class="hidden sm:block">
                @php
                    $totalSections = $chapter->sections->count();
                    $filledSections = $chapter->sections->whereNotNull('content')->count();
                    $progress = $totalSections > 0 ? round(($filledSections / $totalSections) * 100) : 0;
                @endphp
                <div class="text-right">
                    <span class="text-sm font-semibold text-gray-700">Progress Bab: {{ $progress }}%</span>
                    <div class="w-48 bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-{{ $progress == 100 ? 'green' : 'blue' }}-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Daftar Subbab -->
        <div class="w-full lg:w-1/4" x-data="{ showList: false }">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm sticky top-6">
                <div @click="showList = !showList" class="p-4 border-b border-gray-100 bg-gray-50/50 rounded-t-xl cursor-pointer lg:cursor-default flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Daftar Subbab</h3>
                    <span class="lg:hidden text-gray-500">
                        <svg class="h-5 w-5 transform transition-transform duration-200" :class="showList ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
                <div x-show="showList" class="lg:!block" style="display: none;">
                    <ul id="sections-list" class="divide-y divide-gray-100 max-h-[calc(100vh-200px)] overflow-y-auto">
                        @foreach($chapter->sections as $section)
                            <li class="section-item relative group bg-white" data-id="{{ $section->id }}">
                                <div class="flex items-center justify-between p-4 hover:bg-blue-50 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="cursor-move text-gray-300 hover:text-gray-500 section-drag-handle">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                        </span>
                                        <a href="#section-{{ $section->id }}" class="text-sm font-medium {{ empty($section->content) ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ $section->title }}
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button onclick="openEditSectionModal({{ $section->id }}, '{{ addslashes($section->title) }}')" class="text-blue-600 bg-blue-50 p-1.5 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors border border-blue-100 shadow-sm" title="Edit Judul">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                        </button>
                                        @if(!empty($section->content))
                                            <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="p-4 border-t border-gray-100">
                        <button onclick="document.getElementById('modal-tambah-subbab').classList.remove('hidden')" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Tambah Subbab Manual
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editor Area -->
        <div class="w-full lg:w-3/4 space-y-8">
            @foreach($chapter->sections as $section)
                <div id="section-{{ $section->id }}" class="bg-white border border-gray-200 rounded-xl shadow-sm scroll-mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-t-xl">
                        <h3 class="text-lg font-bold text-gray-900">{{ $section->title }}</h3>
                        
                        <div class="flex items-center gap-2">
                            <!-- Tombol Generate AI -->
                            <form action="{{ route('user.chapters.sections.generate', [$project, $section]) }}" method="POST" onsubmit="return confirmGenerate()">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-100 border border-indigo-200 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                                    </svg>
                                    {{ empty($section->content) ? 'Tulis dengan AI' : 'Generate Ulang' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Form Simpan Manual -->
                        <form action="{{ route('user.chapters.sections.update', [$project, $section]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label for="content-{{ $section->id }}" class="sr-only">Isi {{ $section->title }}</label>
                                <textarea name="content" id="content-{{ $section->id }}" class="tinymce-editor block w-full rounded-lg border-2 border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600 sm:text-sm">{{ old('content', $section->content) }}</textarea>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah Subbab -->
    <div id="modal-tambah-subbab" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="document.getElementById('modal-tambah-subbab').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-indigo-100 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Tambah Subbab Baru</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Masukkan judul subbab yang ingin Anda tambahkan secara manual ke dalam {{ $chapter->title }}.</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('user.chapters.sections.store', [$project, $chapter]) }}" method="POST" class="mt-5 sm:mt-6">
                    @csrf
                    <div class="space-y-4 mb-5 text-left">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Subbab</label>
                            <input type="text" name="title" required placeholder="Contoh: 1.6 Sistematika Penulisan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="document.getElementById('modal-tambah-subbab').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Subbab -->
    <div id="modal-edit-subbab" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="document.getElementById('modal-edit-subbab').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit Judul Subbab</h3>
                    </div>
                </div>
                <form id="form-edit-subbab" method="POST" class="mt-5 sm:mt-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4 mb-5 text-left">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Subbab</label>
                            <input type="text" id="edit-subbab-title" name="title" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="document.getElementById('modal-edit-subbab').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        function confirmGenerate() {
            return confirm('Anda yakin ingin (me)nulis subbab ini menggunakan AI? Jika sudah ada teks sebelumnya, teks tersebut akan terganti dengan hasil baru dari AI.');
        }

        // Modal Edit Subbab
        function openEditSectionModal(sectionId, title) {
            document.getElementById('edit-subbab-title').value = title;
            document.getElementById('form-edit-subbab').action = `/user/projects/{{ $project->id }}/chapters/sections/${sectionId}/rename`;
            document.getElementById('modal-edit-subbab').classList.remove('hidden');
        }

        // Sortable
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('sections-list');
            if (el) {
                new Sortable(el, {
                    handle: '.section-drag-handle',
                    animation: 150,
                    ghostClass: 'bg-indigo-50',
                    onEnd: function (evt) {
                        let sectionOrder = [];
                        el.querySelectorAll('.section-item').forEach(function(item) {
                            sectionOrder.push(item.dataset.id);
                        });

                        fetch('{{ route("user.chapters.sections.reorder", [$project, $chapter]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ order: sectionOrder })
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
    
    <!-- TinyMCE (Self-hosted via CDNJS to avoid API key warning) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '.tinymce-editor',
                height: 400,
                menubar: false,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | ai_rewrite ai_expand ai_shorten ai_formal ai_grammar',
                setup: function (editor) {
                    
                    const processAi = (actionName) => {
                        const selectedText = editor.selection.getContent({format: 'text'});
                        if (!selectedText) {
                            alert('Silakan blok/pilih teks terlebih dahulu untuk diproses oleh AI.');
                            return;
                        }

                        editor.setProgressState(true);

                        fetch('{{ route("user.ai-editor.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                action: actionName,
                                text: selectedText
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            editor.setProgressState(false);
                            if (data.success) {
                                if (actionName === 'grammar') {
                                    alert(data.result);
                                } else {
                                    editor.selection.setContent(data.result);
                                }
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(err => {
                            editor.setProgressState(false);
                            alert('Gagal memproses AI');
                            console.error(err);
                        });
                    };

                    editor.ui.registry.addButton('ai_rewrite', {
                        text: '✨ Rewrite',
                        tooltip: 'Parafrase kalimat yang dipilih',
                        onAction: () => processAi('rewrite')
                    });
                    
                    editor.ui.registry.addButton('ai_expand', {
                        text: '📏 Expand',
                        tooltip: 'Perpanjang teks yang dipilih',
                        onAction: () => processAi('expand')
                    });

                    editor.ui.registry.addButton('ai_shorten', {
                        text: '✂️ Shorten',
                        tooltip: 'Perpendek teks yang dipilih',
                        onAction: () => processAi('shorten')
                    });

                    editor.ui.registry.addButton('ai_formal', {
                        text: '👔 Formal',
                        tooltip: 'Ubah ke bahasa akademis/formal',
                        onAction: () => processAi('formal')
                    });

                    editor.ui.registry.addButton('ai_grammar', {
                        text: '📝 Grammar',
                        tooltip: 'Cek tata bahasa (LanguageTool)',
                        onAction: () => processAi('grammar')
                    });
                }
            });
        });
    </script>
    @endpush
</x-user-layout>
