<x-admin-layout>
    <x-slot name="header">
        Edit Persona AI
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">Edit Persona: {{ $persona->name }}</h2>
        <a href="{{ route('admin.personas.index') }}" class="text-gray-500 hover:text-gray-700">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.personas.update', $persona) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Persona</label>
                    <input type="text" name="name" id="name" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required value="{{ old('name', $persona->name) }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required>{{ old('description', $persona->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="system_prompt" class="block text-sm font-medium text-gray-700">System Prompt</label>
                    <textarea name="system_prompt" id="system_prompt" rows="5" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">{{ old('system_prompt', $persona->system_prompt) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Instruksi sistem yang akan digunakan AI saat menggunakan persona ini.</p>
                    @error('system_prompt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Update Persona</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
