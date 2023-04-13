<?php

namespace Database\Seeders;

use App\Jobs\StoreScoreJob;
use App\Models\Score;
use App\Models\User;
use App\Repositories\Score\ScoreRepository;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 300; $i++) {
            $scoreRepo = new ScoreRepository(new Score());
            $scoreService = new ScoreRepository(new Score());
            $userId = User::all()->random()->id;
            $payload = [
                'score' => rand(10, 1000),
            ];
            StoreScoreJob::dispatch(
                $scoreRepo,
                $userId,
                $payload,
//                $this->scoreService
            );
        }

    }
}
