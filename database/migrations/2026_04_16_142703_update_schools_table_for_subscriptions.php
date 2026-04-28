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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('plan')->default('basic'); // basic, pro, enterprise
            $table->decimal('subscription_amount', 12, 2)->default(0.00);
            $table->string('admin_name')->nullable(); // The name of the school's main admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
