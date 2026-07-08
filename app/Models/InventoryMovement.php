<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_date',
        'fuel_product_id',
        'tank_id',
        'movement_type',
        'quantity_liters',
        'balance_after_liters',
        'reference_type',
        'reference_id',
        'user_id',
        'remarks',
    ];

    protected $casts = [
        'movement_date' => 'datetime',
        'quantity_liters' => 'decimal:2',
        'balance_after_liters' => 'decimal:2',
    ];

    public function fuelProduct()
    {
        return $this->belongsTo(FuelProduct::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
