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
        Schema::table('result_tokens', function (Blueprint $table) {
            $table->string('session')->nullable()->after('student_id');
            $table->string('term')->nullable()->after('session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('result_tokens', function (Blueprint $table) {
            //
        });
    }
};
