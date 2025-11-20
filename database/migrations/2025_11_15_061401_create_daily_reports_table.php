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
        // Schema::create('daily_reports', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('report_date');
        //     $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        //     $table->integer('total_stock_in')->default(0);
        //     $table->integer('total_stock_out')->default(0);
        //     $table->decimal('total_value_in', 15, 2)->default(0);
        //     $table->decimal('total_value_out', 15, 2)->default(0);
        //     $table->integer('total_products')->default(0);
        //     $table->json('top_products')->nullable(); // produk terlaris
        //     $table->json('low_stock_products')->nullable(); // produk stock menipis
        //     $table->text('notes')->nullable();
        //     $table->timestamps();

        //     $table->unique(['report_date', 'warehouse_id']);
        //     $table->index('report_date');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
