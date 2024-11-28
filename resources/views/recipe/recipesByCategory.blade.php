@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="title">{{$category}}</h1>
        <div class="line"></div>
        <div class="arrow"></div>
        <ul class="row">
            @foreach ($dishes as $dish)
                <li class="col-md-4">
                    <x-dishCard :dish="$dish"/>
                </li>
            @endforeach
        </ul>
        <a href="#" class="btn btn-success">Посмотреть больше</a>
    </div>
@endsection
