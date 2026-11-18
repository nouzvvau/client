<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingPublicSubmissionTest extends TestCase
{
    use LazilyRefreshDatabase;
    use WithFaker;

    public function test_booking_page_renders_public_booking_form_for_guests(): void
    {
        $this->get(route('booking'))
            ->assertOk()
            ->assertSee(route('booking.store'))
            ->assertSee('Nama pemesan')
            ->assertSee('Undang Cakra Aji')
            ->assertSee('ke acaramu');
    }

    public function test_guest_can_submit_booking_without_login(): void
    {
        $response = $this->from(route('booking'))
            ->post(route('booking.store'), $this->validPayload());

        $response->assertRedirect(route('booking'));

        $this->assertDatabaseHas('bookings', [
            'name' => 'Budi Pemesan',
            'phone' => '081234567890',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas Sekolah',
            'status' => 'pending',
        ]);
    }

    public function test_booking_status_is_always_pending_regardless_of_visitor_input(): void
    {
        $this->post(route('booking.store'), $this->validPayload([
            'status' => 'accepted',
        ]));

        $this->assertDatabaseHas('bookings', [
            'name' => 'Budi Pemesan',
            'status' => 'pending',
        ]);

        $this->assertDatabaseMissing('bookings', [
            'name' => 'Budi Pemesan',
            'status' => 'accepted',
        ]);
    }

    public function test_guest_is_redirected_back_with_success_message_after_submitting(): void
    {
        $response = $this->followingRedirects()
            ->from(route('booking'))
            ->post(route('booking.store'), $this->validPayload());

        $response->assertOk()
            ->assertSee('Permintaan booking berhasil dikirim');
    }

    public function test_validation_fails_when_required_fields_are_missing(): void
    {
        $response = $this->from(route('booking'))
            ->post(route('booking.store'), []);

        $response->assertRedirect(route('booking'));
        $response->assertSessionHasErrors([
            'name',
            'phone',
            'service_type',
            'event_name',
            'event_date',
            'event_location',
        ]);

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_validation_fails_when_event_date_is_not_a_valid_date(): void
    {
        $response = $this->from(route('booking'))
            ->post(route('booking.store'), $this->validPayload([
                'event_date' => 'bukan-tanggal',
            ]));

        $response->assertRedirect(route('booking'));
        $response->assertSessionHasErrors('event_date');

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_booking_endpoint_is_rate_limited(): void
    {
        $payload = $this->validPayload();

        for ($i = 0; $i < 6; $i++) {
            $this->post(route('booking.store'), $payload);
        }

        $this->post(route('booking.store'), $payload)
            ->assertStatus(429);
    }

    /**
     * Payload dasar yang valid.
     *
     * @return array<string, string|int>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Budi Pemesan',
            'phone' => '081234567890',
            'institution_name' => 'SD Negeri 1 Tulungagung',
            'service_type' => 'Pentas Seni',
            'event_name' => 'Pentas Sekolah',
            'event_date' => '2027-01-20',
            'start_time' => '09:00',
            'event_location' => 'Aula SD Negeri 1 Tulungagung',
            'estimated_audience' => 150,
            'additional_notes' => 'Mohon siapkan sound system.',
        ], $overrides);
    }
}
