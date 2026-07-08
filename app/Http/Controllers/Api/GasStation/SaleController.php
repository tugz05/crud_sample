<?php

namespace App\Http\Controllers\Api\GasStation;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Pump;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['pump', 'fuelProduct', 'tank'])->latest('sold_at');

        if ($request->filled('date')) {
            $query->whereDate('sold_at', $request->date);
        }

        if ($request->filled('fuel_product_id')) {
            $query->where('fuel_product_id', $request->fuel_product_id);
        }

        return response()->json($query->paginate($request->integer('per_page', 20)));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pump_id' => ['required', 'exists:pumps,id'],
            'liters_sold' => ['required', 'numeric', 'min:0.01'],
            'price_per_liter' => ['nullable', 'numeric', 'min:0'],
            'payment_type' => ['required', 'string', 'max:50'],
            'sold_at' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $sale = DB::transaction(function () use ($data, $request) {
            $pump = Pump::with(['fuelProduct', 'tank'])->lockForUpdate()->findOrFail($data['pump_id']);
            $price = $data['price_per_liter'] ?? $pump->fuelProduct->price_per_liter;
            $total = round($data['liters_sold'] * $price, 2);

            if ($pump->tank->current_balance_liters < $data['liters_sold']) {
                abort(422, 'Insufficient tank balance for this sale.');
            }

            $sale = Sale::create([
                'sold_at' => $data['sold_at'] ?? now(),
                'pump_id' => $pump->id,
                'fuel_product_id' => $pump->fuel_product_id,
                'tank_id' => $pump->tank_id,
                'liters_sold' => $data['liters_sold'],
                'price_per_liter' => $price,
                'total_amount' => $total,
                'payment_type' => $data['payment_type'],
                'cashier_id' => optional($request->user())->id,
                'remarks' => $data['remarks'] ?? null,
            ]);

            $pump->tank->decrement('current_balance_liters', $data['liters_sold']);
            $pump->tank->refresh();

            InventoryMovement::create([
                'movement_date' => $sale->sold_at,
                'fuel_product_id' => $sale->fuel_product_id,
                'tank_id' => $sale->tank_id,
                'movement_type' => 'sale',
                'quantity_liters' => -1 * $sale->liters_sold,
                'balance_after_liters' => $pump->tank->current_balance_liters,
                'reference_type' => Sale::class,
                'reference_id' => $sale->id,
                'user_id' => optional($request->user())->id,
                'remarks' => 'POS sale transaction',
            ]);

            return $sale->load(['pump', 'fuelProduct', 'tank']);
        });

        return response()->json($sale, 201);
    }
}
