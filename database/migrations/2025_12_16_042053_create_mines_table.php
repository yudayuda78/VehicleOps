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
        Schema::create('mines', function (Blueprint $table) {
            $table->id();

            $table->string('name');                 // Nama tambang
            $table->string('code')->unique();       // Kode tambang (TM01, TM02)
            $table->text('address')->nullable();    // Alamat / lokasi
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            // Relasi ke region
            $table->foreignId('region_id')
                ->constrained()
                ->cascadeOnDelete();

            // Status tambang
            $table->boolean('is_active')->default(true);

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mines');
    }
};
