<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivered_at',
        'fuel_product_id',
        'tank_id',
        'supplier_id',
        'quantity_liters',
        'tank_reading_before_liters',
        'tank_reading_after_liters',
        'delivery_receipt_no',
        'recorded_by',
        'remarks',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'quantity_liters' => 'decimal:2',
        'tank_reading_before_liters' => 'decimal:2',
        'tank_reading_after_liters' => 'decimal:2',
    ];

    public function fuelProduct()
    {
        return $this->belongsTo(FuelProduct::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
