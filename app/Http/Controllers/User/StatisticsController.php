<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.statistics.index', compact('project'));
    }

    public function generateMethodology(Request $request, Project $project, GeminiService $gemini)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'research_type' => 'required|string',
            'topic' => 'required|string',
        ]);

        $response = $gemini->generateMethodology($request->topic, $request->research_type);

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghasilkan metodologi dari AI.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'result' => $response
        ]);
    }

    public function uploadData(Request $request, Project $project, GeminiService $gemini)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->storeAs('csv_uploads', time() . '_' . $file->getClientOriginalName());
            
            // Check storage path logic based on Laravel 11/12 changes
            $fullPath = storage_path('app/private/' . $path);
            if (!file_exists($fullPath)) {
                 $fullPath = storage_path('app/' . $path);
            }

            $pythonScript = base_path('python_engine/analyze_stats.py');
            $process = \Illuminate\Support\Facades\Process::run(['python', $pythonScript, $fullPath]);

            if (!$process->successful()) {
                return response()->json(['success' => false, 'message' => 'Gagal memproses dengan Python engine.'], 500);
            }

            $output = json_decode($process->output(), true);
            if (!$output || empty($output['success'])) {
                return response()->json(['success' => false, 'message' => $output['message'] ?? 'Unknown error dari Python'], 500);
            }

            // Generate narrative using Gemini
            $statsJson = json_encode([
                'rows' => $output['rows'],
                'cols' => $output['cols'],
                'columns' => $output['columns'],
                'missing_values' => $output['missing_values'],
                'cronbach_alpha' => $output['cronbach_alpha']
            ]);
            
            $prompt = "Berikut adalah ringkasan hasil analisis statistik deskriptif dan uji reliabilitas (Cronbach's Alpha) dari sebuah dataset penelitian:\n" . $statsJson . "\n\nBuatlah narasi untuk Bab 4 (Hasil dan Pembahasan) berdasarkan angka-angka ini. Tulis secara akademis, jelaskan validitas/reliabilitasnya (jika alpha > 0.6 maka instrumen dianggap reliabel), dan berikan interpretasi. Jangan gunakan markdown heading (#), langsung ke paragraf teks.";

            $narrative = $gemini->generate($prompt, 0.7, 2048);
            
            // Fallback to basic summary if AI fails
            if (!$narrative) {
                $narrative = "Berhasil memproses dataset dengan **{$output['rows']} baris** dan **{$output['cols']} kolom**. Reliabilitas (Alpha): " . round($output['cronbach_alpha'], 3);
            }

            return response()->json([
                'success' => true,
                'summary' => $narrative,
                'rows' => $output['rows'],
                'cols' => $output['cols'],
                'columns' => $output['columns'],
                'alpha' => $output['cronbach_alpha']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses berkas CSV: ' . $e->getMessage()
            ], 500);
        }
    }
}
