<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_login_creates_new_user()
    {
        // Mock Socialite User
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('123456789');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@gmail.com');
        $abstractUser->shouldReceive('getName')->andReturn('Test User');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://avatar.com/img.jpg');

        // Mock Socialite Facade
        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn(Mockery::self())
            ->shouldReceive('userFromToken')
            ->with('fake-token')
            ->andReturn($abstractUser);

        $response = $this->postJson('/api/v1/google-login', [
            'access_token' => 'fake-token',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'user', 'message']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
            'google_id' => '123456789',
        ]);
    }

    public function test_google_login_logs_in_existing_user()
    {
        // Create existing user
        $user = User::create([
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => 'existing@gmail.com',
            'phone_number' => null,
            'password' => bcrypt('password'),
            'google_id' => '987654321',
        ]);

        // Mock Socialite User
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('987654321');
        $abstractUser->shouldReceive('getEmail')->andReturn('existing@gmail.com');

        // Mock Socialite Facade
        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn(Mockery::self())
            ->shouldReceive('userFromToken')
            ->with('fake-token')
            ->andReturn($abstractUser);

        $response = $this->postJson('/api/v1/google-login', [
            'access_token' => 'fake-token',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'user']);

        // Assert the user logged in is the same ID
        $this->assertEquals($user->id, $response->json('user.id'));
    }
}
