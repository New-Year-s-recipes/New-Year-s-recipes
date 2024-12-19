<?php

namespace App\Http\Controllers;

use App\Models\CouncilEvaluation;
use Illuminate\Http\Request;
use App\Models\Tip;
use Illuminate\Support\Facades\Auth;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::all();
        return view('tips.index', compact('tips'));
    }

    public function myTip()
    {
        $tips = Tip::all()->where('user_id', Auth::id());
        return view('tips.myTips', compact('tips'));
    }

    public function addTipShow()
    {
        return view('tips.add');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $path = $request->file('photo')->store('images', 'public');

        $tip = Tip::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'text' => $validated['text'],
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Рецепт успешно записан!');
    }


    public function destroy($id) {
        $tip = Tip::findOrFail($id);
        $tip->delete();

        return redirect()->back()->with('success', 'Рецепт удален');
    }

    public function editShow($id) {
        $tip = Tip::findOrFail($id);

        return view('tips.edit', compact('tip'));
    }

    public function edit(Request $request, $id)
    {
        $validated = $this->validateData($request, true);

        // Поиск рецепта по ID
        $tip = Tip::findOrFail($id);

        // Обновление полей рецепта
        $tip->title = $validated['title'];
        $tip->description = $validated['description'];
        $tip->text = $validated['text'];

        // Если есть новое изображение, сохраняем его
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $tip->image_path = $path;
        }

        $tip->save();

        return redirect(route('homePage'))->with('success', 'Рецепт успешно обновлён!');
    }

    public function more($id)
    {
        $tip = Tip::findOrFail($id);

        return view('tips.show', compact('tip'));
    }

    private function validateData(Request $request, $isUpdate = false)
    {
        $photoRule = $isUpdate ? 'image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'photo' => $photoRule,
            'text' => 'required|string',
        ]);

        return $validated;
    }

    public function show($id)
    {
        $tip = Tip::findOrFail($id);
        $user = Auth::user(); // Получаем текущего пользователя

        $userRating = null;
        if ($user) {
            // Проверяем, оставил ли пользователь оценку
            $userRating = CouncilEvaluation::where('users_id', $user->id)
                ->where('tips_id', $id)
                ->first();
        }

        return view('tips.show', compact('tip', 'userRating'));
    }




    public function council_evaluation_add(Request $request, $id)
    {
        // Получаем текущего авторизованного пользователя
        $user = Auth::user();

        // Проверка на наличие значения в поле "rating"
        $rating = $request->input('rating');
        if (!$rating) {
            return redirect()->back()->with('error', 'Выберите оценку');
        }

        // Проверяем, оставил ли пользователь уже оценку для данного совета
        $existingRating = CouncilEvaluation::where('users_id', $user->id)
                                        ->where('tips_id', $id)
                                        ->first();

        // Если оценка существует, обновляем её
        if ($existingRating) {
            $existingRating->rating = $rating;
            $existingRating->save();
            return redirect()->route('tips.show', ['id' => $id])->with('success', 'Оценка успешно обновлена');
        }

        // Если оценки нет, создаем новую
        CouncilEvaluation::create([
            'users_id' => $user->id,  // ID текущего пользователя
            'rating' => $rating,       // Оценка, полученная из формы
            'tips_id' => $id,          // ID совета из URL
        ]);

        return redirect()->route('tips.show', ['id' => $id])->with('success', 'Оценка выдана');
    }

}
