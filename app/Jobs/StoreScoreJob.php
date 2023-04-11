<?php

namespace App\Jobs;

use App\Repositories\Score\ScoreRepository;
use App\Services\ScoreService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        array                   $payload,
        private ScoreService    $scoreService,
    )
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = $this->payload;
        $payload['user_id'] = $this->userId;

        $insertedScore = $this->scoreRepository->create($payload);
        $userHighestScore = $this->scoreRepository->user($this->userId)->getHighestScore()->first();

        if ($insertedScore->id != $userHighestScore->id && $insertedScore->score > $userHighestScore) {
            $this->scoreService->regenerateTopList();
        }
    }
}
