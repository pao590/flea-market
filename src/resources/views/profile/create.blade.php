@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypages/edit.css') }}">
@endsection

@section('content')
<div class="container max-w-xl mx-auto">
    <h2 class="text-xl font-bold text-center mb-6">プロフィール設定</h2>

    @if ($errors->any())
    <div class="validation-errors mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('profile.setup.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex items-center space-x-4 mb-4">
            <img src="{{ asset('storage/profiles/default-profile.png') }}"
                class="rounded-full w-24 h-24 object-cover" alt="プロフィール画像">
            <input type="file" name="profile_image" class="text-orange-500">
        </div>

        <div class="mb-4">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>郵便番号</label>
            <input type="text" name="zipcode" value="{{ old('zipcode') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building') }}" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded w-full">
            登録する
        </button>
    </form>
</div>
@endsection