@extends('layouts.app')
@section('content')
    <a href="{{ route('profile' ,  ['id' => Auth::user()->id])}}">Профиль</a>
    <form action="{{ route('recipes_edit', ['id' => $recipe->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" value="{{ $recipe->title }}" required>
        @error('title')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <label>Описание:</label>
        <input type="text" name="description" value="{{ $recipe->data['description'] ?? 'Описание отсутствует' }}" required>
        @error('description')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <input type="time" name="cooking_time" value="{{ $recipe->data['cooking_time'] }}" required>
        @error('cooking_time')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <label>Калорийность:</label>
        <input type="number" name="calorie" min="0" value="{{ $recipe->data['calorie'] ?? 'Калорийность не указана' }}" required>
        @error('calorie')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label>Сложность:</label>
        <select name="complexity">

            <option value="Высокая" @if($recipe->complexity=="Высокая") selected @endif>
                Высокая
            </option>
            <option value="Средняя" @if($recipe->complexity=="Средняя") selected @endif>
                Средняя
            </option>
            <option value="Низкая" @if($recipe->complexity=="Низкая") selected @endif>
                Низкая
            </option>
        </select>
        @error('complexity')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label>Категория:</label>
        <select name="category">
            <option value="Горячее" @if($recipe->category=="Горячее") selected @endif>Горячее</option>
            <option value="Холодное" @if($recipe->category=="Холодное") selected @endif>Холодное</option>
            <option value="Десерт" @if($recipe->category=="Десерт") selected @endif>Десерт</option>
        </select>
        @error('category')
        <div>
            <p>{{$message}}</p>
        </div>
        @enderror

        <label>Ингредиенты:</label>
        <textarea name="ingredients" required>{{ implode("\n", array_column($recipe->data['ingredients'], 'name')) }}</textarea>
        @error('ingredients')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <label>Шаги:</label>
        <textarea name="steps" placeholder="Шаги приготовления: один на строку" required>{{ implode("\n", $recipe->data['steps']) }}</textarea>
        @error('steps')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <label>Текущее фото:</label>
        <img src="{{ asset('storage/' . $recipe->path) }}" alt="Фото рецепта" style="max-width: 200px;">

        <label>Загрузить новое фото:</label>
        <input type="file" name="photo">
        @error('photo')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <button type="submit">Обновить рецепт</button>
    </form>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{session('error')}}</div>
    @endif
@endsection
