@props(['dish'])

<div class="card">
    <a href="{{route('recipesPage', $dish->id)}}">
        <img src="{{ asset('storage/' . $dish->path) }}" alt="Uploaded Photo">
        <div class="card-body">
            <h5>{{ $dish->title }}</h5>
            <p>{{ $dish->mini_description}}</p>

            <div class="time">
                <img src="{{ asset('images/time.svg') }}" alt="Время приготовления" style="width: 20px; height: 20px;">
                <span>{{ $dish->data['cooking_time'] ?? 'Время приготовления не указана' }}</span>
            </div>

            <div class="difficulty">
                <img src="{{ asset('images/santa.svg') }}" alt="Сложность" style="width: 20px; height: 20px;">
                <span>{{ $dish->complexity }}</span>
            </div>
        </div>
    </a>

</div>
