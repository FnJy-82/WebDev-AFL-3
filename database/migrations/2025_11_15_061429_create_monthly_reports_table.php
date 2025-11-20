<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('monthly_reports', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('year');
        //     $table->integer('month');
        //     $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        //     $table->integer('total_stock_in')->default(0);
        //     $table->integer('total_stock_out')->default(0);
        //     $table->decimal('total_value_in', 15, 2)->default(0);
        //     $table->decimal('total_value_out', 15, 2)->default(0);
        //     $table->decimal('total_revenue', 15, 2)->default(0);
        //     $table->integer('total_transactions')->default(0);
        //     $table->json('category_breakdown')->nullable();
        //     $table->json('supplier_breakdown')->nullable();
        //     $table->json('best_selling_products')->nullable();
        //     $table->text('summary')->nullable();
        //     $table->timestamps();

        //     $table->unique(['year', 'month', 'warehouse_id']);
        //     $table->index(['year', 'month']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
