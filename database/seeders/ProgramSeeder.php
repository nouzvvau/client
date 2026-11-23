<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Mengisi data Program & Kegiatan awal tanpa menghapus data yang sudah ada.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Ruang Edukasi & Workshop',
                'name_en' => 'Education Space & Workshop',
                'schedule' => 'Rabu & Minggu, sesuai kelompok',
                'schedule_en' => 'Wednesday & Sunday, by group',
                'description' => 'Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.',
                'description_en' => 'Structured karawitan classes from beginner to advanced levels, covering practice, theory, and a full understanding of the art.',
                'image' => 'assets/images/galeri/galeri-01.jpeg',
            ],
            [
                'name' => 'Kreteg',
                'name_en' => 'Kreteg',
                'schedule' => 'Minggu, sesuai kelompok',
                'schedule_en' => 'Sunday, by group',
                'description' => 'Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.',
                'description_en' => 'A singing and vocal training program for children, introducing traditional songs while building confidence on stage.',
                'image' => 'assets/images/galeri/galeri-02.jpeg',
            ],
            [
                'name' => 'Grebek Kampung',
                'name_en' => 'Village Tour',
                'schedule' => 'Agustus 2025',
                'schedule_en' => 'August 2025',
                'description' => 'Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.',
                'description_en' => 'A traveling performance that brings together music, movement, and stories with residents in village spaces.',
                'image' => 'assets/images/galeri/galeri-03.jpeg',
            ],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(
                ['name' => $program['name']],
                $program + ['is_active' => true]
            );
        }
    }
}
