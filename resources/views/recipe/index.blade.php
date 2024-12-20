<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
<div>
    <header>
        <div class="container">
            <section class="header">
                <div class="header-content">
                    <h1>Новогодние рецепты и кулинарные советы</h1>
                    <p>Мы предоставляем любителям кулинарии наши невообразимые рецепты и полезные советы. Пробуйте и
                        совершенствуйтесь! </p>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/main.png') }}" alt="main-image">
                </div>
            </section>
        </div>
    </header>

    <section class="dishes">
        <div class="container">
            <div class="dishes__wrapper">
                <div class="image-wrapper__dishes">
                    <a href="{{route('recipesByCategory', $category = 'Горячее')}}">
                        <img src="{{ asset('images/first-dish.png') }}" alt="first-dish">
                    </a>
                    <span>Горячие блюда </span>
                </div>
                <div class="image-wrapper__dishes">
                    <a href="{{route('recipesByCategory', $category = 'Холодное')}}">
                        <img src="{{ asset('images/second-dish.png') }}" alt="second-dish">
                    </a>
                    <span>Холодные блюда</span>
                </div>
                <div class="image-wrapper__dishes">
                    <a href="{{route('recipesByCategory', $category = 'Десерты')}}">
                        <img src="{{ asset('images/third-dish.png') }}" alt="third-dish">
                    </a>
                    <span>Десерты</span>
                </div>
            </div>
        </div>
        <div class="lights">
            <div class="lights-wrapper"></div>
        </div>
    </section>

    <section class="popular">
        <div class="container">
            <div class="popular-wrapper">
                <h2>ПОПУЛЯРНЫЕ БЛЮДА</h2>
                <ul class="categories">
                    <li class="item__category">Все</li>
                    <li class="item__category">Горячее</li>
                    <li class="item__category">Десерты</li>
                    <li class="item__category">Холодное</li>
                </ul>
            </div>

            <ul class="dishes-slider">
                @foreach($popularRecipes as $recipe)
                    <li>
                        <a href="{{route('recipesPage', $recipe->id)}}">
                            <img src="{{ asset('/' . $recipe->path) }}" alt="dish" class="dish-images">
                            <div class="item__dishes_slider">
                                <div class="item-info__dishes_slider">
                                    <span>РЕЦЕПТ</span>
                                    <p>{{ $recipe->title}}</p>
                                </div>
                                @if(Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'expert'))
                                    @if(Auth::user()->favorites->contains($recipe->id))
                                        <!-- Удалить из избранного -->
                                        <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/favorite.svg')}}"
                                                    alt="Удалить из избранного"></button>
                                        </form>
                                    @else
                                        <!-- Добавить в избранное -->
                                        <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/unfavorite.svg')}}"
                                                    alt="Добавить в избранное"></button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="dishes-slider hidden-slider">
                @foreach($hots as $recipe)
                    <li>
                        <a href="{{route('recipesPage', $recipe->id)}}">
                            <img src="{{ asset('/' . $recipe->path) }}" alt="dish" class="dish-images">
                            <div class="item__dishes_slider">
                                <div class="item-info__dishes_slider">
                                    <span>РЕЦЕПТ</span>
                                    <p>{{ $recipe->title}}</p>
                                </div>
                                @if(Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'expert'))
                                    @if(Auth::user()->favorites->contains($recipe->id))
                                        <!-- Удалить из избранного -->
                                        <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/favorite.svg')}}"
                                                    alt="Удалить из избранного"></button>
                                        </form>
                                    @else
                                        <!-- Добавить в избранное -->
                                        <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/unfavorite.svg')}}"
                                                    alt="Добавить в избранное"></button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="dishes-slider hidden-slider">
                @foreach($deserts as $recipe)
                    <li>
                        <a href="{{route('recipesPage', $recipe->id)}}">
                            <img src="{{ asset('/' . $recipe->path) }}" alt="dish" class="dish-images">
                            <div class="item__dishes_slider">
                                <div class="item-info__dishes_slider">
                                    <span>РЕЦЕПТ</span>
                                    <p>{{ $recipe->title}}</p>
                                </div>
                                @if(Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'expert'))
                                    @if(Auth::user()->favorites->contains($recipe->id))
                                        <!-- Удалить из избранного -->
                                        <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/favorite.svg')}}"
                                                    alt="Удалить из избранного"></button>
                                        </form>
                                    @else
                                        <!-- Добавить в избранное -->
                                        <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/unfavorite.svg')}}"
                                                    alt="Добавить в избранное"></button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="dishes-slider hidden-slider">
                @foreach($colds as $recipe)
                    <li>
                        <a href="{{route('recipesPage', $recipe->id)}}">
                            <img src="{{ asset('/' . $recipe->path) }}" alt="dish" class="dish-images">
                            <div class="item__dishes_slider">
                                <div class="item-info__dishes_slider">
                                    <span>РЕЦЕПТ</span>
                                    <p>{{ $recipe->title}}</p>
                                </div>
                                @if(Auth::check() && (Auth::user()->role == 'user' || Auth::user()->role == 'expert'))
                                    @if(Auth::user()->favorites->contains($recipe->id))
                                        <!-- Удалить из избранного -->
                                        <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/favorite.svg')}}"
                                                    alt="Удалить из избранного"></button>
                                        </form>
                                    @else
                                        <!-- Добавить в избранное -->
                                        <form action="{{ route('favorite.add', $recipe->id) }}" method="POST">
                                            @csrf
                                            <button class="favorite-btn" type="submit"><img src="{{asset('images/unfavorite.svg')}}"
                                                    alt="Добавить в избранное"></button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @if(isset($adviceOfTheDay))
        <section class="advice">
            <div class="container advice-container">
                <div class="advise-wrapper">
                    <h2>СОВЕТ ДНЯ</h2>
                    <div class="content__advice">
                        <div class="text__advice">
                            <h5>{{$adviceOfTheDay->title}}</h5>
                            <p>{{$adviceOfTheDay->text}}</p>
                        </div>
                        <div class="image-wrapper__advice">
                            <img class="advice-img" src=" {{ asset('/' . $adviceOfTheDay->image_path) }}"
                                alt="advice-image">
                            <div class="author">
                                <img src="{{  asset('/' . $adviceOfTheDay->user->path) }}" alt="author">
                                <div class="author__content">
                                    <span class="name">{{$adviceOfTheDay->user->name}}</span>
                                    <span class="author-class">Эксперт</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

<section class="expert-advice">
    <div class="container">
        <h2>СОВЕТЫ ЭКСПЕРТОВ</h2>
        <ul class="expert-advice-slider">
            @foreach($tips as $tip)
                <li>
                    <a href="{{ route('tips.show', $tip->id) }}">
                        <div class="expert-advice-icon">
                            <img src="{{ asset('/' . $tip->image_path) }}" alt="{{ $tip->title }}">
                        </div>
                        <div class="item__dishes_slider">
                            <div class="item-info__dishes_slider">
                                <span>КУХОННАЯ РАЗВЕДКА</span>
                                <p>{{ $tip->title }}</p>
                            </div>

                            <img src="{{ asset('images/christmas.png') }}" alt="Декор">

                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="expert-advice-btn">
            <a href="{{ route('tips.index') }}"><button type="submit">Посмотреть все</button></a>
        </div>
    </div>
</section>


<div class="cont">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-wrapper">
        <div class="image left-image">
            <img src="{{ asset('images/mrn.png') }}" alt="Изображение 1">
        </div>
        <form class="recipe-form" action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <h2>ОСТАЛИСЬ ВОПРОСЫ?</h2>
            <h3>Напишите нам свои жалобы или пожелания</h3>
            <input type="text" name="name" placeholder="ФИО" required>
            <input type="email" name="email" placeholder="Почта" required>
            <textarea name="comments" placeholder="Комментарии" required></textarea>
            <button class="click-form" type="submit">Добавить</button>
        </form>
        <div class="image right-image">
            <img src="{{ asset('images/chicken.png') }}" alt="Изображение 2">
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/category-slider.js') }}"></script>
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