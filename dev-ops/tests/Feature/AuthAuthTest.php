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

        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
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
            'name' => 'Client',
            'email' => 'client@client.com',
            'credit' => 1000,
            'password' => Hash::make('password'),
            'is_admin' => FALSE
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'credit' =>  $user->credit 
        ]);
        $this->assertGuest();
    }
}
