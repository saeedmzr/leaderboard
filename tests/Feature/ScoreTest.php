<?php

namespace Tests\Feature;

use App\Models\Score;
use App\Models\User;
use App\Repositories\Score\ScoreRepository;
use Tests\TestCase;

class ScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_get_top_list()
    {
        $this->loginAsSaeed();
        $response = $this->get('api/score/getTopList');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'user', 'score'
                ]
            ]
        ]);
    }

    public function test_user_can_get_around_scores()
    {
        $this->loginAsSaeed();
        $response = $this->get('api/score/around');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'user', 'score'
                ]
            ]
        ]);
    }

    public function test_user_can_store_new_score()
    {
        $this->loginAsSaeed();
        $data = [
            'score' => 10,
        ];
        $response = $this->post('api/score', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
    }

    public function test_user_store_highest_rank_and_be_first_in_top_list()
    {
        $user = $this->loginAsSaeed();

        $scoreRepo = new ScoreRepository(new Score());
        $highestScore = Score::orderBy('score', 'desc')->first();
        $user = User::factory()->create();

        $this->loginAsSaeed();
        $data = [
            'score' => $highestScore->score + 1,
        ];
        $this->post('api/score', $data);

        $response = $this->get('api/auth/get');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'rank' =>1
        ]);
    }
}
