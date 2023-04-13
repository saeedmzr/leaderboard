<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAsSaeed()
    {
        $user = User::where('email', 'saeedmouzarmi@gmail.com')->first();
//        Auth::login($user);
        $this->actingAs($user);
        return $user;
    }

}
