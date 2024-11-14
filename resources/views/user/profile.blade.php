<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <a href="{{route('logout')}}">Выйти</a>
    <a href="{{ route('homePage') }}">Перейти на главную</a>
    <div>
        <form action="{{route('recipes_store')}}" method="post">
            @csrf
            <input type="text" name="title" placeholder="Название рецепта" required>
            @error('title')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <input type="time" name="cooking_time" placeholder="Время приготовления" required>
            @error('cooking_time')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Ингредиенты:</label>
            <textarea name="ingredients" placeholder="Ингредиенты: один на строку" required></textarea>
            @error('ingredients')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Шаги:</label>
            <textarea name="steps" placeholder="Шаги приготовления: один на строку" required></textarea>
            @error('steps')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <button type="submit">Добавить рецепт</button>
        </form>
    </div>

    <div>
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    <a href="{{ route('recipes_destroy', ['id' => $recipe->id])}} ">Удалить</a>
                    <a href="{{ route('recipes_edit_show', ['id' => $recipe->id])}} ">Изменить</a>
                    <h1>Рецепт: {{ $recipe->title }}</h1>
                    <p>Время приготовления: {{ $recipe->data['cooking_time'] }}</p>
                    <p>Ингредиенты:</p>
                    <ul>
                        @foreach ($recipe->data['ingredients'] as $ingredient)
                            <li>{{ $ingredient['name'] }}</li>
                        @endforeach
                    </ul>
                    <p>Шаги:</p>
                    <ol>
                        @foreach ($recipe->data['steps'] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ol>
                </li>
            @endforeach

        </ul>
    </div>
@endsection
