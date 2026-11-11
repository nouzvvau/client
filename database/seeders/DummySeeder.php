<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityPhoto;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\Location;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // PROGRAM
        $program1 = Program::create([
            'name' => 'Tari Tradisional',
            'description' => 'Program pembelajaran tari tradisional.',
            'is_active' => true,
        ]);

        $program2 = Program::create([
            'name' => 'Karawitan',
            'description' => 'Program pembelajaran seni karawitan.',
            'is_active' => true,
        ]);

        // MURID
        $student1 = Student::create([
            'full_name' => 'Budi Santoso',
            'birth_date' => '2015-05-12',
            'guardian_name' => 'Siti Aminah',
            'contact_phone' => '081234567890',
            'address' => 'Tulungagung',
            'joined_at' => now()->toDateString(),
            'status' => 'active',
        ]);

        $student2 = Student::create([
            'full_name' => 'Ani Putri',
            'birth_date' => '2016-08-20',
            'guardian_name' => 'Dewi Lestari',
            'contact_phone' => '081234567891',
            'address' => 'Tulungagung',
            'joined_at' => now()->toDateString(),
            'status' => 'active',
        ]);

        // RELASI MURID DAN PROGRAM
        $student1->programs()->attach($program1->id, [
            'status' => 'active',
            'joined_at' => now()->toDateString(),
        ]);

        $student2->programs()->attach($program2->id, [
            'status' => 'active',
            'joined_at' => now()->toDateString(),
        ]);

        // LOKASI
        $location = Location::create([
            'name' => 'Sanggar Utama',
            'address' => 'Tulungagung',
            'description' => 'Lokasi latihan utama.',
            'google_maps_url' => 'https://maps.google.com/',
            'is_active' => true,
        ]);

        // JADWAL
        Schedule::create([
            'program_id' => $program1->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '15:00:00',
            'end_time' => '17:00:00',
        ]);

        // STAF
        Staff::create([
            'name' => 'Pak Agus',
            'position' => 'Pelatih Tari',
            'description' => 'Pelatih tari tradisional.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // PENDAFTARAN
        Registration::create([
            'full_name' => 'Citra Lestari',
            'birth_date' => '2017-03-15',
            'guardian_name' => 'Rina Lestari',
            'contact_phone' => '081234567892',
            'address' => 'Tulungagung',
            'program_id' => $program1->id,
            'music_experience' => 'Belum pernah',
            'notes' => 'Data dummy.',
            'status' => 'pending',
            'created_at' => now(),
        ]);

        // BOOKING
        Booking::create([
            'name' => 'Panitia Acara',
            'phone' => '081234567893',
            'institution_name' => 'Sekolah Contoh',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas Seni Sekolah',
            'event_date' => now()->addMonth()->toDateString(),
            'start_time' => '09:00:00',
            'event_location' => 'Tulungagung',
            'estimated_audience' => 100,
            'additional_notes' => 'Data dummy.',
            'status' => 'pending',
            'created_at' => now(),
        ]);

        // FEEDBACK
        Feedback::create([
            'name' => 'Orang Tua Murid',
            'sender_type' => 'Ortu',
            'message_type' => 'Saran',
            'subject' => 'Jadwal Latihan',
            'message' => 'Semoga jadwal latihan lebih bervariasi.',
            'reply_contact' => '081234567894',
            'is_read' => false,
            'created_at' => now(),
        ]);

        // AKTIVITAS
        $activity = Activity::create([
            'title' => 'Latihan Bersama',
            'description' => 'Dokumentasi kegiatan latihan.',
            'date' => now()->toDateString(),
        ]);

        // FOTO AKTIVITAS
        ActivityPhoto::create([
            'activity_id' => $activity->id,
            'photo' => 'activities/dummy-photo.jpg',
            'caption' => 'Foto dummy aktivitas.',
        ]);
    }
}
