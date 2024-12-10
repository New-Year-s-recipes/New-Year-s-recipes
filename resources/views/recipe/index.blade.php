<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <div>
        <form action="{{route('recipes.search')}}" method="post">
            @csrf
            <input name="searchTerm" type="search"  @if(!empty($searchTerm)) value="{{$searchTerm}}" @endif>
            <button class="btn-success btn">Поиск</button>
        </form>

        <div class="filter-container">
            <button id="toggleFilterButton" class="filter-icon">
                <img src="{{ asset('images/filter-icon.svg') }}" alt="Фильтр">
            </button>


            <form id="filterForm" action="{{ route('recipes.sorting') }}" method="GET" class="hidden filter-form">
                <div>
                    <label for="category">Категория:</label>
                    <select name="category" id="category">
                        <option value="">Все</option>
                        <option value="Горячее" {{ $request->category == 'Горячее' ? 'selected' : '' }}>Горячее</option>
                        <option value="Холодное" {{ $request->category == 'Холодное' ? 'selected' : '' }}>Холодное</option>
                        <option value="Десерты" {{ $request->category == 'Десерты' ? 'selected' : '' }}>Десерты</option>
                    </select>
                </div>

                <div>
                    <label for="complexity">Сложность:</label>
                    <select name="complexity" id="complexity">
                        <option value="">Все</option>
                        <option value="Низкая" {{ $request->complexity == 'Низкая' ? 'selected' : '' }}>Низкая</option>
                        <option value="Средняя" {{ $request->complexity == 'Средняя' ? 'selected' : '' }}>Средняя</option>
                        <option value="Высокая" {{ $request->complexity == 'Высокая' ? 'selected' : '' }}>Высокая</option>
                    </select>
                </div>

                <div>
                    <label for="min_calories">Калорийность:</label>
                    <input type="number" name="min_calories" id="min_calories" placeholder="Мин" value="{{ $request->min_calories }}">
                    <input type="number" name="max_calories" id="max_calories" placeholder="Макс" value="{{ $request->max_calories }}">
                </div>

                <div>
                    <label for="sort_by">Сортировать по:</label>
                    <select name="sort_by" id="sort_by">
                        <option value="cooking_time" {{ $request->sort_by == 'cooking_time' ? 'selected' : '' }}>Времени приготовления</option>
                        <option value="calorie" {{ $request->sort_by == 'calorie' ? 'selected' : '' }}>Калорийности</option>
                    </select>

                    <label for="sort_order">Порядок:</label>
                    <select name="sort_order" id="sort_order">
                        <option value="asc" {{ $request->sort_order == 'asc' ? 'selected' : '' }}>По возрастанию</option>
                        <option value="desc" {{ $request->sort_order == 'desc' ? 'selected' : '' }}>По убыванию</option>
                    </select>
                </div>

                <button type="submit" class="btn-success btn">Применить</button>
            </form>
        </div>



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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggleFilterButton');
            const filterForm = document.getElementById('filterForm');

            toggleButton.addEventListener('click', function () {
                if (filterForm.classList.contains('hidden')) {
                    filterForm.classList.remove('hidden');
                    filterForm.style.display = 'block';
                } else {
                    filterForm.classList.add('hidden');
                    filterForm.style.display = 'none';
                }
            });
        });
    </script>
@endsection
