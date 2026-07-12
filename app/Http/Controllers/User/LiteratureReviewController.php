<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectReference;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class LiteratureReviewController extends Controller
{
    public function index(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $references = $project->references()->get();

        return view('user.literature.index', compact('project', 'references'));
    }

    /**
     * Upload PDF and extract text.
     */
    public function uploadPdf(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240',
        ]);

        try {
            $file = $request->file('pdf_file');
            $pdfPath = $file->getPathname();
            $text = '';

            // 1. Coba gunakan Smalot PDFParser (cepat, untuk PDF berbasis teks)
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($pdfPath);
                $text = $pdf->getText();
            } catch (\Exception $e) {
                // Biarkan kosong, akan mencoba Tesseract
            }

            // 2. Jika teks kosong atau sangat sedikit, kemungkinan ini PDF hasil scan. Gunakan Tesseract OCR.
            if (strlen(trim($text)) < 100) {
                // Pastikan direktori temp ada
                $tempDir = storage_path('app/temp_ocr');
                if (!is_dir($tempDir)) {
                    mkdir($tempDir, 0755, true);
                }

                $prefix = $tempDir . '/' . uniqid('ocr_');
                
                // Konversi PDF ke gambar menggunakan pdftoppm (bagian dari poppler-utils)
                $cmdPdfToPpm = "pdftoppm -png " . escapeshellarg($pdfPath) . " " . escapeshellarg($prefix);
                shell_exec($cmdPdfToPpm);

                // Jalankan Tesseract untuk setiap gambar yang dihasilkan
                $images = glob($prefix . "-*.png");
                $ocrText = '';
                foreach ($images as $img) {
                    $txtOut = $img . "_out";
                    // Tesseract menggunakan bahasa Indonesia dan Inggris (opsional, jika diinstall)
                    $cmdTesseract = "tesseract " . escapeshellarg($img) . " " . escapeshellarg($txtOut) . " -l ind+eng";
                    shell_exec($cmdTesseract);
                    
                    if (file_exists($txtOut . ".txt")) {
                        $ocrText .= file_get_contents($txtOut . ".txt") . "\n";
                        @unlink($txtOut . ".txt");
                    }
                    @unlink($img); // hapus gambar sementara
                }

                if (strlen(trim($ocrText)) > 10) {
                    $text = $ocrText;
                }
            }

            $text = substr($text, 0, 15000);

            return response()->json([
                'success' => true,
                'text' => $text,
                'message' => 'PDF berhasil diekstrak.',
                'filename' => $file->getClientOriginalName()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekstrak PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save a reference (from search results, manual entry, or PDF upload).
     */
    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:500',
            'authors' => 'nullable|string|max:500',
            'journal' => 'nullable|string|max:300',
            'year' => 'nullable|string|max:10',
            'doi' => 'nullable|string|max:200',
            'url' => 'nullable|string|max:500',
            'source' => 'nullable|string|in:manual,crossref,doaj,pdf',
            'citation_format' => 'nullable|string|in:APA,IEEE,MLA,CHICAGO,VANCOUVER',
            'pdf_extracted_text' => 'nullable|string',
        ]);

        $ref = $project->references()->create([
            'title' => $request->title,
            'authors' => $request->authors,
            'journal' => $request->journal,
            'year' => $request->year,
            'doi' => $request->doi,
            'url' => $request->url,
            'source' => $request->source ?? 'manual',
            'citation_format' => $request->citation_format ?? 'APA',
            'pdf_extracted_text' => $request->pdf_extracted_text,
        ]);

        // Generate citation
        $ref->citation_text = $ref->generateCitation($ref->citation_format);
        $ref->save();

        return response()->json([
            'success' => true,
            'reference' => $ref,
            'message' => 'Referensi berhasil disimpan.'
        ]);
    }

    /**
     * Delete a reference.
     */
    public function destroy(Project $project, ProjectReference $reference)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reference->project_id !== $project->id) {
            abort(403);
        }

        $reference->delete();

        return response()->json([
            'success' => true,
            'message' => 'Referensi berhasil dihapus.'
        ]);
    }

    /**
     * Generate citation in a specific format.
     */
    public function generateCitation(Request $request, Project $project, ProjectReference $reference)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'format' => 'required|string|in:APA,IEEE,MLA,CHICAGO,VANCOUVER',
        ]);

        $citation = $reference->generateCitation($request->format);
        $reference->update([
            'citation_format' => $request->format,
            'citation_text' => $citation,
        ]);

        return response()->json([
            'success' => true,
            'citation' => $citation,
            'format' => $request->format,
        ]);
    }

    /**
     * Generate comparative literature review from selected references using AI.
     */
    public function generateReview(Request $request, Project $project, \App\Services\GeminiService $gemini)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $references = $project->references()->get();

        if ($references->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada referensi jurnal yang ditambahkan.'
            ], 400);
        }

        $context = "";
        foreach ($references as $index => $ref) {
            $context .= "Jurnal " . ($index + 1) . ":\n";
            $context .= "Judul: " . $ref->title . "\n";
            $context .= "Penulis: " . $ref->authors . "\n";
            if (!empty($ref->pdf_extracted_text)) {
                // Ambil 3000 karakter pertama dan terakhir jika dirasa perlu, 
                // tapi 3000 karakter pertama biasanya sudah memuat abstrak dan pendahuluan.
                $context .= "Abstrak/Isi: " . substr($ref->pdf_extracted_text, 0, 3000) . "\n";
            }
            $context .= "------\n\n";
        }

        $prompt = "Berikut adalah ringkasan dari beberapa jurnal referensi (Literatur) yang akan digunakan dalam penelitian:\n\n" . 
                  $context . 
                  "\nBuatkan sebuah 'Literature Review' akademis yang mensintesis jurnal-jurnal tersebut. " .
                  "Fokuskan pada: 1. Persamaan antar penelitian. 2. Perbedaan/Metode yang digunakan. 3. Gap Penelitian (Research Gap) yang bisa diisi oleh penelitian saya. " .
                  "Buatlah hasil akhirnya berbentuk tabel komparasi yang rapi (format Markdown table), lalu diikuti dengan 2-3 paragraf narasi kesimpulan mengenai gap penelitian.";

        $result = $gemini->generate($prompt, 0.7, 4000);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghasilkan Literature Review dari AI.'
            ], 500);
        }

        \App\Models\AiUsage::create([
            'user_id' => auth()->id(),
            'action_type' => 'Literature Review (' . $references->count() . ' referensi)'
        ]);

        return response()->json([
            'success' => true,
            'review_content' => $result
        ]);
    }
}
