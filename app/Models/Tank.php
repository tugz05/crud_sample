<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_product_id',
        'name',
        'capacity_liters',
        'current_balance_liters',
        'is_active',
    ];

    protected $casts = [
        'capacity_liters' => 'decimal:2',
        'current_balance_liters' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function fuelProduct()
    {
        return $this->belongsTo(FuelProduct::class);
    }

    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }
}
