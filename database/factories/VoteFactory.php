<?php
namespace Database\Factories;

use App\Models\Vote;
use App\Models\User;
use App\Models\Poll;
use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'poll_id' => Poll::inRandomOrder()->first()->id,
            'choice_id' => Choice::inRandomOrder()->first()->id,
        ];
    }
}
