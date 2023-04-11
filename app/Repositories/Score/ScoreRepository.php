<?php

namespace App\Repositories\Score;

use App\Models\Score;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class ScoreRepository extends BaseRepository
{

    protected $model;

    public function __construct(Score $model)
    {
        $this->model = $model;
    }

    public function user($userId): static
    {
        $this->model = $this->model->where('user_id', $userId);
        return $this;
    }

    public function getHighestScore($userId = null, $number = 1)
    {
        $builder = $this->model->with('user');
        if ($userId) $builder = $builder->where('user_id', $userId);

        return
            $builder->orderby('score', 'desc')
                ->take($number)->get();
    }

    public function getScoresAroundUserScore(int $userId, int $userScore): Collection|array
    {

        $scores = $this->all();

        $rank = $scores->search(function ($score) use ($userScore) {
            return $score->score <= $userScore;
        });

        $offset = max(0, $rank - 5);
        $limit = 11;

        return $this->model
            ->whereBetween('score', [$scores[$offset]->score, $scores[$offset + $limit - 1]->score])
            ->orderBy('score', 'desc')
            ->get();
    }
}
