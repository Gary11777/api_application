<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testRegister()
    {
        $this->artisan('passport:install');
        //prepare data for request
        $data = [
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => 'user4',
            'password_confirmation' => 'user4'
        ];
        //send request and get response
        $response = $this->json('POST', 'api/users', $data)->assertStatus(200);
        //check the response and database changes. You can use any asserts you need.
        //find them in Laravel documentation
        $response->assertJsonStructure(['token']);
    }

    public function testLogin()
    {
        $this->artisan('passport:install');
        $pass = 'user1';
        $password_hash = Hash::make($pass);
        $user = User::factory()->create([
            'email' => 'user1@gmail.com',
            'password' => $password_hash
        ]);
        $response = $this->json('POST', 'api/login',[
            'email' => $user->email,
            'password' => $pass
        ])->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
}
