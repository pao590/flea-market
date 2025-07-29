@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="user-info">
        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('storage/profiles/default-profile.png') }}"
            alt="プロフィール画像" class="profile-image">

        <div class="user-name">
            {{ $user->name }}
        </div>

        <div class="edit-button-wrapper">
            <a href="{{ route('profile.edit') }}" class="edit-button">プロフィール編集</a>
        </div>
    </div>

    <div class="tabs">
        <a href="{{ route('mypages.index', ['page' => 'sell']) }}"
            class="tab {{ request('page') !== 'buy' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypages.index', ['page' => 'buy']) }}"
            class="tab {{ request('page') === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    <div class="item-grid">
        @forelse ($items as $item)
        <div class="item-card">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
            <div class="item-name">{{ $item->name }}</div>
            <div class="item-price">¥{{ number_format($item->price) }}</div>
        </div>
        @empty
        <p class="no-items">商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection