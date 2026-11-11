<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Program;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_schedules_with_their_programs(): void
    {
        [$program, $location] = $this->createProgramAndLocation();
        $schedule = Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '09:00',
        ]);

        $this->getJson('/api/schedules')
            ->assertOk()
            ->assertJsonPath('0.id', $schedule->id)
            ->assertJsonPath('0.program.id', $program->id)
            ->assertJsonPath('0.program.name', 'Program Pagi');
    }

    public function test_valid_payload_creates_schedule_and_returns_201(): void
    {
        [$program, $location] = $this->createProgramAndLocation();

        $this->postJson('/api/schedules', [
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Selasa',
            'start_time' => '09:00',
            'end_time' => '10:30',
        ])
            ->assertCreated()
            ->assertJsonPath('data.program.id', $program->id)
            ->assertJsonPath('data.program.name', 'Program Pagi');

        $this->assertDatabaseHas('schedules', [
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Selasa',
            'start_time' => '09:00',
            'end_time' => '10:30',
        ]);
    }

    public function test_show_returns_schedule_with_its_program(): void
    {
        [$program, $location] = $this->createProgramAndLocation();
        $schedule = Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Rabu',
            'start_time' => '13:00',
            'end_time' => '14:00',
        ]);

        $this->getJson("/api/schedules/{$schedule->id}")
            ->assertOk()
            ->assertJsonPath('id', $schedule->id)
            ->assertJsonPath('program.id', $program->id);
    }

    public function test_valid_payload_updates_schedule_and_returns_200(): void
    {
        [$oldProgram, $location] = $this->createProgramAndLocation();
        $newProgram = Program::create(['name' => 'Program Sore']);
        $schedule = Schedule::create([
            'program_id' => $oldProgram->id,
            'location_id' => $location->id,
            'day_of_week' => 'Kamis',
            'start_time' => '15:00',
            'end_time' => '16:00',
        ]);

        $this->putJson("/api/schedules/{$schedule->id}", [
            'program_id' => $newProgram->id,
            'day_of_week' => 'Jumat',
            'start_time' => '16:00',
            'end_time' => '17:30',
        ])
            ->assertOk()
            ->assertJsonPath('data.program.id', $newProgram->id)
            ->assertJsonPath('data.day_of_week', 'Jumat');

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'program_id' => $newProgram->id,
            'day_of_week' => 'Jumat',
            'start_time' => '16:00',
            'end_time' => '17:30',
        ]);
    }

    public function test_destroy_removes_schedule_and_returns_200(): void
    {
        [$program, $location] = $this->createProgramAndLocation();
        $schedule = Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Sabtu',
            'start_time' => '10:00',
            'end_time' => '11:00',
        ]);

        $this->deleteJson("/api/schedules/{$schedule->id}")
            ->assertOk();

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_returns_422_when_creating_schedule_with_invalid_data(): void
    {
        $this->postJson('/api/schedules', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'program_id',
                'location_id',
                'day_of_week',
                'start_time',
                'end_time',
            ]);
    }

    public function test_returns_422_when_creating_schedule_with_invalid_column_values(): void
    {
        $this->postJson('/api/schedules', [
            'program_id' => 999,
            'location_id' => 999,
            'day_of_week' => 'Hari Kerja',
            'start_time' => 'pagi',
            'end_time' => 'sore',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'program_id',
                'location_id',
                'day_of_week',
                'start_time',
                'end_time',
            ]);
    }

    public function test_returns_422_when_updating_schedule_without_data(): void
    {
        [$program, $location] = $this->createProgramAndLocation();
        $schedule = Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Minggu',
            'start_time' => '08:00',
            'end_time' => '09:00',
        ]);

        $this->putJson("/api/schedules/{$schedule->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.schedule.0', 'Minimal satu data jadwal harus dikirim.');
    }

    public function test_returns_422_when_creating_schedule_with_end_time_not_after_start_time(): void
    {
        [$program, $location] = $this->createProgramAndLocation();

        $this->postJson('/api/schedules', [
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '10:00',
            'end_time' => '09:00',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.end_time.0', 'Jam selesai harus lebih lambat dari jam mulai.');

        $this->assertDatabaseMissing('schedules', [
            'program_id' => $program->id,
            'start_time' => '10:00',
        ]);
    }

    public function test_returns_422_when_updating_end_time_before_existing_start_time(): void
    {
        [$program, $location] = $this->createProgramAndLocation();
        $schedule = Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '10:00',
            'end_time' => '11:00',
        ]);

        $this->putJson("/api/schedules/{$schedule->id}", [
            'end_time' => '09:00',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.end_time.0', 'Jam selesai harus lebih lambat dari jam mulai.');

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'end_time' => '11:00',
        ]);
    }

    public function test_returns_404_when_schedule_does_not_exist(): void
    {
        $this->getJson('/api/schedules/999')
            ->assertNotFound();
    }

    /**
     * @return array{Program, Location}
     */
    private function createProgramAndLocation(): array
    {
        $program = Program::create(['name' => 'Program Pagi']);
        $location = Location::create([
            'name' => 'Studio Utama',
            'address' => 'Jalan Melati 1',
            'google_maps_url' => 'https://maps.example.test/studio-utama',
        ]);

        return [$program, $location];
    }
}
