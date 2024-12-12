<?php

namespace App\Providers;

use App\Models\Recipe;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Recipe::updated(function ($recipe) {
            if ($recipe->isDirty('status') && $recipe->status == 'Одобрен') {
                $recipe->user->updateRoleBasedOnApprovedRecipes();
            }
        });
    }
}
