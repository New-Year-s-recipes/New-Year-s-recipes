<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <div class="container m-t">
        <div class="line-div">
            <h1>Избранные рецепты</h1>
            <div class="line"></div>
        </div>
        <ul class="row">
            @foreach($recipes as $recipe)
                <li class="my-recipe">
                    <div class="recipe-actions">
                            <form action="{{ route('favorite.remove', $recipe->id) }}" method="POST">
                                @csrf
                                <button class="favorite-remove-btn" type="submit"><img src="{{asset('images/favorite.svg')}}" alt="Удалить из избранного"></button>
                            </form>
                    </div>
                        <x-dishCard :dish="$recipe"/>
                </li>
            @endforeach

        </ul>
    </div>
@endsection

