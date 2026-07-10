<x-admin-layout>
    <x-slot name="header">
        Personas AI
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Manajemen Personas</h2>
        <a href="{{ route('admin.personas.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Tambah Persona</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($personas as $persona)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6 items-start md:items-center hover:border-blue-300 transition-colors">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 font-bold text-lg border border-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                
                <div class="flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $persona->name }}</h3>
                    <p class="text-sm text-gray-500">{{ Str::limit($persona->description, 150) }}</p>
                </div>

                <div class="flex-shrink-0 w-full md:w-auto flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('admin.personas.edit', $persona) }}" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-transparent">Edit</a>
                    <form action="{{ route('admin.personas.destroy', $persona) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus persona ini?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 font-semibold text-sm rounded-lg hover:bg-red-600 hover:text-white transition-colors border border-red-100 hover:border-transparent">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-500">Belum ada persona AI.</p>
            </div>
        @endforelse
    </div>
    @if($personas->hasPages())
        <div class="mt-6">
            {{ $personas->links() }}
        </div>
    @endif
</x-admin-layout>
