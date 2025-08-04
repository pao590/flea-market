<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PaymentMethodSelectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 支払い方法選択画面で変更が即時反映される()
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
            'price' => 2000,
            'condition' => '新品',
            'description' => '支払い方法選択テスト用商品',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->actingAs($buyer)->get(route('purchases.index', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('payment_method');
        $response->assertSee('card');
        $response->assertSee('convenience');

        $response = $this->actingAs($buyer)->post(route('purchases.store', ['item' => $item->id]), [
            'payment_method' => 'convenience',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'convenience',
        ]);
    }
}