<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        Poll::factory()->count(10)->create();
    }
}
