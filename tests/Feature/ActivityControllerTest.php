<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\ActivityPhoto;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_activities_with_their_photos(): void
    {
        $olderActivity = Activity::create(['title' => 'Aktivitas Lama']);
        $olderActivity->forceFill(['created_at' => now()->subDay()])->save();
        $activity = Activity::create(['title' => 'Aktivitas Baru']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/first.jpg']);

        $this->getJson('/api/activities')
            ->assertOk()
            ->assertJsonPath('0.id', $activity->id)
            ->assertJsonPath('0.photos.0.id', $photo->id)
            ->assertJsonPath('1.id', $olderActivity->id);
    }

    public function test_valid_payload_creates_activity_and_returns_201(): void
    {
        $this->postJson('/api/activities', [
            'title' => 'Pentas Seni',
            'description' => 'Pentas seni tahunan',
            'date' => '2026-08-17',
        ])
            ->assertCreated()
            ->assertJsonPath('data.title', 'Pentas Seni')
            ->assertJsonPath('data.photos', []);

        $this->assertDatabaseHas('activities', [
            'title' => 'Pentas Seni',
            'description' => 'Pentas seni tahunan',
        ]);
        $this->assertSame('2026-08-17', Activity::first()->date->toDateString());
    }

    public function test_show_returns_activity_with_its_photos(): void
    {
        $activity = Activity::create(['title' => 'Latihan Rutin']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/latihan.jpg']);

        $this->getJson("/api/activities/{$activity->id}")
            ->assertOk()
            ->assertJsonPath('id', $activity->id)
            ->assertJsonPath('photos.0.id', $photo->id);
    }

    public function test_valid_payload_updates_activity_and_returns_200(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->putJson("/api/activities/{$activity->id}", [
            'title' => 'Pentas Seni Baru',
            'date' => '2026-09-01',
        ])
            ->assertOk()
            ->assertJsonPath('data.title', 'Pentas Seni Baru');

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Pentas Seni Baru',
        ]);
        $this->assertSame('2026-09-01', $activity->refresh()->date->toDateString());
    }

    public function test_destroy_removes_activity_its_photos_and_their_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('activities/keep-me.jpg', 'photo');
        $activity = Activity::create(['title' => 'Pentas Seni']);
        $photo = $this->createPhoto($activity, ['photo' => 'activities/keep-me.jpg']);

        $this->deleteJson("/api/activities/{$activity->id}")
            ->assertOk();

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
        $this->assertDatabaseMissing('activity_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing('activities/keep-me.jpg');
    }

    public function test_returns_422_when_creating_activity_with_missing_required_data(): void
    {
        $this->postJson('/api/activities', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title']);
    }

    public function test_returns_422_when_creating_activity_with_invalid_column_values(): void
    {
        $this->postJson('/api/activities', [
            'title' => str_repeat('a', 256),
            'description' => ['invalid'],
            'date' => 'bukan-tanggal',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'title',
                'description',
                'date',
            ]);
    }

    public function test_returns_422_when_updating_activity_without_data(): void
    {
        $activity = Activity::create(['title' => 'Pentas Seni']);

        $this->putJson("/api/activities/{$activity->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.activity.0', 'Minimal satu data aktivitas harus dikirim.');
    }

    public function test_returns_404_when_activity_does_not_exist(): void
    {
        $this->getJson('/api/activities/999')
            ->assertNotFound();
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
