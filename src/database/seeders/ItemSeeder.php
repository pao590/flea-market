<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'items/watch.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],

            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'items/hdd.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],

            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'items/green_onion.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 1,
            ],

            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'items/shoes.jpg',
                'condition' => '状態が悪い',
                'user_id' => 1,
            ],

            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image_path' => 'items/laptop.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],

            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'items/microphone.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],

            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'items/bag.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 1,
            ],

            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image_path' => 'items/tumbler.jpg',
                'condition' => '状態が悪い',
                'user_id' => 1,
            ],

            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image_path' => 'items/coffee_maker.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],

            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image_path' => 'items/make_up.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],
        ]);
    }
}
