<x-admin-layout>
    <x-slot name="header">
        Manajemen User
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Daftar Pengguna</h2>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($users as $user)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6 items-start md:items-center hover:border-blue-300 transition-colors">
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 font-bold text-lg border border-blue-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                
                <div class="flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="inline-flex items-center px-2 py-1 rounded-md border {{ $user->role === 'admin' ? 'bg-purple-50 border-purple-200 text-purple-700' : 'bg-green-50 border-green-200 text-green-700' }}">
                            Role: {{ ucfirst($user->role) }}
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-md border bg-gray-50 border-gray-200 text-gray-700">
                            IP Terakhir: {{ $user->last_login_ip ?? 'Belum pernah' }}
                        </span>
                    </div>
                </div>

                <div class="flex-shrink-0 w-full md:w-auto flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold text-sm rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-transparent">Ubah</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 font-semibold text-sm rounded-lg hover:bg-red-600 hover:text-white transition-colors border border-red-100 hover:border-transparent">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-500">Belum ada user.</p>
            </div>
        @endforelse
    </div>
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</x-admin-layout>
