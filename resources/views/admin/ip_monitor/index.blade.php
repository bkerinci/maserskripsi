<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Monitor IP Mencurigakan (Otomatis Terblokir)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4 text-sm text-gray-600">
                        Halaman ini memonitor Alamat IP yang digunakan oleh 2 akun atau lebih. Sistem otentikasi secara otomatis 
                        telah memblokir IP ini agar tidak bisa mendaftarkan akun baru lagi untuk mencegah eksploitasi limit gratis.
                    </p>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Alamat IP</th>
                                    <th scope="col" class="px-6 py-3 text-center">Jumlah Akun</th>
                                    <th scope="col" class="px-6 py-3">Daftar Akun Terkait</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suspiciousIps as $ipData)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-semibold text-red-600">
                                            {{ $ipData->last_login_ip }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-900">
                                            {{ $ipData->total_accounts }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside">
                                                @foreach ($usersByIp[$ipData->last_login_ip] as $u)
                                                    <li>
                                                        <a href="{{ route('admin.users.edit', $u) }}" class="text-blue-600 hover:underline">
                                                            {{ $u->name }}
                                                        </a> 
                                                        <span class="text-xs text-gray-500">({{ $u->email }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-green-400 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Aman! Belum ada IP mencurigakan (Multi-Akun) yang terdeteksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $suspiciousIps->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
