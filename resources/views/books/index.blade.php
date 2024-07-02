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
                            @if(Auth::user()->image != "")
                            <img src="{{asset('/uploads/thumb/' .Auth::user()->image)}}" class="img-fluid rounded-circle" alt="{{Auth::user()->name}}">       
                            @endif                     
                        </div>
                        <div class="h5 text-center">
                            <strong>{{Auth::user()->name}} </strong>
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
                @include('layouts.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Books
                    </div>
                    <div class="card-body pb-0">            
                       <div class="d-flex justify-content-between">
                            <a href="{{route('account.bookCreate')}}" class="btn btn-primary">Add Book</a>         
                                <form action="" method="get">
                                    <div class="d-flex">
                                        <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control me-2" placeholder="Keyword">
                                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        <a href="{{route('account.bookIndex')}}" class="btn btn-warning ms-2">Clear</a>
                                    </div>   
                                </form>
                       </div>
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                                <tbody>
                                    @if ($books->isnotEmpty())
                                        @foreach ($books as $book)
                                            <tr>
                                                <td>{{$book->title}}</td>
                                                <td>{{$book->author}}</td>
                                                <td>3.0 (3 Reviews)</td>
                                                <td>
                                                @if($book->status == 1)
                                                    <span class="text-success">Active</span>    
                                                @else 
                                                    <span class="text-danger">Block</span>
                                                @endif</td>
                                                <td>
                                                    <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                                    <a href="{{route('account.bookEdit', $book->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('account.bookDestroy', $book->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach 
                                    @endif
                                </tbody>
                            </thead>
                        </table>       
                        @if ($books->isNotEmpty())
                            <div class="pagination justify-content-center" >
                                {{ $books->links() }}
                            </div>   
                        @endif        
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>

@endsection    
 