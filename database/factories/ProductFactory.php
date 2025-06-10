<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory()->create(['role_id' => Role::ADMIN_ID]),
            'name'  => $this->faker->word(),
            'description'  => $this->faker->paragraph(),
            'price'  => $this->faker->numberBetween(100, 1),
            'stock'  => $this->faker->numberBetween(100, 1000),
        ];
    }
}
