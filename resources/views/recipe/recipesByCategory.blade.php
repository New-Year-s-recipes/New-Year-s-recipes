@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="line-div">
            <h1 class="title">{{$category}}</h1>
            <div class="line"></div>
        </div>
        <ul class="row">
            @foreach ($dishes as $dish)
                <li class="col-md-4">
                    <x-dishCard :dish="$dish"/>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
