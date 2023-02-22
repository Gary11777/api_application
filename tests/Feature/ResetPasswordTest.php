<?php

namespace Tests\Feature;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_resetPassword_method()
    {
        $this->artisan('passport:install');
        $pass = 'user1';
        $password_hash = Hash::make($pass);
        $user = User::factory()->create([
            'email' => 'user1@gmail.com',
            'password' => $password_hash
        ]);
        Mail::fake();
        $response = $this->json('POST', 'api/reset_password',[
            'email' => $user->email
        ])->assertStatus(200);
        $response->assertJsonStructure(['result', 'message']);
        Mail::assertSent(ResetPassword::class);
    }

    public function test_setNewPassword_method()
    {
        $this->artisan('passport:install');
        $pass = 'user1';
        $password_hash = Hash::make($pass);
        $user = User::factory()->create([
            'email' => 'user1@gmail.com',
            'password' => $password_hash
        ]);
        $token = Str::random(10);
        DB::table('reset_passwords')->insert([
            'user_id' => 1,
            'token' => $token
        ]);
        $response = $this->json('POST', 'api/set_newpassword',[
            'token' => $token,
            'password' => '123'
        ])->assertStatus(200);
        $response->assertJsonStructure(['result', 'message']);
    }
}
