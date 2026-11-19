<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'activity_photos',
            'activities',
            'bookings',
            'booking_requests',
            'feedbacks',
            'registrations',
            'program_student',
            'schedules',
            'locations',
            'staff',
            'programs',
            'pendaftaran_murids',
            'personal_access_tokens',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Legacy tables are intentionally not recreated.
    }
};
