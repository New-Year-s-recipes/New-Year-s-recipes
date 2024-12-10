<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <div>
        @if(Auth::check() && Auth::user()->role == 'user')
            @if(Auth::user()->favorites->contains($recipe->id))
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
            <form method="POST" action="{{ route('ratings_store') }}">
                @csrf
                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                <label for="rating">Оцените товар:</label>

                <div class="stars">
                    <input type="radio" id="star5-{{ $recipe->id }}" name="rating" value="5"
                           @if(isset($userRatings) && $userRatings->rating == 5) checked @endif />
                    <label for="star5-{{ $recipe->id }}" title="5 stars">&#9733;</label>

                    <input type="radio" id="star4-{{ $recipe->id }}" name="rating" value="4"
                           @if(isset($userRatings) && $userRatings->rating == 4) checked @endif />
                    <label for="star4-{{ $recipe->id }}" title="4 stars">&#9733;</label>

                    <input type="radio" id="star3-{{ $recipe->id }}" name="rating" value="3"
                           @if(isset($userRatings) && $userRatings->rating == 3) checked @endif />
                    <label for="star3-{{ $recipe->id }}" title="3 stars">&#9733;</label>

                    <input type="radio" id="star2-{{ $recipe->id }}" name="rating" value="2"
                           @if(isset($userRatings) && $userRatings->rating == 2) checked @endif />
                    <label for="star2-{{ $recipe->id }}" title="2 stars">&#9733;</label>

                    <input type="radio" id="star1-{{ $recipe->id }}" name="rating" value="1"
                           @if(isset($userRatings) && $userRatings->rating == 1) checked @endif />
                    <label for="star1-{{ $recipe->id }}" title="1 star">&#9733;</label>
                </div>

                <button type="submit">Оценить</button>
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
                <li>{{ $ingredient['name'] }} - {{$ingredient['quantity']}} {{$ingredient['unit']}}</li>
            @endforeach
        </ul>
        <p>Шаги:</p>
        <ol>
            @foreach ($recipe->data['steps'] as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ol>
    </div>
@endsection

