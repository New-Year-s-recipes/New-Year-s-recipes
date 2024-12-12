@extends('layouts.app')

@section('content')
    <div class="container show m-t">
        <div>
            <img class="recipe-image" src="{{ asset('storage/' . $tip->image_path) }}" alt="Фото совета">
            <h2>{{$tip->title}}</h2>
            <p class="recipe-description">{{ $tip->description }}</p>
            <p>{{ $tip->text }}</p>
        </div>
        <div class="author">
            <img src="{{ asset($tip->image_author) }}" alt="Автор">
            <div>
                <h4>{{ $tip->user->name }}</h4>
                <p>Автор</p>
            </div>
        </div>
    </div>
@endsection
