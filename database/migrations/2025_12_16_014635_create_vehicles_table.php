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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
             $table->foreignId('region_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
             // Identitas kendaraan
            $table->string('name');
            $table->string('plate_number')->unique();
            $table->string('type'); // angkutan orang / barang
            $table->year('year')->nullable();

            // Kepemilikan
            $table->enum('ownership', ['office', 'outsource']);

            // BBM
            $table->string('fuel_type')->nullable(); // solar / bensin
            $table->decimal('fuel_consumption', 8, 2)->nullable(); 
            // km / liter atau liter / jam

            // Service
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('service_interval_km')->nullable();

            // Status kendaraan
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
