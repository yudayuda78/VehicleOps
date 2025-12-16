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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
                  // Relasi ke region
            $table->foreignId('region_id')
                ->constrained()
                ->cascadeOnDelete();

            // Data office
            $table->string('name');
            $table->string('code')->unique()->nullable();

            // Tipe kantor
            $table->enum('type', ['head_office', 'branch_office']);

            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
