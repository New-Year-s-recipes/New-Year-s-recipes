<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление совета</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="container" style="padding-top: 20px">
<a href="{{route('profile', ['id' => Auth::user()->id])}}" class="back-link">⟵ вернуться назад</a>
<div class="new-recipes" style="padding-top: 50px">
<form action="{{ route('tips_store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="new-recipes-photo">
                    <input id="photoInput" type="file" name="photo" accept="image/jpeg, image/jpg, image/png" hidden>
                    <img id="imagePreview" src="{{asset('images/new-photo.svg')}}" alt="new-photo" style="max-width: 100%; height: auto; display: block;">
                    <div id="instructionText">
                        <p >Выберите изображение на вашем устройстве или перетащите его в эту область.</p>
                        <span class="dropzone_button__wcBP7" onclick="document.getElementById('photoInput').click();">
                            Загрузить обложку совета
                            <img src="{{asset('images/plus.svg')}}" alt="plus">
                        </span>
                        <p>Пожалуйста, используйте только свои авторские фотографии. Допустимые форматы фотографий для загрузки: JPEG, JPG, PNG</p>
                    </div>
                </label>
                @error('photo')
                <div class="error"><p>{{ $message }}</p></div>
                @enderror
            </div>

            <fieldset class="form-input">
                <label>Название совета:</label>
                <input type="text" name="title" placeholder="Название совета" required>
                @error('title')
                <div><p>{{ $message }}</p></div>
                @enderror

                <label>Описание:</label>
                <input type="text" name="description" placeholder="Описание" required>
                @error('description')
                <div><p>{{ $message }}</p></div>
                @enderror

                <label>Текст совета:</label>
                <textarea name="text" cols="30" rows="10"></textarea>
                @error('text')
                <div><p>{{ $message }}</p></div>
                @enderror
            </fieldset>


            <button type="submit" class="btn-success">Добавить совет</button>
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
        const photoInput = document.getElementById('photoInput');
        const imagePreview = document.getElementById('imagePreview');
        const instructionText = document.getElementById('instructionText');

        photoInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    instructionText.style.display = 'none';
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
