<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Choice;

class ChoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 choices (and related polls if needed)
        Choice::factory()->count(50)->create();
    }
}

