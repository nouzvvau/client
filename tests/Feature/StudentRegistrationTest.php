<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_does_not_render_a_laravel_form(): void
    {
        $this->get(route('pendaftaran.index'))
            ->assertOk()
            ->assertDontSee('name="nama_murid"', false)
            ->assertDontSee('name="nama_wali"', false);
    }

    public function test_registration_submission_is_not_stored_in_the_database(): void
    {
        $this->post('/pendaftaran', [
            'nama_murid' => 'Rina Putri',
            'tanggal_lahir' => '2015-04-12',
            'nama_wali' => 'Bapak Budi',
            'whatsapp' => '081234567890',
            'program' => 'Tari',
            'pengalaman' => 'Belum pernah',
        ])->assertStatus(405);

        $this->assertDatabaseCount('students', 0);
    }

    public function test_registered_student_is_publicly_listed_with_class(): void
    {
        Student::create([
            'name' => 'Aulia Eky',
            'class' => 'Karawitan',
        ]);

        $this->get(route('murid.index'))
            ->assertOk()
            ->assertSee('Aulia Eky')
            ->assertSee('Karawitan');
    }
}
