<x-admin-layout>
    <x-slot name="header">
        Prompts AI
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Manajemen Prompts</h2>
        <a href="{{ route('admin.prompts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Tambah Prompt</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($prompts as $prompt)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6 items-start md:items-center hover:border-blue-300 transition-colors">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-teal-50 text-teal-600 font-bold text-lg border border-teal-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                
                <div class="flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $prompt->title }}</h3>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="inline-flex items-center px-2 py-1 rounded-md border bg-blue-50 border-blue-200 text-blue-700">
                            Tipe: {{ $prompt->type ?? 'Umum' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-md border bg-gray-50 border-gray-200 text-gray-700">
                            Persona: {{ $prompt->persona->name ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex-shrink-0 w-full md:w-auto flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('admin.prompts.edit', $prompt) }}" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-transparent">Edit</a>
                    <form action="{{ route('admin.prompts.destroy', $prompt) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prompt ini?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 font-semibold text-sm rounded-lg hover:bg-red-600 hover:text-white transition-colors border border-red-100 hover:border-transparent">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-500">Belum ada prompt AI.</p>
            </div>
        @endforelse
    </div>
    @if($prompts->hasPages())
        <div class="mt-6">
            {{ $prompts->links() }}
        </div>
    @endif
</x-admin-layout>
