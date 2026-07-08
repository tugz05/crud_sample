<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->decimal('price_per_liter', 10, 2)->default(0);
            $table->unsignedInteger('supplier_lead_time_days')->default(3);
            $table->decimal('safety_stock_liters', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->decimal('capacity_liters', 12, 2)->default(0);
            $table->decimal('current_balance_liters', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('pump_number')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('opening_readings', function (Blueprint $table) {
            $table->id();
            $table->date('reading_date');
            $table->foreignId('pump_id')->constrained('pumps')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('opening_balance_liters', 12, 2);
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['reading_date', 'pump_id']);
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('delivered_at');
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->decimal('quantity_liters', 12, 2);
            $table->decimal('tank_reading_before_liters', 12, 2);
            $table->decimal('tank_reading_after_liters', 12, 2)->nullable();
            $table->string('delivery_receipt_no')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamp('sold_at');
            $table->foreignId('pump_id')->constrained('pumps')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('liters_sold', 12, 2);
            $table->decimal('price_per_liter', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_type')->default('cash');
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('closing_readings', function (Blueprint $table) {
            $table->id();
            $table->date('reading_date');
            $table->foreignId('pump_id')->constrained('pumps')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('closing_balance_liters', 12, 2);
            $table->decimal('computed_sold_liters', 12, 2)->default(0);
            $table->decimal('pos_sold_liters', 12, 2)->default(0);
            $table->decimal('discrepancy_liters', 12, 2)->default(0);
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['reading_date', 'pump_id']);
        });

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->dateTime('movement_date');
            $table->foreignId('fuel_product_id')->constrained('fuel_products')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tank_id')->constrained('tanks')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('movement_type');
            $table->decimal('quantity_liters', 12, 2);
            $table->decimal('balance_after_liters', 12, 2);
            $table->nullableMorphs('reference');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('closing_readings');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('opening_readings');
        Schema::dropIfExists('pumps');
        Schema::dropIfExists('tanks');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('fuel_products');
    }
};
