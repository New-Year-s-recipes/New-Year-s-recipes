<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipe->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container show m-t">
        <button onclick="goBack()" class="back-link">⟵ вернуться назад</button>
        <div class="line-div">
            <h1 class="recipe-title">{{ $recipe->title }}</h1>
            <div class="line"></div>
        </div>
        @if(Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'expert'))
            @if(Auth::user()->favorites->contains($recipe->id))
                <!-- Удалить из избранного -->
                <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                    @csrf
                    <button class="favorite-btn" type="submit"><img src="{{asset('images/favorite.svg')}}" alt="Удалить из избранного"></button>
                </form>
            @else
                <!-- Добавить в избранное -->
                <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                    @csrf
                    <button class="favorite-btn" type="submit"><img src="{{asset('images/unfavorite.svg')}}" alt="Добавить в избранное"></button>
                </form>
            @endif
        @endif
        <div>
            <img class="recipe-image" src="{{ asset('storage/' . $recipe->path) }}" alt="Фото рецепта">
            <p class="recipe-description">{{ $recipe->data['description'] }}</p>
        </div>

        <div class="recipe-info">
            <div class="info-block">
                <img src="{{ asset('images/time.svg') }}" alt="Время готовки">
                <div>
                    <p>Время готовки:</p>
                    @php
                        $cookingHours = $recipe->data['cooking_time'] ? explode(':', $recipe->data['cooking_time'])[0] : 0;
                        $cookingMinutes = $recipe->data['cooking_time'] ? explode(':', $recipe->data['cooking_time'])[1] : 0;
                    @endphp

                    @if($cookingHours > 0)
                        <span>{{ $cookingHours }} часов {{ $cookingMinutes }} минут</span>
                    @else
                        <span>{{ $cookingMinutes }} минут</span>
                    @endif
                </div>
            </div>
            <div class="info-block">
                <img src="{{ asset('images/rating.svg') }}" alt="Рейтинг">
                <div>
                    <p>Рейтинг:</p>
                    <span>{{ isset($averageRatings[$recipe->id]) ? $averageRatings[$recipe->id].'/5' : 'Нет оценок' }}</span>
                </div>
            </div>
            <div class="info-block">
                <img src="{{ asset('images/calories.svg') }}" alt="Калории">
                <div>
                    <p>Калорийность:</p>
                    <span>{{ $recipe->data['calorie'] ?? 'Калорийность не указана' }} ккал</span>
                </div>
            </div>
            <div class="info-block">
                <img src="{{ asset('images/santa.svg') }}" alt="Сложность">
                <div>
                    <p>Сложность:</p>
                    <span>{{ $recipe->complexity }}</span>
                </div>
            </div>
        </div>

        <div class="recipe-info-cook">
            <h2 class="recipe-info-h2">Как приготовить {{ $recipe->title }}</h2>

            <div class="ingredients">
                <h3>Ингредиенты:</h3>
                <ul>
                    @foreach ($recipe->data['ingredients'] as $ingredient)
                        <li>{{ $ingredient['name'] }} - {{$ingredient['quantity']}} {{$ingredient['unit']}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="steps">
    <h3>Шаги приготовления:</h3>
    <ol>
        @foreach ($recipe->steps as $step)
            <li>
                <p>{{ $step->description }}</p>
                @if($step->photo)
                <img src="{{ asset('storage/' . $step->photo) }}" alt="Фото шага" class="step-photo">
                @endif
            </li>
        @endforeach
    </ol>
</div>  
        </div>

        <div class="recipe-add-info">
            @if(Auth::check() && (Auth::user()->role == 'user' ||Auth::user()->role == 'expert' ))
                <div class="rating">
                    <h3>Оценить:</h3>
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

                        <button type="submit" class="btn-success">Оценить</button>
                    </form>
                </div>

            @elseif(Auth::check() && Auth::user()->role == 'admin')
                <div class="flex">
                    @if($recipe->status == 'На рассмотрении')
                        <a class="btn btn-success" href="{{route('statusApproved', $recipe->id)}}">Одобрить</a>
                        <a class="btn btn-error" href="{{route('statusRejected', $recipe->id)}}">Отклонить</a>
                    @else
                        <p>{{$recipe->status}}</p>
                    @endif
                </div>
            @endif
            <div class="author">
                <img src="{{ asset('/' . $recipe->user->path) }}" alt="Автор">
                <div>
                    <h4>{{ $recipe->user->name }}</h4>
                    <p>Автор</p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/go-back.js') }}"></script>
</body>
</html>
