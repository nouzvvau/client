<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom konten Bahasa Inggris untuk Program & Kegiatan.
     * Kolom dibuat nullable agar data lama tetap aman dan halaman English
     * otomatis memakai konten Indonesia ketika terjemahan belum diisi.
     */
    public function up(): void
    {
        if (! Schema::hasTable('programs')) {
            return;
        }

        Schema::table('programs', function (Blueprint $table): void {
            if (! Schema::hasColumn('programs', 'name_en')) {
                $table->string('name_en')->nullable()->after('name');
            }

            if (! Schema::hasColumn('programs', 'schedule_en')) {
                $table->string('schedule_en')->nullable()->after('schedule');
            }

            if (! Schema::hasColumn('programs', 'description_en')) {
                $table->text('description_en')->nullable()->after('description');
            }
        });

        $this->backfillTranslations();
    }

    /**
     * Mengisi terjemahan awal hanya untuk data bawaan yang belum memiliki
     * terjemahan. Data yang sudah diubah admin tidak ditimpa.
     */
    private function backfillTranslations(): void
    {
        $translations = [
            'Ruang Edukasi & Workshop' => [
                'name_en' => 'Education Space & Workshop',
                'schedule_en' => 'Wednesday & Sunday, by group',
                'description_en' => 'Structured karawitan classes from beginner to advanced levels, covering practice, theory, and a full understanding of the art.',
            ],
            'Kreteg' => [
                'name_en' => 'Kreteg',
                'schedule_en' => 'Sunday, by group',
                'description_en' => 'A singing and vocal training program for children, introducing traditional songs while building confidence on stage.',
            ],
            'Grebek Kampung' => [
                'name_en' => 'Village Tour',
                'schedule_en' => 'August 2025',
                'description_en' => 'A traveling performance that brings together music, movement, and stories with residents in village spaces.',
            ],
        ];

        foreach ($translations as $name => $values) {
            DB::table('programs')
                ->where('name', $name)
                ->whereNull('name_en')
                ->update($values);
        }
    }

    /**
     * Kolom terjemahan tidak dihapus saat rollback agar konten yang sudah
     * diisi tidak hilang.
     */
    public function down(): void
    {
        //
    }
};
