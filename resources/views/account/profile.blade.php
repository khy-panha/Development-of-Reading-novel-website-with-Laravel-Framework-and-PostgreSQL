    @extends('layouts.app')

    @section('main')
    <link rel="stylesheet" href="{{ asset('css/style_acc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <div class="account-container">
        <div class="menu-on-top">
            <div class="p-2-subscribe">
                <a href="{{ route('account.profile') }}">SUBSCRIBE</a>
            </div>
            <div class="p-3-dashbord">
            @if (in_array(Auth::user()->role, ['author', 'admin']))
                    <a href="{{ route('books.index') }}">DASHBOARD</a>
            @endif
            </div>

            <div class="p-4-account"><a href="{{ route('account.menu_account') }}">ACCOUNT</a></div>
        </div>
        <div class="profile-container">
            <!-- Display User Info -->
            <div class="user-info">
                @if(Auth::user()->role === 'author')
                    <h5 class="welcome-message">Welcome, Author {{ $user->name }}</h5>
                @else
                    <h5 class="welcome-message">Welcome, {{ $user->name }}</h5>
                @endif
            </div>
            
        
            <!-- Display Book Info and Subscriptions -->
            <div class="book-info">
                @if(Auth::user()->role == 'user')
                    <!-- User: Display their own subscriptions -->
                    @if($totalSubscriptions)
                        <h5>Subscriptions: <span class="subscriptions-count">{{ $totalSubscriptions }}</span></h5>
                        
                        
                    @else
                        <h5>Have No Subscription</h5>
                    @endif
                @elseif(Auth::user()->role == 'author')
                    <!-- Author: Display the count of subscriptions for their own books -->
                    @if($totalSubscriptions)
                        <h5>Your Books Subscribed: <span class="subscriptions-count">{{ $totalSubscriptions }}</span></h5>
                    @else
                        <h5>No Subscriptions on Your Books</h5>
                    @endif
                @elseif(Auth::user()->role == 'admin')
                    <!-- Admin: Display the total subscriptions for all books -->
                    <h5>Total Subscriptions: <span class="subscriptions-count">{{ $totalSubscriptions }}</span></h5>
                @endif
            </div>

        </div>
                    <h1>You Subscribed Other Authors.</h1>
        <div class="card-container">
            
            @foreach ($books as $book)
                @if(Auth::user()->subscriptions->contains('book_id', $book->id))
                
                    <div class="card-post">
                        <a href="{{ route('book.detail', $book->id) }}" class="btn-link" style="text-decoration: none;color:rgb(117, 109, 109);">
                            <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" class="card-image">
                      
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
                                    <h2 class="card-title">{{ $book->title }}</h2>
                                    <p class="text-md-left">
                                        <i class="fa-solid fa-bell"></i> {{ $book->subscriptions()->count() }}  
                                        &emsp;  
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16" color="red">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg> {{ $book->likes()->count() }}
                                    </p>
                                    <p class="text-md-left">
                                        Updated {{ $book->updated_at->format('M d, Y') }}
                                    </p>

                                    
                                </div>

                                
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

     @if(Auth::user()->author_status === 'none')
    <form method="POST" action="{{ route('account.requestAuthor') }}">
        @csrf
        <button type="submit" class="btn btn-primary mt-4">Become an Author</button>
    </form>
@elseif(Auth::user()->author_status === 'pending')
    <p class="text-warning">Your request to become an author is pending admin approval.</p>
@elseif(Auth::user()->author_status === 'approved')
    <p class="text-success">You are now an author!</p>
@endif


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

@endsection
