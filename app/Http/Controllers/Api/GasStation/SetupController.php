<?php

namespace App\Http\Controllers\Api\GasStation;

use App\Http\Controllers\Controller;
use App\Models\FuelProduct;
use App\Models\Pump;
use App\Models\Supplier;
use App\Models\Tank;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function products()
    {
        return response()->json(FuelProduct::orderBy('name')->get());
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:fuel_products,code'],
            'price_per_liter' => ['required', 'numeric', 'min:0'],
            'supplier_lead_time_days' => ['nullable', 'integer', 'min:0'],
            'safety_stock_liters' => ['nullable', 'numeric', 'min:0'],
        ]);

        return response()->json(FuelProduct::create($data), 201);
    }

    public function tanks()
    {
        return response()->json(Tank::with('fuelProduct')->orderBy('name')->get());
    }

    public function storeTank(Request $request)
    {
        $data = $request->validate([
            'fuel_product_id' => ['required', 'exists:fuel_products,id'],
            'name' => ['required', 'string', 'max:255'],
            'capacity_liters' => ['required', 'numeric', 'min:0'],
            'current_balance_liters' => ['nullable', 'numeric', 'min:0'],
        ]);

        return response()->json(Tank::create($data), 201);
    }

    public function pumps()
    {
        return response()->json(Pump::with(['fuelProduct', 'tank'])->orderBy('pump_number')->get());
    }

    public function storePump(Request $request)
    {
        $data = $request->validate([
            'fuel_product_id' => ['required', 'exists:fuel_products,id'],
            'tank_id' => ['required', 'exists:tanks,id'],
            'pump_number' => ['required', 'integer', 'min:1', 'unique:pumps,pump_number'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        return response()->json(Pump::create($data), 201);
    }

    public function suppliers()
    {
        return response()->json(Supplier::orderBy('name')->get());
    }

    public function storeSupplier(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        return response()->json(Supplier::create($data), 201);
    }
}
