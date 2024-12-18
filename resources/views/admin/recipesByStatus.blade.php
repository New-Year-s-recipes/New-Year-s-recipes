@extends('layouts.app')
@section('content')
    <div class="container mt-4 m-t" >
        <ul>
            <li><a href="{{route('recipe_status', $status = "all")}}">Все</a></li>
            <li><a href="{{route('recipe_status', $status = "На рассмотрении")}}">Новые</a></li>
            <li><a href="{{route('recipe_status', $status = "Одобрен")}}">Одобрено</a></li>
            <li><a href="{{route('recipe_status', $status = "Отклонен")}}">Отклонен</a></li>
        </ul>
        <ul class="row">
            @foreach($recipes as $recipe)
                <li class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('/' . $recipe->path) }}" alt="Uploaded Photo">
                        <div class="card-body">
                            <h5>{{ $recipe->title }}</h5>
                            <p>{{ $recipe->data['description'] ?? 'Описание отсутствует' }}</p>

                            <div class="time">
                                <img src="{{ asset('images/time.svg') }}" alt="Время приготовления" style="width: 20px; height: 20px;">
                                <span>{{ $recipe->data['cooking_time'] ?? 'Время приготовления не указана' }}</span>
                            </div>

                            <div class="difficulty">
                                <img src="{{ asset('images/santa.svg') }}" alt="Сложность" style="width: 20px; height: 20px;">
                                <span>{{ $recipe->complexity }}</span>
                            </div>
                            <div class="flex">
                                @if($recipe->status == 'На рассмотрении')
                                    <a class="btn btn-success" href="{{route('statusApproved', $recipe->id)}}">Одобрить</a>
                                    <a class="btn btn-success" href="{{route('statusRejected', $recipe->id)}}">Отклонить</a>
                                @else
                                    <p>{{$recipe->status}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
