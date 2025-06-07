<?php

namespace Tests\Feature\V1;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithAdminReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::ADMIN_ID
        ]);

        $response = $this->actingAs($user)
            ->get(route('v1.category.index'));

        $response->assertOk()
            ->assertJsonCount(10, 'data.data');

        Category::factory()->create([
            'name' => 'Nueva categoria'
        ]);

        $response = $this->actingAs($user)
            ->get(route('v1.category.index' , [
                'filter' => [
                    'name' => 'Nueva'
                ]
            ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data.data');

    }

    public function testIndexWithUserReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::USER_ID
        ]);

        $response = $this->actingAs($user)
            ->get(route('v1.category.index'));

        $response->assertOk()
            ->assertJsonCount(10, 'data.data');

        Category::factory()->create([
            'name' => 'Nueva categoria'
        ]);

        $response = $this->actingAs($user)
            ->get(route('v1.category.index' , [
                'filter' => [
                    'name' => 'Nueva'
                ]
            ]));

        $response->assertOk()
            ->assertJsonCount(1, 'data.data');

    }

    public function testShowReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::USER_ID
        ]);

        $category = Category::factory()->create();


        $response = $this->actingAs($user)
            ->get(route('v1.category.show', ['category' => $category->id]));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description
                ],
                'message' => config('messages.success.show')
            ]);
    }

    public function testShowReturnsErrorResponse()
    {
        $user = User::factory()->create([]);

        $response = $this->actingAs($user)
            ->get(route('v1.category.show', ['category' => 99]));

        $response->assertStatus(404);
    }

    public function testStoreWithUserReturnErrorResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::USER_ID
        ]);

        $category = Category::factory()->make()->toArray();

        $response = $this->actingAs($user)
            ->post(route('v1.category.store'), $category);

        $response->assertForbidden()
            ->assertJson([
                'message' => 'No posee permisos para acceder a este recurso'
            ]);
    }

    public function testStoreWithAdminReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::ADMIN_ID
        ]);

        $category = Category::factory()->make()->toArray();
        $response = $this->actingAs($user)
            ->post(route('v1.category.store'), $category);

        $response->assertCreated()
            ->assertJson([
                'message' => config('messages.success.store'),
                'data' => $category
            ]);
    }

    public function testUpdateWithUserReturnsErrorResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::USER_ID
        ]);

        $category = Category::factory()->create();
        $updatedData = ['name' => 'Updated Category'];

        $response = $this->actingAs($user)
            ->put(route('v1.category.update', ['category' => $category->id]), $updatedData);

        $response->assertForbidden()
            ->assertJson([
                'message' => 'No posee permisos para acceder a este recurso'
            ]);
    }

    public function testUpdateWithAdminReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::ADMIN_ID
        ]);

        $category = Category::factory()->create();
        $updatedData = ['name' => 'Updated Category'];

        $response = $this->actingAs($user)
            ->put(route('v1.category.update', ['category' => $category->id]), $updatedData);

        $response->assertOk()
            ->assertJson([
                'message' => config('messages.success.update'),
                'data' => [
                    'id' => $category->id,
                    'name' => 'Updated Category'
                ]
            ]);
    }

    public function testDeleteWithUserReturnsErrorResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::USER_ID
        ]);

        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('v1.category.destroy', ['category' => $category->id]));

        $response->assertForbidden()
            ->assertJson([
                'message' => 'No posee permisos para acceder a este recurso'
            ]);
    }

    public function testDeleteWithAdminReturnsSuccessResponse()
    {
        $user = User::factory()->create([
            'role_id' => Role::ADMIN_ID
        ]);

        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('v1.category.destroy', ['category' => $category->id]));

        $response->assertOk()
            ->assertJson([
                'message' => config('messages.success.delete'),
                'data' => []
            ]);
    }
}
