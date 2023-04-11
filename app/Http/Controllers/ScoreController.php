<?php

namespace App\Http\Controllers;

use App\Http\Requests\Score\StoreScoreRequest;
use App\Jobs\StoreScoreJob;
use App\Repositories\Score\ScoreRepository;
use App\Services\ScoreService;
use Illuminate\Http\Request;

class ScoreController extends Controller
{

    public function __construct(
        private ScoreRepository $scoreRepository,
        private ScoreService    $scoreService,
    )
    {
    }

    public function store(StoreScoreRequest $request)
    {
        $userId = $request->user()->id;

        StoreScoreJob::dispatch(
            $this->scoreRepository,
            $userId,
            $request->validated(),
            $this->scoreService
        );
    }

    public function getTopList()
    {
        $scores = $this->scoreService->getTopList();
        return response()->json($scores);
    }

    public function getScoresAroundUser(Request $request)
    {
        $userId = $request->user()->id;
        $highestUserScore = $this->scoreRepository->getHighestScore($userId)->first();
        $scores = $this->scoreRepository->getScoresAroundUserScore($userId, $highestUserScore->score);
        return response()->json($scores);

    }


}
