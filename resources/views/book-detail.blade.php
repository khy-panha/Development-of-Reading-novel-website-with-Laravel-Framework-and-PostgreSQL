@extends('layouts.app')

@section('main')

  {{-- Include only necessary head elements in the layout, not here --}}
<link rel="stylesheet" href="{{ asset('css\book\style_book.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="{{ asset('assets/images/hero-banner.png') }}">

  
  <main>
    <article>

      <!-- HERO SECTION -->
      <section class="section hero" id="home" aria-label="home">
        {{-- <div class="container"> --}}
          @include('layouts.message')
         
          <div class="hero-content">
            <div class="left-content">
                <p class="section-subtitle">Author Name: {{ $book->author }}</p>
                <h1 class="h1 hero-title">Title: {{ $book->title }}</h1>
                <p>Total views: {{ $viewCount }}</p>
                {{-- <div class="star-rating d-inline-flex ml-2" title="">
                  <span class="rating-text theme-font theme-yellow">{{ $book->averageRating() }} / 5</span>
                  <div class="star-rating d-inline-flex mx-2" title="">
                      <div class="back-stars ">
                          <i class="fa fa-star " aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>

                          <div class="front-stars" style="width: {{ $book->averageRating() * 20}}%">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                          </div>
                      </div>
                  </div>
                  <span class="theme-font text-muted">({{ $book->comments()->count()}} Review)</span>
                </div> --}}
    
                <div class="button-group">
                  <!-- Like Button (Heart Icon) -->
                  <form action="{{ route('book.like', $book->id) }}" method="POST">
                      @csrf
                      <button type="submit" style="font-size: 24px; background: none; border: none;">
                          @if(auth()->user() && $book->likes()->where('user_id', auth()->id())->exists())
                              <!-- Filled Heart if liked -->
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"></path>
                              </svg>
                          @else
                              <!-- Outline Heart if not liked -->
                              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="red" stroke-width="2" class="bi bi-heart" viewBox="0 0 16 16">
                                  <path d="M8 2.748l-.717-.737C5.6.281 2.514 3.36 8 8.682c5.486-5.322 2.4-8.4.717-6.671L8 2.748z"></path>
                              </svg>
                          @endif
                      </button>
                  </form>
                  <div class="count">{{ $book->likes()->count() }}</div>
              
                  <!-- Subscribe Button (Bell Icon) -->
                  <form action="{{ route('book.subscribe', $book->id) }}" method="POST">
                      @csrf
                      <button type="submit" style="background: none; border: none;">
                          @if(auth()->user() && $book->subscriptions()->where('user_id', auth()->id())->exists())
                              <!-- Filled Bell -->
                              <i class="fa-solid fa-bell" style="font-size: 24px; color: blue;"></i>
                          @else
                              <!-- Outline Bell -->
                              <i class="fa-regular fa-bell" style="font-size: 24px; color: blue;"></i>
                          @endif
                      </button>
                  </form>
                  <div class="count">{{ $book->subscriptions()->count() }}</div>
              </div>
              
            
            </div>
            <div class="hero-banner has-before">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" width="431" height="596" class="w-100">

            </div>
          </div>

        {{-- </div> --}}
      </section>
      <section class="section description" aria-label="description">
        <div class="content mt-3">
          <h2>Description:</h2>
          <p> <div class="rich-description">{!! $book->description !!}</div></p>
        </div>
      </section>
      <!-- CHAPTER PREVIEW -->
      <section class="section preview" aria-label="preview">
        <div class="container">
      
          <p class="section-subtitle">Chapter Preview</p>
      
          <h2 class="h2 section-title has-underline">
            Read some chapter free
            <span class="span has-before"></span>
          </h2>
      
          <ul class="tab-list">
            @foreach($stories as $index => $story)
              <li>
                <div class="tab-card" data-tab-card>
                  <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $story->id]) }}">
                  <h3 class="h3 tab-text">Part {{ $index + 1 }}</h3>
                 
                    <button class="w-100">Part {{ $index + 1 }}</button>
                  </a>
                </div>
              </li>
            @endforeach
          </ul>
        </div>

      </section>
      
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
                                <div class="profile-name" style="display: flex; flex-direction: row;">
                                   @if (Auth::user()->image)
                                  <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="profile-pic" alt="Profile Picture" style="width: 60px; height: 60px; border-radius: 50%;">
                                  @endif
                                  <h5 class="mb-3" style=" padding-left: 30px; padding-top: 20px; font-size: medium;">{{ $comment->user->name }}</h5>
                                </div>
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
                                      <span class="theme-font theme-yellow">{{ $comment->rating }} / 5</span>
                                  </div>
                                 
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
                            
                          <div class="star-rating large" style="display: flex; flex-direction: row; font-size: 2.5rem;">
                              @foreach (range(5, 1) as $i)
                              <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                              <label for="star{{ $i }}" title="{{ $i }} stars">★</label>
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

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">

      <div class="footer-top">
        <a href="{{ url('/') }}" class="logo">ReadNovel</a>

        {{-- <ul class="footer-list">
          <li><a href="{{ url('/') }}" class="footer-link">Home</a></li>
        </ul> --}}
      </div>

      <div class="footer-bottom">
        <p class="copyright">
          &copy; 2025 All right reserved. Made with ❤ by MemeTeam.
        </p>
      </div>

    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('ratingForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault(); // prevent normal submit

                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    });

                    if (response.ok) {
                        // Reset form
                        form.reset();
                        closeModal(); // close modal
                        
                    } else {
                      
                    }
                } catch (error) {
                    console.error("Error submitting comment:", error);
                }
            });
        });

        function openModal() {
            document.getElementById("commentModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("commentModal").style.display = "none";
        }

        // Optional: close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById("commentModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    
@endsection
