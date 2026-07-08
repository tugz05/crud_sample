<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_date',
        'pump_id',
        'fuel_product_id',
        'tank_id',
        'opening_balance_liters',
        'recorded_by',
    ];

    protected $casts = [
        'reading_date' => 'date',
        'opening_balance_liters' => 'decimal:2',
    ];
}
