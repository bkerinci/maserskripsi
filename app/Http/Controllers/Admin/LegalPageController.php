<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalPageController extends Controller
{
    public function index()
    {
        $pages = LegalPage::orderBy('created_at', 'desc')->get();
        return view('admin.legal-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.legal-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:legal_pages,slug',
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:10',
            'version' => 'required|string|max:20',
            'status' => 'required|in:Published,Draft',
            'content' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        LegalPage::create($validated);

        return redirect()->route('admin.legal-pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(LegalPage $legalPage)
    {
        return view('admin.legal-pages.edit', compact('legalPage'));
    }

    public function update(Request $request, LegalPage $legalPage)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:legal_pages,slug,' . $legalPage->id,
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:10',
            'version' => 'required|string|max:20',
            'status' => 'required|in:Published,Draft',
            'content' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        $legalPage->update($validated);

        return redirect()->route('admin.legal-pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(LegalPage $legalPage)
    {
        $legalPage->delete();
        return redirect()->route('admin.legal-pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
