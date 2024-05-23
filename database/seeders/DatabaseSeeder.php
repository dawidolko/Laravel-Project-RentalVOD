<?php

namespace Database\Seeders;

use App\Models\LoyaltyPoint;
use App\Models\ReferralCode;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MoviesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\LoansSeeder;
use Database\Seeders\OpinionsSeeder;
use Database\Seeders\LoansMoviesSeeder;
use Database\Seeders\CategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class,
            MoviesSeeder::class,
            RoleSeeder::class,
            UsersSeeder::class,
            LoansSeeder::class,
            LoansMoviesSeeder::class,
            OpinionsSeeder::class,
        ]);
        User::all()->each(function ($user) {
            if (!$user->referralCode) {
                ReferralCode::create([
                    'user_id' => $user->id,
                    'code' => substr(md5($user->id . microtime()), 0, 8)
                ]);
            }

            if (!$user->loyaltyPoints) {
                LoyaltyPoint::create([
                    'user_id' => $user->id,
                    'points' => 0
                ]);
            }
        });
    }
}
