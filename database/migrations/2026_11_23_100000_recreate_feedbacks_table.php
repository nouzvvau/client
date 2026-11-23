<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat ulang tabel feedbacks untuk fitur Kritik & Saran.
     * Tabel lama dihapus oleh migrasi drop_legacy_tables; skema mengikuti
     * migrasi asli 2026_11_11_111951_create_feedbacks_table.
     */
    public function up(): void
    {
        if (Schema::hasTable('feedbacks')) {
            return;
        }

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sender_type')->nullable();
            $table->string('message_type');
            $table->string('subject');
            $table->text('message');
            $table->string('reply_contact')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Tidak menghapus tabel feedbacks agar masukan yang sudah masuk
     * tidak hilang saat rollback.
     */
    public function down(): void
    {
        //
    }
};
