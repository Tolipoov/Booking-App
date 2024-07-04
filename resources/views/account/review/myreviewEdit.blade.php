@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.sidebar')
            <div class="col-md-9">
                @include('layouts.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Edit Review
                    </div>
                    <div class="card-body">
                        <form action="{{route('account.review.updateMyReview', $review->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="book" class="form-label">Book</label>
                                <div><b>{{$review->book->title}}</b></div>
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Review</label>
                                <textarea name="review" id="description" class="form-control" value="{{$review->review}}" placeholder="review" cols="30" rows="5">{{$review->review}}</textarea>
                                @if ($errors->has('review'))
                                    <p class="text-danger">{{$errors->first('review')}}</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Rating</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1" {{$review->rating == 1 ? 'selected' : ''}}>1</option>
                                    <option value="2" {{$review->rating == 2 ? 'selected' : ''}}>2</option>
                                    <option value="3" {{$review->rating == 3 ? 'selected' : ''}}>3</option>
                                    <option value="4" {{$review->rating == 4 ? 'selected' : ''}}>4</option>
                                    <option value="5" {{$review->rating == 5 ? 'selected' : ''}}>5</option>
                                </select>
                                @if ($errors->has('rating'))
                                    <p class="text-danger">{{$message}}</p>
                                @endif
                            </div>
                            <button class="btn btn-primary mt-2" >Update</button>        
                        </form>                 
                    </div>
                </div>                
            </div>
        </div>       
    </div>
@endsection