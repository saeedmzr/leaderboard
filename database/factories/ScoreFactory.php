<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $userId = User::all()->random()->first()->id;
        return [
            'user_id' => $userId,
            'score' => $this->faker->randomNumber(5)
        ];
    }
}
