<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'discount_price', 'promo', 'duration_days', 'features'];

    protected $casts = [
        'features' => 'array',
        'duration_days' => 'integer',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
