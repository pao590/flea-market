<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Mylist;

class ItemController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath ?? null,
            'condition' => $request->condition,
            'price' => $request->price,
        ]);

        if ($request->has('categories')) {
            $item->categories()->attach($request->categories);
        }

        return redirect()->route('items.index')->with('success', '商品を出品しました。');
    }

    public function index(Request $request)
    {
        $query = Item::with('categories');

        $userId = Auth::id();

        if ($userId) {
            $query->where('user_id', '!=', $userId);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $purchasedItemIds = \App\Models\Purchase::pluck('item_id')->toArray();

        $items = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('items.index', compact('items', 'purchasedItemIds'));
    }

    public function edit(Item $item)
    {
        if (Auth::id() !== $item->user_id) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::all();
        $selectedCategoryIds = $item->categories->pluck('id')->toArray();

        return view('items.edit', compact('item', 'categories', 'selectedCategoryIds'));
    }

    public function update(ExhibitionRequest $request, Item $item)
    {
        if (Auth::id() !== $item->user_id) {
            abort(403, 'Unauthorized');
        } //更新防止

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
        ]);

        $item->categories()->sync($request->categories);

        return redirect()->route('items.show', $item)->with('success', '商品情報を更新しました。');
    }

    public function show(Item $item)
    {
        $item->load(['categories', 'user', 'likes', 'comments.user']);

        $isSold = \App\Models\Purchase::where('item_id', $item->id)->exists();
        
        return view('items.show', compact('item'));
    }

    public function like($itemId)
    {
        $user = auth()->user();

        if (!Mylist::where('user_id', $user->id)->where('item_id', $itemId)->exists()) {
            Mylist::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]);
        }

        return redirect()->back();
    }

    public function unlike($itemId)
    {
        $user = auth()->user();

        Mylist::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->delete();

        return redirect()->back();
    }
}
