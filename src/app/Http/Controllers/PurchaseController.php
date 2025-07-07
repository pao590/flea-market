<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAddressRequest;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::with(['categories', 'user'])->findOrFail($itemId);

        $user = Auth::user();

        return view('purchase.index', compact('item', 'user'));
    }

    public function address()
    {
        $user = Auth::user();
        return view('purchase.address', compact('user'));
    }

    public function updateAddress(UpdateAddressRequest $request)
    {
        $user = Auth::user();
        $user->address = $request->input('address');
        $user->save();

        return redirect()->route('purchases.index', ['item_id' => session('last_item_id')])->with('success', '住所が更新されました');
    }
}
