<?php

namespace Tests\Feature;

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
            'id', 'user', 'score'
        ]);
    }
}
