<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_registration_stores_only_student_name_and_class(): void
    {
        $response = $this->post(route('pendaftaran.store'), [
            'nama_murid' => 'Rina Putri',
            'tanggal_lahir' => '2015-04-12',
            'nama_wali' => 'Bapak Budi',
            'whatsapp' => '081234567890',
            'alamat' => 'Tulungagung',
            'program' => 'Tari',
            'pengalaman' => 'Belum pernah',
            'catatan' => 'Ingin kelas sore',
        ]);

        $response
            ->assertRedirect(route('pendaftaran.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'name' => 'Rina Putri',
            'class' => 'Tari',
        ]);
        $this->assertDatabaseCount('students', 1);
        $this->assertSame(['id', 'name', 'class'], Schema::getColumnListing('students'));
    }

    public function test_registration_validates_existing_form_fields(): void
    {
        $this->post(route('pendaftaran.store'), [])
            ->assertSessionHasErrors([
                'nama_murid',
                'tanggal_lahir',
                'nama_wali',
                'whatsapp',
                'program',
                'pengalaman',
            ]);

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
