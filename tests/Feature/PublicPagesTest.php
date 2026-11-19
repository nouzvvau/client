<?php

namespace Tests\Feature;

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
        $this->assertFalse(Schema::hasTable('programs'));
        $this->assertFalse(Schema::hasTable('locations'));
        $this->assertFalse(Schema::hasTable('staff'));
        $this->assertFalse(Schema::hasTable('pendaftaran_murids'));

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

    public function test_program_detail_redirects_to_program_page(): void
    {
        $this->get(route('program.detail', ['slug' => 'kegiatan-lama']))
            ->assertRedirect(route('program'));
    }

    public function test_booking_submission_is_validated_but_not_persisted(): void
    {
        $response = $this->from(route('booking'))->post(route('booking.store'), [
            'name' => 'Budi Pemesan',
            'phone' => '081234567890',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas Sekolah',
            'event_date' => '2026-12-11',
            'event_location' => 'Tulungagung',
        ]);

        $response
            ->assertRedirect(route('booking'))
            ->assertSessionHasErrors('booking');

        $this->assertFalse(Schema::hasTable('bookings'));
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
