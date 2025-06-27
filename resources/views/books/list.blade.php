@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style_book.css') }}">
<div class="list-container">
    <div class="menu-on-top">
        <div class="p-2 "> <a href="{{ route('account.profile') }}">SUBSCRIBE</a></div>
    @if (in_array(Auth::user()->role, ['author', 'admin']))
        <div class="p-2">
            <a href="{{ route('books.index') }}">DASHBOARD</a>
        </div>
    @endif
        <div class="p-2"> <a href="{{ route('account.menu_account') }}">ACCOUNT</a></div>
    </div>
    <div class="nav-btn">
        <button class="create-button">
             <a href="{{route('books.create')}}" > + Create  &nbsp; Series</a>
        </button>
    </div>
    <div class="card-container">

        @if($books->isNotEmpty())
        @foreach ($books as $book)
        <div class="card-post">
            <a href="{{ route('stories.index', $book->id) }}" ><img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" class="card-image"></a>
            <div class="card-content">
                
                <div class="text2">
                    <h5 class="genr">
                        @if(!empty($book->genre1) || !empty($book->genre2))
                            <div style="display: flex; gap: 10px;">
                                <span class="genre1" style="color: #FF5733;">{{ $book->genre1 }}</span>
                                <span class="genre2" style="color: #33B5FF;">{{ $book->genre2 }}</span>
                            </div>
                        @else
                            No genre
                        @endif
                    </h5>
                    <h2 class="card-title">{{$book->title}}</h2>
                    <p class="text-md-left">
                        <i class="fa-solid fa-bell"></i>  {{ $book->subscriptions()->count() }}  
                        &emsp;  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16" color="red">
                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                          </svg>  {{ $book->likes()->count() }}
                    </p>
                    <p class="text-md-left">
                       Updated {{ $book->updated_at->format('M d, Y')  }}
                    </p>
                 
                    
                    <div class="group-button">
                        <button class="btn-edit">
                            <a href="{{route('books.edit',$book->id)}}"><b>Edit Series</b></a>
                        </button>
                        <button class="btn-edit"><a href="{{route('stories.create',$book->id)}}"><b> + Add Episode</b></a></button>
                    </div>
                </div>
                <div class="top-right-icons">
                    <a href="{{ route('stories.index', $book->id) }}" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{route('books.edit',$book->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a href="" onclick="deleteBook({{$book->id}});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <p>No books found.</p>
    @endif
    
        </div>
        <div class="d-flex ml-4">
            <div class="list-1">
                <ul class="list-group">
                    <li class="list-group-item">Most Views</li>
                    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
                        @foreach ($relatedBooks as $relatedBook)
                            <li class="list-group-item">

                                <a href="{{ route('book.detail', $relatedBook->id) }}">
                                    <img src="{{ asset('uploads/books/' . $relatedBook->image) }}" class="card-img-top">
                                </a>
                                <div class="text">
                                <h3 class="h4 heading">{{ $relatedBook->title }}</h3>
                                <p>by {{ $relatedBook->author }}</p>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">No related books found.</li>
                    @endif
                </ul>
            </div>
           
        </div>
</div>        

    @endsection
    @section('script')
    <script>
        function deleteBook(id){
            if(confirm("Areyou sure you want to delete?")) {
                $.ajax({
                    url:'{{route('books.destroy')}}',
                    type:'delete',
                    data: {id:id},
                    headers:{
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response){
                        window.location.href= '{{route("books.index")}}';
                    }
    
                });
            }
    
        }
    </script>
    @endsection