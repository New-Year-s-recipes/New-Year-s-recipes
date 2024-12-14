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
        </div>
    </div>
    <script src="{{ asset('js/go-back.js') }}"></script>
</body>

</html>
