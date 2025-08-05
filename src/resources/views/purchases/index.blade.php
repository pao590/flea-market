@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/index.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <h2>購入手続き</h2>

    <div class="item-summary">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        <div class="item-details">
            <h3>{{ $item->name }}</h3>
            <p>{{ $item->brand_name ?? 'ブランド未設定' }}</p>
            <p>￥{{ number_format($item->price) }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('purchases.store', ['item' => $item->id]) }}">
        @csrf
        <div class="form-section">
            <label for="payment_method">支払い方法</label>
            <select name="payment_method" id="payment_method" required>
                <option value="card">クレジットカード</option>
                <option value="convenience">コンビニ払い</option>
            </select>
        </div>

        <div class="form-section">
            <label>配送先</label>
            <p>〒{{ $user->zipcode }}</p>
            <p>{{ $user->address }}</p>
            <a href="{{ route('purchases.address') }}">変更する</a>
        </div>

        <button type="submit" class="submit-button">購入する</button>
    </form>
</div>
@endsection