<x-admin-layout>
    <x-slot name="header">
        Tambah Paket Langganan
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.subscription-plans.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Paket</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <div class="p-6">
            <form action="{{ route('admin.subscription-plans.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Paket</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors" required>
                    <p class="text-xs text-gray-500 mt-1">Gunakan angka saja, contoh: 99000 (Gunakan 0 untuk Custom/Gratis).</p>
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="features" class="block text-sm font-medium text-gray-700">Fitur (Pisahkan dengan baris baru / enter)</label>
                    <textarea name="features" id="features" rows="5" class="mt-2 block w-full rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-600 sm:text-sm transition-colors">{{ old('features') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Setiap baris akan ditampilkan sebagai satu poin (checklist) pada tampilan harga.</p>
                    @error('features') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Simpan Paket</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
