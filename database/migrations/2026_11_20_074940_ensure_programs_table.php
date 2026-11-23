<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Memastikan tabel programs tersedia sebagai satu-satunya sumber data
     * Program & Kegiatan. Migrasi ini aman dijalankan pada database lama
     * yang tabel programs-nya sudah pernah dibuat maupun yang belum.
     */
    public function up(): void
    {
        if (! Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('schedule')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            return;
        }

        if (! Schema::hasColumn('programs', 'schedule')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->string('schedule')->nullable()->after('name');
            });
        }
    }

    /**
     * Tidak menghapus tabel programs agar data Program & Kegiatan yang sudah
     * ada tidak hilang saat rollback.
     */
    public function down(): void
    {
        //
    }
};
