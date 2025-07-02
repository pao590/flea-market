@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item-list-container">
    <h1>商品一覧</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="item-grid">
        @forelse ($items as $item)
        <div class="item-card">
            <a href="{{ route('items.show', ['item' => $item->id]) }}">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
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
        <p>現在、商品はありません。</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $items->links() }}
    </div>
</div>
@endsection