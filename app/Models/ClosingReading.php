<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosingReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_date',
        'pump_id',
        'fuel_product_id',
        'tank_id',
        'closing_balance_liters',
        'computed_sold_liters',
        'pos_sold_liters',
        'discrepancy_liters',
        'recorded_by',
    ];

    protected $casts = [
        'reading_date' => 'date',
        'closing_balance_liters' => 'decimal:2',
        'computed_sold_liters' => 'decimal:2',
        'pos_sold_liters' => 'decimal:2',
        'discrepancy_liters' => 'decimal:2',
    ];
}
