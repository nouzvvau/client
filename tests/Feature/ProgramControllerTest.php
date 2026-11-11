<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Program;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgramControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_programs_with_relation_counts(): void
    {
        $olderProgram = Program::create(['name' => 'Program Lama']);
        $olderProgram->forceFill(['created_at' => now()->subDay()])->save();
        $program = Program::create(['name' => 'Program Baru']);

        $this->getJson('/api/programs')
            ->assertOk()
            ->assertJsonPath('0.id', $program->id)
            ->assertJsonPath('0.name', 'Program Baru')
            ->assertJsonPath('0.students_count', 0)
            ->assertJsonPath('0.schedules_count', 0)
            ->assertJsonPath('0.registrations_count', 0)
            ->assertJsonPath('1.id', $olderProgram->id);
    }

    public function test_valid_payload_creates_program_with_image_and_returns_201(): void
    {
        Storage::fake('public');

        $response = $this->post('/api/programs', [
            'name' => 'Program Musik',
            'description' => 'Kelas musik tradisional',
            'image' => UploadedFile::fake()->image('musik.jpg'),
        ], ['Accept' => 'application/json']);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'Program Musik')
            ->assertJsonPath('data.description', 'Kelas musik tradisional')
            ->assertJsonPath('data.is_active', true);

        $imagePath = $response->json('data.image');

        $this->assertStringStartsWith('programs/', $imagePath);
        Storage::disk('public')->assertExists($imagePath);
        $this->assertDatabaseHas('programs', [
            'name' => 'Program Musik',
            'is_active' => true,
        ]);
    }

    public function test_show_returns_program_with_its_relations(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $student = Student::create(['full_name' => 'Budi Santoso']);
        $student->programs()->attach($program->id);

        $this->getJson("/api/programs/{$program->id}")
            ->assertOk()
            ->assertJsonPath('id', $program->id)
            ->assertJsonPath('students.0.id', $student->id);
    }

    public function test_valid_payload_updates_program_and_returns_200(): void
    {
        $program = Program::create(['name' => 'Program Tari']);

        $this->putJson("/api/programs/{$program->id}", [
            'name' => 'Program Karawitan',
            'description' => 'Deskripsi baru',
            'is_active' => false,
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Program Karawitan')
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Program Karawitan',
            'is_active' => false,
        ]);
    }

    public function test_replacing_program_image_removes_old_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('programs/old-image.jpg', 'image');
        $program = Program::create(['name' => 'Program Tari', 'image' => 'programs/old-image.jpg']);

        $response = $this->post("/api/programs/{$program->id}", [
            'name' => 'Program Tari',
            'image' => UploadedFile::fake()->image('new-image.jpg'),
            '_method' => 'PUT',
        ], ['Accept' => 'application/json']);

        $response->assertOk();

        $imagePath = $response->json('data.image');

        Storage::disk('public')->assertMissing('programs/old-image.jpg');
        Storage::disk('public')->assertExists($imagePath);
        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'image' => $imagePath,
        ]);
    }

    public function test_destroy_removes_program_and_its_image_and_returns_200(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('programs/old-image.jpg', 'image');
        $program = Program::create(['name' => 'Program Tari', 'image' => 'programs/old-image.jpg']);

        $this->deleteJson("/api/programs/{$program->id}")
            ->assertOk();

        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
        Storage::disk('public')->assertMissing('programs/old-image.jpg');
    }

    public function test_destroy_is_blocked_when_program_still_has_relations(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $student = Student::create(['full_name' => 'Budi Santoso']);
        $student->programs()->attach($program->id);

        $this->deleteJson("/api/programs/{$program->id}")
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Program memiliki relasi atau riwayat. Nonaktifkan program daripada menghapus permanen.');

        $this->assertDatabaseHas('programs', ['id' => $program->id]);
    }

    public function test_destroy_is_blocked_when_program_still_has_registrations(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        Registration::create([
            'full_name' => 'Citra Lestari',
            'birth_date' => '2017-03-15',
            'guardian_name' => 'Rina Lestari',
            'contact_phone' => '081234567890',
            'program_id' => $program->id,
        ]);

        $this->deleteJson("/api/programs/{$program->id}")
            ->assertUnprocessable();

        $this->assertDatabaseHas('programs', ['id' => $program->id]);
    }

    public function test_destroy_is_blocked_when_program_still_has_schedules(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        Schedule::create([
            'program_id' => $program->id,
            'location_id' => $this->createLocation()->id,
            'day_of_week' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '09:00',
        ]);

        $this->deleteJson("/api/programs/{$program->id}")
            ->assertUnprocessable();

        $this->assertDatabaseHas('programs', ['id' => $program->id]);
    }

    public function test_returns_422_when_creating_program_with_missing_required_data(): void
    {
        $this->postJson('/api/programs', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_returns_422_when_creating_program_with_invalid_column_values(): void
    {
        $this->post('/api/programs', [
            'name' => str_repeat('a', 256),
            'description' => ['invalid'],
            'image' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
            'is_active' => 'aktif',
        ], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'description',
                'image',
                'is_active',
            ]);
    }

    public function test_returns_404_when_program_does_not_exist(): void
    {
        $this->getJson('/api/programs/999')
            ->assertNotFound();
    }

    private function createLocation(): Location
    {
        return Location::create([
            'name' => 'Studio Utama',
            'address' => 'Jalan Melati 1',
            'google_maps_url' => 'https://maps.example.test/studio-utama',
        ]);
    }
}
