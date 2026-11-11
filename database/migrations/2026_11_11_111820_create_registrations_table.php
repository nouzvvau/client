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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('guardian_name');
            $table->string('contact_phone');
            $table->text('address')->nullable();
            $table->foreignId('program_id')->constrained('programs');
            $table->text('music_experience')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
