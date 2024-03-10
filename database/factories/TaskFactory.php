<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->sentence(),
            // rand uses the PHP internal random number generator
            'is_completed'  => rand(0, 1),
            'status_active' => 1,
            'is_delete'     => 0,
        ];
    }
}
