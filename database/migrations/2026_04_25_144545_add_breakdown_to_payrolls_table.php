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
            $table->decimal('gross_amount', 15, 2)->after('user_id');
            $table->decimal('tax_deduction', 15, 2)->default(0)->after('gross_amount');
            $table->decimal('pension_deduction', 15, 2)->default(0)->after('tax_deduction');
            // 'amount' column already exists; we will use it as Net Pay.
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
