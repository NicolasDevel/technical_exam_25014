<?php

namespace Tests\Feature\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(route('v1.auth.login'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'token_type',
                    'token',
                    'user' => [
                        'name',
                        'email',
                        'role'
                    ]
                ],
                'message'
            ])->assertJsonFragment([
                'data' => [
                    'token' => $response->json('data.token'),
                    'token_type' => 'Bearer',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role->name
                    ],
                ],
                'message' => 'Se ha iniciado sesión correctamente.'
            ]);
    }

    public function testLoginFailed()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'fail'
        ];
        $response = $this->postJson(route('v1.auth.login'), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['password']);

        $data['password'] = 'passwordIncorrect';

        $response = $this->postJson(route('v1.auth.login'), $data);

        $response->assertUnauthorized()
            ->assertJson([
                'errors' => [],
                'trace' => [],
                'message' => 'Las credenciales son incorrectas.'
            ]);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('v1.auth.logout'));

        $response->assertOk()
            ->assertJson([
                'data' => [],
                'message' =>  'La sesión ha sido cerrada.'
            ]);
    }

    public function testLogoutFailed()
    {
        $this->postJson(route('v1.auth.logout'))
            ->assertUnauthorized();
    }

}
