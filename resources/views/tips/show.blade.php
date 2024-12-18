<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tip.css') }}">
    <title>{{ $tip->title }}</title>
</head>

<body>
    <div class="tip-container">
        <button onclick="goBack()" class="back-link">⟵ вернуться назад</button>
        <h1 class="tip-title">{{ $tip->title }}</h1>
        <div class="tip-content">
            <img class="tip-image" src="{{ asset('storage/' . $tip->image_path) }}" alt="Изображение совета" />
            <div class="tip-details">
                <p class="tip-description">{{ $tip->description }}</p>
                <p class="tip-text">{{ $tip->text }}</p>
            </div>
            <div>
                <h1>Оцените совет эксперта</h1>
                @if(Auth::check() && Auth::user()->role == 'user')
                    <form action="{{ route('tips.council_evaluation_add', ['id' => $tip->id]) }}" method="POST">
                        @csrf
                        <div class="form_radio_container">
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="5" id="star5" required class="appointment-radio">
                                <label for="star5" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="4" id="star4" required class="appointment-radio">
                                <label for="star4" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="3" id="star3" required class="appointment-radio">
                                <label for="star3" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="2" id="star2" required class="appointment-radio">
                                <label for="star2" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="1" id="star1" required class="appointment-radio">
                                <label for="star1" class="appointment-label-radio">☆</label>
                            </div>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                @endif
                @guest
                    <h1>Вы не авторизованы.</h1>
                    <div>
                        <a class="btn-success" href="{{route('loginPage')}}">Войти</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
    <script src="{{ asset('js/go-back.js') }}"></script>
    <script src="{{ asset('js/form-star.js') }}"></script>
</body>

</html>