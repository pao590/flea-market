<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Mylist;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => 'テスト説明',
            'image_path' => 'items/test.jpg',
            'condition' => '新品',
            'price' => 1000,
        ]);

        $response = $this->get('/?keyword=テスト');


        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    /** @test */
    public function 検索状態がマイリストでも保持される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherUser = User::create([
            'name' => '別ユーザー',
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $likedItem = Item::create([
            'user_id' => $otherUser->id,
            'name' => 'テスト商品C',
            'description' => 'テスト説明',
            'image_path' => 'items/testC.jpg',
            'condition' => '新品',
            'price' => 1500,
        ]);

        $ownItem = Item::create([
            'user_id' => $user->id,
            'name' => 'サンプル商品D',
            'description' => 'サンプル説明',
            'image_path' => 'items/testD.jpg',
            'condition' => '中古',
            'price' => 2000,
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?keyword=テスト&tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('テスト商品C');
        $response->assertDontSee('サンプル商品D');
    }
}
