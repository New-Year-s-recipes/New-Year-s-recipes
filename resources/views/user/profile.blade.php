<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <a href="{{route('logout')}}">Выйти</a>
    <a href="{{ route('homePage') }}">Перейти на главную</a>
    <div>
        <form action="{{route('recipes_store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label>Название рецепта:</label>
            <input type="text" name="title" placeholder="Название рецепта" required>
            @error('title')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Описание:</label>
            <input type="text" name="description" placeholder="Описание" required>
            @error('description')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Время приготовления:</label>
            <input type="time" name="cooking_time" placeholder="Время приготовления" required>
            @error('cooking_time')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Калорийность:</label>
            <input type="number" name="calorie" min="0" placeholder="Введите кол-во калорий" required>
            @error('calorie')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Сложность:</label>
            <select name="complexity">
                <option value="Высокая">Высокая</option>
                <option value="Средняя">Средняя</option>
                <option value="Низкая">Низкая</option>
            </select>
            @error('complexity')
            <div>
                <p>{{$message}}</p>
            </div>
            @enderror

            <label>Категория:</label>
            <select name="category">
                <option value="Горячее">Горячее</option>
                <option value="Холодное">Холодное</option>
                <option value="Десерт">Десерт</option>
            </select>
            @error('category')
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

            <label>Изображение:</label>
            <input type="file" name="photo" required>
            @error('photo')
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
                    <img src="{{ asset('storage/' . $recipe->path) }}" alt="Uploaded Photo">
                    <h1>Рецепт: {{ $recipe->title }}</h1>
                    <p>Описание: {{ $recipe->data['description'] ?? 'Описание отсутствует' }}</p>
                    <p>Сложность: {{ $recipe->complexity }}</p>
                    <p>Калорийность: {{ $recipe->data['calorie'] ?? 'Калорийность не указана' }}</p>
                    <p>Категория: {{ $recipe->category }}</p>
                    <p>Время приготовления:{{ $recipe->data['cooking_time'] ?? 'Время приготовления не указана' }}</p>
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
