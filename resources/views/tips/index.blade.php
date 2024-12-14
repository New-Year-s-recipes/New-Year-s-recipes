<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tip.css') }}">
    <title>Советы экспертов</title>
</head>

<body>
    <div class="container">
        <button onclick="goBack()" class="back-link">⟵ вернуться назад</button>
        <h1>Советы экспертов</h1>
        <div class="line"></div>
        <div class="arrow"></div>
        <div class="tips-grid">
            @foreach($tips as $tip)
                <div class="tip-card">
                    <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Совет 1" />
                    <h2>{{$tip->title}}</h2>
                    <p>{{ $tip->description }}</p>
                    <a href="{{ route('tips.show', $tip->id) }}" class="details-button">Подробнее</a>
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{ asset('js/go-back.js') }}"></script>
</body>

</html>
