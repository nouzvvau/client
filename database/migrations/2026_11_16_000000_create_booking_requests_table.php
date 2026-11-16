<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 120);
            $table->string('whatsapp', 20);
            $table->string('organization', 160)->nullable();
            $table->string('event_type', 80);
            $table->string('event_name', 160);
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->string('event_location', 200);
            $table->unsignedInteger('audience_estimate')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
