<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <div>
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    @if(Auth::check() && Auth::user()->favorites->contains($recipe->id))
                        <!-- Удалить из избранного -->
                        <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                            @csrf
                            <button type="submit">Удалить из избранного</button>
                        </form>
                    @else
                        <!-- Добавить в избранное -->
                        <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                            @csrf
                            <button type="submit">Добавить в избранное</button>
                        </form>
                    @endif
                    <img src="{{ asset('storage/' . $recipe->path) }}" alt="Uploaded Photo">
                    <h1>Рецепт: {{ $recipe->title }}</h1>
                    <p>Рейтинг: {{ isset($averageRatings[$recipe->id]) ? $averageRatings[$recipe->id] : 'Нет оценок' }}</p>
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
                        <a href="{{route('recipesPage', $recipe->id)}}">Подробнее</a>
                </li>
            @endforeach

        </ul>
    </div>
@endsection
