@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="item-detail-container">
    <div class="item-detail-wrapper">
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <div class="item-info">
            <h2 class="item-title">{{ $item->name }}</h2>

            <p class="item-brand">{{ $item->brand_name ?? 'ブランド未設定' }}</p>

            <h3>商品説明</h3>
            <p class="item-description">{{ $item->description }}</p>

            @if (!empty($item->color))
            <p>カラー：{{ $item->color }}</p>
            @endif

            <div class="item-meta">
                <div class="item-price">価格: ¥{{ number_format($item->price) }}</div>
                <div class="item-actions">
                    @auth
                    @php
                    $liked = $item->mylists->contains('user_id', Auth::id());
                    @endphp
                    <form action="{{ $liked ? route('items.unlike',$item->id) : route('items.like',$item->id) }}" method="POST" class="like-form">
                        @csrf
                        <button type="submit" class="like-button" aria-label="お気に入りボタン">
                            <i class="{{ $liked ? 'fas' : 'far' }} fa-star"></i>

                        </button>
                        <div class="like-count">{{ $item->mylists->count() }}</div>
                    </form>
                    @endauth

                    <div class="comment-button" role="button" tabindex="0" aria-label="コメント数">
                        <i class="far fa-comment"></i>
                        <div class="comment-count">{{ $item->comments->count() }}</div>
                    </div>

                </div>

                <div class="purchase-button-wrapper">
                    @if ($isSold)
                    <span class="sold-label text-danger">この商品は売り切れました（Sold）</span>
                    @elseif (Auth::check() && Auth::id() !== $item->user_id)
                    <a href="{{ route('purchases.index', ['item_id' => $item->id]) }}" class="purchase-button">購入手続きへ</a>
                    @endif
                </div>

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

    <div class="comments-section">
        <h3 class="comments-title">コメント（{{ $item->comments->count() }}）</h3>

        @forelse ($item->comments as $comment)
        <div class="comment-card">
            <div class="comment-header">
                <img src="{{ asset($comment->user->profile_image ?? 'storage/default-profile.png') }}" alt="プロフィール画像" class="comment-avatar">
                <div class="comment-user-info">
                    <p class="comment-user-name">{{ $comment->user->name ?? '匿名ユーザー' }}</p>
                    <p class="comment-date">{{ $comment->created_at->format('Y年m月d日 H:i') }}</p>
                </div>
            </div>
            <div class="comment-body">
                <p class="comment-text">{{ $comment->content }}</p>
            </div>
        </div>
        @empty
        <p class="no-comments-message">まだコメントがありません。</p>
        @endforelse

        @auth
        <div class="comment-form">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <textarea name="content" rows="3" class="comment-textarea" placeholder="商品へのコメントを書く"></textarea>
                @error('content')
                <p class="comment-error-message">{{ $message }}</p>
                @enderror
                <button type="submit" class="comment-submit-button">コメントを送信</button>
            </form>
        </div>
        @endauth
    </div>

</div>
@endsection