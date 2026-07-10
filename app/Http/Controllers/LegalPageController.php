<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    public function show($slug)
    {
        $page = LegalPage::where('slug', $slug)->where('status', 'Published')->first();
        
        // Auto-generate skeleton page if it doesn't exist yet
        if (!$page) {
            $page = LegalPage::create([
                'slug' => $slug,
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'language' => 'ID',
                'version' => 'v1.0.0',
                'status' => 'Published',
                'content' => '<h2>' . ucwords(str_replace('-', ' ', $slug)) . '</h2><p>Konten halaman ini sedang dalam tahap penyusunan. Admin dapat mengubah teks ini melalui menu <strong>Legal Pages</strong> di Dashboard Admin.</p>'
            ]);
        }
        
        return view('pages.show', compact('page'));
    }
}
