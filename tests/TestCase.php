<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\CertainUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAsSaeed()
    {
        $this->seed(CertainUserSeeder::class);
        $user = User::where('email', 'saeedmouzarmi@gmail.com')->first();
//        Auth::login($user);
        $this->actingAs($user);
        return $user;
    }

}
