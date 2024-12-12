<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Новогодние рецепты</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
</head>
<body>
<header>
    <nav class="container">
        <ul class="nav-list">
            <div>
                <li><a href="{{route('homePage')}}">Главная</a></li>
                @if(Auth::check() && Auth::user()->role == 'admin')
                        <li><a href="{{route('admin', $status='all')}}">Администрирование</a></li>
                @endif
                <li><a href="{{route('recipesByCategory', $category = 'Горячее')}}">Горячие блюда</a></li>
                <li><a href="{{route('recipesByCategory', $category = 'Холодное')}}">Холодные блюда</a></li>
                <li><a href="{{route('recipesByCategory', $category = 'Десерты')}}">Десерты</a></li>
                <li><a href="{{route('tips.index')}}">Советы экспертов</a></li>
            </div>


            @if(Auth::check())
                <div>
                @if(Auth::user()->role != 'admin' )
                            <a class="profile" href="{{route('profile', ['id' => Auth::user()->id])}}">
                                <img src="{{ asset('storage/' . Auth::user()->path) }}" alt="Фото профиля">
                                <p>{{Auth::user()->name}}</p>
                            </a>
                @endif
            @else
                <a class="btn-success" href="{{route('loginPage')}}">Войти</a>
                    </div>
            @endif
        </ul>
    </nav>
</header>
<main>
    @yield('content')
</main>

<footer>

</footer>
@yield('scripts')
<script src="{{ asset('js/go-back.js') }}"></script>
</body>
</html>
