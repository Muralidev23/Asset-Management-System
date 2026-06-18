<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'emp_id' => 'EMP-TEST-99',
            'department' => 'Test Department',
            'designation' => 'Test Designation',
            'emp_role' => 'Test Role',
            'doj' => '2026-06-18',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('employee.dashboard'));
    }
}
