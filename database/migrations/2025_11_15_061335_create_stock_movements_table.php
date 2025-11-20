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
        // Schema::create('stock_movements', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('product_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->string('type'); // in, out, adjustment, transfer
        //     $table->integer('quantity');
        //     $table->integer('stock_before');
        //     $table->integer('stock_after');
        //     $table->string('reference_type')->nullable(); // StockIn, StockOut, etc
        //     $table->unsignedBigInteger('reference_id')->nullable();
        //     $table->text('notes')->nullable();
        //     $table->timestamp('movement_date');
        //     $table->timestamps();

        //     $table->index(['product_id', 'movement_date']);
        //     $table->index(['reference_type', 'reference_id']);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
