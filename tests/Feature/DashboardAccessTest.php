<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_admin_can_access_chat()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get(route('chat.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Messages');
    }

    public function test_doctor_can_access_dashboard()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        
        $response = $this->actingAs($doctor)->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_doctor_can_access_chat()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        
        $response = $this->actingAs($doctor)->get(route('chat.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Messages');
    }

    public function test_doctor_cannot_access_admin_only_routes()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        
        // admin.doctors.index
        $response = $this->actingAs($doctor)->get(route('admin.doctors.index'));
        
        $response->assertStatus(403);
    }

    public function test_patient_cannot_access_dashboard()
    {
        $patient = User::factory()->create(['role' => 'patient']);
        
        $response = $this->actingAs($patient)->get('/');
        
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/');
        
        $response->assertRedirect(route('show-login'));
    }

    public function test_doctor_can_login_to_dashboard()
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login-dash'), [
            'email' => $doctor->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($doctor);
    }
}
