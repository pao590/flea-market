<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class ItemCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_creation_and_storage()
    {
        $user = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'profiles/seller.jpg',
        ]);

        $category = Category::create([
            'name' => 'テストカテゴリ',
        ]);

        $response = $this->actingAs($user)->get(route('items.create'));
        $response->assertStatus(200);

        $postData = [
            'condition' => '新品',
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明です',
            'price' => 5000,
            'image' => new UploadedFile(
                storage_path('app/public/items/sample.jpg'), 
                'sample.jpg',
                'image/jpeg',
                null,
                true
            ),
            'categories' => [$category->id],
        ];

        $response = $this->actingAs($user)->post(route('items.store'), $postData);

        $response->assertStatus(302);
        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition' => '新品',
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明です',
            'price' => 5000,
        ]);

        $item = Item::where('name', 'テスト商品')->first();
        $this->assertTrue($item->categories->contains($category));
    }
}
