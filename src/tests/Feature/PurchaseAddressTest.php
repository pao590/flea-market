<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 住所変更画面で登録した住所が購入画面に反映される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 3000,
            'condition' => '新品',
            'description' => 'テスト商品説明',
            'image_path' => 'items/test.jpg',
        ]);

        $this->actingAs($user)
            ->withSession(['last_item_id' => $item->id])
            ->get(route('purchases.address'))
            ->assertStatus(200);

        $newAddress = '東京都千代田区1-1-1';
        $response = $this->actingAs($user)
            ->withSession(['last_item_id' => $item->id])
            ->post(route('purchases.updateAddress'), [
                'address' => $newAddress,
            ]);
        $response->assertRedirect(route('purchases.index', ['item_id' => $item->id]));

        $response = $this->actingAs($user)->get(route('purchases.index', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee($newAddress);
    }

    /** @test */
    public function 商品購入時に送付先住所が購入データに紐づく()
    {
        $user = User::create([
            'name' => 'テストユーザー2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'address' => '大阪府大阪市1-2-3',
        ]);

        $seller = User::create([
            'name' => '出品者2',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '別テスト商品',
            'price' => 4000,
            'condition' => '新品',
            'description' => '別テスト商品説明',
            'image_path' => 'items/test2.jpg',
        ]);

        $response = $this->actingAs($user)->post(route('purchases.store', ['item' => $item->id]), [
            'payment_method' => 'card',
        ]);
        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
        ]);

        $user->refresh();
        $this->assertEquals('大阪府大阪市1-2-3', $user->address);
    }
}
