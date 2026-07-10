<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'university',
        'faculty',
        'study_program',
        'degree_level',
        'research_type',
        'topic',
        'advisor_name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter_number');
    }

    public function references()
    {
        return $this->hasMany(ProjectReference::class)->orderBy('created_at', 'desc');
    }
}
