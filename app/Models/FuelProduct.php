<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price_per_liter',
        'supplier_lead_time_days',
        'safety_stock_liters',
        'is_active',
    ];

    protected $casts = [
        'price_per_liter' => 'decimal:2',
        'safety_stock_liters' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function tanks()
    {
        return $this->hasMany(Tank::class);
    }

    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }
}
