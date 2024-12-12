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
<a href="{{route('myTip')}}" class="back-link">⟵ вернуться назад</a>
<div class="new-recipes" style="padding-top: 50px">
        <form action="{{ route('tips_edit', ['id' => $tip->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="new-recipes-photo">
                <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Фото рецепта" style="max-width: 200px;">

                <label>Загрузить новое фото:</label>
                <input type="file" name="photo">
            </div>
            @error('photo')
            <div><p>{{ $message }}</p></div>
            @enderror


            <fieldset class="form-input">
                <label>Название совета:</label>
                <input type="text" name="title" value="{{ $tip->title }}" placeholder="Название совета" required>
                @error('title')
                <div><p>{{ $message }}</p></div>
                @enderror

                <label>Описание:</label>
                <input type="text" name="description" placeholder="Описание" required value="{{ $tip->description }}">
                @error('description')
                <div><p>{{ $message }}</p></div>
                @enderror

                <label>Текст совета:</label>
                <textarea name="text" cols="30" rows="10">{{ $tip->text }}</textarea>
                @error('text')
                <div><p>{{ $message }}</p></div>
                @enderror
            </fieldset>

            <button type="submit" class="btn-success">Обновить совет</button>
        </form>
    </div>

    <script>

        @if(session('success'))
        alert('{{ session('success') }}');
        @endif

        @if (session('error'))
        alert('{{ session('error') }}');
        @endif

        document.getElementById('add-ingredient-edit').addEventListener('click', function() {
            const container = document.getElementById('ingredients-container-edit');
            const ingredient = document.createElement('div');
            ingredient.classList.add('ingredient');
            ingredient.innerHTML = `
                <input type="text" name="ingredients[]" placeholder="Ингредиент">
                <input type="number" name="ingredient_quantity[]" placeholder="Количество">
                <select name="ingredient_unit[]">
                    <option value="г">г</option>
                    <option value="кг">кг</option>
                    <option value="мл">мл</option>
                    <option value="л">л</option>
                    <option value="шт">шт</option>
                    <option value="чашка">чашка</option>
                    <option value="ст. ложка">ст. ложка</option>
                    <option value="чайная ложка">чайная ложка</option>
                </select>
                <button type="button" class="remove-step"><img class="remove-ingredient" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
            `;
            container.appendChild(ingredient);
        });

        // Удаление ингредиентов
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.ingredient').remove();
            }
        });

        document.getElementById('add-step-edit').addEventListener('click', function() {
            const container = document.getElementById('steps-container-edit');
            const step = document.createElement('div');
            step.classList.add('step');
            step.innerHTML = '<input type="text" name="steps[]" placeholder="Шаг приготовления">' +
                '<button type="button" class="remove-step"><img class="remove-step" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>';
            container.appendChild(step);
        });


        // Удаление шагов
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-step')) {
                e.target.closest('.step').remove();
            }
        });


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
