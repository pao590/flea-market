@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    {{-- ユーザー情報 --}}
    <div class="user-info">
        <img src="{{ asset('storage/profiles/' . ($user->profile_image ?? 'default-profile.png')) }}"
            alt="プロフィール画像"
            class="profile-image">

        <div class="user-name">{{ $user->name }}</div>

        <div class="edit-button-wrapper">
            <a href="{{ route('profile.edit') }}" class="edit-button">
                プロフィールを編集
            </a>
        </div>
    </div>

    {{-- タブ --}}
    <div class="tabs">
        <a href="{{ route('mypages.index', ['page' => 'sell']) }}"
            class="tab {{ request('page') == 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypages.index', ['page' => 'buy']) }}"
            class="tab {{ request('page') == 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    {{-- 商品一覧 --}}
    <div class="item-grid">
        @foreach ($items as $item)
        <div class="item-card">
            <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
            <div class="item-name">{{ $item->name }}</div>
            <div class="item-price">¥{{ number_format($item->price) }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection