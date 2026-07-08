<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sold_at',
        'pump_id',
        'fuel_product_id',
        'tank_id',
        'liters_sold',
        'price_per_liter',
        'total_amount',
        'payment_type',
        'cashier_id',
        'remarks',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'liters_sold' => 'decimal:2',
        'price_per_liter' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    public function fuelProduct()
    {
        return $this->belongsTo(FuelProduct::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
