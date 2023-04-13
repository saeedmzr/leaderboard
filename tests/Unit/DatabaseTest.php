<?php

namespace Tests\Unit;


use App\Models\Score;
use App\Models\User;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_users_table()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users',
            ['id' => $user->id]
        );
    }

    public function test_scores_table()
    {
        $score = Score::factory()->create();
        $this->assertDatabaseHas('scores',
            ['id' => $score->id]
        );
    }
}
