@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/edit.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h2>商品情報を編集</h2>

    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name', $item->name) }}" required>

        <label>商品説明</label>
        <textarea name="description" required>{{ old('description', $item->description) }}</textarea>

        <label>現在の画像</label><br>
        <img src="{{ asset('storage/' . $item->image_path) }}" class="current-image" alt="current image"><br>

        <label>カテゴリ（複数選択可）</label>
        <select name="categories[]" multiple>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <label>商品の状態</label>
        <select name="condition">
            <option value="new" {{ $item->condition === 'new' ? 'selected' : '' }}>新品</option>
            <option value="used" {{ $item->condition === 'used' ? 'selected' : '' }}>中古</option>
            <option value="other" {{ $item->condition === 'other' ? 'selected' : '' }}>その他</option>
        </select>

        <label>価格</label>
        <input type="number" name="price" value="{{ old('price', $item->price) }}" required>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection