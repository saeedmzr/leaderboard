<?php

namespace App\Http\Requests\Score;

use Illuminate\Foundation\Http\FormRequest;

class StoreScoreRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'score' => 'required|numeric',
        ];
    }
}
