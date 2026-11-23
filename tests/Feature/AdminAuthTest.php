<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_for_admin_pages(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.nama-murid'))->assertRedirect(route('login'));
        $this->get(route('admin.program.index'))->assertRedirect(route('login'));
    }

    public function test_login_page_is_accessible(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk Admin');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $this->post(route('login.proses'), [
            'email' => 'admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_non_admin_user_cannot_login_to_admin_panel(): void
    {
        User::factory()->create([
            'email' => 'bukan-admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ]);

        $this->from(route('login'))->post(route('login.proses'), [
            'email' => 'bukan-admin@cakraaji.test',
            'password' => 'rahasia-admin',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_admin_can_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.nama-murid'))->assertOk();
        $this->get(route('admin.program.index'))->assertOk();
    }

    public function test_authenticated_admin_can_logout(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->post(route('logout'))->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
