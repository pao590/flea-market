<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function test_全商品を取得できる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => '説明文',
            'image_path' => 'test.jpg',
            'condition' => 'new',
            'price' => 1000,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    /** @test */
    public function test_購入済み商品には_sold_が表示される()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
            'description' => '説明文',
            'image_path' => 'sold.jpg',
            'condition' => 'new',
            'price' => 2000,
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'credit',
        ]);

        $response = $this->get('/');
        $response->assertSee('Sold');
    }

    /** @test */
    public function test_自分が出品した商品は表示されない()
    {
        $user = User::create([
            'name' => '自分',
            'email' => 'me@example.com',
            'password' => bcrypt('password'),
        ]);

        Item::create([
            'user_id' => $user->id,
            'name' => '自分の商品',
            'description' => '説明文',
            'image_path' => 'myitem.jpg',
            'condition' => 'new',
            'price' => 3000,
        ]);

        $this->actingAs($user);

        $response = $this->get('/');
        $response->assertDontSee('自分の商品');
    }
}
