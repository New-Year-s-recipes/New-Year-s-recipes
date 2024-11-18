<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    @if(Auth::check())
        <a href="{{route('profile', ['id' => Auth::user()->id])}}">Профиль</a>
    @endif
    <div>
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    <img src="{{ asset('storage/' . $recipe->path) }}" alt="Uploaded Photo">
                    <h1>Рецепт: {{ $recipe->title }}</h1>
                    <p>Автор: {{ $recipe->user->name }}</p>
                    <p>Описание: {{ $recipe->data['description'] ?? 'Описание отсутствует' }}</p>
                    <p>Сложность: {{ $recipe->complexity }}</p>
                    <p>Калорийность: {{ $recipe->data['calorie'] ?? 'Калорийность не указана' }}</p>
                    <p>Категория: {{ $recipe->category }}</p>
                    <p>Время приготовления: {{ $recipe->data['cooking_time'] ?? 'Время приготовления не указана' }}</p>
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
