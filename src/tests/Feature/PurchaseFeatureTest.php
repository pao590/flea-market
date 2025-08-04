<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 購入するボタンを押すと購入が完了する()
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
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト商品です',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->actingAs($buyer)->post(route('purchases.store', ['item' => $item->id]),['payment_method' => 'card',]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);
    }

    /** @test */
    public function 購入した商品は商品一覧画面にてsoldと表示される()
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
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト商品です',
            'image_path' => 'items/test.jpg',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($buyer)->get(route('items.index', ['tab' => 'recommend']));

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    /** @test */
    public function 購入した商品はプロフィールの購入した商品一覧に追加されている()
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
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト商品です',
            'image_path' => 'items/test.jpg',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($buyer)->get(route('items.show', ['item' => $item->id]));

        $response->assertStatus(200);

        $response->assertSee($item->name);
    }
}
