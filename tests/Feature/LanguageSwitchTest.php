<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageSwitchTest extends TestCase
{
    use RefreshDatabase;

    private function useEnglish(): void
    {
        $this->get(route('language.switch', 'en'))
            ->assertRedirect()
            ->assertSessionHas('locale', 'en');
    }

    public function test_language_switch_translates_public_pages(): void
    {
        config()->set('forms.registration_url', null);
        config()->set('forms.booking_url', null);

        $this->useEnglish();

        $this->get('/')
            ->assertOk()
            ->assertSee('Home')
            ->assertSee('Register')
            ->assertSee('Book an Event')
            ->assertDontSee('Beranda');

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Programs &amp; Activities', false)
            ->assertSee('Education Space &amp; Workshop', false)
            ->assertSee('Village Tour')
            ->assertDontSee('ui.');

        $this->get(route('pendaftaran.index'))
            ->assertOk()
            ->assertSee('Registration form not available yet')
            ->assertSee('Contact the team')
            ->assertDontSee('ui.');

        $this->get(route('booking'))
            ->assertOk()
            ->assertSee('Form not available yet')
            ->assertSee('Contact the team')
            ->assertDontSee('ui.');

        $this->get(route('galeri'))
            ->assertOk()
            ->assertSee('Practice schedule')
            ->assertSee('Advanced Karawitan')
            ->assertDontSee('ui.');

        $this->get(route('lokasi'))
            ->assertOk()
            ->assertSee('Find us')
            ->assertSee('Sanggar Cakra Aji Beji')
            ->assertSee('Get directions')
            ->assertDontSee('ui.');

        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('Let\'s talk,')
            ->assertSee('Studio Team')
            ->assertSee('Event booking')
            ->assertDontSee('ui.');

        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('FREQUENTLY ASKED QUESTIONS')
            ->assertSee('Cakra Aji Assistant')
            ->assertSee('How do I register as a student?')
            ->assertDontSee('ui.');

        $this->get(route('murid.index'))
            ->assertOk()
            ->assertSee('Studio Students')
            ->assertSee('No active students yet.')
            ->assertDontSee('ui.');

        $this->get('/tentang-kami')
            ->assertOk()
            ->assertSee('ABOUT US')
            ->assertDontSee('ui.');
    }

    public function test_english_program_content_uses_database_translations(): void
    {
        Program::create([
            'name' => 'Ruang Edukasi & Workshop',
            'name_en' => 'Education Space & Workshop',
            'schedule' => 'Rabu & Minggu',
            'schedule_en' => 'Wednesday & Sunday',
            'description' => 'Kelas karawitan terstruktur.',
            'description_en' => 'Structured karawitan classes.',
            'is_active' => true,
        ]);

        $this->useEnglish();

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Education Space &amp; Workshop', false)
            ->assertSee('Structured karawitan classes.')
            ->assertSee('Wednesday &amp; Sunday', false)
            ->assertDontSee('Kelas karawitan terstruktur.');

        $this->get(route('program.detail', ['slug' => 'ruang-edukasi-workshop']))
            ->assertOk()
            ->assertSee('Education Space &amp; Workshop', false)
            ->assertSee('Structured karawitan classes.')
            ->assertDontSee('Kelas karawitan terstruktur.');
    }

    public function test_english_program_content_falls_back_to_indonesian_when_translation_is_empty(): void
    {
        Program::create([
            'name' => 'Kreteg',
            'schedule' => 'Minggu',
            'description' => 'Program kidung dan olah vokal untuk anak.',
            'is_active' => true,
        ]);

        $this->useEnglish();

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Kreteg')
            ->assertSee('Program kidung dan olah vokal untuk anak.');
    }

    public function test_faq_chat_data_is_localized(): void
    {
        $this->useEnglish();

        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('faq-chat-data', false)
            ->assertSee('Sorry, that question is not yet available in the FAQ information.', false)
            ->assertSee('"keywords"', false)
            ->assertSee('register', false)
            ->assertDontSee('Maaf, pertanyaan tersebut belum tersedia', false);
    }
}
