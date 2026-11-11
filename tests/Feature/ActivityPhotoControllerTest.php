<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\ActivityPhoto;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActivityPhotoControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_multiple_photos_can_be_uploaded_with_captions(): void
    {
        Storage::fake('public');
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $response = $this->post("/api/activities/{$activity->id}/photos", [
            'photos' => [
                UploadedFile::fake()->image('satu.jpg'),
                UploadedFile::fake()->image('dua.jpg'),
            ],
            'captions' => ['Pembukaan', null],
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.caption', 'Pembukaan')
            ->assertJsonPath('data.1.caption', null);

        $paths = $response->json('data.*.photo');

        foreach ($paths as $path) {
            $this->assertStringStartsWith('activities/', $path);
            Storage::disk('public')->assertExists($path);
        }

        $this->assertDatabaseCount('activity_photos', 2);
        $this->assertDatabaseHas('activity_photos', [
            'activity_id' => $activity->id,
            'caption' => 'Pembukaan',
        ]);
    }

    public function test_photo_caption_can_be_updated(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('activities/old.jpg', 'photo');
        $activity = Activity::create(['title' => 'Pentas Seni']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/old.jpg']);

        $this->putJson("/api/activities/{$activity->id}/photos/{$photo->id}", [
            'caption' => 'Caption baru',
        ])
            ->assertOk()
            ->assertJsonPath('data.caption', 'Caption baru');

        Storage::disk('public')->assertExists('activities/old.jpg');
        $this->assertDatabaseHas('activity_photos', [
            'id' => $photo->id,
            'caption' => 'Caption baru',
        ]);
    }

    public function test_replacing_photo_file_removes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('activities/old.jpg', 'photo');
        $activity = Activity::create(['title' => 'Pentas Seni']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/old.jpg']);

        $response = $this->put("/api/activities/{$activity->id}/photos/{$photo->id}", [
            'photo' => UploadedFile::fake()->image('baru.jpg'),
            'caption' => 'Foto baru',
        ], ['Accept' => 'application/json']);

        $response->assertOk();

        $newPath = $response->json('data.photo');

        Storage::disk('public')->assertMissing('activities/old.jpg');
        Storage::disk('public')->assertExists($newPath);
        $this->assertDatabaseHas('activity_photos', [
            'id' => $photo->id,
            'photo' => $newPath,
        ]);
    }

    public function test_destroy_removes_photo_row_and_its_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('activities/hapus.jpg', 'photo');
        $activity = Activity::create(['title' => 'Pentas Seni']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/hapus.jpg']);

        $this->deleteJson("/api/activities/{$activity->id}/photos/{$photo->id}")
            ->assertOk();

        $this->assertDatabaseMissing('activity_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing('activities/hapus.jpg');
    }

    public function test_returns_422_when_uploading_without_photos(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->postJson("/api/activities/{$activity->id}/photos", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['photos']);
    }

    public function test_returns_422_when_uploading_non_image_photos(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->post("/api/activities/{$activity->id}/photos", [
            'photos' => [
                UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
            ],
        ], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['photos.0']);

        $this->assertDatabaseCount('activity_photos', 0);
    }

    public function test_returns_422_when_updating_photo_without_data(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);
        $photo = $this->createPhoto($activity);

        $this->putJson("/api/activities/{$activity->id}/photos/{$photo->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.activity_photo.0', 'Minimal satu data foto aktivitas harus dikirim.');
    }

    public function test_returns_404_when_activity_does_not_exist(): void
    {
        $this->postJson('/api/activities/999/photos', [
            'photos' => [UploadedFile::fake()->image('satu.jpg')],
        ])->assertNotFound();
    }

    public function test_returns_404_when_photo_does_not_exist(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->deleteJson("/api/activities/{$activity->id}/photos/999")
            ->assertNotFound();
    }

    public function test_returns_404_when_photo_belongs_to_another_activity(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('activities/milik-lain.jpg', 'photo');
        $otherActivity = Activity::create(['title' => 'Aktivitas Lain']);
        $photo = $this->createPhoto($otherActivity, ['photo' => 'activities/milik-lain.jpg']);
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->deleteJson("/api/activities/{$activity->id}/photos/{$photo->id}")
            ->assertNotFound()
            ->assertJsonPath('message', 'Foto tidak ditemukan pada aktivitas ini.');

        $this->assertDatabaseHas('activity_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertExists('activities/milik-lain.jpg');
    }

    private function createPhoto(Activity $activity, array $attributes = []): ActivityPhoto
    {
        return ActivityPhoto::create([
            'activity_id' => $activity->id,
            'photo' => 'activities/photo.jpg',
            ...$attributes,
        ]);
    }
}
