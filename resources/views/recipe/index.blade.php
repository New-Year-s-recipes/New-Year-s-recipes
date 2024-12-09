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
                        <p>Мы предоставляем любителям кулинарии наши невообразимые рецепты и полезные советы. Пробуйте и совершенствуйтесь! </p>
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
                                <img src="{{ asset('storage/' . $recipe->path) }}" alt="dish" class="dish-images">
                                <div class="item__dishes_slider">
                                    <div class="item-info__dishes_slider">
                                        <span>РЕЦЕПТ</span>
                                        <p>{{ $recipe->title}}</p>
                                    </div>
                                    @if(Auth::check() && Auth::user()->role == 'user')
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
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="dishes-slider hidden-slider">
                    @foreach($hots as $recipe)
                        <li>
                            <a href="{{route('recipesPage', $recipe->id)}}">
                                <img src="{{ asset('storage/' . $recipe->path) }}" alt="dish" class="dish-images">
                                <div class="item__dishes_slider">
                                    <div class="item-info__dishes_slider">
                                        <span>РЕЦЕПТ</span>
                                        <p>{{ $recipe->title}}</p>
                                    </div>
                                    @if(Auth::check() && Auth::user()->role == 'user')
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
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="dishes-slider hidden-slider">
                    @foreach($deserts as $recipe)
                        <li>
                            <a href="{{route('recipesPage', $recipe->id)}}">
                                <img src="{{ asset('storage/' . $recipe->path) }}" alt="dish" class="dish-images">
                                <div class="item__dishes_slider">
                                    <div class="item-info__dishes_slider">
                                        <span>РЕЦЕПТ</span>
                                        <p>{{ $recipe->title}}</p>
                                    </div>
                                    @if(Auth::check() && Auth::user()->role == 'user')
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
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="dishes-slider hidden-slider">
                    @foreach($colds as $recipe)
                        <li>
                            <a href="{{route('recipesPage', $recipe->id)}}">
                                <img src="{{ asset('storage/' . $recipe->path) }}" alt="dish" class="dish-images">
                                <div class="item__dishes_slider">
                                    <div class="item-info__dishes_slider">
                                        <span>РЕЦЕПТ</span>
                                        <p>{{ $recipe->title}}</p>
                                    </div>
                                    @if(Auth::check() && Auth::user()->role == 'user')
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
                            <img src=" {{ asset('storage/' . $adviceOfTheDay->image_path) }}" alt="advice-image">
                            <div class="author">
                                <img src="{{  asset('storage/' . $adviceOfTheDay->user->path) }}" alt="author">
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
