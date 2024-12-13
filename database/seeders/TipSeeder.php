<?php

namespace Database\Seeders;

use App\Models\Tip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class TipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tips = [
            [
                'title' => 'Как быстро очистить гранат',
                'description' => 'Совет для тех, кто не хочет тратить много времени на чистку граната.',
                'text' => 'Разрежьте гранат пополам, опустите его в миску с водой и аккуратно отделите зерна руками. Вода предотвратит разбрызгивание сока, а кожура всплывет на поверхность.',
                'image_path' => 'images/pomegranate_tip.jpg',
            ],
            [
                'title' => 'Как сохранить свежесть зелени',
                'description' => 'Простой способ продлить срок хранения зелени.',
                'text' => 'Заверните зелень в слегка влажное бумажное полотенце и положите в герметичный пакет. Храните в холодильнике. Это поможет сохранить свежесть до 2 недель.',
                'image_path' => 'images/greenery_tip.jpg',
            ],
            [
                'title' => 'Как избежать слёз при нарезке лука',
                'description' => 'Способ уменьшить раздражение глаз во время готовки.',
                'text' => 'Перед нарезкой лука положите его в морозилку на 10-15 минут. Это замедлит выделение раздражающих веществ, и ваши глаза останутся сухими.',
                'image_path' => 'images/onion_tip.jpg',
            ],
            [
                'title' => 'Как правильно варить яйца',
                'description' => 'Лайфхак для идеальной варки яиц.',
                'text' => 'Для получения мягкого желтка варите яйца 6 минут после закипания, для твёрдого — 10 минут. Сразу же опустите их в холодную воду, чтобы легче очистить скорлупу.',
                'image_path' => 'images/egg_boiling_tip.jpg',
            ],
            [
                'title' => 'Как правильно готовить пасту',
                'description' => 'Совет для любителей итальянской кухни.',
                'text' => 'Используйте 1 литр воды на каждые 100 г пасты. Добавьте соль в воду после её закипания. Не промывайте пасту после варки, чтобы сохранить крахмал и соус лучше держался.',
                'image_path' => 'images/pasta_cooking_tip.jpg',
            ],
        ];

        foreach ($tips as $data) {
            $validated = [
                'title' => $data['title'],
                'image_path' => $data['image_path'],
                'description' => $data['description'],
                'text' => $data['text']
            ];


            Tip::create([
                'user_id' => Auth::id() ?? 8, // Если сид запускается без авторизации, используем ID по умолчанию
                'title' => $validated['title'],
                'description' => $validated['description'],
                'text' => $validated['text'],
                'image_path' => $validated['image_path'], // Здесь предполагается, что photo уже сохранено в нужный путь
            ]);
        }
    }
}