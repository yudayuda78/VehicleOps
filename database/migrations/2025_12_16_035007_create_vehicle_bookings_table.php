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
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->id();
                 // Relasi kendaraan dan region
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();

            // User yang memesan dan yang membuat record
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // pemesan
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // admin yang input

            // Approver berjenjang
            $table->foreignId('approver_level_1_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_level_1_at')->nullable();

            $table->foreignId('approver_level_2_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_level_2_at')->nullable();

            // Status pemesanan
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_bookings');
    }
};
