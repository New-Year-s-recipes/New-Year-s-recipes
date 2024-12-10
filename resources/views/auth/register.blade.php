<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
</head>
<body>
<div class="form-container">
    <div class="form-content">
        <h1>Регистрация</h1>
        <form action="{{route('register')}}" method="post">
            @csrf

            <div class="form-input">
                <label for="register-name">Имя:</label>
                <input type="text" id="register-name" name="name" placeholder="Введите имя..." required>
                @error('name')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-input">
                <label for="register-email">Почта:</label>
                <input type="email" id="register-email" name="email" placeholder="Введите почту..." required>
                @error('email')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-input">
                <label for="register-password">Пароль:</label>
                <input type="password" id="register-password" name="password" placeholder="Введите пароль..." required>
                @error('password')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-input">
                <label for="register-password-confirmation">Подтвердите пароль:</label>
                <input type="password" id="register-password-confirmation" name="password_confirmation" placeholder="Подтвердите пароль..." required>
                @error('password_confirmation')
                <div class="error">
                    <p>{{$message}}</p>
                </div>
                @enderror
            </div>

            <div class="form-btn">
                <button type="submit" class="btn-success">Зарегистрироваться</button>
                <a href="{{route('loginPage')}}">Войти</a>
            </div>


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
