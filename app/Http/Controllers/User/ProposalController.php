<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ChapterSection;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil Bab 1, 2, dan 3 beserta sections-nya
        $chapters = $project->chapters()
            ->whereIn('chapter_number', [1, 2, 3])
            ->with('sections')
            ->get();

        // Hitung total sections dan yang sudah terisi
        $sections = collect();
        foreach ($chapters as $chapter) {
            foreach ($chapter->sections as $section) {
                $sections->push($section);
            }
        }

        $totalSections = $sections->count();
        $filledSections = $sections->whereNotNull('content')->count();
        $progress = $totalSections > 0 ? round(($filledSections / $totalSections) * 100) : 0;

        return view('user.proposal.index', compact('project', 'chapters', 'sections', 'progress', 'totalSections', 'filledSections'));
    }

    public function generateSection(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!auth()->user()->canUseAi()) {
            return response()->json([
                'success' => false,
                'message' => 'Batas AI Prompt Anda bulan ini sudah habis atau Anda belum memiliki paket aktif. Silakan upgrade paket Anda untuk terus menggunakan AI.'
            ], 403);
        }

        $validated = $request->validate([
            'section_id' => 'required|exists:chapter_sections,id'
        ]);

        $section = ChapterSection::with('chapter')->find($validated['section_id']);
        
        // Pastikan section milik project ini
        if ($section->chapter->project_id !== $project->id) {
            return response()->json(['success' => false, 'message' => 'Invalid section'], 403);
        }

        // Panggil AI
        $gemini = app(GeminiService::class);
        $references = $project->references()->get()->toArray();
        $content = $gemini->generateChapterContent($project->title, $section->chapter->title, $section->title, $project->research_type, $references);

        if (empty($content) || str_starts_with($content, 'Maaf, terjadi kesalahan')) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghasilkan konten dari AI. Coba lagi.'
            ], 500);
        }

        $section->update(['content' => $content]);

        // Catat penggunaan AI
        auth()->user()->recordAiUsage('proposal_generation');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil generate',
        ]);
    }
}
