<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="logo" type="image/png" href="{{ asset('images/logo.png') }}">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/public/common.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Attendance Management" class="header__logo-image">
                </a>


                <form action="{{ route('items.index') }}" method="GET" class="header-search-form">
                    <input type="hidden" name="tab" value="{{ request('tab', Auth::check() ? 'mylist' : 'recommend') }}">
                    <input type="text" name="keyword" class="header-search-input" placeholder="何をお探しですか？" value="{{ request('keyword') }}">
                    <button type="submit" class="header-search-button"><i class="fas fa-search"></i></button>
                </form>

                <nav>
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('items.create') }}">出品する</a>
                        </li>
                        @auth
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('mypages.index') }}">マイページ</a>
                        </li>
                        <li class="header-nav__item">
                            <form class="form" action="/logout" method="POST">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @endauth

                        @guest
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('login') }}">ログイン</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('register') }}">新規登録</a>
                        </li>
                        @endguest
                    </ul>
                </nav>

            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>