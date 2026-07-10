<x-user-layout>
    <x-slot name="header">
        Riwayat Pencarian Judul
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Brainstorming</h2>
        <a href="{{ route('user.ai-judul.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium flex items-center gap-2 shadow-sm">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Generate Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($histories->isEmpty())
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada riwayat</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum pernah melakukan generate judul dengan AI.</p>
            </div>
        @else
            <ul role="list" class="divide-y divide-gray-100">
                @foreach($histories as $history)
                    <li class="relative flex justify-between gap-x-6 py-5 px-6 hover:bg-gray-50 transition-colors">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="h-12 w-12 flex-none rounded-full bg-blue-50 flex items-center justify-center border border-blue-100 text-blue-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    <a href="{{ route('user.ai-judul.show', $history) }}">
                                        <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                        Minat: {{ $history->input_minat }}
                                    </a>
                                </p>
                                <p class="mt-1 flex text-xs leading-5 text-gray-500">
                                    Bidang: {{ $history->input_bidang }} {{ $history->input_lokasi ? ' • Lokasi: ' . $history->input_lokasi : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-x-4">
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                                <p class="text-sm leading-6 text-gray-900">{{ is_array($history->results) ? count($history->results) : 0 }} Judul Dihasilkan</p>
                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    <time datetime="{{ $history->created_at->toIso8601String() }}">{{ $history->created_at->diffForHumans() }}</time>
                                </p>
                            </div>
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @if($histories->hasPages())
        <div class="mt-6">
            {{ $histories->links() }}
        </div>
    @endif
</x-user-layout>
