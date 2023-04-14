<?php

namespace Tests\Feature;

use App\Models\Score;
use App\Models\User;
use App\Repositories\Score\ScoreRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_works()
    {
        $password = '1111';
        $user = User::factory([
            'password' => Hash::make($password)
        ])->create();
        $response = $this->post('api/auth/login', ['email' => $user->email, 'password' => $password]);
        $response->assertStatus(200);
    }

    public function test_auth_get_works()
    {
        $user = $this->loginAsSaeed();
        $response = $this->get('api/auth/get');
        $response->assertStatus(200);
    }
    public function test_auth_logout_works()
    {
        $user = $this->loginAsSaeed();
        $response = $this->post('api/auth/logout');
        $response->assertStatus(200);
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
            'rank' => 1
        ]);
    }
}
