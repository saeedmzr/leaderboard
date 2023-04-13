<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::whereEmail('saeedmouzarmi@gmail.com')->first()) {
            User::create([
                'name' => 'saeedmouzarmi',
                'email' => 'saeedmouzarmi@gmail.com',
                'password' => Hash::make('111111'),
            ]);

        }

        User::factory()->count(1000)->create();
    }
}
