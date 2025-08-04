<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function プロフィールページに必要な情報が表示される()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'profiles/seller.jpg',
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'profiles/buyer.jpg',
        ]);

        $item1 = Item::create([
            'user_id' => $seller->id,
            'name' => '出品商品1',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト商品1',
            'image_path' => 'items/item1.jpg',
        ]);

        $item2 = Item::create([
            'user_id' => $seller->id,
            'name' => '出品商品2',
            'price' => 2000,
            'condition' => '中古',
            'description' => 'テスト商品2',
            'image_path' => 'items/item2.jpg',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item1->id,
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($buyer)->get(route('profile.edit'));

        $response->assertStatus(200);

        $response->assertSee('profiles/buyer.jpg');
        $response->assertSee('購入者');

        $response->assertDontSee('出品商品1');
        $response->assertDontSee('出品商品2');
    }
}
