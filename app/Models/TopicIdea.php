<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicIdea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'input_minat',
        'input_lokasi',
        'input_bidang',
        'results',
    ];

    protected $casts = [
        'results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
