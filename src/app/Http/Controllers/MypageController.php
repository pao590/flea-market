<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Mylist;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->page == 'buy') {
            $items = $user->purchasedItems;
        } else {
            $items = $user->items;
        }

        return view('mypages.index', compact('user', 'items'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mypages.index', compact('user', 'items'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = basename($path);
        }

        $user->name = $validated['name'];
        $user->zipcode = $validated['zipcode'];
        $user->address = $validated['address'];
        $user->building = $validated['building'] ?? null;
        $user->save();

        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました');
    }

    public function mylist()
    {
        $user = Auth::user();

        $likedItems = Mylist::with('item')
            ->where('user_id', $user->id)
            ->get()
            ->filter(function ($mylist) use ($user) {
                return $mylist->item && $mylist->item->user_id !== $user->id;
            })
            ->pluck('item');

        return view('mypages.mylist', compact('likedItems'));
    }
}
