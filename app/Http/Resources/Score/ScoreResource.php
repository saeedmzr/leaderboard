<?php

namespace App\Http\Resources\Score;

use App\Http\Resources\Admin\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
{
    public static $wrap = null;


    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->name,
            'score' => $this->cost_per_check_in,
        ];
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(200);
    }
}
