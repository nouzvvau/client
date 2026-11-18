<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Location;
use App\Models\PendaftaranMurid;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    // ===== INT-005: halaman pendaftar =====

    public function test_pendaftar_page_shows_registration_data_from_database(): void
    {
        PendaftaranMurid::create([
            'nama_murid' => 'Budi Calon Murid',
            'tanggal_lahir' => '2015-01-01',
            'nama_wali' => 'Wali Budi',
            'whatsapp' => '081234567890',
            'program' => 'Tari',
            'pengalaman' => 'Belum pernah',
            'status' => 'Menunggu',
        ]);

        $this->get(route('admin.pendaftar'))
            ->assertOk()
            ->assertSee('Budi Calon Murid')
            ->assertSee('Wali Budi')
            ->assertSee('081234567890')
            ->assertSee('Menunggu');
    }

    public function test_pendaftar_page_shows_empty_state_when_no_registrations(): void
    {
        $this->get(route('admin.pendaftar'))
            ->assertOk()
            ->assertSee('Belum ada pendaftar murid.');
    }

    public function test_pendaftar_page_filters_by_search_and_status(): void
    {
        PendaftaranMurid::create([
            'nama_murid' => 'Andi',
            'tanggal_lahir' => '2015-01-01',
            'nama_wali' => 'Wali Andi',
            'whatsapp' => '081111111111',
            'program' => 'Tari',
            'pengalaman' => 'Belum pernah',
            'status' => 'Menunggu',
        ]);

        $this->get(route('admin.pendaftar', ['cari' => 'andi']))
            ->assertOk()
            ->assertSee('Andi');

        $this->get(route('admin.pendaftar', ['cari' => 'tidakada']))
            ->assertOk()
            ->assertSee('Tidak ada pendaftar yang cocok dengan filter.');
    }

    public function test_pendaftar_page_is_not_accessible_for_guests(): void
    {
        auth()->logout();

        $this->get(route('admin.pendaftar'))->assertRedirect(route('login'));
    }

    // ===== INT-003: halaman booking =====

    public function test_booking_page_shows_real_bookings(): void
    {
        Booking::create([
            'name' => 'Panitia Lomba',
            'phone' => '081234567893',
            'institution_name' => 'SD Nusantara',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Lomba Sekolah',
            'event_date' => '2026-12-11',
            'event_location' => 'Tulungagung',
            'status' => 'pending',
        ]);

        $this->get(route('admin.booking'))
            ->assertOk()
            ->assertSee('Panitia Lomba')
            ->assertSee('Lomba Sekolah')
            ->assertSee('https://wa.me/081234567893', false);
    }

    public function test_admin_can_change_booking_status(): void
    {
        $booking = Booking::create([
            'name' => 'Panitia Acara',
            'phone' => '081234567893',
            'institution_name' => 'Sekolah Contoh',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas',
            'event_date' => '2026-12-11',
            'event_location' => 'Tulungagung',
            'status' => 'pending',
        ]);

        $this->post(route('admin.booking.status', $booking), [
            'status' => 'accepted',
        ])->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'accepted',
        ]);
    }

    // ===== INT-003: pengaturan daftar nama siswa =====

    public function test_nama_murid_page_shows_students(): void
    {
        Student::create(['full_name' => 'Aulia Eky Ridha Aprilia']);

        $this->get(route('admin.nama-murid'))
            ->assertOk()
            ->assertSee('Aulia Eky Ridha Aprilia');
    }

    public function test_admin_can_add_update_and_delete_student(): void
    {
        $this->post(route('admin.nama-murid.store'), [
            'nama_murid' => 'Murid Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', ['full_name' => 'Murid Baru']);

        $student = Student::where('full_name', 'Murid Baru')->firstOrFail();

        $this->put(route('admin.nama-murid.update', $student), [
            'nama_murid' => 'Nama Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'full_name' => 'Nama Baru',
        ]);

        $this->delete(route('admin.nama-murid.destroy', $student))->assertRedirect();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_student_with_program_cannot_be_deleted(): void
    {
        $program = Program::create(['name' => 'Karawitan']);
        $student = Student::create(['full_name' => 'Murid Terhubung']);
        $student->programs()->attach($program->id, ['status' => 'active']);

        $this->delete(route('admin.nama-murid.destroy', $student))->assertSessionHasErrors();

        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }

    // ===== INT-003: edit galeri =====

    public function test_admin_can_edit_activity_information(): void
    {
        Storage::fake('public');
        $activity = Activity::create(['title' => 'Acara Lama']);
        $photo = $activity->photos()->create(['photo' => 'activities/tes.jpg']);

        $this->get(route('admin.galeri.edit', $activity))
            ->assertOk()
            ->assertSee('Acara Lama');

        $this->put(route('admin.galeri.update', $activity), [
            'title' => 'Acara Baru',
            'date' => '2026-08-17',
            'description' => 'Deskripsi baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Acara Baru',
        ]);
    }

    public function test_admin_can_upload_and_delete_activity_photo(): void
    {
        Storage::fake('public');
        $activity = Activity::create(['title' => 'Acara Foto']);

        $this->post(route('admin.galeri.photos.store', $activity), [
            'photos' => [UploadedFile::fake()->image('foto.jpg')],
        ])->assertRedirect();

        $photo = $activity->photos()->firstOrFail();
        Storage::disk('public')->assertExists($photo->photo);

        $this->delete(route('admin.galeri.photos.destroy', $photo))->assertRedirect();

        $this->assertDatabaseMissing('activity_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing($photo->photo);
    }

    public function test_admin_can_delete_activity_with_all_photos(): void
    {
        Storage::fake('public');
        $activity = Activity::create(['title' => 'Acara Hapus']);
        $photo = $activity->photos()->create(['photo' => 'activities/hapus.jpg']);
        Storage::disk('public')->put('activities/hapus.jpg', 'dummy');

        $this->delete(route('admin.galeri.destroy', $activity))->assertRedirect(route('admin.galeri'));

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
        $this->assertDatabaseMissing('activity_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing('activities/hapus.jpg');
    }

    // ===== INT-004: pagination murid =====

    public function test_murid_page_paginates_and_shows_second_page(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Student::create(['full_name' => str_pad((string) $i, 2, '0', STR_PAD_LEFT).' Murid']);
        }

        $page1 = $this->get(route('murid.index'));
        $page1->assertOk();
        $page1->assertSee('Murid');
        $page1->assertSee('Selanjutnya');

        $this->get(route('murid.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Murid');

        $this->get(route('murid.index', ['search' => '01']))
            ->assertOk()
            ->assertSee('01 Murid')
            ->assertDontSee('02 Murid');
    }

    // ===== INT-002: integrasi konten database ke halaman publik =====

    public function test_public_galeri_page_shows_activities_with_photos(): void
    {
        Storage::fake('public');
        $activity = Activity::create(['title' => 'Kegiatan Panggung']);
        $photo = $activity->photos()->create(['photo' => 'activities/panggung.jpg']);
        Storage::disk('public')->put('activities/panggung.jpg', 'dummy');

        $this->get(route('galeri'))
            ->assertOk()
            ->assertSee('Kegiatan Panggung');
    }

    public function test_public_galeri_page_falls_back_to_static_content_when_empty(): void
    {
        Activity::query()->delete();

        $this->get(route('galeri'))
            ->assertOk()
            ->assertSee('Dokumentasi latihan gamelan');
    }

    public function test_public_galeri_page_shows_schedules_from_database(): void
    {
        $program = Program::create(['name' => 'Program Jadwal']);
        $location = Location::create(['name' => 'Sanggar Uji', 'address' => 'Jl. Uji No. 1', 'google_maps_url' => 'https://maps.google.com/']);
        Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '15:00',
            'end_time' => '17:00',
        ]);

        $this->get(route('galeri'))
            ->assertOk()
            ->assertSee('Program Jadwal')
            ->assertSee('Senin')
            ->assertSee('Sanggar Uji');
    }

    public function test_public_program_page_shows_activities_from_database(): void
    {
        Storage::fake('public');
        $activity = Activity::create([
            'title' => 'Kolaborasi Uji',
            'description' => 'Deskripsi kolaborasi uji.',
            'date' => '2026-08-01',
        ]);
        $activity->photos()->create(['photo' => 'activities/uji.jpg']);
        Storage::disk('public')->put('activities/uji.jpg', 'dummy');

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Kolaborasi Uji')
            ->assertSee('Deskripsi kolaborasi uji.');
    }

    public function test_public_lokasi_page_shows_locations_from_database(): void
    {
        $location = Location::create([
            'name' => 'Sanggar Plosokandang Uji',
            'address' => 'Jl. Manggisan',
            'google_maps_url' => 'https://maps.google.com/',
        ]);

        $this->get(route('lokasi'))
            ->assertOk()
            ->assertSee('Sanggar Plosokandang Uji')
            ->assertSee('Jl. Manggisan');
    }

    public function test_public_pengurus_page_shows_staff_from_database(): void
    {
        Staff::create([
            'name' => 'Pak Sariwan',
            'position' => 'Pelatih Karawitan',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get(route('pengurus'))
            ->assertOk()
            ->assertSee('Pak Sariwan')
            ->assertSee('Pelatih Karawitan');
    }

    public function test_public_pengurus_page_falls_back_to_static_team_when_empty(): void
    {
        Staff::query()->delete();

        $this->get(route('pengurus'))
            ->assertOk()
            ->assertSee('Yuli Wildan Santoso, S.Sn.')
            ->assertSee('Zefanya Widya');
    }
}
