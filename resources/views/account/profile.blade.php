@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('layouts.sidebar')
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Profile
                </div>
                <div class="card-body">
                  <form action="{{route('account.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{$user->name}}" class="form-control" placeholder="Name" name="name" id="" />
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" value="{{$user->email}}" class="form-control" placeholder="Email"  name="email" id="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if(Auth::user()->image != "")
                            <img src="{{asset('/uploads/thumb/' .Auth::user()->image)}}" class="img-fluid " alt="Luna John">         
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