<?php
use Illuminate\Support\Facades\Auth;?>
@extends('layouts.app')
@section('content')
    <div class="container m-t">
        <div>
            <ul class="row">
                @foreach($tips as $tip)
                    <li class="my-recipe">
                        <div class="recipe-actions">
                            <a href="{{ route('tips_edit_show', ['id' => $tip->id])}} ">
                                <img src="{{asset('images/edit.svg')}}" alt="Изменить">
                            </a>
                            <a href="{{ route('tips_destroy', ['id' => $tip->id])}} ">
                                <img src="{{asset('images/delete.svg')}}" alt="Удалить">
                            </a>
                        </div>

                        <x-tipCard :tip="$tip"/>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
