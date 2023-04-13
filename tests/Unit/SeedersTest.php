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
    public function test_users_seeder()
    {
        $this->seed(UserSeeder::class);
        $this->assertEquals(2002, User::all()->count());
    }

    public function test_scores_seeder()
    {
        $this->seed(ScoreSeeder::class);
        $this->assertEquals(601, Score::all()->count());
    }
}
