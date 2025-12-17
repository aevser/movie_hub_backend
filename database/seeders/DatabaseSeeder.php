<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create(
            [
                'name' => 'admin',
                'email' => '1@1.ru',
                'password' => Hash::make('password')
            ]
        );
    }
}
