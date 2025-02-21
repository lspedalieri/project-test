<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder{

    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => "admin@example.com", //fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'roles' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'user',
                'email' => "user@example.com", //fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'roles' => 'user',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),                
            ]
        ]);
    }
}

