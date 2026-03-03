<?php

namespace Database\Seeders;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notifications::create([
            'user_id' => User::first()->id,
            'title' => 'Test Notification',
            'body' => 'This is a test notification',
        ]);
    }
}
