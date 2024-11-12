@extends('layouts.app')
@section('content')
    <a href="{{route('loginPage')}}">Войти</a>
    <form action="{{route('register')}}" method="post">
        @csrf
        <label for="register-name">Имя:</label>
        <input type="text" id="register-name" name="name" required>
        @error('name')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label for="register-email">Почта:</label>
        <input type="email" id="register-email" name="email" required>
        @error('email')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label for="register-password">Пароль:</label>
        <input type="password" id="register-password" name="password" required>
        @error('password')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label for="register-password-confirmation">Подтвердите пароль:</label>
        <input type="password" id="register-password-confirmation" name="password_confirmation" required>
        @error('password_confirmation')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <button type="submit">Зарегистрироваться</button>

        @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
    </form>
@endsection
