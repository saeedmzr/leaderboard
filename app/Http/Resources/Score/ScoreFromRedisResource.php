<?php

namespace App\Http\Resources\Score;

use App\Http\Resources\Admin\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreFromRedisResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request): array
    {

        return [
            'user' => $this['user']->name,
            'score' => $this['score']
        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
