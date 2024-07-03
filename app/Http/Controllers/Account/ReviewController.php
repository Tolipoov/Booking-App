<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function review(Request $request){
        $reviews = Review::with('book', 'user')->orderBy('created_at', 'DESC');

        if(!empty($request->keyword)){
            $reviews = $reviews->where('review', 'like', '%'.$request->keyword.'%');
        }

        $reviews = $reviews->paginate(10);
        return view('review.review', ['reviews' => $reviews]);
    }

    public function reviewEdit($id){
        $review = Review::findOrFail($id);

        return view('review.reviewEdit', ['review' => $review]);

    }

    public function updateReview($id, Request $request){
        $review = Review::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'staus' => 'required' 
        ]);

        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();
        session()->flash('success', 'Review has been updated');

        return redirect()->route('review.review')->with('success', 'Review has been updated');

    }
    public function reviewDestroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
    
        return redirect()->route('review.review')->with('success', 'Review has been deleted');
    }
}
