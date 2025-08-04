<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function ログイン済みのユーザーはコメントを送信できる()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $commenter = User::create([
            'name' => 'コメント投稿者',
            'email' => 'commenter@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト用商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->actingAs($commenter)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $commenter->id,
            'content' => 'テストコメント',
        ]);

        $this->assertEquals(1, Comment::count());
    }

    /** @test */
    public function ログイン前のユーザーはコメントを送信できない()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト用商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => 'ログインしていないコメント',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', [
            'content' => 'ログインしていないコメント',
        ]);
    }

    /** @test */
    public function コメントが入力されていない場合バリデーションメッセージが表示される()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $commenter = User::create([
            'name' => 'コメント投稿者',
            'email' => 'commenter@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト用商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $response = $this->actingAs($commenter)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function コメントが255字以上の場合バリデーションメッセージが表示される()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $commenter = User::create([
            'name' => 'コメント投稿者',
            'email' => 'commenter@example.com',
            'password' => bcrypt('password'),
        ]);

        $item = Item::create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'condition' => '新品',
            'description' => 'テスト用商品です。',
            'image_path' => 'items/test.jpg',
        ]);

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($commenter)->post(route('comments.store'), [
            'item_id' => $item->id,
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors('content');
        $this->assertDatabaseCount('comments', 0);
    }
}
