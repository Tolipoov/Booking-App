<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Review;

class ShareReviewData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $allMyreviews = Review::where('user_id', Auth::user()->id)->get();
            View::share('allMyreviews', $allMyreviews);
        }

        return $next($request);
    }
}