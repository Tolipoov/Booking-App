@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header  text-white">
                        Welcome, {{Auth::user()->name}}                       
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if (Auth::user()->image != "")
                            <img src="{{asset('/uploads/thumb/' .Auth::user()->image)}}" class="img-fluid rounded-circle" alt="">                            
                            @endif
                        </div>
                        <div class="h5 text-center">
                            <strong>{{Auth::user()->name}}</strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header  text-white">
                        Navigation
                    </div>
                    <div class="card-body sidebar">
                        @include('layouts.sidebar')
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Edit Review
                    </div>
                    <div class="card-body">
                        <form action="{{route('review.updateReview', $review->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="author" class="form-label">Review</label>
                                <textarea name="review" id="description" class="form-control" value="{{$review->review}}" placeholder="review" cols="30" rows="5">{{$review->review}}</textarea>
                                @if ($errors->has('review'))
                                    <p class="text-danger">{{$errors->first('review')}}</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{$review->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$review->status == 0 ? 'selected' : ''}}>Block</option>
                                </select>
                                @if ($errors->has('status'))
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