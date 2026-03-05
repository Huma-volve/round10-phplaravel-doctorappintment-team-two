<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'skdk5id@gmail.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'mobile_number' => '01010101010',
                'role' => 'admin',
                'latitude' => 0,
                'longitude' => 0,
            ]
        );
    }
}
