@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@section('content')
<div class="item-create-wrapper">
    <h2 class="item-create-title">商品を出品する</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="item-create-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input">
            @error('name')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">商品説明</label>
            <textarea name="description" id="description" rows="4" class="form-textarea">{{ old('description') }}</textarea>
            @error('description')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="image" class="form-label">商品画像</label>
            <input type="file" name="image" id="image" accept=".jpeg,.jpg,.png" class="form-input-file">
            @error('image')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">カテゴリ（複数選択）</label>
            <div class="category-checkbox-group">
                @foreach ($categories as $category)
                <label class="category-checkbox">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : ''}}>
                    {{ category->name }}
                </label>
                @endforeach
            </div>
            @error('categories')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition" class="form-label">商品の状態</label>
            <select name="condition" id="condition" class="form-select">
                <option value="">選択してください</option>
                <option value="新品" {{ old('condition') == '新品' ? 'selected' : '' }}>新品</option>
                <option value="未使用に近い" {{ old('condition') == '未使用に近い' ? 'selected' : '' }}>未使用に近い</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="全体的に状態が悪い" {{ old('condition') == '全体的に状態が悪い' ? 'selected' : '' }}>全体的に状態が悪い</option>
            </select>
            @error('condition')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label">価格（円）</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-input">
            @error('price')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-submit">
            <button type="submit" class="btn-submit">出品する</button>
        </div>
    </form>
</div>
@endsection