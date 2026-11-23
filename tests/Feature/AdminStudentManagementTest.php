<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_nama_murid_page_lists_students_with_their_class(): void
    {
        Student::create([
            'name' => 'Aulia Eky Ridha Aprilia',
            'class' => 'Tari',
        ]);

        $this->get(route('admin.nama-murid'))
            ->assertOk()
            ->assertSee('Aulia Eky Ridha Aprilia')
            ->assertSee('Tari');
    }

    public function test_admin_can_add_update_and_delete_student(): void
    {
        $this->post(route('admin.nama-murid.store'), [
            'nama_murid' => 'Murid Baru',
            'program_id' => 'Karawitan Mahir',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'name' => 'Murid Baru',
            'class' => 'Karawitan Mahir',
        ]);

        $student = Student::query()->where('name', 'Murid Baru')->firstOrFail();

        $this->put(route('admin.nama-murid.update', $student), [
            'nama_murid' => 'Nama Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Nama Baru',
            'class' => 'Karawitan Mahir',
        ]);

        $this->delete(route('admin.nama-murid.destroy', $student))->assertRedirect();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_admin_can_add_student_without_class(): void
    {
        $this->post(route('admin.nama-murid.store'), [
            'nama_murid' => 'Tanpa Kelas',
            'program_id' => '',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'name' => 'Tanpa Kelas',
            'class' => null,
        ]);
    }

    public function test_admin_can_change_student_class_when_program_is_submitted(): void
    {
        $student = Student::create([
            'name' => 'Murid Kelas',
            'class' => 'Tari',
        ]);

        $this->put(route('admin.nama-murid.update', $student), [
            'nama_murid' => 'Murid Kelas',
            'program_id' => 'Karawitan Madya I',
        ])->assertRedirect();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'class' => 'Karawitan Madya I',
        ]);
    }

    public function test_dashboard_renders_real_student_and_program_counts(): void
    {
        Student::create([
            'name' => 'Murid Dashboard',
            'class' => 'Tari',
        ]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total Murid')
            ->assertSee('Program Aktif');
    }
}
