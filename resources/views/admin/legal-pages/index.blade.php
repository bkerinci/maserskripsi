<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Legal Pages</h2>
                <p class="text-sm text-gray-500 mt-1">Manage terms, privacy, and refund policies.</p>
            </div>
            <a href="{{ route('admin.legal-pages.create') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Add New Page
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-0 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-500 text-sm border-b border-gray-200 bg-gray-50/50">
                                    <th class="px-6 py-4 font-medium">Slug</th>
                                    <th class="px-6 py-4 font-medium">Title</th>
                                    <th class="px-6 py-4 font-medium">Language</th>
                                    <th class="px-6 py-4 font-medium">Version</th>
                                    <th class="px-6 py-4 font-medium">Status</th>
                                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse ($pages as $page)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $page->slug }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $page->title }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $page->language }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $page->version }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->status === 'Published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $page->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium space-x-3">
                                            <a href="{{ route('legal.show', $page->slug) }}" target="_blank" class="text-slate-600 hover:text-slate-900">Preview</a>
                                            <a href="{{ route('admin.legal-pages.edit', $page) }}" class="text-slate-600 hover:text-slate-900">Edit</a>
                                            <form action="{{ route('admin.legal-pages.destroy', $page) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-600 hover:text-red-600">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada legal pages yang ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
