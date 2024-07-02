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
                        Add Book
                    </div>
                    <div class="card-body">
                        <form action="{{route('account.bookStore')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" name="title" id="title" />
                                @if ($errors->has('title'))
                                    <p class="text-danger">{{$errors->first('title')}}</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" placeholder="Author"  name="author" id="author"/>
                                @if ($errors->has('author'))
                                    <p class="text-danger">{{$errors->first('author')}}</p>
                                @endif
                            </div>
    
                            <div class="mb-3">
                                <label for="author" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5"></textarea>
                            </div>
    
                            <div class="mb-3">
                                <label for="Image" class="form-label">Image</label>
                                <input type="file" class="form-control"  name="image" id="image"/>
                                @if ($errors->has('image'))
                                    <p class="text-danger">{{$errors->first('title')}}</p>
                                @endif
                            </div>
    
                            <div class="mb-3">
                                <label for="author" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                @if ($errors->has('status'))
                                    <p class="text-danger">{{$errors->first('title')}}</p>
                                @endif
                            </div>
                            <button class="btn btn-primary mt-2" >Create</button>        
                        </form>                 
                    </div>
                </div>                
            </div>
        </div>       
    </div>
@endsection