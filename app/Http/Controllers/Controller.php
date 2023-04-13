<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function generateScoreFromRedis(array $scores)
    {
        $userRepo = new UserRepository(new User());
        $newScores = [];
        foreach ($scores as $key => $score) {

            $newScores[] = [
                'user_id' => $key,
                'score' => $score
            ];
        }
        return collect($newScores)->map(function ($item) use ($userRepo) {
            return [
                'user' => $userRepo->findById($item['user_id']),
                'score' => $item['score']
            ];
        });
    }
}
