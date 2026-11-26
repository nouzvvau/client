<?php

namespace Tests\Feature;

use App\Models\EventDocumentationPhoto;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProgramDocumentationPhotoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_admin_can_upload_documentation_photos_when_creating_program(): void
    {
        Storage::fake('public');

        $this->post(route('admin.program.store'), [
            'name' => 'Program Fotogenik',
            'is_active' => '1',
            'photos' => [
                UploadedFile::fake()->image('satu.jpg'),
                UploadedFile::fake()->image('dua.png'),
            ],
        ])->assertSessionHasNoErrors()->assertRedirect();

        $program = Program::query()->where('name', 'Program Fotogenik')->firstOrFail();

        $this->assertSame('Program Fotogenik', $program->documentations()->first()->title);

        $photos = EventDocumentationPhoto::query()
            ->whereIn('event_documentation_id', $program->documentations()->pluck('id'))
            ->get();

        $this->assertCount(2, $photos);

        Storage::disk('public')->assertExists($photos->first()->photo);
    }

    public function test_program_form_rejects_more_than_five_photos(): void
    {
        $this->post(route('admin.program.store'), [
            'name' => 'Program Foto Banyak',
            'is_active' => '1',
            'photos' => [
                UploadedFile::fake()->image('1.jpg'),
                UploadedFile::fake()->image('2.jpg'),
                UploadedFile::fake()->image('3.jpg'),
                UploadedFile::fake()->image('4.jpg'),
                UploadedFile::fake()->image('5.jpg'),
                UploadedFile::fake()->image('6.jpg'),
            ],
        ])->assertSessionHasErrors('photos');

        $this->assertDatabaseMissing('programs', ['name' => 'Program Foto Banyak']);
    }

    public function test_program_edit_rejects_photos_over_slot_limit(): void
    {
        Storage::fake('public');

        $program = Program::create(['name' => 'Program Penuh', 'is_active' => true]);
        $documentation = $program->documentations()->create(['title' => $program->name]);

        foreach (range(1, 4) as $index) {
            $documentation->photos()->create([
                'photo' => UploadedFile::fake()->image($index.'.jpg')->store('event-documentation', 'public'),
            ]);
        }

        $this->post(route('admin.program.documentation-photos', $program), [
            'photos' => [
                UploadedFile::fake()->image('baru-1.jpg'),
                UploadedFile::fake()->image('baru-2.jpg'),
            ],
        ])->assertSessionHasErrors('photos');

        $this->assertSame(4, $documentation->photos()->count());
    }

    public function test_admin_can_remove_documentation_photo_from_program(): void
    {
        Storage::fake('public');

        $program = Program::create(['name' => 'Program Bersih', 'is_active' => true]);
        $documentation = $program->documentations()->create(['title' => $program->name]);
        $path = UploadedFile::fake()->image('lama.jpg')->store('event-documentation', 'public');
        $photo = $documentation->photos()->create(['photo' => $path]);

        $this->post(route('admin.program.documentation-photos', $program), [
            'remove_photos' => [$photo->id],
        ])->assertRedirect(route('admin.program.edit', $program));

        $this->assertDatabaseMissing('event_documentation_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_program_detail_page_shows_documentation_photos(): void
    {
        Storage::fake('public');

        $program = Program::create(['name' => 'Program Galeri', 'is_active' => true]);
        $documentation = $program->documentations()->create(['title' => $program->name]);
        $documentation->photos()->create([
            'photo' => UploadedFile::fake()->image('dokumentasi.jpg')->store('event-documentation', 'public'),
            'caption' => 'Momen pentas',
        ]);

        $this->get(route('program.detail', ['slug' => $program->slug]))
            ->assertOk()
            ->assertSee('activity-gallery')
            ->assertSee('Momen pentas')
            ->assertSee('event-documentation', false);
    }

    public function test_program_forms_expose_documentation_photo_fields(): void
    {
        $program = Program::create(['name' => 'Program Formulir', 'is_active' => true]);
        $documentation = $program->documentations()->create(['title' => $program->name]);
        $documentation->photos()->create(['photo' => 'event-documentation/sudah-ada.jpg']);

        $this->get(route('admin.program.index'))
            ->assertOk()
            ->assertSee('name="photos[]"', false)
            ->assertSee('Maksimal 5 foto dokumentasi', false);

        $this->get(route('admin.program.edit', $program))
            ->assertOk()
            ->assertSee('Foto dokumentasi')
            ->assertSee('1/5', false)
            ->assertSee(route('admin.program.documentation-photos', $program), false)
            ->assertSee('remove_photos[]', false)
            ->assertSee('event-documentation/sudah-ada.jpg', false);
    }

    public function test_program_detail_page_without_photos_has_no_gallery_grid(): void
    {
        $program = Program::create(['name' => 'Program Tanpa Foto', 'is_active' => true]);

        $this->get(route('program.detail', ['slug' => $program->slug]))
            ->assertOk()
            ->assertDontSee('activity-gallery');
    }
}
