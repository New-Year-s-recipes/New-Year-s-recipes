@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <div class="container mt-4 m-t">
        <div class="user-info">
            <h2>{{Auth::user()->name}}</h2>
            <p>{{Auth::user()->email}}</p>
            <div>
                <a href="{{route('logout')}}" class="btn-logout">Выйти</a>
            </div>
        </div>
        <ul class="user-action">
            <li><a class="btn-success" href="{{route('admin', $status = 'all')}}">Все</a></li>
            <li><a class="btn-success" href="{{route('admin', $status = "На рассмотрении")}}">Новые</a></li>
            <li><a class="btn-success" href="{{route('admin', $status = "Одобрен")}}">Одобрено</a></li>
            <li><a class="btn-success" href="{{route('admin', $status = "Отклонен")}}">Отклонен</a></li>
        </ul>
        <ul class="row">
            @foreach($recipes as $recipe)
                <li class="col-md-4 admin-recipe-card">
                    <x-dishCard :dish="$recipe"/>
                    <div class="flex recipe-actions">
                        @if($recipe->status == 'Одобрен')
                            <img src="{{asset('images/approved.svg')}}" alt="Одобрен">
                        @elseif($recipe->status == 'Отклонен')
                            <img src="{{asset('images/delete.svg')}}" alt="Одобрен">
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
