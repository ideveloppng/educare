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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The employee
            $table->string('month'); // e.g., "April"
            $table->string('year');  // e.g., "2026"
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->string('reference')->unique();
            $table->timestamps();

            // Prevent double payment for the same month/year
            $table->unique(['user_id', 'month', 'year'], 'unique_monthly_pay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
