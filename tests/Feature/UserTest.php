<?php

namespace Tests\Feature;

use App\Mail\DeleteAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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

    public function test_updateUser()
    {
        $this->artisan('passport:install');
        $pass = 'user1';
        $password_hash = Hash::make($pass);
        $user = User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => $password_hash
        ]);
        $data = [
            'name' => 'user111'
        ];
        $response = $this->actingAs($user, 'api')->put("api/users/$user->id", $data);
        $response->assertSuccessful();
        $user->refresh();
        $this->assertEquals('user111', $user->name);
    }

    public function test_getUserEmails_method()
    {
        $this->artisan('passport:install');
        $users = User::factory()->count(3)->create();
        $response = $this->actingAs($users[0], 'api')->get("api/users")->assertStatus(200);
        $response->assertJsonStructure(['emails']);
    }

    public function test_getUserData_method()
    {
        $this->artisan('passport:install');
        $users = User::factory()->count(3)->create();
        $response = $this->actingAs($users[0], 'api')->get("api/users/1")
            ->assertStatus(200);
        $response->assertJsonStructure(['user']);
    }
    public function test_getUserData_otherUser_method()
    {
        $this->artisan('passport:install');
        $users = User::factory()->count(3)->create();
        $response = $this->actingAs($users[0], 'api')->get("api/users/2");
        $response->assertStatus(403);
    }

    public function test_delete_method()
    {
        $this->artisan('passport:install');
        $users = User::factory()->count(3)->create();
        Mail::fake();
        $response = $this->actingAs($users[0], 'api')->get("api/users/1")->assertSuccessful();
        $response->assertJsonStructure(null, 204);
        Mail::assertSent(DeleteAccount::class);
    }
}
