@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.sidebar')
            <div class="col-md-9">
                @include('layouts.message')
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