<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->latest()->paginate(10);
        return view('user.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('user.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'university' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'study_program' => 'nullable|string|max:255',
            'degree_level' => 'nullable|string|max:50',
            'research_type' => 'nullable|string|max:100',
            'topic' => 'nullable|string|max:255',
            'advisor_name' => 'nullable|string|max:255',
        ]);

        $project = auth()->user()->projects()->create($validated);

        // Auto-seed default chapters and sections
        $defaultChapters = [
            1 => [
                'title' => 'Bab 1 - Pendahuluan',
                'sections' => ['1.1 Latar Belakang', '1.2 Rumusan Masalah', '1.3 Tujuan Penelitian', '1.4 Manfaat Penelitian', '1.5 Batasan Penelitian']
            ],
            2 => [
                'title' => 'Bab 2 - Tinjauan Pustaka',
                'sections' => ['2.1 Kajian Teori', '2.2 Penelitian Terdahulu', '2.3 Kerangka Berpikir']
            ],
            3 => [
                'title' => 'Bab 3 - Metodologi Penelitian',
                'sections' => ['3.1 Jenis Penelitian', '3.2 Lokasi & Waktu', '3.3 Populasi & Sampel', '3.4 Teknik Pengumpulan Data', '3.5 Analisis Data']
            ],
            4 => [
                'title' => 'Bab 4 - Hasil dan Pembahasan',
                'sections' => ['4.1 Deskripsi Data', '4.2 Hasil Analisis Data', '4.3 Pembahasan']
            ],
            5 => [
                'title' => 'Bab 5 - Penutup',
                'sections' => ['5.1 Kesimpulan', '5.2 Saran']
            ],
        ];

        foreach ($defaultChapters as $number => $data) {
            $chapter = $project->chapters()->create([
                'title' => $data['title'],
                'chapter_number' => $number,
            ]);

            foreach ($data['sections'] as $index => $sectionTitle) {
                $chapter->sections()->create([
                    'title' => $sectionTitle,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('user.projects.show', $project)
            ->with('success', 'Project penelitian berhasil dibuat beserta struktur Bab!');
    }

    public function show(Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'university' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'study_program' => 'nullable|string|max:255',
            'degree_level' => 'nullable|string|max:50',
            'research_type' => 'nullable|string|max:100',
            'topic' => 'nullable|string|max:255',
            'advisor_name' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,in_progress,completed',
        ]);

        $project->update($validated);

        return redirect()->route('user.projects.show', $project)->with('success', 'Project diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->delete();
        return redirect()->route('user.projects.index')->with('success', 'Project dihapus.');
    }
}
