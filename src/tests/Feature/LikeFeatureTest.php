<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Mylist;

class LikeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function ユーザーは商品をいいねできる()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $buyer = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => 'その他',
            'description' => 'これはテスト商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->actingAs($buyer)
            ->post(route('items.like', $item->id));

        $this->assertDatabaseHas('mylists', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals(1, $item->mylists()->count());

        $item->refresh();
        $this->assertEquals(1, $item->mylists()->count());
    }

    /** @test */
    public function ユーザーは商品へのいいねを解除できる()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => 'その他',
            'description' => 'これはテスト商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        Mylist::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('items.unlike', $item->id));

        $this->assertDatabaseMissing('mylists', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals(0, $item->mylists()->count());

        $response = $this->get(route('items.show', $item->id));
        $response->assertSee('<div class="like-count">0</div>', false);
        $response->assertSee('far fa-star');
    }
}
