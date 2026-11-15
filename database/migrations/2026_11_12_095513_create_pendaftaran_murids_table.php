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
        Schema::create('pendaftaran_murids', function (Blueprint $table) {
            $table->id();
            $table->string('nama_murid');
            $table->date('tanggal_lahir');
            $table->string('nama_wali');
            $table->string('whatsapp', 20);
            $table->string('alamat')->nullable();
            $table->string('program');
            $table->string('pengalaman');
            $table->text('catatan')->nullable();
            $table->string('status')->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_murids');
    }
};
