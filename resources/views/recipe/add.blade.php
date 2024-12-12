<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление рецепта</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="container" style="padding-top: 20px">
<a href="{{route('profile', ['id' => Auth::user()->id])}}" class="back-link">⟵ вернуться назад</a>
<div class="new-recipes" style="padding-top: 50px">
    <form action="{{ route('recipes_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="new-recipes-photo">
                <input id="photoInput" type="file" name="photo" accept="image/jpeg, image/jpg, image/png" hidden>
                <img id="imagePreview" src="{{asset('images/new-photo.svg')}}" alt="new-photo" style="max-width: 100%; height: auto; display: block;">
                <div id="instructionText">
                    <p >Выберите изображение на вашем устройстве или перетащите его в эту область.</p>
                    <span class="dropzone_button__wcBP7" onclick="document.getElementById('photoInput').click();">
                            Загрузить обложку рецепта
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
            <label>Название рецепта:</label>
            <input type="text" name="title" placeholder="Название рецепта" required>
            @error('title')
            <div><p>{{ $message }}</p></div>
            @enderror

            <label>Небольшой текст для превью:</label>
            <input type="text" name="mini_description" placeholder="Мини описание (превью)" required>
            @error('mini_description')
            <div><p>{{ $message }}</p></div>
            @enderror

            <label>Описание:</label>
            <input type="text" name="description" placeholder="Описание" required>
            @error('description')
            <div><p>{{ $message }}</p></div>
            @enderror
        </fieldset>

        <fieldset class="form-input grid">
            <div class="grid time">
                <label>Время готовки:</label>
                <input type="number" name="cooking_hours" min="0" max="24" placeholder="Часы" required>
                :
                <input type="number" name="cooking_minutes" min="0" max="59" placeholder="Минуты" required>
                @error('cooking_hours')
                <div><p>{{ $message }}</p></div>
                @enderror
                @error('cooking_minutes')
                <div><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="grid">
                <label>Калорийность:</label>
                <input type="number" name="calorie" min="0" placeholder="Введите кол-во калорий" required>
                @error('calorie')
                <div><p>{{ $message }}</p></div>
                @enderror
            </div>

            <div class="grid">
                <label>Сложность:</label>
                <select name="complexity">
                    <option value="Высокая">Высокая</option>
                    <option value="Средняя">Средняя</option>
                    <option value="Низкая">Низкая</option>
                </select>
                @error('complexity')
                <div><p>{{ $message }}</p></div>
                @enderror
            </div>
            <div class="grid">
                <label>Категория:</label>
                <select name="category">
                    <option value="Горячее">Горячее</option>
                    <option value="Холодное">Холодное</option>
                    <option value="Десерты">Десерт</option>
                </select>
                @error('category')
                <div><p>{{ $message }}</p></div>
                @enderror
            </div>
        </fieldset>

        <fieldset class="form-input m-b">
            <label>Ингредиенты:</label>
            <div id="ingredients-container">
                <div class="ingredient-item">
                    <input type="text" name="ingredients[]" placeholder="Название" required>
                    <input type="number" name="ingredient_quantity[]" min="0" placeholder="Количество" required>
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
                    <button type="button" class="remove-ingredient"><img class="remove-ingredient" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
                </div>
            </div>
            <div>
                <button type="button" id="add-ingredient" class="btn-success flex">
                    Добавить ингредиент
                    <img src="{{asset('images/plus-green.svg')}}" alt="plus">
                </button>
            </div>
            @error('ingredients')
            <div><p>{{ $message }}</p></div>
            @enderror
        </fieldset>


        <fieldset class="form-input m-b">
            <label>Шаги:</label>
            <div id="steps-container">
                <div class="step-item">
                    <input type="text" name="steps[]" placeholder="Шаг приготовления" required>
                    <button type="button" class="remove-step"><img class="remove-step" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
                </div>
            </div>
            <div>
                <button type="button" id="add-step" class="btn-success flex">
                    Добавить шаг
                    <img src="{{asset('images/plus-green.svg')}}" alt="plus">
                </button>
            </div>
            @error('steps')
            <div><p>{{ $message }}</p></div>
            @enderror
        </fieldset>

        <button type="submit" class="btn-success">Добавить рецепт</button>
    </form>
</div>

<script>

    @if(session('success'))
    alert('{{ session('success') }}');
    @endif

    @if (session('error'))
    alert('{{ session('error') }}');
    @endif


    // Динамическое добавление ингредиентов
    document.getElementById('add-ingredient').addEventListener('click', () => {
        const container = document.getElementById('ingredients-container');
        const count = container.children.length;
        const ingredientHtml = `
            <div class="ingredient-item">
                <input type="text" name="ingredients[${count}]" placeholder="Название" required>
                <input type="number" name="ingredient_quantity[${count}]" min="0" placeholder="Количество" required>
                <select name="ingredient_unit[${count}]">
                    <option value="г">г</option>
                        <option value="кг">кг</option>
                        <option value="мл">мл</option>
                        <option value="л">л</option>
                        <option value="шт">шт</option>
                        <option value="чашка">чашка</option>
                        <option value="ст. ложка">ст. ложка</option>
                        <option value="чайная ложка">чайная ложка</option>
                </select>
                <button type="button" class="remove-ingredient"><img class="remove-ingredient" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
            </div>`;
        container.insertAdjacentHTML('beforeend', ingredientHtml);
    });

    // Удаление ингредиентов
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-ingredient')) {
            e.target.closest('.ingredient-item').remove();
        }
    });

    // Динамическое добавление шагов
    document.getElementById('add-step').addEventListener('click', () => {
        const container = document.getElementById('steps-container');
        const count = container.children.length;
        const stepHtml = `
            <div class="step-item">
                <input type="text" name="steps[]" placeholder="Шаг приготовления" required>
                <button type="button" class="remove-step"><img class="remove-step" src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
            </div>`;
        container.insertAdjacentHTML('beforeend', stepHtml);
    });

    // Удаление шагов
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-step')) {
            e.target.closest('.step-item').remove();
        }
    });


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
