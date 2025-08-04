<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Mylist;
use App\Models\Comment;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $categories = [
            Category::create(['name' => 'ブランド']),
            Category::create(['name' => 'アウトドア']),
        ];

        $item = Item::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => 'その他',
            'description' => 'これはテスト商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $item->categories()->attach(array_map(fn($c) => $c->id, $categories));

        $commentUser = User::create([
            'name' => 'コメントユーザー',
            'email' => 'comment@example.com',
            'password' => bcrypt('password'),
        ]);

        $comment = Comment::create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'content' => '良い商品です！',
        ]);

        Mylist::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.show', ['item' => $item->id]));

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('ブランド未設定');
        $response->assertSee('¥1,000');
        $response->assertSee('その他');
        $response->assertSee('これはテスト商品です。');
        $response->assertSee(asset('storage/' . $item->image_path));

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }

        $response->assertSee('<div class="like-count">1</div>', false);
        $response->assertSee('<div class="comment-count">1</div>', false);
        $response->assertSee('良い商品です！');
        $response->assertSee('コメントユーザー');
    }
}

