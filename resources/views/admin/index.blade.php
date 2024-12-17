@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 16px;
        background-color: #fff;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .pagination a:hover,
    .pagination span:hover {
        background-color: #f1f1f1;
    }

    .pagination .active {
        background-color: #2196F3;
        color: white;
        font-weight: bold;
    }

    .pagination .disabled {
        color: #ccc;
        pointer-events: none;
    }
</style>

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
    <ul class="searchStyle">
        <form method="GET" action="{{ route('admin') }}" class="search-form">
            <input type="text" name="search" placeholder="Введите запрос..." value="{{ request('search') }}"class="form-control" />
            <button type="submit" class="btn btn-primary">Поиск</button>
        </form>
    </ul>
    <ul class="row">
        @foreach($recipes as $recipe)
            <li class="col-md-4 admin-recipe-card">
                <x-dishCard :dish="$recipe" />
                <div class="flex recipe-actions">
                    @if($recipe->status == 'Одобрен')
                        <img src="{{asset('images/approved.svg')}}" alt="Одобрен">
                    @elseif($recipe->status == 'Отклонен')
                        <img src="{{asset('images/delete.svg')}}" alt="Отклонен">
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Пагинация -->
    <div class="pagination">
        {{ $recipes->appends(request()->query())->links() }}
    </div>
</div>
@endsection
