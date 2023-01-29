<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\UserService;

class UserTest extends TestCase
{
    /** @test */
    public function it_tests_create_method()
    {
        //create an instance of UserService through the ServiceContainer.
        $userService = app()->make(UserService::class);
        //prepare data
        $user_data = [
            'name' => 'user3',
            'email' => 'user3@gmail.com'
            ];
        $user_data['password'] = Hash::make('user3');
        //call service method
        $createdUser = $userService->createUser($user_data);
        //check all necessary changes and response.
        // You can use any asserts you need. find them in Laravel documentation
        $this->assertInstanceOf($createdUser, User::class);
        //check Laravel documentation
        $this->assertDatabaseHas('users', [
            'email' => 'user3@gmail.com',
        ]);
    }
}
