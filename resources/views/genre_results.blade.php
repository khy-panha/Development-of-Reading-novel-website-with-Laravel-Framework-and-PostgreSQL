@extends('layouts.app')

@section('main')
    <div class="container" style="margin-top: 90px">
        <h1 style="width: 100%; height: 40px; color:white; background-color: #df6e6e;">Books in Genre: {{ $genre }}</h1>
        @if($books->isNotEmpty())
            <ul class="book-list"style="display:flex; flex-direction:row;">
                @foreach ($books as $book)
                    <li class="book-item">
                        <div class="benefits-card has-before has-after">
                            <!-- Book Title -->
                            <h3 class="h3 card-title">Title: {{ $book->title }}</h3>

                            <!-- Author -->
                            <div class="h4 text-muted">Author: {{ $book->author }}</div>
                            
                            <!-- Book Image -->
                            <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                                <img src="{{ asset('uploads/books/' . $book->image) }}" alt="Book Image" class="card-image" loading="lazy">
                            </a>

                            <!-- Read More Button -->
                            <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                                <span class="span">Read more</span>
                                <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                            </a>

                            <!-- Rating -->
                            <div class="star-rating d-inline-flex ml-2" title="">
                                <span class="rating-text theme-font theme-yellow">{{ $book->averageRating() }} / 5</span>
                                <div class="star-rating d-inline-flex mx-2" title="">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <div class="front-stars" style="width: {{ $book->averageRating() * 20 }}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews Count -->
                            <span class="theme-font text-muted">({{ $book->comments()->count() }} Reviews)</span>

                            <!-- Views Count -->
                            <p>Total views: {{ $book->views()->count() }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No books found in this genre.</p>
        @endif
    </div>
    
    <!-- FOOTER -->
<footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <p class="copyright">
          &copy; 2025 All right reserved. Made with ❤ by MemeTeam.
        </p>
      </div>
    </div>
  </footer>
  
  <!-- Custom JS -->
  <script src="{{ asset('js/script.js') }}"></script>
  
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  
  </body>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
@endsection

