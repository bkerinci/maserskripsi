<x-user-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('user.projects.show', $project) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                    Kembali ke Project
                </a>
                <h2 class="text-2xl font-bold text-gray-900">AI Proposal Generator</h2>
                <p class="text-sm text-gray-500 mt-1">Project: {{ $project->title }}</p>
            </div>
            
            <div class="hidden sm:block">
                <div class="text-right">
                    <span class="text-sm font-semibold text-gray-700">Progress Proposal: <span id="progress-text">{{ $progress }}</span>%</span>
                    <div class="w-48 bg-gray-200 rounded-full h-2 mt-1">
                        <div id="progress-bar" class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-8 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50 text-center">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Mulai Generate Proposal Otomatis</h3>
                <p class="mt-2 text-sm text-gray-600 max-w-2xl mx-auto">Sistem akan menyusun Bab 1 (Pendahuluan), Bab 2 (Tinjauan Pustaka), dan Bab 3 (Metodologi) secara berurutan. Biarkan halaman ini tetap terbuka sampai proses selesai.</p>
                
                <div class="mt-6">
                    <button id="btn-start" onclick="startGeneration()" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" /></svg>
                        Mulai Generate Sekarang
                    </button>
                    <button id="btn-stop" onclick="stopGeneration()" class="hidden inline-flex items-center gap-2 px-6 py-3 bg-red-100 text-red-700 font-bold rounded-lg hover:bg-red-200 shadow-sm transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z" /></svg>
                        Hentikan Proses
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    @foreach($chapters as $chapter)
                        <div>
                            <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2 mb-3">{{ $chapter->title }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($chapter->sections as $section)
                                    <div id="section-card-{{ $section->id }}" class="flex items-center justify-between p-3 rounded-lg border {{ empty($section->content) ? 'border-gray-200 bg-white' : 'border-green-200 bg-green-50' }} shadow-sm" data-id="{{ $section->id }}" data-status="{{ empty($section->content) ? 'pending' : 'done' }}">
                                        <div class="flex items-center gap-3">
                                            <div id="icon-pending-{{ $section->id }}" class="{{ empty($section->content) ? '' : 'hidden' }} text-gray-400">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <div id="icon-loading-{{ $section->id }}" class="hidden text-indigo-500 animate-spin">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            </div>
                                            <div id="icon-done-{{ $section->id }}" class="{{ !empty($section->content) ? '' : 'hidden' }} text-green-500">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <div id="icon-error-{{ $section->id }}" class="hidden text-red-500">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            </div>
                                            
                                            <span class="text-sm font-medium {{ empty($section->content) ? 'text-gray-700' : 'text-green-800' }}">{{ $section->title }}</span>
                                        </div>
                                        <span id="status-text-{{ $section->id }}" class="text-xs font-semibold {{ empty($section->content) ? 'text-gray-400' : 'text-green-600' }}">
                                            {{ empty($section->content) ? 'Menunggu' : 'Selesai' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        let isGenerating = false;
        let pendingSections = [];
        let totalSections = {{ $totalSections }};
        let filledSectionsCount = {{ $filledSections }};

        document.addEventListener('DOMContentLoaded', () => {
            // Collect all pending sections
            const cards = document.querySelectorAll('[id^="section-card-"]');
            cards.forEach(card => {
                if (card.getAttribute('data-status') === 'pending') {
                    pendingSections.push(card.getAttribute('data-id'));
                }
            });
            
            if (pendingSections.length === 0) {
                document.getElementById('btn-start').innerText = 'Proposal Sudah Lengkap';
                document.getElementById('btn-start').disabled = true;
            }
        });

        async function startGeneration() {
            if (pendingSections.length === 0) return;
            
            isGenerating = true;
            document.getElementById('btn-start').classList.add('hidden');
            document.getElementById('btn-stop').classList.remove('hidden');

            for (let i = 0; i < pendingSections.length; i++) {
                if (!isGenerating) break; // If user clicked stop
                
                let sectionId = pendingSections[i];
                await generateSection(sectionId);
            }

            isGenerating = false;
            document.getElementById('btn-stop').classList.add('hidden');
            document.getElementById('btn-start').classList.remove('hidden');
            
            if (filledSectionsCount === totalSections) {
                document.getElementById('btn-start').innerText = 'Proposal Selesai!';
                document.getElementById('btn-start').disabled = true;
                alert('Selamat! Draf Proposal Anda (Bab 1-3) telah selesai disusun oleh AI. Anda dapat meninjaunya di menu Dokumen Skripsi.');
            }
        }

        function stopGeneration() {
            isGenerating = false;
            document.getElementById('btn-stop').classList.add('hidden');
            document.getElementById('btn-start').classList.remove('hidden');
            document.getElementById('btn-start').innerText = 'Lanjutkan Generate';
        }

        async function generateSection(id) {
            // Update UI to Loading
            document.getElementById(`icon-pending-${id}`).classList.add('hidden');
            document.getElementById(`icon-error-${id}`).classList.add('hidden');
            document.getElementById(`icon-loading-${id}`).classList.remove('hidden');
            document.getElementById(`status-text-${id}`).innerText = 'Menulis...';
            document.getElementById(`status-text-${id}`).classList.replace('text-gray-400', 'text-indigo-600');
            document.getElementById(`section-card-${id}`).classList.replace('border-gray-200', 'border-indigo-300');
            document.getElementById(`section-card-${id}`).classList.replace('bg-white', 'bg-indigo-50');

            try {
                const response = await fetch("{{ route('user.proposal.generate-section', $project) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ section_id: id })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Success UI
                    document.getElementById(`icon-loading-${id}`).classList.add('hidden');
                    document.getElementById(`icon-done-${id}`).classList.remove('hidden');
                    document.getElementById(`status-text-${id}`).innerText = 'Selesai';
                    document.getElementById(`status-text-${id}`).classList.replace('text-indigo-600', 'text-green-600');
                    document.getElementById(`section-card-${id}`).classList.replace('border-indigo-300', 'border-green-200');
                    document.getElementById(`section-card-${id}`).classList.replace('bg-indigo-50', 'bg-green-50');
                    document.getElementById(`section-card-${id}`).setAttribute('data-status', 'done');

                    // Remove from pending
                    pendingSections = pendingSections.filter(sId => sId !== id);
                    
                    // Update progress
                    filledSectionsCount++;
                    updateProgress();
                } else {
                    throw new Error(data.message || 'Server error');
                }
            } catch (error) {
                // Error UI
                document.getElementById(`icon-loading-${id}`).classList.add('hidden');
                document.getElementById(`icon-error-${id}`).classList.remove('hidden');
                document.getElementById(`status-text-${id}`).innerText = 'Gagal';
                document.getElementById(`status-text-${id}`).classList.replace('text-indigo-600', 'text-red-600');
                document.getElementById(`section-card-${id}`).classList.replace('border-indigo-300', 'border-red-200');
                document.getElementById(`section-card-${id}`).classList.replace('bg-indigo-50', 'bg-red-50');
                
                // Stop the entire loop so the user can see there was an error
                console.error("Generate error:", error);
                isGenerating = false;
                alert('Terjadi kesalahan jaringan atau respons API. Proses dihentikan otomatis. Silakan coba klik Lanjutkan lagi.');
            }
        }

        function updateProgress() {
            let pct = totalSections > 0 ? Math.round((filledSectionsCount / totalSections) * 100) : 0;
            document.getElementById('progress-text').innerText = pct;
            document.getElementById('progress-bar').style.width = pct + '%';
            if (pct === 100) {
                document.getElementById('progress-bar').classList.replace('bg-indigo-600', 'bg-green-600');
            }
        }
    </script>
</x-user-layout>
