
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('event_bookings');
        Schema::dropIfExists('student_registrations');
    }

    public function down(): void
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('phone', 30);
            $table->text('address')->nullable();
            $table->string('program')->nullable();
            $table->text('experience')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('name');
        });

        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('institution_name')->nullable();
            $table->string('service_type');
            $table->string('event_name');
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->text('event_location');
            $table->unsignedInteger('estimated_audience')->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->index(['status', 'event_date']);
            $table->index('name');
        });
    }
};
