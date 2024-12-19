<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index($status)
    {
        $query = Recipe::query();

        // Если статус не 'all', фильтруем рецепты по статусу
        if ($status != 'all') {
            $query->where('status', $status);
        }

        // Пагинация с 6 рецептами на странице
        $recipes = $query->paginate(6);

        return view('admin.index', compact('recipes', 'status'));
    }

    public function statusApproved($id)
    {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->status == "На рассмотрении") {
            $recipe->status = "Одобрен";
            $recipe->save();
        }
        return redirect()->back();
    }

    public function statusRejected($id)
    {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->status == "На рассмотрении") {
            $recipe->status = "Отклонен";
            $recipe->save();
        }
        return redirect()->back();
    }

    public function search(Request $request, $status = 'all')
    {
        $search = $request->input('search');
        $query = Recipe::query();

        // Если статус не 'all', фильтруем рецепты по статусу
        if ($status != 'all') {
            $query->where('status', $status);
        }

        // Если есть запрос на поиск
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('mini_description', 'like', "%{$search}%");
            });
        }

        // Пагинация с 6 рецептами на странице
        $recipes = $query->paginate(4);

        return view('admin.index', compact('recipes', 'status'));
    }
}
