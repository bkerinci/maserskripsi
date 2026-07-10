<x-user-layout>
    <x-slot name="header">
        Buat Project Baru
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">Wizard Pembuatan Skripsi / Penelitian</h3>
                <p class="mt-1 text-sm text-gray-500">Isi data dasar penelitian Anda. AI akan menyesuaikan gaya dan metodologi berdasarkan parameter ini.</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('user.projects.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Step 1: Data Dasar -->
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">1</span>
                            Data Dasar
                        </h4>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Penelitian / Skripsi <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" required value="{{ old('title', request('title')) }}" placeholder="Contoh: Pengaruh AI Terhadap Kinerja Mahasiswa" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="university" class="block text-sm font-medium text-gray-700">Universitas</label>
                                <input type="text" name="university" id="university" value="{{ old('university') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                            </div>

                            <div>
                                <label for="faculty" class="block text-sm font-medium text-gray-700">Fakultas</label>
                                <input type="text" name="faculty" id="faculty" value="{{ old('faculty') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                            </div>

                            <div>
                                <label for="study_program" class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <input type="text" name="study_program" id="study_program" value="{{ old('study_program') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                            </div>

                            <div>
                                <label for="degree_level" class="block text-sm font-medium text-gray-700">Jenjang</label>
                                <select name="degree_level" id="degree_level" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="D3" {{ old('degree_level') == 'D3' ? 'selected' : '' }}>D3 - Diploma</option>
                                    <option value="S1" {{ old('degree_level') == 'S1' ? 'selected' : '' }}>S1 - Sarjana</option>
                                    <option value="S2" {{ old('degree_level') == 'S2' ? 'selected' : '' }}>S2 - Magister</option>
                                    <option value="S3" {{ old('degree_level') == 'S3' ? 'selected' : '' }}>S3 - Doktoral</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Jenis Penelitian -->
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">2</span>
                            Jenis Penelitian
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @php
                                $researchTypes = [
                                    'Kuantitatif', 'Kualitatif', 'Mixed Method', 
                                    'R&D', 'Studi Literatur', 'Eksperimen'
                                ];
                            @endphp
                            @foreach($researchTypes as $type)
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="research_type" value="{{ $type }}" class="sr-only peer" {{ old('research_type') == $type ? 'checked' : '' }}>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900 peer-checked:text-blue-600">{{ $type }}</span>
                                    </span>
                                </span>
                                <svg class="h-5 w-5 text-blue-600 hidden peer-checked:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span class="pointer-events-none absolute -inset-px rounded-lg border-2 border-transparent peer-checked:border-blue-600" aria-hidden="true"></span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 3: Topik -->
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">3</span>
                            Topik & Info Tambahan
                        </h4>
                        <div class="grid grid-cols-1 gap-y-6">
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700">Topik atau Area Penelitian</label>
                                <input type="text" name="topic" id="topic" value="{{ old('topic') }}" placeholder="Contoh: Machine Learning, Pendidikan, Hukum Bisnis..." class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                            </div>
                            <div>
                                <label for="advisor_name" class="block text-sm font-medium text-gray-700">Nama Pembimbing (Opsional)</label>
                                <input type="text" name="advisor_name" id="advisor_name" value="{{ old('advisor_name') }}" placeholder="Dr. Ahmad" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('user.projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Batal</a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2 shadow-sm">
                            Selesai & Masuk Workspace
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-user-layout>
