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
        Schema::table('payrolls', function (Blueprint $table) {
            // Additional Deductions
            $table->decimal('union_dues', 15, 2)->default(0)->after('pension_deduction');
            $table->decimal('cooperative_deduction', 15, 2)->default(0)->after('union_dues');
            
            // Allowances
            $table->decimal('housing_allowance', 15, 2)->default(0)->after('cooperative_deduction');
            $table->decimal('feeding_allowance', 15, 2)->default(0)->after('housing_allowance');
            $table->decimal('transport_allowance', 15, 2)->default(0)->after('feeding_allowance');
            $table->decimal('medical_benefit', 15, 2)->default(0)->after('transport_allowance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            //
        });
    }
};
