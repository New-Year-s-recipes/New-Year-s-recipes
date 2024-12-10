<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="form-container">
    <div class="form-content">
        <h1>Вход</h1>
        <form action="{{route('login')}}" method="post">
            @csrf

            <div class="form-input">
                <label for="login-email">Почта:</label>
                <input type="email" id="login-email" name="email" placeholder="Введите почту..." required>
                @error('email')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-input">
                <label for="login-password">Пароль:</label>
                <input type="password" id="login-password" name="password" placeholder="Введите пароль..." required>
                @error('password')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-btn">
                <button type="submit" class="btn-success">Войти</button>
                <a href="{{route('registerPage')}}">Зарегистрироваться</a>
            </div>
            @if(session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>
</div>
</body>
</html>
