<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $user->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('passwordField'); // Поле ввода пароля
            const confirmationField = document.getElementById('passwordConfirmationField'); // Контейнер подтверждения

            if (passwordField) {
                passwordField.addEventListener('input', function () {
                    if (passwordField.value.trim() !== '') {
                        confirmationField.style.display = 'flex'; // Показываем поле подтверждения
                    } else {
                        confirmationField.style.display = 'none'; // Скрываем поле подтверждения
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            console.log('Скрипт загружен!'); // Проверка выполнения скрипта
        });
    </script>

</head>
<body class="container" style="padding-top: 20px">
<a href="{{route('profile', ['id' => Auth::user()->id])}}" class="back-link">⟵ вернуться назад</a>
    <div class="new-recipes" style="padding-top: 50px">
        <form action="{{ route('profile_update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="new-recipes-photo">
                <img src="{{ asset('storage/' . $user->path) }}" alt="Фото профиля" style="max-width: 200px;">

                <label>Загрузить новое фото:</label>
                <input type="file" name="photo">
            </div>
            @error('photo')
            <div><p>{{ $message }}</p></div>
            @enderror

            <fieldset class="form-input">
                <label>Имя:</label>
                <input type="text" name="name" value="{{ $user->name }}" placeholder="Название совета" required>
                @error('name')
                <div><p>{{ $message }}</p></div>
                @enderror

                <label>Пароль:</label>
                <input type="password" id="passwordField" name="password" placeholder="Пароль">
                @error('password')
                <div><p>{{ $message }}</p></div>
                @enderror

                <div id="passwordConfirmationField" class="confirm" style="display: none;">
                    <label>Подтвердите пароль:</label>
                    <input type="password" name="password_confirmation" placeholder="Подтвердите пароль">
                    @error('password_confirmation')
                    <div><p>{{ $message }}</p></div>
                    @enderror
                </div>

            </fieldset>

            <button type="submit" class="btn-success">Обновить профиль</button>
        </form>
    </div>

    <script>

        @if(session('success'))
        alert('{{ session('success') }}');
        @endif

        @if (session('error'))
        alert('{{ session('error') }}');
        @endif

        // превью изображния
        const photoInput = document.getElementById('photoInput-edit');
        const imagePreview = document.getElementById('imagePreview-edit');

        photoInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
