@props(['dish'])

<a class="card" href="{{route('recipesPage', $dish->id)}}">
    <img src="{{ asset('storage/' . $dish->path) }}" alt="Uploaded Photo">
    <div class="card-body">
        <h5>{{ $dish->title }}</h5>
        <p>{{ $dish->mini_description}}</p>
        <div class="card-icons">
            <div class="card-icon">
                <img src="{{ asset('images/time.svg') }}" alt="Время приготовления">
                <span>{{ $dish->data['cooking_time'] ?? 'Время приготовления не указана' }}</span>
            </div>

            <div class="card-icon">
                <img src="{{ asset('images/santa.svg') }}" alt="Сложность">
                <span>{{ $dish->complexity }}</span>
            </div>
        </div>
    </div>
</a>
