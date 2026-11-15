<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class KegiatanSeeder extends Seeder
{
    /**
     * @return array{
     *     title: string,
     *     description: string,
     *     date: string,
     *     photos: array<int, array{file: string, caption: string}>
     * }
     */
    private function kegiatan(): array
    {
        return [
            [
                'title' => 'Ruang Edukasi & Workshop',
                'description' => 'Kelas karawitan terstruktur dari tingkat dasar hingga mahir, mencakup praktik, teori, dan pemahaman konsep seni.',
                'date' => '2025-08-01',
                'photos' => [
                    ['file' => 'galeri-01.jpeg', 'caption' => 'Latihan gamelan ruang edukasi Cakra Aji'],
                    ['file' => 'galeri-04.jpeg', 'caption' => 'Workshop karawitan bersama peserta'],
                ],
            ],
            [
                'title' => 'Kreteg',
                'description' => 'Program kidung dan olah vokal untuk anak, mengenalkan lagu tradisi sekaligus melatih kepercayaan diri di atas panggung.',
                'date' => '2025-08-02',
                'photos' => [
                    ['file' => 'galeri-02.jpeg', 'caption' => 'Latihan kidung program Kreteg'],
                    ['file' => 'galeri-05.jpeg', 'caption' => 'Olah vokal anak-anak Kreteg'],
                ],
            ],
            [
                'title' => 'Grebek Kampung',
                'description' => 'Pentas keliling yang mempertemukan musik, gerak, dan cerita dengan warga di ruang-ruang kampung.',
                'date' => '2025-08-10',
                'photos' => [
                    ['file' => 'galeri-03.jpeg', 'caption' => 'Pentas Grebek Kampung di Boyolangu'],
                    ['file' => 'galeri-06.jpeg', 'caption' => 'Panggung kampung Grebek Kampung'],
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->kegiatan() as $data) {
            $photos = $data['photos'];
            unset($data['photos']);

            $activity = Activity::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'date' => $data['date'],
                ]
            );

            foreach ($photos as $photo) {
                $path = 'activities/'.$photo['file'];

                if (! Storage::disk('public')->exists($path)) {
                    $source = public_path('assets/images/galeri/'.$photo['file']);

                    if (is_file($source)) {
                        Storage::disk('public')->put($path, (string) file_get_contents($source));
                    }
                }

                ActivityPhoto::firstOrCreate(
                    [
                        'activity_id' => $activity->id,
                        'photo' => $path,
                    ],
                    ['caption' => $photo['caption']]
                );
            }
        }
    }
}
