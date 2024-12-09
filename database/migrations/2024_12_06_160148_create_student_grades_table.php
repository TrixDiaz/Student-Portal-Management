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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_section_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->decimal('grade', 8, 2)->nullable();
            $table->decimal('prelim_grade', 8, 2)->nullable();
            $table->decimal('midterm_grade', 8, 2)->nullable();
            $table->decimal('final_grade', 8, 2)->nullable();
            $table->json('quiz_scores')->nullable();
            $table->enum('status', ['Passed', 'Failed'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
