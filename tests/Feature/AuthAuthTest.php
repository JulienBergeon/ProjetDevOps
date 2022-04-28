<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::create([
            'name' => 'Client',
            'email' => 'client@client.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'client@client.com',
            'password' => 'password'
        ]);
      
        if (Auth::check()) {
            return true;
        }else{
            return false;
        }
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::create([
            'name' => 'FakeClient',
            'email' => 'client@client.com',
            'password' => Hash::make('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }
}
