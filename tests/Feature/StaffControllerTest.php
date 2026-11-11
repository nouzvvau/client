<?php

namespace Tests\Feature;

use App\Models\Staff;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StaffControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_staff_in_sort_order(): void
    {
        $laterStaff = Staff::create([
            'name' => 'Staf Kedua',
            'position' => 'Pelatih Musik',
            'sort_order' => 2,
        ]);
        $firstStaff = Staff::create([
            'name' => 'Staf Pertama',
            'position' => 'Pelatih Tari',
            'sort_order' => 1,
        ]);

        $this->getJson('/api/staffs')
            ->assertOk()
            ->assertJsonPath('0.id', $firstStaff->id)
            ->assertJsonPath('1.id', $laterStaff->id);
    }

    public function test_valid_payload_creates_staff_with_photo_and_returns_201(): void
    {
        Storage::fake('public');

        $response = $this->post('/api/staffs', [
            'name' => 'Ibu Rani',
            'position' => 'Pelatih Tari',
            'photo' => UploadedFile::fake()->image('rani.jpg'),
            'description' => 'Pelatih tari tradisional',
            'is_active' => false,
            'sort_order' => 3,
        ], ['Accept' => 'application/json']);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'Ibu Rani')
            ->assertJsonPath('data.is_active', false)
            ->assertJsonPath('data.sort_order', 3);

        $photoPath = $response->json('data.photo');

        $this->assertStringStartsWith('staff/', $photoPath);
        Storage::disk('public')->assertExists($photoPath);
        $this->assertDatabaseHas('staff', [
            'name' => 'Ibu Rani',
            'position' => 'Pelatih Tari',
            'photo' => $photoPath,
            'description' => 'Pelatih tari tradisional',
            'is_active' => false,
            'sort_order' => 3,
        ]);
    }

    public function test_show_returns_staff(): void
    {
        $staff = $this->createStaff();

        $this->getJson("/api/staffs/{$staff->id}")
            ->assertOk()
            ->assertJsonPath('id', $staff->id)
            ->assertJsonPath('position', 'Pelatih Tari');
    }

    public function test_valid_payload_updates_staff_and_returns_200(): void
    {
        $staff = $this->createStaff();

        $this->putJson("/api/staffs/{$staff->id}", [
            'position' => 'Koordinator Pelatih',
            'is_active' => false,
            'sort_order' => 4,
        ])
            ->assertOk()
            ->assertJsonPath('data.position', 'Koordinator Pelatih')
            ->assertJsonPath('data.is_active', false)
            ->assertJsonPath('data.sort_order', 4);

        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'position' => 'Koordinator Pelatih',
            'is_active' => false,
            'sort_order' => 4,
        ]);
    }

    public function test_replacing_staff_photo_removes_old_photo(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('staff/old-photo.jpg', 'photo');
        $staff = $this->createStaff(['photo' => 'staff/old-photo.jpg']);

        $response = $this->put("/api/staffs/{$staff->id}", [
            'photo' => UploadedFile::fake()->image('new-photo.jpg'),
        ], ['Accept' => 'application/json']);

        $response->assertOk();

        $photoPath = $response->json('data.photo');

        Storage::disk('public')->assertMissing('staff/old-photo.jpg');
        Storage::disk('public')->assertExists($photoPath);
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'photo' => $photoPath,
        ]);
    }

    public function test_removing_staff_photo_clears_its_path(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('staff/old-photo.jpg', 'photo');
        $staff = $this->createStaff(['photo' => 'staff/old-photo.jpg']);

        $this->putJson("/api/staffs/{$staff->id}", ['photo' => null])
            ->assertOk()
            ->assertJsonPath('data.photo', null);

        Storage::disk('public')->assertMissing('staff/old-photo.jpg');
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'photo' => null,
        ]);
    }

    public function test_destroy_removes_staff_and_its_photo_and_returns_200(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('staff/old-photo.jpg', 'photo');
        $staff = $this->createStaff(['photo' => 'staff/old-photo.jpg']);

        $this->deleteJson("/api/staffs/{$staff->id}")
            ->assertOk();

        $this->assertDatabaseMissing('staff', ['id' => $staff->id]);
        Storage::disk('public')->assertMissing('staff/old-photo.jpg');
    }

    public function test_returns_422_when_creating_staff_with_missing_required_data(): void
    {
        $this->postJson('/api/staffs', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'position',
            ]);
    }

    public function test_returns_422_when_creating_staff_with_invalid_column_values(): void
    {
        $this->post('/api/staffs', [
            'name' => str_repeat('a', 256),
            'position' => ['invalid'],
            'photo' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
            'description' => ['invalid'],
            'is_active' => 'aktif',
            'sort_order' => 'pertama',
        ], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'position',
                'photo',
                'description',
                'is_active',
                'sort_order',
            ]);
    }

    public function test_returns_422_when_updating_staff_without_data(): void
    {
        $staff = $this->createStaff();

        $this->putJson("/api/staffs/{$staff->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.staff.0', 'Minimal satu data staf harus dikirim.');
    }

    public function test_returns_404_when_staff_does_not_exist(): void
    {
        $this->getJson('/api/staffs/999')
            ->assertNotFound();
    }

    private function createStaff(array $attributes = []): Staff
    {
        return Staff::create([
            'name' => 'Pak Agus',
            'position' => 'Pelatih Tari',
            'description' => 'Pelatih tari tradisional',
            'sort_order' => 1,
            ...$attributes,
        ]);
    }
}
