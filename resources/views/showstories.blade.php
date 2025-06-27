@extends('layouts.app')

@section('main')
  <!-- 
    - primary meta tags
  -->
  <title>ReadNovel - Read More And Make Success</title>
  <meta name="title" content="ReadNovel - Read More And Make Success">
  <meta name="description"
    content="Read More And Make Success The Result Of Perfection. - Get lost in another world, one page at a time. #BookLovers.">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{ asset('css/style_book.css') }}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- 
    - preload image
  -->
  <link rel="preload" as="image" href="./assets/images/hero-banner.png">

</head>

<body>

  <!-- 
    - #HEADER
  -->


  <main>
    <article>
      <!-- Book Reading Page -->
      <section class="section reading" id="reading" aria-label="reading" style="background-color: #f5f0e9; margin-top: 50px;">
        <div class="container">
          <div class="reading-content">
            <h1 class="h1 reading-title">Title: {{ $book->title }} - Part {{ $story->part }}</h1>
            <p id="bookText" class="section-text">
              <p>{!! $story->story !!}</p>

            </p>
            
          </div>
          <div class="container-btn">
            {{-- Previous Button --}}
            @if($prevStory)
                <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $prevStory->id]) }}">
                    <button class="btn">Previous</button>
                </a>
            @else
                <a href="{{ route('book.detail', $book->id) }}">
                    <button class="btn">To Book</button>
                </a>
            @endif
        
            {{-- Next Button --}}
            @if($nextStory)
                <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $nextStory->id]) }}">
                    <button class="btn">Next</button>
                </a>
            @else
                <a href="{{ route('book.detail', $book->id) }}">
                    <button class="btn">?</button>
                </a>
            @endif
        </div>
        
        </div>
      </section>
      <section class="comment">
        @if (Auth::guest())
        <script>
            function showAlert() {
                alert("Please Login First!");
            }
        </script>
        <a href="{{ route('account.login') }}">
          <div class="comment-container">
            <h2>Raise Your Comment and Rating Here...</h2>
            <button onclick="openModal()" class="rating-and-comment">Rate & Comment</button>
          </div>
        </a>
    @else
        @if (Auth::user()->role !== 'auth') {{-- Allow all roles except restricted authors --}}
            <section class="section rating" aria-label="rating">
              <div class="comment-container">
                <h2>Raise Your Comment and Rating Here...</h2>
                <button onclick="openModal()" class="rating-and-comment">Rate & Comment</button>
              </div>
                <div class="comments-list" id="commentSection">
                    @foreach ($book->comments as $comment)
                        <div class="card border-0 shadow-lg my-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between"> 
                                    <h5 class="mb-3">{{ $comment->user->name }}</h5>
                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('d M, Y') }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="star-rating d-inline-flex">
                                        <div class="back-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            @endfor
                                            <div class="front-stars" style="width: {{ $comment->rating * 20 }}%">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="theme-font theme-yellow">{{ $comment->rating }} / 5</span>
                                </div>
                                <div class="content">
                                    <p>{{ $comment->comment }}</p>
                                </div>
    
                                @if (auth()->user()->id == $comment->user_id || auth()->user()->id == $comment->book->user_id)
                                    <form action="{{ route('comment.delete', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-comment">Delete Comment</button>
                
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endif
    
    <div id="commentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <section class="section comment" aria-label="comment">
                <div class="content mt-3">
                    <div class="comment-box">
                        <h1>Rate and Comment</h1>
                        <form method="POST" action="{{ route('book.saveComment') }}" id="ratingForm">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                              
                            <div class="star-rating" style="display: flex; flex-direction: row;">
                                @foreach (range(5, 1) as $i)
                                    <input id="star{{ $i }}" type="radio" name="rating" value="{{ $i }}" required />
                                    <label for="star{{ $i }}">★</label>
                                @endforeach
                            </div>
    
                            <textarea name="comment" id="commentText" rows="4" placeholder="Write a comment..." required></textarea>
                            <button type="submit" class="comment-btn">Submit</button>
                        </form>
    
                       
                    </div>
                </div>
            </section>
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    </div>
      </section>
      <section class="related-books-section">
        <div class="book-list-container">
            <div class="book-list-column">
                <ul class="book-list">
                    <li class="book-list-title">Most Views</li>
                    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
                        @foreach ($relatedBooks as $relatedBook)
                            <li class="book-list-item">
                                <a href="{{ route('book.detail', $relatedBook->id) }}">
                                    <img src="{{ asset('uploads/books/' . $relatedBook->image) }}" class="book-cover">
                                </a>
                                <div class="text">
                                    <h3 class="book-title">{{ $relatedBook->title }}</h3>
                                    <p class="book-author">by {{ $relatedBook->author }}</p>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="book-list-item">No related books found.</li>
                    @endif
                </ul>
            </div>
        </div>
      </section>
    </article>
  </main>

  <!-- 
    - #FOOTER
  -->
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <p class="copyright">
          © 2025 All rights reserved. Made with ❤ by MemeTeam.
        </p>
      </div>
    </div>
  </footer>

  <!-- 
    - custom js link
  -->
  <script src="{{ asset('js/script.js') }}"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>