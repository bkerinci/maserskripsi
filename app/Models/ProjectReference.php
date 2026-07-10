<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectReference extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'authors',
        'journal',
        'year',
        'doi',
        'url',
        'source',
        'citation_format',
        'citation_text',
        'pdf_extracted_text',
        'ai_review',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Generate citation text in the specified format.
     */
    public function generateCitation(string $format = 'APA'): string
    {
        $authors = $this->authors ?: 'Penulis Tidak Diketahui';
        $title = $this->title;
        $journal = $this->journal ?: '';
        $year = $this->year ?: 'n.d.';
        $doi = $this->doi;

        switch (strtoupper($format)) {
            case 'APA':
                $citation = "{$authors} ({$year}). {$title}.";
                if ($journal) $citation .= " *{$journal}*.";
                if ($doi) $citation .= " https://doi.org/{$doi}";
                break;

            case 'IEEE':
                $citation = "{$authors}, \"{$title},\"";
                if ($journal) $citation .= " *{$journal}*,";
                $citation .= " {$year}.";
                if ($doi) $citation .= " doi: {$doi}.";
                break;

            case 'MLA':
                $citation = "{$authors}. \"{$title}.\"";
                if ($journal) $citation .= " *{$journal}*,";
                $citation .= " {$year}.";
                if ($doi) $citation .= " doi:{$doi}.";
                break;

            case 'CHICAGO':
                $citation = "{$authors}. \"{$title}.\"";
                if ($journal) $citation .= " *{$journal}*";
                $citation .= " ({$year}).";
                if ($doi) $citation .= " https://doi.org/{$doi}.";
                break;

            case 'VANCOUVER':
                $citation = "{$authors}. {$title}.";
                if ($journal) $citation .= " {$journal}.";
                $citation .= " {$year}.";
                if ($doi) $citation .= " doi: {$doi}.";
                break;

            default:
                $citation = "{$authors} ({$year}). {$title}.";
        }

        return $citation;
    }
}
