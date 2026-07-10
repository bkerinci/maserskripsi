<x-admin-layout>
    <x-slot name="header">
        Tambah Prompt AI
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">Tambah Prompt Baru</h2>
        <a href="{{ route('admin.prompts.index') }}" class="text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.prompts.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Prompt</label>
                    <input type="text" name="title" id="title" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required value="{{ old('title') }}">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Prompt</label>
                    <input type="text" name="type" id="type" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" value="{{ old('type') }}">
                    <p class="mt-1 text-sm text-gray-500">Contoh: judul, bab1, bab2, dsb.</p>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="persona_id" class="block text-sm font-medium text-gray-700">Persona</label>
                    <select name="persona_id" id="persona_id" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">
                        <option value="">-- Pilih Persona (Opsional) --</option>
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>{{ $persona->name }}</option>
                        @endforeach
                    </select>
                    @error('persona_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700">Konten Prompt</label>
                    <textarea name="content" id="content" rows="6" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required>{{ old('content') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Gunakan placeholder seperti {topic} jika perlu.</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Simpan Prompt</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
