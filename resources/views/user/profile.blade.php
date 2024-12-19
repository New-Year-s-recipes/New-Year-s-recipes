<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="user-info m-t">
        <div>
            <img src="{{ asset('/' . Auth::user()->path) }}" alt="Фото профиля">
            <h2>{{Auth::user()->name}}</h2>
            <p>{{Auth::user()->email}}</p>
        </div>
        <div class="flex">
            <a class="btn btn-error" href="{{route('logout')}}">Выйти</a>
            <a class="btn btn-success" href="{{route('profile_edit', $id = Auth::user()->id)}}">Изменить</a>
            <a class="btn btn-success" href="{{ route('feedback.index') }}">Обратная связь</a>
        </div>

    </div>
    <div class="user-action">
        <a class="btn-success" href="{{ route('recipes.add') }}">Добавить рецепт</a>
        <a class="btn-success" href="{{ route('favorite') }}">Избранные рецепты</a>
        @if(Auth::user()->role == 'expert')
            <a class="btn-success" href="{{ route('tips.add') }}">Добавить совет</a>
            <a class="btn-success" href="{{ route('myTip') }}">Мои советы</a>
        @endif
    </div>
    <div>
        <ul class="row">
            @foreach($recipes as $recipe)
                <li class="my-recipe">
                    <div class="recipe-actions">
                        <a href="{{ route('recipes_edit_show', ['id' => $recipe->id])}} ">
                            <img src="{{asset('images/edit.svg')}}" alt="Изменить">
                        </a>
                        <a href="{{ route('recipes_destroy', ['id' => $recipe->id])}} ">
                            <img src="{{asset('images/delete.svg')}}" alt="Удалить">
                        </a>
                    </div>

                    <x-dishCard :dish="$recipe" />
                </li>
            @endforeach
        </ul>
    </div>
</div>


@endsection