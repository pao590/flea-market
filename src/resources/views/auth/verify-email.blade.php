@extends('layouts.app')

@section('content')
<div class="container">
    <h2>メール認証が必要です</h2>
    <p>確認リンクがメールアドレスに送信されました。メールを確認してください。</p>

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">確認メールを再送する</button>
    </form>
</div>
@endsection