@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="tabs">
        <a href="{{ route('items.index', ['tab' => 'recommend']) }}"
            class="tab {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>

        <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
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
                <p>価格: ¥{{ number_format($item->price) }}</p>
                <p>状態: {{ $item->condition }}</p>
                <div class="category-tags">
                    @foreach($item->categories as $category)
                    <span class="tag">{{ $category->name }}</span>
                    @endforeach
                </div>
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
                <p>価格: ¥{{ number_format($item->price) }}</p>
                <p>状態: {{ $item->condition }}</p>
                <div class="category-tags">
                    @foreach($item->categories as $category)
                    <span class="tag">{{ $category->name }}</span>
                    @endforeach
                </div>
            </a>
        </div>
        @empty
        <p class="message">マイリストに商品はありません。</p>
        @endforelse
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