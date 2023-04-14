<?php

namespace Tests\Unit;

use App\Models\Score;
use App\Models\User;
use Database\Seeders\ScoreSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class SeedersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_users_factory()
    {
        $testingUser = User::factory()->create();
        $this->assertModelExists($testingUser);
    }

    public function test_scores_factory()
    {
        $testingScore = Score::factory()->create();
        $this->assertModelExists($testingScore);
    }
}
