<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'chapter_number',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sections()
    {
        return $this->hasMany(ChapterSection::class)->orderBy('order');
    }
}
