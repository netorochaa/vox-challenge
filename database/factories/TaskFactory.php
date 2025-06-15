<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->sentence(),
            'category_id' => Category::factory(),
            'order'       => rand(1, 1000),
        ];
    }
}
