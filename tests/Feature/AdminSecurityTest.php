<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    // ===== SEC-001: API admin tidak bisa diakses tanpa autentikasi =====

    public function test_guest_cannot_read_admin_api_endpoints(): void
    {
        $this->getJson('/api/activities')->assertUnauthorized();
        $this->getJson('/api/bookings')->assertUnauthorized();
        $this->getJson('/api/locations')->assertUnauthorized();
        $this->getJson('/api/programs')->assertUnauthorized();
        $this->getJson('/api/registrations')->assertUnauthorized();
        $this->getJson('/api/schedules')->assertUnauthorized();
        $this->getJson('/api/staffs')->assertUnauthorized();
        $this->getJson('/api/students')->assertUnauthorized();
    }

    public function test_guest_cannot_create_data_via_admin_api(): void
    {
        $this->postJson('/api/students', ['full_name' => 'Murid Ilegal'])
            ->assertUnauthorized();

        $this->assertDatabaseMissing('students', [
            'full_name' => 'Murid Ilegal',
        ]);

        $this->postJson('/api/registrations', [
            'full_name' => 'Pendaftar Ilegal',
            'birth_date' => '2015-01-01',
            'guardian_name' => 'Wali Ilegal',
            'contact_phone' => '08111111111',
            'program_id' => 1,
        ])->assertUnauthorized();

        $this->assertDatabaseMissing('registrations', [
            'full_name' => 'Pendaftar Ilegal',
        ]);
    }

    public function test_guest_cannot_update_or_delete_data_via_admin_api(): void
    {
        $student = Student::create(['full_name' => 'Murid Asli']);

        $this->putJson("/api/students/{$student->id}", ['full_name' => 'Diubah Tamu'])
            ->assertUnauthorized();
        $this->deleteJson("/api/students/{$student->id}")
            ->assertUnauthorized();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'full_name' => 'Murid Asli',
        ]);
    }

    public function test_authenticated_user_can_use_admin_api(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->getJson('/api/students')->assertOk();

        $this->postJson('/api/students', [
            'full_name' => 'Murid Admin',
        ])->assertCreated();

        $this->assertDatabaseHas('students', [
            'full_name' => 'Murid Admin',
        ]);
    }

    // ===== SEC-002: Data pribadi tidak bocor ke halaman publik =====

    public function test_public_murid_page_does_not_expose_private_data(): void
    {
        $program = Program::create(['name' => 'Tari']);

        $student = Student::create([
            'full_name' => 'Ananda Rahasia',
            'guardian_name' => 'Wali Sangat Privat',
            'contact_phone' => '081234567890',
            'address' => 'Alamat Rumah Privat',
        ]);
        $student->programs()->attach($program->id, ['status' => 'active']);

        $response = $this->get(route('murid.index'));
        $response->assertOk();
        $response->assertSee('Ananda Rahasia');
        $response->assertDontSee('Wali Sangat Privat');
        $response->assertDontSee('081234567890');
        $response->assertDontSee('Alamat Rumah Privat');
    }

    public function test_public_pages_remain_accessible_for_visitors(): void
    {
        $this->get('/')->assertOk();
        $this->get(route('murid.index'))->assertOk();
        $this->get(route('pendaftaran.index'))->assertOk();

        $this->post(route('pendaftaran.store'), [
            'nama_murid' => 'Calon Murid',
            'tanggal_lahir' => '2015-01-01',
            'nama_wali' => 'Wali Calon Murid',
            'whatsapp' => '081298765432',
            'program' => 'Tari',
            'pengalaman' => 'Belum pernah',
        ])->assertRedirect(route('pendaftaran.index'));

        $this->assertDatabaseHas('pendaftaran_murids', [
            'nama_murid' => 'Calon Murid',
            'status' => 'Menunggu',
        ]);
    }

    // ===== SEC-003: Halaman admin, login, dan logout =====

    public function test_guest_is_redirected_to_login_for_admin_pages(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.galeri'))->assertRedirect(route('login'));
        $this->get(route('admin.galeri.create'))->assertRedirect(route('login'));
    }

    public function test_login_page_is_accessible_and_shows_login_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk Admin');
    }

    public function test_login_fails_with_wrong_credentials(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $response = $this->from(route('login'))->post(route('login.proses'), [
            'email' => 'admin@cakraaji.test',
            'password' => 'password-salah',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_succeeds_with_valid_credentials(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $response = $this->post(route('login.proses'), [
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_is_rate_limited(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post(route('login.proses'), [
                'email' => 'admin@cakraaji.test',
                'password' => 'password-salah',
            ]);
        }

        $response = $this->post(route('login.proses'), [
            'email' => 'admin@cakraaji.test',
            'password' => 'password-salah',
        ]);

        $response->assertStatus(429);
    }

    public function test_logout_requires_authentication(): void
    {
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.galeri'))->assertOk();
        $this->get(route('admin.galeri.create'))->assertOk();
    }

    public function test_admin_dashboard_route_exists_and_is_unique(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/admin/dashboard')->assertOk();
    }

    // ===== SEC-004: hanya akun admin yang boleh masuk panel =====

    public function test_non_admin_user_cannot_login_to_admin_panel(): void
    {
        User::factory()->create([
            'email' => 'bukan-admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $response = $this->from(route('login'))->post(route('login.proses'), [
            'email' => 'bukan-admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('admin.galeri'))->assertForbidden();
        $this->get(route('admin.nama-murid'))->assertForbidden();
    }

    public function test_non_admin_user_cannot_access_admin_api(): void
    {
        $this->actingAs(User::factory()->create());

        $this->getJson('/api/students')->assertForbidden();
        $this->postJson('/api/students', ['full_name' => 'Murid Non Admin'])
            ->assertForbidden();

        $this->assertDatabaseMissing('students', [
            'full_name' => 'Murid Non Admin',
        ]);
    }

    // ===== SEC-005: Keamanan fitur hapus booking =====

    public function test_admin_can_delete_booking(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $booking = Booking::create([
            'name' => 'Booking Testing',
            'phone' => '081234567890',
            'institution_name' => 'Testing',
            'service_type' => 'Testing',
            'event_name' => 'Acara Testing',
            'event_date' => now()->addDays(7)->toDateString(),
            'start_time' => '09:00:00',
            'event_location' => 'Lokasi Testing',
            'estimated_audience' => 10,
            'additional_notes' => 'Data untuk pengujian.',
            'status' => 'pending',
            'created_at' => now(),
        ]);

        $response = $this->delete(route('admin.booking.destroy', $booking));

        $response->assertRedirect(route('admin.booking'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }

    public function test_guest_cannot_delete_booking(): void
    {
        $booking = Booking::create([
            'name' => 'Booking Testing',
            'phone' => '081234567890',
            'institution_name' => 'Testing',
            'service_type' => 'Testing',
            'event_name' => 'Acara Testing',
            'event_date' => now()->addDays(7)->toDateString(),
            'start_time' => '09:00:00',
            'event_location' => 'Lokasi Testing',
            'estimated_audience' => 10,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        $this->delete(route('admin.booking.destroy', $booking))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
        ]);
    }

    public function test_non_admin_user_cannot_delete_booking(): void
    {
        $booking = Booking::create([
            'name' => 'Booking Testing',
            'phone' => '081234567890',
            'institution_name' => 'Testing',
            'service_type' => 'Testing',
            'event_name' => 'Acara Testing',
            'event_date' => now()->addDays(7)->toDateString(),
            'start_time' => '09:00:00',
            'event_location' => 'Lokasi Testing',
            'estimated_audience' => 10,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        $this->actingAs(User::factory()->create());

        $this->delete(route('admin.booking.destroy', $booking))
            ->assertForbidden();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
        ]);
    }

    public function test_admin_cannot_delete_nonexistent_booking(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->delete(route('admin.booking.destroy', 999999))
            ->assertNotFound();
    }
}
