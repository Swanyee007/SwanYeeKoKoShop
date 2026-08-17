<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_no' => $this->faker->unique()->bothify('ITEM-####??'),
            'name'=>$this->faker->word(),
            'image'=>$this->faker->imageUrl(),
            'price'=>$this->faker->numberBetween(1000,10000000),
            'discount'=>$this->faker->numberBetween(0,100000),
            'in_stock'=>$this->faker->boolean(),
            'description'=>$this->faker->paragraph(),
            'category_id'=>\App\Models\Category::factory()
        ];
    }
}

