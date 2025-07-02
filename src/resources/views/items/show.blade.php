@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')
<div class="item-detail-container">
    <div class="item-detail-wrapper">
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <div class="item-info">
            <h2 class="item-title">{{ $item->name }}</h2>
            <p class="item-description">{{ $item->description }}</p>

            <div class="item-meta">
                <div class="item-price">価格: ¥{{ number_format($item->price) }}</div>
                <div class="item-condition">状態:
                    @if ($item->condition === 'new')
                    新品
                    @elseif ($item->condition === 'used')
                    中古
                    @else
                    その他
                    @endif
                </div>
                <div class="item-categories">
                    カテゴリ:
                    @foreach($item->categories as $category)
                    <span class="category-badge">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection