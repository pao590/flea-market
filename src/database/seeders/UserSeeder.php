<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'default-profile.png',
            'zipcode' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'サンプルビル101'
        ]);
    }
}
