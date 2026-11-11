<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Program;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_locations(): void
    {
        $location = $this->createLocation();

        $this->getJson('/api/locations')
            ->assertOk()
            ->assertJsonPath('0.id', $location->id)
            ->assertJsonPath('0.name', 'Studio Utama');
    }

    public function test_valid_payload_creates_location_and_returns_201(): void
    {
        $this->postJson('/api/locations', [
            'name' => 'Studio Timur',
            'address' => 'Jalan Mawar 2',
            'description' => 'Ruang latihan tari',
            'google_maps_url' => 'https://maps.example.test/studio-timur',
            'is_active' => false,
        ])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Studio Timur')
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('locations', [
            'name' => 'Studio Timur',
            'address' => 'Jalan Mawar 2',
            'description' => 'Ruang latihan tari',
            'google_maps_url' => 'https://maps.example.test/studio-timur',
            'is_active' => false,
        ]);
    }

    public function test_show_returns_location(): void
    {
        $location = $this->createLocation();

        $this->getJson("/api/locations/{$location->id}")
            ->assertOk()
            ->assertJsonPath('id', $location->id)
            ->assertJsonPath('google_maps_url', 'https://maps.example.test/studio-utama');
    }

    public function test_valid_payload_updates_location_and_returns_200(): void
    {
        $location = $this->createLocation();

        $this->putJson("/api/locations/{$location->id}", [
            'name' => 'Studio Barat',
            'is_active' => false,
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Studio Barat')
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Studio Barat',
            'is_active' => false,
        ]);
    }

    public function test_destroy_removes_location_and_returns_200(): void
    {
        $location = $this->createLocation();

        $this->deleteJson("/api/locations/{$location->id}")
            ->assertOk();

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_returns_422_when_creating_location_with_missing_required_data(): void
    {
        $this->postJson('/api/locations', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'address',
                'google_maps_url',
            ]);
    }

    public function test_returns_422_when_creating_location_with_invalid_column_values(): void
    {
        $this->postJson('/api/locations', [
            'name' => str_repeat('a', 256),
            'address' => 'Jalan Melati 3',
            'description' => ['invalid'],
            'google_maps_url' => 'bukan-url',
            'is_active' => 'aktif',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'description',
                'google_maps_url',
                'is_active',
            ]);
    }

    public function test_returns_422_when_updating_location_without_data(): void
    {
        $location = $this->createLocation();

        $this->putJson("/api/locations/{$location->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.location.0', 'Minimal satu data lokasi harus dikirim.');
    }

    public function test_returns_422_when_deleting_location_with_schedules(): void
    {
        $location = $this->createLocation();
        $program = Program::create(['name' => 'Program Uji']);
        Schedule::create([
            'program_id' => $program->id,
            'location_id' => $location->id,
            'day_of_week' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '09:00',
        ]);

        $this->deleteJson("/api/locations/{$location->id}")
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Lokasi masih digunakan oleh jadwal. Hapus atau pindahkan jadwal terlebih dahulu.');

        $this->assertModelExists($location);
    }

    public function test_returns_404_when_location_does_not_exist(): void
    {
        $this->getJson('/api/locations/999')
            ->assertNotFound();
    }

    private function createLocation(): Location
    {
        return Location::create([
            'name' => 'Studio Utama',
            'address' => 'Jalan Melati 1',
            'description' => 'Ruang latihan utama',
            'google_maps_url' => 'https://maps.example.test/studio-utama',
        ]);
    }
}
