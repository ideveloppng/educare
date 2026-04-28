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
        Schema::create('result_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('set null'); // Tied to first student
            $table->string('serial_number')->unique();
            $table->string('pin')->unique();
            $table->integer('usage_limit')->default(5);
            $table->integer('usage_count')->default(0);
            $table->string('batch_number')->nullable(); // To group generations
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_tokens');
    }
};
