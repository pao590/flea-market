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
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'テストユーザー',
                'password' => Hash::make('password'),
                'profile_image' => 'profiles/default-profile.png',
                'zipcode' => '123-4567',
                'address' => '東京都新宿区',
                'building' => 'サンプルビル101',
            ]
        );

        User::firstOrCreate(
            ['email' => 'noitems@example.com'],
            [
                'name' => '未出品ユーザー',
                'password' => Hash::make('password'),
                'profile_image' => 'profiles/default-profile.png',
                'zipcode' => '987-6543',
                'address' => '大阪府大阪市',
                'building' => 'テストビル202',
            ]
        );
    }
}
