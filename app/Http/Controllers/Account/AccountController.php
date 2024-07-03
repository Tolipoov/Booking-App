<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    public function register()
    {
        return view('account.register');
    }

    public function myReview(Request $request)
    {
        $reviews = Review::with('book')->where('user_id', Auth::user()->id);
        $reviews = $reviews->orderBy('created_at', 'DESC');
        
        if(!empty($request->keyword)){
                $reviews = $reviews->where('review', 'like', '%'.$request->keyword.'%');
            }

        $reviews = $reviews->paginate(10);
      

        return view('account.review.myReview', ['reviews' => $reviews]);

    }
}