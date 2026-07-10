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

    public function uploadData(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            
            // Basic CSV Parsing logic using PHP native functions
            $data = [];
            $header = null;
            if (($handle = fopen($path, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        // Tolerate rows with different column counts
                        if (count($header) === count($row)) {
                            $data[] = array_combine($header, $row);
                        }
                    }
                }
                fclose($handle);
            }

            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'Berkas CSV kosong atau format tidak sesuai.'], 400);
            }

            // Simple Descriptive Statistics Mockup
            $rowCount = count($data);
            $columns = count($header);
            
            $summary = "Berhasil memproses dataset dengan **$rowCount baris** dan **$columns kolom**.\n\n";
            $summary .= "### Analisis AI (Simulasi)\n";
            $summary .= "- **Distribusi Data:** Secara umum, data terlihat berdistribusi normal.\n";
            $summary .= "- **Insight Utama:** Berdasarkan angka rata-rata pada kolom metrik, terdapat tren yang stabil di seluruh entitas.\n";
            $summary .= "- **Rekomendasi Uji Lanjut:** Disarankan untuk menggunakan Analisis Regresi Linear Berganda untuk mengukur korelasi yang lebih dalam.";

            return response()->json([
                'success' => true,
                'summary' => $summary,
                'rows' => $rowCount,
                'cols' => $columns,
                'columns' => $header
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses berkas CSV: ' . $e->getMessage()
            ], 500);
        }
    }
}
