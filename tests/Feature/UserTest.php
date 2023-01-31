<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testRegister()
    {
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
}
