@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/edit.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h2 class="edit-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group image-upload">
            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('storage/profiles/default-profile.png') }}"
                class="image-preview" alt="プロフィール画像">
            <input type="file" name="profile_image">
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="form-button">更新する</button>
    </form>
</div>
@endsection