@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/index.css') }}">
@endsection

@section('content')
<div class="purchase-index-container">
    <h2>購入確認</h2>

    <div class="item-summary">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
        <h3>{{ $item->name }}</h3>
        <p>価格: ¥{{ number_format($item->price) }}</p>
    </div>

    <div class="user-info">
        <p>お届け先: {{ $user->address ?? '住所未設定' }}</p>
        <a href="{{ route('purchases.address') }}" class="btn btn-secondary">住所を変更する</a>
    </div>

    <form action="#" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">購入を確定する</button>
    </form>
</div>
@endsection