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
        Schema::create('program_student', function (Blueprint $table) {
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['program_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_student');
    }
};
