<?php
namespace Database\Factories;

use App\Models\Choice;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'poll_id' => Poll::inRandomOrder()->first()->id, // creates a related poll if needed
            'value' => $this->faker->sentence(3), // random text
        ];
    }
}
