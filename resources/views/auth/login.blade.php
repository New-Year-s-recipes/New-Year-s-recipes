@extends('layouts.app')
@section('content')
    <a href="{{route('registerPage')}}">Зарегистрироваться</a>
    <form action="{{route('login')}}" method="post">
        @csrf
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

        <button type="submit">Войти</button>

        @if(session('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif
    </form>
@endsection
