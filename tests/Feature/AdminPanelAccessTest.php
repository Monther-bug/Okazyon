<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Run specific seeders needed for permissions
        $this->seed(RoleSeeder::class);
    }

    public function test_admin_can_access_admin_panel()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_seller_cannot_access_admin_panel()
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $seller->assignRole('seller');

        $response = $this->actingAs($seller)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_buyer_cannot_access_admin_panel()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $buyer->assignRole('user');

        $response = $this->actingAs($buyer)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}
