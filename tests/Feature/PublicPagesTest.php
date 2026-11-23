<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_public_pages_render_without_legacy_tables(): void
    {
        $this->assertFalse(Schema::hasTable('activities'));
        $this->assertFalse(Schema::hasTable('bookings'));
        $this->assertFalse(Schema::hasTable('locations'));
        $this->assertFalse(Schema::hasTable('staff'));
        $this->assertFalse(Schema::hasTable('pendaftaran_murids'));
        $this->assertTrue(Schema::hasTable('programs'));

        $this->get('/')->assertOk();
        $this->get(route('program'))->assertOk()->assertSee('Ruang Edukasi');
        $this->get(route('galeri'))->assertOk()->assertSee('Dokumentasi latihan gamelan');
        $this->get(route('lokasi'))->assertOk()->assertSee('Sanggar Cakra Aji Beji');
        $this->get(route('kontak'))->assertOk()->assertSee('Pengurus Sanggar');
        $this->get(route('pengurus'))->assertOk()->assertSee('Yuli Wildan Santoso, S.Sn.');
        $this->get(route('murid.index'))->assertOk();
        $this->get(route('pendaftaran.index'))->assertOk();
        $this->get(route('booking'))->assertOk();
        $this->get(route('faq'))->assertOk();
        $this->get('/tentang-kami')->assertOk();
    }

    public function test_program_page_uses_database_programs_when_available(): void
    {
        Program::create([
            'name' => 'Kreteg',
            'schedule' => 'Minggu',
            'description' => 'Program kidung dan olah vokal untuk anak.',
            'is_active' => true,
        ]);

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Kreteg')
            ->assertSee('Program kidung dan olah vokal untuk anak.');
    }

    public function test_booking_and_registration_post_routes_are_not_available(): void
    {
        $this->post('/booking', [
            'name' => 'Budi Pemesan',
            'phone' => '081234567890',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas Sekolah',
            'event_date' => '2026-12-11',
            'event_location' => 'Tulungagung',
        ])->assertStatus(405);

        $this->post('/pendaftaran', [
            'nama_murid' => 'Rina Putri',
        ])->assertStatus(405);

        $this->assertFalse(Schema::hasTable('bookings'));
        $this->assertFalse(Schema::hasTable('pendaftaran_murids'));
        $this->assertDatabaseCount('students', 0);
    }

    public function test_murid_page_paginates_public_students(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Student::create([
                'name' => str_pad((string) $i, 2, '0', STR_PAD_LEFT).' Murid',
                'class' => 'Tari',
            ]);
        }

        $this->get(route('murid.index'))
            ->assertOk()
            ->assertSee('Selanjutnya');

        $this->get(route('murid.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Murid');

        $this->get(route('murid.index', ['search' => '01']))
            ->assertOk()
            ->assertSee('01 Murid')
            ->assertDontSee('02 Murid');
    }
}
