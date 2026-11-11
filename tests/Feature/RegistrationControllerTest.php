<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Registration;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_registrations_with_their_programs(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $registration = $this->createRegistration($program);

        $this->getJson('/api/registrations')
            ->assertOk()
            ->assertJsonPath('0.id', $registration->id)
            ->assertJsonPath('0.program.id', $program->id)
            ->assertJsonPath('0.program.name', 'Program Tari');
    }

    public function test_valid_payload_creates_registration_with_program_and_returns_201(): void
    {
        $program = Program::create(['name' => 'Program Musik']);

        $this->postJson('/api/registrations', [
            'full_name' => 'Citra Lestari',
            'birth_date' => '2017-03-15',
            'guardian_name' => 'Rina Lestari',
            'contact_phone' => '081234567890',
            'address' => 'Tulungagung',
            'program_id' => $program->id,
            'music_experience' => 'Belum pernah',
            'notes' => 'Perlu jadwal sore',
        ])
            ->assertCreated()
            ->assertJsonPath('data.full_name', 'Citra Lestari')
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.program.id', $program->id)
            ->assertJsonPath('data.program.name', 'Program Musik');

        $this->assertDatabaseHas('registrations', [
            'full_name' => 'Citra Lestari',
            'program_id' => $program->id,
            'status' => 'pending',
        ]);
    }

    public function test_show_returns_registration_with_its_program(): void
    {
        $program = Program::create(['name' => 'Program Karawitan']);
        $registration = $this->createRegistration($program);

        $this->getJson("/api/registrations/{$registration->id}")
            ->assertOk()
            ->assertJsonPath('id', $registration->id)
            ->assertJsonPath('program.id', $program->id);
    }

    public function test_valid_payload_updates_registration_and_returns_200(): void
    {
        $oldProgram = Program::create(['name' => 'Program Tari']);
        $newProgram = Program::create(['name' => 'Program Musik']);
        $registration = $this->createRegistration($oldProgram);

        $this->putJson("/api/registrations/{$registration->id}", [
            'program_id' => $newProgram->id,
            'contact_phone' => '081234567899',
            'status' => 'completed',
        ])
            ->assertOk()
            ->assertJsonPath('data.program.id', $newProgram->id)
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('registrations', [
            'id' => $registration->id,
            'program_id' => $newProgram->id,
            'contact_phone' => '081234567899',
            'status' => 'completed',
        ]);
    }

    public function test_destroy_removes_registration_and_returns_200(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $registration = $this->createRegistration($program);

        $this->deleteJson("/api/registrations/{$registration->id}")
            ->assertOk();

        $this->assertDatabaseMissing('registrations', ['id' => $registration->id]);
    }

    public function test_returns_422_when_creating_registration_with_missing_required_data(): void
    {
        $this->postJson('/api/registrations', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'full_name',
                'birth_date',
                'guardian_name',
                'contact_phone',
                'program_id',
            ]);
    }

    public function test_returns_422_when_creating_registration_with_invalid_column_values(): void
    {
        $this->postJson('/api/registrations', [
            'full_name' => str_repeat('a', 256),
            'birth_date' => '2100-01-01',
            'guardian_name' => str_repeat('b', 256),
            'contact_phone' => str_repeat('1', 21),
            'address' => ['invalid'],
            'program_id' => 999,
            'music_experience' => ['invalid'],
            'notes' => ['invalid'],
            'status' => 'invalid',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'full_name',
                'birth_date',
                'guardian_name',
                'contact_phone',
                'address',
                'program_id',
                'music_experience',
                'notes',
                'status',
            ]);
    }

    public function test_returns_422_when_updating_registration_without_data(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $registration = $this->createRegistration($program);

        $this->putJson("/api/registrations/{$registration->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.registration.0', 'Minimal satu data pendaftaran harus dikirim.');
    }

    public function test_returns_404_when_registration_does_not_exist(): void
    {
        $this->getJson('/api/registrations/999')
            ->assertNotFound();
    }

    private function createRegistration(Program $program): Registration
    {
        return Registration::create([
            'full_name' => 'Budi Santoso',
            'birth_date' => '2016-05-10',
            'guardian_name' => 'Siti Santoso',
            'contact_phone' => '081234567891',
            'address' => 'Tulungagung',
            'program_id' => $program->id,
            'music_experience' => 'Pernah belajar',
            'status' => 'pending',
        ]);
    }
}
