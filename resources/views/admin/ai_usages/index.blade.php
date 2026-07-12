<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Penggunaan AI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                    <th scope="col" class="px-6 py-3">User (Email)</th>
                                    <th scope="col" class="px-6 py-3">Jenis Aktivitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($usages as $usage)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $usage->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $usage->user->name ?? 'User Terhapus' }} <br>
                                            <span class="text-xs text-gray-500">{{ $usage->user->email ?? '' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ $usage->action_type }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">Belum ada riwayat aktivitas AI.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $usages->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
