@extends('layouts.app')

@section('content')
<div class="container show">
    <a href="#" class="back-link"><-вернуться назад</a>
    <div class="line-div">
    <h1 class="recipe-title">{{ $recipe->title }}</h1>
    <div class="line"></div>
    </div>
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
    @endif

    <img class="recipe-image" src="{{ asset('storage/' . $recipe->path) }}" alt="Фото рецепта">

    <p class="recipe-description">{{ $recipe->data['description'] }}</p>

    <div class="recipe-info">
        <div class="info-block">
            <p>Время готовки:</p>
            <img src="{{ asset('images/time.svg') }}" alt="Время готовки">
            <p>{{ $recipe->data['cooking_time'] ?? 'Время приготовления не указана' }}</p>
        </div>
        <div class="info-block">
            <p>Рейтинг:</p>
            <img src="{{ asset('images/rating.svg') }}" alt="Рейтинг">
            <p>{{ isset($averageRatings[$recipe->id]) ? $averageRatings[$recipe->id].'/5' : 'Нет оценок' }}</p>
        </div>
        <div class="info-block">
            <p>Калорийность:</p>
            <img src="{{ asset('images/calories.svg') }}" alt="Калории">
            <p>{{ $recipe->data['calorie'] ?? 'Калорийность не указана' }} ккал</p>
        </div>
        <div class="info-block">
            <p>Сложность:</p>
            <img src="{{ asset('images/santa.svg') }}" alt="Сложность">
            <p>{{ $recipe->complexity }}</p>
        </div>
    </div>

    <h2>Ингредиенты:</h2>
    <div class="ingredients">
        <ul>
            @foreach ($recipe->data['ingredients'] as $ingredient)
                <li>{{ $ingredient['name'] }} - {{$ingredient['quantity']}} {{$ingredient['unit']}}</li>
            @endforeach
        </ul>
    </div>

    <h2>Приготовление:</h2>
    <div class="steps">
        <ol>
            @foreach ($recipe->data['steps'] as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ol>
    </div>

    <h3>Оценить:</h3>
    <div class="rating">
        @if(Auth::check() && Auth::user()->role == 'user')
            <form method="POST" action="{{ route('ratings_store') }}">
                @csrf
                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
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
    </div>

    <div class="author">
        <img src="{{ asset($recipe->image_author) }}" alt="Автор">
        <h4>{{ $recipe->user->name }}</h4>
    </div>
</div>
@endsection
