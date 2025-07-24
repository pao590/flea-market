<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Purchase;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::with(['categories', 'user'])->findOrFail($itemId);

        $user = Auth::user();

        return view('purchases.index', compact('item', 'user'));
    }

    public function address()
    {
        $user = Auth::user();
        return view('purchases.address', compact('user'));
    }

    public function updateAddress(UpdateAddressRequest $request)
    {
        $user = Auth::user();
        $user->address = $request->input('address');
        $user->save();

        return redirect()->route('purchases.index', ['item_id' => session('last_item_id')])->with('success', '住所が更新されました');
    }

    public function store(Request $request, $itemId)
    {
        $user = auth()->user();

        if (Purchase::where('item_id', $itemId)->exists()){
            return redirect()->route('items.show', $itemId)->with('error', 'すでに購入されています。');
        }

        $item = Item::findOrFail($itemId);

        if ($item->user_id == $user->id) {
            return redirect()->route('items.show', $itemId)->with('error', '自分の商品は購入できません。');
        }

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);

        return redirect()->route('items.index')->with('success', '商品を購入しました。');
    }
}
