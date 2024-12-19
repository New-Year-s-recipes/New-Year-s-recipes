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
                @if(Auth::check())
                    @if($userRating)
                        <div class="alert alert-info">
                            Вы уже оставили оценку: {{ $userRating->rating }} звёзд. Вы можете изменить её.
                        </div>
                    @endif
                
                    <form action="{{ route('tips.council_evaluation_add', ['id' => $tip->id]) }}" method="POST" id="rating-form">
                        @csrf
                        <div class="form_radio_container">
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="5" id="star5" required class="appointment-radio" 
                                    @if($userRating && $userRating->rating == 5) checked @endif>
                                <label for="star5" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="4" id="star4" required class="appointment-radio"
                                    @if($userRating && $userRating->rating == 4) checked @endif>
                                <label for="star4" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="3" id="star3" required class="appointment-radio"
                                    @if($userRating && $userRating->rating == 3) checked @endif>
                                <label for="star3" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="2" id="star2" required class="appointment-radio"
                                    @if($userRating && $userRating->rating == 2) checked @endif>
                                <label for="star2" class="appointment-label-radio">☆</label>
                            </div>
                            <div class="form_radio_btn">
                                <input type="radio" name="rating" value="1" id="star1" required class="appointment-radio"
                                    @if($userRating && $userRating->rating == 1) checked @endif>
                                <label for="star1" class="appointment-label-radio">☆</label>
                            </div>
                        </div>
                        <button type="submit">Сохранить</button>
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
                @else
                    <p>Вы должны <a href="{{ route('loginPage') }}">войти</a>, чтобы оставить оценку.</p>
                @endif
            
                <!-- Отображение средней оценки -->
                <div class="average-rating">
                    <h2>Средняя оценка совета: 
                        @if($averageRating)
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star @if($i <= $averageRating) filled @endif">☆</span>
                            @endfor
                            ({{ $averageRating }})
                        @else
                            Нет оценок
                        @endif
                    </h2>
                </div>
            </div>            
        </div>
    </div>
    <script src="{{ asset('js/go-back.js') }}"></script>
    <script src="{{ asset('js/form-star.js') }}"></script>
</body>

</html>