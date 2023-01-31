<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testCreateMethod()
    {
        //create an instance of UserService through the ServiceContainer.
        $userService = app()->make(UserService::class);
        //prepare data
        $data = [
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'user3'
            ];
        //call service method
        $createdUser = $userService->createUser($data);
        //check all necessary changes and response.
        // You can use any asserts you need. find them in Laravel documentation
        $this->assertInstanceOf(User::class, $createdUser);
        //check Laravel documentation
        $this->assertDatabaseHas('users', [
            'email' => 'user3@gmail.com',
        ]);
    }
}
