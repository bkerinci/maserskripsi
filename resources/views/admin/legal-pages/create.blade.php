<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Legal Page
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.legal-pages.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul (Title)</label>
                                <input type="text" name="title" id="title" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" value="{{ old('title') }}" required>
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
                                <input type="text" name="slug" id="slug" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" value="{{ old('slug') }}" placeholder="contoh: terms-of-service" required>
                                @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700">Bahasa</label>
                                <input type="text" name="language" id="language" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" value="{{ old('language', 'EN') }}" required>
                            </div>
                            
                            <div>
                                <label for="version" class="block text-sm font-medium text-gray-700">Versi</label>
                                <input type="text" name="version" id="version" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" value="{{ old('version', 'v1.0.0') }}" required>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required>
                                    <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Konten (Mendukung HTML)</label>
                            <textarea name="content" id="content" rows="15" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors font-mono" required>{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.legal-pages.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
