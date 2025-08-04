<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_update_page_shows_initial_values()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'profile_image' => 'profiles/testuser.jpg',
            'zipcode' => '123-4567',
            'address' => '東京都新宿区西新宿2-8-1',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);

        $response->assertSee('value="テストユーザー"', false);
        $response->assertSee('profiles/testuser.jpg');
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都新宿区西新宿2-8-1"', false); 
    }
}
