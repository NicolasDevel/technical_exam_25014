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
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => Role::USER_ID
        ]);


        $userData = [
            ...User::factory()->make()->toArray(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => Role::ADMIN_ID
        ];

        $response = $this->post(route('v1.user.register'), $userData);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => Role::USER_ID
        ]);
    }

    public function testRegisterNewUserWithSession(): void
    {
        $user = User::factory()->make([
            'role_id' => Role::ADMIN_ID
        ]);

        $this->actingAs($user);

        //try to create a user role
        $userData = [
            ...User::factory()->make(['role_id' => Role::USER_ID])->toArray(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('v1.user.register'), $userData);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => Role::USER_ID
        ]);

        // Try to create admin user

        $userData = [
            ...User::factory()->make(['role_id' => Role::ADMIN_ID])->toArray(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('v1.user.register'), $userData);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => Role::ADMIN_ID
        ]);

    }

}
