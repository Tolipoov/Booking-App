<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // Share data with all views
         View::composer('*', function ($view) {
            if (Auth::check()) {
                $allMyreviews = Review::where('user_id', Auth::user()->id)->get();
                $allMyreview = Review::all();
                $view->with(['allMyreviews' => $allMyreviews, 'allMyreview' => $allMyreview]);
            }
        });
    }
}
