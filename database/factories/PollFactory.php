<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
class PollFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
