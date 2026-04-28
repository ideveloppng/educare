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
        Schema::table('results', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('remarks');
            // If remarks doesn't exist yet, add it:
            if (!Schema::hasColumn('results', 'remarks')) {
                $table->string('remarks')->nullable()->after('grade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            //
        });
    }
};
