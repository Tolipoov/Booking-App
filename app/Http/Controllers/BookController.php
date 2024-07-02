<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BookController extends Controller
{
   public function bookIndex(){
    $books = Book::orderBy('created_at', 'DESC');

    if(!empty(request('keyword'))){
        $books = $books->where('title', 'like', '%'.request('keyword').'%');
    }

    $books = $books->paginate(10);
    return view('books.index', ['books'=>$books]);
   }

   public function bookCreate(){
    return view('books.create');
   }

   public function bookStore(Request $request){
    $rules=[
        'title' => 'required|string|min:5',
        'author' => 'required|string|min:3',
        'status' => 'required',
    ];
    if(!empty($request->image)){
        $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
    }

    $validator = Validator::make($request->all(), $rules);
    
    if ($validator->fails()) {
        return redirect()->route('account.bookCreate')->withInput()->withErrors($validator);
    }

    $book = new Book();
    $book->title = $request->title;
    $book->description = $request->description;
    $book->author = $request->author;
    $book->status = $request->status;
    $book->save();

    if(!empty($request->image)){

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $image->move(public_path('uploads/books'), $filename);
        
        $book->image=$filename;
        $book->save();

        $manage_image = new ImageManager(Driver::class );
        $img = $manage_image->read(public_path('uploads/books/'.$filename));

        $img->resize(990);
        $img->save(public_path('uploads/books/thumb/'.$filename));

    }
    return redirect()->route('account.bookIndex')->with('success', 'Book added successfully.');
    }

    public function bookEdit($id){
        $book = Book::findOrFail($id);
        return view('books.edit', ['book'=>$book]);
    }

    public function bookUpdate($id , Request $request){
        $book = Book::findOrFail($id);
        
        $rules=[
            'title' => 'required|string|min:5',
            'author' => 'required|string|min:3',
            'status' => 'required',
        ];
        if(!empty($request->image)){
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        
        $validator = Validator::make($request->all(), $rules);

        $book->title = $request->title; 
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->save();

        if(!empty($request->image)){

            File::delete(public_path('uploads/books/'.$book->image));
            File::delete(public_path('uploads/books/thumb/'.$book->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $image->move(public_path('uploads/books'), $filename);

            $book->image=$filename;
            $book->save();

            $manage_image = new ImageManager(Driver::class );
            $img = $manage_image->read(public_path('uploads/books/'.$filename));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/'.$filename));

        }
        return redirect()->route('account.bookIndex')->with('success', 'Book updated successfully.');
    }

    public function bookDestroy($id){
        $book = Book::findOrFail($id);
        if ($book) {
            $book->delete();
            return redirect()->route('account.bookIndex')->with('success', 'Book deleted successfully.');
        }
        return redirect()->route('account.bookIndex')->with('error', 'Book not found.');
    }
  
}
