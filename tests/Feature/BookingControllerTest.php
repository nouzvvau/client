<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_bookings(): void
    {
        $olderBooking = Booking::create(array_merge($this->basePayload(), ['name' => 'Booking Lama']));
        $olderBooking->forceFill(['created_at' => now()->subDay()])->save();
        $booking = Booking::create(array_merge($this->basePayload(), ['name' => 'Booking Baru']));

        $this->getJson('/api/bookings')
            ->assertOk()
            ->assertJsonPath('0.id', $booking->id)
            ->assertJsonPath('0.name', 'Booking Baru')
            ->assertJsonPath('1.id', $olderBooking->id);
    }

    public function test_valid_payload_creates_booking_and_returns_201(): void
    {
        $this->postJson('/api/bookings', $this->basePayload([
            'institution_name' => 'SD Negeri 1',
            'start_time' => '09:00',
            'estimated_audience' => 150,
            'additional_notes' => 'Butuh sound system',
        ]))
            ->assertCreated()
            ->assertJsonPath('data.name', 'Citra Lestari')
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.event_name', 'Pentas Seni Sekolah');

        $this->assertDatabaseHas('bookings', [
            'name' => 'Citra Lestari',
            'event_name' => 'Pentas Seni Sekolah',
            'status' => 'pending',
            'institution_name' => 'SD Negeri 1',
        ]);
    }

    public function test_show_returns_booking(): void
    {
        $booking = $this->createBooking();

        $this->getJson("/api/bookings/{$booking->id}")
            ->assertOk()
            ->assertJsonPath('id', $booking->id)
            ->assertJsonPath('event_name', 'Pentas Seni Sekolah');
    }

    public function test_valid_payload_updates_booking_and_returns_200(): void
    {
        $booking = $this->createBooking(['status' => 'pending']);

        $this->putJson("/api/bookings/{$booking->id}", [
            'status' => 'accepted',
            'event_date' => '2027-08-01',
            'estimated_audience' => 300,
        ])
            ->assertOk()
            ->assertJsonPath('data.status', 'accepted')
            ->assertJsonPath('data.estimated_audience', 300);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'accepted',
            'estimated_audience' => 300,
        ]);
    }

    public function test_destroy_removes_booking_and_returns_200(): void
    {
        $booking = $this->createBooking();

        $this->deleteJson("/api/bookings/{$booking->id}")
            ->assertOk();

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }

    public function test_returns_422_when_creating_booking_with_missing_required_data(): void
    {
        $this->postJson('/api/bookings', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'phone',
                'service_type',
                'event_name',
                'event_date',
                'event_location',
            ]);
    }

    public function test_returns_422_when_creating_booking_with_invalid_column_values(): void
    {
        $this->postJson('/api/bookings', [
            'name' => str_repeat('a', 256),
            'phone' => str_repeat('1', 256),
            'institution_name' => str_repeat('b', 256),
            'service_type' => str_repeat('c', 256),
            'event_name' => str_repeat('d', 256),
            'event_date' => 'bukan-tanggal',
            'start_time' => 'bukan-jam',
            'event_location' => ['invalid'],
            'estimated_audience' => 'seratus',
            'additional_notes' => ['invalid'],
            'status' => 'invalid',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'phone',
                'institution_name',
                'service_type',
                'event_name',
                'event_date',
                'start_time',
                'event_location',
                'estimated_audience',
                'additional_notes',
                'status',
            ]);
    }

    public function test_returns_422_when_updating_booking_without_data(): void
    {
        $booking = $this->createBooking();

        $this->putJson("/api/bookings/{$booking->id}", [])
            ->assertUnprocessable()
            ->assertJsonPath('errors.booking.0', 'Minimal satu data booking harus dikirim.');
    }

    public function test_returns_404_when_booking_does_not_exist(): void
    {
        $this->getJson('/api/bookings/999')
            ->assertNotFound();
    }

    /**
     * @return array<string, mixed>
     */
    private function basePayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Citra Lestari',
            'phone' => '081234567890',
            'service_type' => 'Panggung Seni',
            'event_name' => 'Pentas Seni Sekolah',
            'event_date' => '2027-07-01',
            'event_location' => 'Lapangan Sekolah',
        ], $overrides);
    }

    private function createBooking(array $attributes = []): Booking
    {
        return Booking::create([...$this->basePayload(), ...$attributes]);
    }
}
