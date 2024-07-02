<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request){
        
        $books = Book::orderBy('created_at', 'DESC');

        if (!empty($request->keyword)) {
            $books->where('title', 'like', '%' . $request->keyword . '%');
        }

        $books = $books->where('status', 1)->paginate(4);

        return view('home.index', ['books' => $books]);
    }

    public function detail($id){

        $book = Book::with(['reviews.user', 'reviews' => function($query) {
            $query->where('status', 1);
        }])->findOrFail($id);
        
        if($book->status == 0){
            abort(404);
        }

        $randomBook = Book::where('status', 1)->where('id', '!=', $id)->inRandomOrder()->limit(3)->get();

        return view('home.detail', ['book' => $book, 'randomBooks' => $randomBook]);
    }

    public function review(Request $request){
       $validator= Validator::make($request->all(), [
           'review' => 'required|min:10',
           'rating' => 'required',
       ]);

     

       $countReview = Review::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->count();
       
       if($countReview > 0){
            session()->flash('error', 'You have already reviewed this book');
            return response()->json(['status' => true]);
       }

       $review = new Review();
       $review->book_id = $request->book_id;
       $review->review = $request->review;
       $review->rating = $request->rating;
       $review->user_id = Auth::user()->id;
       $review->save();

       $book = Book::findOrfail($request->book_id);
       $book->review_count = $book->review_count + 1;
       $book->save();

       session()->flash('success', 'Thank you for your review');
       return response()->json(['status' => true]);
    }
}
