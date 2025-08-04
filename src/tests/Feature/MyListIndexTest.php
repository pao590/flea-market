<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Mylist;
use App\Models\Purchase;

class MyListIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        $otherUser1 = User::factory()->create();
        $otherUser2 = User::factory()->create();

        $likedItem = Item::create([
            'user_id' => $otherUser1->id,
            'name' => 'いいねした商品',
            'description' => '説明文',
            'image_path' => 'like.jpg',
            'condition' => 'new',
            'price' => 1000,
        ]);

        $notLikedItem = Item::create([
            'user_id' => $otherUser2->id,
            'name' => 'いいねしていない商品',
            'description' => '説明文',
            'image_path' => 'notlike.jpg',
            'condition' => 'new',
            'price' => 2000,
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    /** @test */
    public function test_購入済み商品には_sold_が表示される()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
            'description' => '説明文',
            'image_path' => 'sold.jpg',
            'condition' => 'new',
            'price' => 3000,
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit',
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();

        $myItem = Item::create([
            'user_id' => $user->id,
            'name' => '自分の商品',
            'description' => '説明文',
            'image_path' => 'myitem.jpg',
            'condition' => 'new',
            'price' => 4000,
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $myItem->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
    }

    /** @test */
    public function test_未認証の場合は何も表示されない()
    {
        $user = User::factory()->create();

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'description' => '説明文',
            'image_path' => 'test.jpg',
            'condition' => 'new',
            'price' => 5000,
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/mypages/mylist');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    
}
