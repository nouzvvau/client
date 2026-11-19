<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExternalFormsAndLocaleTest extends TestCase
{
    public function test_form_links_fall_back_to_internal_pages_without_google_form_urls(): void
    {
        config()->set('forms.registration_url', null);
        config()->set('forms.booking_url', null);

        $this->get('/')
            ->assertOk()
            ->assertSee(route('pendaftaran.index'), false)
            ->assertSee(route('booking'), false);

        $this->get(route('pendaftaran.index'))
            ->assertOk()
            ->assertSee('action="'.route('pendaftaran.store').'"', false);

        $this->get(route('booking'))
            ->assertOk()
            ->assertSee('action="'.route('booking.store').'"', false);
    }

    public function test_invalid_external_form_urls_fall_back_to_internal_pages(): void
    {
        config()->set('forms.registration_url', 'javascript:alert(1)');
        config()->set('forms.booking_url', 'bukan-url');

        $this->get('/')
            ->assertOk()
            ->assertSee(route('pendaftaran.index'), false)
            ->assertSee(route('booking'), false)
            ->assertDontSee('javascript:alert(1)', false);
    }

    public function test_form_links_and_pages_use_google_forms_when_configured(): void
    {
        $registrationUrl = 'https://docs.google.com/forms/d/e/pendaftaran-test/viewform';
        $bookingUrl = 'https://docs.google.com/forms/d/e/booking-test/viewform';

        config()->set('forms.registration_url', $registrationUrl);
        config()->set('forms.booking_url', $bookingUrl);

        $this->get('/')
            ->assertOk()
            ->assertSee($registrationUrl, false)
            ->assertSee($bookingUrl, false)
            ->assertDontSee(route('pendaftaran.index'), false);

        $this->get(route('pendaftaran.index'))
            ->assertOk()
            ->assertSee($registrationUrl, false)
            ->assertSee('Buka formulir pendaftaran')
            ->assertDontSee('action="'.route('pendaftaran.store').'"', false);

        $this->get(route('booking'))
            ->assertOk()
            ->assertSee($bookingUrl, false)
            ->assertSee('Buka formulir booking')
            ->assertDontSee('action="'.route('booking.store').'"', false);
    }

    public function test_language_switch_persists_locale_and_translates_shared_ui(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('lang="id"', false)
            ->assertSee('Beranda');

        $this->get(route('language.switch', 'en'))
            ->assertRedirect()
            ->assertSessionHas('locale', 'en');

        $this->get('/')
            ->assertOk()
            ->assertSee('lang="en"', false)
            ->assertSee('Home')
            ->assertSee('Register')
            ->assertDontSee('Beranda');
    }

    public function test_unsupported_locale_is_rejected(): void
    {
        $this->get(route('language.switch', 'fr'))->assertNotFound();
    }

    public function test_public_layout_loads_design_system_and_mobile_navigation_script(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('assets/css/design-system.css', false)
            ->assertSee('assets/js/script2.js', false);
    }

    public function test_faq_loads_the_plain_faq_asset_instead_of_vite(): void
    {
        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('assets/js/tanya-jawab.js', false)
            ->assertDontSee('/build/assets/', false);
    }
}
