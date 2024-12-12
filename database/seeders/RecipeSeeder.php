<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Оливье',
                'photo' => 'images/olivier.jpg',
                'description' => 'Оливье — традиционный русский салат с овощами, мясом и майонезом.',
                'mini_description' => 'Классический новогодний салат.',
                'category' => 'Холодное',
                'complexity' => 'Средняя',
                'calorie' => 200,
                'cooking_hours' => 1,
                'cooking_minutes' => 0,
                'ingredients' => [
                    'Картофель', 'Морковь', 'Яйца', 'Колбаса', 'Горошек консервированный', 'Майонез'
                ],
                'ingredient_quantity' => [3, 2, 4, 300, 1, 150],
                'ingredient_unit' => ['шт', 'шт', 'шт', 'г', 'банка', 'г'],
                'steps' => [
                    'Отварите картофель и морковь до готовности.',
                    'Отварите яйца вкрутую.',
                    'Порежьте все ингредиенты кубиками.',
                    'Добавьте горошек и майонез, тщательно перемешайте.'
                ]
            ],
            [
                'title' => 'Селедка под шубой',
                'photo' => 'images/shuba.jpg',
                'description' => 'Селедка под шубой — это слоеный салат с рыбой и овощами.',
                'mini_description' => 'Популярное праздничное блюдо.',
                'category' => 'Холодное',
                'complexity' => 'Средняя',
                'calorie' => 250,
                'cooking_hours' => 1,
                'cooking_minutes' => 30,
                'ingredients' => [
                    'Сельдь', 'Картофель', 'Морковь', 'Свекла', 'Лук', 'Майонез'
                ],
                'ingredient_quantity' => [1, 3, 2, 2, 1, 200],
                'ingredient_unit' => ['шт', 'шт', 'шт', 'шт', 'шт', 'г'],
                'steps' => [
                    'Отварите картофель, морковь и свеклу до готовности.',
                    'Порежьте сельдь и лук мелкими кусочками.',
                    'Натрите отварные овощи на терке.',
                    'Выкладывайте слоями: картофель, сельдь, лук, морковь, свеклу, смазывая каждый слой майонезом.',
                    'Охладите перед подачей.'
                ]
            ],
            [
                'title' => 'Холодец',
                'photo' => 'images/kholodec.jpg',
                'description' => 'Холодец — традиционное мясное желе, приготовленное из бульона.',
                'mini_description' => 'Классика русского застолья.',
                'category' => 'Холодное',
                'complexity' => 'Высокая',
                'calorie' => 180,
                'cooking_hours' => 6,
                'cooking_minutes' => 0,
                'ingredients' => [
                    'Говядина', 'Свинина', 'Морковь', 'Лук', 'Чеснок', 'Желатин'
                ],
                'ingredient_quantity' => [1, 1, 2, 1, 3, 10],
                'ingredient_unit' => ['кг', 'кг', 'шт', 'шт', 'зубчик', 'г'],
                'steps' => [
                    'Промойте мясо и отварите в большом количестве воды.',
                    'Добавьте лук, морковь и специи.',
                    'Долго варите на медленном огне.',
                    'Извлеките мясо, нарежьте и разложите в формы.',
                    'Процедите бульон, добавьте чеснок и желатин.',
                    'Залейте мясо бульоном и охладите.'
                ]
            ],
            [
                'title' => 'Наполеон',
                'photo' => 'images/napoleon.jpg',
                'description' => 'Наполеон — слоеный торт с заварным кремом.',
                'mini_description' => 'Популярный праздничный десерт.',
                'category' => 'Десерты',
                'complexity' => 'Высокая',
                'calorie' => 350,
                'cooking_hours' => 2,
                'cooking_minutes' => 0,
                'ingredients' => [
                    'Мука', 'Масло сливочное', 'Молоко', 'Яйца', 'Сахар', 'Ваниль'
                ],
                'ingredient_quantity' => [500, 200, 500, 4, 300, 1],
                'ingredient_unit' => ['г', 'г', 'мл', 'шт', 'г', 'ч. ложка'],
                'steps' => [
                    'Замесите тесто из муки и масла.',
                    'Раскатайте и испеките коржи.',
                    'Приготовьте заварной крем из молока, яиц, сахара и ванили.',
                    'Промажьте коржи кремом, соберите торт.',
                    'Охладите торт перед подачей.'
                ]
            ],
            [
                'title' => 'Кулич',
                'photo' => 'images/kulich.jpg',
                'description' => 'Кулич — традиционная сладкая выпечка.',
                'mini_description' => 'Идеально для праздников.',
                'category' => 'Десерты',
                'complexity' => 'Средняя',
                'calorie' => 290,
                'cooking_hours' => 4,
                'cooking_minutes' => 0,
                'ingredients' => [
                    'Мука', 'Молоко', 'Сахар', 'Яйца', 'Изюм', 'Дрожжи'
                ],
                'ingredient_quantity' => [600, 250, 200, 3, 100, 20],
                'ingredient_unit' => ['г', 'мл', 'г', 'шт', 'г', 'г'],
                'steps' => [
                    'Замесите тесто на молоке и дрожжах.',
                    'Добавьте изюм и дайте тесту подняться.',
                    'Выложите тесто в формы и дайте еще раз подняться.',
                    'Выпекайте до готовности.'
                ]
            ],
            [
                'title' => 'Медовик',
                'photo' => 'images/medovik.jpg',
                'description' => 'Медовик — мягкий торт с медовыми коржами и сметанным кремом.',
                'mini_description' => 'Классический русский десерт.',
                'category' => 'Десерты',
                'complexity' => 'Средняя',
                'calorie' => 300,
                'cooking_hours' => 3,
                'cooking_minutes' => 0,
                'ingredients' => [
                    'Мука', 'Мед', 'Сахар', 'Яйца', 'Сметана', 'Сода'
                ],
                'ingredient_quantity' => [500, 100, 200, 3, 400, 1],
                'ingredient_unit' => ['г', 'г', 'г', 'шт', 'г', 'ч. ложка'],
                'steps' => [
                    'Смешайте мед, сахар, яйца и соду, прогрейте на водяной бане.',
                    'Добавьте муку, замесите тесто, испеките коржи.',
                    'Промажьте коржи сметанным кремом.',
                    'Охладите перед подачей.'
                ]
            ],
            [
                'title' => 'Тирамису',
                'photo' => 'images/tiramisu.jpg',
                'description' => 'Тирамису — итальянский десерт с сыром маскарпоне и печеньем савоярди.',
                'mini_description' => 'Идеальный десерт.',
                'category' => 'Десерты',
                'complexity' => 'Высокая',
                'calorie' => 400,
                'cooking_hours' => 1,
                'cooking_minutes' => 30,
                'ingredients' => [
                    'Маскарпоне', 'Савоярди', 'Яйца', 'Сахар', 'Кофе', 'Какао'
                ],
                'ingredient_quantity' => [500, 200, 3, 100, 300, 20],
                'ingredient_unit' => ['г', 'г', 'шт', 'г', 'мл', 'г'],
                'steps' => [
                    'Приготовьте крем из маскарпоне, яичных желтков и сахара.',
                    'Смочите савоярди в кофе.',
                    'Выложите слоями печенье и крем.',
                    'Посыпьте какао и охладите.'
                ]
            ],
            [
                'title' => 'Курица в сливочном соусе с грибами',
                'photo' => 'images/chicken_mushroom_sauce.jpg',
                'description' => 'Нежное куриное филе в сливочном соусе с шампиньонами, идеально сочетается с гарниром.',
                'mini_description' => 'Сочное и нежное блюдо.',
                'category' => 'Горячее',
                'complexity' => 'Средняя',
                'calorie' => 350,
                'cooking_hours' => 1,
                'cooking_minutes' => 15,
                'ingredients' => [
                    'Куриное филе', 'Шампиньоны', 'Лук', 'Сливки 20%', 'Растительное масло'
                ],
                'ingredient_quantity' => [500, 200, 1, 200, 2],
                'ingredient_unit' => ['г', 'г', 'шт', 'мл', 'ст. ложка'],
                'steps' => [
                    'Нарезать куриное филе и обжарить до румяной корочки.',
                    'Добавить нарезанные грибы и лук, обжарить.',
                    'Залить сливками, тушить 20 минут.'
                ]
            ],
            [
                'title' => 'Паста Болоньезе',
                'photo' => 'images/pasta_bolognese.jpg',
                'description' => 'Классическое итальянское блюдо из макарон с мясным соусом.',
                'mini_description' => 'Любимое блюдо из Италии.',
                'category' => 'Горячее',
                'complexity' => 'Средняя',
                'calorie' => 420,
                'cooking_hours' => 0,
                'cooking_minutes' => 45,
                'ingredients' => [
                    'Спагетти', 'Говяжий фарш', 'Томатная паста', 'Лук', 'Чеснок'
                ],
                'ingredient_quantity' => [250, 300, 150, 1, 2],
                'ingredient_unit' => ['г', 'г', 'мл', 'шт', 'зубчик'],
                'steps' => [
                    'Обжарить фарш с луком и чесноком.',
                    'Добавить томатную пасту, тушить 20 минут.',
                    'Отварить спагетти и смешать с соусом.'
                ]
            ],
            [
                'title' => 'Греческий салат',
                'photo' => 'images/greek_salad.jpg',
                'description' => 'Легкий салат с фетой, овощами и оливковым маслом.',
                'mini_description' => 'Легкость и свежесть.',
                'category' => 'Холодное',
                'complexity' => 'Низкая',
                'calorie' => 150,
                'cooking_hours' => 0,
                'cooking_minutes' => 15,
                'ingredients' => [
                    'Помидоры', 'Огурцы', 'Фета', 'Маслины', 'Оливковое масло'
                ],
                'ingredient_quantity' => [3, 2, 150, 50, 2],
                'ingredient_unit' => ['шт', 'шт', 'г', 'г', 'ст. ложка'],
                'steps' => [
                    'Нарезать овощи и фету.',
                    'Смешать все ингредиенты, добавить масло.'
                ]
            ]

        ];


        foreach ($recipes as $data) {
            $validated = [
                'title' => $data['title'],
                'photo' => $data['photo'],
                'description' => $data['description'],
                'mini_description' => $data['mini_description'],
                'category' => $data['category'],
                'complexity' => $data['complexity'],
                'calorie' => $data['calorie'],
                'cooking_hours' => $data['cooking_hours'],
                'cooking_minutes' => $data['cooking_minutes'],
                'ingredients' => $data['ingredients'],
                'ingredient_quantity' => $data['ingredient_quantity'],
                'ingredient_unit' => $data['ingredient_unit'],
                'steps' => $data['steps']
            ];


            Recipe::create([
                'user_id' => Auth::id() ?? 8, // Если сид запускается без авторизации, используем ID по умолчанию
                'title' => $validated['title'],
                'mini_description' => $validated['mini_description'],
                'data' => [
                    'description' => $validated['description'],
                    'cooking_time' => $validated['cooking_hours'] . ':' . str_pad($validated['cooking_minutes'], 2, '0', STR_PAD_LEFT),
                    'calorie' => $validated['calorie'],
                    'ingredients' => array_map(function ($ingredient, $index) use ($validated) {
                        return [
                            'name' => trim($ingredient),
                            'quantity' => trim($validated['ingredient_quantity'][$index]),
                            'unit' => trim($validated['ingredient_unit'][$index]),
                        ];
                    }, $validated['ingredients'], array_keys($validated['ingredients'])),
                    'steps' => $validated['steps'],
                ],
                'category' => $validated['category'],
                'complexity' => $validated['complexity'],
                'path' => $validated['photo'], // Здесь предполагается, что photo уже сохранено в нужный путь
            ]);
        }
    }
}
