<?php

namespace Tests\Feature\V1;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUserWithoutSession(): void
    {
        $userData = [
            ...User::factory()->make()->toArray(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('v1.user.register'), $userData);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => Role::USER_ID
        ]);
    }
}
