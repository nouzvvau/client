<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProgramManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_program_page_lists_programs(): void
    {
        Program::create([
            'name' => 'Ruang Edukasi & Workshop',
            'schedule' => 'Rabu & Minggu',
            'description' => 'Kelas karawitan terstruktur.',
            'is_active' => true,
        ]);

        $this->get(route('admin.program.index'))
            ->assertOk()
            ->assertSee('Ruang Edukasi &amp; Workshop', false)
            ->assertSee('Rabu &amp; Minggu', false);
    }

    public function test_admin_can_add_update_and_delete_program(): void
    {
        $this->post(route('admin.program.store'), [
            'name' => 'Program Baru',
            'schedule' => 'Sabtu',
            'description' => 'Deskripsi program baru.',
            'image' => 'assets/images/galeri/galeri-01.jpeg',
            'is_active' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('programs', [
            'name' => 'Program Baru',
            'schedule' => 'Sabtu',
            'is_active' => true,
        ]);

        $program = Program::query()->where('name', 'Program Baru')->firstOrFail();

        $this->put(route('admin.program.update', $program), [
            'name' => 'Program Diubah',
            'schedule' => 'Minggu',
            'description' => 'Deskripsi diperbarui.',
            'image' => 'assets/images/galeri/galeri-02.jpeg',
        ])->assertRedirect(route('admin.program.index'));

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Program Diubah',
            'schedule' => 'Minggu',
            'is_active' => false,
        ]);

        $this->delete(route('admin.program.destroy', $program))->assertRedirect();

        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
    }

    public function test_public_program_page_and_detail_use_database_programs(): void
    {
        Program::create([
            'name' => 'Grebek Kampung',
            'schedule' => 'Agustus 2025',
            'description' => 'Pentas keliling bersama warga.',
            'image' => 'assets/images/galeri/galeri-03.jpeg',
            'is_active' => true,
        ]);

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Grebek Kampung')
            ->assertSee('Agustus 2025');

        $this->get(route('program.detail', ['slug' => 'grebek-kampung']))
            ->assertOk()
            ->assertSee('Grebek Kampung')
            ->assertSee('Pentas keliling bersama warga.');
    }

    public function test_admin_can_store_english_program_fields(): void
    {
        $this->post(route('admin.program.store'), [
            'name' => 'Grebek Kampung',
            'name_en' => 'Village Tour',
            'schedule' => 'Agustus 2025',
            'schedule_en' => 'August 2025',
            'description' => 'Pentas keliling bersama warga.',
            'description_en' => 'A traveling performance with residents.',
            'is_active' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('programs', [
            'name' => 'Grebek Kampung',
            'name_en' => 'Village Tour',
            'schedule_en' => 'August 2025',
            'description_en' => 'A traveling performance with residents.',
        ]);
    }

    public function test_inactive_program_is_hidden_from_public_pages(): void
    {
        Program::create([
            'name' => 'Program Rahasia',
            'is_active' => false,
        ]);

        $this->get(route('program'))
            ->assertOk()
            ->assertDontSee('Program Rahasia');

        $this->get(route('program.detail', ['slug' => 'program-rahasia']))
            ->assertNotFound();
    }
}
