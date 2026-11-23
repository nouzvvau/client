<?php

namespace Tests\Feature;

use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_page_renders_the_form(): void
    {
        $this->get(route('kritik-saran'))
            ->assertOk()
            ->assertSee(__('ui.feedback.form_title'))
            ->assertSee(__('ui.feedback.submit_button'))
            ->assertSee('name="subject"', false)
            ->assertSee('name="message"', false)
            ->assertSee('name="message_type"', false)
            ->assertSee(route('kritik-saran.store'), false);
    }

    public function test_valid_feedback_is_stored_and_success_is_shown(): void
    {
        $response = $this->post(route('kritik-saran.store'), [
            'name' => 'Budi Santoso',
            'sender_type' => 'murid',
            'message_type' => 'saran',
            'subject' => 'Tambah jam latihan malam',
            'message' => 'Mohon tambahkan sesi latihan malam untuk kelas karawitan.',
            'reply_contact' => '081234567890',
        ]);

        $response
            ->assertRedirect(route('kritik-saran'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('feedbacks', [
            'name' => 'Budi Santoso',
            'sender_type' => 'murid',
            'message_type' => 'saran',
            'subject' => 'Tambah jam latihan malam',
            'message' => 'Mohon tambahkan sesi latihan malam untuk kelas karawitan.',
            'reply_contact' => '081234567890',
            'is_read' => false,
        ]);

        $this->get(route('kritik-saran'))
            ->assertOk()
            ->assertSee(__('ui.feedback.success_message'));
    }

    public function test_invalid_feedback_is_rejected_and_errors_are_shown(): void
    {
        $this->from(route('kritik-saran'))
            ->post(route('kritik-saran.store'), [
                'message_type' => 'bukan-jenis',
                'subject' => '',
                'message' => '',
            ])
            ->assertRedirect(route('kritik-saran'))
            ->assertSessionHasErrors(['message_type', 'subject', 'message']);

        $this->assertDatabaseCount('feedbacks', 0);

        $this->get(route('kritik-saran'))
            ->assertOk()
            ->assertSee(__('ui.feedback.errors_title'))
            ->assertSee(__('ui.feedback.validation.required', ['field' => __('ui.feedback.field_subject')]));
    }

    public function test_faq_page_links_to_the_feedback_page(): void
    {
        $this->get(route('faq'))
            ->assertOk()
            ->assertSee(route('kritik-saran'), false)
            ->assertSee(__('ui.faq.feedback_button'));
    }
}
