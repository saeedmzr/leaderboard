<?php

namespace App\Jobs;

use App\Repositories\Score\ScoreRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Redis;

class StoreScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private ScoreRepository $scoreRepository,
        private int             $userId,
        array                   $payload
    )
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \RedisException
     */
    public function handle()
    {
        $redis = new Redis();
        $redis->connect('localhost', 6379);

        $payload = $this->payload;
        $payload['user_id'] = $this->userId;

        $insertedScore = $this->scoreRepository->create($payload);

        if ($insertedScore->score > $redis->zScore('leaderboard', $this->userId)) {
            $redis->zAdd('leaderboard', $insertedScore->score, $this->userId);
        }
    }
}
