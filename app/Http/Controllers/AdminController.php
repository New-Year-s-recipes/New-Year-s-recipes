<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $recipes = Recipe::all();

        return view('admin.index', compact('recipes'));
    }

    public function status($status) {
        $recipes = Recipe::all()->where('status', $status);

        return view('admin.recipesByStatus', compact('recipes'));
    }

    public function statusApproved($id) {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->status == "На рассмотрении") {
            $recipe->status = "Одобрен";
            $recipe->save();
        }
        return redirect()->back();
    }

    public function statusRejected($id) {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->status == "На рассмотрении") {
            $recipe->status = "Отклонен";
            $recipe->save();
        }
        return redirect()->back();
    }
}
