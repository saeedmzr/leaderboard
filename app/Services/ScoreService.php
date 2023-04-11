<?php

namespace App\Services;

use App\Repositories\Score\ScoreRepository;
use Illuminate\Support\Facades\Cache;

class ScoreService
{
    public function __construct(private ScoreRepository $scoreRepository)
    {
    }

    public function regenerateTopList()
    {
        $getFirstHundredScores = $this->scoreRepository->getHighestScore(100);
        Cache::remember('top_list', 600, function () use ($getFirstHundredScores) {
            return $getFirstHundredScores->map(function ($score) {
                return [
                    'user' => $score->user,
                    'score' => $score->score,
                    'created_at' => $score->created_at
                ];
            });
        });
    }

    public function getTopList()
    {
        if (!Cache::has('top_list'))
            $this->regenerateTopList();

        return Cache::get('top_list');
    }

}
