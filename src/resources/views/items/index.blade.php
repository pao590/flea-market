@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="tabs">
        <a href="{{ route('items.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
            class="tab {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>

        <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword') ]) }}"
            class="tab {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <div class="item-grid">

        @if ($tab === 'recommend')
        @foreach ($recommendedItems as $item)
        <div class="item-card">
            <a href="{{ route('items.show', ['item' => $item->id]) }}">
                <div class="item-image-wrapper" style="position: relative;">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                    @if (isset($purchasedItemIds) && in_array($item->id, $purchasedItemIds))
                    <span class="sold-overlay">Sold</span>
                    @endif
                </div>
                <h2>{{ $item->name }}</h2>
            </a>
        </div>
        @endforeach


        @elseif ($tab === 'mylist')
        @auth
        @forelse ($likedItems as $item)
        <div class="item-card">
            <a href="{{ route('items.show', ['item' => $item->id]) }}">
                <div class="item-image-wrapper" style="position: relative;">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                    @if (isset($purchasedItemIds) && in_array($item->id, $purchasedItemIds))
                    <span class="sold-overlay">Sold</span>
                    @endif
                </div>
                <h2>{{ $item->name }}</h2>
            </a>
        </div>
        @empty
        <p class="message">マイリストに商品はありません。</p>
        @endforelse

        <div class="pagination">
            {{ $likedItems->links() }}
        </div>

        @else
        <p class="message">ログインするとマイリストが表示されます。</p>
        @endauth
        @endif
    </div>


    @if ($tab === 'recommend')
    <div class="pagination">
        {{ $recommendedItems->links() }}
    </div>
    @endif
</div>
@endsection

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif