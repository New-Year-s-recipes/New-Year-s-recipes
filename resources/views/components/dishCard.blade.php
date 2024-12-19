@props(['dish'])

<a class="card" href="{{route('recipesPage', $dish->id)}}">
    <img src="{{ asset('/' . $dish->path) }}" alt="Uploaded Photo">
    <div class="card-body">
        <h5>{{ $dish->title }}</h5>
        <p>{{ $dish->mini_description}}</p>
        <div class="card-icons">
            <div class="card-icon">
                <img src="{{ asset('images/time.svg') }}" alt="Время приготовления">
                @php
                    $cookingHours = $dish->data['cooking_time'] ? explode(':', $dish->data['cooking_time'])[0] : 0;
                    $cookingMinutes = $dish->data['cooking_time'] ? explode(':', $dish->data['cooking_time'])[1] : 0;
                @endphp

                @if($cookingHours > 0)
                    <span> ~{{ $cookingHours }} часa</span>
                @else
                    <span>{{ $cookingMinutes }} минут</span>
                @endif
            </div>

            <div class="card-icon">
                <img src="{{ asset('images/santa.svg') }}" alt="Сложность">
                <span>{{ $dish->complexity }}</span>
            </div>
        </div>
    </div>
</a>
