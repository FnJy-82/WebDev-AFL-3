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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->text('description');
            $table->text('vision');
            $table->text('mission_1');
            $table->text('mission_2');
            $table->text('mission_3');
            $table->text('mission_4');
            $table->text('address');
            $table->string('city');
            $table->timestamps();
        });

        // Schema::create('warehouses', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('code')->unique();
        //     $table->text('address');
        //     $table->string('city');
        //     $table->string('province')->nullable();
        //     $table->string('postal_code')->nullable();
        //     $table->string('manager_name')->nullable();
        //     $table->string('phone')->nullable();
        //     $table->integer('capacity')->nullable();
        //     $table->boolean('is_active')->default(true);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
