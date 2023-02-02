<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function testLogin_correct_data()
    {

        $user = User::factory()->create();
        $user->dump();
        $response = $this->json('POST', 'api/login',[
            'email' => $user->email,
            'password' => $user->password
        ])->assertStatus(200);
        $response->dump();
        $response->assertJsonStructure(['token']);

    }

    public function testLogin_incorrect_password()
    {

        $user = User::factory()->create();

        $response = $this->json('POST', 'api/login',[
            'email' => $user->email,
            'password' => 'user2'
        ])->assertStatus(200)->assertJsonStructure([
            'message',
            'error'
        ]);;

    }

    public function testLogin_incorrect_email()
    {

        $user = User::factory()->create();

        $response = $this->json('POST', 'api/login',[
            'email' => 'random@gmail.com',
            'password' => $user->password
        ])->assertStatus(200)->assertJsonStructure([
            'message',
            'error'
        ]);;

    }
}
