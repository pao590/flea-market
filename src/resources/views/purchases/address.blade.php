@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/address.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h2>お届け先住所の変更</h2>

    <form action="#" method="POST">
        @csrf
        <div class="form-group">
            <label for="address">新しい住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}" required>
            @error('address')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">住所を保存する</button>
    </form>
</div>
@endsection