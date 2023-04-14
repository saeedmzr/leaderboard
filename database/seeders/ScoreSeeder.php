<?php

namespace Database\Seeders;

use App\Jobs\StoreScoreJob;
use App\Models\Score;
use App\Models\User;
use App\Repositories\Score\ScoreRepository;
use Illuminate\Database\Seeder;
use Redis;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 500; $i++) {
            $scoreRepo = new ScoreRepository(new Score());
            $scoreService = new ScoreRepository(new Score());
            $userId = User::all()->random()->id;
            $payload = [
                'score' => rand(10, 1000),
            ];
            $redis = new Redis();
            $redis->connect('localhost', 6379);

            $payload['user_id'] = $userId;

            $insertedScore = $scoreRepo->create($payload);

            if ($insertedScore->score > $redis->zScore('leaderboard', $userId)) {
                $redis->zAdd('leaderboard', $insertedScore->score, $userId);
            }
        }

    }
}
