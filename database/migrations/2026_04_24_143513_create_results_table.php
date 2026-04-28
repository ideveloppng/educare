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
            Schema::create('results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained()->onDelete('cascade');
                $table->foreignId('student_id')->constrained()->onDelete('cascade');
                $table->foreignId('subject_id')->constrained()->onDelete('cascade');
                $table->foreignId('school_class_id')->constrained()->onDelete('cascade');
                $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
                
                $table->string('term');    // e.g., First Term
                $table->string('session'); // e.g., 2024/2025
                
                $table->decimal('ca1', 5, 2)->default(0);
                $table->decimal('ca2', 5, 2)->default(0);
                $table->decimal('exam', 5, 2)->default(0);
                $table->decimal('total', 5, 2)->default(0);
                $table->string('grade')->nullable();
                $table->string('remarks')->nullable();
                
                $table->timestamps();

                // Ensure one student gets one result per subject per term
                $table->unique(['student_id', 'subject_id', 'term', 'session'], 'unique_result_entry');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
