<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_documentation_photos', function (Blueprint $table) {
            $table->boolean('is_thumbnail')
                ->default(false)
                ->after('caption');
        });

        // Pilih foto pertama dari setiap program sebagai thumbnail awal.
        $firstPhotos = DB::table('event_documentations as ed')
            ->join(
                'event_documentation_photos as edp',
                'edp.event_documentation_id',
                '=',
                'ed.id'
            )
            ->selectRaw('MIN(edp.id) as photo_id')
            ->groupBy('ed.program_id')
            ->get();

        foreach ($firstPhotos as $photo) {
            DB::table('event_documentation_photos')
                ->where('id', $photo->photo_id)
                ->update(['is_thumbnail' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('event_documentation_photos', function (Blueprint $table) {
            $table->dropColumn('is_thumbnail');
        });
    }
};