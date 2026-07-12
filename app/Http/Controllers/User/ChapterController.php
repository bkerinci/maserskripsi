<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\ChapterSection;
use App\Models\Project;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show(Project $project, Chapter $chapter)
    {
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $chapter->load('sections');

        return view('user.chapters.show', compact('project', 'chapter'));
    }

    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
        ]);

        $project->chapters()->create($validated);

        return back()->with('success', 'Bab baru berhasil ditambahkan.');
    }

    public function storeSection(Request $request, Project $project, Chapter $chapter)
    {
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Get max order
        $maxOrder = $chapter->sections()->max('order') ?? 0;

        $chapter->sections()->create([
            'title' => $validated['title'],
            'order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Subbab baru berhasil ditambahkan.');
    }

    public function reorder(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:chapters,id'
        ]);

        foreach ($validated['order'] as $index => $chapterId) {
            Chapter::where('id', $chapterId)
                ->where('project_id', $project->id)
                ->update(['chapter_number' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function rename(Request $request, Project $project, Chapter $chapter)
    {
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $chapter->update(['title' => $validated['title']]);

        return back()->with('success', 'Judul Bab berhasil diubah.');
    }

    public function reorderSections(Request $request, Project $project, Chapter $chapter)
    {
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:chapter_sections,id'
        ]);

        foreach ($validated['order'] as $index => $sectionId) {
            ChapterSection::where('id', $sectionId)
                ->where('chapter_id', $chapter->id)
                ->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function renameSection(Request $request, Project $project, ChapterSection $section)
    {
        $chapter = $section->chapter;

        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $section->update(['title' => $validated['title']]);

        return back()->with('success', 'Judul Subbab berhasil diubah.');
    }

    public function generateAi(Request $request, Project $project, ChapterSection $section, GeminiService $gemini)
    {
        $chapter = $section->chapter;

        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        if (!auth()->user()->canUseAi()) {
            return redirect()->route('user.subscription.index')
                ->with('error', 'Batas AI Prompt Anda bulan ini sudah habis atau Anda belum memiliki paket aktif. Silakan upgrade paket Anda untuk terus menggunakan AI.');
        }

        // Fetch references to pass to AI
        $references = $project->references()->get()->toArray();

        $defaultTitles = [
            '1.1 Latar Belakang', '1.2 Rumusan Masalah', '1.3 Tujuan Penelitian', '1.4 Manfaat Penelitian', '1.5 Batasan Penelitian',
            '2.1 Kajian Teori', '2.2 Penelitian Terdahulu', '2.3 Kerangka Berpikir',
            '3.1 Jenis Penelitian', '3.2 Lokasi & Waktu', '3.3 Populasi & Sampel', '3.4 Teknik Pengumpulan Data', '3.5 Analisis Data',
            '4.1 Deskripsi Data', '4.2 Hasil Analisis Data', '4.3 Pembahasan',
            '5.1 Kesimpulan', '5.2 Saran'
        ];

        if (!in_array($section->title, $defaultTitles)) {
            $content = $gemini->generateCustomChapterContent($project->title, $chapter->title, $section->title, $project->research_type, $references);
        } else {
            $content = $gemini->generateChapterContent($project->title, $chapter->title, $section->title, $project->research_type, $references);
        }

        $section->update([
            'content' => $content
        ]);

        // Catat penggunaan AI
        auth()->user()->recordAiUsage('chapter_generation');

        return redirect()->route('user.chapters.show', [$project, $chapter])
            ->with('success', "Isi subbab {$section->title} berhasil digenerate oleh AI.");
    }

    public function update(Request $request, Project $project, ChapterSection $section)
    {
        $chapter = $section->chapter;

        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        $section->update([
            'content' => $validated['content']
        ]);

        return redirect()->route('user.chapters.show', [$project, $chapter])
            ->with('success', "Perubahan pada {$section->title} berhasil disimpan.");
    }
}
