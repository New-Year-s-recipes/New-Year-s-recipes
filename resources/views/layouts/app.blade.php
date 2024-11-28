<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новогодние рецепты</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="{{route('homePage')}}">Главная</a></li>
            @if(Auth::check())
                @if(Auth::user()->role == 'user')
                    <li>
                        <a href="{{route('profile', ['id' => Auth::user()->id])}}">Профиль</a>
                    </li>
                @endif

                @if(Auth::user()->role == 'admin')
                    <li><a href="{{route('admin')}}">Администрирование</a></li>
                @endif
            @else
                <li><a href="{{route('loginPage')}}">Вход</a></li>
            @endif
            <li><a href="{{route('recipesByCategory', $category = 'Горячее')}}">Горячие блюда</a></li>
            <li><a href="{{route('recipesByCategory', $category = 'Холодное')}}">Холодные блюда</a></li>
            <li><a href="{{route('recipesByCategory', $category = 'Десерты')}}">Десерты</a></li>
        </ul>
    </nav>
</header>
<main>
    @yield('content')
</main>

<footer>

</footer>

</body>
</html>
