<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_product_id',
        'tank_id',
        'pump_number',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fuelProduct()
    {
        return $this->belongsTo(FuelProduct::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
