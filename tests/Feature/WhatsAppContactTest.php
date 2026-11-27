<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsAppContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_builds_whatsapp_link_from_admin_settings(): void
    {
        Setting::setMany([
            'whatsapp_number' => '0812-3456-7890',
            'whatsapp_message' => 'Halo Cakra Aji & tim',
            'whatsapp_cta_label' => 'Chat Admin',
        ]);

        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('https://wa.me/6281234567890?text=Halo%20Cakra%20Aji%20%26%20tim', false)
            ->assertSee('Chat Admin')
            ->assertSee('target="_blank"', false);
    }

    public function test_contact_page_hides_whatsapp_button_when_number_is_not_configured(): void
    {
        config()->set('whatsapp.number', null);
        config()->set('whatsapp.message', '');
        config()->set('whatsapp.cta_label', '');

        $this->get(route('kontak'))
            ->assertOk()
            ->assertDontSee('wa.me', false)
            ->assertDontSee('Hubungi via WhatsApp')
            ->assertSee('Pengurus Sanggar');
    }

    public function test_faq_contact_button_links_to_whatsapp_from_admin_settings(): void
    {
        Setting::setMany([
            'whatsapp_number' => '0812-3456-7890',
            'whatsapp_message' => 'Halo dari FAQ',
        ]);

        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('https://wa.me/6281234567890?text=Halo%20dari%20FAQ', false)
            ->assertSee(__('ui.faq.contact_button'));
    }

    public function test_faq_contact_button_falls_back_to_contact_page_without_whatsapp(): void
    {
        config()->set('whatsapp.number', null);

        $this->get(route('faq'))
            ->assertOk()
            ->assertSee(route('kontak'), false)
            ->assertDontSee('wa.me', false);
    }
}
