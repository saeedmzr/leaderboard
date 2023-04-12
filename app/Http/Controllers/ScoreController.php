<?php

namespace App\Http\Controllers;

use App\Http\Requests\Score\StoreScoreRequest;
use App\Jobs\StoreScoreJob;
use App\Repositories\Score\ScoreRepository;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use RedisException;

class ScoreController extends Controller
{

    public function __construct(
        private ScoreRepository $scoreRepository,
        private ScoreService $scoreService,
    ) {
    }

    public function store(StoreScoreRequest $request)
    {
        $userId = $request->user()->id;
        StoreScoreJob::dispatch($this->scoreRepository, $userId, $request->validated(), $this->scoreService);
        return response()->json([
            'status' => 'success',
            'message' => 'your score has been stored successfully.'
        ]);
    }

    /**
     * @throws RedisException
     */
    public function getTopList()
    {
        $scores = $this->scoreService->getTopList();
        return response()->json($scores);
    }

    /**
     * @throws RedisException
     */
    public function getScoresAroundUser(Request $request)
    {
        $scores = $this->scoreService->getAround($request->user()->id, 5);
        return response()->json($scores);
    }

}
