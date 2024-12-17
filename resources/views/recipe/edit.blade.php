<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование рецепта</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="container" style="padding-top: 20px">
    <a href="{{route('profile', ['id' => Auth::user()->id])}}" class="back-link">⟵ вернуться назад</a>

    <div class="new-recipes" style="padding-top: 50px">
        <form action="{{ route('recipes_edit', ['id' => $recipe->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="new-recipes-photo">
                <img src="{{ asset('storage/' . $recipe->path) }}" alt="Фото рецепта" style="max-width: 200px;">

                <label>Загрузить новое фото:</label>
                <input type="file" name="photo">
            </div>
            @error('photo')
                <div>
                    <p>{{ $message }}</p>
                </div>
            @enderror


            <fieldset class="form-input">
                <label>Название рецепта:</label>
                <input type="text" name="title" value="{{ $recipe->title }}" placeholder="Название рецепта" required>
                @error('title')
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <label>Небольшой текст для превью:</label>
                <input type="text" name="mini_description" placeholder="Мини описание (превью)"
                    value="{{ $recipe->mini_description }}" required>
                @error('mini_description')
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <label>Описание:</label>
                <input type="text" name="description" placeholder="Описание" required
                    value="{{ $recipe->data['description'] ?? 'Описание отсутствует' }}">
                @error('description')
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </fieldset>

            <fieldset class="form-input grid">
                <div class="grid time">
                    <label>Время готовки:</label>
                    <!-- Поле для ввода часов -->
                    <input type="number" name="cooking_hours" min="0"
                        value="{{ old('cooking_hours', explode(':', $recipe->data['cooking_time'])[0]) }}"
                        placeholder="Часы" required>
                    :
                    <!-- Поле для ввода минут -->
                    <input type="number" name="cooking_minutes" min="0" max="59"
                        value="{{ old('cooking_minutes', explode(':', $recipe->data['cooking_time'])[1]) }}"
                        placeholder="Минуты" required>
                    @error('cooking_hours')
                        <div>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                    @error('cooking_minutes')
                        <div>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                <div class="grid">
                    <label>Калорийность:</label>
                    <input type="number" name="calorie" min="0" placeholder="Введите кол-во калорий"
                        value="{{ $recipe->data['calorie'] ?? 'Калорийность не указана' }}" required>
                    @error('calorie')
                        <div>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid">
                    <label>Сложность:</label>
                    <select name="complexity">
                        <option value="Высокая" @if($recipe->complexity == "Высокая") selected @endif>Высокая</option>
                        <option value="Средняя" @if($recipe->complexity == "Средняя") selected @endif>Средняя</option>
                        <option value="Низкая" @if($recipe->complexity == "Низкая") selected @endif>Низкая</option>
                    </select>
                    @error('complexity')
                        <div>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
                <div class="grid">
                    <label>Категория:</label>
                    <select name="category">
                        <option value="Горячее" @if($recipe->category == "Горячее") selected @endif>Горячее</option>
                        <option value="Холодное" @if($recipe->category == "Холодное") selected @endif>Холодное</option>
                        <option value="Десерты" @if($recipe->category == "Десерты") selected @endif>Десерты</option>
                    </select>
                    @error('category')
                        <div>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </fieldset>

            <fieldset class="form-input m-b">
                <label>Ингредиенты:</label>
                <div id="ingredients-container-edit">
                    @foreach($recipe->data['ingredients'] as $ingredient)
                        <div class="ingredient">
                            <input type="text" name="ingredients[]" value="{{ $ingredient['name'] }}"
                                placeholder="Ингредиент">
                            <input type="number" name="ingredient_quantity[]" value="{{ $ingredient['quantity'] ?? '' }}"
                                placeholder="Количество">
                            <select name="ingredient_unit[]">
                                <option value="г" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'г') selected
                                @endif>г</option>
                                <option value="кг" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'кг') selected
                                @endif>кг</option>
                                <option value="мл" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'мл') selected
                                @endif>мл</option>
                                <option value="л" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'л') selected
                                @endif>л</option>
                                <option value="шт" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'шт') selected
                                @endif>шт</option>
                                <option value="чашка" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'чашка')
                                selected @endif>чашка</option>
                                <option value="ст. ложка" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'ст. ложка') selected @endif>ст. ложка</option>
                                <option value="чайная ложка" @if(isset($ingredient['unit']) && $ingredient['unit'] == 'чайная ложка') selected @endif>чайная ложка</option>
                            </select>
                            <button type="button" class="remove-ingredient"><img class="remove-ingredient"
                                    src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
                        </div>
                    @endforeach
                </div>
                <div>
                    <button type="button" id="add-ingredient-edit" class="btn-success flex">
                        Добавить ингредиент
                        <img src="{{asset('images/plus-green.svg')}}" alt="plus">
                    </button>
                </div>
                @error('ingredients')
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </fieldset>


            <fieldset class="form-input m-b">
                <label>Шаги:</label>
                <div id="steps-container-edit">
                    @if(isset($recipe->data['steps']) && count($recipe->data['steps']) > 0)
                        @foreach($recipe->data['steps'] as $step)
                            <div class="step">
                                <input type="text" name="steps[]" value="{{ $step }}" placeholder="Шаг приготовления">
                                <button type="button" class="remove-step"><img class="remove-step"
                                        src="{{asset('images/delete.svg')}}" alt="Удалить"></button>
                            </div>
                        @endforeach
                    @else
                        <p>Шаги не указаны.</p>
                    @endif
                </div>
                <div>
                    <button type="button" id="add-step-edit" class="btn-success flex">
                        Добавить шаг
                        <img src="{{asset('images/plus-green.svg')}}" alt="plus">
                    </button>
                </div>
                @error('steps')
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </fieldset>

            <button type="submit" class="btn-success">Обновить рецепт</button>
        </form>
    </div>

    <script>

        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if (session('error'))
            alert('{{ session('error') }}');
        @endif

        document.getElementById('add-ingredient-edit').addEventListener('click', function () {
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

        document.getElementById('add-step-edit').addEventListener('click', function () {
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