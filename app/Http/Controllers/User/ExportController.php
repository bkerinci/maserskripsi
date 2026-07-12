<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPdf(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil data chapters
        $chapters = $project->chapters()->with('sections')->orderBy('chapter_number')->get();
        $references = $project->references()->orderBy('title')->get();

        $pdf = Pdf::loadView('user.export.pdf', compact('project', 'chapters', 'references'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Skripsi_' . str_replace(' ', '_', $project->title) . '.pdf');
    }

    public function exportDocx(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16]);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14]);

        $section->addTitle($project->title, 1);
        $section->addText("Penulis: " . auth()->user()->name);
        $section->addText("Universitas: " . ($project->university ?? '-'));
        $section->addTextBreak(2);

        $chapters = $project->chapters()->with('sections')->orderBy('chapter_number')->get();
        foreach ($chapters as $chapter) {
            $section->addTitle($chapter->title, 1);
            foreach ($chapter->sections as $sec) {
                $section->addTitle($sec->title, 2);
                // Karena kita menggunakan TinyMCE, teks mengandung tag HTML.
                // Untuk konversi sederhana kita gunakan strip_tags atau html parsing bawaan PhpWord
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $sec->content ?? '<p></p>', false, false);
                $section->addTextBreak(1);
            }
        }

        $fileName = 'Skripsi_' . str_replace(' ', '_', $project->title) . '.docx';
        $tempFile = storage_path('app/temp/' . $fileName);
        
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    public function exportChapterDocx(Project $project, \App\Models\Chapter $chapter)
    {
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $wordSection = $phpWord->addSection();

        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16]);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14]);

        $wordSection->addTitle($chapter->title, 1);
        $wordSection->addTextBreak(1);

        foreach ($chapter->sections()->orderBy('order')->get() as $sec) {
            $wordSection->addTitle($sec->title, 2);
            \PhpOffice\PhpWord\Shared\Html::addHtml($wordSection, $sec->content ?? '<p></p>', false, false);
            $wordSection->addTextBreak(1);
        }

        $fileName = str_replace(' ', '_', $chapter->title) . '.docx';
        $tempFile = storage_path('app/temp/' . $fileName);
        
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    public function exportSectionDocx(Project $project, \App\Models\ChapterSection $section)
    {
        $chapter = $section->chapter;
        if ($project->user_id !== auth()->id() || $chapter->project_id !== $project->id) {
            abort(403);
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $wordSection = $phpWord->addSection();

        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16]);

        $wordSection->addTitle($section->title, 1);
        $wordSection->addTextBreak(1);

        \PhpOffice\PhpWord\Shared\Html::addHtml($wordSection, $section->content ?? '<p></p>', false, false);

        $fileName = str_replace(' ', '_', $section->title) . '.docx';
        $tempFile = storage_path('app/temp/' . $fileName);
        
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
