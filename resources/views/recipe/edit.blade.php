@extends('layouts.app')
@section('content')
    <a href="{{ route('profile' ,  ['id' => Auth::user()->id])}}">Профиль</a>
    <form action="{{ route('recipes_edit', ['id' => $recipe->id]) }}" method="post">
        @csrf
        <input type="text" name="title" value="{{ $recipe->title }}" required>
        @error('title')
        <div>
            <p>{{ $message }}</p>
        </div>
        @enderror

        <input type="time" name="cooking_time" value="{{ $recipe->data['cooking_time'] }}" required>
        @error('cooking_time')
        <div>
            <p>{{ $message }}</p>
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

        <button type="submit">Обновить рецепт</button>
    </form>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{session('error')}}</div>
    @endif
@endsection
