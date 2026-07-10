<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'type', 'persona_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
