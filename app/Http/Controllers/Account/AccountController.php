<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function myReviewEdit(){
        
        $review = Review::where('user_id', Auth::user()->id)->with('book')->first();
        return view('account.review.myReviewEdit', ['review' => $review]);
    }

    public function updateMyReview($id,Request $request){

        $review = Review::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'staus' => 'required',
            'rating' => 'required',
        ]);

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

        session()->flash('success', 'Review has been updated');

        return redirect()->route('account.review.myReview')->with('success', 'Review has been updated');
    }

    public function myReviewDestroy($id){
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('account.review.myReview')->with('success', 'Review has been deleted');
    }
}