<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $this->artisan('passport:install');

        $data = [
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => 'user4',
            'password_confirmation' => 'user4'
        ];

        $response = $this->post('api/users', $data);

        $response->assertStatus(200);
    }
}
